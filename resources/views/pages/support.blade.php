@extends('layouts.metronic')

@section('title', 'Support — HMLL Logistics')
@section('meta_description', 'Need help with your HMLL delivery or HammShop order? Find quick answers or contact our 24/7 support team.')

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
    .support-hero {
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
    .glass-card-support {
        background: var(--glass-bg);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        box-shadow: var(--glass-shadow);
    }
</style>

<!-- Hero Section -->
<div class="support-hero text-white">
    <div class="max-w-700px mx-auto">
        <span class="badge bg-warning bg-opacity-20 text-warning px-4 py-2 rounded-pill fs-7 fw-bolder mb-4 text-uppercase tracking-wider">
            24/7 CUSTOMER HELP CENTER
        </span>
        <h1 class="display-4 fw-bolder text-white mb-3">
            How Can We <span class="text-warning">Help You</span> Today?
        </h1>
        <p class="fs-5 text-white text-opacity-80 leading-relaxed mb-0">
            Have questions about package tracking, delivery rates, or HammShop orders? We're here 24 hours a day to assist you.
        </p>
    </div>
</div>

<div class="container pb-16">
    <div class="row g-10">
        <!-- FAQ Section -->
        <div class="col-lg-7">
            <h2 class="fs-2x fw-bolder text-dark mb-6">Frequently Asked Questions</h2>
            
            <div class="accordion accordion-icon-toggle gap-4 d-flex flex-column" id="kt_accordion_1">
                <!-- FAQ 1 -->
                <div class="glass-card-support p-6 rounded-4">
                    <div class="accordion-header cursor-pointer d-flex align-items-center justify-content-between" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_item_1">
                        <h3 class="fs-5 fw-bold text-dark mb-0 me-4">How long does nationwide delivery take?</h3>
                        <i class="ki-duotone ki-down fs-3 text-primary"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <div id="kt_accordion_1_item_1" class="collapse show mt-4 text-muted fs-6" data-bs-parent="#kt_accordion_1">
                        Intra-city deliveries (within Lagos, Kano, Abuja, Port Harcourt) take between 20 to 45 minutes on average. Inter-state deliveries across Nigeria arrive within 24 to 48 hours. You can monitor live agent GPS coordinates at any moment.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="glass-card-support p-6 rounded-4">
                    <div class="accordion-header cursor-pointer d-flex align-items-center justify-content-between collapsed" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_item_2">
                        <h3 class="fs-5 fw-bold text-dark mb-0 me-4">How do I track my package live?</h3>
                        <i class="ki-duotone ki-down fs-3 text-primary"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <div id="kt_accordion_1_item_2" class="collapse mt-4 text-muted fs-6" data-bs-parent="#kt_accordion_1">
                        Enter your unique tracking code (e.g. <code>SD-1247</code>) on the <strong>Track Order</strong> page or click the tracking link sent to your phone/email to view the live Leaflet map and courier movement.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="glass-card-support p-6 rounded-4">
                    <div class="accordion-header cursor-pointer d-flex align-items-center justify-content-between collapsed" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_item_3">
                        <h3 class="fs-5 fw-bold text-dark mb-0 me-4">What items are supported for delivery?</h3>
                        <i class="ki-duotone ki-down fs-3 text-primary"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <div id="kt_accordion_1_item_3" class="collapse mt-4 text-muted fs-6" data-bs-parent="#kt_accordion_1">
                        We deliver documents, electronics, clothing, home appliances, food packages, groceries from HammShop, and general merchandise. Prohibited items include hazardous chemicals, illegal substances, and unverified weapons.
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="glass-card-support p-6 rounded-4">
                    <div class="accordion-header cursor-pointer d-flex align-items-center justify-content-between collapsed" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_item_4">
                        <h3 class="fs-5 fw-bold text-dark mb-0 me-4">How do HammShop store deliveries work?</h3>
                        <i class="ki-duotone ki-down fs-3 text-primary"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <div id="kt_accordion_1_item_4" class="collapse mt-4 text-muted fs-6" data-bs-parent="#kt_accordion_1">
                        When you purchase items via HammShop, an HMLL courier is automatically assigned to pick up your store items and deliver them directly to your specified address.
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Cards Section -->
        <div class="col-lg-5">
            <div class="glass-card-support p-8 rounded-4 mb-8">
                <h2 class="fs-2 fw-bolder text-dark mb-4">Contact Support</h2>
                <p class="text-muted fs-6 mb-8">Our support desk operates round the clock to ensure seamless logistics for senders and recipients.</p>
                
                <div class="d-flex align-items-center mb-6 p-4 rounded-3 bg-light-primary">
                    <div class="symbol symbol-45px bg-primary text-white rounded-circle me-4 d-flex align-items-center justify-content-center">
                        <i class="ki-duotone ki-phone fs-2 text-white"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <div>
                        <div class="text-muted fs-8 fw-bold">Phone Support</div>
                        <div class="text-dark fs-6 fw-bolder">+234 800-SWIFT (79438)</div>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-6 p-4 rounded-3 bg-light-success">
                    <div class="symbol symbol-45px bg-success text-white rounded-circle me-4 d-flex align-items-center justify-content-center">
                        <i class="ki-duotone ki-whatsapp fs-2 text-white"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <div>
                        <div class="text-muted fs-8 fw-bold">WhatsApp Direct</div>
                        <div class="text-dark fs-6 fw-bolder">+234 901 234 5678</div>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-6 p-4 rounded-3 bg-light-warning">
                    <div class="symbol symbol-45px bg-warning text-white rounded-circle me-4 d-flex align-items-center justify-content-center">
                        <i class="ki-duotone ki-sms fs-2 text-white"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <div>
                        <div class="text-muted fs-8 fw-bold">Email Desk</div>
                        <div class="text-dark fs-6 fw-bolder">support@swiftdrop.ng</div>
                    </div>
                </div>

                <div class="d-flex align-items-center p-4 rounded-3 bg-light">
                    <div class="symbol symbol-45px bg-secondary text-dark rounded-circle me-4 d-flex align-items-center justify-content-center">
                        <i class="ki-duotone ki-geolocation fs-2 text-dark"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <div>
                        <div class="text-muted fs-8 fw-bold">Headquarters</div>
                        <div class="text-dark fs-6 fw-bolder">HMLL Logistics Center, Nigeria</div>
                    </div>
                </div>
            </div>

            <!-- Agent Callout -->
            <div class="glass-card-support p-6 rounded-4 text-center">
                <h3 class="fs-5 fw-bolder text-dark mb-2">Want to become an HMLL Delivery Agent?</h3>
                <p class="text-muted fs-7 mb-4">Earn competitive income delivering packages in your city with flexible hours and weekly payouts.</p>
                <a href="/register" class="btn btn-outline btn-outline-warning btn-sm fw-bold px-6 rounded-pill">
                    Join Agent Network
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

