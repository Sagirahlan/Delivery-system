@extends('layouts.metronic')

@section('title', 'About Us')
@section('meta_description', 'Learn about HMLL — Kano\'s premier delivery service.')

@section('content')
<style>
    .hero-section {
        background: linear-gradient(135deg, #1e1e2d 0%, #21242e 100%);
        border-radius: 20px;
        padding: 5rem 2rem;
        margin-bottom: 3rem;
        position: relative;
        overflow: hidden;
    }
    .hero-section::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('{{ asset("images/kano-hero.png") }}') no-repeat center center;
        background-size: cover;
        opacity: 0.15;
        z-index: 0;
    }
    .hero-content {
        position: relative;
        z-index: 1;
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
    }
    .glass-card {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 2.5rem;
    }
    [data-bs-theme="light"] .hero-section {
        background: linear-gradient(135deg, #f5f8fa 0%, #ffffff 100%);
        border: 1px solid #eff2f5;
    }
    [data-bs-theme="light"] .glass-card {
        background: rgba(255, 255, 255, 0.8);
        border: 1px solid #eff2f5;
    }
</style>

<div class="hero-section">
    <div class="hero-content">
        <h1 class="display-4 fw-bolder text-white mb-4">Empowering <span class="text-primary">Kano</span> Through Seamless Logistics</h1>
        <p class="fs-5 text-white text-opacity-75 mb-0">HMLL is more than just a delivery service; we are the heartbeat of commerce in Kano metropolitan. Built on trust, speed, and local expertise.</p>
    </div>
</div>

<div class="container py-10">
    <div class="row g-10 align-items-center mb-20">
        <div class="col-lg-6">
            <h2 class="fs-2x fw-bolder text-dark mb-6">Our Story</h2>
            <p class="fs-5 text-muted mb-6">Founded in the heart of Kano, HMLL was born out of a simple necessity: a reliable, fast, and transparent way to move packages across the city's bustling streets. We recognized that in a city as vibrant and fast-paced as ours, traditional logistics just weren't enough.</p>
            <p class="fs-5 text-muted mb-8">Today, we operate a network of over 300 verified agents, serving thousands of residents and businesses daily from Sabon Gari to Nassarawa. Our mission is to bridge the gap between businesses and their customers with technology-driven delivery solutions.</p>
            
            <div class="row g-4">
                <div class="col-6">
                    <div class="d-flex align-items-center gap-3">
                        <div class="symbol symbol-50px bg-light-primary">
                            <i class="ki-duotone ki-rocket fs-2 text-primary"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <div>
                            <div class="fs-3 fw-bolder text-dark">25m</div>
                            <div class="fs-8 text-muted fw-bold">Avg. Delivery</div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center gap-3">
                        <div class="symbol symbol-50px bg-light-success">
                            <i class="ki-duotone ki-check-circle fs-2 text-success"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <div>
                            <div class="fs-3 fw-bolder text-dark">99%</div>
                            <div class="fs-8 text-muted fw-bold">Safety Rate</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="position-relative">
                <img src="{{ asset('images/redesign/man-agent.jpg') }}" class="w-100 rounded-5 shadow-lg" alt="Our Agent">
                <div class="position-absolute bottom-0 start-0 mb-n10 ms-n10 d-none d-lg-block">
                    <div class="glass-card p-6 shadow-xl" style="max-width: 250px;">
                        <div class="d-flex align-items-center gap-4 mb-3">
                            <div class="symbol symbol-40px symbol-circle">
                                <img src="{{ asset('images/redesign/woman-agent.jpg') }}" alt="Agent">
                            </div>
                            <div class="fs-7 fw-bold text-dark">Verified Network</div>
                        </div>
                        <p class="fs-8 text-muted mb-0">Every agent in our system undergoes rigorous vetting and background checks.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mb-10">
        <h2 class="fs-2x fw-bolder text-dark mb-4">Our Core Values</h2>
        <div class="separator separator-content border-primary w-100px mx-auto mb-10"></div>
    </div>

    <div class="row g-8">
        <div class="col-md-4">
            <div class="card h-100 border-0 bg-light-primary shadow-none">
                <div class="card-body p-8">
                    <div class="symbol symbol-50px bg-white mb-6 p-3">
                        <i class="ki-duotone ki-security-user fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <h3 class="fs-4 fw-bolder text-dark mb-3">Trust First</h3>
                    <p class="text-muted mb-0">We handle every package as if it were our own. Security and reliability are non-negotiable.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 bg-light-warning shadow-none">
                <div class="card-body p-8">
                    <div class="symbol symbol-50px bg-white mb-6 p-3">
                        <i class="ki-duotone ki-flash fs-1 text-warning"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <h3 class="fs-4 fw-bolder text-dark mb-3">Local Expertise</h3>
                    <p class="text-muted mb-0">We know Kano's streets better than anyone. Our local roots enable unmatched speed.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 bg-light-success shadow-none">
                <div class="card-body p-8">
                    <div class="symbol symbol-50px bg-white mb-6 p-3">
                        <i class="ki-duotone ki-phone fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <h3 class="fs-4 fw-bolder text-dark mb-3">User Experience</h3>
                    <p class="text-muted mb-0">From real-time tracking to instant notifications, we leverage tech to keep you informed.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
