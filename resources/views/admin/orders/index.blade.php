@extends('layouts.metronic')

@section('title', 'Manage Orders')
@section('body_class', 'aside-enabled')
@section('page_title', 'Manage Orders')
@section('page_subtitle', 'View and manage all delivery orders')

@section('sidebar')
    @include('partials.admin-sidebar')
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="/" class="text-hover-primary" style="color: #94a3b8 !important; font-weight: 500; font-size: 1.1rem;">Home</a>
</li>
<li class="breadcrumb-item"><span style="color: #94a3b8; margin: 0 4px; font-weight: bold; font-size: 1.1rem;">-</span></li>
<li class="breadcrumb-item">
    <a href="{{ route('dashboard.admin') }}" class="text-hover-primary" style="color: #94a3b8 !important; font-weight: 500; font-size: 1.1rem;">Admin</a>
</li>
<li class="breadcrumb-item"><span style="color: #94a3b8; margin: 0 4px; font-weight: bold; font-size: 1.1rem;">-</span></li>
<li class="breadcrumb-item" style="color: #94a3b8; font-weight: 500; font-size: 1.1rem;">Orders</li>
@endsection

@section('container_class', 'container-xxl')

@section('content')
@if(session('success'))
<div class="alert alert-success d-flex align-items-center p-4 mb-6">
    <i class="ki-duotone ki-check-circle fs-2x text-success me-3"><span class="path1"></span><span class="path2"></span></i>
    <span class="fs-6 fw-semibold">{{ session('success') }}</span>
</div>
@endif

<!--begin::Stats Row-->
<div class="row g-6 mb-6">
    <!-- Total Orders -->
    <div class="col-sm-6 col-xl-3">
        <div class="card card-flush">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-40px me-3">
                        <div class="symbol-label bg-light-info d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-package fs-4 text-info"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-muted fs-7 fw-semibold">Total Orders</div>
                        <div class="fs-4 fw-bolder text-dark">{{ number_format($stats['total']) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pending -->
    <div class="col-sm-6 col-xl-3">
        <div class="card card-flush">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-40px me-3">
                        <div class="symbol-label bg-light-warning d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-hourglass fs-4 text-warning"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-muted fs-7 fw-semibold">Pending</div>
                        <div class="fs-4 fw-bolder text-dark">{{ number_format($stats['pending']) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- In Transit -->
    <div class="col-sm-6 col-xl-3">
        <div class="card card-flush">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-40px me-3">
                        <div class="symbol-label bg-light-primary d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-truck fs-4 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-muted fs-7 fw-semibold">In Transit</div>
                        <div class="fs-4 fw-bolder text-dark">{{ number_format($stats['transit']) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Revenue -->
    <div class="col-sm-6 col-xl-3">
        <div class="card card-flush">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-40px me-3">
                        <div class="symbol-label bg-light-success d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-wallet fs-4 text-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-muted fs-7 fw-semibold">Revenue</div>
                        <div class="fs-4 fw-bolder text-dark font-monospace">₦{{ number_format($stats['revenue'], 0) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Stats Row-->

<!--begin::Orders Table Card-->
<div class="card card-flush">
    <!--begin::Card header-->
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center py-4 gap-3">
        <h3 class="card-title fw-bolder text-dark fs-4">ALL ORDERS</h3>
        <!--begin::Filters-->
        <form method="GET" action="{{ route('admin.orders.index') }}" class="d-flex flex-wrap gap-2 align-items-center">
            <input type="text" name="search" class="form-control form-control-solid form-control-sm w-150px" placeholder="Search..." value="{{ request('search') }}">
            <select name="status" class="form-select form-select-solid form-select-sm w-120px" onchange="this.form.submit()">
                <option value="all">All Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="transit" {{ request('status') === 'transit' ? 'selected' : '' }}>In Transit</option>
                <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <input type="date" name="date_from" class="form-control form-control-solid form-control-sm w-130px" value="{{ request('date_from') }}" placeholder="From">
            <input type="date" name="date_to" class="form-control form-control-solid form-control-sm w-130px" value="{{ request('date_to') }}" placeholder="To">
            <button type="submit" class="btn btn-sm btn-light-primary">
                <i class="ki-duotone ki-magnifier fs-3"><span class="path1"></span><span class="path2"></span></i> Filter
            </button>
            @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-light">Clear</a>
            @endif
        </form>
        <!--end::Filters-->
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body p-0">
        @if($orders->isEmpty())
        <div class="text-center py-16">
            <div class="symbol symbol-80px mx-auto mb-5">
                <div class="symbol-label bg-light d-flex align-items-center justify-content-center">
                    <i class="ki-duotone ki-package fs-1 text-muted"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                </div>
            </div>
            <h4 class="fw-bolder text-dark mb-2">No Orders Found</h4>
            <p class="text-muted fs-6">No orders match your current filters.</p>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-row-dashed gy-5">
                <thead>
                    <tr class="fw-bold text-muted fs-7">
                        <th class="min-w-100px ps-6">Tracking #</th>
                        <th class="min-w-120px">Customer</th>
                        <th class="min-w-100px">Agent</th>
                        <th class="min-w-150px">Route</th>
                        <th class="min-w-80px">Amount</th>
                        <th class="min-w-100px">Status</th>
                        <th class="min-w-90px">Date</th>
                        <th class="min-w-100px text-end pe-6">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr class="hover-elevate-up">
                        <td class="ps-6">
                            <a href="{{ route('admin.orders.show', $order->tracking_number) }}" class="font-monospace text-dark fw-bold text-hover-primary">
                                {{ $order->tracking_number }}
                            </a>
                        </td>
                        <td>
                            <span class="fs-7 text-dark">{{ $order->user?->name ?? '—' }}</span>
                        </td>
                        <td>
                            @if($order->agent)
                            <div class="d-flex align-items-center gap-2">
                                <div class="symbol symbol-25px">
                                    <div class="symbol-label bg-light-success">
                                        <i class="ki-duotone ki-user fs-3 text-success"><span class="path1"></span><span class="path2"></span></i>
                                    </div>
                                </div>
                                <span class="fs-7 text-dark">{{ $order->agent->name }}</span>
                            </div>
                            @else
                            <span class="fs-8 text-muted">Unassigned</span>
                            @endif
                        </td>
                        <td>
                            <span class="fs-7 text-dark">{{ Str::limit($order->pickup_address, 18) }} → {{ Str::limit($order->delivery_address, 18) }}</span>
                        </td>
                        <td>
                            <span class="font-monospace text-primary fw-bold">₦{{ number_format($order->amount, 0) }}</span>
                        </td>
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
                        <td>
                            <span class="fs-7 text-dark">{{ $order->created_at->format('M d, Y') }}</span>
                        </td>
                        <td class="text-end pe-6">
                            <a href="{{ route('admin.orders.show', $order->tracking_number) }}" class="btn btn-sm btn-icon btn-light btn-active-light-primary" title="View">
                                <i class="ki-duotone ki-eye fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            </a>
                            <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-icon btn-light btn-active-light-warning" title="Edit">
                                <i class="ki-duotone ki-pencil fs-3"><span class="path1"></span><span class="path2"></span></i>
                            </a>
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this order?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-icon btn-light btn-active-light-danger" title="Delete">
                                    <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
    <!--end::Card body-->

    @if($orders->hasPages())
    <div class="card-footer d-flex justify-content-center">
        {{ $orders->withQueryString()->links() }}
    </div>
    @endif
</div>
<!--end::Orders Table Card-->
@endsection

@push('scripts')
<script>
    KTComponents.init();
</script>
@endpush
