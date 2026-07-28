@extends('layouts.metronic')

@section('title', 'Delivery Assignment')
@section('body_class', 'aside-enabled')
@section('page_title', 'Delivery Assignment')
@section('page_subtitle', 'Assign orders to delivery agents')

@section('sidebar')
    @include('partials.admin-sidebar')
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('dashboard.admin') }}" class="text-hover-primary" style="color: #94a3b8 !important; font-weight: 500; font-size: 1.1rem;">Home</a>
</li>
<li class="breadcrumb-item"><span style="color: #94a3b8; margin: 0 4px; font-weight: bold; font-size: 1.1rem;">-</span></li>
<li class="breadcrumb-item" style="color: #94a3b8; font-weight: 500; font-size: 1.1rem;">Delivery Assignment</li>
@endsection

@section('container_class', 'container-xxl')

@section('content')
@if(session('success'))
<div class="alert alert-success d-flex align-items-center" role="alert">
    <i class="ki-duotone ki-check-circle fs-2hx me-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
    <div>{{ session('success') }}</div>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger d-flex align-items-center" role="alert">
    <i class="ki-duotone ki-information-circle fs-2hx me-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
    <div>
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
</div>
@endif

<!-- Search Bar -->
<div class="card card-flush mb-6">
    <div class="card-body py-4">
        <form method="GET" action="{{ route('admin.assignment') }}" class="d-flex align-items-center gap-3">
            <div class="position-relative flex-grow-1">
                <i class="ki-duotone ki-magnifier position-absolute top-50 translate-middle-y fs-3 text-muted" style="left: 12px;">
                    <span class="path1"></span><span class="path2"></span>
                </i>
                <input type="text" name="search" class="form-control form-control-solid ps-10" placeholder="Search orders or agents..." value="{{ $search ?? '' }}">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
            @if($search)
            <a href="{{ route('admin.assignment') }}" class="btn btn-light">Clear</a>
            @endif
        </form>
    </div>
</div>

<div class="row g-6">
    <!-- Left Column: Unassigned Orders -->
    <div class="col-xl-7">
        <div class="card card-flush">
            <div class="card-header d-flex align-items-center justify-content-between py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">
                    <i class="ki-duotone ki-clipboard-text me-2 text-primary">
                        <span class="path1"></span><span class="path2"></span>
                    </i>
                    Unassigned Orders
                    <span class="badge badge-light-primary ms-2">{{ $unassignedOrders->total() }}</span>
                </h3>
            </div>
            <div class="card-body pt-0">
                @if($unassignedOrders->isEmpty())
                <div class="text-center py-10">
                    <i class="ki-duotone ki-check-circle fs-3x text-success mb-3">
                        <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                    </i>
                    <h4 class="text-muted">No unassigned orders</h4>
                    <p class="text-muted">All pending orders have been assigned.</p>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 gy-4">
                        <thead>
                            <tr class="fw-bold text-muted">
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Package</th>
                                <th>Destination</th>
                                <th>Amount</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($unassignedOrders as $order)
                            <tr>
                                <td>
                                    <span class="text-dark fw-bold font-monospace">{{ $order->tracking_number }}</span>
                                    <br>
                                    <span class="text-muted fs-8">{{ $order->created_at->format('M d, Y H:i') }}</span>
                                </td>
                                <td>
                                    <div class="text-dark fw-semibold">{{ $order->user->name ?? 'N/A' }}</div>
                                    <span class="text-muted fs-8">{{ $order->user->email ?? '' }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-light-{{ $order->is_fragile ? 'danger' : 'info' }}">
                                        {{ Str::limit($order->package_description ?? 'Package', 20) }}
                                        @if($order->is_fragile)
                                        <i class="ki-duotone ki-shield fs-8 ms-1"><span class="path1"></span><span class="path2"></span></i>
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted">{{ Str::limit($order->delivery_address, 25) }}</span>
                                </td>
                                <td>
                                    <span class="text-dark fw-semibold font-monospace">&#8358;{{ number_format($order->amount, 2) }}</span>
                                </td>
                                <td class="text-end">
                                    <form method="POST" action="{{ route('admin.assign', $order->id) }}" class="d-inline" id="assign-form-{{ $order->id }}">
                                        @csrf
                                        <div class="d-flex align-items-center gap-2 justify-content-end">
                                            <select name="agent_id" class="form-select form-select-sm form-select-solid" style="min-width: 140px;" required>
                                                <option value="">Select agent</option>
                                                @foreach($availableAgents as $agent)
                                                <option value="{{ $agent->id }}">
                                                    {{ $agent->name }} ({{ $agent->assigned_deliveries_count }} active)
                                                </option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                <i class="ki-duotone ki-check fs-6"><span class="path1"></span><span class="path2"></span></i>
                                                Assign
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Showing {{ $unassignedOrders->firstItem() }} to {{ $unassignedOrders->lastItem() }} of {{ $unassignedOrders->total() }} orders
                    </div>
                    <div>
                        {{ $unassignedOrders->appends(['search' => $search])->links('pagination::bootstrap-5') }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Column: Available Agents -->
    <div class="col-xl-5">
        <div class="card card-flush">
            <div class="card-header d-flex align-items-center justify-content-between py-4">
                <h3 class="card-title fw-bolder text-dark fs-4">
                    <i class="ki-duotone ki-users me-2 text-success">
                        <span class="path1"></span><span class="path2"></span>
                    </i>
                    Available Agents
                    <span class="badge badge-light-success ms-2">{{ $availableAgents->total() }}</span>
                </h3>
            </div>
            <div class="card-body pt-0">
                @if($availableAgents->isEmpty())
                <div class="text-center py-10">
                    <i class="ki-duotone ki-information fs-3x text-warning mb-3">
                        <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                    </i>
                    <h4 class="text-muted">No available agents</h4>
                    <p class="text-muted">All agents are currently busy or offline.</p>
                </div>
                @else
                <div class="d-flex flex-column gap-3">
                    @foreach($availableAgents as $agent)
                    <div class="card border border-dashed border-gray-300">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start">
                                <div class="symbol symbol-45px me-3">
                                    <div class="symbol-label bg-light-success d-flex align-items-center justify-content-center">
                                        <i class="ki-duotone ki-user fs-3 text-success">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-dark fw-bold">{{ $agent->name }}</span>
                                            <span class="badge badge-light-success ms-2">Available</span>
                                        </div>
                                    </div>
                                    <div class="text-muted fs-8 mt-1">{{ $agent->email }}</div>
                                    @if($agent->phone)
                                    <div class="text-muted fs-9"><i class="ki-duotone ki-phone fs-8"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> {{ $agent->phone }}</div>
                                    @endif
                                    <div class="d-flex align-items-center mt-2 gap-4">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-package fs-7 text-muted me-1">
                                                <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                                            </i>
                                            <span class="fs-8 text-muted">
                                                <span class="fw-bold text-dark">{{ $agent->assigned_deliveries_count }}</span> active orders
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-star fs-7 text-warning me-1">
                                                <span class="path1"></span>
                                            </i>
                                            <span class="fs-8 text-muted">
                                                Score: <span class="fw-bold text-dark">{{ $agent->performance_score ?? 'N/A' }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Showing {{ $availableAgents->firstItem() }} to {{ $availableAgents->lastItem() }} of {{ $availableAgents->total() }} agents
                    </div>
                    <div>
                        {{ $availableAgents->appends(['search' => $search])->links('pagination::bootstrap-5') }}
                    </div>
                </div>
                @endif
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
