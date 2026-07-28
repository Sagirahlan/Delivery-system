@extends('layouts.metronic')

@section('title', 'Order ' . $order->tracking_number)
@section('body_class', 'aside-enabled')
@section('page_title', 'Order Details')
@section('page_subtitle', $order->tracking_number)

@section('sidebar')
<div style="margin-top: 2rem;">
    <a class="menu-link mb-2" href="{{ route('dashboard.customer') }}" id="sidebar-orders" style="color:#bbb;border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-package fs-4" style="color:#64748b;"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <span>Orders</span>
    </a>
    <a class="menu-link mb-2" href="{{ route('orders.place') }}" id="sidebar-new-order" style="color:#bbb;border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-plus-circle fs-4" style="color:#64748b;"><span class="path1"></span><span class="path2"></span></i>
        <span>Place New Order</span>
    </a>
    <a class="menu-link mb-2" href="{{ route('tracking.map') }}" id="sidebar-tracking" style="color:#bbb;border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-geolocation fs-4" style="color:#64748b;"><span class="path1"></span><span class="path2"></span></i>
        <span>Live Tracking</span>
    </a>
    <a class="menu-link mb-2 active" href="{{ route('orders.history') }}" id="sidebar-history" style="color:#ff8c00;background:rgba(255,140,0,0.1);border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-clock fs-4" style="color:#ff8c00;"><span class="path1"></span><span class="path2"></span></i>
        <span>Order History</span>
    </a>
    <a class="menu-link mb-2" href="#" id="sidebar-settings" style="color:#bbb;border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-setting-2 fs-4" style="color:#64748b;"><span class="path1"></span><span class="path2"></span></i>
        <span>Settings</span>
    </a>
</div>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item text-muted"><a href="/" class="text-muted text-hover-primary">Home</a></li>
<li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
<li class="breadcrumb-item text-muted"><a href="{{ route('orders.history') }}" class="text-muted text-hover-primary">Order History</a></li>
<li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
<li class="breadcrumb-item text-muted">{{ $order->tracking_number }}</li>
@endsection

@section('container_class', 'container-xxl')

@section('content')
<div class="liquid-mesh-container">
<div class="liquid-mesh-bg"></div>

@if(session('success'))
<div class="alert alert-success d-flex align-items-center p-4 mb-6 rounded-4">
    <i class="ki-duotone ki-check-circle fs-2x text-success me-3"><span class="path1"></span><span class="path2"></span></i>
    <span class="fs-6 fw-semibold">{{ session('success') }}</span>
</div>
@endif

@include('partials.hammshop-promo')

