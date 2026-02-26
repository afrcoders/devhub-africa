@extends('africoders.kortextools.layout')

@section('title', $category . ' - KortexTools')
@section('meta_description', 'Free ' . strtolower($category) . ' tools for developers and creators')

@section('content')
<div class="kortextools-category">
    <!-- Header -->
    <section class="category-header bg-primary text-white py-5">
        <div class="container text-center">
            <h1 class="display-5 fw-bold">{{ $category }}</h1>
            <p class="lead">{{ count($tools) }} free tools to help you with {{ strtolower($category) }}</p>
        </div>
    </section>

    <!-- Tools Grid -->
    <div class="container my-5">
        <div class="row g-3">
            @foreach($tools as $tool)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('tools.kortex.tool.show', $tool->slug) }}" class="tool-card card text-decoration-none h-100">
                    <div class="card-body text-center p-4">
                        <div class="tool-icon mb-3">
                            <i class="{{ $tool->icon }} fa-2x text-primary"></i>
                        </div>
                        <h5 class="card-title">{{ $tool->name }}</h5>
                        <p class="card-text text-muted small">{{ $tool->description }}</p>

                        <!-- Rating -->
                        <div class="tool-rating mt-3">
                            <div class="text-warning">
                                @for($i = 0; $i < 5; $i++)
                                    @if($i < floor($tool->rating))
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                                <small class="text-muted ms-1">({{ $tool->rating_count }})</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <!-- Back to Categories -->
        <div class="text-center mt-5">
            <a href="{{ route('tools.kortex.categories.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-chevron-left"></i> Back to Categories
            </a>
        </div>
    </div>
</div>

<style>
.tool-card {
    transition: all 0.3s ease;
    border: 1px solid #e0e0e0;
}

.tool-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    color: inherit;
}

.tool-icon {
    color: #667eea;
}
</style>
@endsection
