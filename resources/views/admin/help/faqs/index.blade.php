@extends('admin.layout')

@section('title', 'Manage FAQs')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-3">Manage FAQs</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.help.dashboard') }}">Help Center</a></li>
                            <li class="breadcrumb-item active">FAQs</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.help.faqs.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> New FAQ
                    </a>
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
                                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category">
                                <option value="">All Categories</option>
                                <option value="general" {{ request('category') === 'general' ? 'selected' : '' }}>General</option>
                                <option value="accounts" {{ request('category') === 'accounts' ? 'selected' : '' }}>Accounts</option>
                                <option value="security" {{ request('category') === 'security' ? 'selected' : '' }}>Security</option>
                                <option value="privacy" {{ request('category') === 'privacy' ? 'selected' : '' }}>Privacy</option>
                                <option value="community" {{ request('category') === 'community' ? 'selected' : '' }}>Community</option>
                                <option value="billing" {{ request('category') === 'billing' ? 'selected' : '' }}>Billing</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Search</label>
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                                   placeholder="Search by question or answer...">
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

    <!-- FAQs List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">FAQs ({{ $faqs->total() }})</h5>
                    <small class="text-muted">Drag to reorder</small>
                </div>
                <div class="card-body p-0">
                    @if($faqs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="faqs-table">
                                <thead class="table-light">
                                    <tr>
                                        <th width="30"></th>
                                        <th>Status</th>
                                        <th>Question</th>
                                        <th>Category</th>
                                        <th>Order</th>
                                        <th>Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($faqs as $faq)
                                        <tr data-faq-id="{{ $faq->id }}">
                                            <td class="drag-handle" style="cursor: grab;">
                                                <i class="bi bi-grip-vertical text-muted"></i>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $faq->published ? 'success' : 'secondary' }}">
                                                    {{ $faq->published ? 'Published' : 'Draft' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $faq->question }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ Str::limit(strip_tags($faq->answer), 80) }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ ucfirst($faq->category) }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $faq->order }}</span>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ $faq->updated_at->format('M j, Y') }}
                                                    <br>
                                                    <small class="text-muted">{{ $faq->updated_at->format('g:i A') }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.help.faqs.show', $faq) }}"
                                                       class="btn btn-outline-primary" title="View Details">
                                                        <i class="bi bi-file-text"></i>
                                                    </a>
                                                    <a href="{{ route('admin.help.faqs.edit', $faq) }}"
                                                       class="btn btn-outline-warning" title="Edit FAQ">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger"
                                                            onclick="deleteFaq({{ $faq->id }})" title="Delete FAQ">
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
                            <i class="bi bi-question-circle" style="font-size: 3rem; color: #6c757d;"></i>
                            <h5 class="mt-3 text-muted">No FAQs found</h5>
                            <p class="text-muted">Try adjusting your filters or search criteria.</p>
                            <a href="{{ route('admin.help.faqs.create') }}" class="btn btn-primary mt-2">
                                <i class="bi bi-plus-circle"></i> Create First FAQ
                            </a>
                        </div>
                    @endif
                </div>
                @if($faqs->hasPages())
                    <div class="card-footer">
                        {{ $faqs->appends(request()->query())->links() }}
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
                <p>Are you sure you want to delete this FAQ? This action cannot be undone.</p>
                <div class="alert alert-warning">
                    <strong>Warning:</strong> This will permanently remove the FAQ and all its content.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete FAQ</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function deleteFaq(faqId) {
    const form = document.getElementById('deleteForm');
    form.action = `/admin/help/faqs/${faqId}`;

    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Simple drag and drop for reordering (you can enhance this with a library like SortableJS)
let draggedElement = null;

document.querySelectorAll('.drag-handle').forEach(handle => {
    handle.addEventListener('mousedown', function() {
        draggedElement = this.closest('tr');
        draggedElement.style.opacity = '0.5';
    });
});

document.addEventListener('mouseup', function() {
    if (draggedElement) {
        draggedElement.style.opacity = '1';
        draggedElement = null;
    }
});
</script>
@endpush
