@extends('admin.layout')

@section('title', 'Tool Ratings - KortexTools Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2">Tool Ratings</h1>
            <p class="text-muted">View and manage tool ratings</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.kortextools.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-chart-line me-2"></i>Dashboard
            </a>
        </div>
    </div>

    <!-- Recent Ratings -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Recent Ratings</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>User</th>
                        <th>Tool</th>
                        <th>Rating</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ratings as $rating)
                    <tr>
                        <td>
                            @if($rating->user)
                                <strong>{{ $rating->user->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $rating->user->email }}</small>
                            @else
                                <span class="text-muted">Unknown User</span>
                            @endif
                        </td>
                        <td><code>{{ $rating->tool_slug }}</code></td>
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
                        <td>{{ $rating->created_at->format('M d, Y H:i') }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.kortextools.ratings.destroy', $rating->id) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this rating?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            No ratings found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $ratings->links() }}
        </div>
    </div>

    <!-- Top Rated Tools -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Top Rated Tools</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tool</th>
                        <th>Average Rating</th>
                        <th>Total Ratings</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topRated as $tool)
                    <tr>
                        <td>
                            <a href="{{ route('admin.kortextools.ratings.tool', $tool->tool_slug) }}">
                                <code>{{ $tool->tool_slug }}</code>
                            </a>
                        </td>
                        <td>
                            <div class="text-warning">
                                @for($i = 0; $i < 5; $i++)
                                    @if($i < floor($tool->avg_rating))
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                                <strong class="text-dark ms-2">{{ number_format($tool->avg_rating, 1) }}/5.0</strong>
                            </div>
                        </td>
                        <td><span class="badge bg-secondary">{{ $tool->total_ratings }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">
                            No ratings found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
