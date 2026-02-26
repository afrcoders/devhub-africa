@extends('africoders.kortextools.layout')

@section('title', 'Categories - KortexTools')
@section('meta_description', 'Browse all tool categories on KortexTools')

@section('content')
<div class="kortextools-categories">
    <!-- Header -->
    <section class="categories-header bg-primary text-white py-5">
        <div class="container text-center">
            <h1 class="display-5 fw-bold">Tool Categories</h1>
            <p class="lead">Browse {{ count($categories) }} categories of productivity tools</p>
        </div>
    </section>

    <!-- Categories Grid -->
    <div class="container my-5">
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('tools.kortex.tools.category', $category['slug']) }}" class="category-card card text-decoration-none h-100">
                    <div class="card-body">
                        <div class="category-icon mb-3">
                            <i class="{{ $category['icon'] }} fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title h4">{{ $category['name'] }}</h5>
                        <p class="card-text text-muted">{{ $category['count'] }} tools available</p>
                    </div>
                    <div class="card-footer bg-light border-top-0">
                        <span class="text-primary">Browse Tools <i class="fas fa-arrow-right ms-2"></i></span>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
.category-card {
    transition: all 0.3s ease;
    border: 1px solid #e0e0e0;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    color: inherit;
}

.category-icon {
    color: #667eea;
}
</style>
@endsection
