<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'agent']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('tracking_number', 'like', "%{$s}%")
                  ->orWhere('package_description', 'like', "%{$s}%")
                  ->orWhere('pickup_address', 'like', "%{$s}%")
                  ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$s}%"));
            });
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(20);

        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'transit' => Order::where('status', 'transit')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'revenue' => Order::where('status', 'delivered')->sum('amount'),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function show($trackingNumber)
    {
        $order = Order::with(['user', 'agent', 'locations' => fn($q) => $q->latestFirst()->limit(50)])
            ->where('tracking_number', $trackingNumber)->firstOrFail();

        return view('admin.orders.show', compact('order'));
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $agents = User::role('agent')->where('status', 'active')->get();
        return view('admin.orders.edit', compact('order', 'agents'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate(['status' => 'required|in:pending,transit,delivered,cancelled']);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        if ($request->status === 'transit' && !$order->estimated_arrival) {
            $order->update(['estimated_arrival' => now()->addMinutes(20)]);
        }

        // Notify customer
        $order->user->notify(new \App\Notifications\OrderStatusChanged($order, $oldStatus, $request->status));
        event(new \App\Events\OrderStatusUpdated($order, $oldStatus, $request->status));

        return back()->with('success', "Order {$order->tracking_number} updated to {$request->status}.");
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted.');
    }
}
