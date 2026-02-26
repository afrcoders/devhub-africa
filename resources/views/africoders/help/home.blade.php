@extends('africoders.help.layout')

@section('title', 'Africoders Help Center')

@section('content')
    <div class="section-header text-center">
        <h1>How can we help?</h1>
        <p>Find answers, get support, and learn about Africoders</p>
    </div>

    <!-- Search -->
    <div class="search-box">
        <form method="GET" action="{{ route('help.search') }}">
            <div class="input-group">
                <span class="input-group-text bg-white border-0">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" class="form-control border-0" name="q" placeholder="Search help articles, FAQ, and more...">
            </div>
        </form>
    </div>

    <!-- Quick Links -->
    <div class="row mb-5">
        <div class="col-md-3 mb-3">
            <a href="{{ route('help.support') }}" class="card text-decoration-none text-dark">
                <div class="card-body text-center">
                    <i class="bi bi-book" style="font-size: 2.5rem; color: var(--color-primary);"></i>
                    <h5 class="mt-3 mb-2">Support & FAQ</h5>
                    <p class="text-muted mb-0">Browse our help articles and FAQs</p>
                </div>
            </a>
        </div>

        <div class="col-md-3 mb-3">
            <a href="{{ route('help.contact') }}" class="card text-decoration-none text-dark">
                <div class="card-body text-center">
                    <i class="bi bi-envelope" style="font-size: 2.5rem; color: var(--color-primary);"></i>
                    <h5 class="mt-3 mb-2">Contact Us</h5>
                    <p class="text-muted mb-0">Get in touch with our team</p>
                </div>
            </a>
        </div>

        <div class="col-md-3 mb-3">
            <a href="{{ route('help.legal', 'community-guidelines') }}" class="card text-decoration-none text-dark">
                <div class="card-body text-center">
                    <i class="bi bi-people" style="font-size: 2.5rem; color: var(--color-primary);"></i>
                    <h5 class="mt-3 mb-2">Community</h5>
                    <p class="text-muted mb-0">Guidelines and code of conduct</p>
                </div>
            </a>
        </div>

        <div class="col-md-3 mb-3">
            <a href="{{ route('help.legal', 'privacy') }}" class="card text-decoration-none text-dark">
                <div class="card-body text-center">
                    <i class="bi bi-shield-lock" style="font-size: 2.5rem; color: var(--color-primary);"></i>
                    <h5 class="mt-3 mb-2">Legal</h5>
                    <p class="text-muted mb-0">Terms, privacy, and policies</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Popular Articles -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Popular Articles</h5>
                </div>
                <div class="card-body">
                    {{-- TODO: Replace with database queries when migration is complete --}}
                    <div class="article-item">
                        <a href="{{ route('help.article', 'getting-started') }}">
                            <h5>Getting Started with Africoders</h5>
                        </a>
                        <p class="text-muted mb-0">Learn the basics of using the Africoders platform and services.</p>
                    </div>

                    <div class="article-item">
                        <a href="{{ route('help.article', 'account-security') }}">
                            <h5>Account Security Best Practices</h5>
                        </a>
                        <p class="text-muted mb-0">Keep your account secure with these important tips.</p>
                    </div>

                    <div class="article-item">
                        <a href="{{ route('help.article', 'privacy-settings') }}">
                            <h5>Managing Your Privacy Settings</h5>
                        </a>
                        <p class="text-muted mb-0">Control what information you share and with whom.</p>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('help.articles') }}" class="btn btn-primary btn-sm">
                            View All Articles
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Frequently Asked Questions</h5>
                </div>
                <div class="card-body">
                    {{-- TODO: Replace with database queries when migration is complete --}}
                    <div class="faq-item">
                        <a href="{{ route('help.faq') }}#account-creation">
                            <h6>How do I create an account?</h6>
                        </a>
                        <p class="text-muted mb-0">Creating an account is simple and only takes a few minutes...</p>
                    </div>

                    <div class="faq-item">
                        <a href="{{ route('help.faq') }}#password-reset">
                            <h6>I forgot my password. How do I reset it?</h6>
                        </a>
                        <p class="text-muted mb-0">You can reset your password using the forgot password link...</p>
                    </div>

                    <div class="faq-item">
                        <a href="{{ route('help.faq') }}#data-privacy">
                            <h6>How do you protect my data?</h6>
                        </a>
                        <p class="text-muted mb-0">We take data protection seriously and follow industry standards...</p>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('help.faq') }}" class="btn btn-outline-primary btn-sm">
                            View All FAQs
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Ecosystem Navigation -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-diagram-3"></i> Africoders Ecosystem</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Access all platforms with your account</p>
                    <div class="d-grid gap-2">
                        <a href="https://{{ config('domains.africoders.main') }}" class="btn btn-sm btn-outline-primary text-start">
                            <i class="bi bi-house-door me-2"></i>Africoders
                        </a>
                        <a href="https://{{ config('domains.africoders.id') }}/dashboard" class="btn btn-sm btn-outline-primary text-start">
                            <i class="bi bi-person-badge me-2"></i>ID Dashboard
                        </a>
                        <a href="https://{{ config('domains.noccea.main') }}?auth=true" class="btn btn-sm btn-outline-primary text-start">
                            <i class="bi bi-grid me-2"></i>Noccea Hub
                        </a>
                        <a href="https://{{ config('domains.noccea.learn') }}?auth=true" class="btn btn-sm btn-outline-info text-start">
                            <i class="bi bi-book me-2"></i>Learn
                        </a>
                        <a href="https://{{ config('domains.noccea.community') }}?auth=true" class="btn btn-sm btn-outline-success text-start">
                            <i class="bi bi-people me-2"></i>Community
                        </a>
                        <a href="https://{{ config('domains.noccea.business') }}?auth=true" class="btn btn-sm btn-outline-warning text-start">
                            <i class="bi bi-briefcase me-2"></i>Business
                        </a>
                        <a href="https://{{ config('domains.tools.kortex') }}" class="btn btn-sm btn-outline-secondary text-start">
                            <i class="bi bi-tools me-2"></i>Kortex Tools
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Need More Help?</h5>
                </div>
                <div class="card-body">
                    <p>Can't find what you're looking for?</p>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('help.contact') }}">Contact our support team</a></li>
                        <li><a href="{{ route('help.search') }}">Search our knowledge base</a></li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Links</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('help.legal', 'terms') }}">Terms of Service</a></li>
                        <li><a href="{{ route('help.legal', 'privacy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('help.legal', 'community-guidelines') }}">Community Guidelines</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .article-item, .faq-item {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #f3f4f6;
    }

    .article-item:last-child, .faq-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .article-item a, .faq-item a {
        text-decoration: none;
        color: var(--color-primary);
    }

    .article-item a:hover, .faq-item a:hover {
        text-decoration: underline;
    }
</style>
@endpush
