@extends('africoders.help.layout')

@section('title', 'Search Results' . (request('q') ? ' for "' . request('q') . '"' : '') . ' - Africoders Help')

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Search Header -->
            <div class="card mb-4">
                <div class="card-body">
                    <h1 class="h3 mb-3">
                        @if(request('q'))
                            Search Results for "{{ request('q') }}"
                        @else
                            Search Help Center
                        @endif
                    </h1>

                    <form method="GET" action="{{ route('help.search') }}" class="mb-0">
                        <div class="input-group">
                            <input type="search" class="form-control" name="q" placeholder="Search for help articles, FAQs, and more..."
                                value="{{ request('q') }}" autocomplete="off">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i> Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @if(request('q'))
                <!-- Search Results -->
                <div class="row">
                    <div class="col-lg-8">
                        @php
                            $query = request('q');
                        @endphp

                        @if(empty($searchResults))
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i>
                                <strong>No results found</strong> for "{{ $query }}". Try different keywords or check the suggestions below.
                            </div>
                        @else
                            <p class="text-muted mb-3">Found {{ count($searchResults) }} result{{ count($searchResults) !== 1 ? 's' : '' }}</p>
                        @endif

                        @foreach($searchResults as $result)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-1">
                                            <a href="{{ $result['url'] }}" class="text-decoration-none">{{ $result['title'] }}</a>
                                        </h5>
                                        <span class="badge bg-{{ $result['type_color'] }}">{{ $result['type'] }}</span>
                                    </div>

                                    <p class="card-text text-muted small mb-2">{{ $result['description'] }}</p>

                                    @if($result['content'])
                                        <p class="card-text">{{ $result['content'] }}</p>
                                    @endif

                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            @if($result['category'])
                                                Category: {{ $result['category'] }}
                                            @endif
                                        </small>
                                        <a href="{{ $result['url'] }}" class="btn btn-outline-primary btn-sm">Read More</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if(empty($searchResults))
                            <!-- Search Suggestions -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Try these popular topics</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>Getting Started</h6>
                                            <ul class="list-unstyled">
                                                <li><a href="{{ route('help.article', 'getting-started') }}">Getting Started Guide</a></li>
                                                <li><a href="{{ route('help.article', 'creating-account') }}">Creating an Account</a></li>
                                                <li><a href="{{ route('help.article', 'platform-overview') }}">Platform Overview</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Account & Security</h6>
                                            <ul class="list-unstyled">
                                                <li><a href="{{ route('help.article', 'account-security') }}">Account Security</a></li>
                                                <li><a href="{{ route('help.article', 'password-management') }}">Password Management</a></li>
                                                <li><a href="{{ route('help.article', 'privacy-settings') }}">Privacy Settings</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Search Sidebar -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Search Tips</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    <li class="mb-2"><strong>Use specific terms:</strong> "password reset" vs "password"</li>
                                    <li class="mb-2"><strong>Try different words:</strong> "login" or "sign in"</li>
                                    <li class="mb-2"><strong>Check spelling:</strong> Make sure keywords are spelled correctly</li>
                                    <li><strong>Keep it simple:</strong> Shorter queries often work better</li>
                                </ul>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Browse by Category</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    <a href="{{ route('help.articles') }}?category=getting-started" class="list-group-item list-group-item-action">
                                        <i class="bi bi-play-circle"></i> Getting Started
                                        <span class="badge bg-secondary float-end">12</span>
                                    </a>
                                    <a href="{{ route('help.articles') }}?category=accounts" class="list-group-item list-group-item-action">
                                        <i class="bi bi-person"></i> Account Management
                                        <span class="badge bg-secondary float-end">8</span>
                                    </a>
                                    <a href="{{ route('help.articles') }}?category=security" class="list-group-item list-group-item-action">
                                        <i class="bi bi-shield-check"></i> Security & Privacy
                                        <span class="badge bg-secondary float-end">6</span>
                                    </a>
                                    <a href="{{ route('help.articles') }}?category=community" class="list-group-item list-group-item-action">
                                        <i class="bi bi-people"></i> Community
                                        <span class="badge bg-secondary float-end">4</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Still Need Help?</h5>
                            </div>
                            <div class="card-body">
                                <p class="small text-muted">Can't find what you're looking for?</p>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('help.contact') }}" class="btn btn-primary btn-sm">Contact Support</a>
                                    <a href="{{ route('help.faq') }}" class="btn btn-outline-secondary btn-sm">Browse FAQ</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Search Landing -->
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <i class="bi bi-search text-muted" style="font-size: 4rem;"></i>
                            <h2 class="h4 mt-3">Search our help center</h2>
                            <p class="text-muted">Find answers to your questions about Africoders</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="bi bi-play-circle text-primary" style="font-size: 2rem;"></i>
                                        <h5 class="card-title mt-2">Getting Started</h5>
                                        <p class="card-text small">New to Africoders? Start here for setup guides and basic tutorials.</p>
                                        <a href="{{ route('help.articles') }}?category=getting-started" class="btn btn-outline-primary btn-sm">Browse Articles</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="bi bi-shield-check text-success" style="font-size: 2rem;"></i>
                                        <h5 class="card-title mt-2">Security & Privacy</h5>
                                        <p class="card-text small">Learn about account security, privacy settings, and data protection.</p>
                                        <a href="{{ route('help.articles') }}?category=security" class="btn btn-outline-success btn-sm">Browse Articles</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="bi bi-person text-info" style="font-size: 2rem;"></i>
                                        <h5 class="card-title mt-2">Account Management</h5>
                                        <p class="card-text small">Manage your profile, preferences, and account settings.</p>
                                        <a href="{{ route('help.articles') }}?category=accounts" class="btn btn-outline-info btn-sm">Browse Articles</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="bi bi-people text-warning" style="font-size: 2rem;"></i>
                                        <h5 class="card-title mt-2">Community</h5>
                                        <p class="card-text small">Connect with others, join discussions, and network professionally.</p>
                                        <a href="{{ route('help.articles') }}?category=community" class="btn btn-outline-warning btn-sm">Browse Articles</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <p class="text-muted">Or browse our <a href="{{ route('help.faq') }}">frequently asked questions</a></p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
<style>
    .card .badge {
        font-size: 0.75rem;
    }

    .search-result-highlight {
        background-color: #fff3cd;
        padding: 0.1rem 0.2rem;
        border-radius: 0.2rem;
    }

    .list-group-item i {
        width: 1.2rem;
        margin-right: 0.5rem;
    }
</style>
@endpush


