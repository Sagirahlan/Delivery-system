@extends('layouts.metronic')

@section('title', 'Live Tracking')
@section('body_class', 'aside-enabled')
@section('page_title', 'Live Order Tracking')
@section('page_subtitle', $order ? 'Tracking: ' . $order->tracking_number : 'Enter a tracking number to get started')

@section('sidebar')
    @include('partials.role-sidebar')
@endsection

@section('breadcrumb')
<li class="breadcrumb-item text-muted">
    <a href="/" class="text-muted text-hover-primary">Home</a>
</li>
@if($order)
<li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
<li class="breadcrumb-item text-muted">
    <a href="/dashboard/customer" class="text-muted text-hover-primary">Orders</a>
</li>
<li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
<li class="breadcrumb-item text-muted">{{ $order->tracking_number }}</li>
@endif
@endsection

@section('container_class', 'container-xxl')

@section('content')

@if(session('success'))
<div class="alert alert-success d-flex align-items-center p-4 mb-6 rounded-4">
    <i class="ki-duotone ki-check-circle fs-2x text-success me-3"><span class="path1"></span><span class="path2"></span></i>
    <span class="fs-6 fw-semibold">{{ session('success') }}</span>
</div>
@endif

@if($errors->has('payment'))
<div class="alert alert-danger d-flex align-items-center justify-content-between p-4 mb-6 rounded-4">
    <div class="d-flex align-items-center">
        <i class="ki-duotone ki-information fs-2x text-danger me-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <span class="fs-6 fw-semibold">{{ $errors->first('payment') }}</span>
    </div>
    @if($order && $order->payment_status !== 'paid')
    <a href="{{ route('orders.payment.retry', $order->tracking_number) }}" class="btn btn-sm btn-warning ms-3 d-inline-flex align-items-center gap-1">
        <i class="ki-duotone ki-wallet fs-5"><span class="path1"></span><span class="path2"></span></i>
        <span>Retry Payment</span>
    </a>
    @endif
</div>
@endif

<!--begin::Tracking Number Input (shown when no order)-->
@if(!$order)
<div class="row justify-content-center mb-6">
    <div class="col-lg-6">
        <div class="card card-flush">
            <div class="card-body text-center py-10">
                <div class="symbol symbol-70px mx-auto mb-5">
                    <div class="symbol-label bg-light-primary">
                        <i class="ki-duotone ki-geolocation fs-1 text-primary">
                            <span class="path1"></span><span class="path2"></span>
                        </i>
                    </div>
                </div>
                <h3 class="fw-bolder text-dark fs-3 mb-2">Track Your Order</h3>
                <p class="text-muted fs-6 mb-6">Enter your order tracking number to see live location.</p>

                <form id="track-form" class="d-flex gap-2">
                    <input type="text" id="track-input" class="form-control form-control-solid fs-5"
                           placeholder="e.g. SD-1247" style="text-transform: uppercase;">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="ki-duotone ki-search fs-3">
                            <span class="path1"></span><span class="path2"></span>
                        </i>
                        Track
                    </button>
                </form>
                <div id="track-error" class="text-danger fs-7 mt-3 d-none"></div>
            </div>
        </div>
    </div>
</div>
@endif

