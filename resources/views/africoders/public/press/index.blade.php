<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Press & Announcements - Africoders</title>
    <meta name="description" content="Latest news, announcements, and press releases from Africoders.">
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

        .page-header {
            background: linear-gradient(135deg, var(--color-primary) 0%, #1557b0 100%);
            color: white;
            padding: 3rem 0;
        }

        .press-section {
            padding: 3rem 0;
        }

        .press-item {
            border-left: 4px solid var(--color-primary);
            padding: 2rem;
            background: white;
            margin-bottom: 2rem;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .press-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .press-date {
            color: #6c757d;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .press-category {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: #f0f0f0;
            border-radius: 20px;
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .press-category.announcement {
            background: #d1ecf1;
            color: #0c5460;
        }

        .press-category.award {
            background: #fff3cd;
            color: #856404;
        }

        .press-category.partnership {
            background: #d4edda;
            color: #155724;
        }

        .press-category.funding {
            background: #f8d7da;
            color: #721c24;
        }

        .press-category.milestone {
            background: #d6d8db;
            color: #383d41;
        }

        .press-title {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: #333;
        }

        .press-excerpt {
            color: #666;
            margin-bottom: 1rem;
            line-height: 1.6;
        }

        .press-meta {
            font-size: 0.875rem;
            color: #999;
        }

        .press-meta a {
            color: var(--color-primary);
            text-decoration: none;
        }

        .press-meta a:hover {
            text-decoration: underline;
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
            <h1>Press & Announcements</h1>
            <p>Latest news from Africoders and our portfolio companies</p>
        </div>
    </div>

    <!-- Press Listing -->
    <section class="press-section">
        <div class="container">
            @if($releases->count() > 0)
                <div class="row g-4">
                    @foreach($releases as $release)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0 press-card">
                            @if($release->featured_image)
                                <img src="{{ $release->featured_image }}" alt="{{ $release->title }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-primary" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-newspaper text-white" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                            <div class="card-body d-flex flex-column">
                                <div class="mb-2">
                                    <span class="press-category {{ $release->press_category }}">
                                        {{ ucfirst($release->press_category) }}
                                    </span>
                                </div>
                                <div class="press-date small text-muted mb-2">{{ $release->published_at->format('F d, Y') }}</div>
                                <h5 class="card-title press-title">
                                    <a href="{{ route('africoders.press.show', $release) }}" class="text-decoration-none text-dark">
                                        {{ $release->title }}
                                    </a>
                                </h5>
                                <p class="card-text press-excerpt flex-grow-1">{{ $release->excerpt }}</p>
                                <div class="mt-auto">
                                    <a href="{{ route('africoders.press.show', $release) }}" class="btn btn-primary btn-sm">Read Full Story →</a>
                                    @if($release->venture)
                                        <div class="small text-muted mt-2">
                                            <i class="bi bi-building"></i> <a href="{{ route('africoders.ventures.show', $release->venture) }}" class="text-decoration-none">{{ $release->venture->name }}</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $releases->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="alert alert-info text-center">
                    <p>No press releases published yet.</p>
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
