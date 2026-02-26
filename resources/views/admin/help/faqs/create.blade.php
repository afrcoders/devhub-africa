@extends('admin.layout')

@section('title', 'Create FAQ')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-3">Create FAQ</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.help.dashboard') }}">Help Center</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.help.faqs.index') }}">FAQs</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </nav>
        </div>
    </div>

    <form action="{{ route('admin.help.faqs.store') }}" method="POST">
        @csrf
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
                                   name="question" value="{{ old('question') }}" required>
                            @error('question')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Answer <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('answer') is-invalid @enderror"
                                      name="answer" rows="15" required>{{ old('answer') }}</textarea>
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
                                   name="category" value="{{ old('category') }}" placeholder="general">
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Organize FAQs by category.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Display Order</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror"
                                   name="order" value="{{ old('order', 0) }}" min="0">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Lower numbers appear first.</div>
                        </div>

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

                        <hr>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Create FAQ
                            </button>
                            <a href="{{ route('admin.help.faqs.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