<!--begin::Main Tracking Layout-->
@if($order)
<div class="row g-6">
    <!-- Map Column -->
    <div class="col-lg-8">
        <div class="card card-flush">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <h3 class="card-title fw-bolder text-dark fs-4">LIVE MAP</h3>
                    <span class="badge {{ $order->statusBadgeClass() }}">
                        <span class="bullet bullet-dot fs-2x me-1"
                              style="background-color: {{ $order->status === 'transit' ? '#ff8c00' : ($order->status === 'delivered' ? '#15c552' : ($order->status === 'pending' ? '#00a8ff' : '#f13848')) }}"></span>
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-light-primary" id="btn-center-marker" title="Center on agent">
                        <i class="ki-duotone ki-geolocation fs-4"><span class="path1"></span><span class="path2"></span></i>
                        Center
                    </button>
                    <button class="btn btn-sm btn-light" id="btn-fit-route" title="Show full route">
                        <i class="ki-duotone ki-map fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        Fit Route
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <!-- Map Container -->
                <div id="tracking-map" style="height: 550px; width: 100%;"></div>
            </div>
        </div>
    </div>

    <!-- Info Sidebar -->
    <div class="col-lg-4">
        <div class="d-flex flex-column gap-6">
            <!-- Order Info Card -->
            <div class="card card-flush">
                <div class="card-header">
                    <h3 class="card-title fw-bolder text-dark">ORDER DETAILS</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-4">
                        <!-- Tracking Number -->
                        <div class="d-flex justify-content-between">
                            <span class="text-muted fs-7">Tracking Number</span>
                            <span class="font-monospace text-dark fw-bold fs-7">{{ $order->tracking_number }}</span>
                        </div>
                        <!-- Status -->
                        <div class="d-flex justify-content-between">
                            <span class="text-muted fs-7">Status</span>
                            <span class="badge {{ $order->statusBadgeClass() }}">{{ ucfirst($order->status) }}</span>
                        </div>
                        <!-- Agent -->
                        @if($order->agent)
                        <div class="d-flex justify-content-between">
                            <span class="text-muted fs-7">Agent</span>
                            <span class="text-dark fs-7">{{ $order->agent->name }}</span>
                        </div>
                        @endif
                        <!-- Amount -->
                        <div class="d-flex justify-content-between">
                            <span class="text-muted fs-7">Amount</span>
                            <span class="font-monospace text-primary fw-bold fs-7">₦{{ number_format($order->amount, 2) }}</span>
                        </div>

                        <!-- Payment Status & Retry -->
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted fs-7">Payment</span>
                            @if($order->payment_status === 'paid')
                                <span class="badge badge-light-success">Paid</span>
                            @else
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge badge-light-danger">{{ ucfirst($order->payment_status ?? 'Unpaid') }}</span>
                                    <a href="{{ route('orders.payment.retry', $order->tracking_number) }}" class="btn btn-xs btn-warning px-2 py-1 fs-8" title="Retry NABRoll Payment">
                                        Retry
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="separator"></div>

                        <!-- Route -->
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fs-8 text-muted text-uppercase fw-bold">Active Route</span>
                                <span class="badge badge-light-primary fs-9" id="active-target-badge">
                                    {{ $order->status === 'pending' ? '📍 Heading to Pickup' : ($order->status === 'transit' ? '🎯 Heading to Drop-off' : '✔ Delivered') }}
                                </span>
                            </div>
                            <div class="d-flex align-items-start gap-3 mb-3">
                                <div class="d-flex flex-column align-items-center mt-1">
                                    <div class="w-10px h-10px rounded-circle bg-success" id="pickup-dot"></div>
                                    <div class="w-2px h-35px bg-gradient-success-primary" id="route-line-connector"></div>
                                    <div class="w-10px h-10px rounded-circle bg-primary" id="delivery-dot"></div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fs-8 text-muted">Pickup Location</span>
                                            <span class="fs-9 badge {{ $order->status === 'pending' ? 'badge-light-success' : 'badge-light' }}" id="pickup-status-tag">
                                                {{ $order->status === 'pending' ? 'ACTIVE TARGET' : 'PICKED UP ✔' }}
                                            </span>
                                        </div>
                                        <div class="fs-7 text-dark fw-semibold">{{ $order->pickup_address }}</div>
                                    </div>
                                    <div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fs-8 text-muted">Delivery Destination</span>
                                            <span class="fs-9 badge {{ $order->status === 'transit' ? 'badge-light-warning' : 'badge-light' }}" id="delivery-status-tag">
                                                {{ $order->status === 'transit' ? 'ACTIVE TARGET 🎯' : ($order->status === 'delivered' ? 'DELIVERED ✔' : 'PENDING PICKUP') }}
                                            </span>
                                        </div>
                                        <div class="fs-7 text-dark fw-semibold">{{ $order->delivery_address }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Agent Action Card (Visible to assigned Agent & Admin) -->
            @if(auth()->check() && (auth()->id() === $order->agent_id || auth()->user()->hasRole('admin')))
            <div class="card card-flush border border-primary border-dashed" id="agent-actions-card">
                <div class="card-header py-3">
                    <h3 class="card-title fw-bolder text-dark fs-5">
                        <i class="ki-duotone ki-user-tick fs-3 text-primary me-2"><span class="path1"></span><span class="path2"></span></i>
                        AGENT ACTIONS
                    </h3>
                </div>
                <div class="card-body pt-0">
                    <div id="agent-action-buttons">
                        @if($order->status === 'pending')
                        <button type="button" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm" id="btn-confirm-pickup">
                            <i class="ki-duotone ki-box-tick fs-2 me-1"><span class="path1"></span><span class="path2"></span></i>
                            Confirm Pickup & Start Transit
                        </button>
                        <div class="fs-8 text-muted mt-2 text-center" id="pickup-hint">
                            Click when package is collected. Route will switch to delivery destination.
                        </div>
                        @elseif($order->status === 'transit')
                        <button type="button" class="btn btn-success btn-lg w-100 fw-bold shadow-sm" id="btn-confirm-delivery">
                            <i class="ki-duotone ki-check-circle fs-2 me-1"><span class="path1"></span><span class="path2"></span></i>
                            Mark as Delivered
                        </button>
                        <div class="fs-8 text-muted mt-2 text-center">
                            Click when package is delivered to recipient.
                        </div>
                        @elseif($order->status === 'delivered')
                        <div class="alert alert-success d-flex align-items-center mb-0 p-3 rounded-3">
                            <i class="ki-duotone ki-check-circle fs-2x text-success me-3"><span class="path1"></span><span class="path2"></span></i>
                            <span class="fs-6 fw-bold">Delivery Completed</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Live Status Card -->
            <div class="card card-flush" id="live-status-card">
                <div class="card-header">
                    <h3 class="card-title fw-bolder text-dark">LIVE STATUS</h3>
                    <span class="d-flex align-items-center gap-1 fs-8 text-success fw-semibold">
                        <span class="bullet bullet-dot bg-success fs-2x" id="connection-dot"></span>
                        <span id="connection-text">Connected</span>
                    </span>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-3" id="live-updates">
                        <div class="d-flex align-items-center gap-2 text-muted">
                            <i class="ki-duotone ki-information fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            <span class="fs-7" id="initial-status-msg">
                                @if($order->status === 'pending')
                                    Agent assigned. Heading to pickup location.
                                @elseif($order->status === 'transit')
                                    Package collected! En route to delivery destination.
                                @elseif($order->status === 'delivered')
                                    Package delivered successfully.
                                @else
                                    Waiting for updates...
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- ETA Display -->
                    <div class="bg-light rounded p-4 text-center mt-3" id="eta-display" style="{{ $order->status === 'transit' ? '' : 'display: none;' }}">
                        <div class="fs-8 text-muted text-uppercase ls-1 mb-1">Estimated Arrival</div>
                        <div class="fs-2 fw-bolder text-warning font-monospace" id="eta-countdown">15 mins</div>
                        <div class="fs-8 text-muted mt-1">en route to drop-off</div>
                    </div>
                </div>
            </div>

            <!-- Simulation Controls (Admin / Testing) -->
            @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->id() === $order->agent_id))
            <div class="card card-flush">
                <div class="card-header py-3">
                    <h3 class="card-title fw-bolder text-dark fs-6">LOCATION SIMULATION</h3>
                </div>
                <div class="card-body pt-0">
                    <button class="btn btn-light-warning btn-sm w-100" id="btn-simulate">
                        <i class="ki-duotone ki-truck fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        Simulate Agent Movement
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endif
<!--end::Main Tracking Layout-->
@endsection

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
      crossorigin="" />
