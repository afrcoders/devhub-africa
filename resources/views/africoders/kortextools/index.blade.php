@extends('africoders.kortextools.layout')

@section('title', 'KortexTools - Free Developer & Productivity Tools')
@section('meta_description', 'Access 148+ free online tools for developers, designers, and productivity enthusiasts. No signup required.')

@section('content')
<div class="kortextools-home">
    <!-- Hero Section with Featured Tools -->
    <section class="hero-section">
        <div class="hero-gradient"></div>
        <div class="container">
            <div class="row align-items-center min-vh-75">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1 class="display-3 fw-bold text-white mb-4">
                            <span class="text-gradient">148+</span> Free Tools<br>
                            <span class="hero-subtitle">for Developers & Creators</span>
                        </h1>
                        <p class="lead text-white-75 mb-4">
                            Boost your productivity with our collection of free online tools.
                            No registration required, instant results.
                        </p>

                        <!-- Search Bar -->
                        <form action="{{ route('tools.kortex.search') }}" method="get" class="hero-search mb-4">
                            <div class="input-group input-group-lg">
                                <input
                                    type="text"
                                    name="q"
                                    class="form-control search-input"
                                    placeholder="Search from 148+ tools..."
                                    required
                                >
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search me-2"></i>Search
                                </button>
                            </div>
                        </form>

                        <!-- Stats -->
                        <div class="hero-stats">
                            <div class="row g-4">
                                <div class="col-4">
                                    <div class="stat-item">
                                        <div class="stat-number">148+</div>
                                        <div class="stat-label">Tools</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-item">
                                        <div class="stat-number">14</div>
                                        <div class="stat-label">Categories</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-item">
                                        <div class="stat-number">100%</div>
                                        <div class="stat-label">Free</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-tools">
                        <div class="tools-showcase">
                            @if(isset($featuredTools) && $featuredTools->isNotEmpty())
                                @foreach($featuredTools->take(6) as $index => $tool)
                                <div class="tool-card-hero animate__animated animate__fadeInUp" style="animation-delay: {{ $index * 0.1 }}s;">
                                    <a href="{{ route('tools.kortex.tool.show', $tool->slug) }}" class="tool-link">
                                        <div class="tool-icon">
                                            <i class="{{ $tool->icon ?? 'fas fa-wrench' }}"></i>
                                        </div>
                                        <div class="tool-info">
                                            <h6 class="tool-name">{{ $tool->name }}</h6>
                                            <small class="tool-category">{{ $tool->category }}</small>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Tools Section -->
    <section class="popular-tools-section py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="h1 fw-bold mb-3">Most Popular Tools</h2>
                <p class="lead text-muted">Discover the tools our users love most</p>
            </div>

            <div class="row g-4">
                @if(isset($featuredTools) && $featuredTools->isNotEmpty())
                    @foreach($featuredTools->take(12) as $tool)
                    <div class="col-md-6 col-lg-4">
                        <div class="popular-tool-card">
                            <a href="{{ route('tools.kortex.tool.show', $tool->slug) }}" class="tool-card-link">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="tool-icon-large me-3">
                                                <i class="{{ $tool->icon ?? 'fas fa-wrench' }}"></i>
                                            </div>
                                            <div>
                                                <h5 class="card-title mb-1">{{ $tool->name }}</h5>
                                                <small class="text-muted">{{ $tool->category }}</small>
                                            </div>
                                        </div>
                                        <p class="card-text text-muted">{{ Str::limit($tool->description ?? 'Professional tool for advanced productivity and analysis.', 80) }}</p>
                                        <div class="tool-badge">
                                            <i class="fas fa-arrow-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>

            <div class="text-center mt-5">
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('tools.kortex.tools.index') }}" class="btn btn-primary btn-lg px-4">
                        <i class="fas fa-th-large me-2"></i>Browse Tools
                    </a>
                    <a href="{{ route('tools.kortex.all-tools') }}" class="btn btn-outline-primary btn-lg px-4">
                        <i class="fas fa-list me-2"></i>All Tools A-Z
                    </a>
                </div>
                <small class="text-muted d-block mt-2">{{ number_format(148) }}+ tools available • No registration required</small>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories-section py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="h1 fw-bold mb-3">Browse by Category</h2>
                <p class="lead text-muted">Find exactly what you need from our organized collection</p>
            </div>

            <div class="row g-4">
                @foreach($categories->take(8) as $category)
                <div class="col-md-6 col-lg-3">
                    <a href="{{ route('tools.kortex.tools.category', $category['slug']) }}" class="category-card-modern">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center p-4">
                                <div class="category-icon-modern mb-3">
                                    <i class="{{ $category['icon'] }}"></i>
                                </div>
                                <h5 class="card-title mb-2">{{ $category['name'] }}</h5>
                                <div class="category-count">
                                    <span class="badge bg-primary rounded-pill">{{ $category['count'] }} tools</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('tools.kortex.categories.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-th-large me-2"></i>View All Categories
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="h1 fw-bold mb-4">Why Choose KortexTools?</h2>
                    <div class="features-list">
                        <div class="feature-item d-flex mb-4">
                            <div class="feature-icon me-3">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <div>
                                <h5 class="mb-2">Lightning Fast</h5>
                                <p class="text-muted">All tools work instantly in your browser. No downloads or installations required.</p>
                            </div>
                        </div>
                        <div class="feature-item d-flex mb-4">
                            <div class="feature-icon me-3">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div>
                                <h5 class="mb-2">Secure & Private</h5>
                                <p class="text-muted">Your data stays in your browser. We don't store or track your information.</p>
                            </div>
                        </div>
                        <div class="feature-item d-flex mb-4">
                            <div class="feature-icon me-3">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div>
                                <h5 class="mb-2">Mobile Friendly</h5>
                                <p class="text-muted">Access all tools from any device - desktop, tablet, or mobile.</p>
                            </div>
                        </div>
                        <div class="feature-item d-flex">
                            <div class="feature-icon me-3">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div>
                                <h5 class="mb-2">Always Free</h5>
                                <p class="text-muted">No hidden fees, no subscriptions. All tools are completely free to use.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="features-visual">
                        <div class="floating-tools">
                            <div class="floating-tool floating-tool-1">
                                <i class="fas fa-qrcode"></i>
                            </div>
                            <div class="floating-tool floating-tool-2">
                                <i class="fas fa-calculator"></i>
                            </div>
                            <div class="floating-tool floating-tool-3">
                                <i class="fas fa-code"></i>
                            </div>
                            <div class="floating-tool floating-tool-4">
                                <i class="fas fa-palette"></i>
                            </div>
                            <div class="floating-tool floating-tool-5">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section bg-primary text-white py-5">
        <div class="container text-center">
            <h2 class="h1 fw-bold mb-3">Ready to Boost Your Productivity?</h2>
            <p class="lead mb-4">Join thousands of developers and creators who use KortexTools daily</p>
            <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
                <a href="{{ route('tools.kortex.tools.index') }}" class="btn btn-light btn-lg px-5">
                    <i class="fas fa-rocket me-2"></i>Explore All Tools
                </a>
                <a href="{{ route('tools.kortex.how-it-works') }}" class="btn btn-outline-light btn-lg px-5">
                    <i class="fas fa-info-circle me-2"></i>How It Works
                </a>
            </div>
        </div>
    </section>
</div>

<style>
/* Modern Homepage Styles */
.kortextools-home {
    overflow-x: hidden;
}

/* Hero Section */
.hero-section {
    position: relative;
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
    display: flex;
    align-items: center;
}

.hero-gradient {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3), transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3), transparent 50%);
}

