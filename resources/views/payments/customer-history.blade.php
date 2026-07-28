@extends('layouts.metronic')

@section('title', 'Payment History')
@section('body_class', 'aside-enabled')

@section('sidebar')
    @include('partials.role-sidebar')
@endsection

@section('container_class', 'container-xxl')

@section('content')
<div class="liquid-mesh-container">
<div class="liquid-mesh-bg"></div>

<!--begin::Header-->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-6 gap-3">
    <div>
        <h1 class="page-heading fs-2x fw-bolder text-dark">PAYMENT HISTORY</h1>
        <p class="text-muted fs-6 mt-1 mb-0">Track all your payment transactions.</p>
    </div>
    <a href="{{ route('orders.place') }}" class="liquid-glass-btn-primary d-inline-flex align-items-center gap-2">
        <i class="ki-duotone ki-plus fs-2"><span class="path1"></span><span class="path2"></span></i>
        Place New Order
    </a>
</div>
<!--end::Header-->

<!--begin::Stats Cards-->
<div class="row g-4 mb-6">
    <div class="col-sm-6 col-xl-3">
        <div class="liquid-glass-card p-4 h-100">
            <div class="card-body p-0 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="symbol symbol-40px">
                        <div class="symbol-label bg-light-success">
                            <i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <span class="fs-7 text-muted fw-semibold">Total Paid</span>
                </div>
                <div class="fs-2 fw-bolder text-success font-monospace">₦{{ number_format($totalPaid) }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-flush h-100">
            <div class="card-body d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="symbol symbol-40px">
                        <div class="symbol-label bg-light-warning">
                            <i class="ki-duotone ki-time fs-1 text-warning"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <span class="fs-7 text-muted fw-semibold">Pending</span>
                </div>
                <div class="fs-2 fw-bolder text-warning font-monospace">₦{{ number_format($totalPending) }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-flush h-100">
            <div class="card-body d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="symbol symbol-40px">
                        <div class="symbol-label bg-light-danger">
                            <i class="ki-duotone ki-cross-circle fs-1 text-danger"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <span class="fs-7 text-muted fw-semibold">Failed</span>
                </div>
                <div class="fs-2 fw-bolder text-danger font-monospace">₦{{ number_format($totalFailed) }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-flush h-100">
            <div class="card-body d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="symbol symbol-40px">
                        <div class="symbol-label bg-light-primary">
                            <i class="ki-duotone ki-bill fs-1 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span></i>
                        </div>
                    </div>
                    <span class="fs-7 text-muted fw-semibold">Transactions</span>
                </div>
                <div class="fs-2 fw-bolder text-primary font-monospace">{{ $totalTransactions }}</div>
            </div>
        </div>
    </div>
</div>
<!--end::Stats Cards-->

<!--begin::Filters-->
<div class="card card-flush mb-6">
    <div class="card-body py-4">
        <form method="GET" action="{{ route('payments.customer') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold fs-7">Payment Status</label>
                <select name="payment_status" class="form-select form-select-solid form-select-sm">
                    <option value="all" {{ request('payment_status') == 'all' ? 'selected' : '' }}>All Statuses</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold fs-7">From Date</label>
                <input type="date" name="date_from" class="form-control form-control-solid form-control-sm" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold fs-7">To Date</label>
                <input type="date" name="date_to" class="form-control form-control-solid form-control-sm" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-sm btn-primary w-100">
                    <i class="ki-duotone ki-filter fs-4"><span class="path1"></span><span class="path2"></span></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>
<!--end::Filters-->

<!--begin::Payment Table-->
<div class="card card-flush">
    <div class="card-header py-4">
        <h3 class="card-title fw-bolder text-dark fs-4">
            <i class="ki-duotone ki-bill fs-3 text-primary me-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span></i>
            Payment Transactions
        </h3>
    </div>
    <div class="card-body pt-0">
        @if($payments->count())
        <div class="table-responsive">
            <table class="table table-row-bordered table-row-dashed gy-4 align-middle" id="payment-table">
                <thead>
                    <tr class="fs-7 fw-bold text-muted text-uppercase">
                        <th>Order</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Payment Ref</th>
                        <th>Payment Status</th>
                        <th>Order Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td>
                            <span class="font-monospace fw-semibold text-dark">{{ $payment->tracking_number }}</span>
                            <div class="fs-8 text-muted">{{ Str::limit($payment->package_description, 30) }}</div>
                        </td>
                        <td>
                            <span class="text-dark fs-7">{{ $payment->created_at->format('M d, Y') }}</span>
                            <div class="fs-8 text-muted">{{ $payment->created_at->format('g:i A') }}</div>
                        </td>
                        <td>
                            <span class="fs-6 fw-bold text-dark font-monospace">₦{{ number_format($payment->amount) }}</span>
                        </td>
                        <td>
                            <span class="font-monospace fs-8 text-muted">{{ $payment->payment_ref ?? '—' }}</span>
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
            <h3 class="fs-4 fw-bolder text-dark mb-2">No Payments Yet</h3>
            <p class="fs-6 text-muted mb-6">You haven't made any payment transactions yet.</p>
            <a href="{{ route('orders.place') }}" class="btn btn-primary">Place Your First Order</a>
        </div>
        @endif
    </div>
</div>
<!--end::Payment Table-->

<!--begin::Chart-->
@if(count($monthlyPayments) > 0)
<div class="row g-6 mt-2">
    <div class="col-12">
        <div class="card card-flush">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">MONTHLY PAYMENT TREND</h3>
            </div>
            <div class="card-body">
                <div id="chart-payment-trend" style="height: 280px;"></div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.49.1/dist/apexcharts.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(count($monthlyPayments) > 0)
    const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
    const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
    const textColor = isDark ? '#888' : '#666';

    const pData = @json($monthlyPayments);
    new ApexCharts(document.getElementById('chart-payment-trend'), {
        chart: { type: 'area', height: 280, toolbar: { show: false }, background: 'transparent' },
        series: [{ name: 'Amount Paid (₦)', data: Object.values(pData) }],
        colors: ['#15c552'],
        stroke: { curve: 'smooth', width: 3 },
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 100] } },
        dataLabels: { enabled: false },
        xaxis: { categories: Object.keys(pData), labels: { style: { colors: textColor } }, axisBorder: { show: false } },
        yaxis: { labels: { style: { colors: textColor }, formatter: v => '₦' + Number(v).toLocaleString() } },
        grid: { borderColor: gridColor, strokeDashArray: 4 },
        tooltip: { theme: isDark ? 'dark' : 'light', y: { formatter: v => '₦' + Number(v).toLocaleString() } }
    }).render();
    @endif
});
</script>
@endpush
