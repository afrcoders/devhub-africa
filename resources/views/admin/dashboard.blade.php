@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-3">Admin Dashboard</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small">Total Users</div>
                            <div class="h4 mb-0">{{ number_format($totalUsers) }}</div>
                        </div>
                        <div>
                            <i class="bi bi-people fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small">Pending Verifications</div>
                            <div class="h4 mb-0">{{ number_format($pendingVerifications) }}</div>
                        </div>
                        <div>
                            <i class="bi bi-clock-history fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small">Total Verifications</div>
                            <div class="h4 mb-0">{{ number_format($totalVerifications) }}</div>
                        </div>
                        <div>
                            <i class="bi bi-check-circle fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small">System Status</div>
                            <div class="h4 mb-0">Active</div>
                        </div>
                        <div>
                            <i class="bi bi-server fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- Recent Activity -->
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Audit Logs</h5>
                </div>
                <div class="card-body">
                    @if($recentAuditLogs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>User</th>
                                        <th>Time</th>
                                        <th>IP Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentAuditLogs as $log)
                                        <tr>
                                            <td>
                                                <span class="badge bg-primary">{{ $log->action }}</span>
                                            </td>
                                            <td>
                                                @if($log->user)
                                                    {{ $log->user->username ?? $log->user->email }}
                                                @else
                                                    <span class="text-muted">System</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small>{{ $log->created_at->diffForHumans() }}</small>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $log->ip_address ?? 'N/A' }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-inbox" style="font-size: 3rem; color: #6c757d;"></i>
                            <h6 class="mt-3 text-muted">No audit logs found</h6>
                            <p class="text-muted">System activity will appear here.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                            <i class="bi bi-people me-2"></i> Manage Users
                        </a>
                        <a href="{{ route('admin.verifications.index') }}" class="btn btn-warning">
                            <i class="bi bi-check-circle me-2"></i> Review Verifications
                        </a>
                        <a href="{{ route('admin.help.dashboard') }}" class="btn btn-info">
                            <i class="bi bi-question-circle me-2"></i> Help Center
                        </a>
                        <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-secondary">
                            <i class="bi bi-journal-text me-2"></i> Audit Logs
                        </a>
                    </div>
                </div>
            </div>

            <!-- System Info -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">System Information</h6>
                </div>
                <div class="card-body">
                    <div class="row g-2 small">
                        <div class="col-6"><strong>PHP Version:</strong></div>
                        <div class="col-6">{{ PHP_VERSION }}</div>

                        <div class="col-6"><strong>Laravel Version:</strong></div>
                        <div class="col-6">{{ app()->version() }}</div>

                        <div class="col-6"><strong>Environment:</strong></div>
                        <div class="col-6">
                            <span class="badge bg-{{ app()->environment('production') ? 'danger' : 'success' }}">
                                {{ strtoupper(app()->environment()) }}
                            </span>
                        </div>

                        <div class="col-6"><strong>Debug Mode:</strong></div>
                        <div class="col-6">
                            <span class="badge bg-{{ config('app.debug') ? 'warning' : 'success' }}">
                                {{ config('app.debug') ? 'ON' : 'OFF' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
