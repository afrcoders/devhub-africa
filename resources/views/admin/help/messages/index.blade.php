@extends('admin.layout')

@section('title', 'Contact Messages')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-3">Contact Messages</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.help.dashboard') }}">Help Center</a></li>
                            <li class="breadcrumb-item active">Messages</li>
                        </ol>
                    </nav>
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
                                <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
                                <option value="replied" {{ request('status') === 'replied' ? 'selected' : '' }}>Replied</option>
                                <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="type">
                                <option value="">All Types</option>
                                <option value="support" {{ request('type') === 'support' ? 'selected' : '' }}>Support</option>
                                <option value="business" {{ request('type') === 'business' ? 'selected' : '' }}>Business</option>
                                <option value="legal" {{ request('type') === 'legal' ? 'selected' : '' }}>Legal</option>
                                <option value="other" {{ request('type') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Search</label>
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                                   placeholder="Search by name, email, or subject...">
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

    <!-- Messages List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Messages ({{ $messages->total() }})</h5>
                </div>
                <div class="card-body p-0">
                    @if($messages->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Status</th>
                                        <th>From</th>
                                        <th>Type</th>
                                        <th>Subject</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages as $message)
                                        <tr class="{{ $message->status === 'pending' ? 'table-warning' : '' }}">
                                            <td>
                                                <span class="badge bg-{{ $message->status === 'pending' ? 'warning' : ($message->status === 'resolved' ? 'success' : 'secondary') }}">
                                                    {{ ucfirst($message->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $message->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $message->email }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ ucfirst($message->type) }}</span>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ Str::limit($message->subject, 50) }}
                                                    @if($message->status === 'pending')
                                                        <i class="bi bi-dot text-warning"></i>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ $message->created_at->format('M j, Y') }}
                                                    <br>
                                                    <small class="text-muted">{{ $message->created_at->format('g:i A') }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.help.messages.show', $message) }}"
                                                       class="btn btn-outline-primary" title="View Message">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger"
                                                            onclick="deleteMessage({{ $message->id }})" title="Delete Message">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox" style="font-size: 3rem; color: #6c757d;"></i>
                            <h5 class="mt-3 text-muted">No messages found</h5>
                            <p class="text-muted">Try adjusting your filters or search criteria.</p>
                        </div>
                    @endif
                </div>
                @if($messages->hasPages())
                    <div class="card-footer">
                        {{ $messages->appends(request()->query())->links() }}
                    </div>
                @endif
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
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
function deleteMessage(messageId) {
    const form = document.getElementById('deleteForm');
    form.action = `/admin/help/messages/${messageId}`;

    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endpush
