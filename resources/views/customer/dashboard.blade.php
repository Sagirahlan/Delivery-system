@extends('layouts.metronic')

@section('title', 'My Orders')
@section('body_class', 'aside-enabled')
@section('page_title', 'My Orders')
@section('page_subtitle', 'Track and manage your delivery orders')

@section('sidebar')
    @include('partials.role-sidebar')
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="/" class="text-hover-primary" style="color: #94a3b8 !important; font-weight: 500; font-size: 1.1rem;">Home</a>
</li>
<li class="breadcrumb-item"><span style="color: #94a3b8; margin: 0 4px; font-weight: bold; font-size: 1.1rem;">-</span></li>
<li class="breadcrumb-item" style="color: #94a3b8; font-weight: 500; font-size: 1.1rem;">My Orders</li>
@endsection

@section('container_class', 'container-xxl')

@section('content')
<div class="liquid-mesh-container">
<div class="liquid-mesh-bg"></div>

<!--begin::Android Header with Action-->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-6 gap-3">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <span class="liquid-badge liquid-badge-primary"><span class="bullet bullet-dot bg-warning fs-2x animate-pulse"></span> Liquid Glass OS</span>
            <span class="text-muted fs-8">Active Session</span>
        </div>
        <h1 class="page-heading fs-2x fw-bolder text-dark">MY ORDERS</h1>
        <p class="text-muted fs-6 mt-1 mb-0">Track and manage your delivery orders in real-time.</p>
    </div>
    <a href="/orders/place" class="liquid-glass-btn-primary d-inline-flex align-items-center gap-2" id="cta-new-order">
        <i class="ki-duotone ki-plus fs-2"><span class="path1"></span><span class="path2"></span></i>
        Place New Order
    </a>
</div>
<!--end::Header-->

@include('partials.hammshop-promo')

