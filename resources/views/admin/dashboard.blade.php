@extends('layouts.metronic')

@section('title', 'Admin Dashboard')
@section('body_class', 'aside-enabled')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Overview of all operations')

@section('sidebar')
    @include('partials.admin-sidebar')
@endsection

@section('breadcrumb')
<!--begin::Item-->
<li class="breadcrumb-item">
    <a href="/" class="text-hover-primary" style="color: #94a3b8 !important; font-weight: 500; font-size: 1.1rem;">Home</a>
</li>
<!--end::Item-->
<!--begin::Separator-->
<li class="breadcrumb-item"><span style="color: #94a3b8; margin: 0 4px; font-weight: bold; font-size: 1.1rem;">-</span></li>
<!--end::Separator-->
<!--begin::Item-->
<li class="breadcrumb-item" style="color: #94a3b8; font-weight: 500; font-size: 1.1rem;">Admin Dashboard</li>
<!--end::Item-->
@endsection

@section('container_class', 'container-xxl')

@section('content')
<!--begin::Stats Row-->
<div class="row g-6 mb-6">
    <!-- Total Orders -->
    <div class="col-sm-6 col-xl-3">
        <div class="card card-flush">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="symbol symbol-40px me-3">
                        <div class="symbol-label bg-light-info d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-package fs-4 text-info">
                                <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                            </i>
                        </div>
                    </div>
                    <div>
                        <div class="text-muted fs-7 fw-semibold">Total Orders</div>
                        <div class="fs-4 fw-bolder text-dark">{{ number_format($totalOrders) }}</div>
                    </div>
                </div>
                <div class="d-flex align-items-center text-success fs-7">
                    <i class="ki-duotone ki-arrow-up fs-3 me-1"><span class="path1"></span><span class="path2"></span></i>
                    +12% this week
                </div>
            </div>
        </div>
    </div>
    <!-- Active Agents -->
    <div class="col-sm-6 col-xl-3">
        <div class="card card-flush">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="symbol symbol-40px me-3">
                        <div class="symbol-label bg-light-success d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-users fs-4 text-success">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                        </div>
                    </div>
                    <div>
                        <div class="text-muted fs-7 fw-semibold">Active Agents</div>
                        <div class="fs-4 fw-bolder text-dark">{{ $activeAgents }}</div>
                    </div>
                </div>
                <div class="text-muted fs-7">of {{ $totalAgents }} total agents</div>
            </div>
        </div>
    </div>
    <!-- Revenue -->
    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('admin.wallet') }}" class="card card-flush card-hover text-decoration-none">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="symbol symbol-40px me-3">
                        <div class="symbol-label bg-light-warning d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-wallet fs-4 text-warning">
                                <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                            </i>
                        </div>
                    </div>
                    <div>
                        <div class="text-muted fs-7 fw-semibold">Revenue</div>
                        <div class="fs-4 fw-bolder text-dark font-monospace">₦{{ number_format($revenue, 0) }}</div>
                    </div>
                </div>
                <div class="d-flex align-items-center text-success fs-7">
                    <i class="ki-duotone ki-arrow-up fs-3 me-1"><span class="path1"></span><span class="path2"></span></i>
                    +8% this week
                </div>
            </div>
        </a>
    </div>
    <!-- Pending Orders -->
    <div class="col-sm-6 col-xl-3">
        <div class="card card-flush">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="symbol symbol-40px me-3">
                        <div class="symbol-label bg-light-danger d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-hourglass fs-4 text-danger">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                        </div>
                    </div>
                    <div>
                        <div class="text-muted fs-7 fw-semibold">Pending Orders</div>
                        <div class="fs-4 fw-bolder text-dark">{{ $pendingOrders }}</div>
                    </div>
                </div>
                <div class="d-flex align-items-center text-warning fs-7">
                    <i class="ki-duotone ki-information fs-3 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                    Needs attention
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Stats Row-->

