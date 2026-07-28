@extends('layouts.metronic')

@section('title', 'Reports')
@section('body_class', 'aside-enabled')
@section('page_title', 'Reports')
@section('page_subtitle', 'Export and analyze delivery data')

@section('sidebar')
    @include('partials.admin-sidebar')
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('dashboard.admin') }}" class="text-hover-primary" style="color: #94a3b8 !important; font-weight: 500; font-size: 1.1rem;">Home</a>
</li>
<li class="breadcrumb-item"><span style="color: #94a3b8; margin: 0 4px; font-weight: bold; font-size: 1.1rem;">-</span></li>
<li class="breadcrumb-item" style="color: #94a3b8; font-weight: 500; font-size: 1.1rem;">Reports</li>
@endsection

@section('container_class', 'container-xxl')

@section('content')
<!-- Stats Row -->
<div class="row g-6 mb-6">
    <div class="col-sm-6 col-xl-3">
        <div class="card card-flush">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-40px me-3">
                        <div class="symbol-label bg-light-info d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-package fs-4 text-info">
                                <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                            </i>
                        </div>
                    </div>
                    <div>
                        <div class="text-muted fs-7 fw-semibold">Total Orders</div>
                        <div class="fs-4 fw-bolder text-dark">{{ number_format($stats['total_orders']) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-flush">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-40px me-3">
                        <div class="symbol-label bg-light-warning d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-wallet fs-4 text-warning">
                                <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                            </i>
                        </div>
                    </div>
                    <div>
                        <div class="text-muted fs-7 fw-semibold">Total Revenue</div>
                        <div class="fs-4 fw-bolder text-dark font-monospace">&#8358;{{ number_format($stats['total_revenue'], 0) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-flush">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-40px me-3">
                        <div class="symbol-label bg-light-success d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-users fs-4 text-success">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                        </div>
                    </div>
                    <div>
                        <div class="text-muted fs-7 fw-semibold">Total Agents</div>
                        <div class="fs-4 fw-bolder text-dark">{{ number_format($stats['total_agents']) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-flush">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-40px me-3">
                        <div class="symbol-label bg-light-primary d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-profile-circle fs-4 text-primary">
                                <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                            </i>
                        </div>
                    </div>
                    <div>
                        <div class="text-muted fs-7 fw-semibold">Total Customers</div>
                        <div class="fs-4 fw-bolder text-dark">{{ number_format($stats['total_customers']) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Report Cards -->
<div class="row g-6">
    <!-- Orders Report -->
    <div class="col-xl-6">
        <div class="card card-flush h-100">
            <div class="card-header d-flex align-items-center py-4">
                <div class="symbol symbol-45px me-3">
                    <div class="symbol-label bg-light-info d-flex align-items-center justify-content-center">
                        <i class="ki-duotone ki-document fs-3 text-info">
                            <span class="path1"></span><span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div>
                    <h3 class="card-title fw-bolder text-dark fs-4 mb-1">Orders Report</h3>
                    <p class="text-muted fs-7 mb-0">Export all orders with filters</p>
                </div>
            </div>
            <div class="card-body pt-0">
                <form method="POST" action="{{ route('admin.reports.orders') }}">
                    @csrf
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-7 fw-semibold text-muted">Date From</label>
                            <input type="date" name="date_from" class="form-control form-control-solid">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-7 fw-semibold text-muted">Date To</label>
                            <input type="date" name="date_to" class="form-control form-control-solid">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fs-7 fw-semibold text-muted">Status</label>
                        <select name="status" class="form-select form-select-solid">
                            <option value="all">All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="transit">In Transit</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ki-duotone ki-down fs-5 me-1"><span class="path1"></span><span class="path2"></span></i>
                        Export Orders CSV
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Revenue Report -->
    <div class="col-xl-6">
        <div class="card card-flush h-100">
            <div class="card-header d-flex align-items-center py-4">
                <div class="symbol symbol-45px me-3">
                    <div class="symbol-label bg-light-warning d-flex align-items-center justify-content-center">
                        <i class="ki-duotone ki-wallet fs-3 text-warning">
                            <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                        </i>
                    </div>
                </div>
                <div>
                    <h3 class="card-title fw-bolder text-dark fs-4 mb-1">Revenue Report</h3>
                    <p class="text-muted fs-7 mb-0">Daily revenue breakdown</p>
                </div>
            </div>
            <div class="card-body pt-0">
                <form method="POST" action="{{ route('admin.reports.revenue') }}">
                    @csrf
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-7 fw-semibold text-muted">Date From</label>
                            <input type="date" name="date_from" class="form-control form-control-solid">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-7 fw-semibold text-muted">Date To</label>
                            <input type="date" name="date_to" class="form-control form-control-solid">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning w-100 text-white">
                        <i class="ki-duotone ki-down fs-5 me-1"><span class="path1"></span><span class="path2"></span></i>
                        Export Revenue CSV
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Agent Performance Report -->
    <div class="col-xl-6">
        <div class="card card-flush h-100">
            <div class="card-header d-flex align-items-center py-4">
                <div class="symbol symbol-45px me-3">
                    <div class="symbol-label bg-light-success d-flex align-items-center justify-content-center">
                        <i class="ki-duotone ki-users fs-3 text-success">
                            <span class="path1"></span><span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div>
                    <h3 class="card-title fw-bolder text-dark fs-4 mb-1">Agent Performance</h3>
                    <p class="text-muted fs-7 mb-0">Delivery stats per agent</p>
                </div>
            </div>
            <div class="card-body pt-0">
                <form method="POST" action="{{ route('admin.reports.agents') }}">
                    @csrf
                    <div class="d-flex flex-column mb-4">
                        <p class="text-muted fs-7 mb-3">
                            Exports a CSV containing each agent's total deliveries, delivered count,
                            in-transit, pending, cancelled counts, and performance score.
                        </p>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="ki-duotone ki-down fs-5 me-1"><span class="path1"></span><span class="path2"></span></i>
                        Export Agent Performance CSV
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Customer List Report -->
    <div class="col-xl-6">
        <div class="card card-flush h-100">
            <div class="card-header d-flex align-items-center py-4">
                <div class="symbol symbol-45px me-3">
                    <div class="symbol-label bg-light-primary d-flex align-items-center justify-content-center">
                        <i class="ki-duotone ki-profile-circle fs-3 text-primary">
                            <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                        </i>
                    </div>
                </div>
                <div>
                    <h3 class="card-title fw-bolder text-dark fs-4 mb-1">Customer List</h3>
                    <p class="text-muted fs-7 mb-0">All registered customers</p>
                </div>
            </div>
            <div class="card-body pt-0">
                <form method="POST" action="{{ route('admin.reports.customers') }}">
                    @csrf
                    <div class="d-flex flex-column mb-4">
                        <p class="text-muted fs-7 mb-3">
                            Exports a CSV containing customer name, email, phone, total order count,
                            and registration date.
                        </p>
                    </div>
                    <button type="submit" class="btn btn-info w-100 text-white">
                        <i class="ki-duotone ki-down fs-5 me-1"><span class="path1"></span><span class="path2"></span></i>
                        Export Customers CSV
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    KTComponents.init();
</script>
@endpush
