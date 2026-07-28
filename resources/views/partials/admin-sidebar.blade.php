<!-- Admin Sidebar Menu -->
<div style="margin-top: 1.5rem;">
    <div class="px-4 py-2 mb-2">
        <div class="fs-8 text-muted text-uppercase fw-semibold ls-1">Main</div>
    </div>
    <a class="menu-link mb-1 {{ request()->routeIs('dashboard.admin') ? 'active' : '' }}" href="{{ route('dashboard.admin') }}" style="color:{{ request()->routeIs('dashboard.admin') ? '#ff8c00' : '#bbb' }};{{ request()->routeIs('dashboard.admin') ? 'background:rgba(255,140,0,0.1);' : '' }}border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-squares-four fs-4" style="color:{{ request()->routeIs('dashboard.admin') ? '#ff8c00' : '#64748b' }};"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
        <span>Dashboard</span>
    </a>
    <a class="menu-link mb-1 {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}" style="color:{{ request()->routeIs('admin.orders.*') ? '#ff8c00' : '#bbb' }};{{ request()->routeIs('admin.orders.*') ? 'background:rgba(255,140,0,0.1);' : '' }}border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-package fs-4" style="color:{{ request()->routeIs('admin.orders.*') ? '#ff8c00' : '#64748b' }};"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <span>Orders</span>
    </a>

    <div class="px-4 py-2 mb-1 mt-4">
        <div class="fs-8 text-muted text-uppercase fw-semibold ls-1">People</div>
    </div>
    <a class="menu-link mb-1 {{ request()->routeIs('admin.agents.*') ? 'active' : '' }}" href="{{ route('admin.agents.index') }}" style="color:{{ request()->routeIs('admin.agents.*') ? '#ff8c00' : '#bbb' }};{{ request()->routeIs('admin.agents.*') ? 'background:rgba(255,140,0,0.1);' : '' }}border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-users fs-4" style="color:{{ request()->routeIs('admin.agents.*') ? '#ff8c00' : '#64748b' }};"><span class="path1"></span><span class="path2"></span></i>
        <span>Agents</span>
    </a>
    <a class="menu-link mb-1 {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}" href="{{ route('admin.customers.index') }}" style="color:{{ request()->routeIs('admin.customers.*') ? '#ff8c00' : '#bbb' }};{{ request()->routeIs('admin.customers.*') ? 'background:rgba(255,140,0,0.1);' : '' }}border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-profile-circle fs-4" style="color:{{ request()->routeIs('admin.customers.*') ? '#ff8c00' : '#64748b' }};"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <span>Customers</span>
    </a>

    <div class="px-4 py-2 mb-1 mt-4">
        <div class="fs-8 text-muted text-uppercase fw-semibold ls-1">Operations</div>
    </div>
    <a class="menu-link mb-1 {{ request()->routeIs('admin.assignment') ? 'active' : '' }}" href="{{ route('admin.assignment') }}" style="color:{{ request()->routeIs('admin.assignment') ? '#ff8c00' : '#bbb' }};{{ request()->routeIs('admin.assignment') ? 'background:rgba(255,140,0,0.1);' : '' }}border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-clipboard-check fs-4" style="color:{{ request()->routeIs('admin.assignment') ? '#ff8c00' : '#64748b' }};"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <span>Assignments</span>
    </a>
    <a class="menu-link mb-1 {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}" href="{{ route('admin.payments.index') }}" style="color:{{ request()->routeIs('admin.payments.*') ? '#ff8c00' : '#bbb' }};{{ request()->routeIs('admin.payments.*') ? 'background:rgba(255,140,0,0.1);' : '' }}border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-bill fs-4" style="color:{{ request()->routeIs('admin.payments.*') ? '#ff8c00' : '#64748b' }};"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span></i>
        <span>Payments</span>
    </a>
    <a class="menu-link mb-1 {{ request()->routeIs('admin.wallet') ? 'active' : '' }}" href="{{ route('admin.wallet') }}" style="color:{{ request()->routeIs('admin.wallet') ? '#ff8c00' : '#bbb' }};{{ request()->routeIs('admin.wallet') ? 'background:rgba(255,140,0,0.1);' : '' }}border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-wallet fs-4" style="color:{{ request()->routeIs('admin.wallet') ? '#ff8c00' : '#64748b' }};"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
        <span>Company Wallet</span>
    </a>
    <a class="menu-link mb-1 {{ request()->routeIs('admin.notifications') ? 'active' : '' }}" href="{{ route('admin.notifications') }}" style="color:{{ request()->routeIs('admin.notifications') ? '#ff8c00' : '#bbb' }};{{ request()->routeIs('admin.notifications') ? 'background:rgba(255,140,0,0.1);' : '' }}border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-notification-1 fs-4" style="color:{{ request()->routeIs('admin.notifications') ? '#ff8c00' : '#64748b' }};"><span class="path1"></span><span class="path2"></span></i>
        <span>Notifications</span>
    </a>

    <div class="px-4 py-2 mb-1 mt-4">
        <div class="fs-8 text-muted text-uppercase fw-semibold ls-1">System</div>
    </div>
    <a class="menu-link mb-1 {{ request()->routeIs('admin.reports') ? 'active' : '' }}" href="{{ route('admin.reports') }}" style="color:{{ request()->routeIs('admin.reports') ? '#ff8c00' : '#bbb' }};{{ request()->routeIs('admin.reports') ? 'background:rgba(255,140,0,0.1);' : '' }}border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-chart-line-up fs-4" style="color:{{ request()->routeIs('admin.reports') ? '#ff8c00' : '#64748b' }};"><span class="path1"></span><span class="path2"></span></i>
        <span>Reports</span>
    </a>
    <a class="menu-link mb-1 {{ request()->routeIs('admin.settings') ? 'active' : '' }}" href="{{ route('admin.settings') }}" style="color:{{ request()->routeIs('admin.settings') ? '#ff8c00' : '#bbb' }};{{ request()->routeIs('admin.settings') ? 'background:rgba(255,140,0,0.1);' : '' }}border-radius:6px;padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none;">
        <i class="ki-duotone ki-setting-2 fs-4" style="color:{{ request()->routeIs('admin.settings') ? '#ff8c00' : '#64748b' }};"><span class="path1"></span><span class="path2"></span></i>
        <span>Settings</span>
    </a>
</div>
