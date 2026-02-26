<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Africoders</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --danger: #ef4444;
            --success: #10b981;
            --warning: #f59e0b;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-700: #374151;
            --gray-900: #111827;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: var(--gray-900);
            background-color: var(--gray-50);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        header {
            background-color: white;
            border-bottom: 1px solid var(--gray-200);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo i {
            font-size: 1.75rem;
        }

        .logo:hover {
            opacity: 0.8;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--gray-900);
            transition: color 0.2s;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-danger {
            background-color: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        .btn-sm {
            padding: 0.25rem 0.75rem;
            font-size: 0.875rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid var(--success);
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #7f1d1d;
            border: 1px solid var(--danger);
        }

        .alert-warning {
            background-color: #fef3c7;
            color: #78350f;
            border: 1px solid var(--warning);
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        textarea,
        select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid var(--gray-300);
            border-radius: 0.375rem;
            font-size: 1rem;
            font-family: inherit;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .error {
            color: var(--danger);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .card {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
        }

        .main-content {
            padding: 2rem 0;
        }

        footer {
            background-color: white;
            border-top: 1px solid var(--gray-200);
            padding: 2rem 0;
            margin-top: 4rem;
            text-align: center;
            color: var(--gray-700);
        }
    </style>


    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

    @stack('styles')
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <a href="{{ route('id.home') }}" class="logo">
                    <i class="bi bi-shield-check"></i> <strong>{{ config('domains.site_names.' . request()->getHost(), 'Africoders ID') }}</strong>
                </a>
                <ul class="nav-links">
                    @auth
                        <li><a href="{{ route('id.dashboard') }}">Dashboard</a></li>
                        @if (auth()->user()->isAdmin())
                            <li><a href="https://{{ config('domains.africoders.admin') }}/">{{ config('domains.site_names.' . config('domains.africoders.admin'), 'Africoders Admin') }}</a></li>
                        @endif
                        <li><a href="{{ route('id.profile.show') }}">Profile</a></li>
                        <li>
                            <form action="{{ route('id.logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Logout</button>
                            </form>
                        </li>
                    @else
                        <li><a href="{{ route('id.auth.unified') }}">Sign In</a></li>
                        <li><a href="{{ route('id.auth.unified') }}">Sign Up</a></li>
                    @endauth
                </ul>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Errors:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if (session('email_verified'))
                <div class="alert alert-success">{{ session('email_verified') }}</div>
            @endif

            @if (session('signup_success'))
                <div class="alert alert-success">{{ session('signup_success') }}</div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Africoders. All rights reserved.</p>
    </footer>

    @stack('scripts')
</body>
</html>
