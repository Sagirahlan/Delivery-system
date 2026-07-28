@extends('layouts.metronic')

@section('title', 'Order History')
@section('body_class', 'aside-enabled')
@section('page_title', 'Order History')
@section('page_subtitle', 'View and manage all your orders')

@section('sidebar')
    @include('partials.role-sidebar')
@endsection

@section('breadcrumb')
<li class="breadcrumb-item text-muted"><a href="/" class="text-muted text-hover-primary">Home</a></li>
<li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
<li class="breadcrumb-item text-muted">Order History</li>
@endsection

@section('container_class', 'container-xxl')

@section('content')
<div class="liquid-mesh-container">
<div class="liquid-mesh-bg"></div>

@include('partials.hammshop-promo')

<!--begin::Stats Row-->
<div class="row g-6 mb-6">
    <div class="col-sm-6 col-lg-3">
        <div class="liquid-glass-card p-4">
            <div class="card-body p-0">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-40px me-3">
                        <div class="symbol-label bg-light-info d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-package fs-4 text-info"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-muted fs-7 fw-semibold">Total Orders</div>
                        <div class="fs-4 fw-bolder text-dark">{{ $stats['total'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="liquid-glass-card p-4">
            <div class="card-body p-0">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-40px me-3">
                        <div class="symbol-label bg-light-warning d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-hourglass fs-4 text-warning"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-muted fs-7 fw-semibold">In Transit</div>
                        <div class="fs-4 fw-bolder text-dark">{{ $stats['transit'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="liquid-glass-card p-4">
            <div class="card-body p-0">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-40px me-3">
                        <div class="symbol-label bg-light-success d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-check-circle fs-4 text-success"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-muted fs-7 fw-semibold">Delivered</div>
                        <div class="fs-4 fw-bolder text-dark">{{ $stats['delivered'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="liquid-glass-card p-4">
            <div class="card-body p-0">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-40px me-3">
                        <div class="symbol-label bg-light-danger d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-cross-circle fs-4 text-danger"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-muted fs-7 fw-semibold">Cancelled</div>
                        <div class="fs-4 fw-bolder text-dark">{{ $stats['cancelled'] }}</div>
                    </div>
</div>
<!--end::Stats Row-->

<!--begin::Filters Card-->
<div class="liquid-glass-card mb-6">
    <div class="card-header p-5 pb-0 border-0">
        <h3 class="card-title fw-bolder text-dark fs-4 mb-0">
            <i class="ki-duotone ki-filter fs-4 me-2 text-primary"><span class="path1"></span><span class="path2"></span></i>
            Filter Orders
        </h3>
    </div>
    <div class="card-body p-5">
        <form method="GET" action="{{ route('orders.history') }}" class="row g-3">
            <!-- Search -->
            <div class="col-md-3">
                <label class="form-label fw-semibold fs-6">Search</label>
                <input type="text" name="search" class="form-control form-control-solid" placeholder="Tracking #, description, address..." value="{{ $search ?? '' }}">
            </div>
            <!-- Status -->
            <div class="col-md-2">
                <label class="form-label fw-semibold fs-6">Status</label>
                <select name="status" class="form-select form-select-solid">
                    <option value="all" {{ ($status ?? '') === 'all' ? 'selected' : '' }}>All</option>
                    <option value="pending" {{ ($status ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="transit" {{ ($status ?? '') === 'transit' ? 'selected' : '' }}>In Transit</option>
                    <option value="delivered" {{ ($status ?? '') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ ($status ?? '') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <!-- Date From -->
            <div class="col-md-2">
                <label class="form-label fw-semibold fs-6">From Date</label>
                <input type="date" name="date_from" class="form-control form-control-solid" value="{{ $dateFrom ?? '' }}">
            </div>
            <!-- Date To -->
            <div class="col-md-2">
                <label class="form-label fw-semibold fs-6">To Date</label>
                <input type="date" name="date_to" class="form-control form-control-solid" value="{{ $dateTo ?? '' }}">
            </div>
            <!-- Buttons -->
            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">
                    <i class="ki-duotone ki-search fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>
                    Filter
                </button>
                <a href="{{ route('orders.history') }}" class="btn btn-outline">
                    <i class="ki-duotone ki-cross fs-4"><span class="path1"></span><span class="path2"></span></i>
                </a>
            </div>
        </form>
    </div>
</div>
<!--end::Filters Card-->

@if(session('success'))
<div class="alert alert-success d-flex align-items-center p-4 mb-6">
    <i class="ki-duotone ki-check-circle fs-2x text-success me-3"><span class="path1"></span><span class="path2"></span></i>
    <span class="fs-6 fw-semibold">{{ session('success') }}</span>
</div>
@endif

<!--begin::Orders Table Card-->
<div class="liquid-glass-card">
    <div class="card-header d-flex justify-content-between align-items-center p-5 pb-0 border-0">
        <h3 class="card-title fw-bolder text-dark fs-4 mb-0">
            ORDERS
            <span class="liquid-badge liquid-badge-primary ms-2">{{ $orders->total() }}</span>
        </h3>
        <a href="{{ route('orders.place') }}" class="liquid-glass-btn-primary btn-sm d-inline-flex align-items-center">
            <i class="ki-duotone ki-plus fs-3 me-1"><span class="path1"></span><span class="path2"></span></i>
            New Order
        </a>
    </div>
    <div class="card-body p-5">
        @if($orders->isEmpty())
            <div class="text-center py-16">
                <div class="symbol symbol-80px mx-auto mb-5">
                    <div class="symbol-label bg-light d-flex align-items-center justify-content-center">
                        <i class="ki-duotone ki-package fs-1 text-muted"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                    </div>
                </div>
                <h4 class="fw-bolder text-dark mb-2">No Orders Found</h4>
                <p class="text-muted fs-6 mb-5">
                    @if($search || $status)
                        Try adjusting your filters.
                    @else
                        You haven't placed any orders yet.
                    @endif
                </p>
                @if(!($search || $status))
                <a href="{{ route('orders.place') }}" class="btn btn-primary">
                    <i class="ki-duotone ki-plus fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>
                    Place Your First Order
                </a>
                @endif
            </div>
        @else
        <div class="table-responsive">
            <table class="table table-row-dashed gy-5 align-middle">
                <thead>
                    <tr class="fw-bold text-muted fs-7">
                        <th class="min-w-100px">Tracking #</th>
                        <th class="min-w-120px">Package</th>
                        <th class="min-w-180px">Route</th>
                        @if($role === 'admin')
                        <th class="min-w-100px">Customer</th>
                        <th class="min-w-100px">Agent</th>
                        @endif
                        <th class="min-w-80px">Amount</th>
                        <th class="min-w-100px">Status</th>
                        <th class="min-w-100px">Date</th>
                        <th class="min-w-80px text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr class="hover-elevate-up">
                        <td>
                            <span class="font-monospace text-dark fw-bold fs-7">{{ $order->tracking_number }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="symbol symbol-30px">
                                    <div class="symbol-label bg-light-{{ $order->package_size === 'small' ? 'success' : ($order->package_size === 'medium' ? 'warning' : 'danger') }}">
                                        <i class="ki-duotone ki-package fs-3 text-{{ $order->package_size === 'small' ? 'success' : ($order->package_size === 'medium' ? 'warning' : 'danger') }}">
                                            <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                                        </i>
                                    </div>
                                </div>
                                <div>
                                    <div class="fs-7 text-dark fw-semibold text-truncate" style="max-width:180px;">{{ Str::limit($order->package_description, 25) }}</div>
                                    <div class="fs-8 text-muted text-uppercase">{{ $order->package_size }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fs-7 text-dark"><span class="bullet bullet-dot bg-success fs-2x me-1"></span>{{ Str::limit($order->pickup_address, 20) }}</span>
                                <span class="fs-7 text-muted mt-1"><span class="bullet bullet-dot bg-primary fs-2x me-1"></span>{{ Str::limit($order->delivery_address, 20) }}</span>
                            </div>
                        </td>
                        @if($role === 'admin')
                        <td>
                            <div class="fs-7 text-dark fw-semibold">{{ $order->user?->name ?? '—' }}</div>
                        </td>
                        <td>
                            <div class="fs-7 text-dark">{{ $order->agent?->name ?? '<span class="text-muted">Unassigned</span>' }}</div>
                        </td>
                        @endif
                        <td>
                            <span class="font-monospace text-primary fw-bold fs-6">₦{{ number_format($order->amount, 2) }}</span>
                        </td>
                        <td>
                            @php
                                $badgeMap = [
                                    'pending' => 'badge-light-info',
                                    'transit' => 'badge-light-warning',
                                    'delivered' => 'badge-light-success',
                                    'cancelled' => 'badge-light-danger',
                                ];
                                $dotColors = [
                                    'pending' => 'info',
                                    'transit' => 'warning',
                                    'delivered' => 'success',
                                    'cancelled' => 'danger',
                                ];
                            @endphp
                            <span class="badge {{ $badgeMap[$order->status] ?? 'badge-light-secondary' }}">
                                <span class="bullet bullet-dot bg-{{ $dotColors[$order->status] ?? 'secondary' }} fs-2x me-1"></span>
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="fs-7 text-dark">{{ $order->created_at->format('M d, Y') }}</div>
                            <div class="fs-8 text-muted">{{ $order->created_at->format('h:i A') }}</div>
                        </td>
                        <td class="text-end">
                            <div class="d-flex gap-1 justify-content-end align-items-center">
                                @if($order->payment_status !== 'paid')
                                <a href="{{ route('orders.payment.retry', $order->tracking_number) }}" class="btn btn-sm btn-warning d-inline-flex align-items-center gap-1 py-1 px-3 fs-8 me-1" title="Retry NABRoll Payment">
                                    <i class="ki-duotone ki-wallet fs-6"><span class="path1"></span><span class="path2"></span></i>
                                    <span>Retry Payment</span>
                                </a>
                                @endif
                                <a href="{{ route('orders.history.detail', $order->tracking_number) }}" class="btn btn-sm btn-icon btn-light btn-active-light-primary" title="View Details">
                                    <i class="ki-duotone ki-eye fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                </a>
                                @if($order->pickup_lat && $order->delivery_lat)
                                <a href="{{ route('tracking.map', $order->tracking_number) }}" class="btn btn-sm btn-icon btn-light btn-active-light-primary" title="Track on Map">
                                    <i class="ki-duotone ki-geolocation fs-3"><span class="path1"></span><span class="path2"></span></i>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center py-3">
        <span class="text-muted fs-7">Showing {{ $orders->firstItem() }}-{{ $orders->lastItem() }} of {{ $orders->total() }} orders</span>
        <div>{{ $orders->links() }}</div>
    </div>
    @endif
</div>
<!--end::Orders Table Card-->
</div>
@endsection
