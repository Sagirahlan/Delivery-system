<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderHistoryController extends Controller
{
    /**
     * Display order history for the authenticated user.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->roles()->first()?->name ?? 'customer';

        $query = Order::query();

        // Scope based on role
        if ($role === 'customer') {
            $query->where('user_id', $user->id);
        } elseif ($role === 'agent') {
            $query->where('agent_id', $user->id);
        }
        // Admin sees all orders (no where clause)

        // Filters
        $status = $request->input('status');
        $search = $request->input('search');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tracking_number', 'like', "%{$search}%")
                    ->orWhere('package_description', 'like', "%{$search}%")
                    ->orWhere('pickup_address', 'like', "%{$search}%")
                    ->orWhere('delivery_address', 'like', "%{$search}%");
            });
        }

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $orders = $query->with(['user', 'agent'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Stats
        $statsQuery = Order::query();
        if ($role === 'customer') {
            $statsQuery->where('user_id', $user->id);
        } elseif ($role === 'agent') {
            $statsQuery->where('agent_id', $user->id);
        }

        $stats = [
            'total' => (clone $statsQuery)->count(),
            'pending' => (clone $statsQuery)->where('status', 'pending')->count(),
            'transit' => (clone $statsQuery)->where('status', 'transit')->count(),
            'delivered' => (clone $statsQuery)->where('status', 'delivered')->count(),
            'cancelled' => (clone $statsQuery)->where('status', 'cancelled')->count(),
            'total_revenue' => (clone $statsQuery)->where('status', 'delivered')->sum('amount'),
        ];

        return view('orders.history', compact('orders', 'stats', 'role', 'status', 'search', 'dateFrom', 'dateTo'));
    }

    /**
     * Show a single order detail page.
     */
    public function show($trackingNumber)
    {
        $order = Order::with([
            'user',
            'agent',
            'locations' => function ($q) {
                $q->latestFirst()->limit(50);
            }
        ])->where('tracking_number', $trackingNumber)->firstOrFail();

        $user = Auth::user();
        $role = $user->roles()->first()?->name ?? 'customer';

        // Authorization
        if ($role === 'customer' && $order->user_id !== $user->id) {
            abort(403);
        }
        if ($role === 'agent' && $order->agent_id !== $user->id) {
            abort(403);
        }

        return view('orders.history-detail', compact('order', 'role'));
    }

    /**
     * Update order status from history page.
     */
    public function updateStatus(Request $request, $trackingNumber)
    {
        $request->validate([
            'status' => 'required|in:pending,transit,delivered,cancelled',
        ]);

        $order = Order::where('tracking_number', $trackingNumber)->firstOrFail();
        $user = Auth::user();
        $role = $user->roles()->first()?->name ?? 'customer';

        if ($role === 'customer' || ($role === 'agent' && $order->agent_id !== $user->id)) {
            abort(403);
        }

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        if ($request->status === 'transit' && !$order->estimated_arrival) {
            $order->update(['estimated_arrival' => now()->addMinutes(20)]);
        }

        return redirect()->back()->with('success', "Order {$trackingNumber} updated from '{$oldStatus}' to '{$request->status}'.");
    }
}
