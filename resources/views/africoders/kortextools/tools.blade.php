@extends('africoders.kortextools.layout')

@section('title', 'All Tools - KortexTools')
@section('meta_description', '100+ free online developer and productivity tools')

@section('content')
<div class="kortextools-tools">
    <!-- Header -->
    <section class="tools-header bg-primary text-white py-4">
        <div class="container">
            <h1 class="display-5 fw-bold mb-0">All Tools</h1>
            <p class="lead text-white-50">{{ count($allTools) }} tools to boost your productivity</p>
        </div>
    </section>

    <!-- Filters & Tools -->
    <div class="container my-5">
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-md-3 mb-4">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Categories</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('tools.kortex.tools.index') }}" class="list-group-item list-group-item-action">
                            All Tools
                        </a>
                        @foreach($categories as $cat)
                        <a href="{{ route('tools.kortex.tools.category', \Illuminate\Support\Str::slug($cat['name'])) }}" class="list-group-item list-group-item-action">
                            {{ $cat['name'] }}
                            <span class="badge bg-secondary float-end">{{ $cat['count'] }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Tools Grid -->
            <div class="col-md-9">
                <div class="row g-3">
                    @forelse($allTools as $tool)
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('tools.kortex.tool.show', $tool['slug']) }}" class="tool-card card text-decoration-none h-100">
                            <div class="card-body text-center p-4">
                                <div class="tool-icon mb-3">
                                    <i class="{{ $tool['icon'] }} fa-2x text-primary"></i>
                                </div>
                                <h5 class="card-title">{{ $tool['name'] }}</h5>
                                <p class="card-text text-muted small">{{ $tool['description'] }}</p>

                                <!-- Rating -->
                                <div class="tool-rating mt-3">
                                    <div class="text-warning">
                                        @for($i = 0; $i < 5; $i++)
                                            @if($i < floor($tool['rating']))
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                        <small class="text-muted">({{ $tool['rating_count'] }})</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            No tools found. Try a different search.
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
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
