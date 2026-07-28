@extends('layouts.metronic')

@section('title', 'Live Tracking')
@section('body_class', 'aside-enabled')
@section('page_title', 'Live Tracking')
@section('page_subtitle', 'Monitor your active delivery in real-time')

@section('sidebar')
    @include('partials.role-sidebar')
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="/" class="text-hover-primary" style="color: #94a3b8 !important; font-weight: 500; font-size: 1.1rem;">Home</a>
</li>
<li class="breadcrumb-item"><span style="color: #94a3b8; margin: 0 4px; font-weight: bold; font-size: 1.1rem;">-</span></li>
<li class="breadcrumb-item" style="color: #94a3b8; font-weight: 500; font-size: 1.1rem;">Live Tracking</li>
@endsection

@section('container_class', 'container-xxl')

@section('content')
<div class="row g-6">
    @if($activeOrder)
    <!-- Map Column -->
    <div class="col-lg-8">
        <div class="card card-flush h-100">
            <div class="card-header border-0 pt-6">
                <h3 class="card-title align-items-start flex-column">
                    <span class="fw-bold fs-3 mb-1">Interactive Map</span>
                    <span class="text-muted fs-7">Real-time driver location</span>
                </h3>
                <div class="card-toolbar">
                    <span class="badge badge-light-success d-flex align-items-center gap-1 fs-6">
                        <span class="bullet bullet-dot bg-success fs-3 animate-pulse"></span> LIVE
                    </span>
                </div>
            </div>
            <div class="card-body pt-0 px-0">
                <!-- Real Map Container -->
                <div id="tracking-map"></div>
            </div>
        </div>
    </div>

    <!-- Status Sidebar Column -->
    <div class="col-lg-4">
        <!-- Order Stats -->
        <div class="card card-flush bg-primary border-0 mb-6 theme-dark-bg">
            <div class="card-body py-9">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="text-white fw-bold fs-6 opacity-75">Tracking ID</div>
                    <div class="text-white fw-bolder fs-4 font-monospace">#{{ $activeOrder->tracking_number }}</div>
                </div>
                
                <div class="bg-white bg-opacity-20 rounded p-4 mb-4">
                    <div class="fs-8 text-white text-uppercase opacity-75 mb-1">Estimated Arrival</div>
                    <div class="fs-1 fw-bolder text-white font-monospace d-flex align-items-center">
                        <i class="ki-duotone ki-time fs-2x text-white me-2"><span class="path1"></span><span class="path2"></span></i>
                        {{ $activeOrder->status == 'transit' ? '12:00 MIN' : 'Pending Update' }}
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <div class="symbol symbol-40px symbol-circle">
                        <div class="symbol-label bg-white bg-opacity-20">
                            <i class="ki-duotone ki-user text-white fs-2"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <div class="d-flex flex-column">
                        <span class="text-white fw-bold fs-5">{{ $activeOrder->agent ? $activeOrder->agent->name : 'Searching for agent...' }}</span>
                        <span class="text-white opacity-75 fs-7">Delivery Agent</span>
                    </div>
                    @if($activeOrder->agent)
                    <a href="tel:{{ $activeOrder->agent->phone ?? '#' }}" class="btn btn-icon btn-light btn-sm ms-auto border-0">
                        <i class="ki-duotone ki-phone fs-4 text-primary"><span class="path1"></span><span class="path2"></span></i>
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tracking Timeline -->
        <div class="card card-flush">
            <div class="card-header pt-6">
                <h3 class="card-title fw-bolder text-dark">Delivery Status</h3>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <!-- Item 1 -->
                    <div class="timeline-item align-items-center mb-7">
                        <div class="timeline-line mt-1 mb-n6 bg-success"></div>
                        <div class="timeline-icon bg-light-success border-success">
                            <i class="ki-duotone ki-check fs-2 text-success"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <div class="timeline-content m-0">
                            <span class="fs-6 fw-bold text-dark d-block">Order Confirmed</span>
                            <span class="fs-8 text-muted">We received your tracking request.</span>
                            <span class="fs-9 text-muted d-block mt-1">{{ $activeOrder->created_at->format('g:i A, M d') }}</span>
                        </div>
                    </div>
                    
                    <!-- Item 2 -->
                    <div class="timeline-item align-items-center mb-7">
                        <div class="timeline-line mt-1 mb-n6 {{ $activeOrder->agent_id ? 'bg-success' : 'bg-gray-300' }}"></div>
                        <div class="timeline-icon {{ $activeOrder->agent_id ? 'bg-light-success border-success' : 'bg-light border-gray-300' }}">
                            @if($activeOrder->agent_id)
                            <i class="ki-duotone ki-check fs-2 text-success"><span class="path1"></span><span class="path2"></span></i>
                            @else
                            <i class="ki-duotone ki-delivery-time fs-2 text-muted"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                            @endif
                        </div>
                        <div class="timeline-content m-0">
                            <span class="fs-6 {{ $activeOrder->agent_id ? 'fw-bold text-dark' : 'text-muted' }} d-block">Agent Assigned & Picked Up</span>
                            <span class="fs-8 text-muted">{{ $activeOrder->agent_id ? 'An agent has picked up your package at ' . $activeOrder->pickup_address : 'Waiting for agent to accept.' }}</span>
                        </div>
                    </div>

                    <!-- Item 3 -->
                    <div class="timeline-item align-items-center mb-7">
                        <div class="timeline-line mt-1 mb-n6 {{ $activeOrder->status == 'transit' ? 'bg-warning' : 'bg-gray-300' }}"></div>
                        <div class="timeline-icon {{ $activeOrder->status == 'transit' ? 'bg-light-warning border-warning pulse' : 'bg-light border-gray-300' }}">
                            @if($activeOrder->status == 'transit')
                            <i class="ki-duotone ki-truck fs-2 text-warning"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            @else
                            <span class="fs-5 text-gray-500">3</span>
                            @endif
                        </div>
                        <div class="timeline-content m-0">
                            <span class="fs-6 {{ $activeOrder->status == 'transit' ? 'fw-bold text-warning' : 'text-muted' }} d-block">In Transit</span>
                            <span class="fs-8 text-muted">Heading to {{ $activeOrder->delivery_address }}</span>
                        </div>
                    </div>

                    <!-- Item 4 -->
                    <div class="timeline-item align-items-center">
                        <div class="timeline-icon bg-light border-gray-300 opacity-50">
                            <i class="ki-duotone ki-home fs-2 text-muted"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <div class="timeline-content m-0 opacity-50">
                            <span class="fs-6 text-muted d-block">Delivered</span>
                            <span class="fs-8 text-muted">Package will arrive at destination.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="col-12">
        <div class="card card-flush">
            <div class="card-body text-center py-15">
                <i class="ki-duotone ki-geolocation fs-5x text-muted mb-4"><span class="path1"></span><span class="path2"></span></i>
                <h3 class="fs-2 fw-bolder text-dark mb-2">No Active Deliveries</h3>
                <p class="fs-5 text-muted mb-8">You don't have any packages currently in transit.</p>
                <a href="{{ route('orders.place') }}" class="btn btn-primary btn-lg">Place a New Order</a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<style>
    .leaflet-container { background: var(--sd-surface-100, #f1f5f9) !important; width: 100%; height: 100%; min-height: 500px; border-radius: 0.625rem; }
    .pickup-pin { width:24px; height:24px; background:#15c552; border-radius:50%; border:3px solid #fff; box-shadow:0 2px 6px rgba(0,0,0,.3); }
    .delivery-pin { width:24px; height:24px; background:#ff8c00; border-radius:50%; border:3px solid #fff; box-shadow:0 2px 6px rgba(0,0,0,.3); }
    .agent-pin { width:32px; height:32px; background:#009ef7; border-radius:50%; border:3px solid #fff; box-shadow:0 1px 12px rgba(0,158,247,0.5); display: flex; align-items: center; justify-content: center; }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if($activeOrder)
        const pickup = [{{ $activeOrder->pickup_lat }}, {{ $activeOrder->pickup_lng }}];
        const delivery = [{{ $activeOrder->delivery_lat }}, {{ $activeOrder->delivery_lng }}];
        
        const map = L.map('tracking-map', { zoomControl: true }).setView(pickup, 13);

        const tileUrls = {
            dark: 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png',
            light: 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png'
        };

        function getSystemTheme() {
            return document.documentElement.getAttribute('data-bs-theme') || 'light';
        }

        let activeTileLayer = L.tileLayer(tileUrls[getSystemTheme()], {
            attribution: '&copy; OpenStreetMap &copy; CARTO',
            subdomains: 'abcd', maxZoom: 20
        }).addTo(map);

        // Theme observer
        const themeObserver = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.attributeName === 'data-bs-theme') {
                    const mode = document.documentElement.getAttribute('data-bs-theme');
                    if (tileUrls[mode]) {
                        map.removeLayer(activeTileLayer);
                        activeTileLayer = L.tileLayer(tileUrls[mode], {
                            attribution: '&copy; OpenStreetMap &copy; CARTO',
                            subdomains: 'abcd', maxZoom: 20
                        }).addTo(map);
                    }
                }
            });
        });
        themeObserver.observe(document.documentElement, { attributes: true });

        // Icons
        const pickupIcon = L.divIcon({ className: '', html: '<div class="pickup-pin"></div>', iconSize: [24,24], iconAnchor: [12,12] });
        const deliveryIcon = L.divIcon({ className: '', html: '<div class="delivery-pin"></div>', iconSize: [24,24], iconAnchor: [12,12] });
        const agentIcon = L.divIcon({ className: '', html: '<div class="agent-pin"><i class="ki-duotone ki-delivery-3 text-white fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></div>', iconSize: [32,32], iconAnchor: [16,16] });

        // Markers & Route
        L.marker(pickup, { icon: pickupIcon }).addTo(map).bindPopup('Pickup: {{ $activeOrder->pickup_address }}');
        L.marker(delivery, { icon: deliveryIcon }).addTo(map).bindPopup('Delivery: {{ $activeOrder->delivery_address }}');
        
        const routeLine = L.polyline([pickup, delivery], {
            color: '#009ef7', // Standard blue for transit route
            weight: 5,
            opacity: 0.5,
            dashArray: '10, 15',
            lineJoin: 'round'
        }).addTo(map);

        // Fit map to show full route
        map.fitBounds(routeLine.getBounds(), { padding: [100, 100] });

        // Agent marker (In Transit simulation or static if not moving yet)
        @if($activeOrder->status == 'transit')
            let agentMarker = L.marker([{{ $activeOrder->current_lat ?? $activeOrder->pickup_lat }}, {{ $activeOrder->current_lng ?? $activeOrder->pickup_lng }}], { icon: agentIcon }).addTo(map).bindPopup('Agent is currently here');
        @endif
        @endif
    });
</script>
@endpush
