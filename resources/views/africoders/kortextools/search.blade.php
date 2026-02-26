@extends('africoders.kortextools.layout')

@section('title', 'Search Tools - KortexTools')
@section('meta_description', 'Search for tools on KortexTools')

@section('content')
<div class="kortextools-search">
    <!-- Header -->
    <section class="search-header bg-primary text-white py-4">
        <div class="container">
            <h1 class="display-5 fw-bold">Search Results</h1>
        </div>
    </section>

    <!-- Search Form & Results -->
    <div class="container my-5">
        <!-- Search Box -->
        <form action="{{ route('tools.kortex.search') }}" method="get" class="mb-4">
            <div class="input-group">
                <input
                    type="text"
                    name="q"
                    class="form-control form-control-lg"
                    placeholder="Search tools..."
                    value="{{ $query }}"
                    required
                >
                <button class="btn btn-primary btn-lg" type="submit">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
        </form>

        <!-- Results -->
        @if($resultsCount > 0)
        <div class="alert alert-info">
            Found <strong>{{ $resultsCount }}</strong> tool(s) matching "{{ $query }}"
        </div>

        <div class="row g-3">
            @foreach($results as $result)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('tools.kortex.tool.show', $result['slug']) }}" class="tool-card card text-decoration-none h-100">
                    <div class="card-body text-center p-4">
                        <div class="tool-icon mb-3">
                            <i class="{{ $result['icon'] }} fa-2x text-primary"></i>
                        </div>
                        <h5 class="card-title">{{ $result['name'] }}</h5>
                        <p class="card-text text-muted small">{{ $result['description'] }}</p>
                        <span class="badge bg-secondary">{{ $result['category'] }}</span>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @else
            @if($query)
            <div class="alert alert-warning text-center">
                <h5>No tools found for "{{ $query }}"</h5>
                <p class="mb-0">Try searching with different keywords or <a href="{{ route('tools.kortex.tools.index') }}">browse all tools</a></p>
            </div>
            @else
            <div class="alert alert-info text-center">
                <p class="mb-0">Enter a search term to find tools</p>
            </div>
            @endif
        @endif
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
</style>
@endsection
