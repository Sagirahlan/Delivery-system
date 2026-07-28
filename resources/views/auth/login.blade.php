<!DOCTYPE html>
<html lang="en">
<head>
    <base href="{{ url('/') }}"/>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Log In — HMLL</title>

    <link rel="shortcut icon" href="{{ asset('metronic/media/logos/favicon.ico') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="{{ asset('metronic/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/liquid-glass-mobile.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }
        /* Background decoration */
        .auth-page::before {
            content: '';
            position: absolute;
            top: -20%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255,140,0,0.08) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        .auth-page::after {
            content: '';
            position: absolute;
            bottom: -15%;
            left: -5%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255,140,0,0.05) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        .auth-card {
            max-width: 440px;
            width: 100%;
            position: relative;
            z-index: 1;
        }
        .auth-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            margin-bottom: 2rem;
        }
        .auth-logo .brand-text {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.08em;
        }
        [data-bs-theme="dark"] .auth-card .card {
            background-color: #141414;
            border-color: rgba(255,255,255,0.08);
            box-shadow: 0 4px 24px rgba(0,0,0,0.3);
        }
        [data-bs-theme="light"] .auth-card .card {
            background-color: #ffffff;
            border-color: #e4e6ef;
            box-shadow: 0 4px 24px rgba(76,87,125,0.1);
        }
        .auth-input {
            height: 48px;
        }
        [data-bs-theme="dark"] .auth-input {
            background-color: rgba(255,255,255,0.04);
            border-color: rgba(255,255,255,0.08);
            color: #e0e0e0;
        }
        [data-bs-theme="dark"] .auth-input::placeholder {
            color: #555;
        }
        [data-bs-theme="light"] .auth-input {
            background-color: #f9f9f9;
            border-color: #e4e6ef;
            color: #181c32;
        }
        /* Floating illustration */
        .auth-illustration {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>

<body>
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            themeMode = localStorage.getItem("data-bs-theme") || defaultThemeMode;
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>

    <div class="auth-page">
        <!-- Theme Toggle -->
        <button type="button" id="theme-toggle-btn"
                class="btn btn-sm btn-icon position-fixed top-0 end-0 m-4"
                style="width:40px;height:40px;z-index:100;"
                title="Toggle Theme">
            <i class="ki-duotone ki-night-day fs-2 d-none" id="theme-icon-sun"><span class="path1"></span><span class="path2"></span></i>
            <i class="ki-duotone ki-moon fs-2 d-none" id="theme-icon-moon"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        </button>

        <div class="auth-card">
            <!-- Logo -->
            <a href="/" class="auth-logo justify-content-center">
                <div class="symbol symbol-50px bg-white border border-secondary border-opacity-25 rounded-circle overflow-hidden p-1 shadow-sm">
                    <img src="{{ asset('images/logo-yolah.jpg') }}" alt="HMLL" style="object-fit: contain;">
                </div>
                <span class="brand-text text-dark ms-2">HMLL</span>
            </a>

            <!-- Heading -->
            <div class="text-center mb-8">
                <h1 class="text-dark fw-bolder fs-2 mb-2">Welcome Back</h1>
                <p class="text-muted fs-6">Sign in to your account to continue.</p>
            </div>

            <!-- Info Alert -->
            @if (session('info'))
            <div class="alert alert-warning d-flex align-items-center p-4 mb-6 rounded-4">
                <i class="ki-duotone ki-information fs-2x text-warning me-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                <div class="fs-6 fw-semibold text-dark">{{ session('info') }}</div>
            </div>
            @endif

            <!-- Error Alert -->
            @if ($errors->any())
            <div class="alert alert-danger d-flex align-items-center p-4 mb-6">
                <i class="ki-duotone ki-information fs-2x text-danger me-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                <div>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li class="fs-7">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <!-- Login Form -->
            <form id="login-form" action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="form-label fw-semibold fs-6 mb-2" for="login-email">Email Address</label>
                    <div class="position-relative">
                        <span class="position-absolute top-50 translate-middle-y ms-4">
                            <i class="ki-duotone ki-sms fs-4 text-muted"><span class="path1"></span><span class="path2"></span></i>
                        </span>
                        <input type="email" id="login-email" name="email"
                               class="form-control form-control-solid auth-input ps-12"
                               placeholder="you@example.com"
                               value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold fs-6 mb-2" for="login-password">Password</label>
                    <div class="position-relative">
                        <span class="position-absolute top-50 translate-middle-y ms-4">
                            <i class="ki-duotone ki-lock fs-4 text-muted"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        </span>
                        <input type="password" id="login-password" name="password"
                               class="form-control form-control-solid auth-input ps-12"
                               placeholder="Enter your password" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-6">
                    <label class="form-check form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox" id="login-remember" name="remember" value="1" />
                        <span class="form-check-label text-muted fs-7">Remember me</span>
                    </label>
                    <a href="#" class="text-primary fs-7 fw-semibold text-hover-primary">Forgot password?</a>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-lg mb-6" id="login-submit">
                    <span class="indicator-label">
                        Sign In
                        <i class="ki-duotone ki-arrow-right fs-4 ms-2"><span class="path1"></span><span class="path2"></span></i>
                    </span>
                </button>
            </form>

            <!-- Divider -->
            <div class="text-center mb-4">
                <span class="text-muted fs-7">or</span>
            </div>

            <!-- Register Link -->
            <div class="text-center">
                <p class="text-muted fs-6 mb-0">
                    Don't have an account?
                    <a href="/register" class="text-primary fw-bold ms-1">Create Account</a>
                </p>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8">
                <p class="text-muted fs-8">&copy; {{ date('Y') }} HMLL. Kano, Nigeria.</p>
            </div>
        </div>
    </div>

    <script>var hostUrl = "{{ asset('metronic/') }}";</script>
    <script src="{{ asset('metronic/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('metronic/js/scripts.bundle.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('theme-toggle-btn');
            const sunIcon = document.getElementById('theme-icon-sun');
            const moonIcon = document.getElementById('theme-icon-moon');

            function updateIcons(mode) {
                if (mode === 'dark') {
                    sunIcon.classList.remove('d-none');
                    moonIcon.classList.add('d-none');
                } else {
                    moonIcon.classList.remove('d-none');
                    sunIcon.classList.add('d-none');
                }
            }

            const mode = document.documentElement.getAttribute('data-bs-theme') || 'light';
            updateIcons(mode);

            toggleBtn?.addEventListener('click', function() {
                const current = document.documentElement.getAttribute('data-bs-theme') || 'light';
                const next = current === 'dark' ? 'light' : 'dark';
                document.documentElement.setAttribute('data-bs-theme', next);
                localStorage.setItem('data-bs-theme', next);
                updateIcons(next);
            });
        });
    </script>
</body>
</html>
