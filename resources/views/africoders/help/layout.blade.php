<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Africoders Help Center')</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --color-primary: #1E3A8A;
            --color-secondary: #0F172A;
            --color-success: #22C55E;
            --color-warning: #F59E0B;
            --color-danger: #EF4444;
            --color-bg: #F8FAFC;
        }

        * {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        body {
            background-color: var(--color-bg);
            color: #1f2937;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, #1f3a8a 0%, #1e40af 100%);
            border-bottom: none;
            box-shadow: 0 2px 8px rgba(30, 58, 138, 0.2);
        }

        .navbar-brand {
            font-weight: 700;
            color: white !important;
            font-size: 1.3rem;
            letter-spacing: -0.5px;
        }

        .navbar-light .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 500;
            transition: color 0.2s;
        }

        .navbar-light .navbar-nav .nav-link:hover {
            color: white !important;
        }

        .navbar-light .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255,255,255,0.85%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .navbar-light .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.3);
        }

        /* Main content */
        .main-content {
            min-height: calc(100vh - 200px);
            padding: 3rem 0;
        }

        /* Section Headers */
        .section-header {
            margin-bottom: 3rem;
        }

        .section-header h1 {
            font-weight: 700;
            color: var(--color-primary);
            margin-bottom: 0.5rem;
        }

        .section-header p {
            color: #6b7280;
            font-size: 1.1rem;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Search Box */
        .search-box {
            max-width: 600px;
            margin: 0 auto 3rem auto;
        }

        .search-box .input-group {
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .search-box .form-control {
            font-size: 1.1rem;
            padding: 1rem;
            border: none;
        }

        .search-box .input-group-text {
            padding: 1rem;
            font-size: 1.2rem;
            color: #6b7280;
        }

        /* Footer */
        footer {
            background-color: var(--color-secondary);
            color: white;
            padding: 3rem 0 2rem 0;
            margin-top: 4rem;
        }

        footer h5 {
            color: white;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        footer a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.2s;
        }

        footer a:hover {
            color: white;
        }

        footer .list-unstyled li {
            margin-bottom: 0.5rem;
        }

        footer hr {
            border-color: rgba(255, 255, 255, 0.2);
            margin: 2rem 0 1rem 0;
        }

        footer .text-center {
            color: rgba(255, 255, 255, 0.7);
        }

        @stack('styles')
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('help.home') }}">
                <i class="bi bi-question-circle-fill me-2"></i>
                {{ config('domains.site_names.' . request()->getHost(), 'Africoders Help') }}
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('help.home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('help.support') }}">Support</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('help.faq') }}">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('help.articles') }}">Articles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('help.contact') }}">Contact</a>
                    </li>

                    @auth
                        <!-- User Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i>
                                {{ auth()->user()->username ?? auth()->user()->email }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="https://{{ config('domains.africoders.main') }}/dashboard">
                                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="https://{{ config('domains.africoders.id') }}/dashboard">
                                        <i class="bi bi-person me-2"></i>Account
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('help.logout') }}">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <!-- Login Button -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('help.login', ['return' => request()->fullUrl()]) }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Login
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <h5>Help & Support</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('help.support') }}">Support Center</a></li>
                        <li><a href="{{ route('help.faq') }}">FAQ</a></li>
                        <li><a href="{{ route('help.articles') }}">Help Articles</a></li>
                        <li><a href="{{ route('help.contact') }}">Contact Us</a></li>
                    </ul>
                </div>

                <div class="col-md-3 mb-4">
                    <h5>Legal</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('help.legal', 'terms') }}">Terms of Service</a></li>
                        <li><a href="{{ route('help.legal', 'privacy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('help.legal', 'cookies') }}">Cookie Policy</a></li>
                        <li><a href="{{ route('help.legal', 'disclaimer') }}">Disclaimer</a></li>
                    </ul>
                </div>

                <div class="col-md-3 mb-4">
                    <h5>Community</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('help.legal', 'community-guidelines') }}">Community Guidelines</a></li>
                        <li><a href="{{ route('help.legal', 'code-of-conduct') }}">Code of Conduct</a></li>
                        <li><a href="{{ route('help.legal', 'acceptable-use') }}">Acceptable Use</a></li>
                    </ul>
                </div>

                <div class="col-md-3 mb-4">
                    <h5>Africoders</h5>
                    <ul class="list-unstyled">
                        <li><a href="https://{{ config('domains.africoders.main') }}">Main Site</a></li>
                        <li><a href="https://{{ config('domains.africoders.id') }}">Identity Service</a></li>
                        <li><a href="https://{{ config('domains.portal') }}">Developer Portal</a></li>
                    </ul>
                </div>
            </div>

            <hr>

            <div class="text-center">
                <p>&copy; {{ date('Y') }} Africoders. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
