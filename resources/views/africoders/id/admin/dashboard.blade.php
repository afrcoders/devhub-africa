@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
<div class="admin-dashboard">
    <!-- Header Section -->
    <div class="dashboard-header mb-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-5 fw-bold mb-2">Dashboard</h1>
                    <p class="text-white-50 mb-0">Welcome back, {{ auth()->user()->full_name ?? auth()->user()->email }}</p>
                </div>
                <div class="header-icon">
                    <i class="bi bi-speedometer2"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Stats Grid -->
        <div class="row g-4 mb-5">
            <!-- Total Users Card -->
            <div class="col-lg-6 col-xl-3">
                <div class="stat-card stat-card-primary h-100">
                    <div class="stat-card-bg"></div>
                    <div class="stat-card-content">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <p class="stat-label">Total Users</p>
                                <h2 class="stat-number">{{ $totalUsers }}</h2>
                            </div>
                            <div class="stat-icon">
                                <i class="bi bi-people-fill"></i>
                            </div>
                        </div>
                        <a href="{{ route('admin.users.index') }}" class="stat-link">
                            View all users <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total Verifications Card -->
            <div class="col-lg-6 col-xl-3">
                <div class="stat-card stat-card-success h-100">
                    <div class="stat-card-bg"></div>
                    <div class="stat-card-content">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <p class="stat-label">Verifications</p>
                                <h2 class="stat-number">{{ $totalVerifications }}</h2>
                            </div>
                            <div class="stat-icon">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                        </div>
                        <a href="{{ route('admin.verifications.index') }}" class="stat-link">
                            Review verifications <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Pending Verifications Card -->
            <div class="col-lg-6 col-xl-3">
                <div class="stat-card stat-card-warning h-100">
                    <div class="stat-card-bg"></div>
                    <div class="stat-card-content">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <p class="stat-label">Pending</p>
                                <h2 class="stat-number">{{ $pendingVerifications }}</h2>
                            </div>
                            <div class="stat-icon">
                                <i class="bi bi-hourglass"></i>
                            </div>
                        </div>
                        <a href="{{ route('admin.verifications.index', ['status' => 'pending']) }}" class="stat-link">
                            Action required <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Actions Card -->
            <div class="col-lg-6 col-xl-3">
                <div class="stat-card stat-card-info h-100">
                    <div class="stat-card-bg"></div>
                    <div class="stat-card-content">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <p class="stat-label">Admin Actions</p>
                                <h2 class="stat-number">{{ $recentAuditLogs->count() }}</h2>
                            </div>
                            <div class="stat-icon">
                                <i class="bi bi-lightning-fill"></i>
                            </div>
                        </div>
                        <a href="{{ route('admin.audit-logs.index') }}" class="stat-link">
                            View audit log <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="quick-actions-card">
                    <div class="quick-actions-header">
                        <h5 class="mb-0">
                            <i class="bi bi-lightning me-2"></i>Quick Actions
                        </h5>
                    </div>
                    <div class="quick-actions-body">
                        <a href="{{ route('admin.users.index') }}" class="action-btn action-btn-primary">
                            <div class="action-btn-icon">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="action-btn-content">
                                <h6>Manage Users</h6>
                                <p>View and manage all users</p>
                            </div>
                            <div class="action-btn-arrow">
                                <i class="bi bi-arrow-right"></i>
                            </div>
                        </a>
                        <a href="{{ route('admin.verifications.index') }}" class="action-btn action-btn-success">
                            <div class="action-btn-icon">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="action-btn-content">
                                <h6>Review Verifications</h6>
                                <p>Approve or reject submissions</p>
                            </div>
                            <div class="action-btn-arrow">
                                <i class="bi bi-arrow-right"></i>
                            </div>
                        </a>
                        <a href="{{ route('admin.audit-logs.index') }}" class="action-btn action-btn-info">
                            <div class="action-btn-icon">
                                <i class="bi bi-journal-text"></i>
                            </div>
                            <div class="action-btn-content">
                                <h6>View Audit Logs</h6>
                                <p>Track all admin activities</p>
                            </div>
                            <div class="action-btn-arrow">
                                <i class="bi bi-arrow-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="activity-card">
                    <div class="activity-header">
                        <h5 class="mb-0">
                            <i class="bi bi-clock-history me-2"></i>Recent Activity
                        </h5>
                        <a href="{{ route('admin.audit-logs.index') }}" class="view-all-link">View All</a>
                    </div>
                    <div class="activity-body">
                        @if ($recentAuditLogs->count() > 0)
                            <div class="activity-timeline">
                                @foreach ($recentAuditLogs as $log)
                                    <div class="activity-item">
                                        <div class="activity-marker"></div>
                                        <div class="activity-content">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h6 class="activity-action">{{ str_replace('_', ' ', $log->action) }}</h6>
                                                    <p class="activity-detail">{{ Str::limit($log->details, 60) }}</p>
                                                </div>
                                                <span class="badge bg-dark-subtle text-dark">{{ $log->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="activity-meta">By <strong>{{ $log->user?->email ?? 'Unknown User' }}</strong> from {{ $log->ip_address }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <p class="text-muted">No recent activity</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --admin-primary: #3b82f6;
        --admin-success: #10b981;
        --admin-warning: #f59e0b;
        --admin-info: #0ea5e9;
        --admin-dark: #1f2937;
        --admin-light: #f9fafb;
        --admin-border: #e5e7eb;
    }

    .admin-dashboard {
        background: #f9fafb;
        min-height: 100vh;
        padding-bottom: 3rem;
    }

    /* Header Section */
    .dashboard-header {
        background: linear-gradient(135deg, var(--admin-primary) 0%, #2563eb 100%);
        color: white;
        padding: 3rem 0;
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .header-icon {
        font-size: 4rem;
        opacity: 0.2;
    }

    /* Stat Cards */
    .stat-card {
        position: relative;
        overflow: hidden;
        border: none;
        border-radius: 1rem;
        padding: 1.5rem;
        background: white;
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px rgba(0, 0, 0, 0.1);
    }

    .stat-card-bg {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--admin-primary);
    }

    .stat-card-primary .stat-card-bg { background: linear-gradient(90deg, var(--admin-primary), #60a5fa); }
    .stat-card-success .stat-card-bg { background: linear-gradient(90deg, var(--admin-success), #34d399); }
    .stat-card-warning .stat-card-bg { background: linear-gradient(90deg, var(--admin-warning), #fbbf24); }
    .stat-card-info .stat-card-bg { background: linear-gradient(90deg, var(--admin-info), #38bdf8); }

    .stat-card-content {
        position: relative;
        z-index: 1;
    }

    .stat-label {
        font-size: 0.875rem;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--admin-dark);
        line-height: 1;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        opacity: 0.15;
    }

    .stat-card-primary .stat-icon { color: var(--admin-primary); background: var(--admin-primary); opacity: 0.1; }
    .stat-card-success .stat-icon { color: var(--admin-success); background: var(--admin-success); opacity: 0.1; }
    .stat-card-warning .stat-icon { color: var(--admin-warning); background: var(--admin-warning); opacity: 0.1; }
    .stat-card-info .stat-icon { color: var(--admin-info); background: var(--admin-info); opacity: 0.1; }

    .stat-link {
        font-size: 0.875rem;
        color: var(--admin-primary);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s ease;
        display: inline-block;
    }

    .stat-link:hover {
        color: #2563eb;
        transform: translateX(4px);
    }

    /* Quick Actions */
    .quick-actions-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .quick-actions-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--admin-border);
        background: var(--admin-light);
        font-weight: 600;
    }

    .quick-actions-body {
        padding: 1.5rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .action-btn {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem;
        border-radius: 0.875rem;
        text-decoration: none;
        color: inherit;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        background: var(--admin-light);
    }

    .action-btn:hover {
        transform: translateX(4px);
    }

    .action-btn-primary:hover { background: rgba(59, 130, 246, 0.08); border-color: var(--admin-primary); }
    .action-btn-success:hover { background: rgba(16, 185, 129, 0.08); border-color: var(--admin-success); }
    .action-btn-info:hover { background: rgba(14, 165, 233, 0.08); border-color: var(--admin-info); }

    .action-btn-icon {
        width: 50px;
        height: 50px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .action-btn-primary .action-btn-icon { background: rgba(59, 130, 246, 0.1); color: var(--admin-primary); }
    .action-btn-success .action-btn-icon { background: rgba(16, 185, 129, 0.1); color: var(--admin-success); }
    .action-btn-info .action-btn-icon { background: rgba(14, 165, 233, 0.1); color: var(--admin-info); }

    .action-btn-content {
        flex-grow: 1;
    }

    .action-btn-content h6 {
        margin: 0;
        font-weight: 600;
        color: var(--admin-dark);
    }

    .action-btn-content p {
        margin: 0.25rem 0 0 0;
        font-size: 0.875rem;
        color: #6b7280;
    }

    .action-btn-arrow {
        font-size: 1.25rem;
        color: #d1d5db;
        transition: all 0.3s ease;
    }

    .action-btn:hover .action-btn-arrow {
        color: var(--admin-primary);
        transform: translateX(4px);
    }

    /* Activity Section */
    .activity-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .activity-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--admin-border);
        background: var(--admin-light);
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
    }

    .view-all-link {
        color: var(--admin-primary);
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .view-all-link:hover {
        color: #2563eb;
    }

    .activity-body {
        padding: 1.5rem;
    }

    .activity-timeline {
        position: relative;
    }

    .activity-timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(180deg, var(--admin-primary) 0%, transparent 100%);
    }

    .activity-item {
        position: relative;
        margin-bottom: 1.5rem;
        padding-left: 3.5rem;
    }

    .activity-item:last-child {
        margin-bottom: 0;
    }

    .activity-marker {
        position: absolute;
        left: 0;
        top: 0;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: white;
        border: 3px solid var(--admin-primary);
        z-index: 2;
    }

    .activity-content {
        background: var(--admin-light);
        padding: 1rem;
        border-radius: 0.75rem;
    }

    .activity-action {
        margin: 0;
        color: var(--admin-dark);
        font-weight: 600;
        text-transform: capitalize;
    }

    .activity-detail {
        margin: 0.25rem 0 0 0;
        font-size: 0.875rem;
        color: #6b7280;
    }

    .activity-meta {
        margin: 0.75rem 0 0 0;
        font-size: 0.8rem;
        color: #9ca3af;
    }

    .empty-state {
        text-align: center;
        padding: 2rem;
    }

    .empty-state i {
        font-size: 3rem;
        color: #d1d5db;
        display: block;
        margin-bottom: 1rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .quick-actions-body {
            grid-template-columns: 1fr;
        }

        .stat-number {
            font-size: 1.5rem;
        }

        .dashboard-header h1 {
            font-size: 1.75rem;
        }
    }
</style>
@endsection
