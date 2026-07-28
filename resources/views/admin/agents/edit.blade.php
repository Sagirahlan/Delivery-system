@extends('layouts.metronic')
@section('title', 'Edit Agent')
@section('body_class', 'aside-enabled')
@section('page_title', 'Edit Agent')
@section('page_subtitle', $agent->name)
@section('sidebar')@include('partials.admin-sidebar')@endsection
@section('container_class', 'container-xxl')
@section('content')
<div class="row justify-content-center"><div class="col-lg-8">
<div class="card card-flush">
    <div class="card-header py-4"><h3 class="card-title fw-bolder text-dark fs-4">Edit: {{ $agent->name }}</h3></div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.agents.update', $agent->id) }}">
            @csrf
            <div class="mb-4"><label class="form-label fw-semibold fs-6">Full Name</label><input type="text" name="name" class="form-control form-control-solid" value="{{ old('name', $agent->name) }}" required></div>
            <div class="mb-4"><label class="form-label fw-semibold fs-6">Email</label><input type="email" name="email" class="form-control form-control-solid" value="{{ old('email', $agent->email) }}" required></div>
            <div class="mb-4"><label class="form-label fw-semibold fs-6">Phone</label><input type="tel" name="phone" class="form-control form-control-solid" value="{{ old('phone', $agent->phone) }}"></div>
            <div class="mb-4"><label class="form-label fw-semibold fs-6">New Password <span class="text-muted fw-normal">(leave blank to keep current)</span></label><input type="password" name="password" class="form-control form-control-solid"></div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-lg flex-grow-1"><i class="ki-duotone ki-check fs-4 me-2"><span class="path1"></span><span class="path2"></span></i>Save Changes</button>
                <a href="{{ route('admin.agents.show', $agent->id) }}" class="btn btn-outline btn-lg">Cancel</a>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection
