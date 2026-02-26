@extends('africoders.id.layouts.app')

@section('title', 'Audit Logs')

@section('content')
<style>
    :root {
        --primary-color: #0ea5e9;
        --secondary-color: #0369a1;
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
        box-shadow: 0 0 0 0.2rem rgba(14, 165, 233, 0.15);
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
        box-shadow: 0 2px 6px rgba(14, 165, 233, 0.2);
    }

    .btn-primary:hover {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
        box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
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
        font-size: 0.85rem;
    }

    .table tbody tr:hover {
        background-color: rgba(14, 165, 233, 0.03);
    }

    .badge {
        padding: 0.35rem 0.65rem;
        font-weight: 500;
        border-radius: 5px;
        font-size: 0.75rem;
    }

    .action-badge {
        background-color: rgba(99, 102, 241, 0.15);
        color: #3730a3;
    }

    .pagination .page-item.disabled .page-link {
        color: #adb5bd;
        cursor: not-allowed;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .ip-address {
        font-family: monospace;
        font-size: 0.8rem;
        color: #666;
    }
</style>

<div class="container-lg">
    <!-- Header -->
    <header class="header">
        <a href="{{ route('admin.dashboard') }}" class="back-link">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>
        <h1 class="page-title">Audit Logs</h1>
        <p class="page-subtitle">Track administrative actions and system events</p>
    </header>

    <!-- Stats -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-value">{{ $logs->total() }}</div>
            <div class="stat-label">Total Actions</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">
                @php
                    $last24h = \App\Models\AuditLog::where('created_at', '>=', now()->subDay())->count();
                @endphp
                {{ $last24h }}
            </div>
            <div class="stat-label">Last 24 Hours</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">
                @php
                    $adminCount = \App\Models\AuditLog::distinct('user_id')->count('user_id');
                @endphp
                {{ $adminCount }}
            </div>
            <div class="stat-label">Admin Users</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">
                @php
                    $actionTypes = \App\Models\AuditLog::distinct('action')->count('action');
                @endphp
                {{ $actionTypes }}
            </div>
            <div class="stat-label">Action Types</div>
        </div>
    </div>

    <!-- Filter -->
    <div class="filter-section">
        <h5 class="filter-title"><i class="bi bi-funnel"></i> Filter Logs</h5>
        <form method="GET" action="{{ route('admin.audit-logs.index') }}" class="row g-3">
            <div class="col-md-6">
                <input type="text" class="form-control" name="action" placeholder="Filter by action..." value="{{ request('action') }}">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="user_id" placeholder="Filter by user ID..." value="{{ request('user_id') }}">
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
            <h5 class="card-title m-0">Activity Log</h5>
            <span class="badge bg-light text-dark">{{ $logs->total() }} total</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ACTION</th>
                        <th>ADMIN</th>
                        <th>DETAILS</th>
                        <th>IP ADDRESS</th>
                        <th>TIMESTAMP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td>
                                <span class="badge action-badge">{{ $log->action }}</span>
                            </td>
                            <td>
                                {{ $log->user?->email ?? '—' }}
                            </td>
                            <td>
                                {{ $log->details ? Str::limit($log->details, 40) : '—' }}
                            </td>
                            <td>
                                <span class="ip-address">{{ $log->ip_address ?? '—' }}</span>
                            </td>
                            <td>{{ $log->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox" style="font-size: 2rem; color: #d1d5db;"></i>
                                <p class="mt-2 mb-0">No logs found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($logs->hasPages())
            <div class="card-footer">
                {{ $logs->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
