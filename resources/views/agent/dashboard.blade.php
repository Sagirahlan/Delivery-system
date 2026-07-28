@extends('layouts.metronic')

@section('title', 'Agent Dashboard')
@section('body_class', 'aside-enabled')
@section('page_title', 'Agent Dashboard')
@section('page_subtitle', 'Manage your deliveries and availability')

@section('sidebar')
    @include('partials.role-sidebar')
@endsection

@section('breadcrumb')
<li class="breadcrumb-item text-muted">
    <a href="/" class="text-muted text-hover-primary">Home</a>
</li>
<li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
<li class="breadcrumb-item text-muted">Agent Dashboard</li>
@endsection

@section('container_class', 'container-xxl')

@section('content')
<!--begin::Header with Availability Toggle-->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-6 gap-3">
    <div>
        <h1 class="page-heading">AGENT DASHBOARD</h1>
        <p class="text-muted fs-6 mt-1">Manage your deliveries and availability.</p>
    </div>
    <div class="d-flex align-items-center gap-3">
        <span class="text-muted fs-6 fw-semibold">Availability</span>
        <label class="form-check form-switch form-check-custom form-check-solid">
            <input class="form-check-input" type="checkbox" value="1" id="availability-toggle" checked />
            <span class="form-check-label fw-semibold fs-7" id="availability-label">Online</span>
        </label>
    </div>
</div>
<!--end::Header-->

