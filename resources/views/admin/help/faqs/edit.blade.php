@extends('admin.layout')

@section('title', 'Edit FAQ')

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
                    <h1 class="h3 mb-3">Edit FAQ</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.help.dashboard') }}">Help Center</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.help.faqs.index') }}">FAQs</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.help.faqs.update', $faq) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">FAQ Content</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Question <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('question') is-invalid @enderror"
                                   name="question" value="{{ old('question', $faq->question) }}" required>
                            @error('question')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Answer <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('answer') is-invalid @enderror"
                                      name="answer" rows="15" required>{{ old('answer', $faq->answer) }}</textarea>
                            @error('answer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Answer to the frequently asked question.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">FAQ Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <input type="text" class="form-control @error('category') is-invalid @enderror"
                                   name="category" value="{{ old('category', $faq->category) }}" placeholder="general">
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Organize FAQs by category.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Display Order</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror"
                                   name="order" value="{{ old('order', $faq->order) }}" min="0">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Lower numbers appear first.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select @error('published') is-invalid @enderror" name="published">
                                <option value="0" {{ old('published', $faq->published) == '0' ? 'selected' : '' }}>Draft</option>
                                <option value="1" {{ old('published', $faq->published) == '1' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('published')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Save Changes
                            </button>
                            <a href="{{ route('admin.help.faqs.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>

                <!-- FAQ Info -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">FAQ Stats</h6>
                    </div>
                    <div class="card-body small">
                        <div class="mb-2">
                            <strong>Helpful Votes:</strong><br>
                            <span class="text-success">{{ $faq->helpful_votes }}</span>
                        </div>
                        <div class="mb-2">
                            <strong>Unhelpful Votes:</strong><br>
                            <span class="text-danger">{{ $faq->unhelpful_votes }}</span>
                        </div>
                        <div class="mb-2">
                            <strong>Created:</strong><br>
                            {{ $faq->created_at->format('M j, Y g:i A') }}
                        </div>
                        <div>
                            <strong>Updated:</strong><br>
                            {{ $faq->updated_at->format('M j, Y g:i A') }}
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
        $('textarea[name="answer"]').summernote({
            height: 300,
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
    });
</script>
@endpush
