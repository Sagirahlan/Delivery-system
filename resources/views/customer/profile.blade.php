@extends('layouts.metronic')

@section('title', 'Profile Settings')
@section('body_class', 'aside-enabled')
@section('page_title', 'Profile Settings')
@section('page_subtitle', 'Manage your account information and preferences')

@section('sidebar')
    @include('partials.role-sidebar')
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="/" class="text-hover-primary" style="color: #94a3b8 !important; font-weight: 500; font-size: 1.1rem;">Home</a>
</li>
<li class="breadcrumb-item"><span style="color: #94a3b8; margin: 0 4px; font-weight: bold; font-size: 1.1rem;">-</span></li>
<li class="breadcrumb-item" style="color: #94a3b8; font-weight: 500; font-size: 1.1rem;">Profile Settings</li>
@endsection

@section('container_class', 'container-xxl')

@section('content')
<div class="liquid-mesh-container">
<div class="liquid-mesh-bg"></div>

<!--begin::Success Message-->
@if(session('success'))
<div class="alert alert-success d-flex align-items-center mb-6 rounded-4" role="alert">
    <i class="ki-duotone ki-check-shield fs-2x me-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
    <div>{{ session('success') }}</div>
</div>
@endif
<!--end::Success Message-->

<!--begin::Validation Errors-->
@if($errors->any())
<div class="alert alert-danger d-flex align-items-center mb-6 rounded-4" role="alert">
    <i class="ki-duotone ki-information fs-2x me-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
    <div>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif
<!--end::Validation Errors-->

@include('partials.hammshop-promo')

