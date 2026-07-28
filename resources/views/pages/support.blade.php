@extends('layouts.metronic')

@section('title', 'Support')
@section('meta_description', 'Need help with your delivery? Find answers in our FAQ or contact our support team.')

@section('content')
<div class="container py-20">
    <div class="row g-10">
        <!-- FAQ Section -->
        <div class="col-lg-7">
            <h1 class="fs-2x fw-bolder text-dark mb-10">Frequently Asked Questions</h1>
            
            <div class="accordion accordion-icon-toggle" id="kt_accordion_1">
                <!-- FAQ 1 -->
                <div class="mb-5">
                    <div class="accordion-header py-3 d-flex" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_item_1">
                        <span class="accordion-icon"><i class="ki-duotone ki-plus-square fs-3 pb-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                        <h3 class="fs-4 fw-bold mb-0 ms-4">How long does a typical delivery take?</h3>
                    </div>
                    <div id="kt_accordion_1_item_1" class="fs-6 collapse show ps-10" data-bs-parent="#kt_accordion_1">
                        <div class="py-4 text-muted">
                            Our average delivery time within Kano metropolitan area is 25 minutes. However, this can vary based on distance, traffic conditions, and the specific route. You can track your agent in real-time on the map once they pick up your package.
                        </div>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="mb-5">
                    <div class="accordion-header py-3 d-flex collapsed" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_item_2">
                        <span class="accordion-icon"><i class="ki-duotone ki-plus-square fs-3 pb-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                        <h3 class="fs-4 fw-bold mb-0 ms-4">What areas in Kano do you cover?</h3>
                    </div>
                    <div id="kt_accordion_1_item_2" class="fs-6 collapse ps-10" data-bs-parent="#kt_accordion_1">
                        <div class="py-4 text-muted">
                            We currently cover all major metropolitan areas including Sabon Gari, Nassarawa, Gwale, Fagge, Tarauni, Kumbotso, and Ungogo LGA. We are constantly expanding our agent network to cover more suburbs.
                        </div>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="mb-5">
                    <div class="accordion-header py-3 d-flex collapsed" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_item_3">
                        <span class="accordion-icon"><i class="ki-duotone ki-plus-square fs-3 pb-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                        <h3 class="fs-4 fw-bold mb-0 ms-4">What items are prohibited for delivery?</h3>
                    </div>
                    <div id="kt_accordion_1_item_3" class="fs-6 collapse ps-10" data-bs-parent="#kt_accordion_1">
                        <div class="py-4 text-muted">
                            For safety and legal reasons, we do not deliver illegal substances, hazardous chemicals, firearms, or extremely high-value jewelry. Perishable food items should only be sent via our Express service to ensure fresh delivery.
                        </div>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="mb-5">
                    <div class="accordion-header py-3 d-flex collapsed" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_item_4">
                        <span class="accordion-icon"><i class="ki-duotone ki-plus-square fs-3 pb-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                        <h3 class="fs-4 fw-bold mb-0 ms-4">How do I track my package?</h3>
                    </div>
                    <div id="kt_accordion_1_item_4" class="fs-6 collapse ps-10" data-bs-parent="#kt_accordion_1">
                        <div class="py-4 text-muted">
                            Once your order is accepted by an agent, you'll receive a tracking number. You can enter this number on our "Track Order" page to see the real-time location of the agent and the estimated time of arrival.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="col-lg-5">
            <div class="card bg-light-primary border-0 mb-10">
                <div class="card-body p-10">
                    <h2 class="fs-2 fw-bolder text-dark mb-6">Contact Us</h2>
                    <p class="text-muted fs-6 mb-8">Our support team is available from 8:00 AM to 10:00 PM daily to assist you with any questions or issues.</p>
                    
                    <div class="d-flex align-items-center mb-6">
                        <div class="symbol symbol-40px bg-white me-4">
                            <i class="ki-duotone ki-phone fs-2 text-primary p-3"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="text-muted fs-8 fw-bold">Call Us</span>
                            <span class="text-dark fs-6 fw-bolder">+234 800-HMLL</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-6">
                        <div class="symbol symbol-40px bg-white me-4">
                            <i class="ki-duotone ki-sms fs-2 text-primary p-3"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="text-muted fs-8 fw-bold">Email Support</span>
                            <span class="text-dark fs-6 fw-bolder">support@hmllexpress.com</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-6">
                        <div class="symbol symbol-40px bg-white me-4">
                            <i class="ki-duotone ki-whatsapp fs-2 text-success p-3"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="text-muted fs-8 fw-bold">WhatsApp</span>
                            <span class="text-dark fs-6 fw-bolder">+234 901 234 5678</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-40px bg-white me-4">
                            <i class="ki-duotone ki-geolocation fs-2 text-primary p-3"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="text-muted fs-8 fw-bold">Main Office</span>
                            <span class="text-dark fs-6 fw-bolder">No 42 Murtala Muhammed Way, Kano</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Simple Contact Hook -->
            <div class="card border border-dashed border-gray-400">
                <div class="card-body p-8 text-center">
                    <h3 class="fs-4 fw-bolder text-dark mb-4">Are you a delivery agent?</h3>
                    <p class="text-muted fs-7 mb-6">If you need technical support with the agent app or have questions about your earnings, please use the dedicated agent portal support.</p>
                    <a href="/register" class="btn btn-outline btn-outline-primary btn-sm">Join Agent Network</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
