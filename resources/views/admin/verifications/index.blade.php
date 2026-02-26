@extends('admin.layout')

@section('title', 'Verifications')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-3">Verification Management</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Verifications</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small">Pending</div>
                            <div class="h4">{{ $verifications->where('status', 'pending')->count() }}</div>
                        </div>
                        <i class="bi bi-clock-history fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small">Approved</div>
                            <div class="h4">{{ $verifications->where('status', 'approved')->count() }}</div>
                        </div>
                        <i class="bi bi-check-circle fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small">Rejected</div>
                            <div class="h4">{{ $verifications->where('status', 'rejected')->count() }}</div>
                        </div>
                        <i class="bi bi-x-circle fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small">Total</div>
                            <div class="h4">{{ $verifications->count() }}</div>
                        </div>
                        <i class="bi bi-file-check fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="type">
                                <option value="">All Types</option>
                                <option value="identity" {{ request('type') === 'identity' ? 'selected' : '' }}>Identity</option>
                                <option value="business" {{ request('type') === 'business' ? 'selected' : '' }}>Business</option>
                                <option value="instructor" {{ request('type') === 'instructor' ? 'selected' : '' }}>Instructor</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Search</label>
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                                   placeholder="Search by user or details...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Verifications List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Verification Requests</h5>
                </div>
                <div class="card-body p-0">
                    @if($verifications->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>User</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Submitted</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($verifications as $verification)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-3">
                                                        <span class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                              style="width: 40px; height: 40px;">
                                                            {{ strtoupper(substr($verification->user->username ?? $verification->user->email, 0, 2)) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $verification->user->full_name ?? $verification->user->username }}</div>
                                                        <small class="text-muted">{{ $verification->user->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ ucfirst($verification->type) }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{
                                                    $verification->status === 'approved' ? 'success' :
                                                    ($verification->status === 'rejected' ? 'danger' : 'warning')
                                                }}">
                                                    {{ ucfirst($verification->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ $verification->created_at->format('M j, Y') }}
                                                    <br>
                                                    <small class="text-muted">{{ $verification->created_at->diffForHumans() }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.verifications.show', $verification) }}"
                                                       class="btn btn-outline-primary" title="View Details">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    @if($verification->status === 'pending')
                                                        <form method="POST" action="{{ route('admin.verifications.approve', $verification) }}" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-success" title="Approve">
                                                                <i class="bi bi-check"></i>
                                                            </button>
                                                        </form>
                                                        <form method="POST" action="{{ route('admin.verifications.reject', $verification) }}" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger" title="Reject">
                                                                <i class="bi bi-x"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-file-check" style="font-size: 3rem; color: #6c757d;"></i>
                            <h5 class="mt-3 text-muted">No verification requests found</h5>
                            <p class="text-muted">Try adjusting your filters or search criteria.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
