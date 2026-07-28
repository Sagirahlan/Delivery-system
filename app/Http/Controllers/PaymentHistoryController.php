<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentHistoryController extends Controller
{
    /**
     * Customer: Show their own payment history.
     */
    public function customerIndex(Request $request)
    {
        $user = auth()->user();

        $query = $user->orders()->whereNotNull('payment_ref');

        // Filter by payment status
        if ($request->filled('payment_status') && $request->payment_status !== 'all') {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $payments = $query->latest()->paginate(15);

        // Stats
        $totalPaid = $user->orders()->where('payment_status', 'paid')->sum('amount');
        $totalPending = $user->orders()->where('payment_status', 'pending')->sum('amount');
        $totalFailed = $user->orders()->where('payment_status', 'failed')->sum('amount');
        $totalTransactions = $user->orders()->whereNotNull('payment_ref')->count();

        // Monthly spending chart (last 6 months, paid only)
        $monthlyPayments = $user->orders()
            ->where('payment_status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%b') as month"),
                DB::raw('SUM(amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('month')
            ->orderBy(DB::raw("MIN(created_at)"))
            ->pluck('total', 'month')
            ->toArray();

        return view('payments.customer-history', compact(
            'payments', 'totalPaid', 'totalPending', 'totalFailed',
            'totalTransactions', 'monthlyPayments'
        ));
    }

    /**
     * Admin: Show all payments across the platform.
     */
    public function adminIndex(Request $request)
    {
        $query = Order::with(['user', 'agent'])->whereNotNull('payment_ref');

        // Filter by payment status
        if ($request->filled('payment_status') && $request->payment_status !== 'all') {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by tracking number, customer name or payment ref
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tracking_number', 'like', "%{$search}%")
                  ->orWhere('payment_ref', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $payments = $query->latest()->paginate(20);

        // Global stats
        $totalRevenue = Order::where('payment_status', 'paid')->sum('amount');
        $totalPending = Order::where('payment_status', 'pending')->sum('amount');
        $totalFailed = Order::where('payment_status', 'failed')->sum('amount');
        $totalTransactions = Order::whereNotNull('payment_ref')->count();
        $paidCount = Order::where('payment_status', 'paid')->count();
        $pendingCount = Order::where('payment_status', 'pending')->count();
        $failedCount = Order::where('payment_status', 'failed')->count();

        // Payment status distribution for chart
        $statusDistribution = [
            'Paid' => $paidCount,
            'Pending' => $pendingCount,
            'Failed' => $failedCount,
        ];

        // Monthly revenue chart (last 6 months)
        $monthlyRevenue = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%b') as month"),
                DB::raw('SUM(amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('month')
            ->orderBy(DB::raw("MIN(created_at)"))
            ->pluck('total', 'month')
            ->toArray();

        return view('payments.admin-payments', compact(
            'payments', 'totalRevenue', 'totalPending', 'totalFailed',
            'totalTransactions', 'paidCount', 'pendingCount', 'failedCount',
            'statusDistribution', 'monthlyRevenue'
        ));
    }
}
