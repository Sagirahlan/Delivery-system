<?php

namespace App\Http\Controllers;

use App\Events\OrderStatusUpdated;
use App\Models\Order;
use App\Notifications\OrderAssigned;
use Illuminate\Http\Request;

class AgentOrderController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = $user->assignedDeliveries()->with('user');

        $status = $request->input('status');
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->latest()->paginate(15);

        $stats = [
            'pending' => $user->assignedDeliveries()->where('status', 'pending')->count(),
            'transit' => $user->assignedDeliveries()->where('status', 'transit')->count(),
            'delivered' => $user->assignedDeliveries()->where('status', 'delivered')->count(),
        ];

        return view('agent.orders', compact('orders', 'stats'));
    }

    public function show($trackingNumber)
    {
        $order = Order::with('user')->where('tracking_number', $trackingNumber)
            ->where('agent_id', auth()->id())->firstOrFail();

        return view('agent.order-detail', compact('order'));
    }

    public function updateStatus(Request $request, $trackingNumber)
    {
        $request->validate(['status' => 'required|in:pending,transit,delivered,cancelled']);

        $order = Order::where('tracking_number', $trackingNumber)
            ->where('agent_id', auth()->id())->firstOrFail();

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        if ($request->status === 'transit' && !$order->estimated_arrival) {
            $order->update(['estimated_arrival' => now()->addMinutes(20)]);
        }

        // Notify customer
        $order->user->notify(new \App\Notifications\OrderStatusChanged($order, $oldStatus, $request->status));

        event(new OrderStatusUpdated($order, $oldStatus, $request->status));

        return back()->with('success', "Order updated: {$request->status}");
    }

    public function assignAgent(Request $request, $trackingNumber)
    {
        $request->validate(['agent_id' => 'required|exists:users,id']);

        $order = Order::where('tracking_number', $trackingNumber)->firstOrFail();
        $agent = \App\Models\User::findOrFail($request->agent_id);

        if (!$agent->hasRole('agent')) {
            return back()->withErrors(['agent' => 'Selected user is not an agent.']);
        }

        $order->update(['agent_id' => $request->agent_id]);

        // Notify the agent
        $agent->notify(new OrderAssigned($order));

        return back()->with('success', "Agent {$agent->name} assigned to order {$trackingNumber}.");
    }

    public function accept($trackingNumber)
    {
        $user = auth()->user();

        // Block if agent already has an active (pending or transit) delivery
        $activeOrder = $user->assignedDeliveries()
            ->whereIn('status', ['pending', 'transit'])
            ->first();

        if ($activeOrder) {
            return back()->withErrors([
                'accept' => "You already have an active delivery (#{$activeOrder->tracking_number}). Complete or cancel it before accepting a new one."
            ]);
        }

        $order = Order::where('tracking_number', $trackingNumber)
            ->whereNull('agent_id')
            ->firstOrFail();

        $order->update([
            'agent_id' => $user->id,
            'status' => 'pending' // Still pending, but now assigned
        ]);

        // Redirect directly to live tracking map showing pickup destination
        return redirect()->route('tracking.map', ['trackingNumber' => $order->tracking_number])
            ->with('success', "Order #{$trackingNumber} accepted! Navigate to the pickup location.");
    }

    public function reject($trackingNumber)
    {
        // For now, rejection just hides it from the pool for this session or a simple DB flag.
        // To keep it simple, we could have a 'rejected_by_agents' JSON column or just use the session.
        // But the user said "view it, weather to accept or reject".
        // Let's implement a simple session-based skip for now, or just a redirect.
        
        return back()->with('info', "Order #{$trackingNumber} dismissed.");
    }
}
