@extends('admin.layout')

@section('title', 'KortexTools Admin - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2">KortexTools Dashboard</h1>
            <p class="text-muted">Manage tools, ratings, and usage statistics</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-muted">Total Tools</h5>
                    <h2 class="card-text">{{ $totalTools }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-muted">Categories</h5>
                    <h2 class="card-text">{{ $totalCategories }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-muted">Total Ratings</h5>
                    <h2 class="card-text">{{ $totalRatings }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-muted">Average Rating</h5>
                    <h2 class="card-text">{{ number_format($avgRating, 1) }}/5.0</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <!-- Top Tools -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Top Rated Tools</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Tool</th>
                                <th>Rating</th>
                                <th>Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topTools as $tool)
                            <tr>
                                <td><strong>{{ $tool->tool_slug }}</strong></td>
                                <td>{{ number_format($tool->avg_rating, 1) }}/5.0</td>
                                <td><span class="badge bg-secondary">{{ $tool->total_ratings }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">No ratings yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Ratings -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Ratings</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Tool</th>
                                <th>Rating</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentRatings as $rating)
                            <tr>
                                <td>{{ $rating->user?->name ?? 'Unknown' }}</td>
                                <td><small>{{ $rating->tool_slug }}</small></td>
                                <td>
                                    <div class="text-warning">
                                        @for($i = 0; $i < 5; $i++)
                                            @if($i < $rating->rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </td>
                                <td><small>{{ $rating->created_at->diffForHumans() }}</small></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No ratings yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Links -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Management</h5>
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.kortextools.tools.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-tools me-2"></i>Manage Tools
                        </a>
                        <a href="{{ route('admin.kortextools.ratings.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-star me-2"></i>View Ratings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