<div class="row g-6">
    <!--begin::Left Column-->
    <div class="col-lg-8">
        <!--begin::Edit Profile Card-->
        <div class="liquid-glass-card mb-6">
            <div class="card-header p-5 pb-0 border-0">
                <h3 class="card-title fw-bolder text-dark mb-0">
                    <i class="ki-duotone ki-user fs-4 me-2 text-primary"><span class="path1"></span><span class="path2"></span></i>
                    Edit Profile
                </h3>
            </div>
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body p-5">
                    <div class="row g-5">
                        <!-- Avatar -->
                        <div class="col-md-12 mb-2">
                            <label class="form-label fw-semibold text-dark">Profile Photo</label>
                            <div class="d-flex align-items-center gap-4">
                                <div class="symbol symbol-70px symbol-md-80px overflow-hidden">
                                    <img src="{{ $user->avatar_url }}" alt="Avatar" class="rounded" id="avatarPreview" style="width: 100%; height: 100%; object-fit: cover;" />
                                </div>
                                <input type="file" name="avatar" class="form-control form-control-solid w-auto" accept="image/*" onchange="document.getElementById('avatarPreview').src = window.URL.createObjectURL(this.files[0])" />
                            </div>
                            <div class="form-text">Allowed file types: png, jpg, jpeg. Max size: 2MB.</div>
                        </div>
                        <!-- Name -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-solid" value="{{ old('name', $user->name) }}" required />
                        </div>
                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control form-control-solid" value="{{ old('email', $user->email) }}" required />
                        </div>
                        <!-- Phone -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Phone Number</label>
                            <input type="text" name="phone" class="form-control form-control-solid" value="{{ old('phone', $user->phone) }}" placeholder="+234..." />
                        </div>
                        <!-- Role Badge -->
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="d-flex flex-column">
                                <label class="form-label fw-semibold text-muted">Account Type</label>
                                <div class="d-flex gap-2">
                                    @foreach($roles as $role)
                                    <span class="badge badge-light-primary fs-7">{{ ucfirst($role) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="ki-duotone ki-check fs-5 me-1"><span class="path1"></span><span class="path2"></span></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
        <!--end::Edit Profile Card-->

        <!--begin::Change Password Card-->
        <div class="card card-flush mb-6">
            <div class="card-header">
                <h3 class="card-title fw-bolder text-dark">
                    <i class="ki-duotone ki-lock-2 fs-4 me-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                    Change Password
                </h3>
            </div>
            <form method="POST" action="{{ route('profile.password') }}">
                @csrf
                <div class="card-body">
                    <div class="row g-5">
                        <!-- Current Password -->
                        <div class="col-md-12">
                            <label class="form-label fw-semibold text-dark">Current Password <span class="text-danger">*</span></label>
                            <input type="password" name="current_password" class="form-control form-control-solid" required />
                        </div>
                        <!-- New Password -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">New Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control form-control-solid" required />
                            <div class="form-text">Minimum 8 characters, include uppercase, lowercase, number & symbol.</div>
                        </div>
                        <!-- Confirm Password -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control form-control-solid" required />
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="ki-duotone ki-lock fs-5 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        Update Password
                    </button>
                </div>
            </form>
        </div>
        <!--end::Change Password Card-->

        <!--begin::Saved Addresses Card (Customer Only)-->
        @if($user->hasRole('customer'))
        <div class="card card-flush mb-6" id="addresses-card">
            <div class="card-header">
                <h3 class="card-title fw-bolder text-dark">
                    <i class="ki-duotone ki-geolocation fs-4 me-2"><span class="path1"></span><span class="path2"></span></i>
                    Saved Addresses
                </h3>
            </div>
            <form method="POST" action="{{ route('profile.addresses') }}" id="addresses-form">
                @csrf
                <div class="card-body">
                    <div id="addresses-container">
                        @forelse($savedAddresses as $index => $addr)
                        <div class="address-entry border border-dashed border-gray-300 rounded p-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge badge-light-primary fs-7">{{ $addr['label'] ?? 'Address' }}</span>
                                <button type="button" class="btn btn-sm btn-icon btn-color-danger btn-active-color-danger remove-address-btn" title="Remove address">
                                    <i class="ki-duotone ki-trash fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                </button>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold text-muted fs-8">Label</label>
                                    <input type="text" name="addresses[{{ $index }}][label]" class="form-control form-control-sm" value="{{ $addr['label'] ?? '' }}" placeholder="e.g. Home, Office" required />
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label fw-semibold text-muted fs-8">Full Address</label>
                                    <input type="text" name="addresses[{{ $index }}][address]" class="form-control form-control-sm" value="{{ $addr['address'] ?? '' }}" placeholder="Enter full delivery address" required />
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-6 text-muted" id="no-addresses-msg">
                            <i class="ki-duotone ki-geolocation fs-2x mb-2"><span class="path1"></span><span class="path2"></span></i>
                            <p class="mb-0">No saved addresses yet. Add one below.</p>
                        </div>
                        @endforelse
                    </div>
                    <button type="button" class="btn btn-sm btn-light-primary" id="add-address-btn">
                        <i class="ki-duotone ki-plus fs-5 me-1"><span class="path1"></span><span class="path2"></span></i>
                        Add New Address
                    </button>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="ki-duotone ki-check fs-5 me-1"><span class="path1"></span><span class="path2"></span></i>
                        Save Addresses
                    </button>
                </div>
            </form>
        </div>
        @endif
        <!--end::Saved Addresses Card-->
    </div>
    <!--end::Left Column-->

    <!--begin::Right Column-->
    <div class="col-lg-4">
        <!--begin::Account Status Card-->
        <div class="card card-flush mb-6">
            <div class="card-header">
                <h3 class="card-title fw-bolder text-dark">Account Status</h3>
            </div>
            <div class="card-body text-center">
                <div class="symbol symbol-70px symbol-md-100px mx-auto mb-4 overflow-hidden shadow-sm">
                    <img src="{{ $user->avatar_url }}" alt="Avatar" class="rounded" style="width: 100%; height: 100%; object-fit: cover;" />
                </div>
                <h4 class="fw-bolder text-dark mb-1">{{ $user->name }}</h4>
                <p class="text-muted fs-7 mb-4">{{ $user->email }}</p>
                <div class="d-flex justify-content-center gap-2 mb-3">
                    @php
                        $statusColor = match($user->status) {
                            'active' => 'success',
                            'suspended' => 'warning',
                            'banned' => 'danger',
                            default => 'secondary',
                        };
                    @endphp
                    <span class="badge badge-light-{{ $statusColor }} fs-7">{{ ucfirst($user->status) }}</span>
                </div>
            </div>
        </div>
        <!--end::Account Status Card-->

        <!--begin::Agent Availability Card (Agent Only)-->
        @if($user->hasRole('agent'))
        <div class="card card-flush mb-6" id="availability-card">
            <div class="card-header">
                <h3 class="card-title fw-bolder text-dark">
                    <i class="ki-duotone ki-clock fs-4 me-2"><span class="path1"></span><span class="path2"></span></i>
                    Duty Status
                </h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.availability') }}">
                    @csrf
                    <div class="d-flex flex-column align-items-center">
                        <!-- Toggle Switch -->
                        <div class="form-check form-switch form-check-custom form-check-solid mb-4">
                            <input class="form-check-input" type="checkbox" name="is_available" id="availability-toggle"
                                   value="1" {{ old('is_available', $user->is_available) ? 'checked' : '' }}
                                   onchange="this.form.submit()" />
                            <label class="form-check-label fw-semibold fs-5 ms-2" for="availability-toggle" id="availability-label">
                                {{ old('is_available', $user->is_available) ? 'On Duty' : 'Off Duty' }}
                            </label>
                        </div>

                        <!-- Status Indicator -->
                        <div class="d-flex flex-column align-items-center mb-4">
                            @if($user->is_available)
                                <span class="bullet bullet-dot bg-success fs-2x animate-pulse me-2"></span>
                                <span class="text-success fw-bolder fs-6">Available for deliveries</span>
                            @else
                                <span class="bullet bullet-dot bg-gray-400 fs-2x me-2"></span>
                                <span class="text-gray-500 fw-bolder fs-6">Currently unavailable</span>
                            @endif
                        </div>
                    </div>
                </form>

                <!-- Performance Stats -->
                <div class="separator my-4"></div>
                <h5 class="fw-bolder text-dark mb-4">Performance Stats</h5>

                <div class="d-flex flex-column gap-4">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted fs-7">Performance Score</span>
                            <span class="fw-bolder fs-6 text-primary">{{ number_format($user->performance_score, 2) }}/5.00</span>
                        </div>
                        <div class="progress h-8px bg-light-success">
                            @php $scorePercent = min(($user->performance_score / 5) * 100, 100); @endphp
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $scorePercent }}%" aria-valuenow="{{ $scorePercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between fs-7">
                        <span class="text-muted">Total Deliveries</span>
                        <span class="font-monospace text-dark fw-semibold">{{ $user->assignedDeliveries()->count() }}</span>
                    </div>

                    <div class="d-flex justify-content-between fs-7">
                        <span class="text-muted">Completed</span>
                        <span class="font-monospace text-success fw-semibold">{{ $user->assignedDeliveries()->where('status', 'delivered')->count() }}</span>
                    </div>

                    <div class="d-flex justify-content-between fs-7">
                        <span class="text-muted">In Progress</span>
                        <span class="font-monospace text-warning fw-semibold">{{ $user->assignedDeliveries()->whereIn('status', ['pending', 'transit'])->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!--end::Agent Availability Card-->

        <!--begin::Quick Links Card-->
        <div class="card card-flush mb-6">
            <div class="card-header">
                <h3 class="card-title fw-bolder text-dark">Quick Links</h3>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center p-3 rounded border border-dashed text-hover-primary">
                        <i class="ki-duotone ki-element-11 fs-3 me-3 text-muted"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                        <div>
                            <span class="fw-semibold text-dark">Dashboard</span>
                            <span class="d-block fs-8 text-muted">View your overview</span>
                        </div>
                    </a>
                    <a href="{{ route('orders.history') }}" class="d-flex align-items-center p-3 rounded border border-dashed text-hover-primary">
                        <i class="ki-duotone ki-document fs-3 me-3 text-muted"><span class="path1"></span><span class="path2"></span></i>
                        <div>
                            <span class="fw-semibold text-dark">Order History</span>
                            <span class="d-block fs-8 text-muted">Browse past orders</span>
                        </div>
                    </a>
                    <a href="{{ route('tracking.map') }}" class="d-flex align-items-center p-3 rounded border border-dashed text-hover-primary">
                        <i class="ki-duotone ki-geolocation fs-3 me-3 text-muted"><span class="path1"></span><span class="path2"></span></i>
                        <div>
                            <span class="fw-semibold text-dark">Live Tracking</span>
                            <span class="d-block fs-8 text-muted">Track active deliveries</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!--end::Quick Links Card-->
    </div>
    <!--end::Right Column-->
</div>
</div>
@endsection

@push('scripts')
<script>
// Address management for customers
(function() {
    const container = document.getElementById('addresses-container');
    const addBtn = document.getElementById('add-address-btn');
    const noMsg = document.getElementById('no-addresses-msg');
    let addressCount = {{ count($savedAddresses) }};

    if (addBtn) {
        addBtn.addEventListener('click', function() {
            if (noMsg) noMsg.style.display = 'none';

            const entry = document.createElement('div');
            entry.className = 'address-entry border border-dashed border-gray-300 rounded p-4 mb-4';
            entry.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge badge-light-primary fs-7">New Address</span>
                    <button type="button" class="btn btn-sm btn-icon btn-color-danger btn-active-color-danger remove-address-btn" title="Remove address">
                        <i class="ki-duotone ki-trash fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                    </button>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-muted fs-8">Label</label>
                        <input type="text" name="addresses[\${addressCount}][label]" class="form-control form-control-sm" placeholder="e.g. Home, Office" required />
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-semibold text-muted fs-8">Full Address</label>
                        <input type="text" name="addresses[\${addressCount}][address]" class="form-control form-control-sm" placeholder="Enter full delivery address" required />
                    </div>
                </div>
            `;
            container.appendChild(entry);
            addressCount++;

            // Bind remove event
            entry.querySelector('.remove-address-btn').addEventListener('click', function() {
                entry.remove();
                if (container.querySelectorAll('.address-entry').length === 0 && noMsg) {
                    noMsg.style.display = 'block';
                }
            });
        });
    }

    // Bind existing remove buttons
    document.querySelectorAll('.remove-address-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const entry = btn.closest('.address-entry');
            if (entry) {
                entry.remove();
                if (container.querySelectorAll('.address-entry').length === 0 && noMsg) {
                    noMsg.style.display = 'block';
                }
            }
        });
    });
})();
</script>
@endpush