<style>
    .leaflet-container {
        background: #111 !important;
    }
    .custom-location-marker {
        background: none !important;
        border: none !important;
    }
    .agent-icon {
        width: 44px;
        height: 44px;
        background: #ff8c00;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 4px 12px rgba(255,140,0,0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        animation: pulse-marker 2s infinite;
    }
    @keyframes pulse-marker {
        0%, 100% { box-shadow: 0 2px 8px rgba(0,0,0,0.4), 0 0 0 0 rgba(255,140,0,0.5); }
        50% { box-shadow: 0 2px 8px rgba(0,0,0,0.4), 0 0 0 14px rgba(255,140,0,0); }
    }
    
    /* Pickup Pin */
    .pickup-pin-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        transform: translate(0, -100%);
    }
    .pickup-pin-badge {
        background: #15c552;
        color: #ffffff;
        font-size: 11px;
        font-weight: 800;
        padding: 3px 10px;
        border-radius: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.4);
        white-space: nowrap;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .pickup-pin-body {
        width: 38px;
        height: 38px;
        background: #15c552;
        border: 3px solid #ffffff;
        border-radius: 50% 50% 50% 0;
        transform: rotate(-45deg);
        box-shadow: 0 4px 14px rgba(21, 197, 82, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .pickup-pin-icon {
        transform: rotate(45deg);
        color: #ffffff;
        font-size: 16px;
    }

    /* Delivery Pin */
    .delivery-pin-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        transform: translate(0, -100%);
    }
    .delivery-pin-badge {
        background: #ff4757;
        color: #ffffff;
        font-size: 11px;
        font-weight: 800;
        padding: 3px 10px;
        border-radius: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.4);
        white-space: nowrap;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .delivery-pin-body {
        width: 38px;
        height: 38px;
        background: #ff4757;
        border: 3px solid #ffffff;
        border-radius: 50% 50% 50% 0;
        transform: rotate(-45deg);
        box-shadow: 0 4px 14px rgba(255, 71, 87, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .delivery-pin-icon {
        transform: rotate(45deg);
        color: #ffffff;
        font-size: 16px;
    }

    /* Tooltips */
    .pickup-tooltip {
        background: #0f172a !important;
        border: 1.5px solid #15c552 !important;
        color: #f8fafc !important;
        font-weight: 700 !important;
        border-radius: 8px !important;
        padding: 6px 12px !important;
        box-shadow: 0 6px 16px rgba(0,0,0,0.5) !important;
    }
    .delivery-tooltip {
        background: #0f172a !important;
        border: 1.5px solid #ff4757 !important;
        color: #f8fafc !important;
        font-weight: 700 !important;
        border-radius: 8px !important;
        padding: 6px 12px !important;
        box-shadow: 0 6px 16px rgba(0,0,0,0.5) !important;
    }
</style>
@endpush

@push('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>

<!-- Laravel Echo & Pusher -->
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.min.js"></script>

<script>
@if($order)
@php
    $pickupLat = $order->pickup_lat ?? 12.0022;
    $pickupLng = $order->pickup_lng ?? 8.5920;
    $deliveryLat = $order->delivery_lat ?? 11.9960;
    $deliveryLng = $order->delivery_lng ?? 8.5450;
@endphp

// ====== MAP INITIALIZATION ======
const pickupLat = {{ $pickupLat }};
const pickupLng = {{ $pickupLng }};
const deliveryLat = {{ $deliveryLat }};
const deliveryLng = {{ $deliveryLng }};

const defaultLat = {{ $order->current_lat ?? $pickupLat }};
const defaultLng = {{ $order->current_lng ?? $pickupLng }};

const map = L.map('tracking-map', {
    zoomControl: true,
    attributionControl: true
}).setView([defaultLat, defaultLng], 13);

// Dark tile layer for the theme
L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> &copy; <a href="https://carto.com/">CARTO</a>',
    subdomains: 'abcd',
    maxZoom: 20
}).addTo(map);

// ====== MARKERS ======
// Agent/Current Location Marker
const agentIcon = L.divIcon({
    className: 'custom-location-marker',
    html: '<div class="agent-icon">🚚</div>',
    iconSize: [44, 44],
    iconAnchor: [22, 22]
});

let agentMarker = null;
@if($order->current_lat && $order->current_lng)
agentMarker = L.marker([{{ $order->current_lat }}, {{ $order->current_lng }}], { icon: agentIcon })
    .addTo(map)
    .bindPopup('<b>Agent Location</b><br>Current position');
@endif

// Pickup Point Marker (Bright Green Pin with "PICKUP LOCATION" badge)
const pickupIcon = L.divIcon({
    className: 'custom-location-marker',
    html: `
        <div class="pickup-pin-wrap">
            <div class="pickup-pin-badge">📍 PICKUP</div>
            <div class="pickup-pin-body">
                <span class="pickup-pin-icon">📦</span>
            </div>
        </div>
    `,
    iconSize: [120, 65],
    iconAnchor: [60, 65]
});

const pickupMarker = L.marker([pickupLat, pickupLng], { icon: pickupIcon })
    .addTo(map)
    .bindPopup('<b>PICKUP LOCATION:</b><br>{{ e($order->pickup_address) }}')
    .bindTooltip('<b>📍 PICKUP:</b> {{ e($order->pickup_address) }}', {
        permanent: true,
        direction: 'top',
        className: 'pickup-tooltip',
        offset: [0, -45]
    });

// Delivery Point Marker (Bright Red Pin with "DROP-OFF" badge)
const deliveryIcon = L.divIcon({
    className: 'custom-location-marker',
    html: `
        <div class="delivery-pin-wrap">
            <div class="delivery-pin-badge">🏁 DROP-OFF</div>
            <div class="delivery-pin-body">
                <span class="delivery-pin-icon">🏠</span>
            </div>
        </div>
    `,
    iconSize: [120, 65],
    iconAnchor: [60, 65]
});

const deliveryMarker = L.marker([deliveryLat, deliveryLng], { icon: deliveryIcon })
    .addTo(map)
    .bindPopup('<b>DROP-OFF LOCATION:</b><br>{{ e($order->delivery_address) }}')
    .bindTooltip('<b>🏁 DROP-OFF:</b> {{ e($order->delivery_address) }}', {
        permanent: true,
        direction: 'top',
        className: 'delivery-tooltip',
        offset: [0, -45]
    });

// Auto Fit Map Bounds to show Pickup, Delivery, and Agent
const mapBounds = [];
mapBounds.push([pickupLat, pickupLng]);
mapBounds.push([deliveryLat, deliveryLng]);
@if($order->current_lat && $order->current_lng)
mapBounds.push([{{ $order->current_lat }}, {{ $order->current_lng }}]);
@endif

if (mapBounds.length > 0) {
    map.fitBounds(mapBounds, { padding: [80, 80] });
}

// ====== ACTIVE ROUTE POLYLINE ======
let activeRouteLine = null;

function updateActiveRoute(status) {
    if (activeRouteLine) {
        map.removeLayer(activeRouteLine);
    }

    const currentAgentLat = agentMarker ? agentMarker.getLatLng().lat : pickupLat;
    const currentAgentLng = agentMarker ? agentMarker.getLatLng().lng : pickupLng;

    if (status === 'pending') {
        // Route from Agent/Origin -> Pickup Location (Dashed Green)
        activeRouteLine = L.polyline([[currentAgentLat, currentAgentLng], [pickupLat, pickupLng]], {
            color: '#15c552',
            weight: 5,
            opacity: 0.9,
            dashArray: '10, 10'
        }).addTo(map);
    } else if (status === 'transit') {
        // Route from Pickup -> Delivery Destination (Solid Orange)
        activeRouteLine = L.polyline([[pickupLat, pickupLng], [deliveryLat, deliveryLng]], {
            color: '#ff8c00',
            weight: 6,
            opacity: 0.9
        }).addTo(map);

        // Zoom map to focus on the active delivery route
        map.fitBounds([[pickupLat, pickupLng], [deliveryLat, deliveryLng]], { padding: [80, 80] });
    } else if (status === 'delivered') {
        activeRouteLine = L.polyline([[pickupLat, pickupLng], [deliveryLat, deliveryLng]], {
            color: '#15c552',
            weight: 5,
            opacity: 0.8
        }).addTo(map);
    }
}

// Initial route setup on load
updateActiveRoute('{{ $order->status }}');

// ====== ROUTE LINE HISTORY ======
const locationHistory = [];

// Load initial location history
const trackingNumber = '{{ $order->tracking_number }}';

fetch(`/api/track/${trackingNumber}`)
    .then(res => res.json())
    .then(data => {
        if (data.success && data.locations.length > 0) {
            // Draw path history
            const pathCoords = data.locations.map(loc => [loc.latitude, loc.longitude]).reverse();
            L.polyline(pathCoords, {
                color: '#ff8c00',
                weight: 4,
                opacity: 0.8,
                dashArray: '8, 12'
            }).addTo(map);

            locationHistory.push(...pathCoords);

            // Fit map to show all points
            if (pathCoords.length > 1) {
                map.fitBounds(pathCoords, { padding: [50, 50] });
            }
        }
    })
    .catch(err => console.error('Failed to load location history:', err));

// ====== WEBSOCKET (Laravel Echo + Pusher) ======
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '{{ config('broadcasting.connections.pusher.key', env('PUSHER_APP_KEY')) }}',
    cluster: '{{ config('broadcasting.connections.pusher.options.cluster', env('PUSHER_APP_CLUSTER')) }}',
    forceTLS: false,
    wsHost: window.location.hostname,
    wsPort: 6001,
    wssPort: 6001,
    enabledTransports: ['ws', 'wss'],
    disableStats: true,
    @if(app()->environment('local'))
    wsHost: window.location.hostname,
    wsPort: 6001,
    @endif
});

