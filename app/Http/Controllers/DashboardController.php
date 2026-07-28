<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function admin()
    {
        // Stats
        $totalOrders = Order::count();
        $activeAgents = User::role('agent')->where('is_available', true)->count();
        $totalAgents = User::role('agent')->count();
        $revenue = Order::where('status', 'delivered')->sum('amount');
        $pendingOrders = Order::where('status', 'pending')->count();
        $recentOrders = Order::with(['user', 'agent'])->latest()->take(10)->get();
        $agents = User::role('agent')->withCount([
            'assignedDeliveries as active_deliveries' => fn($q) => $q->whereIn('status', ['pending', 'transit']),
        ])->get();

        // Chart Data: Orders by Status
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')->pluck('count', 'status')->toArray();

        // Chart Data: Monthly Orders (last 6 months)
        $monthlyOrders = Order::select(
            DB::raw("DATE_FORMAT(created_at, '%b') as month"),
            DB::raw('count(*) as count')
        )->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')->orderBy('month')->pluck('count', 'month')->toArray();

        // Chart Data: Revenue by Month (last 6 months)
        $monthlyRevenue = Order::select(
            DB::raw("DATE_FORMAT(created_at, '%b') as month"),
            DB::raw('sum(amount) as total')
        )->where('status', 'delivered')->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')->orderBy('month')->pluck('total', 'month')->toArray();

        // Chart Data: Orders by Package Size
        $ordersBySize = Order::select('package_size', DB::raw('count(*) as count'))
            ->groupBy('package_size')->pluck('count', 'package_size')->toArray();

        // Chart Data: Agent Deliveries
        $agentDeliveries = User::role('agent')->select('users.id', 'users.name')
            ->withCount(['assignedDeliveries as deliveries' => fn($q) => $q->where('status', 'delivered')])
            ->having('deliveries', '>', 0)
            ->orderByDesc('deliveries')->limit(8)->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'activeAgents',
            'totalAgents',
            'revenue',
            'pendingOrders',
            'recentOrders',
            'agents',
            'ordersByStatus',
            'monthlyOrders',
            'monthlyRevenue',
            'ordersBySize',
            'agentDeliveries'
        ));
    }

    public function customer()
    {
        $user = auth()->user();
        $orders = $user->orders()->with('agent')->latest()->paginate(10);
        $activeOrder = $user->orders()->whereIn('status', ['pending', 'transit'])->latest()->first();
        $totalSpent = $user->orders()->where('status', 'delivered')->sum('amount');
        $stats = [
            'total' => $user->orders()->count(),
            'pending' => $user->orders()->where('status', 'pending')->count(),
            'transit' => $user->orders()->where('status', 'transit')->count(),
            'delivered' => $user->orders()->where('status', 'delivered')->count(),
            'cancelled' => $user->orders()->where('status', 'cancelled')->count(),
        ];

        // Chart: Monthly spending (last 6 months)
        $monthlySpending = Order::where('user_id', $user->id)
            ->where('status', 'delivered')
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%b') as month"),
                DB::raw('sum(amount) as total')
            )->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')->orderBy('month')->pluck('total', 'month')->toArray();

        // Chart: Orders by Status
        $ordersByStatus = $user->orders()
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')->pluck('count', 'status')->toArray();

        // Chart: Monthly order count
        $monthlyOrderCount = $user->orders()
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%b') as month"),
                DB::raw('count(*) as count')
            )->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')->orderBy('month')->pluck('count', 'month')->toArray();

        return view('customer.dashboard', compact(
            'orders',
            'activeOrder',
            'totalSpent',
            'stats',
            'monthlySpending',
            'ordersByStatus',
            'monthlyOrderCount'
        ));
    }

    public function agent()
    {
        $user = auth()->user();
        $activeOrder = $user->assignedDeliveries()->whereIn('status', ['pending', 'transit'])->latest()->first();
        $todayDeliveries = $user->assignedDeliveries()->whereDate('created_at', today())->get();
        $todayEarnings = $todayDeliveries->where('status', 'delivered')->sum('amount');
        $todayCount = $todayDeliveries->where('status', 'delivered')->count();
        $totalDeliveries = $user->assignedDeliveries()->where('status', 'delivered')->count();
        $totalEarnings = $user->assignedDeliveries()->where('status', 'delivered')->sum('amount');
        $avgPerOrder = $totalDeliveries > 0 ? round($totalEarnings / $totalDeliveries, 0) : 0;
        $successRate = $user->assignedDeliveries()->count() > 0
            ? round(($totalDeliveries / $user->assignedDeliveries()->count()) * 100, 1) : 0;

        // Chart: Daily deliveries this week
        $weeklyDeliveries = $user->assignedDeliveries()
            ->where('status', 'delivered')
            ->where('created_at', '>=', Carbon::now()->startOfWeek())
            ->select(DB::raw("DATE_FORMAT(created_at, '%a') as day"), DB::raw('count(*) as count'))
            ->groupBy('day')->orderBy('day')->pluck('count', 'day')->toArray();

        // Chart: Earnings by month (last 6 months)
        $monthlyEarnings = $user->assignedDeliveries()
            ->where('status', 'delivered')
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%b') as month"),
                DB::raw('sum(amount) as total')
            )->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')->orderBy('month')->pluck('total', 'month')->toArray();

        // Chart: Order status distribution
        $statusDistribution = $user->assignedDeliveries()
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')->pluck('count', 'status')->toArray();

        // Available unassigned orders (for agents to claim)
        $availableOrders = Order::whereNull('agent_id')
            ->whereIn('status', ['pending', 'confirmed'])
            ->latest()
            ->limit(5)
            ->get();

        return view('agent.dashboard', compact(
            'activeOrder',
            'todayDeliveries',
            'todayEarnings',
            'todayCount',
            'totalDeliveries',
            'totalEarnings',
            'avgPerOrder',
            'successRate',
            'weeklyDeliveries',
            'monthlyEarnings',
            'statusDistribution',
            'availableOrders'
        ));
    }
}
