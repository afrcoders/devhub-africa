@extends('admin.layout')

@section('title', 'Manage Legal Documents')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-3">Manage Legal Documents</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.help.dashboard') }}">Help Center</a></li>
                            <li class="breadcrumb-item active">Legal Documents</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.help.legal.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> New Document
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
                            <label class="form-label">Type</label>
                            <select class="form-select" name="type">
                                <option value="">All Types</option>
                                <option value="privacy" {{ request('type') === 'privacy' ? 'selected' : '' }}>Privacy Policy</option>
                                <option value="terms" {{ request('type') === 'terms' ? 'selected' : '' }}>Terms of Service</option>
                                <option value="cookie-policy" {{ request('type') === 'cookie-policy' ? 'selected' : '' }}>Cookie Policy</option>
                                <option value="disclaimer" {{ request('type') === 'disclaimer' ? 'selected' : '' }}>Disclaimer</option>
                                <option value="community-guidelines" {{ request('type') === 'community-guidelines' ? 'selected' : '' }}>Community Guidelines</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Search</label>
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                                   placeholder="Search by title or content...">
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

    <!-- Legal Documents List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Legal Documents ({{ $documents->total() }})</h5>
                </div>
                <div class="card-body p-0">
                    @if($documents->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Status</th>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Version</th>
                                        <th>Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($documents as $document)
                                        <tr>
                                            <td>
                                                <span class="badge bg-{{ $document->published ? 'success' : 'secondary' }}">
                                                    {{ $document->published ? 'Published' : 'Draft' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $document->title }}</strong>
                                                    @if($document->excerpt)
                                                        <br>
                                                        <small class="text-muted">{{ Str::limit($document->excerpt, 60) }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ ucfirst(str_replace('-', ' ', $document->type)) }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">v{{ $document->version ?? '1.0' }}</span>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ $document->updated_at->format('M j, Y') }}
                                                    <br>
                                                    <small class="text-muted">{{ $document->updated_at->format('g:i A') }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    @if($document->published)
                                                        <a href="{{ route('help.legal', $document->slug) }}"
                                                           class="btn btn-outline-info" title="View Document" target="_blank">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('admin.help.legal.show', $document) }}"
                                                       class="btn btn-outline-primary" title="View Details">
                                                        <i class="bi bi-file-text"></i>
                                                    </a>
                                                    <a href="{{ route('admin.help.legal.edit', $document) }}"
                                                       class="btn btn-outline-warning" title="Edit Document">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger"
                                                            onclick="deleteDocument({{ $document->id }})" title="Delete Document">
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
                            <i class="bi bi-file-earmark-text" style="font-size: 3rem; color: #6c757d;"></i>
                            <h5 class="mt-3 text-muted">No legal documents found</h5>
                            <p class="text-muted">Try adjusting your filters or search criteria.</p>
                            <a href="{{ route('admin.help.legal.create') }}" class="btn btn-primary mt-2">
                                <i class="bi bi-plus-circle"></i> Create First Document
                            </a>
                        </div>
                    @endif
                </div>
                @if($documents->hasPages())
                    <div class="card-footer">
                        {{ $documents->appends(request()->query())->links() }}
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
                <p>Are you sure you want to delete this legal document? This action cannot be undone.</p>
                <div class="alert alert-warning">
                    <strong>Warning:</strong> This will permanently remove the document and all its content.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Document</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function deleteDocument(documentId) {
    const form = document.getElementById('deleteForm');
    form.action = `/admin/help/legal/${documentId}`;

    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endpush
