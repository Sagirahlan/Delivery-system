@extends('layouts.metronic')

@section('title', 'Edit Order — ' . $order->tracking_number)
@section('body_class', 'aside-enabled')
@section('page_title', 'Edit Order')
@section('page_subtitle', $order->tracking_number)

@section('sidebar')
    @include('partials.admin-sidebar')
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="/" class="text-hover-primary" style="color: #94a3b8 !important; font-weight: 500; font-size: 1.1rem;">Home</a>
</li>
<li class="breadcrumb-item"><span style="color: #94a3b8; margin: 0 4px; font-weight: bold; font-size: 1.1rem;">-</span></li>
<li class="breadcrumb-item">
    <a href="{{ route('admin.orders.index') }}" class="text-hover-primary" style="color: #94a3b8 !important; font-weight: 500; font-size: 1.1rem;">Orders</a>
</li>
<li class="breadcrumb-item"><span style="color: #94a3b8; margin: 0 4px; font-weight: bold; font-size: 1.1rem;">-</span></li>
<li class="breadcrumb-item" style="color: #94a3b8; font-weight: 500; font-size: 1.1rem;">Edit</li>
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
    <i class="ki-duotone ki-cross-circle fs-2x text-danger me-3"><span class="path1"></span><span class="path2"></span></i>
    <div>
        @foreach ($errors->all() as $error)
        <div class="fs-6 fw-semibold">{{ $error }}</div>
        @endforeach
    </div>
</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-6">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-light">
        <i class="ki-duotone ki-arrow-left fs-3"><span class="path1"></span><span class="path2"></span></i> Back to Orders
    </a>
</div>

<div class="row g-6">
    <!--begin::Edit Form-->
    <div class="col-xl-8">
        <div class="card card-flush">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">UPDATE ORDER</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf

                    <!--begin::Order Summary-->
                    <div class="bg-light rounded p-5 mb-6">
                        <div class="row g-4">
                            <div class="col-sm-6">
                                <div class="fs-8 text-muted text-uppercase ls-1 mb-1">Tracking Number</div>
                                <div class="fs-5 fw-bold text-dark font-monospace">{{ $order->tracking_number }}</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="fs-8 text-muted text-uppercase ls-1 mb-1">Amount</div>
                                <div class="fs-5 fw-bold text-primary font-monospace">₦{{ number_format($order->amount, 2) }}</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="fs-8 text-muted text-uppercase ls-1 mb-1">Customer</div>
                                <div class="fs-6 text-dark">{{ $order->user?->name ?? '—' }}</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="fs-8 text-muted text-uppercase ls-1 mb-1">Package</div>
                                <div class="fs-6 text-dark">{{ $order->package_description }}</div>
                            </div>
                        </div>
                    </div>
                    <!--end::Order Summary-->

                    <!--begin::Status-->
                    <div class="mb-6">
                        <label class="form-label fw-semibold fs-6 required">Order Status</label>
                        <select name="status" class="form-select form-select-solid" required>
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>
                                🟡 Pending
                            </option>
                            <option value="transit" {{ $order->status === 'transit' ? 'selected' : '' }}>
                                🔵 In Transit
                            </option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>
                                🟢 Delivered
                            </option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>
                                🔴 Cancelled
                            </option>
                        </select>
                        <div class="form-text">Changing the status will notify the customer automatically.</div>
                    </div>
                    <!--end::Status-->

                    <!--begin::Actions-->
                    <div class="d-flex justify-content-end gap-3 pt-4">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ki-duotone ki-check fs-3"><span class="path1"></span><span class="path2"></span></i> Update Order
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
            </div>
        </div>
    </div>
    <!--end::Edit Form-->

    <!--begin::Sidebar Info-->
    <div class="col-xl-4">
        <!--begin::Route Card-->
        <div class="card card-flush mb-6">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">ROUTE</h3>
            </div>
            <div class="card-body">
                <div class="d-flex gap-4">
                    <div class="d-flex flex-column align-items-center mt-1">
                        <div class="w-10px h-10px rounded-circle bg-success"></div>
                        <div class="w-2px h-40px bg-gray-300"></div>
                        <div class="w-10px h-10px rounded-circle bg-danger"></div>
                    </div>
                    <div class="flex-grow-1 d-flex flex-column justify-content-between gap-3">
                        <div>
                            <div class="fs-8 text-muted text-uppercase">Pickup</div>
                            <div class="fs-7 text-dark">{{ $order->pickup_address }}</div>
                        </div>
                        <div>
                            <div class="fs-8 text-muted text-uppercase">Delivery</div>
                            <div class="fs-7 text-dark">{{ $order->delivery_address }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Route Card-->

        <!--begin::Agent Card-->
        <div class="card card-flush">
            <div class="card-header py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">ASSIGNED AGENT</h3>
            </div>
            <div class="card-body">
                @if($order->agent)
                <div class="d-flex align-items-center gap-3">
                    <div class="symbol symbol-40px">
                        <div class="symbol-label bg-light-success">
                            <i class="ki-duotone ki-user fs-3 text-success"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <div>
                        <div class="fs-6 fw-semibold text-dark">{{ $order->agent->name }}</div>
                        <div class="fs-7 text-muted">{{ $order->agent->email }}</div>
                    </div>
                </div>
                @else
                <div class="text-muted fs-7">No agent assigned</div>
                @endif

                @if($agents->count() > 0)
                <div class="separator my-4"></div>
                <div class="fs-8 text-muted text-uppercase ls-1 mb-2">Available Agents ({{ $agents->count() }})</div>
                <div class="d-flex flex-column gap-2">
                    @foreach($agents->take(5) as $agent)
                    <div class="d-flex align-items-center gap-2">
                        <span class="bullet bullet-dot bg-success"></span>
                        <span class="fs-7 text-dark">{{ $agent->name }}</span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        <!--end::Agent Card-->
    </div>
    <!--end::Sidebar Info-->
</div>
@endsection

@push('scripts')
<script>
    KTComponents.init();
</script>
@endpush