<!--begin::Tables & Agent Status Row-->
<div class="row g-6">
    <!-- Recent Orders Table -->
    <div class="col-xl-8">
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header d-flex align-items-center justify-content-between py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">RECENT ORDERS</h3>
                <a href="#" class="btn btn-sm btn-light-primary">View All</a>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-row-dashed gy-5" id="kt_datatable_recent_orders">
                        <thead>
                            <tr class="fw-bold text-muted">
                                <th class="min-w-80px">Order ID</th>
                                <th class="min-w-120px">Customer</th>
                                <th class="min-w-150px">Route</th>
                                <th class="min-w-80px">Amount</th>
                                <th class="min-w-100px">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td><span class="font-monospace text-dark">#{{ $order->tracking_number }}</span></td>
                                <td>{{ $order->user?->name ?? '—' }}</td>
                                <td>{{ Str::limit($order->pickup_address, 15) }} → {{ Str::limit($order->delivery_address, 15) }}</td>
                                <td class="font-monospace">₦{{ number_format($order->amount, 0) }}</td>
                                <td>
                                    @php
                                        $badgeMap = ['pending'=>'badge-light-info','transit'=>'badge-light-warning','delivered'=>'badge-light-success','cancelled'=>'badge-light-danger'];
                                        $dotColors = ['pending'=>'info','transit'=>'warning','delivered'=>'success','cancelled'=>'danger'];
                                    @endphp
                                    <span class="badge {{ $badgeMap[$order->status] ?? 'badge-light-secondary' }}">
                                        <span class="bullet bullet-dot bg-{{ $dotColors[$order->status] ?? 'secondary' }} fs-2x me-1"></span>
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">No orders yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!--end::Card body-->
        </div>
    </div>

    <!-- Agent Status Panel -->
    <div class="col-xl-4">
        <div class="card card-flush h-100">
            <!--begin::Card header-->
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">AGENT STATUS</h3>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <div class="d-flex flex-column gap-3">
                    @forelse($agents as $agent)
                    <div class="d-flex align-items-center p-3 rounded hover-elevate-up">
                        <div class="symbol symbol-40px me-3 position-relative">
                            <div class="symbol-label bg-{{ $agent->is_available ? 'light-success' : 'light-secondary' }}">
                                <i class="ki-duotone ki-user fs-3 text-{{ $agent->is_available ? 'success' : 'secondary' }}">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                            </div>
                            <span class="bullet bullet-dot bg-{{ $agent->is_available ? 'success' : 'secondary' }} border-2 border-light position-absolute bottom-0 end-0"></span>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold text-dark">{{ $agent->name }}</div>
                            <div class="fs-8 text-muted">{{ $agent->active_deliveries }} active deliveries</div>
                        </div>
                        <span class="badge badge-light-{{ $agent->is_available ? 'success' : 'secondary' }}">{{ $agent->is_available ? 'Active' : 'Offline' }}</span>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">No agents registered yet.</div>
                    @endforelse
                </div>
            </div>
            <!--end::Card body-->
        </div>
    </div>
</div>
<!--end::Tables & Agent Status Row-->

<!--begin::Charts Row-->
<div class="row g-6 mt-2">
    <!-- Orders by Status (Bar Chart) -->
    <div class="col-lg-6">
        <div class="card card-flush h-100">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">ORDERS BY STATUS</h3>
            </div>
            <div class="card-body">
                <div id="chart-orders-status" style="height: 300px;"></div>
            </div>
        </div>
    </div>
    <!-- Package Size Distribution (Pie Chart) -->
    <div class="col-lg-6">
        <div class="card card-flush h-100">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">PACKAGE SIZE DISTRIBUTION</h3>
            </div>
            <div class="card-body">
                <div id="chart-package-size" style="height: 300px;"></div>
            </div>
        </div>
    </div>
</div>

<!--begin::Revenue & Performance Row-->
<div class="row g-6 mt-2">
    <!-- Monthly Revenue (Bar Chart) -->
    <div class="col-lg-8">
        <div class="card card-flush h-100">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">MONTHLY REVENUE</h3>
            </div>
            <div class="card-body">
                <div id="chart-revenue" style="height: 300px;"></div>
            </div>
        </div>
    </div>
    <!-- Agent Performance (Bar Chart) -->
    <div class="col-lg-4">
        <div class="card card-flush h-100">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">TOP AGENTS</h3>
            </div>
            <div class="card-body">
                <div id="chart-agents" style="height: 300px;"></div>
            </div>
        </div>
    </div>
</div>
<!--end::Charts Row-->
@endsection

