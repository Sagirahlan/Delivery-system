@extends('layouts.metronic')

@section('title', 'Payment Management')
@section('body_class', 'aside-enabled')

@section('sidebar')
    @include('partials.role-sidebar')
@endsection

@section('container_class', 'container-xxl')

@section('content')
<!--begin::Header-->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-6 gap-3">
    <div>
        <h1 class="page-heading">PAYMENT MANAGEMENT</h1>
        <p class="text-muted fs-6 mt-1">Trace and monitor all payment transactions across the platform.</p>
    </div>
</div>
<!--end::Header-->

<!--begin::Stats Cards-->
<div class="row g-4 mb-6">
    <div class="col-sm-6 col-xl-3">
        <div class="card card-flush h-100" style="border-left: 4px solid #15c552;">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="symbol symbol-40px">
                        <div class="symbol-label bg-light-success">
                            <i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <div>
                        <div class="fs-8 text-muted fw-semibold text-uppercase">Total Revenue</div>
                        <div class="fs-2 fw-bolder text-success font-monospace">₦{{ number_format($totalRevenue) }}</div>
                    </div>
                </div>
                <div class="fs-8 text-muted">{{ $paidCount }} successful {{ Str::plural('payment', $paidCount) }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-flush h-100" style="border-left: 4px solid #ff8c00;">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="symbol symbol-40px">
                        <div class="symbol-label bg-light-warning">
                            <i class="ki-duotone ki-time fs-1 text-warning"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <div>
                        <div class="fs-8 text-muted fw-semibold text-uppercase">Pending</div>
                        <div class="fs-2 fw-bolder text-warning font-monospace">₦{{ number_format($totalPending) }}</div>
                    </div>
                </div>
                <div class="fs-8 text-muted">{{ $pendingCount }} pending {{ Str::plural('payment', $pendingCount) }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-flush h-100" style="border-left: 4px solid #f13848;">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="symbol symbol-40px">
                        <div class="symbol-label bg-light-danger">
                            <i class="ki-duotone ki-cross-circle fs-1 text-danger"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <div>
                        <div class="fs-8 text-muted fw-semibold text-uppercase">Failed</div>
                        <div class="fs-2 fw-bolder text-danger font-monospace">₦{{ number_format($totalFailed) }}</div>
                    </div>
                </div>
                <div class="fs-8 text-muted">{{ $failedCount }} failed {{ Str::plural('payment', $failedCount) }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-flush h-100" style="border-left: 4px solid #00a8ff;">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="symbol symbol-40px">
                        <div class="symbol-label bg-light-primary">
                            <i class="ki-duotone ki-bill fs-1 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span></i>
                        </div>
                    </div>
                    <div>
                        <div class="fs-8 text-muted fw-semibold text-uppercase">Total Transactions</div>
                        <div class="fs-2 fw-bolder text-primary font-monospace">{{ $totalTransactions }}</div>
                    </div>
                </div>
                <div class="fs-8 text-muted">All time</div>
            </div>
        </div>
    </div>
</div>
<!--end::Stats Cards-->

<!--begin::Charts Row-->
<div class="row g-6 mb-6">
    <div class="col-lg-8">
        <div class="card card-flush h-100">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">
                    <i class="ki-duotone ki-chart-line-up fs-3 text-primary me-2"><span class="path1"></span><span class="path2"></span></i>
                    MONTHLY REVENUE
                </h3>
            </div>
            <div class="card-body">
                <div id="chart-admin-revenue" style="height: 280px;"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-flush h-100">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">
                    <i class="ki-duotone ki-chart fs-3 text-primary me-2"><span class="path1"></span><span class="path2"></span></i>
                    STATUS BREAKDOWN
                </h3>
            </div>
            <div class="card-body">
                <div id="chart-admin-status" style="height: 280px;"></div>
            </div>
        </div>
    </div>
</div>
<!--end::Charts Row-->

<!--begin::Filters-->
<div class="card card-flush mb-6">
    <div class="card-body py-4">
        <form method="GET" action="{{ route('admin.payments.index') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold fs-7">Search</label>
                <input type="text" name="search" class="form-control form-control-solid form-control-sm"
                       placeholder="Order #, Payment Ref, Customer..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold fs-7">Payment Status</label>
                <select name="payment_status" class="form-select form-select-solid form-select-sm">
                    <option value="all" {{ request('payment_status') == 'all' ? 'selected' : '' }}>All</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold fs-7">From</label>
                <input type="date" name="date_from" class="form-control form-control-solid form-control-sm" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold fs-7">To</label>
                <input type="date" name="date_to" class="form-control form-control-solid form-control-sm" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary flex-grow-1">
                    <i class="ki-duotone ki-filter fs-4"><span class="path1"></span><span class="path2"></span></i> Filter
                </button>
                <a href="{{ route('admin.payments.index') }}" class="btn btn-sm btn-light">Reset</a>
            </div>
        </form>
    </div>
</div>
<!--end::Filters-->

<!--begin::Payment Table-->
<div class="card card-flush">
    <div class="card-header py-4 d-flex justify-content-between align-items-center">
        <h3 class="card-title fw-bolder text-dark fs-4">
            <i class="ki-duotone ki-bill fs-3 text-primary me-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span></i>
            All Transactions
        </h3>
        <span class="badge badge-light-primary fs-7">{{ $payments->total() }} total</span>
    </div>
    <div class="card-body pt-0">
        @if($payments->count())
        <div class="table-responsive">
            <table class="table table-row-bordered table-row-dashed gy-4 align-middle" id="admin-payment-table">
                <thead>
                    <tr class="fs-7 fw-bold text-muted text-uppercase">
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Payment Ref</th>
                        <th>Payment Status</th>
                        <th>Order Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td>
                            <a href="{{ route('admin.orders.show', $payment->tracking_number) }}" class="text-primary fw-semibold font-monospace text-hover-dark">
                                {{ $payment->tracking_number }}
                            </a>
                        </td>
                        <td>
                            @if($payment->user)
                            <div class="d-flex align-items-center gap-2">
                                <div class="symbol symbol-30px">
                                    <div class="symbol-label bg-light-primary">
                                        <span class="fs-7 fw-bold text-primary">{{ strtoupper(substr($payment->user->name, 0, 1)) }}</span>
                                    </div>
                                </div>
                                <div>
                                    <span class="fs-7 fw-semibold text-dark">{{ $payment->user->name }}</span>
                                    <div class="fs-8 text-muted">{{ $payment->user->email }}</div>
                                </div>
                            </div>
                            @else
                                <span class="text-muted fs-8">Unknown</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-dark fs-7">{{ $payment->created_at->format('M d, Y') }}</span>
                            <div class="fs-8 text-muted">{{ $payment->created_at->format('g:i A') }}</div>
                        </td>
                        <td>
                            <span class="fs-6 fw-bold text-dark font-monospace">₦{{ number_format($payment->amount) }}</span>
                        </td>
                        <td>
                            <span class="font-monospace fs-8 text-muted" title="{{ $payment->payment_ref }}">
                                {{ $payment->payment_ref ? Str::limit($payment->payment_ref, 15) : '—' }}
                            </span>
                        </td>
                        <td>
                            @if($payment->payment_status === 'paid')
                                <span class="badge badge-light-success fs-8">
                                    <i class="ki-duotone ki-check-circle fs-7 me-1"><span class="path1"></span><span class="path2"></span></i>Paid
                                </span>
                            @elseif($payment->payment_status === 'pending')
                                <span class="badge badge-light-warning fs-8">
                                    <i class="ki-duotone ki-time fs-7 me-1"><span class="path1"></span><span class="path2"></span></i>Pending
                                </span>
                            @else
                                <span class="badge badge-light-danger fs-8">
                                    <i class="ki-duotone ki-cross-circle fs-7 me-1"><span class="path1"></span><span class="path2"></span></i>Failed
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($payment->status === 'pending')
                                <span class="badge badge-light-info fs-8">Pending</span>
                            @elseif($payment->status === 'transit')
                                <span class="badge badge-light-warning fs-8">In Transit</span>
                            @elseif($payment->status === 'delivered')
                                <span class="badge badge-light-success fs-8">Delivered</span>
                            @else
                                <span class="badge badge-light-danger fs-8">Cancelled</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.orders.show', $payment->tracking_number) }}" class="btn btn-sm btn-light-primary btn-icon" title="View Order">
                                <i class="ki-duotone ki-eye fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $payments->withQueryString()->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <i class="ki-duotone ki-bill fs-5x text-muted mb-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span></i>
            <h3 class="fs-4 fw-bolder text-dark mb-2">No Transactions Found</h3>
            <p class="fs-6 text-muted">No payment transactions match your filters.</p>
        </div>
        @endif
    </div>
</div>
<!--end::Payment Table-->
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.49.1/dist/apexcharts.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
    const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
    const textColor = isDark ? '#888' : '#666';

    // Chart 1: Monthly Revenue
    const revData = @json($monthlyRevenue);
    new ApexCharts(document.getElementById('chart-admin-revenue'), {
        chart: { type: 'bar', height: 280, toolbar: { show: false }, background: 'transparent' },
        series: [{ name: 'Revenue (₦)', data: Object.values(revData) }],
        colors: ['#15c552'],
        plotOptions: { bar: { borderRadius: 6, columnWidth: '50%' } },
        dataLabels: { enabled: false },
        xaxis: { categories: Object.keys(revData), labels: { style: { colors: textColor } }, axisBorder: { show: false } },
        yaxis: { labels: { style: { colors: textColor }, formatter: v => '₦' + Number(v).toLocaleString() } },
        grid: { borderColor: gridColor, strokeDashArray: 4 },
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.9, opacityTo: 0.5, stops: [0, 100] } },
        tooltip: { theme: isDark ? 'dark' : 'light', y: { formatter: v => '₦' + Number(v).toLocaleString() } }
    }).render();

    // Chart 2: Payment Status Donut
    const stData = @json($statusDistribution);
    const stLabels = Object.keys(stData);
    const stValues = Object.values(stData);
    const stColors = { 'Paid':'#15c552', 'Pending':'#ff8c00', 'Failed':'#f13848' };

    new ApexCharts(document.getElementById('chart-admin-status'), {
        chart: { type: 'donut', height: 280, background: 'transparent' },
        series: stValues,
        labels: stLabels,
        colors: stLabels.map(l => stColors[l] || '#888'),
        legend: { position: 'bottom', labels: { colors: textColor } },
        dataLabels: { enabled: true, style: { colors: ['#fff'] }, formatter: (v) => Math.round(v) + '%' },
        stroke: { show: true, colors: [isDark ? '#141414' : '#fff'], width: 2 },
        tooltip: { theme: isDark ? 'dark' : 'light' }
    }).render();
});
</script>
@endpush
