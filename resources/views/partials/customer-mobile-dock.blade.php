<!--begin::Liquid Glass Bottom Navigation Dock (All Sidebar Items)-->
<div class="liquid-glass-dock shadow-lg">
    <a href="{{ route('dashboard.customer') }}" class="liquid-dock-item {{ request()->routeIs('dashboard.customer') ? 'active' : '' }}" title="Orders Dashboard">
        <i class="ki-duotone ki-package"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <span>Orders</span>
    </a>

    <a href="{{ route('orders.history') }}" class="liquid-dock-item {{ request()->routeIs('orders.history*') ? 'active' : '' }}" title="Order History">
        <i class="ki-duotone ki-clock"><span class="path1"></span><span class="path2"></span></i>
        <span>History</span>
    </a>

    <a href="{{ route('tracking.map') }}" class="liquid-dock-item {{ request()->routeIs('tracking.*') ? 'active' : '' }}" title="Live Tracking">
        <i class="ki-duotone ki-geolocation"><span class="path1"></span><span class="path2"></span></i>
        <span>Tracking</span>
    </a>

    <a href="{{ route('orders.place') }}" class="liquid-dock-center-btn" title="Place New Order">
        <i class="ki-duotone ki-plus fs-1"></i>
    </a>

    <a href="{{ route('payments.customer') }}" class="liquid-dock-item {{ request()->routeIs('payments.customer*') ? 'active' : '' }}" title="Payment History">
        <i class="ki-duotone ki-bill"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span></i>
        <span>Payments</span>
    </a>

    <a href="{{ route('notifications.page') }}" class="liquid-dock-item {{ request()->routeIs('notifications.*') ? 'active' : '' }}" title="Notifications">
        <i class="ki-duotone ki-notification-status"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
        <span>Alerts</span>
    </a>

    <a href="{{ route('profile.index') }}" class="liquid-dock-item {{ request()->routeIs('profile.*') ? 'active' : '' }}" title="My Profile">
        <i class="ki-duotone ki-profile-circle"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <span>Profile</span>
    </a>
</div>
<!--end::Liquid Glass Bottom Navigation Dock-->
