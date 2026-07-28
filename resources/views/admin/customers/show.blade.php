@extends('layouts.metronic')
@section('title', 'Customer: ' . $customer->name)
@section('body_class', 'aside-enabled')
@section('page_title', 'Customer Details')
@section('page_subtitle', $customer->name)
@section('sidebar')@include('partials.admin-sidebar')@endsection
@section('container_class', 'container-xxl')
@section('content')
<div class="row g-6">
    <div class="col-lg-4">
        <div class="card card-flush">
            <div class="card-header py-4"><h3 class="card-title fw-bolder text-dark">PROFILE</h3></div>
            <div class="card-body text-center">
                <div class="symbol symbol-70px mx-auto mb-4"><div class="symbol-label bg-light-success d-flex align-items-center justify-content-center"><span class="fs-2 fw-bolder text-success">{{ substr($customer->name,0,1) }}</span></div></div>
                <h4 class="fw-bolder text-dark mb-1">{{ $customer->name }}</h4>
                <div class="text-muted fs-7 mb-1">{{ $customer->email }}</div>
                <div class="text-muted fs-7 mb-4">{{ $customer->phone ?? 'No phone' }}</div>
                <div class="d-flex gap-2 mb-4 justify-content-center">
                    <span class="badge badge-light-{{ $customer->status==='suspended'?'danger':'success' }}">{{ ucfirst($customer->status) }}</span>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-sm btn-outline flex-grow-1">Edit</a>
                    <form method="POST" action="{{ route('admin.customers.suspend', $customer->id) }}" class="flex-grow-1">@csrf<button class="btn btn-sm btn-{{ $customer->status==='suspended'?'success':'danger' }} w-100">{{ $customer->status==='suspended'?'Activate':'Suspend' }}</button></form>
                </div>
            </div>
        </div>
        <div class="card card-flush mt-6">
            <div class="card-header py-4"><h3 class="card-title fw-bolder text-dark">ORDER SUMMARY</h3></div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex justify-between fs-6"><span class="text-muted">Total Orders</span><span class="font-monospace fw-bold text-dark">{{ $customer->total_orders }}</span></div>
                    <div class="d-flex justify-between fs-6"><span class="text-muted">Completed</span><span class="font-monospace fw-bold text-success">{{ $customer->completed_orders }}</span></div>
                    <div class="d-flex justify-between fs-6"><span class="text-muted">Total Spent</span><span class="font-monospace fw-bold text-primary">₦{{ number_format($totalSpent, 2) }}</span></div>
                    <div class="d-flex justify-between fs-6"><span class="text-muted">Joined</span><span class="text-dark fs-7">{{ $customer->created_at->format('M d, Y') }}</span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card card-flush">
            <div class="card-header py-4"><h3 class="card-title fw-bolder text-dark">ORDER HISTORY</h3></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-row-dashed gy-4">
                        <thead><tr class="fw-bold text-muted fs-7"><th>Tracking</th><th>Agent</th><th>Route</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead>
                        <tbody>
                            @forelse($recentOrders as $o)
                            <tr>
                                <td><span class="font-monospace text-dark fw-bold">{{ $o->tracking_number }}</span></td>
                                <td><span class="text-dark fs-7">{{ $o->agent?->name ?? 'Unassigned' }}</span></td>
                                <td><span class="text-muted fs-7">{{ Str::limit($o->pickup_address,18) }} → {{ Str::limit($o->delivery_address,18) }}</span></td>
                                <td><span class="font-monospace text-primary fw-bold">₦{{ number_format($o->amount,0) }}</span></td>
                                <td><span class="badge badge-light-{{ $o->status==='pending'?'info':($o->status==='transit'?'warning':($o->status==='delivered'?'success':'danger')) }}">{{ ucfirst($o->status) }}</span></td>
                                <td><span class="text-muted fs-7">{{ $o->created_at->format('M d') }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center text-muted py-5">No orders.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
