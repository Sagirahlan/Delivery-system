@extends('layouts.metronic')

@section('title', 'Agents')
@section('body_class', 'aside-enabled')
@section('page_title', 'Agent Management')
@section('page_subtitle', 'Manage delivery agents and performance')

@section('sidebar')
    @include('partials.admin-sidebar')
@endsection

@section('breadcrumb')
<li class="breadcrumb-item text-muted"><a href="/" class="text-muted text-hover-primary">Home</a></li>
<li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
<li class="breadcrumb-item text-muted">Agents</li>
@endsection

@section('container_class', 'container-xxl')

@section('content')
@if(session('success'))
<div class="alert alert-success d-flex align-items-center p-4 mb-6"><i class="ki-duotone ki-check-circle fs-2x text-success me-3"><span class="path1"></span><span class="path2"></span></i><span class="fs-6 fw-semibold">{{ session('success') }}</span></div>
@endif

<!-- Stats -->
<div class="row g-6 mb-6">
    <div class="col-sm-3"><div class="card card-flush"><div class="card-body d-flex align-items-center"><div class="symbol symbol-40px me-3"><div class="symbol-label bg-light-info d-flex align-items-center justify-content-center"><i class="ki-duotone ki-users fs-4 text-info"><span class="path1"></span><span class="path2"></span></i></div></div><div><div class="text-muted fs-7 fw-semibold">Total Agents</div><div class="fs-4 fw-bolder text-dark">{{ $stats['total'] }}</div></div></div></div></div>
    <div class="col-sm-3"><div class="card card-flush"><div class="card-body d-flex align-items-center"><div class="symbol symbol-40px me-3"><div class="symbol-label bg-light-success d-flex align-items-center justify-content-center"><i class="ki-duotone ki-check-circle fs-4 text-success"><span class="path1"></span><span class="path2"></span></i></div></div><div><div class="text-muted fs-7 fw-semibold">Active</div><div class="fs-4 fw-bolder text-dark">{{ $stats['active'] }}</div></div></div></div></div>
    <div class="col-sm-3"><div class="card card-flush"><div class="card-body d-flex align-items-center"><div class="symbol symbol-40px me-3"><div class="symbol-label bg-light-secondary d-flex align-items-center justify-content-center"><i class="ki-duotone ki-user fs-4 text-secondary"><span class="path1"></span><span class="path2"></span></i></div></div><div><div class="text-muted fs-7 fw-semibold">Offline</div><div class="fs-4 fw-bolder text-dark">{{ $stats['offline'] }}</div></div></div></div></div>
    <div class="col-sm-3"><div class="card card-flush"><div class="card-body d-flex align-items-center"><div class="symbol symbol-40px me-3"><div class="symbol-label bg-light-danger d-flex align-items-center justify-content-center"><i class="ki-duotone ki-cross-circle fs-4 text-danger"><span class="path1"></span><span class="path2"></span></i></div></div><div><div class="text-muted fs-7 fw-semibold">Suspended</div><div class="fs-4 fw-bolder text-dark">{{ $stats['suspended'] }}</div></div></div></div></div>
</div>

<!-- Filters + Table -->
<div class="card card-flush">
    <div class="card-header d-flex justify-content-between align-items-center py-4">
        <h3 class="card-title fw-bolder text-dark fs-4">AGENTS</h3>
        <div class="d-flex gap-2">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control form-control-solid form-select-sm" placeholder="Search..." value="{{ request('search') }}">
                <select name="status" class="form-select form-select-solid form-select-sm" onchange="this.form.submit()">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status')==='active'?'selected':'' }}>Active</option>
                    <option value="suspended" {{ request('status')==='suspended'?'selected':'' }}>Suspended</option>
                </select>
                <a href="{{ route('admin.agents.create') }}" class="btn btn-primary btn-sm"><i class="ki-duotone ki-plus fs-3 me-1"><span class="path1"></span><span class="path2"></span></i>Add Agent</a>
            </form>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-row-dashed gy-5">
                <thead><tr class="fw-bold text-muted fs-7"><th>Name</th><th>Email</th><th>Phone</th><th>Status</th><th>Available</th><th>Deliveries</th><th>Active</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                    @forelse($agents as $agent)
                    <tr class="hover-elevate-up">
                        <td><div class="d-flex align-items-center gap-2"><div class="symbol symbol-30px"><div class="symbol-label bg-light-primary d-flex align-items-center justify-content-center"><span class="fw-bold text-primary">{{ substr($agent->name,0,1) }}</span></div></div><span class="fw-semibold text-dark">{{ $agent->name }}</span></div></td>
                        <td><span class="text-dark fs-7">{{ $agent->email }}</span></td>
                        <td><span class="text-muted fs-7">{{ $agent->phone ?? '—' }}</span></td>
                        <td><span class="badge badge-light-{{ $agent->status==='suspended'?'danger':'success' }}">{{ ucfirst($agent->status) }}</span></td>
                        <td><span class="bullet bullet-dot bg-{{ $agent->is_available?'success':'secondary' }} fs-2x"></span> {{ $agent->is_available ? 'On Duty' : 'Off Duty' }}</td>
                        <td><span class="font-monospace text-dark fs-7">{{ $agent->total_deliveries }}</span></td>
                        <td><span class="font-monospace text-warning fs-7">{{ $agent->active_deliveries }}</span></td>
                        <td class="text-end">
                            <div class="d-flex gap-1 justify-content-end">
                                <a href="{{ route('admin.agents.show', $agent->id) }}" class="btn btn-sm btn-icon btn-light" title="View"><i class="ki-duotone ki-eye fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></a>
                                <a href="{{ route('admin.agents.edit', $agent->id) }}" class="btn btn-sm btn-icon btn-light" title="Edit"><i class="ki-duotone ki-pencil fs-3"><span class="path1"></span><span class="path2"></span></i></a>
                                <form method="POST" action="{{ route('admin.agents.suspend', $agent->id) }}" class="d-inline" onsubmit="return confirm('Toggle status?')">
                                    @csrf<button class="btn btn-sm btn-icon btn-light" title="Suspend/Activate"><i class="ki-duotone ki-shield fs-3"><span class="path1"></span><span class="path2"></span></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted py-6">No agents found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($agents->hasPages())<div class="card-footer">{{ $agents->links() }}</div>@endif
</div>
@endsection