<!--begin::Top Info Row-->
<div class="row g-6 mb-6">
    <!-- Order Info -->
    <div class="col-lg-8">
        <div class="liquid-glass-card">
            <div class="card-header d-flex justify-content-between align-items-center p-5 pb-0 border-0">
                <div class="d-flex align-items-center gap-3">
                    <div class="symbol symbol-45px">
                        <div class="symbol-label bg-light-primary d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-package fs-3 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="fw-bolder text-dark fs-4 mb-0">{{ $order->tracking_number }}</h3>
                        <span class="text-muted fs-7">Created {{ $order->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    @php
                        $badgeMap = ['pending'=>'badge-light-info','transit'=>'badge-light-warning','delivered'=>'badge-light-success','cancelled'=>'badge-light-danger'];
                        $dotColors = ['pending'=>'info','transit'=>'warning','delivered'=>'success','cancelled'=>'danger'];
                    @endphp
                    <span class="badge {{ $badgeMap[$order->status] }}">
                        <span class="bullet bullet-dot bg-{{ $dotColors[$order->status] }} fs-2x me-1"></span>
                        {{ ucfirst($order->status) }}
                    </span>
                    @if($order->payment_status !== 'paid')
                    <a href="{{ route('orders.payment.retry', $order->tracking_number) }}" class="btn btn-sm btn-warning d-inline-flex align-items-center gap-1">
                        <i class="ki-duotone ki-wallet fs-4"><span class="path1"></span><span class="path2"></span></i>
                        Retry Payment
                    </a>
                    @endif
                    <a href="{{ route('tracking.map', $order->tracking_number) }}" class="btn btn-sm btn-primary">
                        <i class="ki-duotone ki-geolocation fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>
                        Track
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Route Visualization -->
                <div class="d-flex align-items-start gap-4 mb-6 p-4 bg-light rounded">
                    <div class="d-flex flex-column align-items-center mt-1">
                        <div class="w-12px h-12px rounded-circle bg-success"></div>
                        <div class="w-2px h-60px bg-gradient-success-primary"></div>
                        <div class="w-12px h-12px rounded-circle bg-primary"></div>
                    </div>
                    <div class="flex-grow-1 d-flex flex-column justify-content-between gap-4">
                        <div>
                            <div class="fs-8 text-muted text-uppercase fw-semibold ls-1 mb-1">Pickup Address</div>
                            <div class="fs-6 text-dark fw-semibold">{{ $order->pickup_address }}</div>
                            @if($order->current_lat)
                            <div class="fs-8 text-muted mt-1">
                                📍 {{ number_format($order->current_lat, 6) }}, {{ number_format($order->current_lng, 6) }}
                            </div>
                            @endif
                        </div>
                        <div>
                            <div class="fs-8 text-muted text-uppercase fw-semibold ls-1 mb-1">Delivery Address</div>
                            <div class="fs-6 text-dark fw-semibold">{{ $order->delivery_address }}</div>
                        </div>
                    </div>
                </div>

                <!-- Details Grid -->
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="fs-8 text-muted text-uppercase fw-semibold ls-1 mb-1">Package</div>
                        <div class="fs-6 text-dark fw-semibold">{{ $order->package_description }}</div>
                        <div class="fs-8 text-muted mt-1">Size: {{ ucfirst($order->package_size) }} @if($order->is_fragile) • Fragile @endif</div>
                    </div>
                    <div class="col-sm-6 text-end">
                        <div class="fs-8 text-muted text-uppercase fw-semibold ls-1 mb-1">Amount</div>
                        <div class="fs-3 fw-bolder text-primary font-monospace">₦{{ number_format($order->amount, 2) }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="fs-8 text-muted text-uppercase fw-semibold ls-1 mb-1">Customer</div>
                        <div class="fs-6 text-dark fw-semibold">{{ $order->user?->name ?? '—' }}</div>
                        <div class="fs-8 text-muted mt-1">{{ $order->user?->email ?? '' }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="fs-8 text-muted text-uppercase fw-semibold ls-1 mb-1">Assigned Agent</div>
                        <div class="fs-6 text-dark fw-semibold">{{ $order->agent?->name ?? '<span class="text-muted">Not yet assigned</span>' }}</div>
                        @if($order->agent)
                        <div class="fs-8 text-muted mt-1">{{ $order->agent?->phone ?? '' }}</div>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <div class="fs-8 text-muted text-uppercase fw-semibold ls-1 mb-1">Order Date</div>
                        <div class="fs-6 text-dark fw-semibold">{{ $order->created_at->format('M d, Y \a\t h:i A') }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="fs-8 text-muted text-uppercase fw-semibold ls-1 mb-1">Last Updated</div>
                        <div class="fs-6 text-dark fw-semibold">{{ $order->updated_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Sidebar -->
    <div class="col-lg-4">
        <!-- Status Update (Admin/Agent only) -->
        @if($role === 'admin' || $role === 'agent')
        <div class="card card-flush mb-6">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark">UPDATE STATUS</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('orders.history.status', $order->tracking_number) }}">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-semibold fs-6">New Status</label>
                        <select name="status" class="form-select form-select-solid" required>
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="transit" {{ $order->status === 'transit' ? 'selected' : '' }}>In Transit</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ki-duotone ki-check fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>
                        Update Status
                    </button>
                </form>
            </div>
        </div>
        @endif

        <!-- Quick Actions -->
        <div class="card card-flush">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark">QUICK ACTIONS</h3>
            </div>
            <div class="card-body d-flex flex-column gap-2">
                <a href="{{ route('tracking.map', $order->tracking_number) }}" class="btn btn-light w-100 text-start">
                    <i class="ki-duotone ki-geolocation fs-4 me-2 text-primary"><span class="path1"></span><span class="path2"></span></i>
                    Track on Live Map
                </a>
                @if($order->status === 'pending' && $order->user_id === auth()->id())
                <form method="POST" action="{{ route('orders.cancel', $order->tracking_number) }}"
                      onsubmit="return confirm('Are you sure you want to cancel this order? This action cannot be undone.')">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100 text-start">
                        <i class="ki-duotone ki-cross-circle fs-4 me-2"><span class="path1"></span><span class="path2"></span></i>
                        Cancel This Order
                    </button>
                </form>
                @endif
                <a href="{{ route('orders.history') }}" class="btn btn-outline w-100 text-start">
                    <i class="ki-duotone ki-arrow-left fs-4 me-2"><span class="path1"></span><span class="path2"></span></i>
                    Back to History
                </a>
            </div>
        </div>
    </div>
</div>
<!--end::Top Info Row-->

<!--begin::Location History (if tracking data exists)-->
@if($order->locations->isNotEmpty())
<div class="card card-flush">
    <div class="card-header py-4">
        <h3 class="card-title fw-bolder text-dark">
            <i class="ki-duotone ki-map fs-4 me-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
            LOCATION HISTORY
            <span class="badge badge-light-primary ms-2">{{ $order->locations->count() }} records</span>
        </h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-row-dashed gy-4">
                <thead>
                    <tr class="fw-bold text-muted fs-7">
                        <th class="ps-6">#</th>
                        <th>Coordinates</th>
                        <th>Speed</th>
                        <th>Heading</th>
                        <th>Address Note</th>
                        <th>Recorded At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->locations->take(20) as $i => $loc)
                    <tr>
                        <td class="ps-6">
                            <span class="text-muted fs-7">{{ $i + 1 }}</span>
                        </td>
                        <td>
                            <span class="font-monospace text-dark fs-7">{{ number_format($loc->latitude, 6) }}, {{ number_format($loc->longitude, 6) }}</span>
                        </td>
                        <td>
                            <span class="text-dark fs-7">{{ $loc->speed }} km/h</span>
                        </td>
                        <td>
                            @if($loc->heading)
                            <span class="badge badge-light-info">{{ $loc->heading }}</span>
                            @else
                            <span class="text-muted fs-7">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-dark fs-7">{{ Str::limit($loc->address ?? '', 40) }}</span>
                        </td>
                        <td>
                            <span class="text-dark fs-7">{{ $loc->recorded_at->format('M d, h:i A') }}</span>
                            <div class="fs-8 text-muted">{{ $loc->recorded_at->diffForHumans() }}</div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@endsection
