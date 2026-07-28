<!DOCTYPE html>
<html lang="en">
<head>
    <base href="{{ url('/') }}"/>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="@yield('meta_description', 'HMLL — Fast, reliable delivery across Kano.')" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'HMLL') — Delivery System</title>

    <link rel="shortcut icon" href="{{ asset('metronic/media/logos/favicon.ico') }}" />

    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->

    <!--begin::Metronic Global Stylesheets-->
    <link href="{{ asset('metronic/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Metronic Global Stylesheets-->

    <!--begin::Custom Overrides-->
    <link href="{{ asset('css/metronic-custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/liquid-glass-mobile.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Custom Overrides-->

    @stack('styles')
</head>

<body id="kt_body" class="@yield('body_class', 'aside-enabled')">
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
            document.body.classList.add(themeMode === 'dark' ? 'dark-mode' : 'light-mode');
        }
    </script>
    <!--end::Theme mode setup on page load-->

    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">

            <!--begin::Aside/Sidebar-->
            @hasSection('sidebar')
            <div id="kt_aside" class="aside" style="background-color: #21242e !important;" data-kt-drawer="true" data-kt-drawer-name="aside"
                 data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
                 data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
                 data-kt-drawer-toggle="#kt_aside_mobile_toggle">
                <!--begin::Brand-->
                <div class="aside-brand flex-column-auto pt-8 pb-4" id="kt_aside_brand">
                    <!--begin::Logo-->
                    <a href="/" class="d-flex align-items-center text-decoration-none" style="padding-left: 15px;">
                        <div class="symbol bg-white rounded-circle p-1 shadow-sm overflow-hidden me-3" style="width: 40px; height: 40px; min-width: 40px;">
                            <img src="{{ asset('images/logo-yolah.jpg') }}" alt="HMLL" style="width: 100%; height: 100%; object-fit: contain;">
                        </div>
                        <span class="text-white fw-bold ls-1" style="font-size: 1.1rem;">HMLL</span>
                    </a>
                </div>
                <!--end::Brand-->

                <!--begin::Aside menu-->
                <div class="aside-menu flex-column-fluid pt-2 pb-6">
                    <div id="kt_aside_menu" class="hover-scroll-y" data-kt-menu="true" data-kt-menu-scroll="true">
                        @yield('sidebar')
                    </div>
                </div>
                <!--end::Aside menu-->
            </div>
            @endif
            <!--end::Aside-->

            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

                <!--begin::Header-->
                @include('partials.metronic-header')
                <!--end::Header-->

                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid liquid-mesh-container" id="kt_content">
                    <div class="liquid-mesh-bg"></div>
                    @hasSection('content_toolbar')
                        @yield('content_toolbar')
                    @endif

                    <div class="post d-flex flex-column-fluid">
                        <div class="@yield('container_class', 'container-fluid')">
                            @yield('content')
                        </div>
                    </div>
                </div>
                <!--end::Content-->

                <!--begin::Footer-->
                @include('partials.metronic-footer')
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->

    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-duotone ki-arrow-up fs-1">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </div>
    <!--end::Scrolltop-->

    <!--begin::Metronic Global Javascript-->
    <script>var hostUrl = "{{ asset('metronic/') }}";</script>
    <script src="{{ asset('metronic/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('metronic/js/scripts.bundle.js') }}"></script>
    <!--end::Metronic Global Javascript-->

    <!--begin::Theme Toggle Script-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('theme-toggle-btn');
            const sunIcon = document.getElementById('theme-icon-sun');
            const moonIcon = document.getElementById('theme-icon-moon');

            function getThemeMode() {
                return document.documentElement.getAttribute('data-bs-theme') || 'light';
            }

            function updateIcons(mode) {
                if (mode === 'dark') {
                    sunIcon.classList.remove('d-none');
                    moonIcon.classList.add('d-none');
                } else {
                    moonIcon.classList.remove('d-none');
                    sunIcon.classList.add('d-none');
                }
            }

            // Initialize icons
            updateIcons(getThemeMode());

            // Toggle handler
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    const currentMode = getThemeMode();
                    const newMode = currentMode === 'dark' ? 'light' : 'dark';

                    document.documentElement.setAttribute('data-bs-theme', newMode);
                    localStorage.setItem('data-bs-theme', newMode);
                    document.body.classList.toggle('dark-mode', newMode === 'dark');
                    document.body.classList.toggle('light-mode', newMode === 'light');

                    updateIcons(newMode);

                    // Show tooltip feedback
                    const tooltip = bootstrap.Tooltip.getInstance(toggleBtn);
                    if (tooltip) {
                        tooltip.setContent({ title: `Switch to ${newMode === 'dark' ? 'Dark' : 'Light'} Mode` });
                    }
                });
            }
        });
    </script>
    <!--end::Theme Toggle Script-->

    <!--begin::Notifications Script-->
    <script>
        function loadNotifications() {
            fetch('/api/notifications', {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                const list = document.getElementById('notif-list');
                const badge = document.getElementById('notif-badge');
                const markAllBtn = document.getElementById('notif-mark-all-read');

                if (data.unread > 0) {
                    badge.style.display = 'block';
                    markAllBtn.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                    markAllBtn.style.display = 'none';
                }

                if (data.notifications.length === 0) {
                    list.innerHTML = '<div class="text-center text-muted py-6 fs-7">No notifications</div>';
                    return;
                }

                let html = '';
                data.notifications.slice(0, 8).forEach(n => {
                    const typeIcons = {
                        'status_changed': 'ki-clipboard',
                        'order_cancelled': 'ki-cross-circle',
                        'order_assigned': 'ki-clipboard-check'
                    };
                    const typeColors = {
                        'status_changed': 'warning',
                        'order_cancelled': 'danger',
                        'order_assigned': 'success'
                    };
                    const icon = typeIcons[n.data.type] || 'ki-information';
                    const color = typeColors[n.data.type] || 'primary';
                    const bgClass = n.read_at ? '' : 'bg-light-primary';
                    const title = n.data.type === 'status_changed'
                        ? `Order ${n.data.tracking_number} → ${n.data.new_status}`
                        : n.data.type === 'order_cancelled'
                        ? `Order ${n.data.tracking_number} cancelled`
                        : n.data.type === 'order_assigned'
                        ? `Order ${n.data.tracking_number} assigned`
                        : 'Notification';

                    html += `<div class="d-flex align-items-center px-5 py-3 ${bgClass}" style="cursor:pointer;" onclick="markNotifRead('${n.id}')">
                        <div class="symbol symbol-30px me-3">
                            <div class="symbol-label bg-light-${color}">
                                <i class="ki-duotone ${icon} fs-3 text-${color}"><span class="path1"></span><span class="path2"></span></i>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="fs-7 text-dark fw-semibold">${title}</span>
                            <span class="fs-8 text-muted">${new Date(n.created_at).toLocaleString()}</span>
                        </div>
                    </div>`;
                });
                list.innerHTML = html;
            })
            .catch(() => {});
        }

        function markNotifRead(id) {
            fetch(`/api/notifications/${id}/read`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
            }).then(() => loadNotifications());
        }

        document.getElementById('notif-mark-all-read')?.addEventListener('click', () => {
            fetch('/api/notifications/read-all', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
            }).then(() => loadNotifications());
        });

        // Load on page
        loadNotifications();
        // Refresh every 30 seconds
        setInterval(loadNotifications, 30000);
    </script>
    <!--end::Notifications Script-->

    @if(!request()->is('/') && !request()->routeIs('home'))
        @include('partials.mobile-dock')
    @endif

    @stack('scripts')
</body>
</html>
