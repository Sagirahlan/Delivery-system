@extends('layouts.metronic')

@section('title', 'Pricing')
@section('meta_description', 'Transparent and affordable delivery rates in Kano. No hidden fees.')

@section('content')
<style>
    .pricing-header {
        text-align: center;
        padding: 5rem 0;
        background: radial-gradient(circle at center, rgba(114, 57, 234, 0.05) 0%, transparent 100%);
    }
    .pricing-card {
        border-radius: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .pricing-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    }
    .popular-badge {
        position: absolute;
        top: 0;
        left: 50%;
        transform: translate(-50%, -50%);
        background: var(--kt-primary);
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
</style>

<div class="pricing-header">
    <span class="badge badge-light-primary px-4 py-3 mb-4 fw-bolder">TRANSPARENT PRICING</span>
    <h1 class="display-4 fw-bolder text-dark mb-4">Simple Rates for <span class="text-primary">Every Need</span></h1>
    <p class="fs-5 text-muted max-w-600px mx-auto mb-0">We believe in fair, predictable pricing. No surge charges, no hidden fees. Just fast delivery at a price that makes sense.</p>
</div>

<div class="container pb-20">
    <div class="row g-8 mb-20 justify-content-center">
        <!-- Small -->
        <div class="col-md-4">
            <div class="card pricing-card h-100">
                <div class="card-body p-10 text-center">
                    <div class="symbol symbol-60px bg-light-success mb-6 p-4">
                        <i class="ki-duotone ki-package fs-2x text-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                    </div>
                    <h3 class="fs-2 fw-bolder text-dark mb-2">Small</h3>
                    <p class="text-muted fs-6 mb-6">Letters, documents, and small parcels that fit in a standard envelope or small pouch.</p>
                    
                    <div class="mb-8">
                        <span class="fs-4x fw-bolder text-dark font-monospace">₦500</span>
                        <span class="text-muted fw-bold">/ delivery</span>
                    </div>

                    <ul class="list-unstyled text-start mb-10">
                        <li class="d-flex align-items-center gap-3 mb-4">
                            <i class="ki-duotone ki-check text-success fs-3"><span class="path1"></span><span class="path2"></span></i>
                            <span class="text-gray-700">Weight: Up to 5kg</span>
                        </li>
                        <li class="d-flex align-items-center gap-3 mb-4">
                            <i class="ki-duotone ki-check text-success fs-3"><span class="path1"></span><span class="path2"></span></i>
                            <span class="text-gray-700">Real-time GPS Tracking</span>
                        </li>
                        <li class="d-flex align-items-center gap-3 mb-4">
                            <i class="ki-duotone ki-check text-success fs-3"><span class="path1"></span><span class="path2"></span></i>
                            <span class="text-gray-700">SMS Notifications</span>
                        </li>
                    </ul>

                    <a href="/orders/place" class="btn btn-light-success w-100 btn-lg">Choose Small</a>
                </div>
            </div>
        </div>

        <!-- Medium -->
        <div class="col-md-4">
            <div class="card pricing-card h-100 border-primary border-2">
                <div class="popular-badge shadow-sm">MOST POPULAR</div>
                <div class="card-body p-10 text-center">
                    <div class="symbol symbol-60px bg-light-primary mb-6 p-4">
                        <i class="ki-duotone ki-briefcase fs-2x text-primary"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <h2 class="fs-2 fw-bolder text-dark mb-2">Medium</h2>
                    <p class="text-muted fs-6 mb-6">Standard boxes, electronics, clothing, and moderate-sized e-commerce orders.</p>
                    
                    <div class="mb-8">
                        <span class="fs-4x fw-bolder text-primary font-monospace">₦1,000</span>
                        <span class="text-muted fw-bold">/ delivery</span>
                    </div>

                    <ul class="list-unstyled text-start mb-10">
                        <li class="d-flex align-items-center gap-3 mb-4">
                            <i class="ki-duotone ki-check text-success fs-3"><span class="path1"></span><span class="path2"></span></i>
                            <span class="text-gray-700">Weight: Up to 15kg</span>
                        </li>
                        <li class="d-flex align-items-center gap-3 mb-4">
                            <i class="ki-duotone ki-check text-success fs-3"><span class="path1"></span><span class="path2"></span></i>
                            <span class="text-gray-700">Live Map Tracking</span>
                        </li>
                        <li class="d-flex align-items-center gap-3 mb-4">
                            <i class="ki-duotone ki-check text-success fs-3"><span class="path1"></span><span class="path2"></span></i>
                            <span class="text-gray-700">Priority Dispatch</span>
                        </li>
                        <li class="d-flex align-items-center gap-3 mb-4">
                            <i class="ki-duotone ki-check text-success fs-3"><span class="path1"></span><span class="path2"></span></i>
                            <span class="text-gray-700">Fragile Handling Option</span>
                        </li>
                    </ul>

                    <a href="/orders/place" class="btn btn-primary w-100 btn-lg shadow-lg">Choose Medium</a>
                </div>
            </div>
        </div>

        <!-- Large -->
        <div class="col-md-4">
            <div class="card pricing-card h-100">
                <div class="card-body p-10 text-center">
                    <div class="symbol symbol-60px bg-light-warning mb-6 p-4">
                        <i class="ki-duotone ki-truck fs-2x text-warning"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                    </div>
                    <h3 class="fs-2 fw-bolder text-dark mb-2">Large</h3>
                    <p class="text-muted fs-6 mb-6">Bulk inventory, appliances, or multiple packages heading to the same destination.</p>
                    
                    <div class="mb-8">
                        <span class="fs-4x fw-bolder text-dark font-monospace">₦2,000</span>
                        <span class="text-muted fw-bold">/ delivery</span>
                    </div>

                    <ul class="list-unstyled text-start mb-10">
                        <li class="d-flex align-items-center gap-3 mb-4">
                            <i class="ki-duotone ki-check text-success fs-3"><span class="path1"></span><span class="path2"></span></i>
                            <span class="text-gray-700">Weight: Up to 50kg</span>
                        </li>
                        <li class="d-flex align-items-center gap-3 mb-4">
                            <i class="ki-duotone ki-check text-success fs-3"><span class="path1"></span><span class="path2"></span></i>
                            <span class="text-gray-700">Secure Large Handling</span>
                        </li>
                        <li class="d-flex align-items-center gap-3 mb-4">
                            <i class="ki-duotone ki-check text-success fs-3"><span class="path1"></span><span class="path2"></span></i>
                            <span class="text-gray-700">Dedicated Courier</span>
                        </li>
                    </ul>

                    <a href="/orders/place" class="btn btn-light-warning w-100 btn-lg">Choose Large</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Info Section -->
    <div class="card bg-light border-0">
        <div class="card-body p-15">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h2 class="fs-1 fw-bolder text-dark mb-4">Enterprise & Business Plans</h2>
                    <p class="fs-5 text-muted mb-8">Do you run a business with high delivery volume? We offer customized billing, monthly reporting, and volume-based discounts for our corporate partners.</p>
                    <div class="d-flex flex-wrap gap-4">
                        <div class="d-flex align-items-center gap-2">
                            <i class="ki-duotone ki-check text-success fs-2"><span class="path1"></span><span class="path2"></span></i>
                            <span class="fw-bold">Monthly Invoicing</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="ki-duotone ki-check text-success fs-2"><span class="path1"></span><span class="path2"></span></i>
                            <span class="fw-bold">API Integration</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="ki-duotone ki-check text-success fs-2"><span class="path1"></span><span class="path2"></span></i>
                            <span class="fw-bold">Dedicated Manager</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 text-center text-lg-end mt-10 mt-lg-0">
                    <a href="/support" class="btn btn-dark btn-lg px-10">Contact Sales</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
