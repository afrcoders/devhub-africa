<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In / Sign Up - Africoders ID</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        :root {
            --color-primary: #1E3A8A;
            --color-secondary: #0F172A;
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

        .form-group input.is-invalid {
            border-color: var(--color-danger);
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
            padding-right: 42px;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 0.95rem;
            transition: all 0.3s;
            box-sizing: border-box;
        }

        .password-input-wrapper input:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }

        .password-toggle-btn {
            position: absolute;
            right: 8px;
            top: 38px;
            background: none;
            border: none;
            color: var(--color-primary);
            cursor: pointer;
            padding: 0.5rem;
            font-size: 1.125rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .password-toggle-btn:hover {
            opacity: 0.7;
        }

        .error {
            color: var(--color-danger);
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: block;
        }

        .btn {
            padding: 0.875rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
        }

        .btn-primary {
            background-color: var(--color-primary);
            color: white;
        }

        .btn-primary:hover:not(:disabled) {
            background-color: #1e40af;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(30, 58, 138, 0.2);
        }

        .btn-secondary {
            background-color: #f3f4f6;
            color: #374151;
            border: 2px solid #e5e7eb;
        }

        .btn-secondary:hover:not(:disabled) {
            background-color: #e5e7eb;
        }

        .btn-social {
            background-color: white;
            color: #1f2937;
            border: 2px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
            text-decoration: none;
        }

        .btn-social:hover {
            background-color: #f9fafb;
            border-color: var(--color-primary);
            color: var(--color-primary);
            text-decoration: none;
        }

        .btn-social i {
            font-size: 1.25rem;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 2rem 0;
            color: #9ca3af;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background-color: #e5e7eb;
        }

        .divider-text {
            padding: 0 1rem;
            font-size: 0.875rem;
        }

        .alert {
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            padding: 1rem;
            font-size: 0.95rem;
        }

        .alert-danger {
            background-color: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .alert-danger small {
            display: block;
            margin-top: 0.25rem;
            opacity: 0.9;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #166534;
        }

        .alert .btn-close {
            filter: invert(1);
        }

        .form-check {
            margin: 1.5rem 0;
        }

        .form-check-input {
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid #d1d5db;
            border-radius: 0.375rem;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
        }

        .form-check-label {
            color: #6b7280;
            font-size: 0.875rem;
            margin-left: 0.5rem;
            cursor: pointer;
        }

        .form-check-label a {
            color: var(--color-primary);
            text-decoration: none;
        }

        .form-check-label a:hover {
            text-decoration: underline;
        }

        .g-recaptcha {
            margin: 1.5rem 0;
            display: flex;
            justify-content: center;
        }

        .screen {
            display: none;
        }

        .screen.active {
            display: block;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
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

        .forgot-password {
            text-align: center;
            margin-top: 1rem;
        }

        .forgot-password a {
            color: var(--color-primary);
            text-decoration: none;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        @media (max-width: 576px) {
            .card {
                padding: 1.5rem;
            }

            .brand-logo {
                font-size: 1.5rem;
            }

            .brand-logo i {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-auth">
        <div class="card">
            <!-- Brand -->
            <div class="brand">
                <div class="brand-logo">
                    <i class="bi bi-shield-check"></i> Africoders ID
                </div>
                <p class="brand-subtitle">Secure Identity Platform</p>
            </div>

            <!-- Messages -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Error!</strong>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Screen 1: Email Entry -->
            <div id="emailScreen" class="screen active">
                <form id="emailForm" onsubmit="checkEmail(event)">
                    <div class="form-group">
                        <label for="emailInput">Email or Username</label>
                        <input
                            type="text"
                            id="emailInput"
                            name="email"
                            placeholder="Enter your email or username"
                            required
                            value="{{ old('email') }}"
                        >
                    </div>
                    <button type="submit" class="btn btn-primary">Continue</button>
                </form>

                <!-- Sign Up Link -->
                <div style="text-align: center; margin-top: 1.5rem;">
                    <p style="color: #6b7280; font-size: 0.875rem; margin: 0;">
                        Don't have an account?
                        <a href="#" onclick="goToSignup(event)" style="color: var(--color-primary); text-decoration: none; font-weight: 600;">
                            Sign up here
                        </a>
                    </p>
                </div>

                <!-- Social Login -->
                <div style="margin-top: 2rem;">
                    <div class="divider">
                        <span class="divider-text">OR</span>
                    </div>

                    <div style="margin-top: 1.5rem;">
                        <a href="{{ route('id.socialite.redirect', 'google') }}" class="btn btn-social" title="Continue with Google">
                            <i class="bi bi-google"></i> Google
                        </a>
                        <a href="{{ route('id.socialite.redirect', 'github') }}" class="btn btn-social" title="Continue with GitHub">
                            <i class="bi bi-github"></i> GitHub
                        </a>
                        <a href="{{ route('id.socialite.redirect', 'facebook') }}" class="btn btn-social" title="Continue with Facebook">
                            <i class="bi bi-facebook"></i> Facebook
                        </a>
                        <a href="{{ route('id.socialite.redirect', 'twitter') }}" class="btn btn-social" title="Continue with Twitter">
                            <i class="bi bi-twitter-x"></i> Twitter
                        </a>
                        <a href="{{ route('id.socialite.redirect', 'linkedin') }}" class="btn btn-social" title="Continue with LinkedIn">
                            <i class="bi bi-linkedin"></i> LinkedIn
                        </a>
                    </div>
                </div>
            </div>

            <!-- Screen 2: Login (Password Entry) -->
            <div id="loginScreen" class="screen">
                <form id="loginForm" action="{{ route('id.auth.unified') }}" method="POST">
                    @csrf
                    @if(request('return'))
                        <input type="hidden" name="return" value="{{ request('return') }}">
                    @endif
                    <div class="form-group">
                        <label for="emailDisplay">Email or Username</label>
                        <input
                            type="text"
                            id="emailDisplay"
                            readonly
                            style="background-color: #f3f4f6; cursor: not-allowed;"
                        >
                    </div>

                    <div class="password-input-wrapper">
                        <label for="passwordLogin">Password</label>
                        <input
                            type="password"
                            id="passwordLogin"
                            name="password"
                            placeholder="Enter your password"
                            required
                        >
                        <button type="button" class="password-toggle-btn" onclick="togglePassword('passwordLogin')">
                            <i class="bi bi-eye" id="passwordLogin-icon"></i>
                        </button>
                    </div>

                    <button type="submit" class="btn btn-primary" onclick="setAuthType('login')">Sign In</button>

                    <div class="forgot-password">
                        <a href="{{ route('id.password.forgot') }}">
                            <i class="bi bi-question-circle"></i> Forgot your password?
                        </a>
                    </div>

                    <input type="hidden" name="email" id="emailHidden">
                    <input type="hidden" name="auth_type" id="authType" value="login">
                </form>

                <div class="back-link">
                    <a href="#" onclick="goBackToEmail(event)">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
            </div>

            <!-- Screen 3: Registration -->
            <div id="registerScreen" class="screen">
                <form id="registerForm" action="{{ route('id.auth.unified') }}" method="POST" onsubmit="return validateRegisterForm(event)">
                    @csrf
                    @if(request('return'))
                        <input type="hidden" name="return" value="{{ request('return') }}">
                    @endif
                    <div class="form-group" id="emailRegisterGroup">
                        <label for="emailRegister">Email</label>
                        <input
                            type="email"
                            id="emailRegister"
                            name="email"
                            readonly
                            style="background-color: #f3f4f6; cursor: not-allowed;"
                        >
                        <small id="emailRegisterError" style="color: #ef4444; display: none; margin-top: 0.25rem;"></small>
                    </div>

                    <div class="form-group" id="emailInputGroup" style="display: none;">
                        <label for="emailInput2">Email</label>
                        <input
                            type="email"
                            id="emailInput2"
                            name="email"
                            placeholder="Enter your email"
                            value="{{ old('email') }}"
                            oninput="validateEmail()"
                        >
                        <small id="emailInput2Error" style="color: #ef4444; display: none; margin-top: 0.25rem;"></small>
                        <small id="emailInput2Success" style="color: #22c55e; display: none; margin-top: 0.25rem;"></small>
                    </div>

                    <div class="form-group">
                        <label for="fullName">Full Name</label>
                        <input
                            type="text"
                            id="fullName"
                            name="full_name"
                            placeholder="Enter your full name"
                            required
                            value="{{ old('full_name') }}"
                            oninput="validateFullName()"
                        >
                        <small id="fullNameError" style="color: #ef4444; display: none; margin-top: 0.25rem;"></small>
                        <small id="fullNameSuccess" style="color: #22c55e; display: none; margin-top: 0.25rem;"></small>
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            placeholder="Choose a username (3-20 characters)"
                            required
                            value="{{ old('username') }}"
                            oninput="validateUsername()"
                        >
                        <small style="color: #6b7280; display: block; margin-top: 0.25rem;">Letters, numbers, and underscores only</small>
                        <small id="usernameError" style="color: #ef4444; display: none; margin-top: 0.25rem;"></small>
                        <small id="usernameSuccess" style="color: #22c55e; display: none; margin-top: 0.25rem;"></small>
                    </div>

                    <div class="password-input-wrapper">
                        <label for="passwordRegister">Password</label>
                        <input
                            type="password"
                            id="passwordRegister"
                            name="password"
                            placeholder="Create a strong password"
                            required
                            oninput="validatePassword()"
                        >
                        <button type="button" class="password-toggle-btn" onclick="togglePassword('passwordRegister')">
                            <i class="bi bi-eye" id="passwordRegister-icon"></i>
                        </button>
                        <small id="passwordError" style="color: #ef4444; display: none; margin-top: 0.25rem;"></small>
                        <small id="passwordSuccess" style="color: #22c55e; display: none; margin-top: 0.25rem;"></small>
                    </div>

                    <div class="form-check">
                        <input
                            type="checkbox"
                            class="form-check-input"
                            id="agreeTerms"
                            name="agree_to_terms"
                            value="1"
                            required
                            {{ old('agree_to_terms') ? 'checked' : '' }}
                            onchange="validateTerms()"
                        >
                        <label class="form-check-label" for="agreeTerms">
                            I agree to the <a href="https://{{ config('domains.africoders.help') }}/terms" target="_blank">Terms of Service</a>
                        </label>
                        <small id="termsError" style="color: #ef4444; display: block; margin-top: 0.25rem;"></small>
                    </div>

                    <!-- reCAPTCHA -->
                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>

                    <button type="submit" class="btn btn-primary">Create Account</button>

                    <input type="hidden" name="email" id="emailRegisterHidden">
                    <input type="hidden" name="auth_type" id="authType2" value="register">
                </form>

                <div class="back-link">
                    <a href="#" onclick="goBackToEmail(event)">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const emailInput = document.getElementById('emailInput');
        const emailScreen = document.getElementById('emailScreen');
        const loginScreen = document.getElementById('loginScreen');
        const registerScreen = document.getElementById('registerScreen');
        const emailDisplay = document.getElementById('emailDisplay');
        const emailRegisterDisplay = document.getElementById('emailRegister');
        const emailHidden = document.getElementById('emailHidden');
        const emailRegisterHidden = document.getElementById('emailRegisterHidden');

        // Check if we're on the login screen with a password error
        window.addEventListener('DOMContentLoaded', function() {
            @if ($errors->has('password'))
                const emailFromHidden = document.getElementById('emailHidden').value;
                if (emailFromHidden) {
                    emailDisplay.value = emailFromHidden;
                    showScreen('loginScreen');
                    document.getElementById('passwordLogin').focus();
                }
            @endif
        });

        async function checkEmail(event) {
            event.preventDefault();

            const email = emailInput.value.trim();
            if (!email) {
                alert('Please enter an email or username');
                return;
            }

            try {
                const response = await fetch('{{ route("id.auth.check-user") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]') ?
                            document.querySelector('input[name="_token"]').value :
                            '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ email })
                });

                const data = await response.json();

                if (data.exists) {
                    // User exists - show login screen
                    emailHidden.value = email;
                    emailDisplay.value = email;
                    showScreen('loginScreen');
                    document.getElementById('passwordLogin').focus();
                } else {
                    // User doesn't exist - show registration screen
                    emailRegisterHidden.value = email;
                    emailRegisterDisplay.value = email;

                    // Show readonly email field when coming from email check
                    document.getElementById('emailRegisterGroup').style.display = 'block';
                    document.getElementById('emailInputGroup').style.display = 'none';

                    showScreen('registerScreen');
                    document.getElementById('fullName').focus();
                }
            } catch (error) {
                console.error('Error checking user:', error);
                alert('Something went wrong. Please try again.');
            }
        }

        function showScreen(screenId) {
            // Hide all screens
            emailScreen.classList.remove('active');
            loginScreen.classList.remove('active');
            registerScreen.classList.remove('active');

            // Show selected screen
            document.getElementById(screenId).classList.add('active');
        }

        function goBackToEmail(event) {
            event.preventDefault();
            emailInput.value = '';

            // Reset email field visibility when going back
            document.getElementById('emailRegisterGroup').style.display = 'block';
            document.getElementById('emailInputGroup').style.display = 'none';

            showScreen('emailScreen');
            emailInput.focus();
        }

        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const iconId = fieldId + '-icon';
            const icon = document.getElementById(iconId);

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

        function setAuthType(type) {
            document.getElementById('authType').value = type;
            if (document.getElementById('authType2')) {
                document.getElementById('authType2').value = type;
            }
        }

        function goToSignup(event) {
            event.preventDefault();
            emailInput.value = '';
            emailRegisterHidden.value = '';
            emailRegisterDisplay.value = '';

            // Show editable email field when coming from direct signup
            document.getElementById('emailRegisterGroup').style.display = 'none';
            document.getElementById('emailInputGroup').style.display = 'block';

            // Clear the hidden email field
            document.getElementById('emailInput2').value = '';

            showScreen('registerScreen');
            document.getElementById('emailInput2').focus();
        }

        function prepareRegisterForm() {
            setAuthType('register');

            // Validate username before submission
            if (!validateUsername()) {
                return false;
            }

            // If using the editable email field (direct signup), copy it to the hidden field
            const emailRegisterGroup = document.getElementById('emailRegisterGroup');
            if (emailRegisterGroup.style.display === 'none') {
                // Direct signup mode - use emailInput2
                const email2 = document.getElementById('emailInput2').value;
                document.getElementById('emailRegisterHidden').value = email2;
            } else {
                // Email check mode - use emailRegister (readonly)
                const email1 = document.getElementById('emailRegister').value;
                document.getElementById('emailRegisterHidden').value = email1;
            }
        }

        function validateUsername() {
            const username = document.getElementById('username').value.trim();
            const errorMsg = document.getElementById('usernameError');
            const successMsg = document.getElementById('usernameSuccess');
            const usernameField = document.getElementById('username');

            // Clear previous messages
            errorMsg.style.display = 'none';
            successMsg.style.display = 'none';
            usernameField.style.borderColor = '#e5e7eb';

            // Check if empty
            if (!username) {
                errorMsg.textContent = 'Username is required';
                errorMsg.style.display = 'block';
                usernameField.style.borderColor = '#ef4444';
                return false;
            }

            // Check length
            if (username.length < 3) {
                errorMsg.textContent = 'Username must be at least 3 characters (currently ' + username.length + ')';
                errorMsg.style.display = 'block';
                usernameField.style.borderColor = '#ef4444';
                return false;
            }

            if (username.length > 20) {
                errorMsg.textContent = 'Username must not exceed 20 characters (currently ' + username.length + ')';
                errorMsg.style.display = 'block';
                usernameField.style.borderColor = '#ef4444';
                return false;
            }

            // Check format (only letters, numbers, underscores)
            const validFormat = /^[a-zA-Z0-9_]+$/.test(username);
            if (!validFormat) {
                errorMsg.textContent = 'Username can only contain letters, numbers, and underscores';
                errorMsg.style.display = 'block';
                usernameField.style.borderColor = '#ef4444';
                return false;
            }

            // All validations passed
            successMsg.textContent = '✓ Username looks good!';
            successMsg.style.display = 'block';
            usernameField.style.borderColor = '#22c55e';
            return true;
        }

        function validateEmail() {
            const emailRegisterGroup = document.getElementById('emailRegisterGroup');

            // If readonly email is shown, skip validation (it comes from email check)
            if (emailRegisterGroup.style.display !== 'none') {
                return true;
            }

            const email = document.getElementById('emailInput2').value.trim();
            const errorMsg = document.getElementById('emailInput2Error');
            const successMsg = document.getElementById('emailInput2Success');
            const emailField = document.getElementById('emailInput2');

            errorMsg.style.display = 'none';
            successMsg.style.display = 'none';
            emailField.style.borderColor = '#e5e7eb';

            if (!email) {
                errorMsg.textContent = 'Email is required';
                errorMsg.style.display = 'block';
                emailField.style.borderColor = '#ef4444';
                return false;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                errorMsg.textContent = 'Please enter a valid email address';
                errorMsg.style.display = 'block';
                emailField.style.borderColor = '#ef4444';
                return false;
            }

            successMsg.textContent = '✓ Email looks good!';
            successMsg.style.display = 'block';
            emailField.style.borderColor = '#22c55e';
            return true;
        }

        function validateFullName() {
            const fullName = document.getElementById('fullName').value.trim();
            const errorMsg = document.getElementById('fullNameError');
            const successMsg = document.getElementById('fullNameSuccess');
            const fullNameField = document.getElementById('fullName');

            errorMsg.style.display = 'none';
            successMsg.style.display = 'none';
            fullNameField.style.borderColor = '#e5e7eb';

            if (!fullName) {
                errorMsg.textContent = 'Full name is required';
                errorMsg.style.display = 'block';
                fullNameField.style.borderColor = '#ef4444';
                return false;
            }

            if (fullName.length < 2) {
                errorMsg.textContent = 'Full name must be at least 2 characters';
                errorMsg.style.display = 'block';
                fullNameField.style.borderColor = '#ef4444';
                return false;
            }

            if (fullName.length > 100) {
                errorMsg.textContent = 'Full name must not exceed 100 characters';
                errorMsg.style.display = 'block';
                fullNameField.style.borderColor = '#ef4444';
                return false;
            }

            successMsg.textContent = '✓ Full name looks good!';
            successMsg.style.display = 'block';
            fullNameField.style.borderColor = '#22c55e';
            return true;
        }

        function validatePassword() {
            const password = document.getElementById('passwordRegister').value;
            const errorMsg = document.getElementById('passwordError');
            const successMsg = document.getElementById('passwordSuccess');
            const passwordField = document.getElementById('passwordRegister');

            errorMsg.style.display = 'none';
            successMsg.style.display = 'none';
            passwordField.style.borderColor = '#e5e7eb';

            if (!password) {
                errorMsg.textContent = 'Password is required';
                errorMsg.style.display = 'block';
                passwordField.style.borderColor = '#ef4444';
                return false;
            }

            if (password.length < 6) {
                errorMsg.textContent = 'Password must be at least 6 characters (currently ' + password.length + ')';
                errorMsg.style.display = 'block';
                passwordField.style.borderColor = '#ef4444';
                return false;
            }

            if (password.length > 50) {
                errorMsg.textContent = 'Password must not exceed 50 characters';
                errorMsg.style.display = 'block';
                passwordField.style.borderColor = '#ef4444';
                return false;
            }

            successMsg.textContent = '✓ Password looks good!';
            successMsg.style.display = 'block';
            passwordField.style.borderColor = '#22c55e';
            return true;
        }

        function validateTerms() {
            const termsCheckbox = document.getElementById('agreeTerms');
            const termsError = document.getElementById('termsError');

            if (!termsCheckbox.checked) {
                termsError.textContent = 'You must agree to the Terms of Service';
                termsError.style.color = '#ef4444';
                termsError.style.display = 'block';
                return false;
            } else {
                termsError.style.display = 'none';
                return true;
            }
        }

        function validateRegisterForm(event) {
            event.preventDefault();

            // Validate all fields
            const isEmailValid = validateEmail() || document.getElementById('emailRegisterGroup').style.display !== 'none';
            const isFullNameValid = validateFullName();
            const isUsernameValid = validateUsername();
            const isPasswordValid = validatePassword();
            const isTermsValid = validateTerms();

            // If any validation fails, show error and don't submit
            if (!isEmailValid || !isFullNameValid || !isUsernameValid || !isPasswordValid || !isTermsValid) {
                return false;
            }

            // All validations passed, prepare form and submit
            const emailRegisterGroup = document.getElementById('emailRegisterGroup');
            if (emailRegisterGroup.style.display === 'none') {
                // Direct signup mode - use emailInput2
                const email2 = document.getElementById('emailInput2').value;
                document.getElementById('emailRegisterHidden').value = email2;
            } else {
                // Email check mode - use emailRegister (readonly)
                const email1 = document.getElementById('emailRegister').value;
                document.getElementById('emailRegisterHidden').value = email1;
            }

            // Set auth type
            document.getElementById('authType2').value = 'register';

            // Submit the form
            document.getElementById('registerForm').submit();
            return false;
        }
    </script>
</body>
</html>
