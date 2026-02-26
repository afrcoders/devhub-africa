@extends('africoders.id.layouts.app')

@section('title', 'Verification Details')

@section('content')
<style>
    .verification-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2.5rem 2rem;
        border-radius: 1rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .status-badge {
        font-size: 1rem;
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        font-weight: 600;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-pending {
        background-color: #fbbf24;
        color: #78350f;
    }

    .status-approved {
        background-color: #10b981;
        color: white;
    }

    .status-rejected {
        background-color: #ef4444;
        color: white;
    }

    .status-not-submitted {
        background-color: #6b7280;
        color: white;
    }

    .info-card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .info-card-header {
        background-color: #f3f4f6;
        padding: 1.25rem;
        border-bottom: 1px solid #e5e7eb;
        font-weight: 600;
        font-size: 0.95rem;
        color: #1f2937;
    }

    .info-field {
        padding: 1rem;
        border-bottom: 1px solid #f3f4f6;
    }

    .info-field:last-child {
        border-bottom: none;
    }

    .info-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6b7280;
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
    }

    .info-value {
        color: #1f2937;
        font-size: 1rem;
        font-weight: 500;
    }

    .action-buttons {
        display: flex;
        gap: 0.75rem;
    }

    .btn-approve {
        background-color: #10b981;
        border-color: #10b981;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        flex: 1;
    }

    .btn-approve:hover {
        background-color: #059669;
        border-color: #059669;
        color: white;
    }

    .btn-reject {
        background-color: #ef4444;
        border-color: #ef4444;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        flex: 1;
    }

    .btn-reject:hover {
        background-color: #dc2626;
        border-color: #dc2626;
        color: white;
    }

    .verification-data {
        background-color: #f9fafb;
        border-radius: 0.75rem;
        padding: 1.5rem;
        border: 1px solid #e5e7eb;
    }

    .data-field {
        margin-bottom: 1.5rem;
    }

    .data-field:last-child {
        margin-bottom: 0;
    }

    .data-key {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6b7280;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .data-value {
        background-color: white;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        color: #1f2937;
        border-left: 3px solid #667eea;
        font-size: 0.95rem;
        line-height: 1.5;
    }

    .timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline-item {
        display: flex;
        margin-bottom: 1.5rem;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-icon {
        position: absolute;
        left: 0;
        width: 1.5rem;
        height: 1.5rem;
        background-color: #667eea;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.75rem;
    }

    .timeline-content {
        flex: 1;
    }

    .timeline-label {
        font-size: 0.85rem;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }

    .timeline-value {
        color: #1f2937;
        font-weight: 500;
    }

    .user-avatar {
        width: 3rem;
        height: 3rem;
        border-radius: 0.5rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 1.25rem;
    }
</style>

<div class="container mt-4 mb-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <a href="{{ route('admin.verifications.index') }}" class="text-decoration-none text-muted mb-2" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="bi bi-arrow-left"></i> Back to Verifications
            </a>
        </div>
        <span class="status-badge status-{{ str_replace('_', '-', $verification->status) }}">
            {{ ucfirst(str_replace('_', ' ', $verification->status)) }}
        </span>
    </div>

    <!-- Verification Header -->
    <div class="verification-header">
        <div class="d-flex align-items-center gap-3 mb-3">
            <div class="user-avatar">
                {{ strtoupper(substr($verification->user->full_name ?? $verification->user->email, 0, 1)) }}
            </div>
            <div>
                <h2 style="margin-bottom: 0.5rem; font-size: 1.75rem;">{{ ucfirst($verification->type) }} Verification</h2>
                <p style="margin-bottom: 0; opacity: 0.9;">{{ $verification->user->email }}</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- User & Verification Info -->
            <div class="info-card mb-4">
                <div class="info-card-header">
                    <i class="bi bi-person-circle me-2"></i>User Information
                </div>
                <div class="info-field">
                    <span class="info-label">Full Name</span>
                    <p class="info-value mb-0">{{ $verification->user->full_name ?? '-' }}</p>
                </div>
                <div class="info-field">
                    <span class="info-label">Username</span>
                    <p class="info-value mb-0">{{ $verification->user->username ?? '-' }}</p>
                </div>
                <div class="info-field">
                    <span class="info-label">Email</span>
                    <p class="info-value mb-0">
                        <a href="mailto:{{ $verification->user->email }}" class="text-decoration-none">
                            {{ $verification->user->email }}
                        </a>
                    </p>
                </div>
                <div class="info-field">
                    <span class="info-label">Role</span>
                    <p class="info-value mb-0">
                        <span class="badge bg-info" style="text-transform: capitalize;">
                            {{ str_replace('_', ' ', $verification->user->role) }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- Verification Timeline -->
            <div class="info-card mb-4">
                <div class="info-card-header">
                    <i class="bi bi-clock-history me-2"></i>Timeline
                </div>
                <div style="padding: 1.5rem;">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="bi bi-upload"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-label">Submitted</div>
                                <div class="timeline-value">
                                    @if ($verification->status !== 'not_submitted')
                                        {{ $verification->created_at->format('M d, Y at H:i') }}
                                        <small class="text-muted">({{ $verification->created_at->diffForHumans() }})</small>
                                    @else
                                        <em class="text-muted">Not yet submitted</em>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if ($verification->status === 'approved' && $verification->approved_at)
                            <div class="timeline-item">
                                <div class="timeline-icon">
                                    <i class="bi bi-check"></i>
                                </div>
                                <div class="timeline-content">
                                    <div class="timeline-label">Approved</div>
                                    <div class="timeline-value">
                                        {{ $verification->approved_at->format('M d, Y at H:i') }}
                                        <small class="text-muted">({{ $verification->approved_at->diffForHumans() }})</small>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Submitted Information -->
            @if ($verification->data)
                <div class="info-card mb-4">
                    <div class="info-card-header">
                        <i class="bi bi-file-text me-2"></i>Submitted Information
                    </div>
                    <div style="padding: 1.5rem;">
                        <div class="verification-data">
                            @foreach ($verification->data as $key => $value)
                                <div class="data-field">
                                    <div class="data-key">{{ str_replace('_', ' ', $key) }}</div>
                                    <div class="data-value">
                                        @if (is_array($value))
                                            <pre style="margin-bottom: 0; font-size: 0.85rem;">{{ json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                        @elseif (is_object($value))
                                            <pre style="margin-bottom: 0; font-size: 0.85rem;">{{ json_encode((array)$value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                        @elseif (is_string($value) && (str_ends_with($key, '_document') || str_ends_with($key, '_certificate')))
                                            @if (!empty($value))
                                                <a href="{{ asset('storage/' . $value) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                                    <i class="bi bi-download me-1"></i>{{ basename($value) }}
                                                </a>
                                            @else
                                                <span class="text-muted">No file uploaded</span>
                                            @endif
                                        @else
                                            {{ $value }}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Rejection Reason -->
            @if ($verification->status === 'rejected')
                <div class="info-card mb-4">
                    <div class="info-card-header" style="background-color: #fee2e2; border-bottom-color: #fecaca;">
                        <i class="bi bi-exclamation-triangle me-2"></i>Rejection Reason
                    </div>
                    <div style="padding: 1.5rem; background-color: #fef2f2;">
                        <p style="margin-bottom: 0; color: #991b1b;">{{ $verification->rejection_reason }}</p>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            @if ($verification->status === 'pending' || $verification->status === 'not_submitted')
                <div class="info-card">
                    <div class="info-card-header">
                        <i class="bi bi-sliders me-2"></i>Actions
                    </div>
                    <div style="padding: 1.5rem;">
                        <div class="action-buttons">
                            <form method="POST" action="{{ route('admin.verifications.approve', $verification->id) }}" style="flex: 1;">
                                @csrf
                                <button type="submit" class="btn-approve" onclick="return confirm('Are you sure you want to approve this verification?')">
                                    <i class="bi bi-check-circle me-2"></i>Approve
                                </button>
                            </form>
                            <button type="button" class="btn-reject" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                <i class="bi bi-x-circle me-2"></i>Reject
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="info-card sticky-top" style="top: 2rem;">
                <div class="info-card-header">
                    <i class="bi bi-shield-check me-2"></i>Verification Status
                </div>
                <div style="padding: 1.5rem;">
                    <div class="mb-4">
                        <span class="info-label">Current Status</span>
                        <p class="mb-0">
                            <span class="status-badge status-{{ str_replace('_', '-', $verification->status) }}" style="width: 100%; text-align: center;">
                                {{ ucfirst(str_replace('_', ' ', $verification->status)) }}
                            </span>
                        </p>
                    </div>

                    <div class="mb-4">
                        <span class="info-label">Verification Type</span>
                        <p class="info-value mb-0">
                            <span class="badge bg-primary" style="text-transform: capitalize;">
                                {{ $verification->type }}
                            </span>
                        </p>
                    </div>

                    <div class="mb-4">
                        <span class="info-label">Submission Date</span>
                        <p class="info-value mb-0">
                            @if ($verification->status !== 'not_submitted')
                                {{ $verification->created_at->format('M d, Y') }}
                            @else
                                <em class="text-muted">Pending submission</em>
                            @endif
                        </p>
                    </div>

                    @if ($verification->status === 'approved')
                        <div class="mb-4">
                            <span class="info-label">Approved Date</span>
                            <p class="info-value mb-0">
                                {{ $verification->approved_at ? $verification->approved_at->format('M d, Y') : 'Not yet approved' }}
                            </p>
                        </div>
                    @endif

                    <hr style="margin: 1.5rem 0;">

                    <a href="{{ route('admin.users.show', $verification->user->id) }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-person me-2"></i>View User Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 0.75rem; border: none;">
            <form method="POST" action="{{ route('admin.verifications.reject', $verification->id) }}">
                @csrf
                <div class="modal-header" style="background-color: #fef2f2; border-color: #fecaca;">
                    <h5 class="modal-title" style="color: #991b1b; font-weight: 600;">
                        <i class="bi bi-x-circle me-2"></i>Reject Verification
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding: 1.5rem;">
                    <div class="mb-3">
                        <label for="reason" class="form-label" style="font-weight: 600; color: #1f2937;">
                            Reason for Rejection
                        </label>
                        <textarea class="form-control @error('reason') is-invalid @enderror"
                                  id="reason" name="reason" rows="4" placeholder="Explain why this verification is being rejected..."
                                  style="border-radius: 0.5rem; border-color: #e5e7eb;"></textarea>
                        @error('reason')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer" style="border-top-color: #e5e7eb;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to reject this verification?')">
                        <i class="bi bi-x-circle me-2"></i>Reject Verification
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
