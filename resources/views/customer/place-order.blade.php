@extends('layouts.metronic')

@section('title', 'Place Order')
@section('body_class', 'aside-enabled')
@section('page_title', 'Send a Package')
@section('page_subtitle', 'Fill in the details below to request a delivery')

@section('sidebar')
    @include('partials.role-sidebar')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item text-muted"><a href="/" class="text-muted text-hover-primary">Home</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-muted">Send a Package</li>
@endsection

@section('container_class', 'container-xxl')

@section('content')
<div class="liquid-mesh-container">
<div class="liquid-mesh-bg"></div>

    <!--begin::Liquid Glass Header-->
    <div class="text-center mb-6">
        <div class="liquid-badge liquid-badge-primary mb-2">
            <span class="bullet bullet-dot bg-warning fs-2x animate-pulse"></span> Instant Dispatch
        </div>
        <h1 class="page-heading fs-2x fw-bolder text-dark">Send a Package</h1>
        <p class="text-muted fs-6 mt-1">Fill in the details below to request a fast delivery anywhere in Nigeria.</p>
    </div>

    @include('partials.hammshop-promo')

    <!--begin::Step Indicator-->
    <div class="d-flex align-items-center justify-content-center mb-6">
        <div class="d-flex align-items-center gap-3 liquid-glass-pill p-3 px-5">
            <div class="d-flex align-items-center gap-2" id="step-indicator-1">
                <div class="symbol symbol-30px bg-primary bg-opacity-25 rounded-circle" data-step="1"><span
                        class="symbol-label text-primary fw-bolder fs-6">1</span></div>
                <span class="text-dark fw-bold d-none d-sm-inline">Addresses</span>
            </div>
            <div class="bullet bg-primary h-2px w-20px" id="step-line-1"></div>
            <div class="d-flex align-items-center gap-2 opacity-50" id="step-indicator-2">
                <div class="symbol symbol-30px bg-light rounded-circle" data-step="2"><span
                        class="symbol-label text-muted fw-bolder fs-6">2</span></div>
                <span class="text-muted fw-bold d-none d-sm-inline">Package</span>
            </div>
            <div class="bullet bg-gray-300 h-2px w-20px" id="step-line-2"></div>
            <div class="d-flex align-items-center gap-2 opacity-50" id="step-indicator-3">
                <div class="symbol symbol-30px bg-light rounded-circle" data-step="3"><span
                        class="symbol-label text-muted fw-bolder fs-6">3</span></div>
                <span class="text-muted fw-bold d-none d-sm-inline">Review</span>
            </div>
        </div>
    </div>
    <!--end::Step Indicator-->

    <!--begin::Main Content Grid-->
    <div class="row g-6">
        <!-- Form Area -->
        <div class="col-lg-8">
            <form id="place-order-form" method="POST" action="{{ route('orders.store') }}">
                @csrf
                <!-- Step 1: Addresses + Map -->
                <div class="order-step" id="order-step-1">
                    <div class="liquid-glass-card mb-4">
                        <div class="card-header p-5 pb-0 border-0">
                            <h3 class="card-title fw-bolder text-dark fs-4 d-flex align-items-center gap-2 mb-0">
                                <i class="ki-duotone ki-geolocation fs-4 text-primary"><span class="path1"></span><span
                                        class="path2"></span></i>
                                Addresses
                            </h3>
                        </div>
                        <div class="card-body p-5">
                            <!-- Pickup Section -->
                            <div class="mb-5">
                                <h4 class="fs-6 fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                                    <span class="bullet bullet-dot bg-success fs-2x"></span>
                                    Pickup Information
                                </h4>
                                <div class="row g-4">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-dark fs-6" for="pickup-address">Pickup
                                            Address</label>
                                        <div class="input-group">
                                            <input type="text" id="pickup-address" name="pickup_address"
                                                class="form-control form-control-solid"
                                                placeholder="e.g. 12 Zoo Road, Kano">
                                            <button type="button" class="btn btn-light-primary" id="btn-geolocate"
                                                title="Use my current location">
                                                <i class="ki-duotone ki-geolocation fs-3"><span class="path1"></span><span
                                                        class="path2"></span></i>
                                            </button>
                                        </div>
                                        <div class="invalid-feedback d-none" id="error-pickup-address">Please set a pickup
                                            address on the map.</div>
                                        <input type="hidden" id="pickup_lat" name="pickup_lat">
                                        <input type="hidden" id="pickup_lng" name="pickup_lng">
                                        <small class="text-muted d-block mt-1" id="pickup-coords-display"></small>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label fw-semibold text-dark fs-6">Pickup Contact Name</label>
                                        <input type="text" class="form-control form-control-solid" id="pickup-contact"
                                            name="pickup_contact" placeholder="e.g. Amina Yusuf">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label fw-semibold text-dark fs-6">Pickup Phone</label>
                                        <input type="tel" class="form-control form-control-solid" id="pickup-phone"
                                            name="pickup_phone" placeholder="+234 801 234 5678">
                                    </div>
                                </div>
                            </div>
                            <div class="separator my-5"></div>
                            <!-- Delivery Section -->
                            <div>
                                <h4 class="fs-6 fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                                    <span class="bullet bullet-dot bg-primary fs-2x"></span>
                                    Delivery Information
                                </h4>
                                <div class="row g-4">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-dark fs-6" for="delivery-address">Delivery
                                            Address</label>
                                        <input type="text" id="delivery-address" name="delivery_address"
                                            class="form-control form-control-solid"
                                            placeholder="e.g. 45 Murtala Mohd Way, Kano">
                                        <div class="invalid-feedback d-none" id="error-delivery-address">Please set a
                                            delivery address on the map.</div>
                                        <input type="hidden" id="delivery_lat" name="delivery_lat">
                                        <input type="hidden" id="delivery_lng" name="delivery_lng">
                                        <small class="text-muted d-block mt-1" id="delivery-coords-display"></small>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label fw-semibold text-dark fs-6">Recipient Name</label>
                                        <input type="text" class="form-control form-control-solid" id="delivery-contact"
                                            name="delivery_contact" placeholder="e.g. Ibrahim Musa">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label fw-semibold text-dark fs-6">Recipient Phone</label>
                                        <input type="tel" class="form-control form-control-solid" id="delivery-phone"
                                            name="delivery_phone" placeholder="+234 802 345 6789">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Map Picker -->
                    <div class="card card-flush mb-4">
                        <div class="card-header py-4 d-flex justify-content-between align-items-center">
                            <h3 class="card-title fw-bolder text-dark fs-4 d-flex align-items-center gap-2">
                                <i class="ki-duotone ki-map fs-4 text-primary"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span></i>
                                Pick Locations on Map
                            </h3>
                            <span class="fs-8 text-muted" id="map-hint">Click to set <b class="text-success">pickup</b>
                                first</span>
                        </div>
                        <div class="card-body p-0">
                            <div id="order-map" style="height: 380px; width: 100%;"></div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary btn-lg w-100" onclick="goToOrderStep(2)" id="order-next-1">
                        Continue to Package Details
                        <i class="ki-duotone ki-arrow-right fs-3"><span class="path1"></span><span class="path2"></span></i>
                    </button>
                </div>

                <!-- Step 2: Package Details -->
                <div class="order-step d-none" id="order-step-2">
                    <div class="card card-flush mb-4">
                        <div class="card-header py-4">
                            <h3 class="card-title fw-bolder text-dark fs-4 d-flex align-items-center gap-2">
                                <i class="ki-duotone ki-package fs-4 text-primary"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span></i>
                                Package Details
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark fs-6" for="package-desc">Package
                                    Description</label>
                                <input type="text" id="package-desc" name="package_desc"
                                    class="form-control form-control-solid"
                                    placeholder="e.g. Electronics, documents, food...">
                                <div class="invalid-feedback d-none" id="error-package-desc">Please describe what is in the
                                    package.</div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark fs-6">Package Size</label>
                                <div class="row g-3">
                                    <div class="col-4">
                                        <label class="card card-flush card-hover cursor-pointer text-center p-4 h-100">
                                            <input type="radio" name="package_size" value="small" class="btn-check" checked>
                                            <div class="symbol symbol-50px mx-auto mb-3">
                                                <div class="symbol-label bg-light"><i
                                                        class="ki-duotone ki-package fs-3 text-muted"><span
                                                            class="path1"></span><span class="path2"></span><span
                                                            class="path3"></span></i></div>
                                            </div>
                                            <div class="fs-6 fw-bold text-dark">Small</div>
                                            <div class="fs-8 text-primary font-monospace">₦500</div>
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <label class="card card-flush card-hover cursor-pointer text-center p-4 h-100">
                                            <input type="radio" name="package_size" value="medium" class="btn-check">
                                            <div class="symbol symbol-50px mx-auto mb-3">
                                                <div class="symbol-label bg-light"><i
                                                        class="ki-duotone ki-package fs-2 text-muted"><span
                                                            class="path1"></span><span class="path2"></span><span
                                                            class="path3"></span></i></div>
                                            </div>
                                            <div class="fs-6 fw-bold text-dark">Medium</div>
                                            <div class="fs-8 text-primary font-monospace">₦1,000</div>
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <label class="card card-flush card-hover cursor-pointer text-center p-4 h-100">
                                            <input type="radio" name="package_size" value="large" class="btn-check">
                                            <div class="symbol symbol-50px mx-auto mb-3">
                                                <div class="symbol-label bg-light"><i
                                                        class="ki-duotone ki-package fs-1 text-muted"><span
                                                            class="path1"></span><span class="path2"></span><span
                                                            class="path3"></span></i></div>
                                            </div>
                                            <div class="fs-6 fw-bold text-dark">Large</div>
                                            <div class="fs-8 text-primary font-monospace">₦2,000</div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" id="fragile-check" name="is_fragile"
                                        value="1" />
                                    <span class="form-check-label text-dark fw-semibold fs-6">Package is fragile <span
                                            class="text-muted fw-normal">(extra care +₦200)</span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <button type="button" class="btn btn-outline flex-1" onclick="goToOrderStep(1)"><i
                                class="ki-duotone ki-arrow-left fs-3"><span class="path1"></span><span
                                    class="path2"></span></i> Back</button>
                        <button type="button" class="btn btn-primary flex-1 btn-lg" onclick="goToOrderStep(3)"
                            id="order-next-2">Review Order <i class="ki-duotone ki-arrow-right fs-3"><span
                                    class="path1"></span><span class="path2"></span></i></button>
                    </div>
                </div>

                <!-- Step 3: Review -->
                <div class="order-step d-none" id="order-step-3">
                    <div class="card card-flush mb-4">
                        <div class="card-header py-4">
                            <h3 class="card-title fw-bolder text-dark fs-4 d-flex align-items-center gap-2">
                                <i class="ki-duotone ki-check-square fs-4 text-primary"><span class="path1"></span><span
                                        class="path2"></span></i>
                                Review Order
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="bg-light rounded p-4 mb-4">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="d-flex flex-column align-items-center mt-1">
                                        <div class="w-10px h-10px rounded-circle bg-success"></div>
                                        <div class="w-2px h-40px bg-gradient-success-primary"></div>
                                        <div class="w-10px h-10px rounded-circle bg-primary"></div>
                                    </div>
                                    <div class="flex-grow-1 d-flex flex-column justify-content-between gap-2">
                                        <div>
                                            <div class="fs-8 text-muted text-uppercase">Pickup</div>
                                            <div class="fs-6 text-dark" id="review-pickup">—</div>
                                            <div class="fs-7 text-muted" id="review-pickup-contact"></div>
                                        </div>
                                        <div>
                                            <div class="fs-8 text-muted text-uppercase">Delivery</div>
                                            <div class="fs-6 text-dark" id="review-delivery">—</div>
                                            <div class="fs-7 text-muted" id="review-delivery-contact"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-light rounded p-4 mb-4">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <div class="fs-8 text-muted text-uppercase">Package</div>
                                        <div class="fs-6 text-dark" id="review-package">—</div>
                                    </div>
                                    <div class="text-end">
                                        <div class="fs-8 text-muted text-uppercase">Size</div>
                                        <div class="fs-6 text-dark text-uppercase" id="review-size">—</div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column gap-2 fs-7 border-top pt-4">
                                <div class="d-flex justify-between"><span class="text-muted">Base fare</span><span
                                        class="font-monospace text-dark" id="review-base">₦500</span></div>
                                <div class="d-flex justify-between d-none" id="review-fragile-row"><span
                                        class="text-muted">Fragile handling</span><span
                                        class="font-monospace text-dark">₦200</span></div>
                                <div class="d-flex justify-between"><span class="text-muted">Service fee</span><span
                                        class="font-monospace text-dark">₦100</span></div>
                                <div class="separator"></div>
                                <div class="d-flex justify-between fs-5"><span class="text-dark fw-bold">Total</span><span
                                        class="font-monospace text-primary fw-bolder" id="review-total">₦600</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <button type="button" class="btn btn-outline flex-1" onclick="goToOrderStep(2)"><i
                                class="ki-duotone ki-arrow-left fs-3"><span class="path1"></span><span
                                    class="path2"></span></i> Back</button>
                        <button type="submit" class="btn btn-primary flex-1 btn-lg" id="order-confirm"
                            onclick="this.innerHTML='<span class=\'spinner-border spinner-border-sm me-2\'></span>Processing...';">
                            <i class="ki-duotone ki-check-circle fs-3"><span class="path1"></span><span
                                    class="path2"></span></i> Confirm & Pay
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="liquid-glass-card sticky-top" id="order-summary-card" style="top:100px;">
                <div class="card-header p-5 pb-0 border-0">
                    <h3 class="card-title fw-bolder text-dark fs-4 mb-0">ORDER SUMMARY</h3>
                </div>
                <div class="card-body p-5">
                    <div class="d-flex flex-column gap-3 mb-4">
                        <div class="d-flex align-items-start gap-2">
                            <div class="symbol symbol-20px">
                                <div class="symbol-label bg-light-success">
                                    <div class="w-8px h-8px rounded-circle bg-success"></div>
                                </div>
                            </div>
                            <div>
                                <div class="fs-8 text-muted text-uppercase">From</div>
                                <div class="fs-7 text-dark" id="summary-from">Enter pickup address</div>
                                <div class="fs-8 text-muted" id="summary-from-contact"></div>
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-2">
                            <div class="symbol symbol-20px">
                                <div class="symbol-label bg-light-primary">
                                    <div class="w-8px h-8px rounded-circle bg-primary"></div>
                                </div>
                            </div>
                            <div>
                                <div class="fs-8 text-muted text-uppercase">To</div>
                                <div class="fs-7 text-dark" id="summary-to">Enter delivery address</div>
                                <div class="fs-8 text-muted" id="summary-to-contact"></div>
                            </div>
                        </div>
                    </div>

                    <div class="separator my-4"></div>

                    <div class="d-flex flex-column gap-2 mb-4">
                        <div class="d-flex justify-content-between fs-7">
                            <span class="text-muted">Package:</span>
                            <span class="text-dark fw-semibold" id="summary-package">—</span>
                        </div>
                        <div class="d-flex justify-content-between fs-7">
                            <span class="text-muted">Size:</span>
                            <span class="text-dark fw-semibold" id="summary-size">Small</span>
                        </div>
                        <div class="d-flex justify-content-between fs-7 d-none" id="summary-fragile-row">
                            <span class="text-muted">Fragile Handling:</span>
                            <span class="text-dark fw-semibold">+₦200</span>
                        </div>
                        <div class="d-flex justify-content-between fs-7">
                            <span class="text-muted">Service Fee:</span>
                            <span class="text-dark fw-semibold">₦100</span>
                        </div>
                    </div>

                    <div class="separator my-4"></div>

                    <div class="d-flex justify-content-between align-items-center bg-light rounded-4 p-4 border">
                        <span class="fs-7 text-dark fw-bold text-uppercase">Total Estimated:</span>
                        <div class="fs-2 fw-bolder text-warning font-monospace" id="summary-price">₦600</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Main Content Grid-->
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    <style>
        .leaflet-container {
            background: var(--sd-surface-100, #fcfcfc) !important;
        }

        .pickup-pin {
            width: 24px;
            height: 24px;
            background: #15c552;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .3);
        }

        .delivery-pin {
            width: 24px;
            height: 24px;
            background: #ff8c00;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .3);
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script>
        KTComponents.init();

        // ====== LEAFLET MAP ======
        const KANO_CENTER = [12.0022, 8.5920];
        const map = L.map('order-map', { zoomControl: true }).setView(KANO_CENTER, 13);

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

        // Theme listener
        window.addEventListener('storage', (e) => {
            if (e.key === 'data-bs-theme') updateMapTheme(e.newValue);
        });

        // Since we're using custom toggle, we can also watch for attribute changes
        const themeObserver = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.attributeName === 'data-bs-theme') {
                    updateMapTheme(document.documentElement.getAttribute('data-bs-theme'));
                }
            });
        });
        themeObserver.observe(document.documentElement, { attributes: true });

        function updateMapTheme(mode) {
            if (!tileUrls[mode]) return;
            map.removeLayer(activeTileLayer);
            activeTileLayer = L.tileLayer(tileUrls[mode], {
                attribution: '&copy; OpenStreetMap &copy; CARTO',
                subdomains: 'abcd', maxZoom: 20
            }).addTo(map);
        }

        let mapMode = 'pickup'; // 'pickup' or 'delivery'
        let pickupMarker = null, deliveryMarker = null, routeLine = null;

        const pickupIcon = L.divIcon({ className: '', html: '<div class="pickup-pin"></div>', iconSize: [24, 24], iconAnchor: [12, 12] });
        const deliveryIcon = L.divIcon({ className: '', html: '<div class="delivery-pin"></div>', iconSize: [24, 24], iconAnchor: [12, 12] });

        function updateRouteLine() {
            if (pickupMarker && deliveryMarker) {
                const points = [pickupMarker.getLatLng(), deliveryMarker.getLatLng()];
                if (routeLine) {
                    routeLine.setLatLngs(points);
                } else {
                    routeLine = L.polyline(points, {
                        color: '#ff8c00', // Using Brand Orange for the line
                        weight: 4,
                        opacity: 0.6,
                        dashArray: '10, 10',
                        lineJoin: 'round'
                    }).addTo(map);
                }
                map.fitBounds(routeLine.getBounds(), { padding: [50, 50] });
            }
        }

        async function reverseGeocode(lat, lng, targetId) {
            const input = document.getElementById(targetId);
            if (!input) return;

            // Show loading state in input
            const originalPlaceholder = input.placeholder;
            input.placeholder = "Locating address...";

            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
                const data = await response.json();
                if (data.display_name) {
                    input.value = data.display_name;
                    // Trigger input event to update summary sidebar
                    input.dispatchEvent(new Event('input'));
                }
            } catch (error) {
                console.error('Geocoding error:', error);
            } finally {
                input.placeholder = originalPlaceholder;
            }
        }

        function setCoords(mode, lat, lng) {
            if (mode === 'pickup') {
                document.getElementById('pickup_lat').value = lat.toFixed(7);
                document.getElementById('pickup_lng').value = lng.toFixed(7);
                document.getElementById('pickup-coords-display').textContent = `📍 ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                reverseGeocode(lat, lng, 'pickup-address');
            } else {
                document.getElementById('delivery_lat').value = lat.toFixed(7);
                document.getElementById('delivery_lng').value = lng.toFixed(7);
                document.getElementById('delivery-coords-display').textContent = `📍 ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                reverseGeocode(lat, lng, 'delivery-address');
            }
            updateRouteLine();
        }

        map.on('click', function (e) {
            const { lat, lng } = e.latlng;

            if (mapMode === 'pickup') {
                if (pickupMarker) pickupMarker.setLatLng(e.latlng);
                else pickupMarker = L.marker(e.latlng, { icon: pickupIcon, draggable: true }).addTo(map);
                pickupMarker.on('dragend', function (ev) {
                    const p = ev.target.getLatLng();
                    setCoords('pickup', p.lat, p.lng);
                });
                setCoords('pickup', lat, lng);

                // Switch mode to delivery
                mapMode = 'delivery';
                document.getElementById('map-mode-pickup').classList.remove('active');
                document.getElementById('map-mode-delivery').classList.add('active');
                document.getElementById('map-hint').innerHTML = 'Now click to set <b class="text-primary">delivery</b> location';
            } else {
                if (deliveryMarker) deliveryMarker.setLatLng(e.latlng);
                else deliveryMarker = L.marker(e.latlng, { icon: deliveryIcon, draggable: true }).addTo(map);
                deliveryMarker.on('dragend', function (ev) {
                    const p = ev.target.getLatLng();
                    setCoords('delivery', p.lat, p.lng);
                });
                setCoords('delivery', lat, lng);

                document.getElementById('map-hint').innerHTML = 'Both set! Click to adjust <b class="text-success">pickup</b> or <b class="text-primary">delivery</b>';
            }
        });

        // Mode toggle buttons
        document.getElementById('map-mode-pickup').addEventListener('click', function () {
            mapMode = 'pickup';
            this.classList.add('active');
            document.getElementById('map-mode-delivery').classList.remove('active');
            document.getElementById('map-hint').innerHTML = 'Click to set <b class="text-success">pickup</b> location';
        });
        document.getElementById('map-mode-delivery').addEventListener('click', function () {
            mapMode = 'delivery';
            this.classList.add('active');
            document.getElementById('map-mode-pickup').classList.remove('active');
            document.getElementById('map-hint').innerHTML = 'Click to set <b class="text-primary">delivery</b> location';
        });

        // Geolocate button
        document.getElementById('btn-geolocate').addEventListener('click', function () {
            if (!navigator.geolocation) { alert('Geolocation not supported'); return; }
            this.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
            navigator.geolocation.getCurrentPosition(pos => {
                const lat = pos.coords.latitude, lng = pos.coords.longitude;
                map.setView([lat, lng], 16);
                if (pickupMarker) pickupMarker.setLatLng([lat, lng]);
                else pickupMarker = L.marker([lat, lng], { icon: pickupIcon, draggable: true }).addTo(map);
                pickupMarker.on('dragend', function (ev) {
                    const p = ev.target.getLatLng();
                    setCoords('pickup', p.lat, p.lng);
                });
                setCoords('pickup', lat, lng);
                mapMode = 'delivery';
                document.getElementById('map-mode-delivery').classList.add('active');
                document.getElementById('map-mode-pickup').classList.remove('active');
                this.innerHTML = '<i class="ki-duotone ki-geolocation fs-3"><span class="path1"></span><span class="path2"></span></i>';
            }, () => {
                alert('Unable to get your location');
                this.innerHTML = '<i class="ki-duotone ki-geolocation fs-3"><span class="path1"></span><span class="path2"></span></i>';
            });
        });

        // ====== STEP NAVIGATION ======
        function validateStep(step) {
            let isValid = true;

            // Hide all errors first
            document.querySelectorAll('.invalid-feedback').forEach(el => el.classList.add('d-none'));

            if (step === 1) {
                if (!document.getElementById('pickup-address').value) {
                    document.getElementById('error-pickup-address').classList.remove('d-none');
                    isValid = false;
                }
                if (!document.getElementById('delivery-address').value) {
                    document.getElementById('error-delivery-address').classList.remove('d-none');
                    isValid = false;
                }
            } else if (step === 2) {
                if (!document.getElementById('package-desc').value.trim()) {
                    document.getElementById('error-package-desc').classList.remove('d-none');
                    isValid = false;
                }
            }
            return isValid;
        }

        function goToOrderStep(step) {
            const currentStep = step === 2 ? 1 : 2; // Simple math for next button
            if (step > currentStep && !validateStep(currentStep)) return;

            document.querySelectorAll('.order-step').forEach(el => el.classList.add('d-none'));
            document.getElementById('order-step-' + step).classList.remove('d-none');
            for (let i = 1; i <= 3; i++) {
                const indicator = document.getElementById('step-indicator-' + i);
                const symbol = indicator.querySelector('.symbol');
                const label = indicator.querySelector('span:last-child');
                if (i <= step) {
                    indicator.classList.remove('opacity-50');
                    symbol.classList.remove('bg-light'); symbol.classList.add('bg-primary', 'bg-opacity-25');
                    symbol.querySelector('.symbol-label').classList.remove('text-muted'); symbol.querySelector('.symbol-label').classList.add('text-primary');
                    if (label) { label.classList.remove('text-muted'); label.classList.add('text-dark'); }
                } else {
                    indicator.classList.add('opacity-50');
                    symbol.classList.remove('bg-primary', 'bg-opacity-25'); symbol.classList.add('bg-light');
                    symbol.querySelector('.symbol-label').classList.remove('text-primary'); symbol.querySelector('.symbol-label').classList.add('text-muted');
                    if (label) { label.classList.remove('text-dark'); label.classList.add('text-muted'); }
                }
            }
            for (let i = 1; i <= 2; i++) {
                const line = document.getElementById('step-line-' + i);
                if (i < step) { line.classList.remove('bg-gray-300'); line.classList.add('bg-primary'); }
                else { line.classList.remove('bg-primary'); line.classList.add('bg-gray-300'); }
            }
            if (step === 3) updateReview();
            setTimeout(() => map.invalidateSize(), 200);
        }

        function updateReview() {
            document.getElementById('review-pickup').textContent = document.getElementById('pickup-address').value || '—';
            document.getElementById('review-delivery').textContent = document.getElementById('delivery-address').value || '—';
            document.getElementById('review-package').textContent = document.getElementById('package-desc').value || '—';
            const sizeRadio = document.querySelector('input[name="package_size"]:checked');
            const size = sizeRadio ? sizeRadio.value : 'small';
            const prices = { small: '₦500', medium: '₦1,000', large: '₦2,000' };
            document.getElementById('review-size').textContent = size.charAt(0).toUpperCase() + size.slice(1);
            document.getElementById('review-base').textContent = prices[size];

            // Contact Info
            const pContact = document.getElementById('pickup-contact').value;
            const pPhone = document.getElementById('pickup-phone').value;
            document.getElementById('review-pickup-contact').textContent = (pContact || pPhone) ? `${pContact} (${pPhone})` : '';

            const dContact = document.getElementById('delivery-contact').value;
            const dPhone = document.getElementById('delivery-phone').value;
            document.getElementById('review-delivery-contact').textContent = (dContact || dPhone) ? `${dContact} (${dPhone})` : '';

            const fragile = document.getElementById('fragile-check').checked;
            document.getElementById('review-fragile-row').classList.toggle('d-none', !fragile);
            const basePrice = { small: 500, medium: 1000, large: 2000 }[size];
            const total = basePrice + (fragile ? 200 : 0) + 100;
            document.getElementById('review-total').textContent = '₦' + total.toLocaleString();
        }

        // Live sidebar
        document.getElementById('pickup-address').addEventListener('input', function () { document.getElementById('summary-from').textContent = this.value || 'Enter pickup address'; });
        document.getElementById('delivery-address').addEventListener('input', function () { document.getElementById('summary-to').textContent = this.value || 'Enter delivery address'; });
        document.getElementById('package-desc').addEventListener('input', function () { document.getElementById('summary-package').textContent = this.value || '—'; });
        document.querySelectorAll('input[name="package_size"]').forEach(r => r.addEventListener('change', function () {
            const prices = { small: '₦600', medium: '₦1,100', large: '₦2,100' };
            document.getElementById('summary-size').textContent = this.value.charAt(0).toUpperCase() + this.value.slice(1);
            document.getElementById('summary-price').textContent = prices[this.value];
        }));
        document.getElementById('fragile-check').addEventListener('change', function () {
            document.getElementById('summary-fragile-row').classList.toggle('d-none', !this.checked);
        });

        // Live contact summaries
        const updateContactSummary = (type) => {
            const contact = document.getElementById(`${type}-contact`).value;
            const phone = document.getElementById(`${type}-phone`).value;
            const summaryId = type === 'pickup' ? 'summary-from-contact' : 'summary-to-contact';
            document.getElementById(summaryId).textContent = (contact || phone) ? `${contact} ${phone}` : '';
        };
        document.getElementById('pickup-contact').addEventListener('input', () => updateContactSummary('pickup'));
        document.getElementById('pickup-phone').addEventListener('input', () => updateContactSummary('pickup'));
        document.getElementById('delivery-contact').addEventListener('input', () => updateContactSummary('delivery'));
        document.getElementById('delivery-phone').addEventListener('input', () => updateContactSummary('delivery'));
    </script>
@endpush