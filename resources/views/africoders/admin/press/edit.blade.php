@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Edit Press Release: {{ $press->title }}</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.africoders.press.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.africoders.press.update', $press->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Press Release Content</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $press->title) }}" placeholder="Enter press release title" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Excerpt <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror" name="excerpt" rows="3" placeholder="Brief summary (will appear in listings)" required>{{ old('excerpt', $press->excerpt) }}</textarea>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Full Content <span class="text-danger">*</span></label>
                            <textarea class="form-control summernote @error('content') is-invalid @enderror" name="content" required>{{ old('content', $press->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Author <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('author') is-invalid @enderror" name="author" value="{{ old('author', $press->author) }}" placeholder="Author name" required>
                            @error('author')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Featured Image</label>
                            @if($press->featured_image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $press->featured_image) }}" alt="{{ $press->title }}" style="max-width: 300px; max-height: 200px;" class="img-thumbnail">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('featured_image') is-invalid @enderror" name="featured_image" accept="image/*">
                            <small class="text-muted">Recommended: 1200x600px</small>
                            @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Press Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('press_category') is-invalid @enderror" name="press_category" required>
                                <option value="">Select category</option>
                                <option value="announcement" {{ old('press_category', $press->press_category) === 'announcement' ? 'selected' : '' }}>Announcement</option>
                                <option value="award" {{ old('press_category', $press->press_category) === 'award' ? 'selected' : '' }}>Award</option>
                                <option value="partnership" {{ old('press_category', $press->press_category) === 'partnership' ? 'selected' : '' }}>Partnership</option>
                                <option value="funding" {{ old('press_category', $press->press_category) === 'funding' ? 'selected' : '' }}>Funding</option>
                                <option value="milestone" {{ old('press_category', $press->press_category) === 'milestone' ? 'selected' : '' }}>Milestone</option>
                            </select>
                            @error('press_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Related Venture</label>
                            <select class="form-select @error('venture_id') is-invalid @enderror" name="venture_id">
                                <option value="">-- None --</option>
                                @foreach($ventures as $venture)
                                    <option value="{{ $venture->id }}" {{ old('venture_id', $press->venture_id) === (string)$venture->id ? 'selected' : '' }}>
                                        {{ $venture->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('venture_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" {{ old('featured', $press->featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="featured">
                                    Feature on homepage
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="published" name="published" value="1" {{ old('published', $press->published) ? 'checked' : '' }}>
                                <label class="form-check-label" for="published">
                                    Published
                                </label>
                            </div>
                        </div>

                        @if($press->published_at)
                            <div class="alert alert-info" role="alert">
                                Published on {{ $press->published_at->format('M d, Y H:i') }}
                            </div>
                        @endif

                        <hr>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-lg"></i> Update Press Release
                            </button>
                            <a href="{{ route('admin.africoders.press.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>

<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['codeview', 'help']]
            ]
        });
    });
</script>
@endsection