@push('scripts')
<!-- ApexCharts CDN -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.49.1/dist/apexcharts.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    KTComponents.init();

    const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
    const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
    const textColor = isDark ? '#888' : '#666';

    // Chart 1: Orders by Status (Bar)
    const statusData = @json($ordersByStatus);
    const statusLabels = Object.keys(statusData).map(s => s.charAt(0).toUpperCase() + s.slice(1));
    const statusValues = Object.values(statusData);
    const statusColors = { 'Pending':'#00a8ff', 'Transit':'#ff8c00', 'Delivered':'#15c552', 'Cancelled':'#f13848' };
    const statusBarColors = statusLabels.map(l => statusColors[l] || '#888');

    new ApexCharts(document.getElementById('chart-orders-status'), {
        chart: { type: 'bar', height: 300, toolbar: { show: false }, background: 'transparent' },
        series: [{ name: 'Orders', data: statusValues }],
        colors: statusBarColors,
        plotOptions: { bar: { borderRadius: 6, columnWidth: '50%' } },
        dataLabels: { enabled: false },
        xaxis: { categories: statusLabels, labels: { style: { colors: textColor } }, axisBorder: { show: false } },
        yaxis: { labels: { style: { colors: textColor } } },
        grid: { borderColor: gridColor, strokeDashArray: 4 },
        states: { hover: { filter: { type: 'lighten', value: 0.15 } } },
        tooltip: { theme: isDark ? 'dark' : 'light' }
    }).render();

    // Chart 2: Package Size (Pie)
    const sizeData = @json($ordersBySize);
    const sizeLabels = Object.keys(sizeData).map(s => s.charAt(0).toUpperCase() + s.slice(1));
    const sizeValues = Object.values(sizeData);

    new ApexCharts(document.getElementById('chart-package-size'), {
        chart: { type: 'pie', height: 300, background: 'transparent' },
        series: sizeValues,
        labels: sizeLabels,
        colors: ['#15c552', '#ff8c00', '#f13848'],
        legend: { position: 'bottom', labels: { colors: textColor } },
        dataLabels: { enabled: true, style: { colors: ['#fff'] }, formatter: (v) => Math.round(v) + '%' },
        stroke: { show: true, colors: [isDark ? '#141414' : '#fff'], width: 2 },
        states: { hover: { filter: { type: 'lighten', value: 0.15 } } },
        tooltip: { theme: isDark ? 'dark' : 'light' }
    }).render();

    // Chart 3: Monthly Revenue (Bar)
    const revData = @json($monthlyRevenue);
    const revLabels = Object.keys(revData);
    const revValues = Object.values(revData);

    new ApexCharts(document.getElementById('chart-revenue'), {
        chart: { type: 'bar', height: 300, toolbar: { show: false }, background: 'transparent' },
        series: [{ name: 'Revenue (₦)', data: revValues }],
        colors: ['#ff8c00'],
        plotOptions: { bar: { borderRadius: 6, columnWidth: '45%' } },
        dataLabels: { enabled: false },
        xaxis: { categories: revLabels, labels: { style: { colors: textColor } }, axisBorder: { show: false } },
        yaxis: { labels: { style: { colors: textColor }, formatter: v => '₦' + Number(v).toLocaleString() } },
        grid: { borderColor: gridColor, strokeDashArray: 4 },
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.9, opacityTo: 0.5, stops: [0, 100] } },
        states: { hover: { filter: { type: 'lighten', value: 0.15 } } },
        tooltip: { theme: isDark ? 'dark' : 'light', y: { formatter: v => '₦' + Number(v).toLocaleString() } }
    }).render();

    // Chart 4: Top Agents (Horizontal Bar)
    const agentNames = @json($agentDeliveries->pluck('name'));
    const agentCounts = @json($agentDeliveries->pluck('deliveries'));

    new ApexCharts(document.getElementById('chart-agents'), {
        chart: { type: 'bar', height: 300, toolbar: { show: false }, background: 'transparent' },
        series: [{ name: 'Deliveries', data: agentCounts }],
        colors: ['#15c552'],
        plotOptions: { bar: { borderRadius: 6, horizontal: true, barHeight: '60%' } },
        dataLabels: { enabled: true, style: { colors: ['#fff'] }, formatter: v => v },
        xaxis: { categories: agentNames, labels: { style: { colors: textColor, fontSize: '11px' } }, axisBorder: { show: false } },
        yaxis: { labels: { style: { colors: textColor, fontSize: '11px' } } },
        grid: { borderColor: gridColor, strokeDashArray: 4, xaxis: { lines: { show: true } } },
        states: { hover: { filter: { type: 'lighten', value: 0.15 } } },
        tooltip: { theme: isDark ? 'dark' : 'light' }
    }).render();
});
</script>
@endpush
