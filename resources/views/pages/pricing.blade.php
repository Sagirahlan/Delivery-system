@extends('layouts.metronic')

@section('title', 'Pricing — HMLL Logistics')
@section('meta_description', 'Transparent and affordable delivery rates across Nigeria. No surge fees or hidden charges.')

@section('content')
<style>
    :root {
        --glass-bg: rgba(255, 255, 255, 0.08);
        --glass-border: rgba(255, 255, 255, 0.2);
        --glass-shadow: 0 20px 50px -14px rgba(0, 0, 0, 0.4);
    }
    [data-bs-theme="light"] {
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 255, 255, 0.8);
        --glass-shadow: 0 20px 45px -16px rgba(31, 38, 135, 0.15);
    }
    .pricing-hero {
        position: relative;
        z-index: 0;
        border-radius: 28px;
        padding: 4rem 2rem;
        margin-bottom: 3rem;
        overflow: hidden;
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 41, 59, 0.95) 100%);
        border: 1px solid var(--glass-border);
        box-shadow: var(--glass-shadow);
        text-align: center;
    }
    .pricing-card-glass {
        background: var(--glass-bg);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        box-shadow: var(--glass-shadow);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
    }
    .pricing-card-glass:hover {
        transform: translateY(-8px);
    }
    .popular-badge-custom {
        position: absolute;
        top: -14px;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(135deg, #ff8c00 0%, #ff5252 100%);
        color: white;
        padding: 6px 18px;
        border-radius: 50px;
        font-weight: 800;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 4px 15px rgba(255, 140, 0, 0.4);
    }
</style>

<!-- Hero Section -->
<div class="pricing-hero text-white">
    <div class="max-w-700px mx-auto">
        <span class="badge bg-warning bg-opacity-20 text-warning px-4 py-2 rounded-pill fs-7 fw-bolder mb-4 text-uppercase tracking-wider">
            FAIR & TRANSPARENT RATES
        </span>
        <h1 class="display-4 fw-bolder text-white mb-3">
            Simple Pricing for <span class="text-warning">Every Package</span>
        </h1>
        <p class="fs-5 text-white text-opacity-80 leading-relaxed mb-0">
            No surge charges, no hidden fees. Affordable door-to-door delivery across Lagos, Kano, Abuja, Port Harcourt, and major cities nationwide.
        </p>
    </div>
</div>

<div class="container pb-16">
    <!-- Pricing Cards Grid -->
    <div class="row g-8 mb-16 justify-content-center">
        <!-- Small Package -->
        <div class="col-lg-4 col-md-6">
            <div class="pricing-card-glass h-100 p-8 p-lg-10 text-center">
                <div class="symbol symbol-60px bg-light-success rounded-circle mb-6 mx-auto d-flex align-items-center justify-content-center">
                    <i class="ki-duotone ki-document fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <h3 class="fs-2 fw-bolder text-dark mb-2">Small Package</h3>
                <p class="text-muted fs-6 mb-6">Letters, legal documents, small pouches, keys, and compact personal items.</p>
                
                <div class="mb-8">
                    <span class="fs-4x fw-bolder text-dark font-monospace">₦500</span>
                    <span class="text-muted fw-bold">/ base rate</span>
                </div>

                <ul class="list-unstyled text-start mb-8 fs-6">
                    <li class="d-flex align-items-center gap-3 mb-3">
                        <i class="ki-duotone ki-check-circle text-success fs-3"><span class="path1"></span><span class="path2"></span></i>
                        <span class="text-gray-700">Weight: Up to 5 kg</span>
                    </li>
                    <li class="d-flex align-items-center gap-3 mb-3">
                        <i class="ki-duotone ki-check-circle text-success fs-3"><span class="path1"></span><span class="path2"></span></i>
                        <span class="text-gray-700">Live Map GPS Tracking</span>
                    </li>
                    <li class="d-flex align-items-center gap-3 mb-3">
                        <i class="ki-duotone ki-check-circle text-success fs-3"><span class="path1"></span><span class="path2"></span></i>
                        <span class="text-gray-700">Instant Status Updates</span>
                    </li>
                    <li class="d-flex align-items-center gap-3">
                        <i class="ki-duotone ki-check-circle text-success fs-3"><span class="path1"></span><span class="path2"></span></i>
                        <span class="text-gray-700">Digital Proof of Delivery</span>
                    </li>
                </ul>

                <a href="/orders/place" class="btn btn-light-success w-100 btn-lg fw-bold rounded-pill">
                    Send Small Parcel
                </a>
            </div>
        </div>

        <!-- Medium Package (Featured) -->
        <div class="col-lg-4 col-md-6">
            <div class="pricing-card-glass h-100 p-8 p-lg-10 text-center border-warning border-2">
                <div class="popular-badge-custom">MOST POPULAR</div>
                <div class="symbol symbol-60px bg-light-warning rounded-circle mb-6 mx-auto d-flex align-items-center justify-content-center">
                    <i class="ki-duotone ki-briefcase fs-1 text-warning"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <h3 class="fs-2 fw-bolder text-dark mb-2">Medium Package</h3>
                <p class="text-muted fs-6 mb-6">Standard boxes, clothing, shoes, small electronics, and HammShop store orders.</p>
                
                <div class="mb-8">
                    <span class="fs-4x fw-bolder text-warning font-monospace">₦1,000</span>
                    <span class="text-muted fw-bold">/ base rate</span>
                </div>

                <ul class="list-unstyled text-start mb-8 fs-6">
                    <li class="d-flex align-items-center gap-3 mb-3">
                        <i class="ki-duotone ki-check-circle text-success fs-3"><span class="path1"></span><span class="path2"></span></i>
                        <span class="text-gray-700">Weight: Up to 15 kg</span>
                    </li>
                    <li class="d-flex align-items-center gap-3 mb-3">
                        <i class="ki-duotone ki-check-circle text-success fs-3"><span class="path1"></span><span class="path2"></span></i>
                        <span class="text-gray-700">Live Map GPS Tracking</span>
                    </li>
                    <li class="d-flex align-items-center gap-3 mb-3">
                        <i class="ki-duotone ki-check-circle text-success fs-3"><span class="path1"></span><span class="path2"></span></i>
                        <span class="text-gray-700">Fragile Protection Option (+₦200)</span>
                    </li>
                    <li class="d-flex align-items-center gap-3 mb-3">
                        <i class="ki-duotone ki-check-circle text-success fs-3"><span class="path1"></span><span class="path2"></span></i>
                        <span class="text-gray-700">Priority Courier Dispatch</span>
                    </li>
                    <li class="d-flex align-items-center gap-3">
                        <i class="ki-duotone ki-check-circle text-success fs-3"><span class="path1"></span><span class="path2"></span></i>
                        <span class="text-gray-700">HammShop Direct Delivery</span>
                    </li>
                </ul>

                <a href="/orders/place" class="btn btn-warning w-100 btn-lg fw-bold rounded-pill shadow-lg">
                    Send Medium Parcel
                </a>
            </div>
        </div>

        <!-- Large Package -->
        <div class="col-lg-4 col-md-6">
            <div class="pricing-card-glass h-100 p-8 p-lg-10 text-center">
                <div class="symbol symbol-60px bg-light-primary rounded-circle mb-6 mx-auto d-flex align-items-center justify-content-center">
                    <i class="ki-duotone ki-truck fs-1 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                </div>
                <h3 class="fs-2 fw-bolder text-dark mb-2">Large & Cargo</h3>
                <p class="text-muted fs-6 mb-6">Bulk inventory, home appliances, large boxes, or multiple items to one location.</p>
                
                <div class="mb-8">
                    <span class="fs-4x fw-bolder text-dark font-monospace">₦2,000</span>
                    <span class="text-muted fw-bold">/ base rate</span>
                </div>

                <ul class="list-unstyled text-start mb-8 fs-6">
                    <li class="d-flex align-items-center gap-3 mb-3">
                        <i class="ki-duotone ki-check-circle text-success fs-3"><span class="path1"></span><span class="path2"></span></i>
                        <span class="text-gray-700">Weight: Up to 50 kg</span>
                    </li>
                    <li class="d-flex align-items-center gap-3 mb-3">
                        <i class="ki-duotone ki-check-circle text-success fs-3"><span class="path1"></span><span class="path2"></span></i>
                        <span class="text-gray-700">Dedicated Courier Vehicle</span>
                    </li>
                    <li class="d-flex align-items-center gap-3 mb-3">
                        <i class="ki-duotone ki-check-circle text-success fs-3"><span class="path1"></span><span class="path2"></span></i>
                        <span class="text-gray-700">Live Map GPS Tracking</span>
                    </li>
                    <li class="d-flex align-items-center gap-3">
                        <i class="ki-duotone ki-check-circle text-success fs-3"><span class="path1"></span><span class="path2"></span></i>
                        <span class="text-gray-700">Heavy Handling Assistance</span>
                    </li>
                </ul>

                <a href="/orders/place" class="btn btn-light-primary w-100 btn-lg fw-bold rounded-pill">
                    Send Large Cargo
                </a>
            </div>
        </div>
    </div>

    <!-- Enterprise & E-commerce Section -->
    <div class="pricing-card-glass p-8 p-lg-12 rounded-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-3 py-2 rounded-pill fs-8 mb-3">BUSINESS & CORPORATE LOGISTICS</span>
                <h2 class="fs-1 fw-bolder text-dark mb-3">High Volume Business Solutions</h2>
                <p class="fs-6 text-muted mb-6">Running an e-commerce store or corporate fleet in Nigeria? HMLL provides custom monthly billing, volume discounts, bulk dispatching, and automated API integration for online merchants.</p>
                <div class="d-flex flex-wrap gap-4">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ki-duotone ki-check-circle text-success fs-2"><span class="path1"></span><span class="path2"></span></i>
                        <span class="fw-bold text-dark fs-7">Bulk Monthly Invoicing</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="ki-duotone ki-check-circle text-success fs-2"><span class="path1"></span><span class="path2"></span></i>
                        <span class="fw-bold text-dark fs-7">HammShop Merchant Sync</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="ki-duotone ki-check-circle text-success fs-2"><span class="path1"></span><span class="path2"></span></i>
                        <span class="fw-bold text-dark fs-7">Dedicated Logistics Account Manager</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end mt-8 mt-lg-0">
                <a href="/support" class="btn btn-dark btn-lg fw-bold px-8 rounded-pill">
                    Contact Business Support
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

