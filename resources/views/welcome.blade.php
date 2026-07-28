@extends('layouts.metronic')

@section('title', "HMLL")
@section('meta_description', "HMLL — Fast, reliable delivery across Nigeria. Send packages to any city with real-time tracking.")

@section('body_class', '')
@section('container_class', 'container-fluid px-3 px-lg-4')

@section('content')
    <style>
        :root {
            --glass-bg: rgba(255, 255, 255, 0.12);
            --glass-border: rgba(255, 255, 255, 0.35);
            --glass-highlight: rgba(255, 255, 255, 0.5);
            --glass-shadow: 0 20px 50px -14px rgba(0, 0, 0, 0.4), 0 2px 8px rgba(0, 0, 0, 0.12);
        }

        [data-bs-theme="light"] {
            --glass-bg: rgba(255, 255, 255, 0.55);
            --glass-border: rgba(255, 255, 255, 0.6);
            --glass-highlight: rgba(255, 255, 255, 0.85);
            --glass-shadow: 0 20px 45px -16px rgba(31, 38, 135, 0.2), 0 2px 8px rgba(31, 38, 135, 0.08);
        }

        /* Ambient wallpaper-style background, gives the glass something to refract */
        .page-wrap { position: relative; z-index: 0; }

        .ambient-bg {
            position: absolute;
            inset: 0;
            z-index: -1;
            pointer-events: none;
            background:
                radial-gradient(circle at 18% 12%, rgba(255, 140, 0, 0.16), transparent 42%),
                radial-gradient(circle at 82% 22%, rgba(14, 124, 74, 0.16), transparent 46%),
                radial-gradient(circle at 50% 92%, rgba(108, 92, 231, 0.12), transparent 50%);
            background-repeat: no-repeat;
            background-size: 140% 140%;
            animation: ambientDrift 24s ease-in-out infinite alternate;
        }

        @keyframes ambientDrift {
            0% { background-position: 0% 0%, 0% 0%, 0% 0%; }
            100% { background-position: 6% 8%, -6% -8%, 4% -6%; }
        }

        @media (prefers-reduced-motion: reduce) {
            .ambient-bg { animation: none; }
        }

        /* Scroll Reveal Animations */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .delay-1 { transition-delay: 0.1s; }
        .delay-2 { transition-delay: 0.2s; }
        .delay-3 { transition-delay: 0.3s; }

        /* Hero Section with Nigeria-wide Background */
        .hero-wrapper {
            position: relative;
            min-height: 65vh;
            display: flex;
            align-items: center;
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 2rem;
            background: #000;
        }

        .hero-video-bg {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            transform: translate(-50%, -50%);
            object-fit: cover;
            z-index: 0;
            opacity: 0.85;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(0, 0, 0, 0.75) 0%, rgba(0, 0, 0, 0.45) 50%, rgba(0, 0, 0, 0.2) 100%);
            z-index: 1;
        }

        [data-bs-theme="light"] .hero-overlay {
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.6) 50%, rgba(255, 255, 255, 0.2) 100%);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            padding: 2.5rem 2.5rem;
            width: 100%;
            max-width: 95%;
        }

        @media (max-width: 991.98px) {
            .hero-content {
                padding: 1.75rem 1.25rem;
                text-align: center;
                max-width: 100%;
            }

            .hero-badge { margin-inline: auto; }
            .hero-content .d-flex { justify-content: center; }
            .hero-content .glass-card { margin-inline: auto; }
        }

        /* Glassmorphism Cards */
        .glass-card {
            background: var(--glass-bg) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border) !important;
            box-shadow: var(--glass-shadow);
            border-radius: 20px !important;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            background: rgba(255, 140, 0, 0.15);
            color: #ff8c00;
            backdrop-filter: blur(4px);
        }

        .feature-card,
        .pricing-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .feature-card:hover,
        .pricing-card:hover {
            transform: translateY(-12px) scale(1.02);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        .float-anim { animation: float 6s ease-in-out infinite; }

        .glow-on-hover { position: relative; overflow: hidden; }

        .glow-on-hover::after {
            content: '';
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
        }

        .glow-on-hover:hover::after { opacity: 1; }

        .brand-text-gradient {
            background: linear-gradient(135deg, #ff8c00 0%, #ff4500 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        [data-bs-theme="light"] .hero-content h1 { color: #0d1117 !important; }
        [data-bs-theme="light"] .hero-content p { color: #4b5563 !important; }

        /* Logo mark (no image) */
        .logo-mark {
            background: linear-gradient(135deg, #ff8c00 0%, #ff4500 100%);
        }

        /* Initial-based avatars (no image) */
        .avatar-initials {
            background: linear-gradient(135deg, #ff8c00 0%, #ff4500 100%);
            color: #fff;
            font-weight: 700;
            font-size: 0.95rem;
            letter-spacing: 0.02em;
        }

        /* Hero live status card */
        #heroStatusText { transition: opacity 0.3s ease; }
        #heroProgressBar { transition: width 1.1s ease; }

        /* Live activity ticker */
        .activity-ticker { font-size: 0.8rem; color: rgba(255, 255, 255, 0.65); }
        [data-bs-theme="light"] .activity-ticker { color: rgba(0, 0, 0, 0.55); }
        #liveActivityText { transition: opacity 0.25s ease; }

        /* Coverage Zone Badges */
        .zone-badge {
            display: inline-block;
            padding: 0.6rem 1.25rem;
            margin-right: 0.85rem;
            margin-bottom: 0.85rem;
            background: rgba(255, 140, 0, 0.08);
            color: #ff8c00;
            border: 1px solid rgba(255, 140, 0, 0.15);
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.3s ease;
            backdrop-filter: blur(4px);
        }

        .zone-badge:hover {
            background: #ff8c00;
            color: #fff;
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(255, 140, 0, 0.3);
        }

        /* Map / Coverage Network Container */
        .map-card-container {
            position: relative;
            height: 400px;
            border-radius: 20px;
            overflow: hidden;
            background: #0d0d0d;
            border: 1px solid var(--glass-border);
            box-shadow: var(--glass-shadow);
        }

        .map-image-bg {
            display: block;
            width: 100%;
            height: 100%;
            transition: transform 10s linear;
        }

        .map-card-container:hover .map-image-bg { transform: scale(1.08); }

        .map-overlay-stats {
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at center, transparent 0%, rgba(0, 0, 0, 0.45) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            z-index: 2;
            pointer-events: none;
        }

        .map-overlay-stats .glass-card { pointer-events: auto; }

        /* Layout Fix: Fit to screen (Remove one-sided shift) */
        @media (min-width: 992px) {
            #kt_wrapper { padding-left: 0 !important; margin-left: 0 !important; width: 100% !important; }
            #kt_header { left: 0 !important; width: 100% !important; }
        }

        /* ====== HammShop Promo Styles ====== */
        .hammshop-banner {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            border: 1px solid rgba(255, 140, 0, 0.2);
            transition: all 0.4s ease;
        }

        .hammshop-banner:hover {
            border-color: rgba(255, 140, 0, 0.5);
            box-shadow: 0 20px 60px -15px rgba(255, 140, 0, 0.2);
            transform: translateY(-4px);
        }

        .hammshop-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255, 140, 0, 0.12) 0%, transparent 70%);
            pointer-events: none;
        }

        .hammshop-banner::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(14, 124, 74, 0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        .hammshop-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            background: rgba(255, 140, 0, 0.15);
            color: #ff8c00;
            border: 1px solid rgba(255, 140, 0, 0.2);
        }

        .hammshop-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            background: linear-gradient(135deg, #ff8c00 0%, #ff6b00 100%);
            color: #fff;
            font-weight: 700;
            font-size: 0.9rem;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 140, 0, 0.3);
        }

        .hammshop-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 140, 0, 0.45);
            color: #fff;
        }

        .hammshop-mini-card {
            background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%);
            border: 1px solid rgba(255, 140, 0, 0.15);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.35s ease;
        }

        .hammshop-mini-card:hover {
            border-color: rgba(255, 140, 0, 0.4);
            box-shadow: 0 10px 30px -8px rgba(255, 140, 0, 0.15);
        }

        .hammshop-feature-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .hammshop-shimmer {
            background: linear-gradient(90deg, transparent 0%, rgba(255, 140, 0, 0.06) 50%, transparent 100%);
            background-size: 200% 100%;
            animation: shimmer 3s ease-in-out infinite;
        }
    </style>

    <!-- ====== HERO SECTION ====== -->
    <div class="hero-wrapper reveal active">
        <video autoplay loop muted playsinline class="hero-video-bg">
            <source src="{{ asset('images/make_it_a_video.mp4') }}" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-badge mb-2 reveal delay-1">
                <span class="bullet bullet-dot bg-success fs-2x animate-pulse"></span>
                Delivering Across Nigeria • 24/7
            </div>

            <h1 class="fw-bolder fs-2x fs-lg-5x mb-2 lh-sm reveal delay-1" style="color: white !important;">
                Deliver Anything,<br>
                <span class="brand-text-gradient">Anywhere in Nigeria.</span>
            </h1>

            <p class="fs-5 mb-3 reveal delay-2" style="color: rgba(255,255,255,0.8);">
                Experience delivery built for the whole country with <span class="fw-bold">HMLL</span>. Fast,
                reliable package delivery from Lagos to Kano, Abuja to Port Harcourt — with real-time tracking and
                doorstep service.
            </p>

            <div class="d-flex flex-wrap gap-3 mb-4 reveal delay-2">
                <a href="/orders/place" class="btn btn-primary btn-lg px-10 glow-on-hover">
                    <i class="ki-duotone ki-paper-plane fs-4 me-2"><span class="path1"></span><span
                            class="path2"></span></i>
                    Send a Package
                </a>
                <a href="https://www.hammshop.com" target="_blank" rel="noopener" class="btn btn-outline btn-lg px-8 text-white border-white"
                    style="backdrop-filter: blur(8px);">
                    <i class="ki-duotone ki-shop fs-4 me-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                    Shop with HammShop
                </a>
            </div>

            <!-- Floating Glass Order Card -->
            <div class="card glass-card float-anim reveal delay-3" style="max-width: 400px;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="bullet bullet-dot bg-success fs-2x animate-pulse"></span>
                            <span class="badge badge-light-success">In Transit</span>
                        </div>
                        <span class="text-white-50 fs-8 font-monospace" id="heroTrackId">#SW-0847</span>
                    </div>

                    <div class="d-flex gap-3 mb-2">
                        <div class="d-flex flex-column align-items-center">
                            <div class="w-10px h-10px rounded-circle bg-success"></div>
                            <div class="w-2px h-40px bg-success opacity-25"></div>
                            <div class="w-10px h-10px rounded-circle bg-primary animate-pulse"></div>
                        </div>
                        <div>
                            <div class="fs-8 text-white-50 text-uppercase fw-semibold mb-1">Current Status</div>
                            <div class="fs-6 text-white fw-semibold" id="heroStatusText">Heading to Victoria Island, Lagos...</div>
                        </div>
                    </div>

                    <div class="progress bg-white bg-opacity-10" style="height:4px;">
                        <div class="progress-bar bg-success" id="heroProgressBar" role="progressbar" style="width: 0%;"></div>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2 mt-3 reveal delay-3 activity-ticker">
                <span class="bullet bullet-dot bg-success fs-2x animate-pulse"></span>
                <span id="liveActivityText">Order #SW-2291 just delivered in Lagos</span>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mt-n20 position-relative z-index-2 reveal delay-3">
        <div class="col-6 col-lg-3">
            <div class="card glass-card text-center p-3 h-100">
                <div class="fs-2x fw-bolder text-primary counter-value" data-target="85000">0</div>
                <div class="fs-8 text-muted text-uppercase fw-bold ls-2">Deliveries</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card glass-card text-center p-3 h-100">
                <div class="fs-2x fw-bolder text-primary counter-value" data-target="2400">0</div>
                <div class="fs-8 text-muted text-uppercase fw-bold ls-2">Verified Agents</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card glass-card text-center p-3 h-100">
                <div class="fs-2x fw-bolder text-primary">25<span class="fs-5">min</span></div>
                <div class="fs-8 text-muted text-uppercase fw-bold ls-2">Avg. In-City Speed</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card glass-card text-center p-3 h-100">
                <div class="fs-2x fw-bolder text-success">99<span class="fs-5">%</span></div>
                <div class="fs-8 text-muted text-uppercase fw-bold ls-2">Accuracy</div>
            </div>
        </div>
    </div>
    <!-- ====== END HERO ====== -->

    <div class="container-fluid px-10 px-lg-15">
        <!-- ====== HOW IT WORKS ====== -->
        <div class="py-5 reveal">
            <div class="text-center mb-3">
                <span class="section-label reveal delay-1">Simple Process</span>
                <h2 class="fw-bolder text-dark fs-4 reveal delay-1">How It Works</h2>
                <p class="text-muted fs-5 mw-500px mx-auto mt-2 reveal delay-2">Three easy steps to get your package
                    delivered anywhere in Nigeria.</p>
            </div>

            <div class="row g-6 reveal delay-3">
                <!-- Step 1 -->
                <div class="col-md-4">
                    <div class="card feature-card hover-elevate-up h-100">
                        <div class="card-body text-center position-relative p-3">
                            <div class="position-absolute top-0 end-0 fs-1 fw-bolder text-muted opacity-10 me-4 mt-3">01
                            </div>
                            <div class="feature-icon bg-light-primary mx-auto mb-3">
                                <i class="ki-duotone ki-geolocation fs-2x text-primary"><span class="path1"></span><span
                                        class="path2"></span></i>
                            </div>
                            <h3 class="fw-bolder text-dark fs-4 mb-2">Enter Addresses</h3>
                            <p class="text-muted fs-6 mb-0">Tell us where to pick up your package and where it needs to go.
                                Use our map for precision.</p>
                        </div>
                    </div>
                </div>
                <!-- Step 2 -->
                <div class="col-md-4">
                    <div class="card feature-card hover-elevate-up h-100">
                        <div class="card-body text-center position-relative p-3">
                            <div class="position-absolute top-0 end-0 fs-1 fw-bolder text-muted opacity-10 me-4 mt-3">02
                            </div>
                            <div class="feature-icon bg-light-success mx-auto mb-3">
                                <i class="ki-duotone ki-user fs-2x text-success"><span class="path1"></span><span
                                        class="path2"></span></i>
                            </div>
                            <h3 class="fw-bolder text-dark fs-4 mb-2">Agent Assigned</h3>
                            <p class="text-muted fs-6 mb-0">A nearby verified agent picks up your package within minutes.
                                Track them in real-time.</p>
                        </div>
                    </div>
                </div>
                <!-- Step 3 -->
                <div class="col-md-4">
                    <div class="card feature-card hover-elevate-up h-100">
                        <div class="card-body text-center position-relative p-3">
                            <div class="position-absolute top-0 end-0 fs-1 fw-bolder text-muted opacity-10 me-4 mt-3">03
                            </div>
                            <div class="feature-icon bg-light-warning mx-auto mb-3">
                                <i class="ki-duotone ki-check-circle fs-2x text-warning"><span class="path1"></span><span
                                        class="path2"></span></i>
                            </div>
                            <h3 class="fw-bolder text-dark fs-4 mb-2">Delivered!</h3>
                            <p class="text-muted fs-6 mb-0">Track in real-time until your package arrives safely. Get
                                notified at every step.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ====== END HOW IT WORKS ====== -->

        <!-- ====== HAMMSHOP PROMO BANNER ====== -->
        <div class="py-5 reveal">
            <div class="hammshop-banner p-0">
                <div class="row g-0 align-items-center">
                    <div class="col-lg-7 p-5 p-lg-10 position-relative z-index-2">
                        <div class="hammshop-badge mb-4">
                            <span class="bullet bullet-dot bg-warning fs-2x animate-pulse"></span>
                            Official Partner Store
                        </div>
                        <h2 class="fw-bolder text-white fs-2x fs-lg-3x mb-3 lh-sm">
                            Need Something Delivered?<br>
                            <span style="background: linear-gradient(135deg, #ff8c00, #ffb347); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Shop It First on HammShop!</span>
                        </h2>
                        <p class="text-white text-opacity-75 fs-5 mb-5" style="max-width: 520px;">
                            From electronics to fashion, gadgets to groceries — get the best quality products at unbeatable
                            prices on <strong class="text-white">hammshop.com</strong>. Then let HMLL deliver it right to your doorstep!
                        </p>
                        <div class="d-flex flex-wrap gap-3 mb-5">
                            <a href="https://www.hammshop.com" target="_blank" rel="noopener" class="hammshop-btn">
                                <i class="ki-duotone ki-shop fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                Visit HammShop Now
                            </a>
                            <a href="https://www.hammshop.com" target="_blank" rel="noopener"
                               class="btn btn-outline btn-lg text-white border-white border-opacity-25"
                               style="backdrop-filter: blur(4px); border-radius: 12px;">
                                Browse Deals
                            </a>
                        </div>
                        <div class="d-flex flex-wrap gap-4">
                            <div class="d-flex align-items-center gap-2">
                                <i class="ki-duotone ki-check-circle fs-4 text-success"><span class="path1"></span><span class="path2"></span></i>
                                <span class="text-white text-opacity-75 fs-7">Premium Quality</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="ki-duotone ki-check-circle fs-4 text-success"><span class="path1"></span><span class="path2"></span></i>
                                <span class="text-white text-opacity-75 fs-7">Best Prices</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="ki-duotone ki-check-circle fs-4 text-success"><span class="path1"></span><span class="path2"></span></i>
                                <span class="text-white text-opacity-75 fs-7">Fast HMLL Delivery</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center position-relative p-6">
                        <div class="text-center position-relative z-index-2">
                            <div class="d-flex flex-column gap-4">
                                <div class="hammshop-shimmer rounded-3 p-4 text-start">
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <div class="hammshop-feature-icon" style="background: rgba(255, 140, 0, 0.15);">
                                            🛍️
                                        </div>
                                        <div>
                                            <div class="text-white fw-bold fs-6">Thousands of Products</div>
                                            <div class="text-white text-opacity-50 fs-8">Electronics, Fashion, Home & More</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="hammshop-shimmer rounded-3 p-4 text-start">
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <div class="hammshop-feature-icon" style="background: rgba(14, 124, 74, 0.15);">
                                            ✅
                                        </div>
                                        <div>
                                            <div class="text-white fw-bold fs-6">Verified & Authentic</div>
                                            <div class="text-white text-opacity-50 fs-8">Only genuine, quality-tested items</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="hammshop-shimmer rounded-3 p-4 text-start">
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <div class="hammshop-feature-icon" style="background: rgba(99, 102, 241, 0.15);">
                                            🚀
                                        </div>
                                        <div>
                                            <div class="text-white fw-bold fs-6">HMLL Express Delivery</div>
                                            <div class="text-white text-opacity-50 fs-8">Buy on HammShop → Delivered by HMLL</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ====== END HAMMSHOP PROMO BANNER ====== -->

        <!-- ====== FEATURES ====== -->
        <div class="py-5 reveal">
            <div class="text-center mb-3">
                <span class="section-label reveal delay-1">Platform Features</span>
                <h2 class="fw-bolder text-dark fs-4 reveal delay-1">Why HMLL?</h2>
                <p class="text-muted fs-5 mw-500px mx-auto mt-2 reveal delay-2">Everything you need for fast, reliable
                    delivery in one platform.</p>
            </div>

            <div class="row g-6 reveal delay-3">
                <div class="col-sm-6 col-lg-4">
                    <div class="card feature-card hover-elevate-up h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="feature-icon bg-light-info mb-0">
                                    <i class="ki-duotone ki-gps fs-2x text-info"><span class="path1"></span><span
                                            class="path2"></span></i>
                                </div>
                                <h3 class="fw-bolder text-dark fs-5 mb-0">Real-Time Tracking</h3>
                            </div>
                            <p class="text-muted fs-6">Live GPS tracking on an interactive map. Know exactly where your
                                package is at every moment.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="card feature-card hover-elevate-up h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="feature-icon bg-light-success mb-0">
                                    <i class="ki-duotone ki-rocket fs-2x text-success"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span></i>
                                </div>
                                <h3 class="fw-bolder text-dark fs-5 mb-0">25-Min Delivery</h3>
                            </div>
                            <p class="text-muted fs-6">Average delivery time of 25 minutes within your city. Fast,
                                efficient, and always on time — anywhere in Nigeria.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="card feature-card hover-elevate-up h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="feature-icon bg-light-primary mb-0">
                                    <i class="ki-duotone ki-user fs-2x text-primary"><span class="path1"></span><span
                                            class="path2"></span></i>
                                </div>
                                <h3 class="fw-bolder text-dark fs-5 mb-0">Verified Agents</h3>
                            </div>
                            <p class="text-muted fs-6">Every agent is background-checked, verified, and rated. Your
                                packages are in safe hands.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="card feature-card hover-elevate-up h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="feature-icon bg-light-warning mb-0">
                                    <i class="ki-duotone ki-notification-status fs-2x text-warning"><span
                                            class="path1"></span><span class="path2"></span><span class="path3"></span><span
                                            class="path4"></span></i>
                                </div>
                                <h3 class="fw-bolder text-dark fs-5 mb-0">Instant Alerts</h3>
                            </div>
                            <p class="text-muted fs-6">Email and in-app notifications at every stage — pickup, in-transit,
                                and delivery confirmation.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="card feature-card hover-elevate-up h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="feature-icon bg-light-danger mb-0">
                                    <i class="ki-duotone ki-chart-line-up fs-2x text-danger"><span
                                            class="path1"></span><span class="path2"></span></i>
                                </div>
                                <h3 class="fw-bolder text-dark fs-5 mb-0">Admin Analytics</h3>
                            </div>
                            <p class="text-muted fs-6">Full control panel with real-time analytics, agent management, and
                                revenue reports.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="card feature-card hover-elevate-up h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="feature-icon bg-light-dark mb-0">
                                    <i class="ki-duotone ki-wallet fs-2x text-dark"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span></i>
                                </div>
                                <h3 class="fw-bolder text-dark fs-5 mb-0">Affordable Pricing</h3>
                            </div>
                            <p class="text-muted fs-6">Starts from just ₦500. No hidden fees, no surge pricing. Transparent
                                and fair always.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ====== END FEATURES ====== -->

        <!-- ====== PRICING ====== -->
        <div class="py-5 reveal">
            <div class="text-center mb-3">
                <span class="section-label reveal delay-1">Simple Pricing</span>
                <h2 class="fw-bolder text-dark fs-4 reveal delay-1">Transparent Rates</h2>
                <p class="text-muted fs-5 mw-500px mx-auto mt-2 reveal delay-2">No surprises. Pay only for what you send,
                    based on package size.</p>
            </div>

            <div class="row g-6 justify-content-center reveal delay-3">
                <!-- Small -->
                <div class="col-md-4">
                    <div class="card pricing-card h-100 text-center">
                        <div class="card-body p-3">
                            <div class="symbol symbol-60px bg-light-success mx-auto mb-3">
                                <i class="ki-duotone ki-package fs-2x text-success"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span></i>
                            </div>
                            <h3 class="fw-bolder text-dark fs-4 mb-1">Small</h3>
                            <p class="text-muted fs-7 mb-3">Documents, letters, small parcels</p>
                            <div class="mb-3">
                                <span class="fs-1 fw-bolder text-dark font-monospace">₦500</span>
                                <span class="text-muted fs-7"> / delivery</span>
                            </div>
                            <ul class="list-unstyled text-start mb-3">
                                <li class="d-flex align-items-center gap-2 mb-2 fs-7 text-muted">
                                    <i class="ki-duotone ki-check text-success fs-6"><span class="path1"></span><span
                                            class="path2"></span></i> Up to 5kg
                                </li>
                                <li class="d-flex align-items-center gap-2 mb-2 fs-7 text-muted">
                                    <i class="ki-duotone ki-check text-success fs-6"><span class="path1"></span><span
                                            class="path2"></span></i> Real-time tracking
                                </li>
                                <li class="d-flex align-items-center gap-2 mb-2 fs-7 text-muted">
                                    <i class="ki-duotone ki-check text-success fs-6"><span class="path1"></span><span
                                            class="path2"></span></i> SMS notifications
                                </li>
                            </ul>
                            <a href="/orders/place" class="btn btn-outline w-100">Send Small Package</a>
                        </div>
                    </div>
                </div>
                <!-- Medium (Popular) -->
                <div class="col-md-4">
                    <div class="card pricing-card popular h-100 text-center position-relative">
                        <div class="position-absolute top-0 start-50 translate-middle">
                            <span class="badge bg-primary px-3 py-2 fs-8">Most Popular</span>
                        </div>
                        <div class="card-body p-3">
                            <div class="symbol symbol-60px bg-light-primary mx-auto mb-3">
                                <i class="ki-duotone ki-package fs-2x text-primary"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span></i>
                            </div>
                            <h3 class="fw-bolder text-dark fs-4 mb-1">Medium</h3>
                            <p class="text-muted fs-7 mb-3">Boxes, electronics, clothing</p>
                            <div class="mb-3">
                                <span class="fs-1 fw-bolder text-primary font-monospace">₦1,000</span>
                                <span class="text-muted fs-7"> / delivery</span>
                            </div>
                            <ul class="list-unstyled text-start mb-3">
                                <li class="d-flex align-items-center gap-2 mb-2 fs-7 text-muted">
                                    <i class="ki-duotone ki-check text-success fs-6"><span class="path1"></span><span
                                            class="path2"></span></i> Up to 15kg
                                </li>
                                <li class="d-flex align-items-center gap-2 mb-2 fs-7 text-muted">
                                    <i class="ki-duotone ki-check text-success fs-6"><span class="path1"></span><span
                                            class="path2"></span></i> Live map tracking
                                </li>
                                <li class="d-flex align-items-center gap-2 mb-2 fs-7 text-muted">
                                    <i class="ki-duotone ki-check text-success fs-6"><span class="path1"></span><span
                                            class="path2"></span></i> Email + push notifications
                                </li>
                                <li class="d-flex align-items-center gap-2 mb-2 fs-7 text-muted">
                                    <i class="ki-duotone ki-check text-success fs-6"><span class="path1"></span><span
                                            class="path2"></span></i> Fragile handling (+₦200)
                                </li>
                            </ul>
                            <a href="/orders/place" class="btn btn-primary w-100">Send Medium Package</a>
                        </div>
                    </div>
                </div>
                <!-- Large -->
                <div class="col-md-4">
                    <div class="card pricing-card h-100 text-center">
                        <div class="card-body p-3">
                            <div class="symbol symbol-60px bg-light-warning mx-auto mb-3">
                                <i class="ki-duotone ki-truck fs-2x text-warning"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span></i>
                            </div>
                            <h3 class="fw-bolder text-dark fs-4 mb-1">Large</h3>
                            <p class="text-muted fs-7 mb-3">Furniture, bulk items, appliances</p>
                            <div class="mb-3">
                                <span class="fs-1 fw-bolder text-dark font-monospace">₦2,000</span>
                                <span class="text-muted fs-7"> / delivery</span>
                            </div>
                            <ul class="list-unstyled text-start mb-3">
                                <li class="d-flex align-items-center gap-2 mb-2 fs-7 text-muted">
                                    <i class="ki-duotone ki-check text-success fs-6"><span class="path1"></span><span
                                            class="path2"></span></i> Up to 50kg
                                </li>
                                <li class="d-flex align-items-center gap-2 mb-2 fs-7 text-muted">
                                    <i class="ki-duotone ki-check text-success fs-6"><span class="path1"></span><span
                                            class="path2"></span></i> Priority dispatch
                                </li>
                                <li class="d-flex align-items-center gap-2 mb-2 fs-7 text-muted">
                                    <i class="ki-duotone ki-check text-success fs-6"><span class="path1"></span><span
                                            class="path2"></span></i> Dedicated agent
                                </li>
                            </ul>
                            <a href="/orders/place" class="btn btn-outline w-100">Send Large Package</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ====== END PRICING ====== -->

        <!-- ====== COVERAGE AREAS ====== -->
        <div class="py-5 reveal">
            <div class="row g-6 align-items-center">
                <div class="col-lg-5 reveal delay-1">
                    <span class="section-label">Coverage</span>
                    <h2 class="fw-bolder text-dark fs-4 mb-3">We Cover All of Nigeria</h2>
                    <p class="text-muted fs-6 mb-3">From Lagos to Abuja, Kano to Port Harcourt, our agents are
                        everywhere. Same-day delivery within your city, and fast inter-state shipping guaranteed
                        nationwide.</p>
                    <div class="d-flex flex-wrap mb-3">
                        <span class="zone-badge">Lagos</span>
                        <span class="zone-badge">Abuja</span>
                        <span class="zone-badge">Kano</span>
                        <span class="zone-badge">Port Harcourt</span>
                        <span class="zone-badge">Ibadan</span>
                        <span class="zone-badge">Kaduna</span>
                        <span class="zone-badge">Enugu</span>
                        <span class="zone-badge">Benin City</span>
                        <span class="zone-badge">Jos</span>
                        <span class="zone-badge">Owerri</span>
                        <span class="zone-badge">Uyo</span>
                        <span class="zone-badge">Warri</span>
                        <span class="zone-badge">Onitsha</span>
                        <span class="zone-badge">Abeokuta</span>
                        <span class="zone-badge">Ilorin</span>
                        <span class="zone-badge">And more...</span>
                    </div>
                    <a href="/register" class="btn btn-primary">
                        <i class="ki-duotone ki-geolocation fs-4 me-2"><span class="path1"></span><span
                                class="path2"></span></i>
                        Check Your Area
                    </a>
                </div>
                <div class="col-lg-7 reveal delay-2">
                    <div class="map-card-container">
                        <canvas id="coverageCanvas" class="map-image-bg" aria-hidden="true"></canvas>
                        <div class="map-overlay-stats">
                            <div class="glass-card p-8 text-center" style="max-width: 450px;">
                                <div class="symbol symbol-70px bg-primary bg-opacity-10 mx-auto mb-5">
                                    <i class="ki-duotone ki-paper-plane fs-3x text-primary"><span
                                            class="path1"></span><span class="path2"></span></i>
                                </div>
                                <h4 class="fw-bolder text-white fs-2 mb-3">Nationwide Coverage</h4>
                                <p class="text-white text-opacity-75 fs-6 mb-6">Our delivery network connects major
                                    cities across Nigeria, with live routing and an average in-city response time of
                                    25 minutes.</p>
                                <div class="d-flex flex-wrap gap-3 justify-content-center">
                                    <span class="badge badge-light-success py-3 px-4 fs-7"><span
                                            class="bullet bullet-dot bg-success fs-2x me-2"></span>States Covered: 30+</span>
                                    <span class="badge badge-light-primary py-3 px-4 fs-7"><span
                                            class="bullet bullet-dot bg-primary fs-2x me-2"></span>Agents: 2,400+</span>
                                    <span class="badge badge-light-warning py-3 px-4 fs-7"><span
                                            class="bullet bullet-dot bg-warning fs-2x me-2"></span>24/7 Service</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ====== END COVERAGE ====== -->

        <!-- ====== HAMMSHOP MINI PROMO ====== -->
        <div class="py-5 reveal">
            <div class="hammshop-mini-card">
                <div class="p-5 p-lg-8">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-8">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="hammshop-feature-icon" style="background: rgba(255, 140, 0, 0.15);">
                                    🛒
                                </div>
                                <div>
                                    <div class="text-white fw-bolder fs-4">Shop on HammShop, Deliver with HMLL</div>
                                    <div class="text-white text-opacity-50 fs-7">The ultimate shopping + delivery combo</div>
                                </div>
                            </div>
                            <p class="text-white text-opacity-65 fs-6 mb-0">
                                Whatever you need — phones, laptops, clothing, accessories, home essentials — <strong class="text-white">hammshop.com</strong>
                                has it all at the best prices. Shop with confidence, enjoy premium quality, and let HMLL handle the delivery to your doorstep.
                            </p>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            <a href="https://www.hammshop.com" target="_blank" rel="noopener" class="hammshop-btn">
                                <i class="ki-duotone ki-shop fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                Shop Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ====== END HAMMSHOP MINI PROMO ====== -->

        <!-- ====== HAMMSHOP FEATURED PRODUCTS SHOWCASE ====== -->
        <div class="py-5 reveal">
            <div class="text-center mb-5">
                <div class="hammshop-badge mb-2">
                    <span class="bullet bullet-dot bg-warning fs-2x animate-pulse"></span>
                    Official Partner Marketplace
                </div>
                <h2 class="fw-bolder text-dark fs-2x reveal delay-1">Shop Everything on HammShop</h2>
                <p class="text-muted fs-5 mw-600px mx-auto mt-2 reveal delay-2">
                    From daily provisions and fresh fruits to electronics and lifestyle — buy high quality products on
                    <strong class="text-dark">hammshop.com</strong> and get express delivery by HMLL.
                </p>
            </div>

            <div class="row g-6 reveal delay-3">
                <!-- Product Card 1: Fresh Fruits -->
                <div class="col-sm-6 col-lg-3">
                    <div class="liquid-glass-card h-100 p-0 overflow-hidden shadow-sm hover-elevate-up">
                        <div class="position-relative overflow-hidden" style="height: 200px;">
                            <img src="{{ asset('images/hammshop-fruits.png') }}" alt="Fresh Tropical Fruits"
                                 style="width: 100%; height: 100%; object-fit: cover;" />
                            <div class="position-absolute top-3 start-3">
                                <span class="badge bg-success text-white fw-bold px-3 py-2 fs-8">🍎 Fresh Fruits</span>
                            </div>
                        </div>
                        <div class="p-5 d-flex flex-column justify-content-between" style="height: calc(100% - 200px);">
                            <div>
                                <h3 class="fs-5 fw-bolder text-dark mb-2">Tropical & Fresh Fruits</h3>
                                <p class="text-muted fs-7 mb-4">
                                    Crisp apples, sweet oranges, bananas, pineapples, grapes & fresh berries.
                                </p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center border-top border-dashed pt-3 mt-auto">
                                <span class="text-success fw-bold fs-8 d-flex align-items-center gap-1">
                                    <i class="ki-duotone ki-check-circle fs-6 text-success"><span class="path1"></span><span class="path2"></span></i>
                                    Fresh & Delivered
                                </span>
                                <a href="https://www.hammshop.com" target="_blank" rel="noopener" class="hammshop-btn py-1.5 px-3 fs-8">
                                    Shop Fruits
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Card 2: Fresh Vegetables -->
                <div class="col-sm-6 col-lg-3">
                    <div class="liquid-glass-card h-100 p-0 overflow-hidden shadow-sm hover-elevate-up">
                        <div class="position-relative overflow-hidden" style="height: 200px;">
                            <img src="{{ asset('images/hammshop-vegetables.png') }}" alt="Fresh Organic Vegetables"
                                 style="width: 100%; height: 100%; object-fit: cover;" />
                            <div class="position-absolute top-3 start-3">
                                <span class="badge bg-success text-white fw-bold px-3 py-2 fs-8">🥦 Farm Vegetables</span>
                            </div>
                        </div>
                        <div class="p-5 d-flex flex-column justify-content-between" style="height: calc(100% - 200px);">
                            <div>
                                <h3 class="fs-5 fw-bolder text-dark mb-2">Organic Vegetables</h3>
                                <p class="text-muted fs-7 mb-4">
                                    Tomatoes, bell peppers, carrots, cucumbers, spinach, onions & leafy greens.
                                </p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center border-top border-dashed pt-3 mt-auto">
                                <span class="text-success fw-bold fs-8 d-flex align-items-center gap-1">
                                    <i class="ki-duotone ki-check-circle fs-6 text-success"><span class="path1"></span><span class="path2"></span></i>
                                    Farm Fresh Daily
                                </span>
                                <a href="https://www.hammshop.com" target="_blank" rel="noopener" class="hammshop-btn py-1.5 px-3 fs-8">
                                    Shop Veggies
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Card 3: Crispy Snacks -->
                <div class="col-sm-6 col-lg-3">
                    <div class="liquid-glass-card h-100 p-0 overflow-hidden shadow-sm hover-elevate-up">
                        <div class="position-relative overflow-hidden" style="height: 200px;">
                            <img src="{{ asset('images/hammshop-snacks.png') }}" alt="Crispy Snacks & Biscuits"
                                 style="width: 100%; height: 100%; object-fit: cover;" />
                            <div class="position-absolute top-3 start-3">
                                <span class="badge bg-warning text-white fw-bold px-3 py-2 fs-8">🍿 Tasty Snacks</span>
                            </div>
                        </div>
                        <div class="p-5 d-flex flex-column justify-content-between" style="height: calc(100% - 200px);">
                            <div>
                                <h3 class="fs-5 fw-bolder text-dark mb-2">Snacks & Confectionery</h3>
                                <p class="text-muted fs-7 mb-4">
                                    Potato chips, chocolate cookies, popcorn, roasted nuts, biscuits & sweets.
                                </p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center border-top border-dashed pt-3 mt-auto">
                                <span class="text-warning fw-bold fs-8 d-flex align-items-center gap-1">
                                    <i class="ki-duotone ki-check-circle fs-6 text-warning"><span class="path1"></span><span class="path2"></span></i>
                                    Crunchy & Fresh
                                </span>
                                <a href="https://www.hammshop.com" target="_blank" rel="noopener" class="hammshop-btn py-1.5 px-3 fs-8">
                                    Shop Snacks
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Card 4: Cool Beverages -->
                <div class="col-sm-6 col-lg-3">
                    <div class="liquid-glass-card h-100 p-0 overflow-hidden shadow-sm hover-elevate-up">
                        <div class="position-relative overflow-hidden" style="height: 200px;">
                            <img src="{{ asset('images/hammshop-beverages.png') }}" alt="Refreshing Beverages & Drinks"
                                 style="width: 100%; height: 100%; object-fit: cover;" />
                            <div class="position-absolute top-3 start-3">
                                <span class="badge bg-primary text-white fw-bold px-3 py-2 fs-8">🥤 Cool Drinks</span>
                            </div>
                        </div>
                        <div class="p-5 d-flex flex-column justify-content-between" style="height: calc(100% - 200px);">
                            <div>
                                <h3 class="fs-5 fw-bolder text-dark mb-2">Beverages & Juices</h3>
                                <p class="text-muted fs-7 mb-4">
                                    Refreshing fruit juices, chilled sodas, sparkling water, energy drinks & tea.
                                </p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center border-top border-dashed pt-3 mt-auto">
                                <span class="text-primary fw-bold fs-8 d-flex align-items-center gap-1">
                                    <i class="ki-duotone ki-check-circle fs-6 text-primary"><span class="path1"></span><span class="path2"></span></i>
                                    Ice Cold Express
                                </span>
                                <a href="https://www.hammshop.com" target="_blank" rel="noopener" class="hammshop-btn py-1.5 px-3 fs-8">
                                    Shop Drinks
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Global HammShop Banner Footer CTA -->
            <div class="mt-8 text-center">
                <a href="https://www.hammshop.com" target="_blank" rel="noopener" class="hammshop-btn py-3 px-8 fs-5">
                    🛍️ Explore All Products on HammShop.com →
                </a>
            </div>
        </div>
        <!-- ====== END HAMMSHOP SHOWCASE ====== -->

        <!-- ====== FAQ ====== -->
        <div class="py-5 reveal">
            <div class="row g-6 justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-3">
                        <span class="section-label reveal delay-1">FAQ</span>
                        <h2 class="fw-bolder text-dark fs-4 reveal delay-1">Frequently Asked Questions</h2>
                    </div>

                    <div class="faq-list">
                        <div class="faq-item py-4">
                            <button
                                class="btn btn-link text-dark fw-semibold fs-6 p-0 text-start w-100 text-decoration-none"
                                data-bs-toggle="collapse" data-bs-target="#faq1">
                                <span class="me-2"><i class="ki-duotone ki-questionnaire-table fs-5 text-primary"><span
                                            class="path1"></span><span class="path2"></span><span
                                            class="path3"></span></i></span>
                                How fast is HMLL delivery?
                                <i class="ki-duotone ki-plus-circle fs-5 float-end text-primary faq-toggle"><span
                                        class="path1"></span><span class="path2"></span></i>
                            </button>
                            <div id="faq1" class="collapse">
                                <p class="text-muted fs-6 mt-2 ms-4">Average delivery time is 25 minutes within a
                                    city. For inter-state deliveries across Nigeria, most packages arrive within
                                    1–3 days depending on distance and route.</p>
                            </div>
                        </div>
                        <div class="faq-item py-4">
                            <button
                                class="btn btn-link text-dark fw-semibold fs-6 p-0 text-start w-100 text-decoration-none"
                                data-bs-toggle="collapse" data-bs-target="#faq2">
                                <span class="me-2"><i class="ki-duotone ki-questionnaire-table fs-5 text-primary"><span
                                            class="path1"></span><span class="path2"></span><span
                                            class="path3"></span></i></span>
                                How do I track my package?
                                <i class="ki-duotone ki-plus-circle fs-5 float-end text-primary faq-toggle"><span
                                        class="path1"></span><span class="path2"></span></i>
                            </button>
                            <div id="faq2" class="collapse">
                                <p class="text-muted fs-6 mt-2 ms-4">Once your order is placed, you'll receive a
                                    tracking number. Visit the tracking page or your dashboard to see your package's
                                    live location on the map.</p>
                            </div>
                        </div>
                        <div class="faq-item py-4">
                            <button
                                class="btn btn-link text-dark fw-semibold fs-6 p-0 text-start w-100 text-decoration-none"
                                data-bs-toggle="collapse" data-bs-target="#faq3">
                                <span class="me-2"><i class="ki-duotone ki-questionnaire-table fs-5 text-primary"><span
                                            class="path1"></span><span class="path2"></span><span
                                            class="path3"></span></i></span>
                                Are my packages insured?
                                <i class="ki-duotone ki-plus-circle fs-5 float-end text-primary faq-toggle"><span
                                        class="path1"></span><span class="path2"></span></i>
                            </button>
                            <div id="faq3" class="collapse">
                                <p class="text-muted fs-6 mt-2 ms-4">Yes! All packages are covered under our delivery
                                    insurance. If anything goes wrong during transit, you'll be fully compensated.</p>
                            </div>
                        </div>
                        <div class="faq-item py-4">
                            <button
                                class="btn btn-link text-dark fw-semibold fs-6 p-0 text-start w-100 text-decoration-none"
                                data-bs-toggle="collapse" data-bs-target="#faq4">
                                <span class="me-2"><i class="ki-duotone ki-questionnaire-table fs-5 text-primary"><span
                                            class="path1"></span><span class="path2"></span><span
                                            class="path3"></span></i></span>
                                How can I become a delivery agent?
                                <i class="ki-duotone ki-plus-circle fs-5 float-end text-primary faq-toggle"><span
                                        class="path1"></span><span class="path2"></span></i>
                            </button>
                            <div id="faq4" class="collapse">
                                <p class="text-muted fs-6 mt-2 ms-4">Sign up as an agent through our registration page.
                                    You'll need a valid ID, phone number, and reliable transportation (bike or car).
                                    We'll verify your details within 24 hours.</p>
                            </div>
                        </div>
                        <div class="faq-item py-4">
                            <button
                                class="btn btn-link text-dark fw-semibold fs-6 p-0 text-start w-100 text-decoration-none"
                                data-bs-toggle="collapse" data-bs-target="#faq5">
                                <span class="me-2"><i class="ki-duotone ki-questionnaire-table fs-5 text-primary"><span
                                            class="path1"></span><span class="path2"></span><span
                                            class="path3"></span></i></span>
                                Can I cancel an order?
                                <i class="ki-duotone ki-plus-circle fs-5 float-end text-primary faq-toggle"><span
                                        class="path1"></span><span class="path2"></span></i>
                            </button>
                            <div id="faq5" class="collapse">
                                <p class="text-muted fs-6 mt-2 ms-4">Yes, you can cancel any pending order before it's
                                    picked up. Once the agent has picked up your package, cancellation is no longer
                                    possible.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ====== END FAQ ====== -->
    </div> <!-- end container-xxl wrap for main content -->

    <!-- ====== CTA SECTION ====== -->
    <div class="py-5 reveal">
        <div class="container-xxl">
            <div class="cta-section text-center reveal delay-2">
                <h2 class="fw-bolder text-dark fs-4 mb-3">Ready to Send a Package?</h2>
                <p class="text-muted fs-5 mw-500px mx-auto mb-3">Join thousands of happy customers who trust HMLL
                    for their deliveries, anywhere in Nigeria. Sign up in seconds.</p>
                <div class="d-flex flex-wrap gap-3 justify-content-center mb-5">
                    <a href="/orders/place" class="btn btn-primary btn-lg px-6 reveal delay-3">
                        <i class="ki-duotone ki-paper-plane fs-4 me-2"><span class="path1"></span><span
                                class="path2"></span></i>
                        Send a Package Now
                    </a>
                    <a href="https://www.hammshop.com" target="_blank" rel="noopener" class="btn btn-outline btn-lg px-5 reveal delay-3">
                        <i class="ki-duotone ki-shop fs-4 me-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                        Shop with HammShop
                    </a>
                </div>
                <div class="separator border-dashed my-4"></div>
                <p class="text-muted fs-6 mb-2">Looking to buy something first?</p>
                <a href="https://www.hammshop.com" target="_blank" rel="noopener" class="hammshop-btn reveal delay-3">
                    🛍️ Shop on HammShop.com
                </a>
                <p class="text-muted fs-8 mt-2">Premium products • Best prices • Delivered by HMLL</p>
            </div>
        </div>
    </div>
    <!-- ====== END CTA ====== -->

    <!-- ====== FOOTER ====== -->
    <div class="container-xxl">
        <div class="border-top border-dashed py-5 mt-3">
            <div class="row g-6">
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="symbol symbol-50px logo-mark rounded-circle d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-paper-plane fs-2 text-white"><span class="path1"></span><span
                                    class="path2"></span></i>
                        </div>
                        <span class="fw-bolder fs-4 text-dark letter-spacing-1">HMLL</span>
                    </div>
                    <p class="text-muted fs-6 mb-3">Fast, reliable delivery platform serving all of Nigeria. Your
                        package, our priority.</p>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-sm btn-icon btn-light"><i class="ki-duotone ki-facebook fs-5"><span
                                    class="path1"></span><span class="path2"></span></i></a>
                        <a href="#" class="btn btn-sm btn-icon btn-light"><i class="ki-duotone ki-twitter fs-5"><span
                                    class="path1"></span><span class="path2"></span></i></a>
                        <a href="#" class="btn btn-sm btn-icon btn-light"><i class="ki-duotone ki-instagram fs-5"><span
                                    class="path1"></span><span class="path2"></span></i></a>
                        <a href="#" class="btn btn-sm btn-icon btn-light"><i class="ki-duotone ki-whatsapp fs-5"><span
                                    class="path1"></span><span class="path2"></span></i></a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <h5 class="fw-bolder text-dark fs-6 mb-3">QUICK LINKS</h5>
                    <div class="d-flex flex-column gap-2">
                        <a href="/orders/place" class="text-muted fs-7 text-hover-primary">Send Package</a>
                        <a href="/track" class="text-muted fs-7 text-hover-primary">Track Order</a>
                        <a href="/register" class="text-muted fs-7 text-hover-primary">Create Account</a>
                        <a href="/orders/history" class="text-muted fs-7 text-hover-primary">Order History</a>
                        <a href="/notifications" class="text-muted fs-7 text-hover-primary">Notifications</a>
                        <a href="https://www.hammshop.com" target="_blank" rel="noopener" class="fs-7 text-hover-primary" style="color: #ff8c00 !important; font-weight: 600;">🛍️ HammShop.com</a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <h5 class="fw-bolder text-dark fs-6 mb-3">PLATFORM</h5>
                    <div class="d-flex flex-column gap-2">
                        <a href="/dashboard/customer" class="text-muted fs-7 text-hover-primary">Customer Dashboard</a>
                        <a href="/dashboard/agent" class="text-muted fs-7 text-hover-primary">Agent Portal</a>
                        <a href="/dashboard/admin" class="text-muted fs-7 text-hover-primary">Admin Panel</a>
                        <a href="/agent/orders" class="text-muted fs-7 text-hover-primary">Assigned Orders</a>
                        <a href="/profile" class="text-muted fs-7 text-hover-primary">My Profile</a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <h5 class="fw-bolder text-dark fs-6 mb-3">CONTACT</h5>
                    <div class="d-flex flex-column gap-2">
                        <p class="text-muted fs-7 d-flex align-items-center gap-2"><i
                                class="ki-duotone ki-geolocation fs-5 text-primary"><span class="path1"></span><span
                                    class="path2"></span></i> Lagos, Nigeria (HQ)</p>
                        <p class="text-muted fs-7 d-flex align-items-center gap-2"><i
                                class="ki-duotone ki-sms fs-5 text-primary"><span class="path1"></span><span
                                    class="path2"></span></i> hello@hmllexpress.com</p>
                        <p class="text-muted fs-7 d-flex align-items-center gap-2"><i
                                class="ki-duotone ki-phone fs-5 text-primary"><span class="path1"></span><span
                                    class="path2"></span></i> +234 800 SWIFT</p>
                    </div>
                </div>
            </div>
            <div
                class="border-top border-dashed mt-5 pt-6 d-flex flex-column flex-md-row justify-content-between align-items-center">
                <p class="text-muted fs-8 mb-2 mb-md-0">&copy; {{ date('Y') }} HMLL. All rights reserved.</p>
                <div class="d-flex gap-3">
                    <a href="#" class="text-muted fs-8 text-hover-primary">Privacy Policy</a>
                    <a href="#" class="text-muted fs-8 text-hover-primary">Terms of Service</a>
                    <a href="#" class="text-muted fs-8 text-hover-primary">Support</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ====== END FOOTER ====== -->
@endsection

@push('scripts')
    <script>
        // Counter animation with IntersectionObserver
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = parseInt(counter.dataset.target);
                    const duration = 2000;
                    const steps = 60;
                    const stepSize = target / steps;
                    let current = 0;
                    let step = 0;

                    const timer = setInterval(() => {
                        step++;
                        current += stepSize;
                        if (step >= steps) {
                            current = target;
                            clearInterval(timer);
                        }
                        counter.textContent = Math.floor(current).toLocaleString() + '+';
                    }, duration / steps);

                    counterObserver.unobserve(counter);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.counter-value').forEach(c => counterObserver.observe(c));

        // Scroll Reveal Animation
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

        // FAQ toggle icons
        document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(btn => {
            btn.addEventListener('click', function () {
                const icon = this.querySelector('.faq-toggle');
                setTimeout(() => {
                    const target = document.querySelector(this.getAttribute('data-bs-target'));
                    if (target.classList.contains('show')) {
                        icon.classList.replace('ki-plus-circle', 'ki-minus-circle');
                    } else {
                        icon.classList.replace('ki-minus-circle', 'ki-plus-circle');
                    }
                }, 50);
            });
        });

        /* Force layout cleanup for Metronic JS */
        document.addEventListener('DOMContentLoaded', function () {
            document.body.classList.remove('aside-enabled');
            document.body.removeAttribute('data-kt-aside-display');
            document.body.setAttribute('data-kt-aside-display', 'false');
        });

        /* ====== Hero live status card: cycles through routes across Nigeria ====== */
        (function () {
            const statusEl = document.getElementById('heroStatusText');
            const idEl = document.getElementById('heroTrackId');
            const barEl = document.getElementById('heroProgressBar');
            if (!statusEl || !idEl || !barEl) return;

            const routes = [
                { id: '#SW-0847', text: 'Heading to Victoria Island, Lagos...', progress: 70 },
                { id: '#SW-1932', text: 'Arriving in Wuse, Abuja...', progress: 85 },
                { id: '#SW-2410', text: 'En route to GRA, Port Harcourt...', progress: 45 },
                { id: '#SW-3087', text: 'Crossing into Kano Municipal...', progress: 60 },
                { id: '#SW-4156', text: 'Approaching Bodija, Ibadan...', progress: 90 }
            ];
            let i = 0;

            function update() {
                const r = routes[i % routes.length];
                i++;
                statusEl.style.opacity = 0;
                barEl.style.width = '0%';
                setTimeout(() => {
                    idEl.textContent = r.id;
                    statusEl.textContent = r.text;
                    statusEl.style.opacity = 1;
                    requestAnimationFrame(() => { barEl.style.width = r.progress + '%'; });
                }, 280);
            }

            update();
            setInterval(update, 4200);
        })();

        /* ====== Live activity ticker ====== */
        (function () {
            const el = document.getElementById('liveActivityText');
            if (!el) return;

            const events = [
                'Order #SW-2291 just delivered in Lagos',
                'Order #SW-4410 picked up in Abuja',
                'Order #SW-1187 delivered in Port Harcourt',
                'Order #SW-3325 en route in Kano',
                'Order #SW-5502 delivered in Ibadan',
                'Order #SW-2874 picked up in Enugu',
                'Order #SW-6690 delivered in Benin City'
            ];
            let i = 0;

            setInterval(() => {
                i = (i + 1) % events.length;
                el.style.opacity = 0;
                setTimeout(() => {
                    el.textContent = events[i];
                    el.style.opacity = 1;
                }, 250);
            }, 3500);
        })();

        /* ====== Animated coverage network (replaces static map image) ====== */
        (function () {
            const canvas = document.getElementById('coverageCanvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            const container = canvas.parentElement;

            function resize() {
                canvas.width = container.clientWidth;
                canvas.height = container.clientHeight;
            }
            resize();
            window.addEventListener('resize', resize);

            // Stylized node layout (abstract network, not a literal geographic map)
            const cities = [
                { name: 'Abuja', x: 0.50, y: 0.42, hub: true },
                { name: 'Lagos', x: 0.16, y: 0.70 },
                { name: 'Ibadan', x: 0.22, y: 0.58 },
                { name: 'Kano', x: 0.54, y: 0.14 },
                { name: 'Kaduna', x: 0.48, y: 0.27 },
                { name: 'Port Harcourt', x: 0.40, y: 0.84 },
                { name: 'Enugu', x: 0.60, y: 0.68 },
                { name: 'Maiduguri', x: 0.86, y: 0.20 }
            ];
            const hub = cities.find(c => c.hub);
            const spokes = cities.filter(c => !c.hub);
            const packets = spokes.map((c, i) => ({
                city: c,
                progress: i / spokes.length,
                speed: 0.0016 + Math.random() * 0.0009
            }));

            let t = 0;

            function draw() {
                t += 1;
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                // faint background grid
                ctx.strokeStyle = 'rgba(255,255,255,0.04)';
                ctx.lineWidth = 1;
                for (let gx = 0; gx < canvas.width; gx += 40) {
                    ctx.beginPath(); ctx.moveTo(gx, 0); ctx.lineTo(gx, canvas.height); ctx.stroke();
                }
                for (let gy = 0; gy < canvas.height; gy += 40) {
                    ctx.beginPath(); ctx.moveTo(0, gy); ctx.lineTo(canvas.width, gy); ctx.stroke();
                }

                // route lines from hub to each city
                spokes.forEach(c => {
                    const x1 = hub.x * canvas.width, y1 = hub.y * canvas.height;
                    const x2 = c.x * canvas.width, y2 = c.y * canvas.height;
                    ctx.strokeStyle = 'rgba(255,140,0,0.28)';
                    ctx.lineWidth = 1.4;
                    ctx.setLineDash([4, 6]);
                    ctx.lineDashOffset = -t * 0.4;
                    ctx.beginPath(); ctx.moveTo(x1, y1); ctx.lineTo(x2, y2); ctx.stroke();
                    ctx.setLineDash([]);
                });

                // moving delivery packets along each route
                packets.forEach(p => {
                    p.progress += p.speed;
                    if (p.progress > 1) p.progress = 0;
                    const x1 = hub.x * canvas.width, y1 = hub.y * canvas.height;
                    const x2 = p.city.x * canvas.width, y2 = p.city.y * canvas.height;
                    const px = x1 + (x2 - x1) * p.progress;
                    const py = y1 + (y2 - y1) * p.progress;
                    ctx.beginPath();
                    ctx.arc(px, py, 3, 0, Math.PI * 2);
                    ctx.fillStyle = '#ff8c00';
                    ctx.shadowColor = '#ff8c00';
                    ctx.shadowBlur = 8;
                    ctx.fill();
                    ctx.shadowBlur = 0;
                });

                // city nodes with pulse rings + labels
                cities.forEach(c => {
                    const x = c.x * canvas.width, y = c.y * canvas.height;
                    const pulse = 4 + Math.sin(t * 0.05 + x) * 1.5;

                    ctx.beginPath();
                    ctx.arc(x, y, c.hub ? 7 : 5, 0, Math.PI * 2);
                    ctx.fillStyle = c.hub ? '#ffffff' : '#4dd4ac';
                    ctx.fill();

                    ctx.beginPath();
                    ctx.arc(x, y, (c.hub ? 12 : 9) + pulse, 0, Math.PI * 2);
                    ctx.strokeStyle = c.hub ? 'rgba(255,255,255,0.25)' : 'rgba(77,212,172,0.25)';
                    ctx.lineWidth = 1.5;
                    ctx.stroke();

                    ctx.fillStyle = 'rgba(255,255,255,0.78)';
                    ctx.font = '11px Inter, sans-serif';
                    ctx.textAlign = 'center';
                    ctx.fillText(c.name, x, y - 14);
                });

                requestAnimationFrame(draw);
            }
            draw();
        })();
    </script>
@endpush