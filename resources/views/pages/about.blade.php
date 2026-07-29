@extends('layouts.metronic')

@section('title', 'About Us — HMLL Logistics')
@section('meta_description', 'Learn about HMLL — Nigeria’s premier tech-enabled delivery & logistics network. Fast, reliable package delivery nationwide.')

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
    .about-hero {
        position: relative;
        z-index: 0;
        border-radius: 28px;
        padding: 5rem 2rem;
        margin-bottom: 3rem;
        overflow: hidden;
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 41, 59, 0.95) 100%);
        border: 1px solid var(--glass-border);
        box-shadow: var(--glass-shadow);
    }
    .about-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 20% 20%, rgba(255, 140, 0, 0.25), transparent 45%),
                    radial-gradient(circle at 80% 80%, rgba(21, 197, 82, 0.2), transparent 45%);
        z-index: -1;
    }
    .glass-card-about {
        background: var(--glass-bg);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        box-shadow: var(--glass-shadow);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .glass-card-about:hover {
        transform: translateY(-5px);
    }
</style>

<!-- Hero Banner -->
<div class="about-hero text-center text-white">
    <div class="max-w-800px mx-auto">
        <span class="badge bg-warning bg-opacity-20 text-warning px-4 py-2 rounded-pill fs-7 fw-bolder mb-4 text-uppercase tracking-wider">
            NATIONWIDE LOGISTICS NETWORK
        </span>
        <h1 class="display-4 fw-bolder mb-4 text-white">
            Connecting All of <span class="text-warning">Nigeria</span>, Package by Package
        </h1>
        <p class="fs-5 text-white text-opacity-80 leading-relaxed mb-0">
            HMLL is building Nigeria's most reliable, tech-driven delivery ecosystem. From Lagos to Kano, Abuja to Port Harcourt, we power fast door-to-door deliveries with real-time GPS tracking and dedicated couriers.
        </p>
    </div>
</div>

<div class="container py-6">
    <!-- Story Section -->
    <div class="row g-10 align-items-center mb-16">
        <div class="col-lg-6">
            <span class="fs-7 text-primary fw-bolder text-uppercase tracking-wider mb-2 d-block">OUR MISSION</span>
            <h2 class="fs-2x fw-bolder text-dark mb-6">Revolutionizing Nationwide Delivery for Individuals & Businesses</h2>
            <p class="fs-6 text-muted leading-relaxed mb-4">
                HMLL was founded to solve a critical challenge across Nigeria: fast, transparent, and trustworthy package delivery. We combined real-time tracking technology with a vast, verified network of delivery agents to eliminate the uncertainty in logistics.
            </p>
            <p class="fs-6 text-muted leading-relaxed mb-6">
                Whether you're sending urgent business contracts across city lines, shipping e-commerce orders for HammShop, or delivering personal parcels to loved ones, HMLL ensures your items arrive safely and on schedule.
            </p>

            <div class="row g-4">
                <div class="col-6">
                    <div class="d-flex align-items-center gap-3 glass-card-about p-4">
                        <div class="symbol symbol-45px bg-light-primary rounded-circle">
                            <i class="ki-duotone ki-rocket fs-2 text-primary"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <div>
                            <div class="fs-3 fw-bolder text-dark font-monospace">24/7</div>
                            <div class="fs-8 text-muted fw-bold">Live Tracking & Support</div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center gap-3 glass-card-about p-4">
                        <div class="symbol symbol-45px bg-light-success rounded-circle">
                            <i class="ki-duotone ki-shield-check fs-2 text-success"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <div>
                            <div class="fs-3 fw-bolder text-dark font-monospace">99.8%</div>
                            <div class="fs-8 text-muted fw-bold">On-Time Delivery</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="position-relative">
                <img src="{{ asset('images/redesign/man-agent.jpg') }}" class="w-100 rounded-4 shadow-lg object-cover" style="max-height: 480px;" alt="HMLL Agent">
                <div class="position-absolute bottom-0 start-0 m-4 d-none d-sm-block">
                    <div class="glass-card-about p-5 text-dark" style="max-width: 280px; background: rgba(15, 23, 42, 0.95); color: white !important;">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <i class="ki-duotone ki-badge fs-2x text-warning"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                            <div class="fs-7 fw-bold text-white">Verified Agents</div>
                        </div>
                        <p class="fs-8 text-white text-opacity-75 mb-0">Every driver & courier in our nationwide network is background-checked and GPS-tracked.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Core Values -->
    <div class="text-center mb-12">
        <span class="fs-7 text-primary fw-bolder text-uppercase tracking-wider mb-2 d-block">WHY CHOOSE HMLL</span>
        <h2 class="fs-2x fw-bolder text-dark mb-3">Engineered for Reliability</h2>
        <p class="fs-6 text-muted max-w-600px mx-auto">Built on top of modern technology and seamless communication for senders and receivers.</p>
    </div>

    <div class="row g-6 mb-16">
        <div class="col-md-4">
            <div class="glass-card-about p-8 h-100">
                <div class="symbol symbol-50px bg-light-primary rounded-3 mb-6 d-flex align-items-center justify-content-center">
                    <i class="ki-duotone ki-geolocation fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <h3 class="fs-4 fw-bolder text-dark mb-3">Live Map Tracking</h3>
                <p class="text-muted fs-6 mb-0">Track your package location second-by-second from pickup to final drop-off with live ETA countdowns.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="glass-card-about p-8 h-100">
                <div class="symbol symbol-50px bg-light-warning rounded-3 mb-6 d-flex align-items-center justify-content-center">
                    <i class="ki-duotone ki-wallet fs-1 text-warning"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                </div>
                <h3 class="fs-4 fw-bolder text-dark mb-3">Transparent Rates</h3>
                <p class="text-muted fs-6 mb-0">Fixed, affordable pricing based on package size and distance. No hidden charges or surge pricing.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="glass-card-about p-8 h-100">
                <div class="symbol symbol-50px bg-light-success rounded-3 mb-6 d-flex align-items-center justify-content-center">
                    <i class="ki-duotone ki-security-user fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <h3 class="fs-4 fw-bolder text-dark mb-3">Secure Handling</h3>
                <p class="text-muted fs-6 mb-0">From delicate electronics to high-value items, our fragile handling options keep your parcels safe.</p>
            </div>
        </div>
    </div>

    <!-- HammShop Partnership Banner -->
    <div class="glass-card-about p-8 p-lg-12 bg-gradient-primary text-white rounded-4 overflow-hidden position-relative mb-10" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill fs-8 mb-3">E-COMMERCE INTEGRATION</span>
                <h2 class="fs-1 fw-bolder text-white mb-3">Powered by HammShop Store Integration</h2>
                <p class="fs-6 text-white text-opacity-80 mb-0">Order groceries, provisions, electronics, and daily essentials on HammShop with instant HMLL delivery to your doorstep anywhere in Nigeria.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-6 mt-lg-0">
                <a href="/orders/place" class="btn btn-warning btn-lg fw-bold px-8 rounded-pill">
                    Send a Package Now
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