// Listen for location updates
Echo.channel(`order.${trackingNumber}`)
    .listen('.location.updated', (data) => {
        console.log('Location updated:', data);

        const lat = data.latitude;
        const lng = data.longitude;
        const speed = data.speed;
        const heading = data.heading;

        // Update or create agent marker
        if (agentMarker) {
            agentMarker.setLatLng([lat, lng]);
            agentMarker.setPopupContent(`<b>Agent Location</b><br>Speed: ${speed} km/h<br>Heading: ${heading}`);
        } else {
            agentMarker = L.marker([lat, lng], { icon: agentIcon })
                .addTo(map)
                .bindPopup(`<b>Agent Location</b><br>Speed: ${speed} km/h`);
        }

        // Add to path history
        locationHistory.push([lat, lng]);
        if (locationHistory.length > 1) {
            L.polyline(locationHistory, {
                color: '#ff8c00',
                weight: 4,
                opacity: 0.8,
                dashArray: '8, 12'
            }).addTo(map);
        }

        // Pan map to new location
        map.panTo([lat, lng], { animate: true, duration: 1 });

        // Update live status
        updateLiveStatus(data);
    })
    .listen('.status.updated', (data) => {
        console.log('Status updated:', data);
        const newStatus = data.new_status;

        // 1. Update active route line on map
        updateActiveRoute(newStatus);

        // 2. Update status badge header
        const statusColors = { 'pending': '#00a8ff', 'transit': '#ff8c00', 'delivered': '#15c552', 'cancelled': '#f13848' };
        const badge = document.querySelector('.badge');
        if (badge) {
            badge.innerHTML = `<span class="bullet bullet-dot fs-2x me-1" style="background-color: ${statusColors[newStatus] || '#888'}"></span> ${newStatus.charAt(0).toUpperCase() + newStatus.slice(1)}`;
        }

        // 3. Update sidebar tags
        const targetBadge = document.getElementById('active-target-badge');
        if (targetBadge) {
            targetBadge.textContent = newStatus === 'pending' ? '📍 Heading to Pickup' : (newStatus === 'transit' ? '🎯 Heading to Drop-off' : '✔ Delivered');
        }

        const pickupTag = document.getElementById('pickup-status-tag');
        if (pickupTag) {
            pickupTag.className = `fs-9 badge ${newStatus === 'pending' ? 'badge-light-success' : 'badge-light'}`;
            pickupTag.textContent = newStatus === 'pending' ? 'ACTIVE TARGET' : 'PICKED UP ✔';
        }

        const deliveryTag = document.getElementById('delivery-status-tag');
        if (deliveryTag) {
            deliveryTag.className = `fs-9 badge ${newStatus === 'transit' ? 'badge-light-warning' : (newStatus === 'delivered' ? 'badge-light-success' : 'badge-light')}`;
            deliveryTag.textContent = newStatus === 'transit' ? 'ACTIVE TARGET 🎯' : (newStatus === 'delivered' ? 'DELIVERED ✔' : 'PENDING PICKUP');
        }

        const etaDisplay = document.getElementById('eta-display');
        if (etaDisplay) {
            etaDisplay.style.display = newStatus === 'transit' ? '' : 'none';
        }

        // 4. Update status messages
        if (newStatus === 'transit') {
            addLiveUpdate('📦 Package collected! Agent is en route to delivery destination.', 'warning');
        } else if (newStatus === 'delivered') {
            addLiveUpdate('🎉 Package delivered successfully to recipient!', 'success');
        }

        // 5. Update agent action buttons
        const agentContainer = document.getElementById('agent-action-buttons');
        if (agentContainer) {
            if (newStatus === 'transit') {
                agentContainer.innerHTML = `
                    <button type="button" class="btn btn-success btn-lg w-100 fw-bold shadow-sm" id="btn-confirm-delivery">
                        <i class="ki-duotone ki-check-circle fs-2 me-1"><span class="path1"></span><span class="path2"></span></i>
                        Mark as Delivered
                    </button>
                    <div class="fs-8 text-muted mt-2 text-center">Click when package is delivered to recipient.</div>
                `;
                bindAgentActionButtons();
            } else if (newStatus === 'delivered') {
                agentContainer.innerHTML = `
                    <div class="alert alert-success d-flex align-items-center mb-0 p-3 rounded-3">
                        <i class="ki-duotone ki-check-circle fs-2x text-success me-3"><span class="path1"></span><span class="path2"></span></i>
                        <span class="fs-6 fw-bold">Delivery Completed</span>
                    </div>
                `;
            }
        }
    });

