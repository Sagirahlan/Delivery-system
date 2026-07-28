@extends('layouts.metronic')
@section('title', 'Agent: ' . $agent->name)
@section('body_class', 'aside-enabled')
@section('page_title', 'Agent Details')
@section('page_subtitle', $agent->name)
@section('sidebar')@include('partials.admin-sidebar')@endsection
@section('breadcrumb')
<li class="breadcrumb-item text-muted"><a href="{{ route('admin.agents.index') }}" class="text-muted text-hover-primary">Agents</a></li>
<li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
<li class="breadcrumb-item text-muted">{{ $agent->name }}</li>
@endsection
@section('container_class', 'container-xxl')

@section('content')
@if(session('success'))
<div class="alert alert-success d-flex align-items-center p-4 mb-6"><i class="ki-duotone ki-check-circle fs-2x text-success me-3"><span class="path1"></span><span class="path2"></span></i><span class="fs-6 fw-semibold">{{ session('success') }}</span></div>
@endif
<div class="row g-6">
    <div class="col-lg-4">
        <div class="card card-flush">
            <div class="card-header py-4"><h3 class="card-title fw-bolder text-dark">PROFILE</h3></div>
            <div class="card-body text-center">
                <div class="symbol symbol-70px mx-auto mb-4">
                    <div class="symbol-label bg-primary bg-opacity-25 d-flex align-items-center justify-content-center">
                        <span class="fs-2 fw-bolder text-primary">{{ substr($agent->name,0,1) }}</span>
                    </div>
                </div>
                <h4 class="fw-bolder text-dark mb-1">{{ $agent->name }}</h4>
                <div class="text-muted fs-7 mb-1">{{ $agent->email }}</div>
                <div class="text-muted fs-7 mb-4">{{ $agent->phone ?? 'No phone' }}</div>
                <div class="d-flex gap-2 mb-4 justify-content-center">
                    <span class="badge badge-light-{{ $agent->status==='suspended'?'danger':'success' }}">{{ ucfirst($agent->status) }}</span>
                    <span class="badge badge-light-{{ $agent->is_available?'success':'secondary' }}">{{ $agent->is_available?'On Duty':'Off Duty' }}</span>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.agents.edit', $agent->id) }}" class="btn btn-sm btn-outline flex-grow-1">Edit</a>
                    <form method="POST" action="{{ route('admin.agents.suspend', $agent->id) }}" class="flex-grow-1">
                        @csrf<button class="btn btn-sm btn-{{ $agent->status==='suspended'?'success':'danger' }} w-100">{{ $agent->status==='suspended'?'Activate':'Suspend' }}</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card card-flush mt-6">
            <div class="card-header py-4"><h3 class="card-title fw-bolder text-dark">PERFORMANCE</h3></div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex justify-between fs-6"><span class="text-muted">Total Deliveries</span><span class="font-monospace fw-bold text-dark">{{ $agent->total_deliveries }}</span></div>
                    <div class="d-flex justify-between fs-6"><span class="text-muted">Active</span><span class="font-monospace fw-bold text-warning">{{ $agent->active_deliveries }}</span></div>
                    <div class="d-flex justify-between fs-6"><span class="text-muted">Completed</span><span class="font-monospace fw-bold text-success">{{ $agent->completed_deliveries }}</span></div>
                    <div class="d-flex justify-between fs-6"><span class="text-muted">Earnings</span><span class="font-monospace fw-bold text-primary">₦{{ number_format($totalEarnings, 2) }}</span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card card-flush">
            <div class="card-header py-4"><h3 class="card-title fw-bolder text-dark">ASSIGNED ORDERS</h3></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-row-dashed gy-4">
                        <thead><tr class="fw-bold text-muted fs-7"><th>Tracking</th><th>Customer</th><th>Route</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead>
                        <tbody>
                            @forelse($recentOrders as $o)
                            <tr>
                                <td><span class="font-monospace text-dark fw-bold fs-7">{{ $o->tracking_number }}</span></td>
                                <td><span class="text-dark fs-7">{{ $o->user?->name ?? '—' }}</span></td>
                                <td><span class="text-muted fs-7">{{ Str::limit($o->pickup_address,15) }} → {{ Str::limit($o->delivery_address,15) }}</span></td>
                                <td><span class="font-monospace text-primary fs-7">₦{{ number_format($o->amount,0) }}</span></td>
                                <td><span class="badge badge-light-{{ $o->status==='pending'?'info':($o->status==='transit'?'warning':($o->status==='delivered'?'success':'danger')) }}">{{ ucfirst($o->status) }}</span></td>
                                <td><span class="text-muted fs-7">{{ $o->created_at->format('M d') }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center text-muted py-5">No orders assigned.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
