<nav class="fixed top-0 left-0 right-0 z-50 border-b border-[var(--color-surface-600)]" style="background: rgba(13,13,13,0.85); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="/" class="flex items-center gap-2 group" id="nav-logo">
                <div class="w-10 h-10 rounded-full bg-white border border-gray-200 p-1 flex items-center justify-center group-hover:scale-105 transition-transform overflow-hidden shadow-sm">
                    <img src="{{ asset('images/logo-yolah.jpg') }}" alt="HMLL" class="w-full h-full object-contain">
                </div>
                <span class="font-heading text-xl tracking-wider text-[var(--color-text-primary)]">HMLL</span>
            </a>

            <!-- Desktop Nav -->
            <div class="hidden md:flex items-center gap-1" id="nav-desktop">
                <a href="/" class="btn-ghost text-sm">Home</a>
                <a href="/orders/place" class="btn-ghost text-sm">Send Package</a>
                <a href="/track" class="btn-ghost text-sm">Track Order</a>
            </div>

            <!-- Auth Buttons -->
            <div class="hidden md:flex items-center gap-3" id="nav-auth">
                @guest
                    <a href="https://www.hammshop.com" target="_blank" rel="noopener" class="btn btn-primary btn-sm flex items-center gap-1">
                        <span>🛍️ Shop HammShop</span>
                    </a>
                    <a href="/orders/place" class="btn btn-ghost btn-sm">Send Package</a>
                @else
                    <a href="{{ route('dashboard') }}" class="btn btn-ghost btn-sm flex items-center gap-2">
                        <img src="{{ Auth::user()->avatar_url }}" class="w-6 h-6 rounded-full object-cover border border-[var(--color-surface-400)]" alt="Avatar">
                        <span>Dashboard</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="btn btn-outline btn-sm">Log Out</button>
                    </form>
                @endguest
            </div>

            <!-- Mobile Menu Button -->
            <button class="md:hidden flex items-center justify-center w-10 h-10 rounded-lg hover:bg-[var(--color-surface-600)] transition-colors" id="mobile-menu-btn" aria-label="Open menu">
                <i class="ph-bold ph-list text-xl text-[var(--color-text-primary)]"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div class="md:hidden hidden border-t border-[var(--color-surface-600)]" id="mobile-menu" style="background: rgba(13,13,13,0.95); backdrop-filter: blur(16px);">
        <div class="px-4 py-4 space-y-1">
            <a href="/" class="block px-4 py-2.5 rounded-lg text-[var(--color-text-secondary)] hover:bg-[var(--color-surface-600)] hover:text-[var(--color-text-primary)] transition-colors">Home</a>
            <a href="/orders/place" class="block px-4 py-2.5 rounded-lg text-[var(--color-text-secondary)] hover:bg-[var(--color-surface-600)] hover:text-[var(--color-text-primary)] transition-colors">Send Package</a>
            <a href="/track" class="block px-4 py-2.5 rounded-lg text-[var(--color-text-secondary)] hover:bg-[var(--color-surface-600)] hover:text-[var(--color-text-primary)] transition-colors">Track Order</a>
            <hr class="border-[var(--color-surface-600)] my-2">
            
            @guest
                <a href="{{ route('login') }}" class="block px-4 py-2.5 rounded-lg text-[var(--color-text-secondary)] hover:bg-[var(--color-surface-600)] transition-colors">Log In</a>
                <a href="{{ route('register') }}" class="block px-4 py-2.5 rounded-lg bg-[var(--color-orange-primary)] text-white text-center font-semibold transition-colors hover:bg-[var(--color-orange-hover)]">Sign Up</a>
            @else
                <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 rounded-lg text-[var(--color-text-primary)] hover:bg-[var(--color-surface-600)] transition-colors font-medium">My Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-4 py-2.5 rounded-lg text-[var(--color-text-secondary)] hover:bg-[var(--color-surface-600)] transition-colors">Log Out</button>
                </form>
            @endguest
        </div>
    </div>
</nav>
