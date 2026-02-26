@extends('admin.layout')

@section('title', 'Verification Details')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-3">Verification Details</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.verifications.index') }}">Verifications</a></li>
                            <li class="breadcrumb-item active">View</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.verifications.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Verification Details -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ ucfirst($verification->type) }} Verification</h5>
                        <span class="badge bg-{{
                            $verification->status === 'approved' ? 'success' :
                            ($verification->status === 'rejected' ? 'danger' : 'warning')
                        }} fs-6">
                            {{ ucfirst($verification->status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    @if($verification->data)
                        @php $data = is_string($verification->data) ? json_decode($verification->data, true) : $verification->data; @endphp

                        @if($data && is_array($data))
                            <div class="row g-3">
                                @foreach($data as $key => $value)
                                    @if(!empty($value))
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">{{ ucwords(str_replace('_', ' ', $key)) }}:</label>
                                            <div class="form-control-plaintext">
                                                @if(filter_var($value, FILTER_VALIDATE_URL) && (str_contains($value, '.jpg') || str_contains($value, '.png') || str_contains($value, '.jpeg')))
                                                    <img src="{{ $value }}" alt="{{ $key }}" class="img-thumbnail" style="max-width: 200px;">
                                                @elseif(filter_var($value, FILTER_VALIDATE_URL))
                                                    <a href="{{ $value }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-download"></i> View Document
                                                    </a>
                                                @else
                                                    {{ $value }}
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                No detailed verification data available.
                            </div>
                        @endif
                    @else
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            No verification data submitted yet.
                        </div>
                    @endif

                    @if($verification->admin_notes)
                        <hr>
                        <div class="mt-3">
                            <label class="form-label fw-bold">Admin Notes:</label>
                            <div class="alert alert-secondary">
                                {{ $verification->admin_notes }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- User Info & Actions -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">User Information</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar me-3">
                            <span class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                  style="width: 50px; height: 50px;">
                                {{ strtoupper(substr($verification->user->username ?? $verification->user->email, 0, 2)) }}
                            </span>
                        </div>
                        <div>
                            <div class="fw-semibold">{{ $verification->user->full_name ?? $verification->user->username }}</div>
                            <div class="text-muted small">{{ $verification->user->email }}</div>
                        </div>
                    </div>

                    <div class="row g-2 small">
                        <div class="col-6"><strong>Username:</strong></div>
                        <div class="col-6">{{ $verification->user->username }}</div>

                        <div class="col-6"><strong>Role:</strong></div>
                        <div class="col-6">
                            <span class="badge bg-info">{{ ucfirst($verification->user->role) }}</span>
                        </div>

                        <div class="col-6"><strong>Joined:</strong></div>
                        <div class="col-6">{{ $verification->user->created_at->format('M j, Y') }}</div>

                        <div class="col-6"><strong>Email Verified:</strong></div>
                        <div class="col-6">
                            @if($verification->user->email_verified)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-warning">No</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Verification Info -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Verification Information</h6>
                </div>
                <div class="card-body">
                    <div class="row g-2 small">
                        <div class="col-6"><strong>Type:</strong></div>
                        <div class="col-6">
                            <span class="badge bg-info">{{ ucfirst($verification->type) }}</span>
                        </div>

                        <div class="col-6"><strong>Status:</strong></div>
                        <div class="col-6">
                            <span class="badge bg-{{
                                $verification->status === 'approved' ? 'success' :
                                ($verification->status === 'rejected' ? 'danger' : 'warning')
                            }}">
                                {{ ucfirst($verification->status) }}
                            </span>
                        </div>

                        <div class="col-6"><strong>Submitted:</strong></div>
                        <div class="col-6">{{ $verification->created_at->format('M j, Y g:i A') }}</div>

                        <div class="col-6"><strong>Updated:</strong></div>
                        <div class="col-6">{{ $verification->updated_at->format('M j, Y g:i A') }}</div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            @if($verification->status === 'pending')
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-success" onclick="approveVerification({{ $verification->id }})">
                                <i class="bi bi-check-circle"></i> Approve
                            </button>
                            <button type="button" class="btn btn-danger" onclick="rejectVerification({{ $verification->id }})">
                                <i class="bi bi-x-circle"></i> Reject
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Verification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to approve this verification request?</p>
                <div class="mb-3">
                    <label class="form-label">Admin Notes (Optional)</label>
                    <textarea class="form-control" id="approveNotes" placeholder="Add any notes..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="approveForm" method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="admin_notes" id="approveNotesInput">
                    <button type="submit" class="btn btn-success">Approve</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Verification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to reject this verification request?</p>
                <div class="mb-3">
                    <label class="form-label">Reason for Rejection</label>
                    <textarea class="form-control" id="rejectNotes" placeholder="Please provide a reason..." required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="rejectForm" method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="admin_notes" id="rejectNotesInput">
                    <button type="submit" class="btn btn-danger">Reject</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function approveVerification(verificationId) {
    const form = document.getElementById('approveForm');
    form.action = `/admin/verifications/${verificationId}/approve`;

    const modal = new bootstrap.Modal(document.getElementById('approveModal'));
    modal.show();

    // Update hidden input when modal is submitted
    form.addEventListener('submit', function() {
        document.getElementById('approveNotesInput').value = document.getElementById('approveNotes').value;
    });
}

function rejectVerification(verificationId) {
    const form = document.getElementById('rejectForm');
    form.action = `/admin/verifications/${verificationId}/reject`;

    const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
    modal.show();

    // Update hidden input when modal is submitted
    form.addEventListener('submit', function() {
        document.getElementById('rejectNotesInput').value = document.getElementById('rejectNotes').value;
    });
}
</script>
@endpush
