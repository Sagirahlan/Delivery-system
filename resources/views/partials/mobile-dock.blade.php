<!--begin::Universal Liquid Glass Bottom Navigation Dock (All Pages)-->
@auth
    @if(auth()->user()->hasRole('admin'))
        {{-- Admin Bottom Dock --}}
        <div class="liquid-glass-dock shadow-lg">
            <a href="{{ route('dashboard.admin') }}" class="liquid-dock-item {{ request()->routeIs('dashboard.admin') ? 'active' : '' }}" title="Admin Dashboard">
                <i class="ki-duotone ki-element-11"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="liquid-dock-item {{ request()->routeIs('admin.orders*') ? 'active' : '' }}" title="All Orders">
                <i class="ki-duotone ki-box"><span class="path1"></span><span class="path2"></span></i>
                <span>Orders</span>
            </a>
            <a href="{{ route('orders.place') }}" class="liquid-dock-center-btn" title="Place Order">
                <i class="ki-duotone ki-plus fs-1"></i>
            </a>
            <a href="{{ route('admin.agents.index') }}" class="liquid-dock-item {{ request()->routeIs('admin.agents*') ? 'active' : '' }}" title="Agent Directory">
                <i class="ki-duotone ki-people"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                <span>Agents</span>
            </a>
            <a href="{{ route('profile.index') }}" class="liquid-dock-item {{ request()->routeIs('profile*') ? 'active' : '' }}" title="My Profile">
                <i class="ki-duotone ki-user"><span class="path1"></span><span class="path2"></span></i>
                <span>Profile</span>
            </a>
        </div>
    @elseif(auth()->user()->hasRole('agent'))
        {{-- Agent Bottom Dock --}}
        <div class="liquid-glass-dock shadow-lg">
            <a href="{{ route('dashboard.agent') }}" class="liquid-dock-item {{ request()->routeIs('dashboard.agent') ? 'active' : '' }}" title="Agent Dashboard">
                <i class="ki-duotone ki-squares-four"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('agent.orders') }}" class="liquid-dock-item {{ request()->routeIs('agent.orders*') ? 'active' : '' }}" title="Assigned Orders">
                <i class="ki-duotone ki-clipboard-list"><span class="path1"></span><span class="path2"></span></i>
                <span>Assigned</span>
            </a>
            <a href="{{ route('tracking.map') }}" class="liquid-dock-center-btn" title="Live Tracking">
                <i class="ki-duotone ki-geolocation fs-1"></i>
            </a>
            <a href="{{ route('orders.history') }}" class="liquid-dock-item {{ request()->routeIs('orders.history*') ? 'active' : '' }}" title="Delivery History">
                <i class="ki-duotone ki-clock"><span class="path1"></span><span class="path2"></span></i>
                <span>History</span>
            </a>
            <a href="{{ route('profile.index') }}" class="liquid-dock-item {{ request()->routeIs('profile*') ? 'active' : '' }}" title="My Profile">
                <i class="ki-duotone ki-user"><span class="path1"></span><span class="path2"></span></i>
                <span>Profile</span>
            </a>
        </div>
    @else
        {{-- Customer Bottom Dock --}}
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
    @endif
@else
    {{-- Guest / Public Bottom Dock --}}
    <div class="liquid-glass-dock shadow-lg">
        <a href="/" class="liquid-dock-item {{ request()->is('/') ? 'active' : '' }}" title="Home">
            <i class="ki-duotone ki-home"><span class="path1"></span><span class="path2"></span></i>
            <span>Home</span>
        </a>
        <a href="{{ route('tracking.map') }}" class="liquid-dock-item {{ request()->routeIs('tracking.*') ? 'active' : '' }}" title="Track Order">
            <i class="ki-duotone ki-geolocation"><span class="path1"></span><span class="path2"></span></i>
            <span>Track</span>
        </a>
        <a href="{{ route('orders.place') }}" class="liquid-dock-center-btn" title="Send a Package">
            <i class="ki-duotone ki-plus fs-1"></i>
        </a>
        <a href="{{ route('pricing') }}" class="liquid-dock-item {{ request()->routeIs('pricing') ? 'active' : '' }}" title="Pricing">
            <i class="ki-duotone ki-price-tag"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
            <span>Pricing</span>
        </a>
        <a href="{{ route('login') }}" class="liquid-dock-item {{ request()->routeIs('login') ? 'active' : '' }}" title="Log In">
            <i class="ki-duotone ki-user"><span class="path1"></span><span class="path2"></span></i>
            <span>Log In</span>
        </a>
    </div>
@endauth
<!--end::Universal Liquid Glass Bottom Navigation Dock-->
