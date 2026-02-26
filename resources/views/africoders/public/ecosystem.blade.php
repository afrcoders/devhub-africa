<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecosystem - Africoders</title>
    <meta name="description" content="Understand how Africoders and its products connect to create a unified innovation ecosystem.">

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

        .ecosystem-content {
            padding: 3rem 0;
        }

        .product-card {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15) !important;
        }

        .product-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--color-primary);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .product-badge.bg-success {
            background: #198754 !important;
        }

        .product-badge.bg-info {
            background: #0dcaf0 !important;
        }

        .product-badge.bg-warning {
            background: #ffc107 !important;
        }

        .product-badge.bg-danger {
            background: #dc3545 !important;
        }

        .product-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 80px;
            background: linear-gradient(135deg, rgba(26, 115, 232, 0.1), rgba(26, 115, 232, 0.05));
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }

        .product-icon i {
            color: var(--color-primary);
        }

        .product-card .card-title {
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 1rem;
            color: #333;
        }

        .product-card .card-text {
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .ecosystem-box {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s;
        }

        .ecosystem-box:hover {
            border-color: var(--color-primary);
            box-shadow: 0 5px 15px rgba(26, 115, 232, 0.2);
            transform: translateY(-5px);
        }

        .ecosystem-icon {
            font-size: 3rem;
            color: var(--color-primary);
            margin-bottom: 1rem;
        }

        .ecosystem-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
        }

        .ecosystem-description {
            color: #666;
            margin-bottom: 1rem;
        }

        .connector {
            text-align: center;
            padding: 1rem;
            color: var(--color-primary);
            font-weight: 600;
        }

        .connection-line {
            display: none;
        }

        @media (min-width: 992px) {
            .connection-line {
                display: block;
                position: absolute;
                top: 100%;
                left: 50%;
                width: 2px;
                height: 30px;
                background: var(--color-primary);
                transform: translateX(-50%);
            }
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 3rem;
            text-align: center;
            color: var(--color-secondary);
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
            <h1>Ecosystem</h1>
            <p>How our products and services connect to create innovation</p>
        </div>
    </div>

    <!-- Ecosystem Content -->
    <section class="ecosystem-content">
        <div class="container">
            <!-- Hero Section -->
            <div class="row mb-5 pb-5">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <h2 class="mb-4">The Africoders Ecosystem</h2>
                    <p class="lead">A comprehensive suite of interconnected products and services designed to empower African entrepreneurs, professionals, and organizations. From identity and authentication to community and productivity tools, we've built an ecosystem that works together seamlessly.</p>
                </div>
            </div>

            <!-- Core Services Layer -->
            <div class="row mb-5">
                <div class="col-12">
                    <h3 class="mb-4"><i class="bi bi-gear text-primary"></i> Core Infrastructure</h3>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <!-- Identity Service -->
                <div class="col-lg-6 col-xl-4">
                    <div class="card h-100 shadow-lg border-0 product-card">
                        <div class="product-badge">Core Service</div>
                        <div class="card-body">
                            <div class="product-icon mb-3">
                                <i class="bi bi-shield-lock text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="card-title">Identity Service</h5>
                            <p class="card-text text-muted mb-4">Unified authentication and identity management across all ecosystem products.</p>
                            <ul class="list-unstyled small text-muted mb-4">
                                <li><i class="bi bi-check-circle text-success"></i> Single Sign-On</li>
                                <li><i class="bi bi-check-circle text-success"></i> User Management</li>
                                <li><i class="bi bi-check-circle text-success"></i> JWT Authentication</li>
                                <li><i class="bi bi-check-circle text-success"></i> Security First</li>
                            </ul>
                            <a href="https://{{ config('domains.africoders.id') }}" class="btn btn-primary btn-sm">Visit ID Service</a>
                        </div>
                    </div>
                </div>

                <!-- Help Center -->
                <div class="col-lg-6 col-xl-4">
                    <div class="card h-100 shadow-lg border-0 product-card">
                        <div class="product-badge">Support</div>
                        <div class="card-body">
                            <div class="product-icon mb-3">
                                <i class="bi bi-question-circle text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="card-title">Help Center</h5>
                            <p class="card-text text-muted mb-4">Comprehensive documentation, guides, and support resources for all ecosystem products.</p>
                            <ul class="list-unstyled small text-muted mb-4">
                                <li><i class="bi bi-check-circle text-success"></i> Knowledge Base</li>
                                <li><i class="bi bi-check-circle text-success"></i> Tutorials & Guides</li>
                                <li><i class="bi bi-check-circle text-success"></i> Support Tickets</li>
                                <li><i class="bi bi-check-circle text-success"></i> FAQs</li>
                            </ul>
                            <a href="https://{{ config('domains.africoders.help') }}" class="btn btn-primary btn-sm">Visit Help Center</a>
                        </div>
                    </div>
                </div>

                <!-- Africoders Main -->
                <div class="col-lg-6 col-xl-4">
                    <div class="card h-100 shadow-lg border-0 product-card">
                        <div class="product-badge">Main Portal</div>
                        <div class="card-body">
                            <div class="product-icon mb-3">
                                <i class="bi bi-globe text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="card-title">Africoders Portal</h5>
                            <p class="card-text text-muted mb-4">The gateway to the entire Africoders ecosystem. Discover ventures, connect with partners, and explore opportunities.</p>
                            <ul class="list-unstyled small text-muted mb-4">
                                <li><i class="bi bi-check-circle text-success"></i> Venture Discovery</li>
                                <li><i class="bi bi-check-circle text-success"></i> Partnership Hub</li>
                                <li><i class="bi bi-check-circle text-success"></i> News & Insights</li>
                                <li><i class="bi bi-check-circle text-success"></i> Ecosystem Overview</li>
                            </ul>
                            <a href="https://{{ config('domains.africoders.main') }}" class="btn btn-primary btn-sm">Visit Portal</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Noccea Platform Section -->
            <div class="row mb-5 mt-5">
                <div class="col-12">
                    <h3 class="mb-4"><i class="bi bi-people text-success"></i> Noccea - Community & Solutions</h3>
                    <p class="text-muted mb-4">Noccea is our flagship community platform connecting African tech professionals, entrepreneurs, and organizations. It's where talent meets opportunity.</p>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <!-- Noccea Main -->
                <div class="col-lg-6 col-xl-3">
                    <div class="card h-100 shadow border-0 product-card">
                        <div class="product-badge bg-success">Community</div>
                        <div class="card-body">
                            <div class="product-icon mb-3">
                                <i class="bi bi-globe-africa text-success" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="card-title">Noccea Platform</h5>
                            <p class="card-text text-muted small mb-3">The heartbeat of our community. Connect with peers, discover opportunities, and grow together.</p>
                            <div class="d-grid">
                                <a href="https://{{ config('domains.noccea.main') }}" class="btn btn-success btn-sm">Explore Platform</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Noccea Business -->
                <div class="col-lg-6 col-xl-3">
                    <div class="card h-100 shadow border-0 product-card">
                        <div class="product-badge bg-success">Enterprise</div>
                        <div class="card-body">
                            <div class="product-icon mb-3">
                                <i class="bi bi-briefcase text-success" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="card-title">Business Discovery</h5>
                            <p class="card-text text-muted small mb-3">Find business partnerships, discover investment opportunities, and unlock enterprise solutions.</p>
                            <div class="d-grid">
                                <a href="https://{{ config('domains.noccea.business') }}" class="btn btn-success btn-sm">Discover Businesses</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Noccea Learning -->
                <div class="col-lg-6 col-xl-3">
                    <div class="card h-100 shadow border-0 product-card">
                        <div class="product-badge bg-success">Learning</div>
                        <div class="card-body">
                            <div class="product-icon mb-3">
                                <i class="bi bi-book text-success" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="card-title">Learning Platform</h5>
                            <p class="card-text text-muted small mb-3">Upskill and reskill with expert-led courses, tutorials, and learning paths for African technologists.</p>
                            <div class="d-grid">
                                <a href="https://{{ config('domains.noccea.learn') }}" class="btn btn-success btn-sm">Learn & Grow</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Noccea Community -->
                <div class="col-lg-6 col-xl-3">
                    <div class="card h-100 shadow border-0 product-card">
                        <div class="product-badge bg-success">Forums</div>
                        <div class="card-body">
                            <div class="product-icon mb-3">
                                <i class="bi bi-chat-left-text text-success" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="card-title">Community Forums</h5>
                            <p class="card-text text-muted small mb-3">Join conversations, ask questions, share knowledge, and build meaningful connections with peers.</p>
                            <div class="d-grid">
                                <a href="https://{{ config('domains.noccea.community') }}" class="btn btn-success btn-sm">Join Community</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tools Platform Section -->
            <div class="row mb-5 mt-5">
                <div class="col-12">
                    <h3 class="mb-4"><i class="bi bi-tools text-info"></i> Productivity Tools</h3>
                    <p class="text-muted mb-4">Professional-grade tools designed for developers, entrepreneurs, and organizations across Africa.</p>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <!-- Kortextools -->
                <div class="col-lg-6 col-xl-4">
                    <div class="card h-100 shadow-lg border-0 product-card">
                        <div class="product-badge bg-info">Tools</div>
                        <div class="card-body">
                            <div class="product-icon mb-3">
                                <i class="bi bi-hammer text-info" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="card-title">Kortextools</h5>
                            <p class="card-text text-muted mb-4">All-in-one productivity platform with tools for file conversion, editing, compression, and collaboration. Perfect for developers and teams.</p>
                            <ul class="list-unstyled small text-muted mb-4">
                                <li><i class="bi bi-check-circle text-info"></i> PDF Tools</li>
                                <li><i class="bi bi-check-circle text-info"></i> File Conversion</li>
                                <li><i class="bi bi-check-circle text-info"></i> Compression</li>
                                <li><i class="bi bi-check-circle text-info"></i> Collaboration</li>
                            </ul>
                            <a href="https://{{ config('domains.tools.kortex') }}" class="btn btn-info btn-sm text-white">Explore Tools</a>
                        </div>
                    </div>
                </div>

                <!-- Ventures -->
                <div class="col-lg-6 col-xl-4">
                    <div class="card h-100 shadow-lg border-0 product-card">
                        <div class="product-badge bg-warning">Portfolio</div>
                        <div class="card-body">
                            <div class="product-icon mb-3">
                                <i class="bi bi-rocket text-warning" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="card-title">Venture Portfolio</h5>
                            <p class="card-text text-muted mb-4">Explore our portfolio of innovative startups and companies that are transforming industries and solving real African problems.</p>
                            <ul class="list-unstyled small text-muted mb-4">
                                <li><i class="bi bi-check-circle text-warning"></i> 6+ Active Ventures</li>
                                <li><i class="bi bi-check-circle text-warning"></i> Multiple Sectors</li>
                                <li><i class="bi bi-check-circle text-warning"></i> Impact-Driven</li>
                                <li><i class="bi bi-check-circle text-warning"></i> Growth-Focused</li>
                            </ul>
                            <a href="{{ route('africoders.ventures.index') }}" class="btn btn-warning btn-sm">View Ventures</a>
                        </div>
                    </div>
                </div>

                <!-- Press -->
                <div class="col-lg-6 col-xl-4">
                    <div class="card h-100 shadow-lg border-0 product-card">
                        <div class="product-badge bg-danger">News</div>
                        <div class="card-body">
                            <div class="product-icon mb-3">
                                <i class="bi bi-newspaper text-danger" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="card-title">Press & Announcements</h5>
                            <p class="card-text text-muted mb-4">Stay updated with the latest news, press releases, and announcements from Africoders and our ecosystem partners.</p>
                            <ul class="list-unstyled small text-muted mb-4">
                                <li><i class="bi bi-check-circle text-danger"></i> Press Releases</li>
                                <li><i class="bi bi-check-circle text-danger"></i> Announcements</li>
                                <li><i class="bi bi-check-circle text-danger"></i> Milestones</li>
                                <li><i class="bi bi-check-circle text-danger"></i> Awards</li>
                            </ul>
                            <a href="{{ route('africoders.press.index') }}" class="btn btn-danger btn-sm">Read News</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ecosystem Values -->
            <div class="row mt-5 pt-5">
                <div class="col-12">
                    <h3 class="mb-4">Why Our Ecosystem Works</h3>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="text-center p-4 bg-light rounded">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">
                            <i class="bi bi-link text-primary"></i>
                        </div>
                        <h6>Seamlessly Connected</h6>
                        <p class="small text-muted">All products share unified authentication and data infrastructure for frictionless integration.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="text-center p-4 bg-light rounded">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">
                            <i class="bi bi-shield-lock text-success"></i>
                        </div>
                        <h6>Enterprise Security</h6>
                        <p class="small text-muted">Bank-level security, encryption, and compliance standards protect your data everywhere.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="text-center p-4 bg-light rounded">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">
                            <i class="bi bi-graph-up text-info"></i>
                        </div>
                        <h6>Built to Scale</h6>
                        <p class="small text-muted">From startup to enterprise, our ecosystem grows with your ambitions.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="text-center p-4 bg-light rounded">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">
                            <i class="bi bi-people text-warning"></i>
                        </div>
                        <h6>Community-First</h6>
                        <p class="small text-muted">50,000+ African professionals united in driving innovation and creating opportunities.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section style="background: linear-gradient(135deg, var(--color-primary) 0%, #1557b0 100%); color: white; padding: 4rem 0; margin-top: 4rem; text-align: center;">
        <div class="container">
            <h2 class="mb-3">Be Part of the Ecosystem</h2>
            <p class="lead mb-4">Join investors, partners, and stakeholders driving innovation across Africa.</p>
            <a href="https://{{ config('domains.africoders.help') }}/contact" class="btn btn-light btn-lg">Get Started</a>
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
