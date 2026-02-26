@extends('admin.layout')

@section('title', 'Help Center Management')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-3">Help Center Management</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                    <li class="breadcrumb-item active">Help Center</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-1">{{ $stats['total_messages'] }}</h5>
                            <p class="card-text mb-0">Total Messages</p>
                        </div>
                        <div class="ms-3">
                            <i class="bi bi-envelope-fill" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-primary border-0">
                    <a href="{{ route('admin.help.messages.index') }}" class="text-white text-decoration-none">
                        View Messages <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-1">{{ $stats['unread_messages'] }}</h5>
                            <p class="card-text mb-0">Unread Messages</p>
                        </div>
                        <div class="ms-3">
                            <i class="bi bi-envelope-exclamation-fill" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-warning border-0">
                    <a href="{{ route('admin.help.messages.index', ['status' => 'pending']) }}" class="text-white text-decoration-none">
                        View Pending <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-1">{{ $stats['published_articles'] }}</h5>
                            <p class="card-text mb-0">Published Articles</p>
                        </div>
                        <div class="ms-3">
                            <i class="bi bi-file-text-fill" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-success border-0">
                    <a href="{{ route('admin.help.articles.index') }}" class="text-white text-decoration-none">
                        Manage Articles <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-1">{{ $stats['active_faqs'] }}</h5>
                            <p class="card-text mb-0">Active FAQs</p>
                        </div>
                        <div class="ms-3">
                            <i class="bi bi-question-circle-fill" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-info border-0">
                    <a href="{{ route('admin.help.faqs.index') }}" class="text-white text-decoration-none">
                        Manage FAQs <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.help.articles.create') }}" class="btn btn-primary w-100">
                                <i class="bi bi-plus-circle"></i> New Article
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.help.faqs.create') }}" class="btn btn-success w-100">
                                <i class="bi bi-plus-circle"></i> New FAQ
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.help.legal.create') }}" class="btn btn-info w-100">
                                <i class="bi bi-plus-circle"></i> New Legal Doc
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.help.messages.index', ['status' => 'pending']) }}" class="btn btn-warning w-100">
                                <i class="bi bi-inbox"></i> Review Messages
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Messages</h5>
                    <a href="{{ route('admin.help.messages.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    @if($stats['recent_messages']->count() > 0)
                        @foreach($stats['recent_messages'] as $message)
                            <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <h6 class="mb-0">{{ $message->name }}</h6>
                                        <span class="badge bg-{{ $message->status === 'pending' ? 'warning' : 'success' }}">
                                            {{ ucfirst($message->status) }}
                                        </span>
                                    </div>
                                    <p class="text-muted small mb-1">{{ $message->subject }}</p>
                                    <p class="text-muted small mb-0">
                                        <i class="bi bi-clock"></i> {{ $message->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="ms-3">
                                    <a href="{{ route('admin.help.messages.show', $message) }}" class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center py-4">No recent messages</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Popular Articles</h5>
                    <a href="{{ route('admin.help.articles.index') }}" class="btn btn-sm btn-outline-primary">Manage All</a>
                </div>
                <div class="card-body">
                    @if($stats['popular_articles']->count() > 0)
                        @foreach($stats['popular_articles'] as $article)
                            <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $article->title }}</h6>
                                    <p class="text-muted small mb-1">
                                        <span class="badge bg-secondary">{{ ucfirst($article->category) }}</span>
                                        {{ $article->views ?? 0 }} views
                                    </p>
                                    <p class="text-muted small mb-0">
                                        <i class="bi bi-clock"></i> {{ $article->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="ms-3">
                                    <a href="{{ route('admin.help.articles.edit', $article) }}" class="btn btn-sm btn-outline-primary">
                                        Edit
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center py-4">No published articles</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .card-footer {
        border-top: none;
        padding: 0.75rem 1.25rem;
    }

    .border-bottom:last-child {
        border-bottom: none !important;
        padding-bottom: 0 !important;
        margin-bottom: 0 !important;
    }
</style>
@endpush
