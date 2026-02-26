@extends('africoders.help.layout')

@section('title', 'Help Articles - Africoders Help')

@section('content')
    <div class="section-header text-center">
        <h1>Help Articles</h1>
        <p>Browse our comprehensive library of help articles and guides</p>
    </div>

    <!-- Category Filter -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h6>Browse by Category:</h6>
                    <div class="btn-group flex-wrap" role="group">
                        <a href="{{ route('help.articles') }}" class="btn btn-sm {{ !request('category') ? 'btn-primary' : 'btn-outline-primary' }}">All Articles</a>
                        <a href="{{ route('help.articles') }}?category=getting-started" class="btn btn-sm {{ request('category') == 'getting-started' ? 'btn-primary' : 'btn-outline-primary' }}">Getting Started</a>
                        <a href="{{ route('help.articles') }}?category=accounts" class="btn btn-sm {{ request('category') == 'accounts' ? 'btn-primary' : 'btn-outline-primary' }}">Accounts</a>
                        <a href="{{ route('help.articles') }}?category=security" class="btn btn-sm {{ request('category') == 'security' ? 'btn-primary' : 'btn-outline-primary' }}">Security</a>
                        <a href="{{ route('help.articles') }}?category=privacy" class="btn btn-sm {{ request('category') == 'privacy' ? 'btn-primary' : 'btn-outline-primary' }}">Privacy</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="search-box">
                <form method="GET" action="{{ route('help.search') }}">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" placeholder="Search articles..." value="{{ request('q') }}">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            @if(request('category'))
                <div class="mb-3">
                    <small class="text-muted">
                        Showing articles in: <strong>{{ ucwords(str_replace('-', ' ', request('category'))) }}</strong>
                    </small>
                </div>
            @endif

            <!-- Getting Started Articles -->
            @if(!request('category') || request('category') == 'getting-started')
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-rocket text-primary me-2"></i>
                            Getting Started
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="article-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6><a href="{{ route('help.article', 'getting-started') }}">Getting Started with Africoders</a></h6>
                                    <p class="text-muted mb-1">Learn the basics of using the Africoders platform and all its services.</p>
                                    <small class="text-muted">Last updated: {{ date('M j, Y') }}</small>
                                </div>
                                <span class="badge bg-success">Popular</span>
                            </div>
                        </div>

                        <div class="article-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6><a href="{{ route('help.article', 'creating-account') }}">Creating Your First Account</a></h6>
                                    <p class="text-muted mb-1">Step-by-step guide to setting up your Africoders account.</p>
                                    <small class="text-muted">Last updated: {{ date('M j, Y') }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="article-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6><a href="{{ route('help.article', 'platform-overview') }}">Platform Overview</a></h6>
                                    <p class="text-muted mb-1">Understanding the different Africoders services and how they work together.</p>
                                    <small class="text-muted">Last updated: {{ date('M j, Y') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Account & Security Articles -->
            @if(!request('category') || in_array(request('category'), ['accounts', 'security']))
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-shield-check text-primary me-2"></i>
                            Account & Security
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="article-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6><a href="{{ route('help.article', 'account-security') }}">Account Security Best Practices</a></h6>
                                    <p class="text-muted mb-1">Keep your account secure with these important security tips and guidelines.</p>
                                    <small class="text-muted">Last updated: {{ date('M j, Y') }}</small>
                                </div>
                                <span class="badge bg-warning">Important</span>
                            </div>
                        </div>

                        <div class="article-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6><a href="{{ route('help.article', 'password-management') }}">Password Management</a></h6>
                                    <p class="text-muted mb-1">Creating strong passwords and managing password changes.</p>
                                    <small class="text-muted">Last updated: {{ date('M j, Y') }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="article-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6><a href="{{ route('help.article', 'account-verification') }}">Account Verification</a></h6>
                                    <p class="text-muted mb-1">Understanding the email verification process and troubleshooting issues.</p>
                                    <small class="text-muted">Last updated: {{ date('M j, Y') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Privacy Articles -->
            @if(!request('category') || request('category') == 'privacy')
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-lock text-primary me-2"></i>
                            Privacy & Data
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="article-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6><a href="{{ route('help.article', 'privacy-settings') }}">Managing Your Privacy Settings</a></h6>
                                    <p class="text-muted mb-1">Control what information you share and with whom on the platform.</p>
                                    <small class="text-muted">Last updated: {{ date('M j, Y') }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="article-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6><a href="{{ route('help.article', 'data-export') }}">Exporting Your Data</a></h6>
                                    <p class="text-muted mb-1">How to download a copy of your personal data from Africoders.</p>
                                    <small class="text-muted">Last updated: {{ date('M j, Y') }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="article-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6><a href="{{ route('help.article', 'account-deletion') }}">Account Deletion</a></h6>
                                    <p class="text-muted mb-1">Understanding the process and consequences of deleting your account.</p>
                                    <small class="text-muted">Last updated: {{ date('M j, Y') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Need Help?</h5>
                </div>
                <div class="card-body">
                    <p>Can't find what you're looking for?</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('help.faq') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-question-circle"></i> Check FAQs
                        </a>
                        <a href="{{ route('help.contact') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-envelope"></i> Contact Support
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Article Stats</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="h4 text-primary mb-0">9</div>
                            <small class="text-muted">Total Articles</small>
                        </div>
                        <div class="col-6">
                            <div class="h4 text-success mb-0">3</div>
                            <small class="text-muted">Categories</small>
                        </div>
                    </div>
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

    .article-item h6 a {
        text-decoration: none;
        color: var(--color-primary);
    }

    .article-item h6 a:hover {
        text-decoration: underline;
    }

    .btn-group .btn {
        margin: 0.125rem;
    }

    .search-box .input-group {
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        border-radius: 0.375rem;
        overflow: hidden;
    }
</style>
@endpush
