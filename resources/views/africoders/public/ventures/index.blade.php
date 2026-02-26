<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Ventures - Africoders</title>
    <meta name="description" content="Explore our portfolio of innovative ventures and companies incubated through Africoders.">

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

        .ventures-section {
            padding: 3rem 0;
        }

        .venture-card {
            border: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
        }

        .venture-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .venture-image {
            height: 200px;
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #adb5bd;
            font-size: 3rem;
        }

        .venture-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .badge-active {
            background: #28a745;
            color: white;
        }

        .badge-incubating {
            background: #ffc107;
            color: #333;
        }

        .badge-launched {
            background: var(--color-primary);
            color: white;
        }

        .badge-exited {
            background: #6c757d;
            color: white;
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
            <h1>Our Ventures</h1>
            <p>Innovative companies incubated and supported through Africoders</p>
        </div>
    </div>

    <!-- Ventures Listing -->
    <section class="ventures-section">
        <div class="container">
            @if($ventures->count() > 0)
                <div class="row g-4">
                    @foreach($ventures as $venture)
                    <div class="col-lg-4 col-md-6">
                        <div class="venture-card">
                            <div class="venture-image position-relative">
                                @if($venture->featured_image)
                                    <img src="{{ $venture->featured_image }}" alt="{{ $venture->name }}" class="w-100 h-100" style="object-fit: cover;">
                                @else
                                    <i class="bi bi-building"></i>
                                @endif
                                <span class="venture-badge badge-{{ str_replace('_', '-', $venture->status) }}">
                                    {{ ucfirst(str_replace('_', ' ', $venture->status)) }}
                                </span>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $venture->name }}</h5>
                                <p class="card-text text-muted">{{ $venture->description }}</p>
                                @if($venture->launch_year)
                                    <small class="text-muted d-block mb-3">
                                        <i class="bi bi-calendar-event"></i> {{ $venture->launch_year }}
                                    </small>
                                @endif
                                <a href="{{ route('africoders.ventures.show', $venture) }}" class="btn btn-sm btn-primary">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $ventures->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="alert alert-info text-center">
                    <p>No ventures published yet.</p>
                </div>
            @endif
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
                        <li><a href="https://{{ config('domains.africoders.help') }}/contact">Contact</a></li>
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
