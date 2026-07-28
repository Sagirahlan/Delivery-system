<!DOCTYPE html>
<html lang="en">
<head>
    <base href="{{ url('/') }}"/>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Account — HMLL</title>

    <link rel="shortcut icon" href="{{ asset('metronic/media/logos/favicon.ico') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="{{ asset('metronic/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/liquid-glass-mobile.css') }}" rel="stylesheet" type="text/css" />

    <style>
        body { min-height: 100vh; }
        [data-bs-theme="dark"] body { background: #0a0a0a; }
        [data-bs-theme="light"] body { background: #f5f8fa; }

        .register-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1.5rem;
            position: relative;
        }
        .register-page::before {
            content: '';
            position: absolute; top: -100px; right: -80px;
            width: 500px; height: 500px; border-radius: 50%;
            background: radial-gradient(circle, rgba(255,140,0,0.07) 0%, transparent 70%);
            pointer-events: none;
        }

        .register-wrapper {
            max-width: 900px;
            width: 100%;
            position: relative;
            z-index: 1;
        }

        /* Header */
        .register-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        .register-header .brand-link {
            display: inline-flex; align-items: center; gap: 10px;
            text-decoration: none; margin-bottom: 1.5rem;
        }

        /* Sections */
        .register-section {
            border-radius: 14px;
            padding: 1.75rem 2rem;
            margin-bottom: 1rem;
        }
        [data-bs-theme="dark"] .register-section {
            background: #141414;
            border: 1px solid rgba(255,255,255,0.06);
        }
        [data-bs-theme="light"] .register-section {
            background: #ffffff;
            border: 1px solid #e4e6ef;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }

        .section-number {
            width: 28px; height: 28px; border-radius: 8px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 0.8rem; font-weight: 700; color: #fff;
            background: #ff8c00; margin-right: 10px; flex-shrink: 0;
        }
        .section-title {
            font-size: 1rem; font-weight: 700; color: inherit;
            display: flex; align-items: center;
        }
        .section-desc {
            font-size: 0.82rem; color: #888; margin-top: 2px;
        }

        .reg-input { height: 46px; }
        [data-bs-theme="dark"] .reg-input {
            background-color: rgba(255,255,255,0.04);
            border-color: rgba(255,255,255,0.08);
            color: #e0e0e0;
        }
        [data-bs-theme="dark"] .reg-input::placeholder { color: #555; }
        [data-bs-theme="light"] .reg-input {
            background-color: #f9f9f9;
            border-color: #e4e6ef;
            color: #181c32;
        }

        /* Info Banner */
        .info-banner {
            border-radius: 10px; padding: 1rem 1.25rem;
            display: flex; align-items: flex-start; gap: 12px;
        }
        [data-bs-theme="dark"] .info-banner { background: rgba(0,168,255,0.08); border: 1px solid rgba(0,168,255,0.15); }
        [data-bs-theme="light"] .info-banner { background: rgba(0,168,255,0.06); border: 1px solid rgba(0,168,255,0.12); }
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

    <div class="register-page">
        <!-- Theme Toggle -->
        <button type="button" id="theme-toggle-btn"
                class="btn btn-sm btn-icon position-fixed top-0 end-0 m-4"
                style="width:40px;height:40px;z-index:100;" title="Toggle Theme">
            <i class="ki-duotone ki-night-day fs-2 d-none" id="theme-icon-sun"><span class="path1"></span><span class="path2"></span></i>
            <i class="ki-duotone ki-moon fs-2 d-none" id="theme-icon-moon"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        </button>

        <div class="register-wrapper">
            <!-- Header -->
            <div class="register-header">
                <a href="/" class="brand-link">
                    <div class="symbol symbol-50px bg-white border border-secondary border-opacity-25 rounded-circle overflow-hidden p-1 shadow-sm">
                        <img src="{{ asset('images/logo-yolah.jpg') }}" alt="HMLL" style="object-fit: contain;">
                    </div>
                    <span class="brand-text fs-4 fw-bolder text-dark ls-1 ms-2">HMLL</span>
                </a>
                <h1 class="text-dark fw-bolder fs-2 mb-1">Create Your Account</h1>
                <p class="text-muted fs-6">Sign up as a customer and start sending packages in minutes.</p>
            </div>

            <!-- Info Alert -->
            @if (session('info'))
            <div class="alert alert-warning d-flex align-items-center p-4 mb-4 rounded-4">
                <i class="ki-duotone ki-information fs-2x text-warning me-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                <div class="fs-6 fw-semibold text-dark">{{ session('info') }}</div>
            </div>
            @endif

            <!-- Error Alert -->
            @if ($errors->any())
            <div class="alert alert-danger d-flex align-items-center p-4 mb-4">
                <i class="ki-duotone ki-information fs-2x text-danger me-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                <div><ul class="mb-0 ps-3">@foreach ($errors->all() as $error)<li class="fs-7">{{ $error }}</li>@endforeach</ul></div>
            </div>
            @endif

            <form id="register-form" action="{{ route('register') }}" method="POST">
                @csrf

                <!-- Section 1: Personal Info -->
                <div class="register-section">
                    <div class="mb-1">
                        <div class="section-title text-dark">
                            <span class="section-number">1</span>
                            Personal Information
                        </div>
                        <div class="section-desc">Tell us who you are so we can set up your account.</div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold fs-7 mb-1">Full Name</label>
                            <div class="position-relative">
                                <span class="position-absolute top-50 translate-middle-y ms-3"><i class="ki-duotone ki-profile-circle fs-5 text-muted"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                                <input type="text" name="name" class="form-control form-control-solid reg-input ps-10" placeholder="e.g. Ibrahim Musa" value="{{ old('name') }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold fs-7 mb-1">Phone Number</label>
                            <div class="position-relative">
                                <span class="position-absolute top-50 translate-middle-y ms-3"><i class="ki-duotone ki-phone fs-5 text-muted"><span class="path1"></span><span class="path2"></span></i></span>
                                <input type="tel" name="phone" class="form-control form-control-solid reg-input ps-10" placeholder="+234 801 234 5678" value="{{ old('phone') }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold fs-7 mb-1">Email Address</label>
                            <div class="position-relative">
                                <span class="position-absolute top-50 translate-middle-y ms-3"><i class="ki-duotone ki-sms fs-5 text-muted"><span class="path1"></span><span class="path2"></span></i></span>
                                <input type="email" name="email" class="form-control form-control-solid reg-input ps-10" placeholder="you@example.com" value="{{ old('email') }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Security -->
                <div class="register-section">
                    <div class="mb-1">
                        <div class="section-title text-dark">
                            <span class="section-number">2</span>
                            Account Security
                        </div>
                        <div class="section-desc">Choose a strong password to protect your account.</div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold fs-7 mb-1">Password</label>
                            <div class="position-relative">
                                <span class="position-absolute top-50 translate-middle-y ms-3"><i class="ki-duotone ki-lock fs-5 text-muted"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                                <input type="password" name="password" class="form-control form-control-solid reg-input ps-10" placeholder="Min. 8 characters" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold fs-7 mb-1">Confirm Password</label>
                            <div class="position-relative">
                                <span class="position-absolute top-50 translate-middle-y ms-3"><i class="ki-duotone ki-lock-2 fs-5 text-muted"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i></span>
                                <input type="password" name="password_confirmation" class="form-control form-control-solid reg-input ps-10" placeholder="Re-enter password" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Banner -->
                <div class="info-banner mb-4">
                    <i class="ki-duotone ki-information-5 fs-3 text-info" style="flex-shrink:0;"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                    <div>
                        <div class="fs-7 fw-semibold text-dark">New account = Customer role</div>
                        <div class="fs-8 text-muted">All new sign-ups are registered as customers. Want to become a delivery agent? Contact our admin team after registration or apply through your dashboard.</div>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-primary w-100 btn-lg mb-4">
                    <span class="indicator-label">
                        Create Account
                        <i class="ki-duotone ki-arrow-right fs-4 ms-2"><span class="path1"></span><span class="path2"></span></i>
                    </span>
                </button>

                <!-- Login Link -->
                <div class="text-center mb-4">
                    <p class="text-muted fs-7 mb-0">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-primary fw-bold ms-1">Log In</a>
                    </p>
                </div>
            </form>

            <!-- Footer -->
            <div class="text-center mt-2">
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
