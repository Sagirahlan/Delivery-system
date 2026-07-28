@extends('layouts.metronic')

@section('title', 'Order Details — ' . $order->tracking_number)
@section('body_class', 'aside-enabled')
@section('page_title', 'Order Details')
@section('page_subtitle', $order->tracking_number)

@section('sidebar')
    @include('partials.agent-sidebar')
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="/" class="text-hover-primary" style="color: #94a3b8 !important; font-weight: 500; font-size: 1.1rem;">Home</a>
</li>
<li class="breadcrumb-item"><span style="color: #94a3b8; margin: 0 4px; font-weight: bold; font-size: 1.1rem;">-</span></li>
<li class="breadcrumb-item">
    <a href="{{ route('agent.orders') }}" class="text-hover-primary" style="color: #94a3b8 !important; font-weight: 500; font-size: 1.1rem;">Assigned Orders</a>
</li>
<li class="breadcrumb-item"><span style="color: #94a3b8; margin: 0 4px; font-weight: bold; font-size: 1.1rem;">-</span></li>
<li class="breadcrumb-item" style="color: #94a3b8; font-weight: 500; font-size: 1.1rem;">{{ $order->tracking_number }}</li>
@endsection

@section('container_class', 'container-xxl')

@section('content')
@if(session('success'))
<div class="alert alert-success d-flex align-items-center p-4 mb-6">
    <i class="ki-duotone ki-check-circle fs-2x text-success me-3"><span class="path1"></span><span class="path2"></span></i>
    <span class="fs-6 fw-semibold">{{ session('success') }}</span>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger d-flex align-items-center p-4 mb-6">
    <i class="ki-duotone ki-information fs-2x text-danger me-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
    <div>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li class="fs-6 fw-semibold">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-6">
    <a href="{{ route('agent.orders') }}" class="btn btn-sm btn-light">
        <i class="ki-duotone ki-arrow-left fs-3"><span class="path1"></span><span class="path2"></span></i> Back to Orders
    </a>
    <a href="{{ route('tracking.map', $order->tracking_number) }}" class="btn btn-sm btn-primary">
        <i class="ki-duotone ki-geolocation fs-3"><span class="path1"></span><span class="path2"></span></i> Live Tracking Map
    </a>
</div>

<div class="row g-6">
    <!--begin::Order Info-->
    <div class="col-xl-8">
        <div class="card card-flush mb-6">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">ORDER INFORMATION</h3>
                @php
                    $badgeMap = ['pending'=>'badge-light-info','transit'=>'badge-light-warning','delivered'=>'badge-light-success','cancelled'=>'badge-light-danger'];
                    $dotColors = ['pending'=>'info','transit'=>'warning','delivered'=>'success','cancelled'=>'danger'];
                @endphp
                <div class="card-toolbar">
                    <span class="badge {{ $badgeMap[$order->status] ?? 'badge-light-secondary' }} fs-7">
                        <span class="bullet bullet-dot bg-{{ $dotColors[$order->status] ?? 'secondary' }} fs-2x me-1"></span>
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-5">
                    <div class="col-sm-6">
                        <div class="fs-8 text-muted text-uppercase ls-1 mb-1">Tracking Number</div>
                        <div class="fs-5 fw-bold text-dark font-monospace">{{ $order->tracking_number }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="fs-8 text-muted text-uppercase ls-1 mb-1">Amount to Collect</div>
                        <div class="fs-5 fw-bold text-primary font-monospace">₦{{ number_format($order->amount, 2) }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="fs-8 text-muted text-uppercase ls-1 mb-1">Package Description</div>
                        <div class="fs-6 text-dark">{{ $order->package_description }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="fs-8 text-muted text-uppercase ls-1 mb-1">Date Assigned</div>
                        <div class="fs-6 text-dark">{{ $order->created_at->format('M d, Y \a\t g:i A') }}</div>
                    </div>
                </div>

                <div class="separator my-5"></div>

                <!--begin::Route-->
                <div class="d-flex gap-4">
                    <div class="d-flex flex-column align-items-center mt-1">
                        <div class="w-12px h-12px rounded-circle bg-success"></div>
                        <div class="w-2px h-50px bg-gray-300"></div>
                        <div class="w-12px h-12px rounded-circle bg-danger"></div>
                    </div>
                    <div class="flex-grow-1 d-flex flex-column justify-content-between gap-4">
                        <div>
                            <div class="fs-8 text-muted text-uppercase ls-1">Pickup Address</div>
                            <div class="fs-6 fw-semibold text-dark">{{ $order->pickup_address }}</div>
                        </div>
                        <div>
                            <div class="fs-8 text-muted text-uppercase ls-1">Delivery Address</div>
                            <div class="fs-6 fw-semibold text-dark">{{ $order->delivery_address }}</div>
                        </div>
                    </div>
                </div>
                <!--end::Route-->

                @if($order->estimated_arrival)
                <div class="separator my-5"></div>
                <div>
                    <div class="fs-8 text-muted text-uppercase ls-1 mb-1">Estimated Arrival</div>
                    <div class="fs-6 fw-semibold text-dark">{{ $order->estimated_arrival->format('M d, Y \a\t g:i A') }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <!--end::Order Info-->

    <!--begin::Sidebar-->
    <div class="col-xl-4">
        <!--begin::Quick Actions-->
        <div class="card card-flush mb-6 border border-primary">
            <div class="card-header py-4 bg-light-primary rounded-top">
                <h3 class="card-title fw-bolder text-primary fs-4">UPDATE STATUS</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('agent.orders.status', $order->tracking_number) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted fs-7 text-uppercase">Current Status</label>
                        <select name="status" class="form-select form-select-solid">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="transit" {{ $order->status === 'transit' ? 'selected' : '' }}>In Transit</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ki-duotone ki-check fs-3"><span class="path1"></span><span class="path2"></span></i>
                        Save Status
                    </button>
                </form>
            </div>
        </div>
        <!--end::Quick Actions-->

        <!--begin::Customer Card-->
        <div class="card card-flush">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">CUSTOMER</h3>
            </div>
            <div class="card-body">
                @if($order->user)
                <div class="d-flex align-items-center gap-3">
                    <div class="symbol symbol-45px">
                        <div class="symbol-label bg-light-primary">
                            <i class="ki-duotone ki-profile-circle fs-1 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        </div>
                    </div>
                    <div>
                        <div class="fs-6 fw-semibold text-dark">{{ $order->user->name }}</div>
                        <div class="fs-7 text-muted">{{ $order->user->email }}</div>
                        @if($order->user->phone)
                        <div class="fs-7 text-muted">{{ $order->user->phone }}</div>
                        @endif
                    </div>
                </div>
                @else
                <span class="text-muted">No customer info</span>
                @endif
            </div>
        </div>
        <!--end::Customer Card-->
    </div>
    <!--end::Sidebar-->
</div>
@endsection

@push('scripts')
<script>
    KTComponents.init();
</script>
@endpush