// ====== HELPER FUNCTIONS ======
function updateLiveStatus(data) {
    const container = document.getElementById('live-updates');
    const time = new Date(data.recorded_at).toLocaleTimeString();

    container.innerHTML = `
        <div class="d-flex align-items-center gap-2">
            <div class="symbol symbol-25px">
                <div class="symbol-label bg-light-warning">
                    <i class="ki-duotone ki-truck fs-3 text-warning"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                </div>
            </div>
            <div>
                <div class="fs-8 text-dark fw-semibold">Agent moving at ${data.speed} km/h</div>
                <div class="fs-9 text-muted">Updated at ${time}</div>
            </div>
        </div>
    `;
}

function addLiveUpdate(message, type = 'info') {
    const container = document.getElementById('live-updates');
    const colors = { info: 'text-info', success: 'text-success', warning: 'text-warning', danger: 'text-danger' };
    container.innerHTML = `
        <div class="d-flex align-items-center gap-2">
            <span class="bullet bullet-dot bg-${type} fs-2x"></span>
            <span class="fs-7 ${colors[type] || 'text-muted'}">${message}</span>
        </div>
    ` + container.innerHTML;
}

// ====== BUTTON HANDLERS ======
document.getElementById('btn-center-marker')?.addEventListener('click', () => {
    if (agentMarker) {
        map.setView(agentMarker.getLatLng(), 15, { animate: true });
    }
});

