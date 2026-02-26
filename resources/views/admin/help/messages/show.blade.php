@extends('admin.layout')

@section('title', 'Message Details')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-3">Message Details</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.help.dashboard') }}">Help Center</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.help.messages.index') }}">Messages</a></li>
                            <li class="breadcrumb-item active">{{ $message->name }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.help.messages.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Messages
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Message Content -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="mb-1">{{ $message->subject }}</h5>
                            <p class="text-muted mb-0">
                                <strong>From:</strong> {{ $message->name }} ({{ $message->email }})
                            </p>
                        </div>
                        <span class="badge bg-{{ $message->status === 'pending' ? 'warning' : ($message->status === 'resolved' ? 'success' : 'secondary') }} fs-6">
                            {{ ucfirst($message->status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6>Message:</h6>
                        <div class="border-start border-primary border-3 ps-3">
                            {!! nl2br(e($message->message)) !!}
                        </div>
                    </div>

                    <div class="row text-muted small">
                        <div class="col-md-6">
                            <p><strong>Type:</strong> {{ ucfirst($message->type) }}</p>
                            <p><strong>Submitted:</strong> {{ $message->created_at->format('F j, Y g:i A') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>IP Address:</strong> {{ $message->ip_address ?? 'N/A' }}</p>
                            <p><strong>User Agent:</strong> {{ Str::limit($message->user_agent ?? 'N/A', 50) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Notes -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Admin Notes</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.help.messages.update-status', $message) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="{{ $message->status }}">

                        <div class="mb-3">
                            <label for="admin_notes" class="form-label">Notes (Internal Use Only)</label>
                            <textarea class="form-control" id="admin_notes" name="admin_notes" rows="4"
                                      placeholder="Add internal notes about this message...">{{ old('admin_notes', $message->admin_notes) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update Notes
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Status Management -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Status Management</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.help.messages.update-status', $message) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="status" class="form-label">Change Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="pending" {{ $message->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="read" {{ $message->status === 'read' ? 'selected' : '' }}>Read</option>
                                <option value="replied" {{ $message->status === 'replied' ? 'selected' : '' }}>Replied</option>
                                <option value="resolved" {{ $message->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="archived" {{ $message->status === 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Update Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}"
                           class="btn btn-outline-primary">
                            <i class="bi bi-reply"></i> Reply via Email
                        </a>

                        <button type="button" class="btn btn-outline-danger" onclick="deleteMessage()">
                            <i class="bi bi-trash"></i> Delete Message
                        </button>
                    </div>
                </div>
            </div>

            <!-- Message Info -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Message Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>ID:</strong></td>
                            <td>{{ $message->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Type:</strong></td>
                            <td><span class="badge bg-info">{{ ucfirst($message->type) }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                <span class="badge bg-{{ $message->status === 'pending' ? 'warning' : ($message->status === 'resolved' ? 'success' : 'secondary') }}">
                                    {{ ucfirst($message->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Submitted:</strong></td>
                            <td>{{ $message->created_at->format('M j, Y g:i A') }}</td>
                        </tr>
                        @if($message->read_at)
                        <tr>
                            <td><strong>Read:</strong></td>
                            <td>{{ $message->read_at->format('M j, Y g:i A') }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td><strong>IP:</strong></td>
                            <td><code>{{ $message->ip_address ?? 'N/A' }}</code></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this message? This action cannot be undone.</p>
                <div class="alert alert-warning">
                    <strong>Message:</strong> {{ $message->subject }}<br>
                    <strong>From:</strong> {{ $message->name }} ({{ $message->email }})
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('admin.help.messages.destroy', $message) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Message</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function deleteMessage() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Auto-save notes
let notesTimeout;
document.getElementById('admin_notes').addEventListener('input', function() {
    clearTimeout(notesTimeout);
    notesTimeout = setTimeout(function() {
        // Could implement auto-save here
    }, 2000);
});
</script>
@endpush
