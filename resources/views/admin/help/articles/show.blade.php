@extends('admin.layout')

@section('title', $article->title)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-3">{{ $article->title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.help.dashboard') }}">Help Center</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.help.articles.index') }}">Articles</a></li>
                            <li class="breadcrumb-item active">{{ Str::limit($article->title, 30) }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <div class="btn-group">
                        @if($article->published)
                            <a href="{{ route('help.article', $article->slug) }}" class="btn btn-outline-info" target="_blank">
                                <i class="bi bi-eye"></i> View Public
                            </a>
                        @endif
                        <a href="{{ route('admin.help.articles.edit', $article) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <button type="button" class="btn btn-danger" onclick="deleteArticle({{ $article->id }})">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Article Content -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Article Content</h5>
                        <span class="badge bg-{{ $article->published ? 'success' : 'secondary' }} fs-6">
                            {{ $article->published ? 'Published' : 'Draft' }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    @if($article->excerpt)
                        <div class="mb-4 p-3 bg-light rounded">
                            <h6 class="mb-2">Excerpt:</h6>
                            <p class="mb-0 text-muted">{{ $article->excerpt }}</p>
                        </div>
                    @endif

                    <div class="article-content">
                        {!! $article->content !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Article Information -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Article Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">Category</label>
                            <div>
                                <span class="badge bg-info fs-6">
                                    {{ ucfirst(str_replace('-', ' ', $article->category)) }}
                                </span>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">URL Slug</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ $article->slug }}" readonly>
                                <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('{{ $article->slug }}')">
                                    <i class="bi bi-clipboard"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-6">
                            <label class="form-label fw-bold">Views</label>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-eye me-2"></i>
                                <span class="fs-5">{{ number_format($article->views ?? 0) }}</span>
                            </div>
                        </div>

                        <div class="col-6">
                            <label class="form-label fw-bold">Status</label>
                            <div>
                                <span class="badge bg-{{ $article->published ? 'success' : 'secondary' }} fs-6">
                                    {{ $article->published ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                        </div>

                        <div class="col-6">
                            <label class="form-label fw-bold">Created</label>
                            <div class="small">
                                {{ $article->created_at->format('M j, Y') }}<br>
                                {{ $article->created_at->format('g:i A') }}
                            </div>
                        </div>

                        <div class="col-6">
                            <label class="form-label fw-bold">Updated</label>
                            <div class="small">
                                {{ $article->updated_at->format('M j, Y') }}<br>
                                {{ $article->updated_at->format('g:i A') }}
                            </div>
                        </div>

                        @if($article->meta_keywords)
                            <div class="col-12">
                                <label class="form-label fw-bold">SEO Keywords</label>
                                <div class="small">{{ $article->meta_keywords }}</div>
                            </div>
                        @endif

                        @if($article->meta_description)
                            <div class="col-12">
                                <label class="form-label fw-bold">SEO Description</label>
                                <div class="small">{{ $article->meta_description }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if(!$article->published)
                            <form action="{{ route('admin.help.articles.update', $article) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="published" value="1">
                                <input type="hidden" name="title" value="{{ $article->title }}">
                                <input type="hidden" name="content" value="{{ $article->content }}">
                                <input type="hidden" name="category" value="{{ $article->category }}">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-eye"></i> Publish Article
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.help.articles.update', $article) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="published" value="0">
                                <input type="hidden" name="title" value="{{ $article->title }}">
                                <input type="hidden" name="content" value="{{ $article->content }}">
                                <input type="hidden" name="category" value="{{ $article->category }}">
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="bi bi-eye-slash"></i> Unpublish Article
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('admin.help.articles.edit', $article) }}" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> Edit Article
                        </a>

                        <button type="button" class="btn btn-outline-danger" onclick="deleteArticle({{ $article->id }})">
                            <i class="bi bi-trash"></i> Delete Article
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this article? This action cannot be undone.</p>
                <div class="alert alert-warning">
                    <strong>Warning:</strong> This will permanently remove the article "<strong>{{ $article->title }}</strong>" and all its content.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" action="{{ route('admin.help.articles.destroy', $article) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Article</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function deleteArticle(articleId) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // You could add a toast notification here
        alert('Copied to clipboard: ' + text);
    });
}
</script>
@endpush

@push('styles')
<style>
.article-content {
    line-height: 1.7;
    font-size: 1.1rem;
}

.article-content h1, .article-content h2, .article-content h3 {
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.article-content p {
    margin-bottom: 1rem;
}
</style>
@endpush
