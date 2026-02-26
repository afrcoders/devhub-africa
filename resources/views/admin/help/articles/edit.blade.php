@extends('admin.layout')

@section('title', 'Edit Article')

@push('styles')
<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-3">Edit Article</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.help.dashboard') }}">Help Center</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.help.articles.index') }}">Articles</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    @if($article->published)
                        <a href="{{ route('help.article', $article->slug) }}" class="btn btn-outline-info me-2" target="_blank">
                            <i class="bi bi-eye"></i> View Article
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.help.articles.update', $article) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Article Content</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   name="title" value="{{ old('title', $article->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                   name="slug" value="{{ old('slug', $article->slug) }}">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">URL-friendly version of the title.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Excerpt</label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                      name="excerpt" rows="3">{{ old('excerpt', $article->excerpt) }}</textarea>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Brief summary shown in article listings.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Content <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      name="content" rows="15" required>{{ old('content', $article->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Main article content. Supports Markdown formatting.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Article Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select @error('published') is-invalid @enderror" name="published">
                                <option value="0" {{ old('published', $article->published) == '0' ? 'selected' : '' }}>Draft</option>
                                <option value="1" {{ old('published', $article->published) == '1' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('published')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('category') is-invalid @enderror" name="category" required>
                                <option value="">Select Category</option>
                                <option value="getting-started" {{ old('category', $article->category) === 'getting-started' ? 'selected' : '' }}>Getting Started</option>
                                <option value="security" {{ old('category', $article->category) === 'security' ? 'selected' : '' }}>Security</option>
                                <option value="accounts" {{ old('category', $article->category) === 'accounts' ? 'selected' : '' }}>Accounts</option>
                                <option value="privacy" {{ old('category', $article->category) === 'privacy' ? 'selected' : '' }}>Privacy</option>
                                <option value="community" {{ old('category', $article->category) === 'community' ? 'selected' : '' }}>Community</option>
                                <option value="general" {{ old('category', $article->category) === 'general' ? 'selected' : '' }}>General</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror"
                                   name="meta_keywords" value="{{ old('meta_keywords', $article->meta_keywords) }}"
                                   placeholder="SEO keywords, comma separated">
                            @error('meta_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                      name="meta_description" rows="3"
                                      placeholder="SEO description">{{ old('meta_description', $article->meta_description) }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg"></i> Update Article
                            </button>
                            <a href="{{ route('admin.help.articles.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Back to Articles
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Article Info -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">Article Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-2 small">
                            <div class="col-6"><strong>Views:</strong></div>
                            <div class="col-6">{{ number_format($article->views ?? 0) }}</div>

                            <div class="col-6"><strong>Created:</strong></div>
                            <div class="col-6">{{ $article->created_at->format('M j, Y g:i A') }}</div>

                            <div class="col-6"><strong>Updated:</strong></div>
                            <div class="col-6">{{ $article->updated_at->format('M j, Y g:i A') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Preview Card -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">Preview</h6>
                    </div>
                    <div class="card-body">
                        <div id="preview-content">
                            <!-- Initial preview will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<!-- Summernote JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.js"></script>

<script>
$(document).ready(function() {
    // Initialize Summernote on content textarea
    $('textarea[name="content"]').summernote({
        height: 400,
        tabsize: 2,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'strikethrough']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['codeview', 'help']]
        ]
    });

    // Auto-generate slug from title
    document.querySelector('input[name="title"]').addEventListener('input', function() {
        const title = this.value;
        const slugInput = document.querySelector('input[name="slug"]');

        if (!slugInput.hasAttribute('data-manual')) {
            const slug = title.toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
            slugInput.value = slug;
        }
    });

    // Mark slug as manually edited
    document.querySelector('input[name="slug"]').addEventListener('input', function() {
        this.setAttribute('data-manual', 'true');
    });
});
</script>
@endpush
