@extends('admin.layout')

@section('title', 'Audit Logs')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-3">Audit Logs</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Audit Logs</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Action</label>
                            <select class="form-select" name="action">
                                <option value="">All Actions</option>
                                <option value="login" {{ request('action') === 'login' ? 'selected' : '' }}>Login</option>
                                <option value="logout" {{ request('action') === 'logout' ? 'selected' : '' }}>Logout</option>
                                <option value="register" {{ request('action') === 'register' ? 'selected' : '' }}>Register</option>
                                <option value="profile_update" {{ request('action') === 'profile_update' ? 'selected' : '' }}>Profile Update</option>
                                <option value="password_change" {{ request('action') === 'password_change' ? 'selected' : '' }}>Password Change</option>
                                <option value="verification_submit" {{ request('action') === 'verification_submit' ? 'selected' : '' }}>Verification Submit</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Date Range</label>
                            <select class="form-select" name="date_range">
                                <option value="">All Time</option>
                                <option value="today" {{ request('date_range') === 'today' ? 'selected' : '' }}>Today</option>
                                <option value="week" {{ request('date_range') === 'week' ? 'selected' : '' }}>This Week</option>
                                <option value="month" {{ request('date_range') === 'month' ? 'selected' : '' }}>This Month</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Search</label>
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                                   placeholder="Search by user, IP, or details...">
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

    <!-- Audit Logs List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">System Activity Logs</h5>
                </div>
                <div class="card-body p-0">
                    @if($logs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Time</th>
                                        <th>User</th>
                                        <th>Action</th>
                                        <th>IP Address</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                        <tr>
                                            <td>
                                                <div>
                                                    {{ $log->created_at->format('M j, Y') }}
                                                    <br>
                                                    <small class="text-muted">{{ $log->created_at->format('g:i A') }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                @if($log->user)
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar me-2">
                                                            <span class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                                  style="width: 32px; height: 32px; font-size: 0.75rem;">
                                                                {{ strtoupper(substr($log->user->username ?? $log->user->email, 0, 2)) }}
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold small">{{ $log->user->username ?? $log->user->email }}</div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted small">System</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{
                                                    str_contains($log->action, 'login') ? 'success' :
                                                    (str_contains($log->action, 'logout') ? 'secondary' :
                                                    (str_contains($log->action, 'error') ? 'danger' : 'primary'))
                                                }}">
                                                    {{ str_replace('_', ' ', ucfirst($log->action)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <small class="font-monospace">{{ $log->ip_address ?? 'N/A' }}</small>
                                            </td>
                                            <td>
                                                @if($log->details)
                                                    <small class="text-muted">{{ Str::limit($log->details, 100) }}</small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-journal-text" style="font-size: 3rem; color: #6c757d;"></i>
                            <h5 class="mt-3 text-muted">No audit logs found</h5>
                            <p class="text-muted">Try adjusting your filters or search criteria.</p>
                        </div>
                    @endif
                </div>
                @if($logs->hasPages())
                    <div class="card-footer">
                        {{ $logs->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
