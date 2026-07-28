<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Show reports page with options.
     */
    public function index()
    {
        // Quick stats
        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', Order::STATUS_DELIVERED)->sum('amount'),
            'total_agents' => User::role('agent')->count(),
            'total_customers' => User::role('customer')->count(),
        ];

        return view('admin.reports.index', compact('stats'));
    }

    /**
     * Export orders to CSV (filterable by date range, status).
     */
    public function exportOrders(Request $request)
    {
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $status = $request->input('status');

        $query = Order::query()->with(['user', 'agent']);

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        return $this->streamCsv(
            $orders,
            'orders_export_' . now()->format('Y-m-d') . '.csv',
            ['Tracking Number', 'Customer', 'Agent', 'Package', 'Size', 'Fragile', 'Pickup Address', 'Delivery Address', 'Amount', 'Status', 'Created At'],
            function ($order) {
                return [
                    $order->tracking_number,
                    $order->user->name ?? 'N/A',
                    $order->agent->name ?? 'Unassigned',
                    $order->package_description ?? '',
                    $order->package_size ?? '',
                    $order->is_fragile ? 'Yes' : 'No',
                    $order->pickup_address ?? '',
                    $order->delivery_address ?? '',
                    $order->amount,
                    $order->status,
                    $order->created_at->format('Y-m-d H:i:s'),
                ];
            }
        );
    }

    /**
     * Export revenue report CSV.
     */
    public function exportRevenue(Request $request)
    {
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $query = Order::query()->where('status', Order::STATUS_DELIVERED);

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Group by date for daily revenue
        $dailyRevenue = $query
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as order_count'), DB::raw('SUM(amount) as total_amount'))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        return $this->streamCsv(
            $dailyRevenue,
            'revenue_report_' . now()->format('Y-m-d') . '.csv',
            ['Date', 'Order Count', 'Total Revenue (NGN)'],
            function ($row) {
                return [
                    $row->date,
                    $row->order_count,
                    number_format($row->total_amount, 2),
                ];
            }
        );
    }

    /**
     * Export agent performance CSV.
     */
    public function exportAgents(Request $request)
    {
        $agents = User::role('agent')
            ->withCount([
                'assignedDeliveries',
                'assignedDeliveries as delivered_count' => function ($q) {
                    $q->where('status', Order::STATUS_DELIVERED);
                },
                'assignedDeliveries as in_transit_count' => function ($q) {
                    $q->where('status', Order::STATUS_TRANSIT);
                },
                'assignedDeliveries as pending_count' => function ($q) {
                    $q->where('status', Order::STATUS_PENDING);
                },
                'assignedDeliveries as cancelled_count' => function ($q) {
                    $q->where('status', Order::STATUS_CANCELLED);
                },
            ])
            ->get();

        return $this->streamCsv(
            $agents,
            'agent_performance_' . now()->format('Y-m-d') . '.csv',
            ['Name', 'Email', 'Phone', 'Available', 'Total Deliveries', 'Delivered', 'In Transit', 'Pending', 'Cancelled', 'Performance Score'],
            function ($agent) {
                return [
                    $agent->name,
                    $agent->email,
                    $agent->phone ?? '',
                    $agent->is_available ? 'Yes' : 'No',
                    $agent->assigned_deliveries_count,
                    $agent->delivered_count,
                    $agent->in_transit_count,
                    $agent->pending_count,
                    $agent->cancelled_count,
                    $agent->performance_score ?? 'N/A',
                ];
            }
        );
    }

    /**
     * Export customers CSV.
     */
    public function exportCustomers(Request $request)
    {
        $customers = User::role('customer')
            ->withCount(['orders'])
            ->get();

        return $this->streamCsv(
            $customers,
            'customers_export_' . now()->format('Y-m-d') . '.csv',
            ['Name', 'Email', 'Phone', 'Total Orders', 'Joined At'],
            function ($customer) {
                return [
                    $customer->name,
                    $customer->email,
                    $customer->phone ?? '',
                    $customer->orders_count,
                    $customer->created_at->format('Y-m-d H:i:s'),
                ];
            }
        );
    }

    /**
     * Helper to stream a CSV download response.
     */
    protected function streamCsv($collection, string $filename, array $headers, callable $rowMapper): StreamedResponse
    {
        return response()->streamDownload(function () use ($collection, $headers, $rowMapper) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM for Excel
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header row
            fputcsv($handle, $headers);

            // Data rows
            foreach ($collection as $item) {
                fputcsv($handle, $rowMapper($item));
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Cache-Control' => 'no-store',
        ]);
    }
}
