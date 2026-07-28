<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryAssignmentController extends Controller
{
    /**
     * Show unassigned orders and available agents.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Unassigned orders (agent_id is null), excluding cancelled
        $ordersQuery = Order::query()
            ->whereNull('agent_id')
            ->where('status', Order::STATUS_PENDING)
            ->with('user')
            ->latest();

        if ($search) {
            $ordersQuery->where(function ($q) use ($search) {
                $q->where('tracking_number', 'like', "%{$search}%")
                    ->orWhere('package_description', 'like', "%{$search}%")
                    ->orWhere('delivery_address', 'like', "%{$search}%");
            });
        }

        $unassignedOrders = $ordersQuery->paginate(10, ['*'], 'orders_page');

        // Available agents (is_available = true, role = agent)
        $agentsQuery = User::role('agent')
            ->where('is_available', true)
            ->withCount(['assignedDeliveries' => function ($q) {
                $q->whereIn('status', [Order::STATUS_PENDING, Order::STATUS_TRANSIT]);
            }])
            ->orderBy('performance_score', 'desc');

        if ($search) {
            $agentsQuery->where('name', 'like', "%{$search}%");
        }

        $availableAgents = $agentsQuery->paginate(10, ['*'], 'agents_page');

        return view('admin.assignment.index', compact('unassignedOrders', 'availableAgents', 'search'));
    }

    /**
     * Assign an order to an agent.
     */
    public function assign(Request $request, $orderId)
    {
        $request->validate([
            'agent_id' => 'required|exists:users,id',
        ]);

        $order = Order::findOrFail($orderId);

        if ($order->agent_id !== null) {
            return back()->withErrors(['order' => 'Order is already assigned to an agent.']);
        }

        $agent = User::findOrFail($request->agent_id);

        // Verify agent is available
        if (!$agent->is_available) {
            return back()->withErrors(['agent' => 'Selected agent is not available.']);
        }

        // Verify agent has the agent role
        if (!$agent->hasRole('agent')) {
            return back()->withErrors(['agent' => 'Selected user is not a delivery agent.']);
        }

        DB::transaction(function () use ($order, $agent) {
            $order->update([
                'agent_id' => $agent->id,
                'status' => Order::STATUS_TRANSIT,
            ]);
        });

        return back()->with('success', "Order {$order->tracking_number} assigned to {$agent->name}.");
    }

    /**
     * Reassign an order from one agent to another.
     */
    public function reassign(Request $request, $orderId)
    {
        $request->validate([
            'agent_id' => 'required|exists:users,id',
        ]);

        $order = Order::findOrFail($orderId);

        if ($order->agent_id === null) {
            return back()->withErrors(['order' => 'Order is not currently assigned. Use the assignment page instead.']);
        }

        $newAgent = User::findOrFail($request->agent_id);

        // Verify new agent is available
        if (!$newAgent->is_available) {
            return back()->withErrors(['agent' => 'Selected agent is not available.']);
        }

        // Verify new agent has the agent role
        if (!$newAgent->hasRole('agent')) {
            return back()->withErrors(['agent' => 'Selected user is not a delivery agent.']);
        }

        $previousAgent = User::find($order->agent_id);

        DB::transaction(function () use ($order, $newAgent) {
            $order->update([
                'agent_id' => $newAgent->id,
            ]);
        });

        $previousAgentName = $previousAgent ? $previousAgent->name : 'Unknown';

        return back()->with('success', "Order {$order->tracking_number} reassigned from {$previousAgentName} to {$newAgent->name}.");
    }
}
