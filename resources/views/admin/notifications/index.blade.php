@extends('layouts.metronic')
@section('title', 'Broadcast Notifications')
@section('body_class', 'aside-enabled')
@section('page_title', 'Notifications')
@section('page_subtitle', 'Send system-wide alerts')
@section('sidebar')@include('partials.admin-sidebar')@endsection
@section('container_class', 'container-xxl')

@section('content')
@if(session('success'))
<div class="alert alert-success d-flex align-items-center p-4 mb-6"><i class="ki-duotone ki-check-circle fs-2x text-success me-3"><span class="path1"></span><span class="path2"></span></i><span class="fs-6 fw-semibold">{{ session('success') }}</span></div>
@endif
<div class="row g-6">
    <div class="col-lg-8">
        <div class="card card-flush">
            <div class="card-header py-4"><h3 class="card-title fw-bolder text-dark fs-4">Send Broadcast</h3></div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.notifications.broadcast') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-semibold fs-6 mb-2">Target Audience</label>
                        <select name="target" class="form-select form-select-solid" required>
                            <option value="all">All Users (Customers + Agents)</option>
                            <option value="customers">Customers Only</option>
                            <option value="agents">Agents Only</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold fs-6 mb-2">Message</label>
                        <textarea name="message" class="form-control form-control-solid" rows="5" placeholder="Type your announcement..." required></textarea>
                        <div class="text-muted fs-8 mt-1">This will appear in every user's notification inbox.</div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100"><i class="ki-duotone ki-sms fs-4 me-2"><span class="path1"></span><span class="path2"></span></i>Send Broadcast</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-flush">
            <div class="card-header py-4"><h3 class="card-title fw-bolder text-dark">AUDIENCE</h3></div>
            <div class="card-body">
                <div class="d-flex flex-column gap-4">
                    <div class="d-flex align-items-center justify-between">
                        <span class="text-muted fs-6">Customers</span>
                        <span class="fs-4 fw-bolder text-dark">{{ $stats['total_customers'] }}</span>
                    </div>
                    <div class="separator"></div>
                    <div class="d-flex align-items-center justify-between">
                        <span class="text-muted fs-6">Agents</span>
                        <span class="fs-4 fw-bolder text-dark">{{ $stats['total_agents'] }}</span>
                    </div>
                    <div class="separator"></div>
                    <div class="d-flex align-items-center justify-between">
                        <span class="text-muted fs-6">Total</span>
                        <span class="fs-4 fw-bolder text-primary">{{ $stats['total_customers'] + $stats['total_agents'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
