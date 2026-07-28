{{-- Customer Sidebar Menu --}}
<div style="margin-top: 2rem;">
    <a class="menu-link mb-2 {{ request()->routeIs('dashboard.customer') ? 'active' : '' }}" href="{{ route('dashboard.customer') }}" id="sidebar-orders" style="color:{{ request()->routeIs('dashboard.customer') ? '#ff8c00' : '#bbb' }};{{ request()->routeIs('dashboard.customer') ? 'background:rgba(255,140,0,0.1);' : '' }}border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-package fs-4" style="color:{{ request()->routeIs('dashboard.customer') ? '#ff8c00' : '#64748b' }};"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <span>Orders</span>
    </a>
    <a class="menu-link mb-2 {{ request()->routeIs('orders.place') ? 'active' : '' }}" href="{{ route('orders.place') }}" id="sidebar-new-order" style="color:{{ request()->routeIs('orders.place') ? '#ff8c00' : '#bbb' }};{{ request()->routeIs('orders.place') ? 'background:rgba(255,140,0,0.1);' : '' }}border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-plus-circle fs-4" style="color:{{ request()->routeIs('orders.place') ? '#ff8c00' : '#64748b' }};"><span class="path1"></span><span class="path2"></span></i>
        <span>Place New Order</span>
    </a>
    <a class="menu-link mb-2 {{ request()->routeIs('tracking.*') ? 'active' : '' }}" href="{{ route('tracking.map') }}" id="sidebar-tracking" style="color:{{ request()->routeIs('tracking.*') ? '#ff8c00' : '#bbb' }};{{ request()->routeIs('tracking.*') ? 'background:rgba(255,140,0,0.1);' : '' }}border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-geolocation fs-4" style="color:{{ request()->routeIs('tracking.*') ? '#ff8c00' : '#64748b' }};"><span class="path1"></span><span class="path2"></span></i>
        <span>Live Tracking</span>
    </a>
    <a class="menu-link mb-2 {{ request()->routeIs('orders.history*') ? 'active' : '' }}" href="{{ route('orders.history') }}" id="sidebar-history" style="color:{{ request()->routeIs('orders.history*') ? '#ff8c00' : '#bbb' }};{{ request()->routeIs('orders.history*') ? 'background:rgba(255,140,0,0.1);' : '' }}border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-clock fs-4" style="color:{{ request()->routeIs('orders.history*') ? '#ff8c00' : '#64748b' }};"><span class="path1"></span><span class="path2"></span></i>
        <span>Order History</span>
    </a>
    <a class="menu-link mb-2 {{ request()->routeIs('payments.customer') ? 'active' : '' }}" href="{{ route('payments.customer') }}" id="sidebar-payments" style="color:{{ request()->routeIs('payments.customer') ? '#ff8c00' : '#bbb' }};{{ request()->routeIs('payments.customer') ? 'background:rgba(255,140,0,0.1);' : '' }}border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-bill fs-4" style="color:{{ request()->routeIs('payments.customer') ? '#ff8c00' : '#64748b' }};"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span></i>
        <span>Payment History</span>
    </a>
    <a class="menu-link mb-2 {{ request()->routeIs('notifications.*') ? 'active' : '' }}" href="{{ route('notifications.page') }}" id="sidebar-notifications" style="color:{{ request()->routeIs('notifications.*') ? '#ff8c00' : '#bbb' }};{{ request()->routeIs('notifications.*') ? 'background:rgba(255,140,0,0.1);' : '' }}border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-notification-1 fs-4" style="color:{{ request()->routeIs('notifications.*') ? '#ff8c00' : '#64748b' }};"><span class="path1"></span><span class="path2"></span></i>
        <span>Notifications</span>
    </a>
    <a class="menu-link mb-2 {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.index') }}" id="sidebar-profile" style="color:{{ request()->routeIs('profile.*') ? '#ff8c00' : '#bbb' }};{{ request()->routeIs('profile.*') ? 'background:rgba(255,140,0,0.1);' : '' }}border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-profile-circle fs-4" style="color:{{ request()->routeIs('profile.*') ? '#ff8c00' : '#64748b' }};"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <span>My Profile</span>
    </a>
</div>
