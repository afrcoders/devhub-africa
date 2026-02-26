@extends('admin.layout')

@section('title', 'Manage Tools - KortexTools Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2">Manage Tools</h1>
            <p class="text-muted">View and manage KortexTools</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.kortextools.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-chart-line me-2"></i>Dashboard
            </a>
        </div>
    </div>

    <!-- Filter by Category -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="get" class="d-flex gap-2">
                <select name="category" class="form-select" style="max-width: 200px;">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat['slug'] }}" @if(request('category') === $cat['slug']) selected @endif>
                        {{ $cat['name'] }}
                    </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>
    </div>

    <!-- Tools Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tool Name</th>
                        <th>Slug</th>
                        <th>Category</th>
                        <th>Popularity</th>
                        <th>Rating</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tools as $tool)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="{{ $tool['icon'] }} fa-lg me-2 text-primary"></i>
                                <span>{{ $tool['name'] }}</span>
                            </div>
                        </td>
                        <td><code>{{ $tool['slug'] }}</code></td>
                        <td><span class="badge bg-info">{{ $tool['category'] }}</span></td>
                        <td>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar" style="width: {{ $tool['popularity'] }}%">
                                    {{ $tool['popularity'] }}%
                                </div>
                            </div>
                        </td>
                        <td>
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
                        </td>
                        <td>
                            <a href="{{ route('admin.kortextools.tools.show', $tool['slug']) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            No tools found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Summary -->
    <div class="mt-3 text-muted">
        Showing {{ count($tools) }} tool(s)
    </div>
</div>
@endsection
