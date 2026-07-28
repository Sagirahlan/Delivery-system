@extends('layouts.metronic')

@section('title', 'Assigned Orders')
@section('body_class', 'aside-enabled')
@section('page_title', 'Assigned Orders')
@section('page_subtitle', 'Manage your delivery assignments')

@section('sidebar')
<div style="margin-top: 2rem;">
    <a class="menu-link mb-2" href="{{ route('dashboard.agent') }}" style="color:#bbb;border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-squares-four fs-4" style="color:#64748b;"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
        <span>Dashboard</span>
    </a>
    <a class="menu-link mb-2 active" href="{{ route('agent.orders') }}" style="color:#ff8c00;background:rgba(255,140,0,0.1);border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-clipboard-list fs-4" style="color:#ff8c00;"><span class="path1"></span><span class="path2"></span></i>
        <span>Assigned Orders</span>
    </a>
    <a class="menu-link mb-2" href="{{ route('orders.history') }}" style="color:#bbb;border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-clock fs-4" style="color:#64748b;"><span class="path1"></span><span class="path2"></span></i>
        <span>Delivery History</span>
    </a>
    <a class="menu-link mb-2" href="{{ route('profile.index') }}" style="color:#bbb;border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-profile-circle fs-4" style="color:#64748b;"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <span>My Profile</span>
    </a>
</div>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item text-muted"><a href="/" class="text-muted text-hover-primary">Home</a></li>
<li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
<li class="breadcrumb-item text-muted">Assigned Orders</li>
@endsection

@section('container_class', 'container-xxl')

@section('content')
@if(session('success'))
<div class="alert alert-success d-flex align-items-center p-4 mb-6">
    <i class="ki-duotone ki-check-circle fs-2x text-success me-3"><span class="path1"></span><span class="path2"></span></i>
    <span class="fs-6 fw-semibold">{{ session('success') }}</span>
</div>
@endif

<!-- Stats -->
<div class="row g-6 mb-6">
    <div class="col-sm-4">
        <div class="card card-flush">
            <div class="card-body d-flex align-items-center">
                <div class="symbol symbol-40px me-3"><div class="symbol-label bg-light-warning d-flex align-items-center justify-content-center"><i class="ki-duotone ki-hourglass fs-4 text-warning"><span class="path1"></span><span class="path2"></span></i></div></div>
                <div><div class="text-muted fs-7 fw-semibold">Pending</div><div class="fs-4 fw-bolder text-dark">{{ $stats['pending'] }}</div></div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card card-flush">
            <div class="card-body d-flex align-items-center">
                <div class="symbol symbol-40px me-3"><div class="symbol-label bg-light-info d-flex align-items-center justify-content-center"><i class="ki-duotone ki-truck fs-4 text-info"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></div></div>
                <div><div class="text-muted fs-7 fw-semibold">In Transit</div><div class="fs-4 fw-bolder text-dark">{{ $stats['transit'] }}</div></div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card card-flush">
            <div class="card-body d-flex align-items-center">
                <div class="symbol symbol-40px me-3"><div class="symbol-label bg-light-success d-flex align-items-center justify-content-center"><i class="ki-duotone ki-check-circle fs-4 text-success"><span class="path1"></span><span class="path2"></span></i></div></div>
                <div><div class="text-muted fs-7 fw-semibold">Delivered</div><div class="fs-4 fw-bolder text-dark">{{ $stats['delivered'] }}</div></div>
            </div>
        </div>
    </div>
</div>

<!-- Orders Table -->
<div class="card card-flush">
    <div class="card-header d-flex justify-content-between align-items-center py-4">
        <h3 class="card-title fw-bolder text-dark fs-4">YOUR DELIVERIES</h3>
        <form method="GET" class="d-flex gap-2">
            <select name="status" class="form-select form-select-solid form-select-sm" onchange="this.form.submit()">
                <option value="all">All Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="transit" {{ request('status') === 'transit' ? 'selected' : '' }}>In Transit</option>
                <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
            </select>
        </form>
    </div>
    <div class="card-body p-0">
        @if($orders->isEmpty())
            <div class="text-center py-16">
                <div class="symbol symbol-80px mx-auto mb-5"><div class="symbol-label bg-light d-flex align-items-center justify-content-center"><i class="ki-duotone ki-clipboard fs-1 text-muted"><span class="path1"></span><span class="path2"></span></i></div></div>
                <h4 class="fw-bolder text-dark mb-2">No Orders Assigned</h4>
                <p class="text-muted fs-6">When orders are assigned to you, they'll appear here.</p>
            </div>
        @else
        <div class="table-responsive">
            <table class="table table-row-dashed gy-5">
                <thead>
                    <tr class="fw-bold text-muted fs-7">
                        <th class="min-w-100px">Tracking #</th>
                        <th class="min-w-100px">Customer</th>
                        <th class="min-w-150px">Route</th>
                        <th class="min-w-80px">Amount</th>
                        <th class="min-w-100px">Status</th>
                        <th class="min-w-80px">Date</th>
                        <th class="min-w-80px text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr class="hover-elevate-up">
                        <td><span class="font-monospace text-dark fw-bold">{{ $order->tracking_number }}</span></td>
                        <td><span class="fs-7 text-dark">{{ $order->user?->name ?? '—' }}</span></td>
                        <td><span class="fs-7 text-dark">{{ Str::limit($order->pickup_address, 18) }} → {{ Str::limit($order->delivery_address, 18) }}</span></td>
                        <td><span class="font-monospace text-primary fw-bold">₦{{ number_format($order->amount, 0) }}</span></td>
                        <td>
                            @php $bm=['pending'=>'badge-light-info','transit'=>'badge-light-warning','delivered'=>'badge-light-success','cancelled'=>'badge-light-danger']; $dc=['pending'=>'info','transit'=>'warning','delivered'=>'success','cancelled'=>'danger']; @endphp
                            <span class="badge {{ $bm[$order->status] }}"><span class="bullet bullet-dot bg-{{ $dc[$order->status] }} fs-2x me-1"></span>{{ ucfirst($order->status) }}</span>
                        </td>
                        <td><span class="fs-7 text-dark">{{ $order->created_at->format('M d') }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('agent.orders.show', $order->tracking_number) }}" class="btn btn-sm btn-icon btn-light btn-active-light-primary" title="View"><i class="ki-duotone ki-eye fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></a>
                            <a href="{{ route('tracking.map', $order->tracking_number) }}" class="btn btn-sm btn-icon btn-light btn-active-light-primary" title="Track"><i class="ki-duotone ki-geolocation fs-3"><span class="path1"></span><span class="path2"></span></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
    @if($orders->hasPages())
    <div class="card-footer">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
