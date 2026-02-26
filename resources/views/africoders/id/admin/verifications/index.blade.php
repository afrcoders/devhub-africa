@extends('africoders.id.layouts.app')

@section('title', 'Manage Verifications')

@section('content')
<style>
    :root {
        --primary-color: #10b981;
        --secondary-color: #047857;
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
        box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.15);
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
        box-shadow: 0 2px 6px rgba(16, 185, 129, 0.2);
    }

    .btn-primary:hover {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
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
        background-color: rgba(16, 185, 129, 0.03);
    }

    .badge {
        padding: 0.35rem 0.65rem;
        font-weight: 500;
        border-radius: 5px;
        font-size: 0.75rem;
    }

    .badge-pending {
        background-color: rgba(245, 158, 11, 0.15);
        color: #92400e;
    }

    .badge-approved {
        background-color: rgba(16, 185, 129, 0.15);
        color: #065f46;
    }

    .badge-rejected {
        background-color: rgba(239, 68, 68, 0.15);
        color: #7f1d1d;
    }

    .badge-identity {
        background-color: rgba(147, 112, 219, 0.15);
        color: #4c1d95;
    }

    .badge-business {
        background-color: rgba(59, 130, 246, 0.15);
        color: #1e3a8a;
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
        background-color: rgba(16, 185, 129, 0.1);
        color: var(--primary-color);
    }

    .action-btn.danger:hover {
        background-color: rgba(239, 68, 68, 0.1);
        color: #ef4444;
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
        <h1 class="page-title">Manage Verifications</h1>
        <p class="page-subtitle">Review and manage user verification requests</p>
    </header>

    <!-- Stats -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-value">{{ $verifications->total() }}</div>
            <div class="stat-label">Total Submissions</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">
                @php
                    $pendingCount = \App\Models\Verification::where('status', 'pending')->count();
                @endphp
                {{ $pendingCount }}
            </div>
            <div class="stat-label">Pending Review</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">
                @php
                    $approvedCount = \App\Models\Verification::where('status', 'approved')->count();
                @endphp
                {{ $approvedCount }}
            </div>
            <div class="stat-label">Approved</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">
                @php
                    $rejectedCount = \App\Models\Verification::where('status', 'rejected')->count();
                @endphp
                {{ $rejectedCount }}
            </div>
            <div class="stat-label">Rejected</div>
        </div>
    </div>

    <!-- Filter -->
    <div class="filter-section">
        <h5 class="filter-title"><i class="bi bi-funnel"></i> Filter Verifications</h5>
        <form method="GET" action="{{ route('admin.verifications.index') }}" class="row g-3">
            <div class="col-md-6">
                <select class="form-select" name="status">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="not_submitted" {{ request('status') === 'not_submitted' ? 'selected' : '' }}>Not Submitted</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" name="type">
                    <option value="">All Types</option>
                    <option value="identity" {{ request('type') === 'identity' ? 'selected' : '' }}>Identity</option>
                    <option value="business" {{ request('type') === 'business' ? 'selected' : '' }}>Business</option>
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
            <h5 class="card-title m-0">Verification Submissions</h5>
            <span class="badge bg-light text-dark">{{ $verifications->total() }} total</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>USER</th>
                        <th>TYPE</th>
                        <th>STATUS</th>
                        <th>SUBMITTED</th>
                        <th>DATE</th>
                        <th style="width: 80px;">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($verifications as $verification)
                        <tr>
                            <td>{{ $verification->user->email ?? '—' }}</td>
                            <td>
                                @if ($verification->type === 'identity')
                                    <span class="badge badge-identity">Identity</span>
                                @else
                                    <span class="badge badge-business">Business</span>
                                @endif
                            </td>
                            <td>
                                @if ($verification->status === 'pending')
                                    <span class="badge badge-pending">Pending</span>
                                @elseif ($verification->status === 'approved')
                                    <span class="badge badge-approved">Approved</span>
                                @elseif ($verification->status === 'rejected')
                                    <span class="badge badge-rejected">Rejected</span>
                                @else
                                    <span class="badge bg-secondary">Not Submitted</span>
                                @endif
                            </td>
                            <td>
                                @if ($verification->status !== 'not_submitted')
                                    <i class="bi bi-check-circle" style="color: #10b981;"></i>
                                @else
                                    <i class="bi bi-x-circle" style="color: #ef4444;"></i>
                                @endif
                            </td>
                            <td>{{ $verification->updated_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.verifications.show', $verification->id) }}" class="action-btn" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox" style="font-size: 2rem; color: #d1d5db;"></i>
                                <p class="mt-2 mb-0">No verifications found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($verifications->hasPages())
            <div class="card-footer">
                {{ $verifications->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