.min-vh-75 {
    min-height: 75vh;
}

.text-gradient {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-subtitle {
    font-size: 2rem;
    font-weight: 400;
    opacity: 0.9;
}

.text-white-75 {
    color: rgba(255, 255, 255, 0.85);
}

.hero-search {
    max-width: 600px;
}

.search-input {
    border: none;
    border-radius: 50px 0 0 50px;
    padding: 1rem 2rem;
    font-size: 1.1rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.search-input:focus {
    border: none;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.hero-search .btn {
    border-radius: 0 50px 50px 0;
    padding: 1rem 2rem;
    font-weight: 600;
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
}

.hero-search .btn:hover {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
}

/* Hero Stats */
.hero-stats {
    margin-top: 3rem;
}

.stat-item {
    text-align: center;
    color: white;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.8;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Hero Tools Showcase */
.hero-tools {
    position: relative;
}

.tools-showcase {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    max-width: 500px;
    margin: 0 auto;
}

.tool-card-hero {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    padding: 1rem;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.tool-card-hero:hover {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.15);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.tool-link {
    text-decoration: none;
    color: white;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.tool-icon {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.tool-name {
    font-weight: 600;
    margin: 0;
    font-size: 0.9rem;
}

.tool-category {
    opacity: 0.7;
    font-size: 0.75rem;
}

/* Popular Tools Section */
.popular-tools-section {
    position: relative;
}

.popular-tool-card {
    transition: all 0.3s ease;
}

.tool-card-link {
    text-decoration: none;
    color: inherit;
}

.popular-tool-card:hover {
    transform: translateY(-5px);
}

.popular-tool-card .card {
    transition: all 0.3s ease;
    border-radius: 16px;
    overflow: hidden;
}

.popular-tool-card:hover .card {
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
}

.tool-icon-large {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.tool-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 40px;
    height: 40px;
    background: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    opacity: 0;
    transition: all 0.3s ease;
}

.popular-tool-card:hover .tool-badge {
    opacity: 1;
}

/* Categories Section */
.categories-section {
    background: #f8f9fa;
}

.category-card-modern {
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    display: block;
}

.category-card-modern:hover {
    color: inherit;
    transform: translateY(-5px);
}

.category-card-modern .card {
    border-radius: 16px;
    transition: all 0.3s ease;
}

.category-card-modern:hover .card {
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
}

.category-icon-modern {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: white;
    font-size: 2rem;
}

.category-count .badge {
    font-size: 0.8rem;
    padding: 0.5rem 1rem;
}

/* Features Section */
.features-section {
    padding: 100px 0;
}

.feature-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.feature-item h5 {
    font-weight: 600;
    color: #2d3748;
}

.features-visual {
    position: relative;
    height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.floating-tools {
    position: relative;
    width: 300px;
    height: 300px;
}

.floating-tool {
    position: absolute;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    animation: float 3s ease-in-out infinite;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.floating-tool-1 { top: 0; left: 50%; transform: translateX(-50%); animation-delay: 0s; }
.floating-tool-2 { top: 25%; right: 0; animation-delay: 0.6s; }
.floating-tool-3 { bottom: 25%; right: 0; animation-delay: 1.2s; }
.floating-tool-4 { bottom: 0; left: 50%; transform: translateX(-50%); animation-delay: 1.8s; }
.floating-tool-5 { top: 25%; left: 0; animation-delay: 2.4s; }

@keyframes float {
    0%, 100% { transform: translateY(0px) translateX(-50%); }
    50% { transform: translateY(-20px) translateX(-50%); }
}

.floating-tool-2,
.floating-tool-3,
.floating-tool-5 {
    animation-name: floatSide;
}

@keyframes floatSide {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

/* CTA Section */
.cta-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-section {
        min-height: auto;
        padding: 80px 0;
    }

    .display-3 {
        font-size: 2.5rem;
    }

    .hero-subtitle {
        font-size: 1.5rem;
    }

    .tools-showcase {
        grid-template-columns: 1fr;
        max-width: 300px;
    }

    .stat-number {
        font-size: 2rem;
    }

    .floating-tools {
        display: none;
    }

    .features-visual {
        height: 200px;
        margin-top: 3rem;
    }
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate__animated {
    animation-duration: 0.8s;
    animation-fill-mode: both;
}

.animate__fadeInUp {
    animation-name: fadeInUp;
}
</style>
@endsection
