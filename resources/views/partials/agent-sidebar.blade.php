{{-- Agent Sidebar Menu --}}
<div style="margin-top: 2rem;">
    <a class="menu-link mb-2 {{ request()->routeIs('dashboard.agent') ? 'active' : '' }}"
        href="{{ route('dashboard.agent') }}"
        style="color:{{ request()->routeIs('dashboard.agent') ? '#ff8c00' : '#bbb' }};{{ request()->routeIs('dashboard.agent') ? 'background:rgba(255,140,0,0.1);' : '' }}border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-squares-four fs-4"
            style="color:{{ request()->routeIs('dashboard.agent') ? '#ff8c00' : '#64748b' }};"><span
                class="path1"></span><span class="path2"></span><span class="path3"></span><span
                class="path4"></span></i>
        <span>Dashboard</span>
    </a>
    <a class="menu-link mb-2 {{ request()->routeIs('agent.orders*') ? 'active' : '' }}"
        href="{{ route('agent.orders') }}"
        style="color:{{ request()->routeIs('agent.orders*') ? '#ff8c00' : '#bbb' }};{{ request()->routeIs('agent.orders*') ? 'background:rgba(255,140,0,0.1);' : '' }}border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-clipboard-list fs-4"
            style="color:{{ request()->routeIs('agent.orders*') ? '#ff8c00' : '#64748b' }};"><span
                class="path1"></span><span class="path2"></span></i>
        <span>Assigned Orders</span>
    </a>
    <a class="menu-link mb-2 {{ request()->routeIs('orders.history*') ? 'active' : '' }}"
        href="{{ route('orders.history') }}"
        style="color:{{ request()->routeIs('orders.history*') ? '#ff8c00' : '#bbb' }};{{ request()->routeIs('orders.history*') ? 'background:rgba(255,140,0,0.1);' : '' }}border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-clock fs-4"
            style="color:{{ request()->routeIs('orders.history*') ? '#ff8c00' : '#64748b' }};"><span
                class="path1"></span><span class="path2"></span></i>
        <span>Delivery History</span>
    </a>
    <a class="menu-link mb-2 {{ request()->routeIs('tracking.*') ? 'active' : '' }}" href="{{ route('tracking.map') }}"
        style="color:{{ request()->routeIs('tracking.*') ? '#ff8c00' : '#bbb' }};{{ request()->routeIs('tracking.*') ? 'background:rgba(255,140,0,0.1);' : '' }}border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-geolocation fs-4"
            style="color:{{ request()->routeIs('tracking.*') ? '#ff8c00' : '#64748b' }};"><span
                class="path1"></span><span class="path2"></span></i>
        <span>Live Tracking</span>
    </a>
    <a class="menu-link mb-2 {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.index') }}"
        style="color:{{ request()->routeIs('profile.*') ? '#ff8c00' : '#bbb' }};{{ request()->routeIs('profile.*') ? 'background:rgba(255,140,0,0.1);' : '' }}border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-profile-circle fs-4"
            style="color:{{ request()->routeIs('profile.*') ? '#ff8c00' : '#64748b' }};"><span
                class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <span>My Profile</span>
    </a>
</div>