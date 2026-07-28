@extends('layouts.metronic')
@section('title', 'Customers')
@section('body_class', 'aside-enabled')
@section('page_title', 'Customer Management')
@section('page_subtitle', 'View and manage customer accounts')
@section('sidebar')@include('partials.admin-sidebar')@endsection
@section('container_class', 'container-xxl')

@section('content')
@if(session('success'))
<div class="alert alert-success d-flex align-items-center p-4 mb-6"><i class="ki-duotone ki-check-circle fs-2x text-success me-3"><span class="path1"></span><span class="path2"></span></i><span class="fs-6 fw-semibold">{{ session('success') }}</span></div>
@endif
<div class="row g-6 mb-6">
    <div class="col-sm-4"><div class="card card-flush"><div class="card-body d-flex align-items-center"><div class="symbol symbol-40px me-3"><div class="symbol-label bg-light-info d-flex align-items-center justify-content-center"><i class="ki-duotone ki-users fs-4 text-info"><span class="path1"></span><span class="path2"></span></i></div></div><div><div class="text-muted fs-7 fw-semibold">Total Customers</div><div class="fs-4 fw-bolder text-dark">{{ $stats['total'] }}</div></div></div></div></div>
    <div class="col-sm-4"><div class="card card-flush"><div class="card-body d-flex align-items-center"><div class="symbol symbol-40px me-3"><div class="symbol-label bg-light-success d-flex align-items-center justify-content-center"><i class="ki-duotone ki-user fs-4 text-success"><span class="path1"></span><span class="path2"></span></i></div></div><div><div class="text-muted fs-7 fw-semibold">Active</div><div class="fs-4 fw-bolder text-dark">{{ $stats['active'] }}</div></div></div></div></div>
    <div class="col-sm-4"><div class="card card-flush"><div class="card-body d-flex align-items-center"><div class="symbol symbol-40px me-3"><div class="symbol-label bg-light-danger d-flex align-items-center justify-content-center"><i class="ki-duotone ki-cross-circle fs-4 text-danger"><span class="path1"></span><span class="path2"></span></i></div></div><div><div class="text-muted fs-7 fw-semibold">Suspended</div><div class="fs-4 fw-bolder text-dark">{{ $stats['suspended'] }}</div></div></div></div></div>
</div>
<div class="card card-flush">
    <div class="card-header d-flex justify-content-between align-items-center py-4">
        <h3 class="card-title fw-bolder text-dark fs-4">CUSTOMERS</h3>
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control form-control-solid form-select-sm" placeholder="Search..." value="{{ request('search') }}">
            <select name="status" class="form-select form-select-solid form-select-sm" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="active" {{ request('status')==='active'?'selected':'' }}>Active</option>
                <option value="suspended" {{ request('status')==='suspended'?'selected':'' }}>Suspended</option>
            </select>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-row-dashed gy-5">
                <thead><tr class="fw-bold text-muted fs-7"><th>Name</th><th>Email</th><th>Phone</th><th>Orders</th><th>Status</th><th>Registered</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                    @forelse($customers as $c)
                    <tr class="hover-elevate-up">
                        <td><div class="d-flex align-items-center gap-2"><div class="symbol symbol-30px"><div class="symbol-label bg-light-success d-flex align-items-center justify-content-center"><span class="fw-bold text-success">{{ substr($c->name,0,1) }}</span></div></div><span class="fw-semibold text-dark">{{ $c->name }}</span></div></td>
                        <td><span class="text-dark fs-7">{{ $c->email }}</span></td>
                        <td><span class="text-muted fs-7">{{ $c->phone ?? '—' }}</span></td>
                        <td><span class="font-monospace text-dark fs-7">{{ $c->total_orders }}</span></td>
                        <td><span class="badge badge-light-{{ $c->status==='suspended'?'danger':'success' }}">{{ ucfirst($c->status) }}</span></td>
                        <td><span class="text-muted fs-7">{{ $c->created_at->format('M d, Y') }}</span></td>
                        <td class="text-end"><div class="d-flex gap-1 justify-content-end">
                            <a href="{{ route('admin.customers.show', $c->id) }}" class="btn btn-sm btn-icon btn-light"><i class="ki-duotone ki-eye fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></a>
                            <a href="{{ route('admin.customers.edit', $c->id) }}" class="btn btn-sm btn-icon btn-light"><i class="ki-duotone ki-pencil fs-3"><span class="path1"></span><span class="path2"></span></i></a>
                            <form method="POST" action="{{ route('admin.customers.suspend', $c->id) }}" class="d-inline" onsubmit="return confirm('Toggle status?')">@csrf<button class="btn btn-sm btn-icon btn-light"><i class="ki-duotone ki-shield fs-3"><span class="path1"></span><span class="path2"></span></i></button></form>
                        </div></td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-6">No customers found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($customers->hasPages())<div class="card-footer">{{ $customers->links() }}</div>@endif
</div>
@endsection
