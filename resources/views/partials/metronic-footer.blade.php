<!--begin::Footer-->
<div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
    <!--begin::Container-->
    <div class="container-xxl d-flex flex-column flex-md-row flex-stack">
        <!--begin::Copyright-->
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">{{ date('Y') }} &copy;</span>
            <a href="/" class="text-gray-800 text-hover-primary">HMLL</a>
        </div>
        <!--end::Copyright-->
        <!--begin::Menu-->
        <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
            <li class="menu-item">
                <a href="{{ route('about') }}" class="menu-link px-2">About</a>
            </li>
            <li class="menu-item">
                <a href="{{ route('support') }}" class="menu-link px-2">Support</a>
            </li>
            <li class="menu-item">
                <a href="{{ route('pricing') }}" class="menu-link px-2">Pricing</a>
            </li>
        </ul>
        <!--end::Menu-->
    </div>
    <!--end::Container-->
</div>
<!--end::Footer-->
