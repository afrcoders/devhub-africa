<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Africoders ID</title>

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
        }

        * {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        body {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .container-auth {
            width: 100%;
            max-width: 450px;
        }

        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 2.5rem;
            background: white;
        }

        .brand {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand-logo {
            font-size: 2rem;
            font-weight: 700;
            color: var(--color-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .brand-logo i {
            font-size: 2.5rem;
        }

        .brand-subtitle {
            color: #6b7280;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #1f2937;
            font-size: 0.95rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 0.95rem;
            transition: all 0.3s;
            background: white;
            box-sizing: border-box;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }

        .form-group input:disabled {
            background-color: #f3f4f6;
            color: #9ca3af;
            cursor: not-allowed;
            border-color: #e5e7eb;
        }

        .password-input-wrapper {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .password-input-wrapper label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #1f2937;
            font-size: 0.95rem;
        }

        .password-input-wrapper input {
            width: 100%;
            padding: 0.75rem 1rem;
            padding-right: 2.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 0.95rem;
            transition: all 0.3s;
            background: white;
            box-sizing: border-box;
        }

        .password-input-wrapper input:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }

        .password-toggle-btn {
            position: absolute;
            right: 12px;
            top: 38px;
            background: none;
            border: none;
            cursor: pointer;
            color: #6b7280;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            padding: 0.25rem;
            transition: color 0.3s;
        }

        .password-toggle-btn:hover {
            color: var(--color-primary);
        }

        .btn {
            width: 100%;
            padding: 0.75rem 1rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 0.5rem;
        }

        .btn-primary {
            background-color: var(--color-primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: #1e40af;
        }

        .btn-primary:active {
            transform: scale(0.98);
        }

        .alert {
            border-radius: 0.5rem;
            border: none;
            margin-bottom: 1.5rem;
            padding: 1rem;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .alert-warning {
            background-color: #fef3c7;
            color: #92400e;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #166534;
        }

        .back-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .back-link a {
            color: var(--color-primary);
            text-decoration: none;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: #6b7280;
            font-size: 0.95rem;
            margin-bottom: 2rem;
        }

        .strength-meter {
            height: 4px;
            background-color: #e5e7eb;
            border-radius: 2px;
            margin-top: 0.5rem;
            overflow: hidden;
        }

        .strength-meter-fill {
            height: 100%;
            width: 0%;
            transition: width 0.3s ease, background-color 0.3s ease;
        }

        .password-strength-text {
            font-size: 0.75rem;
            margin-top: 0.25rem;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="container-auth">
        <div class="card">
            <!-- Brand -->
            <div class="brand">
                <div class="brand-logo">
                    <i class="bi bi-shield-lock"></i>
                </div>
                <div class="brand-subtitle">Africoders ID</div>
            </div>

            <!-- Title -->
            <h1 class="page-title">Reset Your Password</h1>
            <p class="page-subtitle">Enter your new password to regain access to your account</p>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Reset Password Form -->
            <form action="{{ route('id.password.reset.submit') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email Field (Disabled/Grayed Out) -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        value="{{ $email }}"
                        disabled
                        placeholder="your@email.com"
                    >
                    <small style="color: #6b7280; display: block; margin-top: 0.25rem;">
                        <i class="bi bi-info-circle"></i> Account email (cannot be changed)
                    </small>
                </div>

                <!-- Password Field -->
                <div class="password-input-wrapper">
                    <label for="password">New Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Create a strong password"
                        required
                        onchange="checkPasswordStrength()"
                        oninput="checkPasswordStrength()"
                    >
                    <button type="button" class="password-toggle-btn" onclick="togglePassword('password')">
                        <i class="bi bi-eye" id="password-icon"></i>
                    </button>
                    <div class="strength-meter">
                        <div class="strength-meter-fill" id="strengthMeter"></div>
                    </div>
                    <div class="password-strength-text">
                        Password must be at least 6 characters
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Reset Password & Sign In
                </button>
            </form>

            <!-- Back Link -->
            <div class="back-link">
                <a href="{{ route('id.password.forgot') }}">
                    <i class="bi bi-arrow-left"></i> Back to Forgot Password
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');

            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }

        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const meter = document.getElementById('strengthMeter');
            const strengthText = document.querySelector('.password-strength-text');

            let score = 0;

            if (password.length >= 8) score += 20;
            if (password.length >= 12) score += 20;
            if (/[a-z]/.test(password)) score += 15;
            if (/[A-Z]/.test(password)) score += 15;
            if (/[0-9]/.test(password)) score += 15;
            if (/[!@#$%^&*]/.test(password)) score += 15;

            meter.style.width = Math.min(score, 100) + '%';

            if (password.length < 6) {
                meter.style.backgroundColor = '#ef4444';
                strengthText.textContent = 'Too short (minimum 6 characters)';
                strengthText.style.color = '#991b1b';
            } else if (score < 30) {
                meter.style.backgroundColor = '#ef4444';
                strengthText.textContent = 'Weak password - Add numbers and symbols';
                strengthText.style.color = '#991b1b';
            } else if (score < 60) {
                meter.style.backgroundColor = '#f59e0b';
                strengthText.textContent = 'Fair password - Consider adding uppercase letters';
                strengthText.style.color = '#92400e';
            } else if (score < 90) {
                meter.style.backgroundColor = '#eab308';
                strengthText.textContent = 'Good password';
                strengthText.style.color = '#713f12';
            } else {
                meter.style.backgroundColor = '#22c55e';
                strengthText.textContent = 'Strong password';
                strengthText.style.color = '#166534';
            }
        }

        // Check password strength on page load
        document.addEventListener('DOMContentLoaded', function() {
            checkPasswordStrength();
        });
    </script>
</body>
</html>
