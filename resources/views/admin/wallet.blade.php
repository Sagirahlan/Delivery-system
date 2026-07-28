@extends('layouts.metronic')

@section('title', 'Company Wallet')
@section('body_class', 'aside-enabled')

@section('sidebar')
    @include('partials.role-sidebar')
@endsection

@section('container_class', 'container-xxl')

@push('styles')
<style>
    .wallet-hero {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        border-radius: 16px;
        overflow: hidden;
        position: relative;
    }
    .wallet-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 400px;
        height: 400px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255,140,0,0.15) 0%, transparent 70%);
    }
    .wallet-hero::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(21,197,82,0.1) 0%, transparent 70%);
    }
    .wallet-balance-label {
        color: rgba(255,255,255,0.6);
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 600;
    }
    .wallet-balance-value {
        color: #fff;
        font-size: 2.8rem;
        font-weight: 800;
        font-family: 'Inter', monospace;
        line-height: 1.1;
    }
    .wallet-mini-stat {
        background: rgba(255,255,255,0.08);
        border-radius: 12px;
        padding: 16px 20px;
        border: 1px solid rgba(255,255,255,0.06);
        backdrop-filter: blur(10px);
    }
    .wallet-mini-stat .label {
        color: rgba(255,255,255,0.5);
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
    }
    .wallet-mini-stat .value {
        color: #fff;
        font-size: 1.3rem;
        font-weight: 700;
        font-family: 'Inter', monospace;
    }
    .period-card {
        border-left: 4px solid transparent;
        transition: all 0.2s ease;
    }
    .period-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }
    .period-card.today { border-left-color: #15c552; }
    .period-card.week { border-left-color: #ff8c00; }
    .period-card.month { border-left-color: #00a8ff; }
    .txn-row {
        transition: background 0.15s ease;
    }
    .txn-row:hover {
        background: rgba(255,140,0,0.04) !important;
    }
    .top-customer-card {
        transition: all 0.2s ease;
    }
    .top-customer-card:hover {
        transform: translateX(4px);
    }
</style>
@endpush

@section('content')
<!--begin::Page Header-->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-6 gap-3">
    <div>
        <h1 class="page-heading">COMPANY WALLET</h1>
        <p class="text-muted fs-6 mt-1">Financial overview and transaction tracking for HMLL.</p>
    </div>
    <a href="{{ route('admin.payments.index') }}" class="btn btn-light-primary">
        <i class="ki-duotone ki-bill fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span></i>
        View All Payments
    </a>
</div>
<!--end::Page Header-->

<!--begin::Wallet Hero Card-->
<div class="wallet-hero p-6 p-lg-8 mb-6">
    <div class="position-relative" style="z-index: 1;">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-5 mb-lg-0">
                <div class="wallet-balance-label mb-2">Company Balance</div>
                <div class="wallet-balance-value mb-3">₦{{ number_format($totalBalance, 2) }}</div>
                <div class="d-flex align-items-center gap-2 mb-4">
                    <span class="bullet bullet-dot bg-success fs-2x animate-pulse"></span>
                    <span style="color: rgba(255,255,255,0.6); font-size: 0.85rem;">{{ $totalPaidOrders }} confirmed {{ Str::plural('payment', $totalPaidOrders) }}</span>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <span class="badge" style="background: rgba(21,197,82,0.2); color: #4ade80; font-size: 0.78rem; padding: 6px 12px;">
                        <i class="ki-duotone ki-check-circle fs-7 me-1" style="color: #4ade80;"><span class="path1"></span><span class="path2"></span></i>
                        NABRoll Connected
                    </span>
                    <span class="badge" style="background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.7); font-size: 0.78rem; padding: 6px 12px;">
                        <i class="ki-duotone ki-shield-tick fs-7 me-1" style="color: rgba(255,255,255,0.6);"><span class="path1"></span><span class="path2"></span></i>
                        Secure
                    </span>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="row g-3">
                    <div class="col-sm-4">
                        <div class="wallet-mini-stat">
                            <div class="label mb-1">Pending</div>
                            <div class="value" style="color: #fbbf24;">₦{{ number_format($pendingBalance) }}</div>
                            <div style="color: rgba(255,255,255,0.4); font-size: 0.72rem;" class="mt-1">{{ $totalPendingOrders }} orders</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="wallet-mini-stat">
                            <div class="label mb-1">Failed</div>
                            <div class="value" style="color: #f87171;">₦{{ number_format($failedAmount) }}</div>
                            <div style="color: rgba(255,255,255,0.4); font-size: 0.72rem;" class="mt-1">{{ $totalFailedOrders }} orders</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="wallet-mini-stat">
                            <div class="label mb-1">Avg Order</div>
                            <div class="value">₦{{ number_format($averageOrderValue) }}</div>
                            <div style="color: rgba(255,255,255,0.4); font-size: 0.72rem;" class="mt-1">{{ $totalCustomers }} customers</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Wallet Hero Card-->

<!--begin::Period Income Cards-->
<div class="row g-4 mb-6">
    <div class="col-md-4">
        <div class="card card-flush period-card today h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="fs-7 text-muted fw-semibold text-uppercase ls-1">Today</span>
                    <div class="symbol symbol-35px">
                        <div class="symbol-label bg-light-success">
                            <i class="ki-duotone ki-calendar-8 fs-3 text-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span></i>
                        </div>
                    </div>
                </div>
                <div class="fs-2 fw-bolder text-dark font-monospace mb-1">₦{{ number_format($todayIncome) }}</div>
                <div class="fs-8 text-muted">{{ $todayTransactions }} {{ Str::plural('transaction', $todayTransactions) }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-flush period-card week h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="fs-7 text-muted fw-semibold text-uppercase ls-1">This Week</span>
                    <div class="symbol symbol-35px">
                        <div class="symbol-label bg-light-warning">
                            <i class="ki-duotone ki-chart-line fs-3 text-warning"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                </div>
                <div class="fs-2 fw-bolder text-dark font-monospace mb-1">₦{{ number_format($weekIncome) }}</div>
                <div class="fs-8 text-muted">{{ $weekTransactions }} {{ Str::plural('transaction', $weekTransactions) }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-flush period-card month h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="fs-7 text-muted fw-semibold text-uppercase ls-1">This Month</span>
                    <div class="symbol symbol-35px">
                        <div class="symbol-label bg-light-primary">
                            <i class="ki-duotone ki-chart-pie-3 fs-3 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        </div>
                    </div>
                </div>
                <div class="fs-2 fw-bolder text-dark font-monospace mb-1">₦{{ number_format($monthIncome) }}</div>
                <div class="fs-8 text-muted">{{ $monthTransactions }} {{ Str::plural('transaction', $monthTransactions) }}</div>
            </div>
        </div>
    </div>
</div>
<!--end::Period Income Cards-->

<!--begin::Charts Row-->
<div class="row g-6 mb-6">
    <!-- Daily Income Sparkline -->
    <div class="col-lg-8">
        <div class="card card-flush h-100">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">
                    <i class="ki-duotone ki-chart-line-up fs-3 text-success me-2"><span class="path1"></span><span class="path2"></span></i>
                    DAILY INCOME (Last 14 Days)
                </h3>
            </div>
            <div class="card-body">
                <div id="chart-daily-income" style="height: 300px;"></div>
            </div>
        </div>
    </div>
    <!-- Payment Status Donut -->
    <div class="col-lg-4">
        <div class="card card-flush h-100">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">
                    <i class="ki-duotone ki-chart fs-3 text-primary me-2"><span class="path1"></span><span class="path2"></span></i>
                    PAYMENT STATUS
                </h3>
            </div>
            <div class="card-body">
                <div id="chart-payment-status" style="height: 300px;"></div>
            </div>
        </div>
    </div>
</div>
<!--end::Charts Row-->

<!--begin::Monthly Revenue Bar Chart-->
<div class="row g-6 mb-6">
    <div class="col-12">
        <div class="card card-flush">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">
                    <i class="ki-duotone ki-wallet fs-3 text-warning me-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                    MONTHLY REVENUE VS TRANSACTIONS
                </h3>
            </div>
            <div class="card-body">
                <div id="chart-monthly-combo" style="height: 320px;"></div>
            </div>
        </div>
    </div>
</div>
<!--end::Monthly Revenue Bar Chart-->

<!--begin::Transactions & Top Customers-->
<div class="row g-6">
    <!-- Recent Transactions -->
    <div class="col-lg-8">
        <div class="card card-flush">
            <div class="card-header py-4 d-flex justify-content-between align-items-center">
                <h3 class="card-title fw-bolder text-dark fs-4">
                    <i class="ki-duotone ki-bill fs-3 text-primary me-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span></i>
                    RECENT TRANSACTIONS
                </h3>
                <a href="{{ route('admin.payments.index') }}" class="btn btn-sm btn-light-primary">View All</a>
            </div>
            <div class="card-body pt-0">
                @if($recentTransactions->count())
                <div class="table-responsive">
                    <table class="table table-row-dashed gy-4 align-middle">
                        <thead>
                            <tr class="fs-7 fw-bold text-muted text-uppercase">
                                <th>Order</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentTransactions as $txn)
                            <tr class="txn-row">
                                <td>
                                    <a href="{{ route('admin.orders.show', $txn->tracking_number) }}" class="font-monospace fw-semibold text-primary text-hover-dark">
                                        {{ $txn->tracking_number }}
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="symbol symbol-28px">
                                            <div class="symbol-label bg-light-primary">
                                                <span class="fs-8 fw-bold text-primary">{{ strtoupper(substr($txn->user->name ?? '?', 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <span class="fs-7 text-dark">{{ Str::limit($txn->user->name ?? 'Unknown', 20) }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-dark fs-7">{{ $txn->created_at->format('M d') }}</span>
                                    <span class="fs-8 text-muted ms-1">{{ $txn->created_at->format('g:i A') }}</span>
                                </td>
                                <td>
                                    <span class="fs-6 fw-bold text-success font-monospace">+₦{{ number_format($txn->amount) }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-light-success fs-8">
                                        <i class="ki-duotone ki-check-circle fs-7 me-1"><span class="path1"></span><span class="path2"></span></i>Received
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-10">
                    <i class="ki-duotone ki-wallet fs-5x text-muted mb-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                    <h4 class="text-dark mb-1">No Transactions Yet</h4>
                    <p class="text-muted fs-7">Payment transactions will appear here once customers start paying.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Top Paying Customers -->
    <div class="col-lg-4">
        <div class="card card-flush h-100">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">
                    <i class="ki-duotone ki-crown-2 fs-3 text-warning me-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                    TOP CUSTOMERS
                </h3>
            </div>
            <div class="card-body pt-0">
                @if($topCustomers->count())
                <div class="d-flex flex-column gap-3">
                    @foreach($topCustomers as $i => $customer)
                    <div class="top-customer-card d-flex align-items-center p-3 rounded" style="background: {{ $i === 0 ? 'rgba(255,140,0,0.06)' : 'transparent' }};">
                        <div class="me-3">
                            @if($i === 0)
                                <span class="badge" style="background: linear-gradient(135deg, #ff8c00, #ff6b00); color: #fff; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 8px; font-size: 0.75rem;">🥇</span>
                            @elseif($i === 1)
                                <span class="badge bg-light text-dark" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 8px; font-size: 0.75rem;">🥈</span>
                            @elseif($i === 2)
                                <span class="badge bg-light text-dark" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 8px; font-size: 0.75rem;">🥉</span>
                            @else
                                <span class="badge bg-light text-muted" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 8px; font-size: 0.75rem;">{{ $i + 1 }}</span>
                            @endif
                        </div>
                        <div class="symbol symbol-35px me-3">
                            <div class="symbol-label bg-light-{{ ['primary','success','warning','info','danger'][$i % 5] }}">
                                <span class="fs-7 fw-bold text-{{ ['primary','success','warning','info','danger'][$i % 5] }}">{{ strtoupper(substr($customer->name, 0, 1)) }}</span>
                            </div>
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <div class="fw-semibold text-dark text-truncate">{{ $customer->name }}</div>
                            <div class="fs-8 text-muted">{{ $customer->paid_orders }} {{ Str::plural('order', $customer->paid_orders) }}</div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-dark font-monospace fs-7">₦{{ number_format($customer->total_spent) }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <i class="ki-duotone ki-users fs-5x text-muted mb-3"><span class="path1"></span><span class="path2"></span></i>
                    <p class="text-muted fs-7">No paying customers yet.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!--end::Transactions & Top Customers-->
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.49.1/dist/apexcharts.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
    const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
    const textColor = isDark ? '#888' : '#666';

    // ── Chart 1: Daily Income (Area) ─────────────────────────
    const dailyData = @json($dailyIncome);
    new ApexCharts(document.getElementById('chart-daily-income'), {
        chart: { type: 'area', height: 300, toolbar: { show: false }, background: 'transparent',
            sparkline: { enabled: false } },
        series: [{ name: 'Income (₦)', data: Object.values(dailyData) }],
        colors: ['#15c552'],
        stroke: { curve: 'smooth', width: 3 },
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.35, opacityTo: 0.05, stops: [0, 95] } },
        dataLabels: { enabled: false },
        xaxis: {
            categories: Object.keys(dailyData),
            labels: { style: { colors: textColor, fontSize: '10px' }, rotate: -45, rotateAlways: true },
            axisBorder: { show: false }
        },
        yaxis: { labels: { style: { colors: textColor }, formatter: v => '₦' + Number(v).toLocaleString() } },
        grid: { borderColor: gridColor, strokeDashArray: 4 },
        tooltip: { theme: isDark ? 'dark' : 'light', y: { formatter: v => '₦' + Number(v).toLocaleString() } }
    }).render();

    // ── Chart 2: Payment Status Donut ─────────────────────────
    const stData = @json($paymentStatusDist);
    new ApexCharts(document.getElementById('chart-payment-status'), {
        chart: { type: 'donut', height: 300, background: 'transparent' },
        series: Object.values(stData),
        labels: Object.keys(stData),
        colors: ['#15c552', '#ff8c00', '#f13848'],
        legend: { position: 'bottom', labels: { colors: textColor } },
        plotOptions: { pie: { donut: { size: '65%', labels: {
            show: true,
            total: { show: true, label: 'Total', color: textColor,
                formatter: (w) => w.globals.seriesTotals.reduce((a,b) => a+b, 0) }
        }}}},
        dataLabels: { enabled: true, style: { colors: ['#fff'] }, formatter: (v) => Math.round(v) + '%' },
        stroke: { show: true, colors: [isDark ? '#141414' : '#fff'], width: 2 },
        tooltip: { theme: isDark ? 'dark' : 'light' }
    }).render();

    // ── Chart 3: Monthly Revenue + Transaction Count (Combo) ──
    const mIncome = @json($monthlyIncomeChart);
    const mCount = @json($monthlyCountChart);
    new ApexCharts(document.getElementById('chart-monthly-combo'), {
        chart: { type: 'bar', height: 320, toolbar: { show: false }, background: 'transparent' },
        series: [
            { name: 'Revenue (₦)', type: 'bar', data: Object.values(mIncome) },
            { name: 'Transactions', type: 'line', data: Object.values(mCount) }
        ],
        colors: ['#ff8c00', '#15c552'],
        plotOptions: { bar: { borderRadius: 8, columnWidth: '45%' } },
        stroke: { width: [0, 3], curve: 'smooth' },
        dataLabels: { enabled: false },
        xaxis: { categories: Object.keys(mIncome), labels: { style: { colors: textColor } }, axisBorder: { show: false } },
        yaxis: [
            { title: { text: 'Revenue (₦)', style: { color: textColor } },
              labels: { style: { colors: textColor }, formatter: v => '₦' + Number(v).toLocaleString() } },
            { opposite: true, title: { text: 'Transactions', style: { color: textColor } },
              labels: { style: { colors: textColor } } }
        ],
        grid: { borderColor: gridColor, strokeDashArray: 4 },
        fill: { opacity: [0.85, 1], type: ['gradient', 'solid'],
            gradient: { shadeIntensity: 1, opacityFrom: 0.9, opacityTo: 0.5, stops: [0, 100] } },
        legend: { position: 'top', horizontalAlign: 'right', labels: { colors: textColor } },
        tooltip: { theme: isDark ? 'dark' : 'light', shared: true, intersect: false,
            y: { formatter: (v, { seriesIndex }) => seriesIndex === 0 ? '₦' + Number(v).toLocaleString() : v } }
    }).render();
});
</script>
@endpush
