<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', 'HMLL — Fast, reliable delivery across Kano. Order pickup and delivery in minutes.')">
    <title>@yield('title', 'HMLL') — Delivery System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Mono:wght@400;500&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Phosphor Icons -->
    <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/regular/style.css">
    <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/fill/style.css">
    <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/bold/style.css">

    <!-- CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ asset('css/fallback.css') }}">
    @endif

    <link rel="stylesheet" href="{{ asset('css/liquid-glass-mobile.css') }}">
    @stack('styles')
</head>
<body class="min-h-screen liquid-mesh-container">
    <div class="liquid-mesh-bg"></div>
    @hasSection('hide_navbar')
    @else
        @include('partials.navbar')
    @endif

    <main>
        @yield('content')
    </main>

    @if(!request()->is('/') && !request()->routeIs('home'))
        @include('partials.mobile-dock')
    @endif

    @stack('scripts')
</body>
</html>
