<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Store a new order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pickup_address' => 'required|string|max:500',
            'pickup_contact' => 'nullable|string|max:255',
            'pickup_phone' => 'nullable|string|max:20',
            'delivery_address' => 'required|string|max:500',
            'delivery_contact' => 'nullable|string|max:255',
            'delivery_phone' => 'nullable|string|max:20',
            'package_desc' => 'required|string|max:500',
            'package_size' => 'required|in:small,medium,large',
            'pickup_lat' => 'nullable|numeric|between:-90,90',
            'pickup_lng' => 'nullable|numeric|between:-180,180',
            'delivery_lat' => 'nullable|numeric|between:-90,90',
            'delivery_lng' => 'nullable|numeric|between:-180,180',
        ]);

        $prices = ['small' => 500, 'medium' => 1000, 'large' => 2000];
        $base = $prices[$request->package_size];
        $fragile = $request->has('is_fragile') ? 200 : 0;
        $total = $base + $fragile + 100; // 100 service fee

        $user = auth()->user();
        $orderData = [
            'tracking_number' => 'SD-' . rand(10000, 99999),
            'package_description' => $request->package_desc,
            'package_size' => $request->package_size,
            'is_fragile' => $request->has('is_fragile'),
            'pickup_address' => $request->pickup_address,
            'pickup_contact' => $request->pickup_contact,
            'pickup_phone' => $request->pickup_phone,
            'delivery_address' => $request->delivery_address,
            'delivery_contact' => $request->delivery_contact,
            'delivery_phone' => $request->delivery_phone,
            'amount' => $total,
            'status' => 'pending',
            'payment_status' => 'pending',
            'pickup_lat' => $request->pickup_lat ?? 12.0022,
            'pickup_lng' => $request->pickup_lng ?? 8.5920,
            'delivery_lat' => $request->delivery_lat ?? 11.9960,
            'delivery_lng' => $request->delivery_lng ?? 8.5450,
        ];

        if (!$user) {
            session(['pending_order' => $orderData]);
            return redirect()->route('login')->with('info', 'Please log in or sign up to proceed with your NABRoll payment for order #' . $orderData['tracking_number'] . '.');
        }

        $order = $user->orders()->create($orderData);

        // Initiate payment via NABRoll
        $nabrollService = app(\App\Services\NABRollService::class);
        $paymentData = $nabrollService->initiatePayment($order);

        if ($paymentData && !empty($paymentData['PaymentUrl'])) {
            $order->update(['payment_ref' => $paymentData['TransactionRef']]);
            return redirect()->away($paymentData['PaymentUrl']);
        }

        return redirect()->route('dashboard.customer')
            ->with('success', 'Order placed successfully! Tracking: ' . $order->tracking_number . '. Payment failed to initiate.');
    }

    /**
     * Process pending order stored in session after user logs in or registers.
     */
    public static function processPendingOrder($user)
    {
        if (session()->has('pending_order')) {
            $orderData = session()->pull('pending_order');
            $order = $user->orders()->create($orderData);

            $nabrollService = app(\App\Services\NABRollService::class);
            $paymentData = $nabrollService->initiatePayment($order);

            if ($paymentData && !empty($paymentData['PaymentUrl'])) {
                $order->update(['payment_ref' => $paymentData['TransactionRef']]);
                return redirect()->away($paymentData['PaymentUrl']);
            }

            return redirect()->route('dashboard.customer')
                ->with('success', 'Order placed successfully! Tracking #: ' . $order->tracking_number);
        }

        return null;
    }

    /**
     * Cancel a pending order (customer only).
     */
    public function cancel($trackingNumber)
    {
        $order = Order::where('tracking_number', $trackingNumber)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (!in_array($order->status, ['pending'])) {
            return back()->withErrors(['cancel' => 'Only pending orders can be cancelled.']);
        }

        $oldStatus = $order->status;
        $order->update(['status' => 'cancelled']);

        // Notify the agent if assigned
        if ($order->agent) {
            $order->agent->notify(new \App\Notifications\OrderCancelled($order));
        }

        event(new \App\Events\OrderStatusUpdated($order, $oldStatus, 'cancelled'));

        return back()->with('success', "Order {$trackingNumber} has been cancelled.");
    }

    /**
     * Redirect to tracking page for active order.
     */
    public function track()
    {
        $activeOrder = auth()->user()->orders()
            ->whereIn('status', ['pending', 'transit'])
            ->latest()
            ->first();

        if ($activeOrder) {
            return redirect()->route('tracking.map', ['trackingNumber' => $activeOrder->tracking_number]);
        }

        return redirect()->route('dashboard.customer')
            ->with('info', 'No active orders to track.');
    }
}
