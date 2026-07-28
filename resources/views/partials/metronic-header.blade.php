<!--begin::Header-->
<div id="kt_header" class="header">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-center justify-content-between" id="kt_header_container">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            @hasSection('page_title')
                <!--begin::Title-->
                <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-1">
                    @yield('page_title')
                    @hasSection('page_subtitle')
                        <small class="text-muted fs-7 fw-semibold mt-1">@yield('page_subtitle')</small>
                    @endif
                </h1>
                <!--end::Title-->

                <!--begin::Breadcrumb-->
                @hasSection('breadcrumb')
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
                        @yield('breadcrumb')
                    </ul>
                @endif
                <!--end::Breadcrumb-->
            @else
                <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-1">
                    <a href="/" class="d-flex align-items-center text-decoration-none">
                        <div class="symbol bg-white border border-secondary border-opacity-25 rounded-circle overflow-hidden p-1 me-2 shadow-sm" style="width: 35px; height: 35px;">
                            <img src="{{ asset('images/logo-yolah.jpg') }}" alt="HMLL" style="width: 100%; height: 100%; object-fit: contain;">
                        </div>
                        <span class="fw-bold fs-3 ls-1">HMLL</span>
                    </a>
                </h1>
            @endif
        </div>
        <!--end::Page title-->

        <!--begin::Top Menu (Desktop only)-->
        <div class="d-none d-lg-flex align-items-stretch" id="kt_header_nav">
            <div class="header-menu align-items-stretch">
                <div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-state-primary menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch" id="#kt_header_menu" data-kt-menu="true">
                    <div class="menu-item me-lg-1">
                        <a class="menu-link py-3 {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <span class="menu-title">Home</span>
                        </a>
                    </div>
                    <div class="menu-item me-lg-1">
                        <a class="menu-link py-3 {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                            <span class="menu-title">About</span>
                        </a>
                    </div>
                    <div class="menu-item me-lg-1">
                        <a class="menu-link py-3 {{ request()->routeIs('pricing') ? 'active' : '' }}" href="{{ route('pricing') }}">
                            <span class="menu-title">Pricing</span>
                        </a>
                    </div>
                    <div class="menu-item me-lg-1">
                        <a class="menu-link py-3 {{ request()->routeIs('support') ? 'active' : '' }}" href="{{ route('support') }}">
                            <span class="menu-title">Support</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Top Menu-->

        <!--begin::Actions-->
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <!--begin::Track Order Button-->
            <a href="{{ route('tracking.map') }}" class="btn btn-sm btn-light-primary d-none d-md-flex">
                <i class="ki-duotone ki-geolocation fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>
                Track Order
            </a>
            <!--end::Track Order Button-->

            <!--begin::Theme Toggle-->
            <button type="button"
                    class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary d-flex align-items-center justify-content-center rounded-circle"
                    id="theme-toggle-btn"
                    data-bs-toggle="tooltip"
                    title="Toggle Light/Dark Mode"
                    style="width:36px;height:36px;">
                <!-- Sun icon for dark mode (clicking switches to light) -->
                <i class="ki-duotone ki-night-day fs-2 d-none" id="theme-icon-sun">
                    <span class="path1"></span><span class="path2"></span>
                </i>
                <!-- Moon icon for light mode (clicking switches to dark) -->
                <i class="ki-duotone ki-moon fs-2 d-none" id="theme-icon-moon">
                    <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                </i>
            </button>
            <!--end::Theme Toggle-->

            @auth
                <!--begin::Notifications-->
                <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_notifications">
                    <div class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary position-relative"
                         data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                         data-kt-menu-attach="parent"
                         data-kt-menu-placement="bottom-end"
                         style="width:36px;height:36px;">
                        <i class="ki-duotone ki-notification-1 fs-2">
                            <span class="path1"></span><span class="path2"></span>
                        </i>
                        <span class="bullet bullet-dot bg-danger position-absolute top-0 end-0 translate-middle fs-6" id="notif-badge" style="display:none;"></span>
                    </div>
                    <!--begin::Notifications menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column w-300px w-md-325px py-4" data-kt-menu="true" id="kt_notifications_menu">
                        <!--begin::Header-->
                        <div class="px-6 py-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="text-dark fw-bolder m-0">Notifications</h5>
                                <button class="btn btn-sm btn-light-primary" id="notif-mark-all-read" style="display:none;">Mark All Read</button>
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="hover-scroll-y" style="max-height:350px;" id="notif-list">
                            <div class="text-center text-muted py-6 fs-7">Loading...</div>
                        </div>
                        <!--end::Body-->
                        <!--begin::Footer-->
                        <div class="px-6 py-3 border-top">
                            <a href="{{ route('notifications.page') }}" class="btn btn-sm btn-light w-100">View All Notifications</a>
                        </div>
                        <!--end::Footer-->
                    </div>
                    <!--end::Notifications menu-->
                </div>
                <!--end::Notifications-->

                <!--begin::User menu-->
                <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                    <div class="cursor-pointer symbol shadow-sm border border-gray-200"
                         data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                         data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end"
                         style="width: 40px; height: 40px; overflow: hidden; border-radius: 8px;">
                        <img src="{{ Auth::user()->avatar_url }}" alt="user" style="object-fit: cover; width: 100%; height: 100%;" />
                    </div>

                    <!--begin::User account menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                         data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-50px me-5" style="border-radius: 5px; overflow: hidden;">
                                    <img alt="User Avatar" src="{{ Auth::user()->avatar_url }}" style="object-fit: cover; width: 100%; height: 100%;" />
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Username-->
                                <div class="d-flex flex-column">
                                    <div class="fw-bolder d-flex align-items-center fs-5">{{ Auth::user()->name }}</div>
                                    <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{ Auth::user()->email }}</a>
                                </div>
                                <!--end::Username-->
                            </div>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="{{ route('dashboard') }}" class="menu-link px-5">Dashboard</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="{{ route('profile.index') }}" class="menu-link px-5">Account Settings</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="menu-link px-5 text-start">Log Out</button>
                            </form>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::User account menu-->
                </div>
                <!--end::User menu-->
            @else
                <!--begin::HammShop & Send Package Action Buttons-->
                <div class="d-flex align-items-center gap-2 flex-nowrap">
                    <a href="https://www.hammshop.com" target="_blank" rel="noopener" class="liquid-glass-btn-primary btn-sm px-3 py-1.5 fs-7 d-inline-flex align-items-center gap-1">
                        <i class="ki-duotone ki-shop fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                        <span>Shop HammShop</span>
                    </a>
                    <a href="{{ route('orders.place') }}" class="btn btn-sm btn-light-primary px-3 py-1.5 fs-7 d-inline-flex align-items-center gap-1">
                        <i class="ki-duotone ki-plus fs-5"></i>
                        <span>Send Package</span>
                    </a>
                </div>
                <!--end::Action Buttons-->
            @endauth
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Container-->
</div>
<!--end::Header-->
