<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Africoders ID</title>

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

        .navbar {
            background-color: white;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 600;
            color: var(--color-primary) !important;
            font-size: 1.25rem;
        }

        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .btn {
            border-radius: 0.5rem;
            font-weight: 500;
            padding: 0.625rem 1rem;
        }

        .btn-primary {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
        }

        .btn-primary:hover {
            background-color: #1e40af;
            border-color: #1e40af;
        }

        .form-control {
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
        }

        .form-control:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }

        .form-label {
            font-weight: 500;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .container-login {
            max-width: 400px;
            margin-top: 4rem;
            margin-bottom: 2rem;
        }

        .alert {
            border-radius: 0.5rem;
            border: none;
            margin-bottom: 1.5rem;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #166534;
        }

        .alert-info {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .footer {
            margin-top: 3rem;
            padding: 2rem 0;
            border-top: 1px solid #e5e7eb;
            background-color: white;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .footer a {
            color: var(--color-primary);
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 1.5rem;
            color: var(--color-primary);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('id.home') }}">
                <strong>Africoders</strong> ID
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container container-login">
        <a href="{{ route('id.auth.unified') }}" class="back-link">
            <i class="bi bi-arrow-left"></i> Back to Sign In
        </a>

        <div class="card">
            <div class="card-body" style="padding: 2.5rem;">

                <h2 style="margin-bottom: 0.5rem; font-size: 1.5rem; font-weight: 600;">Forgot Password?</h2>
                <p style="color: #6b7280; margin-bottom: 1.5rem;">Enter your email address and we'll send you a link to reset your password.</p>

                @if (isset($success))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i>
                        {{ $success }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i>
                        {{ $errors->first() ?? 'An error occurred.' }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('id.password.forgot.submit') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required autofocus value="{{ old('email') }}">
                        @error('email')
                            <div style="color: #991b1b; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- reCAPTCHA -->
                    <div class="mb-3">
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                        @error('g-recaptcha-response')
                            <div style="color: #991b1b; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100" style="margin-bottom: 1rem;">
                        <i class="bi bi-send"></i> Send Reset Link
                    </button>

                    <div style="text-align: center;">
                        <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0;">
                            Remember your password?
                            <a href="{{ route('id.auth.unified') }}" style="color: var(--color-primary); text-decoration: none;">Sign in</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; {{ date('Y') }} Africoders. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="https://{{ config('domains.africoders.help') }}/privacy" class="me-3">Privacy Policy</a>
                    <a href="https://{{ config('domains.africoders.help') }}/terms" class="me-3">Terms of Service</a>
                    <a href="https://{{ config('domains.africoders.help') }}/contact">Contact</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>