<!--begin::Main Layout Grid-->
<div class="row g-6">
    <!-- Orders List Column -->
    <div class="col-lg-8">
        <div class="d-flex flex-column gap-4">
            @forelse($orders as $order)
            <!-- Order Card — Dynamic Liquid Glass -->
            <div class="liquid-glass-card cursor-pointer" data-order="{{ $order->tracking_number }}">
                <div class="card-body p-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <span class="text-muted fs-8 font-monospace">#{{ $order->tracking_number }}</span>
                            <h3 class="fs-5 fw-bold text-dark mt-0.5 mb-0">{{ $order->package_description }}</h3>
                        </div>
                        @if($order->status == 'pending')
                            <span class="liquid-badge liquid-badge-primary"><span class="bullet bullet-dot bg-primary fs-2x me-1"></span>Pending</span>
                        @elseif($order->status == 'transit')
                            <span class="liquid-badge liquid-badge-warning"><span class="bullet bullet-dot bg-warning fs-2x me-1"></span>In Transit</span>
                        @elseif($order->status == 'delivered')
                            <span class="liquid-badge liquid-badge-success"><span class="bullet bullet-dot bg-success fs-2x me-1"></span>Delivered</span>
                        @else
                            <span class="liquid-badge liquid-badge-danger"><span class="bullet bullet-dot bg-danger fs-2x me-1"></span>Cancelled</span>
                        @endif
                    </div>

                    <div class="d-flex gap-4 mb-4">
                        <div class="d-flex flex-column align-items-center mt-1">
                            <div class="w-10px h-10px rounded-circle bg-success"></div>
                            <div class="w-2px h-40px {{ $order->status == 'delivered' ? 'bg-success' : ($order->status == 'transit' ? 'bg-warning' : 'bg-gray-300') }}"></div>
                            <div class="w-10px h-10px rounded-circle {{ $order->status == 'pending' ? 'bg-gray-300' : ($order->status == 'transit' ? 'bg-warning' : 'bg-success') }}"></div>
                        </div>
                        <div class="flex-grow-1 d-flex flex-column justify-content-between gap-3">
                            <div>
                                <div class="fs-8 text-muted text-uppercase">Pickup</div>
                                <div class="fs-6 text-dark">{{ $order->pickup_address }}</div>
                            </div>
                            <div>
                                <div class="fs-8 text-muted text-uppercase">Delivery</div>
                                <div class="fs-6 text-dark">{{ $order->delivery_address }}</div>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fs-4 fw-bold text-primary font-monospace">₦{{ number_format($order->amount) }}</div>
                            <div class="fs-8 text-muted">{{ $order->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>

                    @if($order->agent)
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top border-dashed">
                        <div class="d-flex align-items-center gap-2">
                            <div class="symbol symbol-25px">
                                <div class="symbol-label bg-light-primary">
                                    <i class="ki-duotone ki-user fs-3 text-primary">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                </div>
                            </div>
                            <span class="fs-8 text-muted">Agent: {{ $order->agent->name }}</span>
                        </div>
                        @if($order->status == 'transit')
                        <span class="fs-8 text-primary fw-semibold">ETA: 12 min</span>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="card card-flush">
                <div class="card-body text-center py-10">
                    <i class="ki-duotone ki-package fs-5x text-muted mb-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                    <h3 class="fs-4 fw-bolder text-dark mb-2">No Orders Yet</h3>
                    <p class="fs-6 text-muted mb-6">You haven't placed any delivery orders yet.</p>
                    <a href="{{ route('orders.place') }}" class="btn btn-primary">Place Your First Order</a>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Tracking Sidebar Column -->
    <div class="col-lg-4">
        <div class="d-flex flex-column gap-6">
            <!-- Live Tracking Card -->
            <div class="liquid-glass-card" id="tracking-card">
                <div class="card-header d-flex justify-content-between align-items-center p-5 pb-0 border-0">
                    <h3 class="card-title fw-bolder text-dark mb-0">LIVE TRACKING</h3>
                    <span class="d-flex align-items-center gap-1 fs-8 text-success fw-semibold">
                        <span class="bullet bullet-dot bg-success fs-2x animate-pulse"></span> Live
                    </span>
                </div>
                <div class="card-body p-5">
                    <!-- Map placeholder -->
                    <div class="w-100 h-150px rounded-4 bg-light d-flex align-items-center justify-content-center mb-4 position-relative overflow-hidden border border-dashed">
                        <div class="position-absolute inset-0 opacity-20">
                            <div class="position-absolute top-4 start-10 w-50px h-2px bg-gray-400 rotate-45"></div>
                            <div class="position-absolute top-8 end-10 w-75px h-2px bg-gray-400 rotate-n12"></div>
                            <div class="position-absolute bottom-6 start-20 w-100px h-2px bg-gray-400 rotate-6"></div>
                        </div>
                        <div class="text-center z-1">
                            <i class="ki-duotone ki-map fs-1 text-muted mb-1">
                                <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                            </i>
                            <div class="fs-8 text-muted">Live map view</div>
                        </div>
                    </div>

                    @if($activeOrder)
                    <div class="font-monospace fs-8 text-muted mb-3">Order #{{ $activeOrder->tracking_number }}</div>

                    <!-- Status timeline -->
                    <div class="d-flex flex-column gap-3 mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="symbol symbol-25px">
                                <div class="symbol-label bg-light-success">
                                    <i class="ki-duotone ki-check fs-2x text-success">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                </div>
                            </div>
                            <div>
                                <div class="fs-8 text-dark">Order Confirmed</div>
                                <div class="fs-9 text-muted">{{ $activeOrder->created_at->format('g:i A') }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="symbol symbol-25px">
                                <div class="symbol-label {{ $activeOrder->agent_id ? 'bg-light-success' : 'bg-gray-200' }}">
                                    @if($activeOrder->agent_id)
                                    <i class="ki-duotone ki-check fs-2x text-success"><span class="path1"></span><span class="path2"></span></i>
                                    @else
                                    <span class="fs-8 text-muted">2</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <div class="fs-8 text-dark">Picked Up</div>
                                <div class="fs-9 text-muted">{{ $activeOrder->agent_id ? 'Yes' : 'Pending agent' }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="symbol symbol-25px">
                                <div class="symbol-label {{ $activeOrder->status == 'transit' ? 'bg-light-warning pulse' : 'bg-gray-200' }}">
                                    @if($activeOrder->status == 'transit')
                                    <i class="ki-duotone ki-truck fs-2x text-warning"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                    @else
                                    <span class="fs-8 text-muted">3</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <div class="fs-8 {{ $activeOrder->status == 'transit' ? 'text-warning fw-semibold' : 'text-dark' }}">In Transit</div>
                                <div class="fs-9 text-muted">{{ $activeOrder->status == 'transit' ? 'Now' : 'Pending' }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3 opacity-40">
                            <div class="symbol symbol-25px">
                                <div class="symbol-label bg-gray-200">
                                    <span class="fs-8 text-muted">4</span>
                                </div>
                            </div>
                            <div>
                                <div class="fs-8 text-muted">Delivered</div>
                                <div class="fs-9 text-muted">Pending</div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-secondary d-flex align-items-center p-4 rounded-4">
                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-dark fs-6 fw-bold">No Active Delivery</h4>
                            <span class="fs-7 text-muted">Place a new order to see live tracking.</span>
                        </div>
                    </div>
                    @endif

                    <!-- Countdown -->
                    <div class="bg-light rounded-4 p-4 text-center border">
                        <div class="fs-8 text-muted text-uppercase ls-1 mb-1">Estimated Arrival</div>
                        <div class="fs-2 fw-bolder text-primary font-monospace" id="countdown-timer">12:00</div>
                        <div class="fs-8 text-muted mt-1">minutes remaining</div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats Card -->
            <div class="liquid-glass-card">
                <div class="card-header p-5 pb-0 border-0">
                    <h3 class="card-title fw-bolder text-dark mb-0">ORDER SUMMARY</h3>
                </div>
                <div class="card-body p-5">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex justify-content-between fs-7">
                            <span class="text-muted">Total Orders</span>
                            <span class="font-monospace text-dark fw-semibold">{{ $orders->count() }}</span>
                        </div>
                        <div class="d-flex justify-content-between fs-7">
                            <span class="text-muted">Delivered</span>
                            <span class="font-monospace text-success fw-semibold">{{ $orders->where('status', 'delivered')->count() }}</span>
                        </div>
                        <div class="d-flex justify-content-between fs-7">
                            <span class="text-muted">In Progress</span>
                            <span class="font-monospace text-info fw-semibold">{{ $orders->whereIn('status', ['pending', 'transit'])->count() }}</span>
                        </div>
                        <div class="separator my-1"></div>
                        <div class="d-flex justify-content-between fs-6">
                            <span class="text-muted fw-semibold">Total Spent</span>
                            <span class="font-monospace text-primary fw-bold">₦{{ number_format($orders->sum('amount')) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- HammShop Promo Card -->
            <div class="card card-flush" style="background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%); border: 1px solid rgba(255, 140, 0, 0.15); overflow: hidden;">
                <div class="card-body position-relative">
                    <div style="position: absolute; top: -30px; right: -30px; width: 120px; height: 120px; background: radial-gradient(circle, rgba(255, 140, 0, 0.12) 0%, transparent 70%); pointer-events: none;"></div>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div style="width: 42px; height: 42px; border-radius: 12px; background: rgba(255, 140, 0, 0.15); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">🛍️</div>
                        <div>
                            <div class="text-white fw-bolder fs-6">HammShop</div>
                            <div class="text-white text-opacity-50 fs-8">Official Partner Store</div>
                        </div>
                    </div>
                    <p class="text-white text-opacity-65 fs-7 mb-4">Need something delivered? Shop quality products at the best prices on <strong class="text-white">hammshop.com</strong> first!</p>
                    <a href="https://www.hammshop.com" target="_blank" rel="noopener"
                       class="btn btn-sm w-100 fw-bold"
                       style="background: linear-gradient(135deg, #ff8c00 0%, #ff6b00 100%); color: #fff; border-radius: 10px; box-shadow: 0 4px 12px rgba(255, 140, 0, 0.3);">
                        <i class="ki-duotone ki-shop fs-5 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                        Visit HammShop
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Main Layout Grid-->
</div>
@endsection

<!--begin::Charts Row-->
<div class="row g-6 mt-2">
    <!-- Monthly Spending (Bar Chart) -->
    <div class="col-lg-6">
        <div class="card card-flush h-100">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">MONTHLY SPENDING</h3>
            </div>
            <div class="card-body">
                <div id="chart-customer-spending" style="height: 280px;"></div>
            </div>
        </div>
    </div>
    <!-- Order Status Distribution (Pie Chart) -->
    <div class="col-lg-6">
        <div class="card card-flush h-100">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">ORDER STATUS BREAKDOWN</h3>
            </div>
            <div class="card-body">
                <div id="chart-customer-status" style="height: 280px;"></div>
            </div>
        </div>
    </div>
</div>

<!--begin::Order Frequency Chart-->
<div class="row g-6 mt-2">
    <div class="col-12">
        <div class="card card-flush">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">MONTHLY ORDER FREQUENCY</h3>
            </div>
            <div class="card-body">
                <div id="chart-order-frequency" style="height: 250px;"></div>
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

    // Chart 1: Monthly Spending
    const spendingData = @json($monthlySpending);
    const spendingLabels = Object.keys(spendingData);
    const spendingValues = Object.values(spendingData);

    new ApexCharts(document.getElementById('chart-customer-spending'), {
        chart: { type: 'bar', height: 280, toolbar: { show: false }, background: 'transparent' },
        series: [{ name: 'Amount (₦)', data: spendingValues }],
        colors: ['#ff8c00'],
        plotOptions: { bar: { borderRadius: 6, columnWidth: '50%' } },
        dataLabels: { enabled: false },
        xaxis: { categories: spendingLabels, labels: { style: { colors: textColor } }, axisBorder: { show: false } },
        yaxis: { labels: { style: { colors: textColor }, formatter: v => '₦' + Number(v).toLocaleString() } },
        grid: { borderColor: gridColor, strokeDashArray: 4 },
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.9, opacityTo: 0.5, stops: [0, 100] } },
        tooltip: { theme: isDark ? 'dark' : 'light', y: { formatter: v => '₦' + Number(v).toLocaleString() } }
    }).render();

    // Chart 2: Order Status (Pie)
    const statusData = @json($ordersByStatus);
    const statusLabels = Object.keys(statusData).map(s => s.charAt(0).toUpperCase() + s.slice(1));
    const statusValues = Object.values(statusData);
    const statusColors = { 'Pending':'#00a8ff', 'Transit':'#ff8c00', 'Delivered':'#15c552', 'Cancelled':'#f13848' };
    const statusPieColors = statusLabels.map(l => statusColors[l] || '#888');

    new ApexCharts(document.getElementById('chart-customer-status'), {
        chart: { type: 'donut', height: 280, background: 'transparent' },
        series: statusValues,
        labels: statusLabels,
        colors: statusPieColors,
        legend: { position: 'bottom', labels: { colors: textColor } },
        dataLabels: { enabled: true, style: { colors: ['#fff'] }, formatter: (v) => Math.round(v) + '%' },
        stroke: { show: true, colors: [isDark ? '#141414' : '#fff'], width: 2 },
        tooltip: { theme: isDark ? 'dark' : 'light' }
    }).render();

    // Chart 3: Monthly Order Frequency (Line)
    const freqData = @json($monthlyOrderCount);
    const freqLabels = Object.keys(freqData);
    const freqValues = Object.values(freqData);

    new ApexCharts(document.getElementById('chart-order-frequency'), {
        chart: { type: 'area', height: 250, toolbar: { show: false }, background: 'transparent' },
        series: [{ name: 'Orders', data: freqValues }],
        colors: ['#15c552'],
        stroke: { curve: 'smooth', width: 3 },
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.3, opacityTo: 0.1, stops: [0, 100] } },
        dataLabels: { enabled: false },
        xaxis: { categories: freqLabels, labels: { style: { colors: textColor } }, axisBorder: { show: false } },
        yaxis: { labels: { style: { colors: textColor } }, tickAmount: 1 },
        grid: { borderColor: gridColor, strokeDashArray: 4 },
        tooltip: { theme: isDark ? 'dark' : 'light' }
    }).render();
});
</script>
@endpush
