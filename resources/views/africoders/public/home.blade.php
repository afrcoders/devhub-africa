<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Africoders - Empowering Africa's Tech Ecosystem</title>
    <meta name="description" content="Integrated platforms for learning, business discovery, and professional collaboration across Africa. Join our growing community of tech professionals.">
    <meta property="og:title" content="Africoders - Empowering Africa's Tech Ecosystem">
    <meta property="og:description" content="Integrated platforms for learning, business discovery, and professional collaboration across Africa. Join our growing community of tech professionals.">

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
            --color-light: #f8f9fa;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            line-height: 1.6;
        }

        .navbar {
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--color-primary) !important;
        }

        .hero {
            background: linear-gradient(135deg, var(--color-primary) 0%, #1557b0 100%);
            color: white;
            padding: 4rem 0 5rem 0;
            text-align: center;
        }

        @media (max-width: 768px) {
            .hero {
                padding: 3rem 0 4rem 0;
            }
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        @media (max-width: 768px) {
            .hero p {
                font-size: 1rem;
            }
        }

        .btn-primary {
            background-color: white;
            color: var(--color-primary);
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #f8f9fa;
            color: var(--color-primary);
        }

        .section {
            padding: 3.5rem 0;
        }

        @media (max-width: 768px) {
            .section {
                padding: 2.5rem 0;
            }
        }

        .card {
            border: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .hover-shadow {
            transition: all 0.3s ease;
        }

        .hover-shadow:hover {
            box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
            transform: translateY(-3px);
        }

        .footer {
            background: #2c3e50;
            color: white;
            padding: 3rem 0;
        }

        .footer a {
            color: #ecf0f1;
            text-decoration: none;
        }

        .footer a:hover {
            color: var(--color-primary);
        }

        .section.bg-white {
            background: white;
        }

        .section.bg-light-gray {
            background: #f5f7fa;
        }

        .section.no-bottom-margin {
            margin-bottom: 0;
            padding-bottom: 4rem;
        }

        .ecosystem-section h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--color-secondary);
        }

        .ecosystem-section p.lead {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 3rem;
        }

        .ecosystem-card {
            text-align: center;
            padding: 2rem;
            border-radius: 10px;
            background: white;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .ecosystem-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            transition: all 0.3s ease;
        }

        .ecosystem-card:hover {
            border-color: var(--color-primary);
            box-shadow: 0 10px 25px rgba(26, 115, 232, 0.15);
            transform: translateY(-5px);
        }

        .ecosystem-card:hover::before {
            height: 6px;
        }

        /* Color variants for ecosystem cards */
        .ecosystem-card.primary::before {
            background: linear-gradient(90deg, #1a73e8, #1557b0);
        }

        .ecosystem-card.success::before {
            background: linear-gradient(90deg, #198754, #157347);
        }

        .ecosystem-card.info::before {
            background: linear-gradient(90deg, #0dcaf0, #0c63e4);
        }

        .ecosystem-card.warning::before {
            background: linear-gradient(90deg, #ffc107, #ff9800);
        }

        .ecosystem-card.danger::before {
            background: linear-gradient(90deg, #dc3545, #c82333);
        }

        .ecosystem-card.purple::before {
            background: linear-gradient(90deg, #9b59b6, #8e44ad);
        }

        .ecosystem-card.teal::before {
            background: linear-gradient(90deg, #17a2b8, #138496);
        }

        .ecosystem-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: auto;
            margin-right: auto;
            border-radius: 10px;
        }

        .ecosystem-card.primary .ecosystem-icon {
            background: linear-gradient(135deg, rgba(26, 115, 232, 0.15), rgba(26, 115, 232, 0.05));
            color: #1a73e8;
        }

        .ecosystem-card.success .ecosystem-icon {
            background: linear-gradient(135deg, rgba(25, 135, 84, 0.15), rgba(25, 135, 84, 0.05));
            color: #198754;
        }

        .ecosystem-card.info .ecosystem-icon {
            background: linear-gradient(135deg, rgba(13, 202, 240, 0.15), rgba(13, 202, 240, 0.05));
            color: #0dcaf0;
        }

        .ecosystem-card.warning .ecosystem-icon {
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.15), rgba(255, 193, 7, 0.05));
            color: #ffc107;
        }

        .ecosystem-card.danger .ecosystem-icon {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.15), rgba(220, 53, 69, 0.05));
            color: #dc3545;
        }

        .ecosystem-card.purple .ecosystem-icon {
            background: linear-gradient(135deg, rgba(155, 89, 182, 0.15), rgba(155, 89, 182, 0.05));
            color: #9b59b6;
        }

        .ecosystem-card.teal .ecosystem-icon {
            background: linear-gradient(135deg, rgba(23, 162, 184, 0.15), rgba(23, 162, 184, 0.05));
            color: #17a2b8;
        }

        .ecosystem-card h5 {
            color: var(--color-secondary);
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .ecosystem-card p {
            font-size: 0.95rem;
            color: #666;
            margin-bottom: 1rem;
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
                    <li class="nav-item"><a class="nav-link" href="{{ route('africoders.ecosystem') }}">Ecosystem</a></li>
                    <li class="nav-item d-none d-lg-block"><a class="nav-link" href="https://{{ config('domains.africoders.help') }}/contact">Contact</a></li>
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('africoders.dashboard') }}"><i class="bi bi-person-circle"></i> <span class="d-none d-md-inline">Dashboard</span></a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="https://{{ config('domains.africoders.id') }}/auth?return={{ urlencode(request()->fullUrl()) }}"><i class="bi bi-box-arrow-in-right"></i> <span class="d-none d-md-inline">Login</span></a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Empowering Africa's Tech Ecosystem</h1>
            <p class="lead">Integrated platforms for learning, collaboration, and innovation across Africa</p>
            <div class="row text-center mt-5 mb-4">
                <div class="col-6 col-md-3 mb-3 mb-md-0">
                    <h2 class="fw-bold">{{ number_format($stats['total_users']) }}+</h2>
                    <p class="mb-0">Active Users</p>
                </div>
                <div class="col-6 col-md-3 mb-3 mb-md-0">
                    <h2 class="fw-bold">{{ $stats['total_courses'] }}+</h2>
                    <p class="mb-0">Courses Available</p>
                </div>
                <div class="col-6 col-md-3">
                    <h2 class="fw-bold">{{ $stats['total_businesses'] }}+</h2>
                    <p class="mb-0">Businesses Listed</p>
                </div>
                <div class="col-6 col-md-3">
                    <h2 class="fw-bold">{{ $stats['total_discussions'] }}+</h2>
                    <p class="mb-0">Discussions</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('africoders.ecosystem') }}" class="btn btn-primary btn-lg me-2 mb-2">Explore Ecosystem</a>
                <a href="https://{{ config('domains.africoders.help') }}/contact" class="btn btn-outline-light btn-lg mb-2">Contact Us</a>
            </div>
        </div>
    </section>

    <!-- Ecosystem Showcase (Moved up as primary focus) -->
    <section class="section ecosystem-section bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h2>Our Platforms</h2>
                <p class="lead">Comprehensive suite of integrated services for Africa's tech professionals</p>
            </div>

            <div class="row g-4">
                @foreach($ecosystemProducts as $index => $product)
                @php
                    $colors = ['primary', 'success', 'warning', 'info'];
                    $color = $colors[$index % count($colors)];
                @endphp
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <a href="{{ $product['url'] }}" class="text-decoration-none">
                        <div class="ecosystem-card {{ $color }}">
                            <div class="ecosystem-icon">
                                <i class="bi bi-{{ $product['icon'] }}"></i>
                            </div>
                            <h5>{{ $product['name'] }}</h5>
                            <p class="d-none d-md-block">{{ $product['description'] }}</p>
                            <p class="d-md-none small">{{ Str::limit($product['description'], 50) }}</p>
                            <span class="badge bg-{{ $color }} bg-opacity-10 text-{{ $color }}">{{ $product['stats'] }}</span>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('africoders.ecosystem') }}" class="btn btn-primary btn-lg">Learn More About Our Ecosystem <i class="bi bi-arrow-right ms-2"></i></a>
            </div>
        </div>
    </section>

    <!-- Popular Kortex Tools -->
    <section class="section bg-light">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                <div class="mb-3 mb-md-0">
                    <h2 class="mb-2">Popular Developer Tools</h2>
                    <p class="text-muted mb-0">Free online tools for developers and creators</p>
                </div>
                <a href="https://{{ config('domains.tools.kortex') }}" class="btn btn-outline-primary">View All Tools <i class="bi bi-arrow-right ms-2"></i></a>
            </div>
            <div class="row g-3 g-md-4">
                <div class="col-6 col-md-3">
                    <a href="https://{{ config('domains.tools.kortex') }}/tool/word-pdf-converter" class="text-decoration-none">
                        <div class="card shadow-sm hover-shadow">
                            <div class="card-body text-center p-3">
                                <div class="mb-2 mb-md-3">
                                    <i class="bi bi-file-earmark-pdf" style="font-size: 2rem; color: #dc3545;"></i>
                                </div>
                                <h6 class="card-title fw-bold mb-2" style="font-size: 0.9rem;">Word to PDF</h6>
                                <p class="card-text text-muted small d-none d-md-block mb-0" style="font-size: 0.85rem;">Convert Word documents to PDF instantly</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="https://{{ config('domains.tools.kortex') }}/tool/pdf-compressor" class="text-decoration-none">
                        <div class="card shadow-sm hover-shadow">
                            <div class="card-body text-center p-3">
                                <div class="mb-2 mb-md-3">
                                    <i class="bi bi-file-zip" style="font-size: 2rem; color: #6c757d;"></i>
                                </div>
                                <h6 class="card-title fw-bold mb-2" style="font-size: 0.9rem;">PDF Compressor</h6>
                                <p class="card-text text-muted small d-none d-md-block mb-0" style="font-size: 0.85rem;">Reduce PDF file size without losing quality</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="https://{{ config('domains.tools.kortex') }}/tool/keyword-research-tool" class="text-decoration-none">
                        <div class="card shadow-sm hover-shadow">
                            <div class="card-body text-center p-3">
                                <div class="mb-2 mb-md-3">
                                    <i class="bi bi-search" style="font-size: 2rem; color: #0d6efd;"></i>
                                </div>
                                <h6 class="card-title fw-bold mb-2" style="font-size: 0.9rem;">Keyword Research</h6>
                                <p class="card-text text-muted small d-none d-md-block mb-0" style="font-size: 0.85rem;">Find the best keywords for SEO</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="https://{{ config('domains.tools.kortex') }}/tool/paraphraser" class="text-decoration-none">
                        <div class="card shadow-sm hover-shadow">
                            <div class="card-body text-center p-3">
                                <div class="mb-2 mb-md-3">
                                    <i class="bi bi-arrow-repeat" style="font-size: 2rem; color: #198754;"></i>
                                </div>
                                <h6 class="card-title fw-bold mb-2" style="font-size: 0.9rem;">Paraphraser</h6>
                                <p class="card-text text-muted small d-none d-md-block mb-0" style="font-size: 0.85rem;">Rewrite text while maintaining meaning</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="text-center mt-4 d-md-none">
                <a href="https://{{ config('domains.tools.kortex') }}" class="btn btn-sm btn-primary">View All 150+ Tools</a>
            </div>
        </div>
    </section>

    <!-- Popular Courses -->
    @if($topCourses->count() > 0)
    <section class="section bg-white">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                <div class="mb-3 mb-md-0">
                    <h2 class="mb-2">Popular Courses</h2>
                    <p class="text-muted mb-0">Start learning with our most popular courses</p>
                </div>
                <a href="https://{{ config('domains.noccea.learn') }}" class="btn btn-outline-primary">Browse All Courses <i class="bi bi-arrow-right ms-2"></i></a>
            </div>
            <div class="row g-3 g-md-4">
                @foreach($topCourses->take(3) as $course)
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        @if($course->image)
                            <img src="{{ $course->image_url }}" class="card-img-top" alt="{{ $course->title }}" style="height: 180px; object-fit: cover;">
                        @else
                            <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 180px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="bi bi-book text-white" style="font-size: 2.5rem; opacity: 0.7;"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            @if($course->category)
                            <span class="badge bg-primary bg-opacity-10 text-primary mb-2 small">{{ $course->category }}</span>
                            @endif
                            <h5 class="card-title mb-2" style="font-size: 1.1rem;">{{ $course->title }}</h5>
                            <p class="card-text text-muted small mb-3">{{ Str::limit($course->description, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <small class="text-muted">
                                    <i class="bi bi-people me-1"></i>{{ $course->students_count }}
                                </small>
                                <small class="text-muted">
                                    <i class="bi bi-journal-text me-1"></i>{{ $course->total_lessons }} lessons
                                </small>
                            </div>
                            <a href="https://{{ config('domains.noccea.learn') }}/courses/{{ $course->slug }}" class="btn btn-sm btn-primary w-100">Enroll Now</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Community Discussions -->
    @if($topDiscussions->count() > 0)
    <section class="section bg-light">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                <div class="mb-3 mb-md-0">
                    <h2 class="mb-2">Trending Discussions</h2>
                    <p class="text-muted mb-0">Join the conversation in our community</p>
                </div>
                <a href="https://{{ config('domains.noccea.community') }}" class="btn btn-outline-primary">Join Community <i class="bi bi-arrow-right ms-2"></i></a>
            </div>
            <div class="row g-3">
                @foreach($topDiscussions->take(3) as $discussion)
                <div class="col-12">
                    <div class="card border-start border-4 border-primary">
                        <div class="card-body p-3 p-md-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start">
                                <div class="flex-grow-1 mb-2 mb-md-0">
                                    <h5 class="card-title mb-2" style="font-size: 1.1rem;">
                                        <a href="https://{{ config('domains.noccea.community') }}/discussions/{{ $discussion->slug }}" class="text-decoration-none text-dark">
                                            {{ Str::limit($discussion->title, 100) }}
                                        </a>
                                    </h5>
                                    <div class="d-flex flex-wrap align-items-center gap-2 gap-md-3 text-muted small">
                                        <span>
                                            <i class="bi bi-person me-1"></i><span class="d-none d-sm-inline">{{ $discussion->user->first_name }} {{ $discussion->user->last_name }}</span>
                                        </span>
                                        <span>
                                            <i class="bi bi-chat-dots me-1"></i>{{ $discussion->replies_count }}
                                        </span>
                                        <span class="d-none d-md-inline">
                                            <i class="bi bi-clock me-1"></i>{{ $discussion->last_activity_at->diffForHumans() }}
                                        </span>
                                        @if($discussion->category)
                                        <span class="badge bg-info bg-opacity-10 text-info small">{{ $discussion->category->name }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- CTA Section -->
    <section class="section" style="background: linear-gradient(135deg, var(--color-primary) 0%, #1557b0 100%); color: white; text-align: center;">
        <div class="container">
            <h2 class="mb-3">Ready to Get Started?</h2>
            <p class="lead mb-4">Join thousands of professionals already using our platforms</p>
            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                <a href="https://{{ config('domains.africoders.id') }}/auth" class="btn btn-light btn-lg">Create Free Account</a>
                <a href="https://{{ config('domains.africoders.help') }}/contact" class="btn btn-outline-light btn-lg">Contact Us</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-6 col-md-3">
                    <h6 class="mb-3">Platforms</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="https://{{ config('domains.noccea.learn') }}">Noccea Learn</a></li>
                        <li class="mb-2"><a href="https://{{ config('domains.noccea.business') }}">Noccea Business</a></li>
                        <li class="mb-2"><a href="https://{{ config('domains.noccea.community') }}">Community</a></li>
                        <li class="mb-2"><a href="https://{{ config('domains.tools.kortex') }}">Kortex Tools</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-3">
                    <h6 class="mb-3">Company</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('africoders.about') }}">About Us</a></li>
                        <li class="mb-2"><a href="{{ route('africoders.ecosystem') }}">Ecosystem</a></li>
                        <li class="mb-2"><a href="https://{{ config('domains.africoders.help') }}/contact">Contact</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-3">
                    <h6 class="mb-3">Support</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="https://{{ config('domains.africoders.help') }}">Help Center</a></li>
                        <li class="mb-2"><a href="https://{{ config('domains.africoders.help') }}/faq">FAQ</a></li>
                        <li class="mb-2"><a href="https://{{ config('domains.africoders.help') }}/support">Support</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-3">
                    <h6 class="mb-3">Legal</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="https://{{ config('domains.africoders.help') }}/privacy">Privacy</a></li>
                        <li class="mb-2"><a href="https://{{ config('domains.africoders.help') }}/terms">Terms</a></li>
                        <li class="mb-2"><a href="https://{{ config('domains.africoders.help') }}/cookies">Cookies</a></li>
                    </ul>
                </div>
            </div>
            <hr class="bg-light opacity-25">
            <div class="text-center py-3">
                <p class="mb-0">&copy; {{ now()->year }} Africoders. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
