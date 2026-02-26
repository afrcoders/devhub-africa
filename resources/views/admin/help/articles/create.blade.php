@extends('admin.layout')

@section('title', 'Create Article')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-3">Create Article</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.help.dashboard') }}">Help Center</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.help.articles.index') }}">Articles</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </nav>
        </div>
    </div>

    <form action="{{ route('admin.help.articles.store') }}" method="POST">
        @csrf
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
                                   name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                   name="slug" value="{{ old('slug') }}"
                                   placeholder="Auto-generated from title if empty">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">URL-friendly version of the title. Leave blank to auto-generate.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Excerpt</label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                      name="excerpt" rows="3">{{ old('excerpt') }}</textarea>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Brief summary shown in article listings.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Content <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      name="content" rows="15" required>{{ old('content') }}</textarea>
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
                                <option value="0" {{ old('published') == '0' ? 'selected' : '' }}>Draft</option>
                                <option value="1" {{ old('published') == '1' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('published')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('category') is-invalid @enderror" name="category" required>
                                <option value="">Select Category</option>
                                <option value="getting-started" {{ old('category') === 'getting-started' ? 'selected' : '' }}>Getting Started</option>
                                <option value="security" {{ old('category') === 'security' ? 'selected' : '' }}>Security</option>
                                <option value="accounts" {{ old('category') === 'accounts' ? 'selected' : '' }}>Accounts</option>
                                <option value="privacy" {{ old('category') === 'privacy' ? 'selected' : '' }}>Privacy</option>
                                <option value="community" {{ old('category') === 'community' ? 'selected' : '' }}>Community</option>
                                <option value="general" {{ old('category') === 'general' ? 'selected' : '' }}>General</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror"
                                   name="meta_keywords" value="{{ old('meta_keywords') }}"
                                   placeholder="SEO keywords, comma separated">
                            @error('meta_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                      name="meta_description" rows="3"
                                      placeholder="SEO description">{{ old('meta_description') }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg"></i> Create Article
                            </button>
                            <a href="{{ route('admin.help.articles.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Back to Articles
                            </a>
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
                            <p class="text-muted">Start typing to see a preview...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
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

// Simple preview functionality
document.querySelector('textarea[name="content"]').addEventListener('input', function() {
    const content = this.value;
    const previewDiv = document.getElementById('preview-content');

    if (content.trim()) {
        // Simple markdown preview (you can enhance this with a proper markdown parser)
        const preview = content
            .replace(/^# (.*$)/gm, '<h1>$1</h1>')
            .replace(/^## (.*$)/gm, '<h2>$1</h2>')
            .replace(/^### (.*$)/gm, '<h3>$1</h3>')
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\*(.*?)\*/g, '<em>$1</em>')
            .replace(/\n/g, '<br>');
        previewDiv.innerHTML = preview;
    } else {
        previewDiv.innerHTML = '<p class="text-muted">Start typing to see a preview...</p>';
    }
});
</script>
@endpush
