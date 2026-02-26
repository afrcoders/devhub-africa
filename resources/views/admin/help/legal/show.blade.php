@extends('admin.layout')

@section('title', $document->title)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-3">{{ $document->title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.help.dashboard') }}">Help Center</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.help.legal.index') }}">Legal Documents</a></li>
                            <li class="breadcrumb-item active">{{ Str::limit($document->title, 30) }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <div class="btn-group">
                        @if($document->published)
                            <a href="{{ route('help.legal', $document->slug) }}" class="btn btn-outline-info" target="_blank">
                                <i class="bi bi-eye"></i> View Public
                            </a>
                        @endif
                        <a href="{{ route('admin.help.legal.edit', $document) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <button type="button" class="btn btn-danger" onclick="deleteDocument({{ $document->id }})">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Document Content -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Document Content</h5>
                        <span class="badge bg-{{ $document->published ? 'success' : 'secondary' }} fs-6">
                            {{ $document->published ? 'Published' : 'Draft' }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="legal-document-content">
                        {!! $document->content !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Document Information -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Document Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">Document Type</label>
                            <div>
                                <span class="badge bg-info fs-6">
                                    {{ ucfirst(str_replace('_', ' ', 'legal_document')) }}
                                </span>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Status</label>
                            <div>
                                <span class="badge bg-{{ $document->published ? 'success' : 'secondary' }} fs-6">
                                    {{ $document->published ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Version</label>
                            <div class="form-control-plaintext">
                                {{ $document->version ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Slug</label>
                            <div class="form-control-plaintext text-break">
                                <code>{{ $document->slug }}</code>
                            </div>
                        </div>

                        @if($document->effective_date)
                            <div class="col-12">
                                <label class="form-label fw-bold">Effective Date</label>
                                <div class="form-control-plaintext">
                                    {{ \Carbon\Carbon::parse($document->effective_date)->format('M j, Y') }}
                                </div>
                            </div>
                        @endif

                        <div class="col-12">
                            <label class="form-label fw-bold">Created</label>
                            <div class="form-control-plaintext">
                                {{ $document->created_at->format('M j, Y') }}
                                <br>
                                <small class="text-muted">{{ $document->created_at->format('g:i A') }}</small>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Last Updated</label>
                            <div class="form-control-plaintext">
                                {{ $document->updated_at->format('M j, Y') }}
                                <br>
                                <small class="text-muted">{{ $document->updated_at->format('g:i A') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if(!$document->published)
                            <button type="button" class="btn btn-success btn-sm" onclick="togglePublishStatus({{ $document->id }}, true)">
                                <i class="bi bi-check-circle"></i> Publish Document
                            </button>
                        @else
                            <button type="button" class="btn btn-warning btn-sm" onclick="togglePublishStatus({{ $document->id }}, false)">
                                <i class="bi bi-pause-circle"></i> Unpublish Document
                            </button>
                        @endif

                        <button type="button" class="btn btn-info btn-sm" onclick="duplicateDocument({{ $document->id }})">
                            <i class="bi bi-files"></i> Duplicate Document
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this legal document?</p>
                <p class="text-muted"><strong>This action cannot be undone.</strong></p>
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

function togglePublishStatus(documentId, publish) {
    if (confirm(`Are you sure you want to ${publish ? 'publish' : 'unpublish'} this document?`)) {
        // Redirect to edit page where user can update status
        window.location.href = `/admin/help/legal/${documentId}/edit`;
    }
}

function duplicateDocument(documentId) {
    if (confirm('Create a copy of this document?')) {
        // This would need to be implemented in the controller
        alert('Duplicate functionality would need to be implemented in the controller.');
    }
}
</script>
@endpush
