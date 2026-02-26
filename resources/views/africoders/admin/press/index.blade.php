@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Manage Press Releases</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.africoders.press.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> New Press Release
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Venture</th>
                        <th>Featured</th>
                        <th>Published</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pressReleases as $press)
                        <tr>
                            <td>
                                <strong>{{ $press->title }}</strong>
                                <br>
                                <small class="text-muted">by {{ $press->author ?? 'Unknown' }}</small>
                            </td>
                            <td>
                                @php
                                    $categoryColors = [
                                        'announcement' => 'primary',
                                        'award' => 'warning',
                                        'partnership' => 'success',
                                        'funding' => 'info',
                                        'milestone' => 'secondary'
                                    ];
                                @endphp
                                <span class="badge bg-{{ $categoryColors[$press->press_category] ?? 'secondary' }}">
                                    {{ ucfirst($press->press_category) }}
                                </span>
                            </td>
                            <td>
                                @if($press->venture)
                                    <a href="{{ route('admin.africoders.ventures.edit', $press->venture_id) }}">
                                        {{ $press->venture->name }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($press->featured)
                                    <span class="badge bg-primary">Featured</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($press->published)
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.africoders.press.edit', $press->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $press->id }}" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $press->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Delete Press Release</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete "<strong>{{ $press->title }}</strong>"? This action cannot be undone.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{ route('admin.africoders.press.destroy', $press->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No press releases found. <a href="{{ route('admin.africoders.press.create') }}">Create one now</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($pressReleases->count() > 0)
        <div class="mt-3">
            {{ $pressReleases->links() }}
        </div>
    @endif
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }
</style>
@endsection
