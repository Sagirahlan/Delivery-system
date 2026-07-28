<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\NABRollService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Handle the Web Checkout ResponseUrl callback from NABRoll.
     */
    public function callback(Request $request, NABRollService $nabrollService)
    {
        $transactionRef = $request->query('TransactionRef');

        $order = $transactionRef ? Order::where('payment_ref', $transactionRef)->first() : null;

        if (!$order) {
            $targetRoute = auth()->check() ? 'orders.history' : 'home';
            return redirect()->route($targetRoute)->withErrors(['payment' => 'Order not found for this payment reference.']);
        }

        if ($order->payment_status === 'pending') {
            $verification = $nabrollService->verifyPayment($transactionRef, $order->tracking_number, $order->amount);

            if ($verification && isset($verification['status']) && $verification['status'] === 'SUCCESSFUL') {
                $order->update(['payment_status' => 'paid']);
                return redirect()->route('tracking.map', ['trackingNumber' => $order->tracking_number])
                    ->with('success', 'Payment successful! Your tracking number is ' . $order->tracking_number);
            } else {
                $order->update(['payment_status' => 'failed']);
                $targetRoute = auth()->check() ? 'orders.history' : 'tracking.map';
                $params = auth()->check() ? [] : ['trackingNumber' => $order->tracking_number];
                return redirect()->route($targetRoute, $params)
                    ->withErrors(['payment' => 'Payment failed or pending for order #' . $order->tracking_number . '. You can retry your payment below.']);
            }
        }

        if ($order->payment_status === 'paid') {
            return redirect()->route('tracking.map', ['trackingNumber' => $order->tracking_number])
                ->with('success', 'Payment was successful! Your tracking number is ' . $order->tracking_number);
        }

        // Handle failed or pending status
        $targetRoute = auth()->check() ? 'orders.history' : 'tracking.map';
        $params = auth()->check() ? [] : ['trackingNumber' => $order->tracking_number];
        return redirect()->route($targetRoute, $params)
            ->withErrors(['payment' => 'Payment failed or pending for order #' . $order->tracking_number . '. You can retry your payment below.']);
    }

    /**
     * Retry payment for an order via NABRoll.
     */
    public function retryPayment($trackingNumber, NABRollService $nabrollService)
    {
        $order = Order::where('tracking_number', $trackingNumber)->firstOrFail();

        if ($order->payment_status === 'paid') {
            return redirect()->route('tracking.map', ['trackingNumber' => $order->tracking_number])
                ->with('info', 'This order has already been paid for.');
        }

        $paymentData = $nabrollService->initiatePayment($order);

        if ($paymentData && !empty($paymentData['PaymentUrl'])) {
            $order->update(['payment_ref' => $paymentData['TransactionRef']]);
            return redirect()->away($paymentData['PaymentUrl']);
        }

        return back()->withErrors(['payment' => 'Could not initiate NABRoll payment gateway. Please try again.']);
    }

    /**
     * Handle webhook server-to-server notifications.
     */
    public function webhook(Request $request, NABRollService $nabrollService)
    {
        $payload = $request->all();
        Log::info('NABRoll Webhook Payload: ', $payload);

        $transactionRef = $request->input('TransactionRef');

        if (!$transactionRef) {
            return response()->json(['status' => 'error', 'message' => 'Missing TransactionRef'], 400);
        }

        $order = Order::where('payment_ref', $transactionRef)->first();
        if (!$order) {
            return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
        }

        if ($order->payment_status === 'pending') {
            $verification = $nabrollService->verifyPayment($transactionRef, $order->tracking_number, $order->amount);

            if ($verification && isset($verification['status']) && $verification['status'] === 'SUCCESSFUL') {
                $order->update(['payment_status' => 'paid']);
            } else {
                $order->update(['payment_status' => 'failed']);
            }
        }

        return response()->json(['status' => 'success']);
    }
}
