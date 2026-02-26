@extends('africoders.help.layout')

@section('title', 'Support Center - Africoders Help')

@section('content')
    <div class="section-header text-center">
        <h1>Support Center</h1>
        <p>Find answers to common questions and get the help you need</p>
    </div>

    <!-- Categories -->
    <div class="row mb-5">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-person-circle" style="font-size: 3rem; color: var(--color-primary);"></i>
                    <h5 class="mt-3">Account & Profile</h5>
                    <p class="text-muted">Account creation, profile settings, and security</p>
                    <a href="{{ route('help.articles') }}?category=accounts" class="btn btn-outline-primary btn-sm">Browse Articles</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-shield-check" style="font-size: 3rem; color: var(--color-primary);"></i>
                    <h5 class="mt-3">Security & Privacy</h5>
                    <p class="text-muted">Data protection, privacy settings, and security</p>
                    <a href="{{ route('help.articles') }}?category=security" class="btn btn-outline-primary btn-sm">Browse Articles</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-rocket" style="font-size: 3rem; color: var(--color-primary);"></i>
                    <h5 class="mt-3">Getting Started</h5>
                    <p class="text-muted">Learn the basics and get up and running</p>
                    <a href="{{ route('help.articles') }}?category=getting-started" class="btn btn-outline-primary btn-sm">Browse Articles</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Featured Articles</h5>
                </div>
                <div class="card-body">
                    <div class="article-item">
                        <a href="{{ route('help.article', 'getting-started') }}">
                            <h6>Getting Started with Africoders</h6>
                        </a>
                        <p class="text-muted mb-0">Everything you need to know to get started with our platform.</p>
                    </div>

                    <div class="article-item">
                        <a href="{{ route('help.article', 'account-security') }}">
                            <h6>Keeping Your Account Secure</h6>
                        </a>
                        <p class="text-muted mb-0">Best practices for maintaining account security.</p>
                    </div>

                    <div class="article-item">
                        <a href="{{ route('help.article', 'privacy-settings') }}">
                            <h6>Managing Privacy Settings</h6>
                        </a>
                        <p class="text-muted mb-0">Control your privacy and data sharing preferences.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Links</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('help.faq') }}">Frequently Asked Questions</a></li>
                        <li><a href="{{ route('help.contact') }}">Contact Support</a></li>
                        <li><a href="{{ route('help.legal', 'terms') }}">Terms of Service</a></li>
                        <li><a href="{{ route('help.legal', 'privacy') }}">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Still Need Help?</h5>
                </div>
                <div class="card-body">
                    <p>Can't find what you're looking for?</p>
                    <a href="{{ route('help.contact') }}" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-envelope"></i> Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .article-item {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #f3f4f6;
    }

    .article-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .article-item a {
        text-decoration: none;
        color: var(--color-primary);
    }

    .article-item a:hover {
        text-decoration: underline;
    }
</style>
@endpush
