<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $release->title }} - Africoders</title>
    @if($release->meta_description)
        <meta name="description" content="{{ $release->meta_description }}">
    @endif
    @if($release->meta_keywords)
        <meta name="keywords" content="{{ $release->meta_keywords }}">
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

        .article-header {
            background: linear-gradient(135deg, var(--color-primary) 0%, #1557b0 100%);
            color: white;
            padding: 3rem 0;
        }

        .article-content {
            padding: 3rem 0;
        }

        .article-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 8px;
            margin: 2rem 0;
        }

        .article-meta {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            font-size: 0.9rem;
            border-left: 4px solid var(--color-primary);
        }

        .article-body {
            font-size: 1.1rem;
            color: #333;
            line-height: 1.9;
        }

        .article-body h2, .article-body h3 {
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: var(--color-secondary);
        }

        .article-body p {
            margin-bottom: 1.5rem;
        }

        .press-category {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: #f0f0f0;
            border-radius: 4px;
            font-size: 0.85rem;
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

        .related-releases {
            margin-top: 4rem;
            padding-top: 3rem;
            border-top: 1px solid #e9ecef;
        }

        .release-card {
            border: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .release-card:hover {
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

    <!-- Article Header -->
    <div class="article-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <small class="text-white-50">{{ $release->published_at->format('F d, Y') }}</small>
                    <h1 class="mt-2">{{ $release->title }}</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Article Content -->
    <section class="article-content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="px-4">
                        <span class="press-category {{ $release->press_category }}">
                            {{ ucfirst($release->press_category) }}
                        </span>

                        @if($release->featured_image)
                            <img src="{{ $release->featured_image }}" alt="{{ $release->title }}" class="article-image img-fluid rounded shadow my-4" style="max-height: 600px; object-fit: cover; width: 100%;">
                        @endif

                        <div class="article-meta alert alert-light border-start border-primary border-5">
                            @if($release->author)
                                <strong><i class="bi bi-person"></i> By {{ $release->author }}</strong><br>
                            @endif
                            <strong><i class="bi bi-calendar"></i> Published {{ $release->published_at->format('F d, Y') }}</strong>
                            @if($release->venture)
                                <br><strong><i class="bi bi-building"></i> Related Venture:</strong> <a href="{{ route('africoders.ventures.show', $release->venture) }}" class="text-decoration-none">{{ $release->venture->name }}</a>
                            @endif
                        </div>

                        <div class="article-body">
                            {!! $release->content !!}
                        </div>

                        <div class="mt-5 pt-4 border-top">
                            <a href="{{ route('africoders.press.index') }}" class="btn btn-outline-primary">
                                <i class="bi bi-arrow-left"></i> Back to Press
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Releases -->
    @if($relatedReleases->count() > 0)
    <section class="container related-releases">
        <h3 class="mb-4">Related Announcements</h3>
        <div class="row g-4">
            @foreach($relatedReleases as $related)
            <div class="col-lg-4">
                <div class="card release-card h-100">
                    <div class="card-body">
                        <small class="text-muted">{{ $related->published_at->format('M d, Y') }}</small>
                        <h5 class="card-title mt-2">
                            <a href="{{ route('africoders.press.show', $related) }}" class="text-decoration-none text-dark">
                                {{ $related->title }}
                            </a>
                        </h5>
                        <p class="card-text text-muted">{{ $related->excerpt }}</p>
                        <a href="{{ route('africoders.press.show', $related) }}" class="btn btn-sm btn-primary">
                            Read More
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
