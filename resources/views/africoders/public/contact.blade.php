<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact & Partnerships - Africoders</title>
    <meta name="description" content="Get in touch with Africoders for partnership inquiries, investment opportunities, or general questions.">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">

    <style>
        :root {
            --color-primary: #1a73e8;
            --color-secondary: #5f6368;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            line-height: 1.8;
        }

        .navbar {
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--color-primary) !important;
        }

        .page-header {
            background: linear-gradient(135deg, var(--color-primary) 0%, #1557b0 100%);
            color: white;
            padding: 3rem 0;
        }

        .contact-content {
            padding: 3rem 0;
        }

        .contact-form {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--color-secondary);
        }

        .form-control, .form-select {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 0.75rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 0.2rem rgba(26, 115, 232, 0.25);
        }

        .btn-submit {
            background-color: var(--color-primary);
            color: white;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #1557b0;
            color: white;
        }

        .contact-info {
            padding: 2rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .contact-info h5 {
            color: var(--color-primary);
            margin-bottom: 1rem;
        }

        .footer {
            background: #2c3e50;
            color: white;
            padding: 3rem 0;
            margin-top: 5rem;
        }

        .footer a {
            color: #ecf0f1;
            text-decoration: none;
        }

        .footer a:hover {
            color: var(--color-primary);
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand" href="{{ route('africoders.home') }}">
                <i class="bi bi-rocket-takeoff"></i> Africoders
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('africoders.home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('africoders.about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('africoders.ventures.index') }}">Ventures</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('africoders.press.index') }}">Press</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('africoders.ecosystem') }}">Ecosystem</a></li>
                    <li class="nav-item"><a class="nav-link" href="https://{{ config('domains.africoders.help') }}/contact">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1>Contact & Partnerships</h1>
            <p>Let's explore how we can work together</p>
        </div>
    </div>

    <!-- Contact Content -->
    <section class="contact-content">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="contact-form">
                        <h3 class="mb-4">Get in Touch</h3>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('africoders.contact.submit') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Full Name *</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                               value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Email *</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                               value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Phone</label>
                                        <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                               value="{{ old('phone') }}">
                                        @error('phone')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Company/Organization</label>
                                        <input type="text" name="company" class="form-control @error('company') is-invalid @enderror"
                                               value="{{ old('company') }}">
                                        @error('company')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Inquiry Type *</label>
                                <select name="inquiry_type" class="form-select @error('inquiry_type') is-invalid @enderror" required>
                                    <option value="">Select an inquiry type</option>
                                    <option value="partnership" {{ old('inquiry_type') === 'partnership' ? 'selected' : '' }}>Partnership Opportunity</option>
                                    <option value="investment" {{ old('inquiry_type') === 'investment' ? 'selected' : '' }}>Investment Inquiry</option>
                                    <option value="collaboration" {{ old('inquiry_type') === 'collaboration' ? 'selected' : '' }}>Collaboration</option>
                                    <option value="support" {{ old('inquiry_type') === 'support' ? 'selected' : '' }}>Other Support</option>
                                </select>
                                @error('inquiry_type')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Message *</label>
                                <textarea name="message" rows="6" class="form-control @error('message') is-invalid @enderror"
                                          placeholder="Tell us about your inquiry..." required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-submit w-100">
                                <i class="bi bi-send me-2"></i>Send Message
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="contact-info">
                        <h5><i class="bi bi-clock-history"></i> Response Time</h5>
                        <p>We typically respond to inquiries within 2-3 business days.</p>
                    </div>

                    <div class="contact-info mt-3">
                        <h5><i class="bi bi-gear"></i> How We Work</h5>
                        <p>Whether you're an investor, partner, or ecosystem stakeholder, we're committed to finding mutually beneficial opportunities.</p>
                    </div>

                    <div class="contact-info mt-3">
                        <h5><i class="bi bi-info-circle"></i> Privacy</h5>
                        <p>Your information is safe with us. We respect your privacy and will only use your data to respond to your inquiry.</p>
                        <a href="https://{{ config('domains.africoders.help') }}/privacy" class="small">Read our Privacy Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <h6>About</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('africoders.about') }}">About Us</a></li>
                        <li><a href="{{ route('africoders.vision') }}">Vision</a></li>
                        <li><a href="{{ route('africoders.mission') }}">Mission</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Explore</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('africoders.ventures.index') }}">Ventures</a></li>
                        <li><a href="{{ route('africoders.press.index') }}">Press</a></li>
                        <li><a href="{{ route('africoders.ecosystem') }}">Ecosystem</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Connect</h6>
                    <ul class="list-unstyled">
                        <li><a href="https://help.africoders.test/contact">Contact</a></li>
                        <li><a href="{{ route('africoders.partnerships') }}">Partnerships</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Legal</h6>
                    <ul class="list-unstyled">
                        <li><a href="https://{{ config('domains.africoders.help') }}/privacy">Privacy Policy</a></li>
                        <li><a href="https://{{ config('domains.africoders.help') }}/terms">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <hr class="bg-light">
            <div class="text-center">
                <p>&copy; {{ now()->year }} Africoders. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
