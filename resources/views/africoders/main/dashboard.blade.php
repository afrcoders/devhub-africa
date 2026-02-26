<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Africoders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    <style>
        :root {
            --color-primary: #1a73e8;
        }
        .navbar-brand {
            font-weight: 700;
            color: var(--color-primary) !important;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('africoders.home') }}">Africoders</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('africoders.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('africoders.account') }}">Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://{{ config('domains.africoders.id') }}/logout?return={{ urlencode(request()->fullUrl()) }}">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">Welcome, {{ $user->name }}!</h1>

                <div class="row g-4">
                    <!-- Profile Card -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-person-circle me-2"></i>Your Profile</h5>
                                <p class="card-text mb-2"><strong>Name:</strong> {{ $user->name }}</p>
                                <p class="card-text mb-2"><strong>Email:</strong> {{ $user->email }}</p>
                                <p class="card-text mb-3"><strong>Member since:</strong> {{ $user->created_at->format('F Y') }}</p>
                                <a href="{{ route('africoders.account') }}" class="btn btn-primary">Manage Account</a>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links Card -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-link-45deg me-2"></i>Quick Links</h5>
                                <div class="list-group list-group-flush">
                                    <a href="https://{{ config('domains.africoders.id') }}/dashboard" class="list-group-item list-group-item-action">
                                        <i class="bi bi-shield-check me-2"></i>ID Service Dashboard
                                    </a>
                                    <a href="https://{{ config('domains.tools.kortex') }}" class="list-group-item list-group-item-action">
                                        <i class="bi bi-tools me-2"></i>Kortex Tools
                                    </a>
                                    <a href="https://{{ config('domains.africoders.help') }}" class="list-group-item list-group-item-action">
                                        <i class="bi bi-question-circle me-2"></i>Help Center
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Noccea Ecosystem -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-3"><i class="bi bi-diagram-3 me-2"></i>Noccea Ecosystem</h5>
                                <p class="text-muted mb-4">Access all Noccea platforms with your Africoders account</p>
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <a href="https://{{ config('domains.noccea.main') }}?auth=true" class="text-decoration-none">
                                            <div class="card h-100 border-primary">
                                                <div class="card-body text-center">
                                                    <div class="mb-3">
                                                        <i class="bi bi-house-door" style="font-size: 2rem; color: #667eea;"></i>
                                                    </div>
                                                    <h6 class="card-title">Noccea Hub</h6>
                                                    <p class="card-text small text-muted">Main platform</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="https://{{ config('domains.noccea.learn') }}?auth=true" class="text-decoration-none">
                                            <div class="card h-100 border-info">
                                                <div class="card-body text-center">
                                                    <div class="mb-3">
                                                        <i class="bi bi-book" style="font-size: 2rem; color: #4299e1;"></i>
                                                    </div>
                                                    <h6 class="card-title">Learn</h6>
                                                    <p class="card-text small text-muted">Courses & skills</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="https://{{ config('domains.noccea.community') }}?auth=true" class="text-decoration-none">
                                            <div class="card h-100 border-success">
                                                <div class="card-body text-center">
                                                    <div class="mb-3">
                                                        <i class="bi bi-people" style="font-size: 2rem; color: #48bb78;"></i>
                                                    </div>
                                                    <h6 class="card-title">Community</h6>
                                                    <p class="card-text small text-muted">Connect & discuss</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="https://{{ config('domains.noccea.business') }}?auth=true" class="text-decoration-none">
                                            <div class="card h-100 border-warning">
                                                <div class="card-body text-center">
                                                    <div class="mb-3">
                                                        <i class="bi bi-briefcase" style="font-size: 2rem; color: #ed8936;"></i>
                                                    </div>
                                                    <h6 class="card-title">Business</h6>
                                                    <p class="card-text small text-muted">Directory & ventures</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info Card -->
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-info-circle me-2"></i>About Africoders</h5>
                                <p class="card-text">
                                    Africoders is a venture studio and corporate platform driving innovation across Africa
                                    through strategic partnerships and ecosystem development.
                                </p>
                                <a href="{{ route('africoders.about') }}" class="btn btn-outline-primary">Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