document.getElementById('btn-fit-route')?.addEventListener('click', () => {
    if (locationHistory.length > 1) {
        map.fitBounds(locationHistory, { padding: [50, 50] });
    } else if (mapBounds.length > 0) {
        map.fitBounds(mapBounds, { padding: [80, 80] });
    }
});

// Bind Agent Action Buttons
function bindAgentActionButtons() {
    const btnPickup = document.getElementById('btn-confirm-pickup');
    if (btnPickup) {
        btnPickup.addEventListener('click', function() {
            updateOrderStatusAPI('transit', this);
        });
    }

    const btnDelivery = document.getElementById('btn-confirm-delivery');
    if (btnDelivery) {
        btnDelivery.addEventListener('click', function() {
            updateOrderStatusAPI('delivered', this);
        });
    }
}

function updateOrderStatusAPI(status, btn) {
    btn.disabled = true;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';

    fetch(`/api/orders/${trackingNumber}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ status: status })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            addLiveUpdate(`Status changed to ${status.toUpperCase()}`, 'success');
        } else {
            alert(data.message || 'Could not update status.');
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    })
    .catch(err => {
        alert('Error: ' + err.message);
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
}

bindAgentActionButtons();

// Simulation Movement Control
document.getElementById('btn-simulate')?.addEventListener('click', function() {
    this.disabled = true;
    this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Simulating...';

    fetch(`/api/orders/${trackingNumber}/simulate`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            addLiveUpdate('Location simulated successfully', 'success');
        } else {
            addLiveUpdate(data.message || 'Simulation failed', 'danger');
        }
    })
    .catch(err => {
        addLiveUpdate('Error: ' + err.message, 'danger');
    })
    .finally(() => {
        this.disabled = false;
        this.innerHTML = '<i class="ki-duotone ki-truck fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> Simulate Agent Movement';
    });
});

@else
// ====== TRACKING NUMBER FORM ======
document.getElementById('track-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const trackingNum = document.getElementById('track-input').value.trim();
    const errorEl = document.getElementById('track-error');

    if (!trackingNum) {
        errorEl.textContent = 'Please enter a tracking number.';
        errorEl.classList.remove('d-none');
        return;
    }

    window.location.href = `/track/${encodeURIComponent(trackingNum)}`;
});
@endif
</script>
@endpush
