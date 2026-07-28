<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WalletController extends Controller
{
    public function index()
    {
        // ── Main wallet balance ───────────────────────────────
        $totalBalance     = Order::where('payment_status', 'paid')->sum('amount');
        $pendingBalance   = Order::where('payment_status', 'pending')->sum('amount');
        $failedAmount     = Order::where('payment_status', 'failed')->sum('amount');

        // ── Today's figures ───────────────────────────────────
        $todayIncome      = Order::where('payment_status', 'paid')
                                ->whereDate('created_at', today())->sum('amount');
        $todayTransactions = Order::where('payment_status', 'paid')
                                ->whereDate('created_at', today())->count();

        // ── This week ─────────────────────────────────────────
        $weekIncome       = Order::where('payment_status', 'paid')
                                ->where('created_at', '>=', Carbon::now()->startOfWeek())->sum('amount');
        $weekTransactions = Order::where('payment_status', 'paid')
                                ->where('created_at', '>=', Carbon::now()->startOfWeek())->count();

        // ── This month ────────────────────────────────────────
        $monthIncome      = Order::where('payment_status', 'paid')
                                ->whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)->sum('amount');
        $monthTransactions = Order::where('payment_status', 'paid')
                                ->whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)->count();

        // ── All-time stats ────────────────────────────────────
        $totalPaidOrders     = Order::where('payment_status', 'paid')->count();
        $totalPendingOrders  = Order::where('payment_status', 'pending')->count();
        $totalFailedOrders   = Order::where('payment_status', 'failed')->count();
        $totalCustomers      = User::role('customer')->count();
        $averageOrderValue   = $totalPaidOrders > 0 ? round($totalBalance / $totalPaidOrders, 2) : 0;

        // ── Daily income for the last 14 days (sparkline) ─────
        $dailyIncome = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subDays(14))
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%b %d') as day"),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('day')
            ->orderBy(DB::raw("MIN(created_at)"))
            ->pluck('total', 'day')
            ->toArray();

        // ── Monthly income (last 6 months) for bar chart ──────
        $monthlyIncome = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%b') as month"),
                DB::raw('SUM(amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('month')
            ->orderBy(DB::raw("MIN(created_at)"))
            ->get()
            ->keyBy('month');

        $monthlyIncomeChart = $monthlyIncome->pluck('total', 'month')->toArray();
        $monthlyCountChart  = $monthlyIncome->pluck('count', 'month')->toArray();

        // ── Payment method distribution ───────────────────────
        $paymentStatusDist = [
            'Paid'    => $totalPaidOrders,
            'Pending' => $totalPendingOrders,
            'Failed'  => $totalFailedOrders,
        ];

        // ── Recent paid transactions (latest 15) ──────────────
        $recentTransactions = Order::with('user')
            ->where('payment_status', 'paid')
            ->latest()
            ->take(15)
            ->get();

        // ── Top paying customers ──────────────────────────────
        $topCustomers = User::role('customer')
            ->select('users.id', 'users.name', 'users.email')
            ->withCount(['orders as paid_orders' => fn($q) => $q->where('payment_status', 'paid')])
            ->withSum(['orders as total_spent' => fn($q) => $q->where('payment_status', 'paid')], 'amount')
            ->having('paid_orders', '>', 0)
            ->orderByDesc('total_spent')
            ->limit(5)
            ->get();

        return view('admin.wallet', compact(
            'totalBalance', 'pendingBalance', 'failedAmount',
            'todayIncome', 'todayTransactions',
            'weekIncome', 'weekTransactions',
            'monthIncome', 'monthTransactions',
            'totalPaidOrders', 'totalPendingOrders', 'totalFailedOrders',
            'totalCustomers', 'averageOrderValue',
            'dailyIncome', 'monthlyIncomeChart', 'monthlyCountChart',
            'paymentStatusDist', 'recentTransactions', 'topCustomers'
        ));
    }
}
