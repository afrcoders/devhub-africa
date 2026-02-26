<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="id-service-url" content="{{ request()->secure() ? 'https://' : 'http://' }}{{ config('domains.africoders.id') }}">
    <title>@yield('title', 'KortexTools - Free Online Tools')</title>
    <meta name="description" content="@yield('meta_description', '100+ free online developer and productivity tools')">
    <meta property="og:title" content="@yield('title', 'KortexTools - Free Online Tools')">
    <meta property="og:description" content="@yield('meta_description', '100+ free online developer and productivity tools')">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/kortext/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="/kortext/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/kortext/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/kortext/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/kortext/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/kortext/android-chrome-512x512.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --color-primary: #1a73e8;
            --color-secondary: #5f6368;
            --color-light: #f8f9fa;
            --color-dark: #202124;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            line-height: 1.6;
            color: var(--color-dark);
        }

        .navbar {
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            background-color: white;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
            color: var(--color-primary) !important;
        }

        .nav-link {
            color: var(--color-secondary) !important;
            font-weight: 500;
        }

        .nav-link:hover {
            color: var(--color-primary) !important;
        }

        .hero {
            background: linear-gradient(135deg, var(--color-primary) 0%, #1557b0 100%);
            color: white;
            padding: 4rem 0;
            text-align: center;
        }

        .tool-card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            height: 100%;
        }

        .tool-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }

        .tool-icon {
            font-size: 2.5rem;
            color: var(--color-primary);
            margin-bottom: 1rem;
        }

        .btn-primary {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
        }

        .btn-primary:hover {
            background-color: #1557b0;
            border-color: #1557b0;
        }

        .category-badge {
            display: inline-block;
            background-color: #e8f0fe;
            color: var(--color-primary);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        footer {
            background-color: var(--color-light);
            border-top: 1px solid #e0e0e0;
            margin-top: 4rem;
            padding: 2rem 0;
        }

        .footer-link {
            color: var(--color-secondary);
            text-decoration: none;
        }

        .footer-link:hover {
            color: var(--color-primary);
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .hero {
                padding: 2rem 0;
            }

            .display-4,
            .display-5 {
                font-size: 1.75rem;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container-lg">
            <a class="navbar-brand" href="https://{{ config('domains.tools.kortex') }}/">
                <i class="bi bi-tools"></i> KortexTools
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="https://{{ config('domains.tools.kortex') }}/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://{{ config('domains.tools.kortex') }}/explore">Tools</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://{{ config('domains.tools.kortex') }}/all-tools">All Tools</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://{{ config('domains.tools.kortex') }}/categories">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://{{ config('domains.tools.kortex') }}/search">Search</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://{{ config('domains.tools.kortex') }}/how-it-works">Guide</a>
                    </li>

                    <!-- Authentication -->
                    @if (auth()->check())
                        <li class="nav-item dropdown ms-2">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="https://{{ config('domains.africoders.id') }}/dashboard"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                                <li><a class="dropdown-item" href="https://{{ config('domains.africoders.id') }}/profile"><i class="bi bi-person"></i> Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="https://{{ config('domains.africoders.id') }}/logout?return={{ urlencode(request()->url()) }}"><i class="bi bi-box-arrow-right"></i> Logout</a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item ms-2">
                            <a class="btn btn-primary btn-sm" href="https://{{ config('domains.africoders.id') }}/auth?return={{ urlencode(request()->url()) }}">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container-lg py-4">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="fw-bold">KortexTools</h5>
                    <p class="text-muted">100+ free online tools for developers and productivity enthusiasts.</p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h6 class="fw-bold">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="https://{{ config('domains.tools.kortex') }}/" class="footer-link">Home</a></li>
                        <li><a href="https://{{ config('domains.tools.kortex') }}/explore" class="footer-link">All Tools</a></li>
                        <li><a href="https://{{ config('domains.tools.kortex') }}/categories" class="footer-link">Categories</a></li>
                        <li><a href="https://help.africoders.test/contact" class="footer-link">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold">Legal</h6>
                    <ul class="list-unstyled">
                        <li><a href="https://help.africoders.test/privacy" class="footer-link">Privacy Policy</a></li>
                        <li><a href="https://help.africoders.test/terms" class="footer-link">Terms of Service</a></li>
                        <li><a href="https://help.africoders.test/" class="footer-link">Help Center</a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="text-center text-muted">
                <p>&copy; {{ date('Y') }} KortexTools. All rights reserved. Part of the <a href="https://africoders.test" class="footer-link">Africoders</a> ecosystem.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
