<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $venture->name }} - Africoders</title>
    @if($venture->meta_description)
        <meta name="description" content="{{ $venture->meta_description }}">
    @endif
    @if($venture->meta_keywords)
        <meta name="keywords" content="{{ $venture->meta_keywords }}">
    @endif

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/android-chrome-512x512.png">

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

        .venture-hero {
            background: linear-gradient(135deg, var(--color-primary) 0%, #1557b0 100%);
            color: white;
            padding: 3rem 0;
        }

        .venture-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 8px;
            margin: 2rem 0;
        }

        .venture-content {
            padding: 3rem 0;
        }

        .venture-meta {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }

        .meta-item {
            margin-bottom: 1rem;
        }

        .meta-label {
            font-weight: 600;
            color: var(--color-secondary);
            display: block;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .meta-value {
            color: #333;
            margin-top: 0.25rem;
        }

        .badge {
            padding: 0.5rem 1rem;
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .badge-active {
            background: #d4edda;
            color: #155724;
        }

        .badge-incubating {
            background: #fff3cd;
            color: #856404;
        }

        .badge-launched {
            background: #d1ecf1;
            color: #0c5460;
        }

        .badge-exited {
            background: #e2e3e5;
            color: #383d41;
        }

        .related-ventures {
            margin-top: 4rem;
            padding-top: 3rem;
            border-top: 1px solid #e9ecef;
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

    <!-- Venture Hero -->
    <div class="venture-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="mb-3">{{ $venture->name }}</h1>
                    <p class="lead mb-0">{{ $venture->description }}</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <span class="badge badge-{{ str_replace('_', '-', $venture->status) }}">
                        {{ ucfirst(str_replace('_', ' ', $venture->status)) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Venture Content -->
    <section class="venture-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    @if($venture->featured_image)
                        <img src="{{ $venture->featured_image }}" alt="{{ $venture->name }}" class="venture-image">
                    @endif

                    @if($venture->content)
                        <div class="venture-description mb-4">
                            {!! $venture->content !!}
                        </div>
                    @endif

                    @if($venture->mission || $venture->vision)
                    <div class="row g-4 mt-4">
                        @if($venture->mission)
                        <div class="col-md-6">
                            <h4 class="mb-3">Mission</h4>
                            <p>{{ $venture->mission }}</p>
                        </div>
                        @endif

                        @if($venture->vision)
                        <div class="col-md-6">
                            <h4 class="mb-3">Vision</h4>
                            <p>{{ $venture->vision }}</p>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Related Press Releases -->
                    @if($venture->pressReleases->count() > 0)
                    <div class="mt-5 pt-4 border-top">
                        <h3 class="mb-4">Press Releases</h3>
                        @foreach($venture->pressReleases->take(3) as $release)
                        <div class="mb-3">
                            <small class="text-muted">{{ $release->published_at->format('M d, Y') }}</small>
                            <h5 class="mb-2"><a href="{{ route('africoders.press.show', $release) }}" class="text-decoration-none">{{ $release->title }}</a></h5>
                            <p class="text-muted">{{ $release->excerpt }}</p>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <div class="col-lg-4">
                    <div class="venture-meta">
                        @if($venture->launch_year)
                        <div class="meta-item">
                            <span class="meta-label">Launch Year</span>
                            <div class="meta-value">{{ $venture->launch_year }}</div>
                        </div>
                        @endif

                        @if($venture->website_url)
                        <div class="meta-item">
                            <span class="meta-label">Website</span>
                            <div class="meta-value">
                                <a href="{{ $venture->website_url }}" target="_blank" rel="noopener noreferrer">
                                    Visit Website <i class="bi bi-box-arrow-up-right"></i>
                                </a>
                            </div>
                        </div>
                        @endif

                        <div class="meta-item">
                            <span class="meta-label">Status</span>
                            <div class="meta-value">
                                <span class="badge badge-{{ str_replace('_', '-', $venture->status) }}">
                                    {{ ucfirst(str_replace('_', ' ', $venture->status)) }}
                                </span>
                            </div>
                        </div>

                        @if($venture->tech_stack)
                        <div class="meta-item">
                            <span class="meta-label">Tech Stack</span>
                            <div class="meta-value">
                                @foreach($venture->tech_stack as $tech)
                                    <span class="badge bg-light text-dark me-1 mb-1">{{ $tech }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>

                    <a href="{{ route('africoders.ventures.index') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-arrow-left"></i> Back to Ventures
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Ventures -->
    @if($relatedVentures->count() > 0)
    <section class="container related-ventures">
        <h3 class="mb-4">Other Ventures</h3>
        <div class="row g-4">
            @foreach($relatedVentures as $related)
            <div class="col-lg-4">
                <div class="venture-card">
                    <div style="height: 150px; background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%); display: flex; align-items: center; justify-content: center;">
                        @if($related->featured_image)
                            <img src="{{ $related->featured_image }}" alt="{{ $related->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="bi bi-building" style="font-size: 2rem; color: #adb5bd;"></i>
                        @endif
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <h5 class="card-title mb-3">{{ $related->name }}</h5>
                        <p class="card-text text-muted flex-grow-1 mb-3">{{ $related->description }}</p>
                        <a href="{{ route('africoders.ventures.show', $related) }}" class="btn btn-sm btn-primary">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

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
