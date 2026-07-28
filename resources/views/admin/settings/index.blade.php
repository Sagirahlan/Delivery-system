@extends('layouts.metronic')

@section('title', 'System Settings')
@section('body_class', 'aside-enabled')
@section('page_title', 'System Settings')
@section('page_subtitle', 'Configure pricing, delivery areas, and system options')

@section('sidebar')
    @include('partials.admin-sidebar')
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('dashboard.admin') }}" class="text-hover-primary" style="color: #94a3b8 !important; font-weight: 500; font-size: 1.1rem;">Home</a>
</li>
<li class="breadcrumb-item"><span style="color: #94a3b8; margin: 0 4px; font-weight: bold; font-size: 1.1rem;">-</span></li>
<li class="breadcrumb-item" style="color: #94a3b8; font-weight: 500; font-size: 1.1rem;">System Settings</li>
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

<form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf

    <div class="row g-6">
        <!-- Pricing & Fees -->
        <div class="col-xl-6">
            <div class="card card-flush">
                <div class="card-header d-flex align-items-center py-4">
                    <div class="symbol symbol-45px me-3">
                        <div class="symbol-label bg-light-warning d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-wallet fs-3 text-warning">
                                <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                            </i>
                        </div>
                    </div>
                    <div>
                        <h3 class="card-title fw-bolder text-dark fs-4 mb-1">Pricing & Fees</h3>
                        <p class="text-muted fs-7 mb-0">Configure delivery pricing structure</p>
                    </div>
                </div>
                <div class="card-body pt-0">
                    @foreach($pricingSettings as $key => $config)
                    <div class="mb-4">
                        <label class="form-label fs-7 fw-semibold text-dark">{{ $config['label'] }}</label>
                        <div class="d-flex align-items-center">
                            <span class="text-muted fs-7 me-2">&#8358;</span>
                            <input type="number" name="{{ $key }}" class="form-control form-control-solid"
                                   value="{{ old($key, $settings[$key] ?? $defaults[$key]['value']) }}"
                                   min="0" step="1" required>
                        </div>
                        <div class="text-muted fs-8 mt-1">{{ $defaults[$key]['description'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Delivery Areas -->
        <div class="col-xl-6">
            <div class="card card-flush">
                <div class="card-header d-flex align-items-center py-4">
                    <div class="symbol symbol-45px me-3">
                        <div class="symbol-label bg-light-primary d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-geolocation fs-3 text-primary">
                                <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                            </i>
                        </div>
                    </div>
                    <div>
                        <h3 class="card-title fw-bolder text-dark fs-4 mb-1">Delivery Areas</h3>
                        <p class="text-muted fs-7 mb-0">Set coverage zones and radius</p>
                    </div>
                </div>
                <div class="card-body pt-0">
                    @foreach($areaSettings as $key => $config)
                    <div class="mb-4">
                        <label class="form-label fs-7 fw-semibold text-dark">{{ $config['label'] }}</label>
                        <input type="{{ $config['type'] }}" name="{{ $key }}" class="form-control form-control-solid"
                               value="{{ old($key, $settings[$key] ?? $defaults[$key]['value']) }}"
                               {{ $config['type'] === 'number' ? 'min="1" step="1" required' : '' }}>
                        <div class="text-muted fs-8 mt-1">{{ $defaults[$key]['description'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- System Config -->
        <div class="col-xl-6">
            <div class="card card-flush">
                <div class="card-header d-flex align-items-center py-4">
                    <div class="symbol symbol-45px me-3">
                        <div class="symbol-label bg-light-info d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-technology-4 fs-3 text-info">
                                <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span>
                            </i>
                        </div>
                    </div>
                    <div>
                        <h3 class="card-title fw-bolder text-dark fs-4 mb-1">System Configuration</h3>
                        <p class="text-muted fs-7 mb-0">Toggle system features and limits</p>
                    </div>
                </div>
                <div class="card-body pt-0">
                    @foreach($systemSettings as $key => $config)
                    <div class="mb-4">
                        @if($config['type'] === 'boolean')
                        <div class="form-check form-switch form-check-custom form-check-solid mb-1">
                            <input class="form-check-input" type="checkbox" name="{{ $key }}" id="switch-{{ $key }}"
                                   value="1" {{ old($key, $settings[$key] ?? $defaults[$key]['value']) ? 'checked' : '' }}>
                            <label class="form-check-label fs-7 fw-semibold text-dark" for="switch-{{ $key }}">
                                {{ $config['label'] }}
                            </label>
                        </div>
                        <div class="text-muted fs-8">{{ $defaults[$key]['description'] }}</div>
                        @else
                        <label class="form-label fs-7 fw-semibold text-dark">{{ $config['label'] }}</label>
                        <input type="{{ $config['type'] }}" name="{{ $key }}" class="form-control form-control-solid"
                               value="{{ old($key, $settings[$key] ?? $defaults[$key]['value']) }}"
                               min="1" step="1" required>
                        <div class="text-muted fs-8 mt-1">{{ $defaults[$key]['description'] }}</div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- User Roles Info -->
        <div class="col-xl-6">
            <div class="card card-flush">
                <div class="card-header d-flex align-items-center py-4">
                    <div class="symbol symbol-45px me-3">
                        <div class="symbol-label bg-light-success d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-shield-tick fs-3 text-success">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                        </div>
                    </div>
                    <div>
                        <h3 class="card-title fw-bolder text-dark fs-4 mb-1">User Roles</h3>
                        <p class="text-muted fs-7 mb-0">Current role configuration</p>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center p-3 rounded bg-light">
                            <div class="symbol symbol-35px me-3">
                                <div class="symbol-label bg-light-danger d-flex align-items-center justify-content-center">
                                    <i class="ki-duotone ki-crown fs-4 text-danger">
                                        <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                                    </i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-dark">Admin</div>
                                <div class="fs-8 text-muted">Full system access, user management, reports</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center p-3 rounded bg-light">
                            <div class="symbol symbol-35px me-3">
                                <div class="symbol-label bg-light-success d-flex align-items-center justify-content-center">
                                    <i class="ki-duotone ki-truck fs-4 text-success">
                                        <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                                    </i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-dark">Agent</div>
                                <div class="fs-8 text-muted">Assigned deliveries, status updates, location tracking</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center p-3 rounded bg-light">
                            <div class="symbol symbol-35px me-3">
                                <div class="symbol-label bg-light-primary d-flex align-items-center justify-content-center">
                                    <i class="ki-duotone ki-profile-circle fs-4 text-primary">
                                        <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                                    </i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-dark">Customer</div>
                                <div class="fs-8 text-muted">Place orders, track deliveries, order history</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="d-flex justify-content-end mt-6">
        <button type="submit" class="btn btn-primary fw-bold px-8 py-3">
            <i class="ki-duotone ki-check fs-5 me-1"><span class="path1"></span><span class="path2"></span></i>
            Save All Settings
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
    KTComponents.init();
</script>
@endpush
