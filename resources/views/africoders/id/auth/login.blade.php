<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Africoders ID</title>

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
            background-color: white;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 600;
            color: var(--color-primary) !important;
            font-size: 1.25rem;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        /* Buttons */
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

        .btn-outline-secondary {
            color: #6b7280;
            border-color: #d1d5db;
        }

        .btn-outline-secondary:hover {
            background-color: #f3f4f6;
            border-color: #d1d5db;
            color: #6b7280;
        }

        .form-control, .form-control:focus {
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

        .input-group .btn {
            border: 1px solid #d1d5db;
        }

        /* Container */
        .container-login {
            max-width: 400px;
            margin-top: 4rem;
            margin-bottom: 2rem;
        }

        /* Alert */
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

        /* User Info */
        .user-info {
            text-align: center;
            margin-bottom: 2rem;
        }

        .user-info p {
            margin: 0;
        }

        .user-info .full-name {
            font-weight: 600;
            font-size: 1.125rem;
            margin-bottom: 0.25rem;
        }

        .user-info .username {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .user-info a {
            color: var(--color-primary);
            font-size: 0.875rem;
            text-decoration: none;
        }

        .user-info a:hover {
            text-decoration: underline;
        }

        /* Footer */
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
        <div class="card">
            <div class="card-body" style="padding: 2.5rem;">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i>
                        {{ $errors->first() ?? 'An error occurred. Please try again.' }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('signup_success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> {{ session('signup_success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('password_reset_success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> {{ session('password_reset_success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Email/Username Form -->
                <form id="emailForm" method="POST" onsubmit="return false;">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email or Username</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email or username" required autofocus value="{{ old('email') }}" onkeypress="if(event.key==='Enter') { event.preventDefault(); checkUser(); }">
                        @error('email')
                            <div style="color: #991b1b; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="button" class="btn btn-primary w-100" style="margin-bottom: 1rem;" onclick="checkUser()">
                        <i class="bi bi-arrow-right"></i> Next
                    </button>

                    <div style="text-align: center;">
                        <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0;">Don't have an account?
                            <a href="{{ route('id.auth.unified') }}" style="color: var(--color-primary); text-decoration: none;">Sign up</a>
                        </p>
                    </div>
                </form>

                <!-- Password Form -->
                <form id="passwordForm" action="{{ route('id.auth.unified') }}" method="POST" style="display: none;">
                    @csrf
                    <input type="hidden" name="email" id="hiddenEmail">

                    <div id="userInfo" class="user-info">
                        <p id="userFullName" class="full-name"></p>
                        <p id="userUsername" class="username"></p>
                        <a href="#" onclick="switchToEmail(event)">Not you?</a>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required autofocus>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword" onclick="togglePasswordVisibility()">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div style="color: #991b1b; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0; font-weight: 400;">
                            <input type="checkbox" name="remember" style="width: auto; margin: 0;">
                            Remember me
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" style="margin-bottom: 1rem;">
                        <i class="bi bi-box-arrow-in-right"></i> Sign In
                    </button>

                    <div style="text-align: center;">
                        <a href="{{ route('id.password.forgot') }}" style="color: var(--color-primary); font-size: 0.875rem; text-decoration: none;">Forgot password?</a>
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

    <script>
        async function checkUser() {
            const email = document.getElementById('email').value.trim();
            if (!email) {
                alert('Please enter your email or username');
                return;
            }

            try {
                const response = await fetch('{{ route("id.auth.check-user") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ email })
                });

                const data = await response.json();

                if (data.userExists) {
                    // Show password form
                    document.getElementById('hiddenEmail').value = email;
                    document.getElementById('userFullName').textContent = data.fullName || email;
                    document.getElementById('userUsername').textContent = '@' + (data.username || '');
                    document.getElementById('emailForm').style.display = 'none';
                    document.getElementById('passwordForm').style.display = 'block';
                    setTimeout(() => document.getElementById('password').focus(), 100);
                } else {
                    // Redirect to signup
                    window.location.href = '{{ route("id.auth.unified") }}?email=' + encodeURIComponent(email);
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        function switchToEmail(e) {
            e.preventDefault();
            document.getElementById('emailForm').style.display = 'block';
            document.getElementById('passwordForm').style.display = 'none';
            document.getElementById('email').focus();
        }

        function togglePasswordVisibility() {
            const field = document.getElementById('password');
            const button = document.getElementById('togglePassword');

            if (field.type === 'password') {
                field.type = 'text';
                button.innerHTML = '<i class="bi bi-eye-slash"></i>';
            } else {
                field.type = 'password';
                button.innerHTML = '<i class="bi bi-eye"></i>';
            }
        }

        // Allow Enter key to submit email form
        document.getElementById('email').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                checkUser();
            }
        });
    </script>
</body>
</html>
