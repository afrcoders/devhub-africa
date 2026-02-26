@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Create Venture</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.africoders.ventures.index') }}" class="btn btn-outline-secondary">
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

    <form action="{{ route('admin.africoders.ventures.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Venture Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Venture Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Enter venture name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Website URL</label>
                                <input type="url" class="form-control @error('website_url') is-invalid @enderror" name="website_url" value="{{ old('website_url') }}" placeholder="https://example.com">
                                @error('website_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Launch Year</label>
                                <input type="number" class="form-control @error('launch_year') is-invalid @enderror" name="launch_year" value="{{ old('launch_year') }}" min="2000" max="{{ now()->year + 1 }}">
                                @error('launch_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Short Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="2" placeholder="Brief description (will appear in listings)" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Full Content <span class="text-danger">*</span></label>
                            <textarea class="form-control summernote @error('content') is-invalid @enderror" name="content" required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mission</label>
                            <textarea class="form-control @error('mission') is-invalid @enderror" name="mission" rows="3" placeholder="Venture's mission statement">{{ old('mission') }}</textarea>
                            @error('mission')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Vision</label>
                            <textarea class="form-control @error('vision') is-invalid @enderror" name="vision" rows="3" placeholder="Venture's vision for the future">{{ old('vision') }}</textarea>
                            @error('vision')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Media</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Logo</label>
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" accept="image/*">
                            <small class="text-muted">Recommended: 200x200px</small>
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Featured Image</label>
                            <input type="file" class="form-control @error('featured_image') is-invalid @enderror" name="featured_image" accept="image/*">
                            <small class="text-muted">Recommended: 1200x600px</small>
                            @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Additional Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Team Members (JSON)</label>
                            <textarea class="form-control @error('team_members') is-invalid @enderror" name="team_members" rows="3" placeholder='[{"name": "John Doe", "role": "CEO"}, {"name": "Jane Smith", "role": "CTO"}]'>{{ old('team_members') }}</textarea>
                            <small class="text-muted">JSON format with name and role fields</small>
                            @error('team_members')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tech Stack (JSON)</label>
                            <textarea class="form-control @error('tech_stack') is-invalid @enderror" name="tech_stack" rows="3" placeholder='["Laravel", "Vue.js", "PostgreSQL", "Docker"]'>{{ old('tech_stack') }}</textarea>
                            <small class="text-muted">JSON array format</small>
                            @error('tech_stack')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Metrics (JSON)</label>
                            <textarea class="form-control @error('metrics') is-invalid @enderror" name="metrics" rows="3" placeholder='{"users": "10K+", "growth": "250%", "funding": "$2M"}'>{{ old('metrics') }}</textarea>
                            <small class="text-muted">JSON object format with key-value pairs</small>
                            @error('metrics')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Venture Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                                <option value="">Select status</option>
                                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="incubating" {{ old('status') === 'incubating' ? 'selected' : '' }}>Incubating</option>
                                <option value="launched" {{ old('status') === 'launched' ? 'selected' : '' }}>Launched</option>
                                <option value="exited" {{ old('status') === 'exited' ? 'selected' : '' }}>Exited</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="featured">
                                    Feature on homepage
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="published" name="published" value="1" {{ old('published') ? 'checked' : '' }}>
                                <label class="form-check-label" for="published">
                                    Publish immediately
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Display Order</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" name="order" value="{{ old('order', 0) }}" min="0">
                            <small class="text-muted">Lower numbers appear first</small>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-lg"></i> Create Venture
                            </button>
                            <a href="{{ route('admin.africoders.ventures.index') }}" class="btn btn-outline-secondary">Cancel</a>
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
