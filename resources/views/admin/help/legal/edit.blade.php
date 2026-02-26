@extends('admin.layout')

@section('title', 'Edit Legal Document')

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
                    <h1 class="h3 mb-3">Edit Legal Document</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.help.dashboard') }}">Help Center</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.help.legal.index') }}">Legal Documents</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    @if($document->published)
                        <a href="{{ route('help.legal', $document->slug) }}" class="btn btn-outline-info me-2" target="_blank">
                            <i class="bi bi-eye"></i> View Document
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.help.legal.update', $document) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Document Content</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   name="title" value="{{ old('title', $document->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                   name="slug" value="{{ old('slug', $document->slug) }}">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">URL-friendly version of the title (e.g., terms).</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Content <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      name="content" rows="20" required>{{ old('content', $document->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Main document content. Supports HTML formatting.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Document Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select @error('published') is-invalid @enderror" name="published">
                                <option value="0" {{ old('published', $document->published) == '0' ? 'selected' : '' }}>Draft</option>
                                <option value="1" {{ old('published', $document->published) == '1' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('published')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Published documents are visible to the public.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Version</label>
                            <input type="text" class="form-control @error('version') is-invalid @enderror"
                                   name="version" value="{{ old('version', $document->version) }}" placeholder="1.0">
                            @error('version')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Document version number.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Effective Date</label>
                            <input type="date" class="form-control @error('effective_date') is-invalid @enderror"
                                   name="effective_date" value="{{ old('effective_date', $document->effective_date) }}">
                            @error('effective_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">When this version becomes effective.</div>
                        </div>

                        <hr>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Save Changes
                            </button>
                            <a href="{{ route('admin.help.legal.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Document Info -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">Document Info</h6>
                    </div>
                    <div class="card-body small">
                        <div class="mb-2">
                            <strong>Created:</strong><br>
                            {{ $document->created_at->format('M j, Y g:i A') }}
                        </div>
                        <div>
                            <strong>Updated:</strong><br>
                            {{ $document->updated_at->format('M j, Y g:i A') }}
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
            ],
            callbacks: {
                onImageUpload: function(files) {
                    // Handle image uploads if needed
                    for(let i = files.length - 1; i >= 0; i--) {
                        insertImage(files[i]);
                    }
                }
            }
        });

        function insertImage(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const image = $('<img>').attr('src', e.target.result).css('max-width', '100%');
                $('textarea[name="content"]').summernote('insertNode', image[0]);
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
