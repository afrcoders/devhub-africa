@extends('africoders.id.layouts.app')

@section('title', 'Manage Users')

@section('content')
<style>
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3a0ca3;
        --light-bg: #f8f9fa;
        --border-color: #e9ecef;
    }

    body {
        background-color: #f5f7fb;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
    }

    .header {
        background-color: white;
        border-bottom: 1px solid var(--border-color);
        padding: 1rem 0;
        margin-bottom: 1rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .page-title {
        font-weight: 600;
        color: var(--secondary-color);
        margin-bottom: 0.25rem;
        font-size: 1.5rem;
    }

    .page-subtitle {
        color: #6c757d;
        font-size: 0.9rem;
        margin: 0;
    }

    .back-link {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        display: inline-block;
    }

    .back-link:hover {
        text-decoration: underline;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        background: white;
        border-radius: 8px;
        padding: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border-left: 4px solid var(--primary-color);
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--secondary-color);
        margin-bottom: 0.25rem;
    }

    .stat-label {
        color: #6c757d;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .filter-section {
        background-color: white;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .filter-title {
        font-weight: 600;
        color: #495057;
        margin-bottom: 1rem;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control, .form-select {
        border-radius: 6px;
        border: 1px solid #dee2e6;
        padding: 0.65rem 0.85rem;
        font-size: 0.9rem;
        background-color: #f8f9fa;
        transition: all 0.2s ease;
    }

    .form-control::placeholder {
        color: #adb5bd;
        font-weight: 500;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        background-color: white;
        box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.15);
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        border-radius: 6px;
        padding: 0.65rem 1.5rem;
        font-weight: 600;
        font-size: 0.9rem;
        white-space: nowrap;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(67, 97, 238, 0.2);
    }

    .btn-primary:hover {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        transform: translateY(-1px);
    }

    .card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 1rem;
        overflow: hidden;
    }

    .card-footer {
        background-color: white;
        border-top: 1px solid var(--border-color);
        padding: 1rem;
    }

    .card-header {
        background-color: white;
        border-bottom: 1px solid var(--border-color);
        padding: 1rem;
    }

    .card-title {
        font-weight: 600;
        color: var(--secondary-color);
        margin: 0;
        font-size: 1rem;
    }

    .table {
        margin-bottom: 0;
        font-size: 0.9rem;
        width: 100%;
    }

    .table thead {
        background-color: #f8f9fa;
    }

    .table thead th {
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #495057;
        padding: 0.75rem;
        white-space: nowrap;
    }

    .table tbody td {
        padding: 0.75rem;
        vertical-align: middle;
        border-bottom: 1px solid #dee2e6;
    }

    .table tbody tr:hover {
        background-color: rgba(67, 97, 238, 0.03);
    }

    .badge {
        padding: 0.35rem 0.65rem;
        font-weight: 500;
        border-radius: 5px;
        font-size: 0.75rem;
    }

    .badge-member {
        background-color: rgba(76, 201, 240, 0.15);
        color: #0c8599;
    }

    .badge-admin {
        background-color: rgba(155, 135, 245, 0.15);
        color: #5b21b6;
    }

    .status-active {
        color: #10b981;
        font-weight: 500;
    }

    .status-inactive {
        color: #ef4444;
        font-weight: 500;
    }

    .verification-status {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.85rem;
    }

    .verification-pending {
        color: #f59e0b;
    }

    .verification-verified {
        color: #10b981;
    }

    .action-btn {
        background: none;
        border: none;
        color: #6c757d;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        transition: all 0.2s;
        cursor: pointer;
        font-size: 1rem;
    }

    .action-btn:hover {
        background-color: rgba(67, 97, 238, 0.1);
        color: var(--primary-color);
    }

    .pagination .page-item.disabled .page-link {
        color: #adb5bd;
        cursor: not-allowed;
    }

    .table-responsive {
        overflow-x: auto;
    }
</style>

<div class="container-lg">
    <!-- Header -->
    <header class="header">
        <a href="{{ route('admin.dashboard') }}" class="back-link">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>
        <h1 class="page-title">Manage Users</h1>
        <p class="page-subtitle">View and manage all user accounts</p>
    </header>

    <!-- Stats -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-value">{{ $users->total() }}</div>
            <div class="stat-label">Total Users</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">
                @php
                    $activeCount = \App\Models\User::where('is_active', true)->count();
                @endphp
                {{ $activeCount }}
            </div>
            <div class="stat-label">Active Users</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">
                @php
                    $adminCount = \App\Models\User::where('role', 'admin')->count();
                @endphp
                {{ $adminCount }}
            </div>
            <div class="stat-label">Admin Users</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">
                @php
                    $pendingCount = \App\Models\User::whereNull('email_verified_at')->count();
                @endphp
                {{ $pendingCount }}
            </div>
            <div class="stat-label">Pending Verification</div>
        </div>
    </div>

    <!-- Filter -->
    <div class="filter-section">
        <h5 class="filter-title"><i class="bi bi-funnel"></i> Filter Users</h5>
        <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3">
            <div class="col-md-6">
                <input type="text" class="form-control" name="search" placeholder="Search email, username, or name..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select class="form-select" name="role">
                    <option value="">All Roles</option>
                    <option value="member" {{ request('role') === 'member' ? 'selected' : '' }}>Member</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title m-0">User Accounts</h5>
            <span class="badge bg-light text-dark">{{ $users->total() }} total</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>EMAIL</th>
                        <th>NAME</th>
                        <th>ROLE</th>
                        <th>STATUS</th>
                        <th>VERIFIED</th>
                        <th style="width: 80px;">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->name ?? '—' }}</td>
                            <td>
                                @if ($user->role === 'admin')
                                    <span class="badge badge-admin">Admin</span>
                                @else
                                    <span class="badge badge-member">Member</span>
                                @endif
                            </td>
                            <td>
                                @if ($user->is_active)
                                    <span class="status-active"><i class="bi bi-dot"></i> Active</span>
                                @else
                                    <span class="status-inactive"><i class="bi bi-dot"></i> Inactive</span>
                                @endif
                            </td>
                            <td>
                                @if ($user->email_verified_at)
                                    <span class="verification-status verification-verified">
                                        <i class="bi bi-check-circle"></i> Verified
                                    </span>
                                @else
                                    <span class="verification-status verification-pending">
                                        <i class="bi bi-clock"></i> Pending
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.users.show', $user->id) }}" class="action-btn" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox" style="font-size: 2rem; color: #d1d5db;"></i>
                                <p class="mt-2 mb-0">No users found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="card-footer">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