<!--begin::Stats Row-->
<div class="row g-6 mb-6">
    <!-- Today's Earnings -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-flush">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-45px me-4">
                        <div class="symbol-label bg-light-warning d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-wallet fs-3 text-warning">
                                <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                            </i>
                        </div>
                    </div>
                    <div>
                        <div class="text-muted fs-7 fw-semibold">Today's Earnings</div>
                        <div class="fs-3 fw-bolder text-dark font-monospace">₦{{ number_format($todayEarnings) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Deliveries Today -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-flush">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-45px me-4">
                        <div class="symbol-label bg-light-success d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-check-circle fs-3 text-success">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                        </div>
                    </div>
                    <div>
                        <div class="text-muted fs-7 fw-semibold">Deliveries Today</div>
                        <div class="fs-3 fw-bolder text-dark">{{ $todayCount }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Rating -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-flush">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-45px me-4">
                        <div class="symbol-label bg-light-info d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-star fs-3 text-info">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                        </div>
                    </div>
                    <div>
                        <div class="text-muted fs-7 fw-semibold">Rating</div>
                        <div class="fs-3 fw-bolder text-dark d-flex align-items-center gap-1">
                            4.8 <i class="ki-duotone ki-star fs-5 text-warning">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Stats Row-->

<!--begin::Main Content Grid-->
<div class="row g-6">
    <!-- Left: Active Delivery & History -->
    <div class="col-lg-8"        <!--begin::Active Delivery Card-->
        <div class="card card-flush mb-6">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <span class="bullet bullet-dot {{ $activeOrder ? 'bg-warning pulse' : 'bg-gray-400' }} fs-2x"></span>
                    <h3 class="card-title fw-bolder text-dark fs-4">ACTIVE DELIVERY</h3>
                </div>
                @if($activeOrder)
                <span class="font-monospace text-muted fs-8">#{{ $activeOrder->tracking_number }}</span>
                @endif
            </div>
            <div class="card-body">
                @if($activeOrder)
                <!-- Route Info -->
                <div class="row g-4 mb-6">
                    <div class="col-sm-6">
                        <div class="bg-light rounded p-4">
                            <div class="d-flex align-items-center gap-1 mb-2">
                                <i class="ki-duotone ki-geolocation fs-6 text-success">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                <span class="fs-8 text-muted text-uppercase fw-semibold ls-1">Pickup</span>
                            </div>
                            <div class="fs-6 text-dark fw-semibold">{{ $activeOrder->pickup_address }}</div>
                            <div class="fs-8 text-muted mt-1">Contact: {{ $activeOrder->pickup_contact ?? 'N/A' }} — {{ $activeOrder->pickup_phone ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="bg-light rounded p-4">
                            <div class="d-flex align-items-center gap-1 mb-2">
                                <i class="ki-duotone ki-map fs-6 text-primary">
                                    <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                                </i>
                                <span class="fs-8 text-muted text-uppercase fw-semibold ls-1">Drop-off</span>
                            </div>
                            <div class="fs-6 text-dark fw-semibold">{{ $activeOrder->delivery_address }}</div>
                            <div class="fs-8 text-muted mt-1">Contact: {{ $activeOrder->delivery_contact ?? 'N/A' }} — {{ $activeOrder->delivery_phone ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Package Info -->
                <div class="d-flex align-items-center gap-4 mb-6 bg-light rounded p-4">
                    <div class="symbol symbol-50px">
                        <div class="symbol-label bg-light-warning d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-package fs-2 text-warning">
                                <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                            </i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fs-6 text-dark fw-semibold">{{ $activeOrder->package_description }}</div>
                        <div class="fs-8 text-muted text-capitalize">{{ $activeOrder->package_size }} size @if($activeOrder->is_fragile) • Fragile @endif</div>
                    </div>
                    <div class="fs-4 fw-bolder text-warning font-monospace">₦{{ number_format($activeOrder->amount) }}</div>
                </div>

                <!-- Status Update Buttons -->
                <div class="d-flex flex-column gap-2">
                    @if($activeOrder->status === 'pending')
                    <form action="{{ route('agent.orders.status', $activeOrder->tracking_number) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="transit">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="ki-duotone ki-hand fs-3"><span class="path1"></span><span class="path2"></span></i>
                            Confirm Pickup & Start Transit
                        </button>
                    </form>
                    @elseif($activeOrder->status === 'transit')
                    <form action="{{ route('agent.orders.status', $activeOrder->tracking_number) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="delivered">
                        <button type="submit" class="btn btn-warning btn-lg w-100">
                            <i class="ki-duotone ki-check-circle fs-3"><span class="path1"></span><span class="path2"></span></i>
                            Mark as Delivered
                        </button>
                    </form>
                    @endif
                </div>
                @else
                <div class="text-center py-10">
                    <i class="ki-duotone ki-delivery-3 fs-5x text-muted mb-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                    <h3 class="fs-4 fw-bolder text-dark mb-2">No Active Delivery</h3>
                    <p class="fs-6 text-muted">You are currently available for new orders. Check the "Available Orders" section below.</p>
                </div>
                @endif
            </div>
        </div>
        <!--end::Active Delivery Card-->

        <!--begin::Available Orders Pool-->
        <div class="card card-flush mb-6">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark fs-4 d-flex align-items-center gap-2">
                    <i class="ki-duotone ki-notification-on fs-4 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                    NEW ORDERS AVAILABLE
                </h3>
            </div>
            <div class="card-body p-0">
                @if($errors->has('accept'))
                <div class="alert alert-warning d-flex align-items-center m-4 mb-0 p-4 rounded-3">
                    <i class="ki-duotone ki-information-2 fs-2x text-warning me-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                    <span class="fs-6 fw-semibold">{{ $errors->first('accept') }}</span>
                </div>
                @endif

                @if($activeOrder)
                <div class="d-flex align-items-center gap-3 bg-light-warning rounded m-4 p-4">
                    <i class="ki-duotone ki-lock-2 fs-2x text-warning"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                    <div>
                        <div class="fs-6 fw-bold text-dark">You have an active delivery</div>
                        <div class="fs-7 text-muted">Complete order <span class="font-monospace fw-semibold">#{{ $activeOrder->tracking_number }}</span> before accepting a new one.</div>
                    </div>
                    <a href="{{ route('tracking.map', $activeOrder->tracking_number) }}" class="btn btn-sm btn-warning ms-auto">
                        <i class="ki-duotone ki-geolocation fs-4"><span class="path1"></span><span class="path2"></span></i>
                        View Map
                    </a>
                </div>
                @endif

                <div class="d-flex flex-column">
                    @forelse($availableOrders as $order)
                    <div class="d-flex flex-column p-5 border-bottom border-dashed">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="fs-8 font-monospace text-muted">#{{ $order->tracking_number }}</span>
                                <div class="fs-6 fw-bold text-dark">{{ $order->package_description }}</div>
                            </div>
                            <div class="text-end">
                                <div class="fs-4 fw-bolder text-primary font-monospace">₦{{ number_format($order->amount) }}</div>
                                <div class="fs-9 text-muted">{{ $order->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div class="d-flex gap-3 mb-4">
                            <div class="flex-grow-1 bg-light rounded p-3">
                                <div class="fs-9 text-muted text-uppercase ls-1">From</div>
                                <div class="fs-7 text-dark truncate">{{ $order->pickup_address }}</div>
                            </div>
                            <div class="flex-grow-1 bg-light rounded p-3">
                                <div class="fs-9 text-muted text-uppercase ls-1">To</div>
                                <div class="fs-7 text-dark truncate">{{ $order->delivery_address }}</div>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            @if($activeOrder)
                            <button type="button" class="btn btn-sm btn-light-secondary w-100 flex-grow-1" disabled title="Complete your active delivery first">
                                <i class="ki-duotone ki-lock-2 fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                Locked
                            </button>
                            @else
                            <form action="{{ route('agent.orders.accept', $order->tracking_number) }}" method="POST" class="flex-grow-1">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-light-success w-100">Accept Order</button>
                            </form>
                            <form action="{{ route('agent.orders.reject', $order->tracking_number) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-light w-40px" title="Ignore">
                                    <i class="ki-duotone ki-cross fs-3 p-0"><span class="path1"></span><span class="path2"></span></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10 px-5">
                        <div class="fs-6 text-muted">No new orders available at the moment.</div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        <!--end::Available Orders Pool-->ry Card-->

        <!--begin::Today's Deliveries Card-->
        <div class="card card-flush">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">TODAY'S DELIVERIES</h3>
            </div>
            <div class="card-body p-0">
                <div class="d-flex flex-column">
                    <!-- Delivery 1 -->
                    <div class="d-flex align-items-center justify-content-between px-4 py-3 hover-elevate-up">
                        <div class="d-flex align-items-center gap-3">
                            <div class="symbol symbol-35px">
                                <div class="symbol-label bg-light-success">
                                    <i class="ki-duotone ki-check fs-3 text-success">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                </div>
                            </div>
                            <div>
                                <div class="fs-6 text-dark fw-semibold">Documents Envelope</div>
                                <div class="fs-8 text-muted">BUK Road → Nassarawa GRA</div>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="font-monospace fs-6 fw-bold text-success">₦1,200</div>
                            <div class="fs-9 text-muted">11:42 AM</div>
                        </div>
                    </div>
                    <!-- Delivery 2 -->
                    <div class="d-flex align-items-center justify-content-between px-4 py-3 hover-elevate-up">
                        <div class="d-flex align-items-center gap-3">
                            <div class="symbol symbol-35px">
                                <div class="symbol-label bg-light-success">
                                    <i class="ki-duotone ki-check fs-3 text-success">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                </div>
                            </div>
                            <div>
                                <div class="fs-6 text-dark fw-semibold">Clothing Package</div>
                                <div class="fs-8 text-muted">Tarauni → Gwale</div>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="font-monospace fs-6 fw-bold text-success">₦800</div>
                            <div class="fs-9 text-muted">10:15 AM</div>
                        </div>
                    </div>
                    <!-- Delivery 3 -->
                    <div class="d-flex align-items-center justify-content-between px-4 py-3 hover-elevate-up">
                        <div class="d-flex align-items-center gap-3">
                            <div class="symbol symbol-35px">
                                <div class="symbol-label bg-light-success">
                                    <i class="ki-duotone ki-check fs-3 text-success">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                </div>
                            </div>
                            <div>
                                <div class="fs-6 text-dark fw-semibold">Food Package</div>
                                <div class="fs-8 text-muted">Sabon Gari → Fagge</div>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="font-monospace fs-6 fw-bold text-success">₦600</div>
                            <div class="fs-9 text-muted">9:30 AM</div>
                        </div>
                    </div>
                    <!-- Delivery 4 -->
                    <div class="d-flex align-items-center justify-content-between px-4 py-3 hover-elevate-up">
                        <div class="d-flex align-items-center gap-3">
                            <div class="symbol symbol-35px">
                                <div class="symbol-label bg-light-success">
                                    <i class="ki-duotone ki-check fs-3 text-success">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                </div>
                            </div>
                            <div>
                                <div class="fs-6 text-dark fw-semibold">Medical Supplies</div>
                                <div class="fs-8 text-muted">Kofar Mata → Dorayi</div>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="font-monospace fs-6 fw-bold text-success">₦1,400</div>
                            <div class="fs-9 text-muted">8:05 AM</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Today's Deliveries Card-->
    </div>

    <!-- Right: Earnings & Profile Sidebar -->
    <div class="col-lg-4">
        <div class="d-flex flex-column gap-6">
            <!-- Earnings Card -->
            <div class="card card-flush">
                <div class="card-header">
                    <h3 class="card-title fw-bolder text-dark">EARNINGS SUMMARY</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-4">
                        <div class="bg-light rounded p-4 text-center">
                            <div class="fs-8 text-muted text-uppercase ls-1 mb-1">This Week</div>
                            <div class="fs-2 fw-bolder text-warning font-monospace">₦24,600</div>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="bg-light rounded p-3 text-center">
                                    <div class="font-monospace fs-4 fw-bold text-dark">28</div>
                                    <div class="fs-9 text-muted text-uppercase">Deliveries</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-light rounded p-3 text-center">
                                    <div class="font-monospace fs-4 fw-bold text-dark">₦879</div>
                                    <div class="fs-9 text-muted text-uppercase">Avg / Order</div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column gap-2 pt-2">
                            <div class="d-flex justify-content-between fs-7">
                                <span class="text-muted">This Month</span>
                                <span class="font-monospace text-dark fw-semibold">₦86,200</span>
                            </div>
                            <div class="d-flex justify-content-between fs-7">
                                <span class="text-muted">Total Deliveries</span>
                                <span class="font-monospace text-dark fw-semibold">342</span>
                            </div>
                            <div class="d-flex justify-content-between fs-7">
                                <span class="text-muted">Success Rate</span>
                                <span class="font-monospace text-success fw-semibold">98.5%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Agent Profile Card -->
            <div class="card card-flush">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="symbol symbol-55px">
                            <div class="symbol-label bg-primary bg-opacity-25 d-flex align-items-center justify-content-center">
                                <span class="fs-2 fw-bolder text-primary">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="overflow-hidden">
                            <div class="fs-5 text-dark fw-semibold truncate">{{ Auth::user()->name }}</div>
                            <div class="fs-8 text-muted truncate">{{ Auth::user()->phone ?? 'No phone number' }}</div>
                            <div class="d-flex align-items-center gap-1 mt-0.5">
                                <i class="ki-duotone ki-star fs-8 text-warning">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                <i class="ki-duotone ki-star fs-8 text-warning">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                <i class="ki-duotone ki-star fs-8 text-warning">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                <i class="ki-duotone ki-star fs-8 text-warning">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                <i class="ki-duotone ki-star-half fs-8 text-warning">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                <span class="fs-8 text-muted ms-1">4.8</span>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="btn btn-outline btn-sm w-100">
                        <i class="ki-duotone ki-pencil fs-4">
                            <span class="path1"></span><span class="path2"></span>
                        </i>
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Main Content Grid-->

<!--begin::Charts Row-->
<div class="row g-6 mt-2">
    <!-- Weekly Deliveries (Bar Chart) -->
    <div class="col-lg-6">
        <div class="card card-flush h-100">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">THIS WEEK'S DELIVERIES</h3>
            </div>
            <div class="card-body">
                <div id="chart-agent-weekly" style="height: 280px;"></div>
            </div>
        </div>
    </div>
    <!-- Order Status Distribution (Pie Chart) -->
    <div class="col-lg-6">
        <div class="card card-flush h-100">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">DELIVERY STATUS</h3>
            </div>
            <div class="card-body">
                <div id="chart-agent-status" style="height: 280px;"></div>
            </div>
        </div>
    </div>
</div>

<!--begin::Monthly Earnings Chart-->
<div class="row g-6 mt-2">
    <div class="col-12">
        <div class="card card-flush">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">MONTHLY EARNINGS TREND</h3>
            </div>
            <div class="card-body">
                <div id="chart-agent-earnings" style="height: 250px;"></div>
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

    // Chart 1: Weekly Deliveries
    const weeklyData = @json($weeklyDeliveries);
    const weeklyLabels = Object.keys(weeklyData);
    const weeklyValues = Object.values(weeklyData);

    new ApexCharts(document.getElementById('chart-agent-weekly'), {
        chart: { type: 'bar', height: 280, toolbar: { show: false }, background: 'transparent' },
        series: [{ name: 'Deliveries', data: weeklyValues }],
        colors: ['#ff8c00'],
        plotOptions: { bar: { borderRadius: 6, columnWidth: '50%' } },
        dataLabels: { enabled: true, style: { colors: ['#fff'] }, formatter: v => v },
        xaxis: { categories: weeklyLabels, labels: { style: { colors: textColor } }, axisBorder: { show: false } },
        yaxis: { labels: { style: { colors: textColor } }, tickAmount: 1 },
        grid: { borderColor: gridColor, strokeDashArray: 4 },
        tooltip: { theme: isDark ? 'dark' : 'light' }
    }).render();

    // Chart 2: Status Distribution (Pie)
    const agentStatusData = @json($statusDistribution);
    const agentStatusLabels = Object.keys(agentStatusData).map(s => s.charAt(0).toUpperCase() + s.slice(1));
    const agentStatusValues = Object.values(agentStatusData);
    const agentStatusColors = { 'Pending':'#00a8ff', 'Transit':'#ff8c00', 'Delivered':'#15c552', 'Cancelled':'#f13848' };
    const agentPieColors = agentStatusLabels.map(l => agentStatusColors[l] || '#888');

    new ApexCharts(document.getElementById('chart-agent-status'), {
        chart: { type: 'donut', height: 280, background: 'transparent' },
        series: agentStatusValues,
        labels: agentStatusLabels,
        colors: agentPieColors,
        legend: { position: 'bottom', labels: { colors: textColor } },
        dataLabels: { enabled: true, style: { colors: ['#fff'] }, formatter: (v) => Math.round(v) + '%' },
        stroke: { show: true, colors: [isDark ? '#141414' : '#fff'], width: 2 },
        tooltip: { theme: isDark ? 'dark' : 'light' }
    }).render();

    // Chart 3: Monthly Earnings (Area)
    const earningsData = @json($monthlyEarnings);
    const earningsLabels = Object.keys(earningsData);
    const earningsValues = Object.values(earningsData);

    new ApexCharts(document.getElementById('chart-agent-earnings'), {
        chart: { type: 'area', height: 250, toolbar: { show: false }, background: 'transparent' },
        series: [{ name: 'Earnings (₦)', data: earningsValues }],
        colors: ['#15c552'],
        stroke: { curve: 'smooth', width: 3 },
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.35, opacityTo: 0.1, stops: [0, 100] } },
        dataLabels: { enabled: false },
        xaxis: { categories: earningsLabels, labels: { style: { colors: textColor } }, axisBorder: { show: false } },
        yaxis: { labels: { style: { colors: textColor }, formatter: v => '₦' + Number(v).toLocaleString() } },
        grid: { borderColor: gridColor, strokeDashArray: 4 },
        tooltip: { theme: isDark ? 'dark' : 'light', y: { formatter: v => '₦' + Number(v).toLocaleString() } }
    }).render();
});

// Availability toggle
document.getElementById('availability-toggle')?.addEventListener('change', function() {
    const label = document.getElementById('availability-label');
    if (this.checked) {
        label.textContent = 'Online';
        label.classList.remove('text-muted');
        label.classList.add('text-success');
    } else {
        label.textContent = 'Offline';
        label.classList.remove('text-success');
        label.classList.add('text-muted');
    }
});
</script>
@endpush
