@extends('admin.layout')

@section('title', $faq->question)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-3">{{ Str::limit($faq->question, 60) }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.help.dashboard') }}">Help Center</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.help.faqs.index') }}">FAQs</a></li>
                            <li class="breadcrumb-item active">{{ Str::limit($faq->question, 30) }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <div class="btn-group">
                        @if($faq->published)
                            <button class="btn btn-outline-info" onclick="viewPublicFaq()" title="View on Public Site">
                                <i class="bi bi-eye"></i> View Public
                            </button>
                        @endif
                        <a href="{{ route('admin.help.faqs.edit', $faq) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <button type="button" class="btn btn-danger" onclick="deleteFaq({{ $faq->id }})">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- FAQ Content -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">FAQ Details</h5>
                        <span class="badge bg-{{ $faq->published ? 'success' : 'secondary' }} fs-6">
                            {{ $faq->published ? 'Published' : 'Draft' }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="fw-bold text-primary mb-3">Question:</h6>
                        <div class="p-3 bg-light rounded">
                            {{ $faq->question }}
                        </div>
                    </div>

                    <div>
                        <h6 class="fw-bold text-success mb-3">Answer:</h6>
                        <div class="faq-answer p-3 border rounded">
                            {!! $faq->answer !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Information -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">FAQ Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">Category</label>
                            <div>
                                <span class="badge bg-info fs-6">
                                    {{ ucfirst(str_replace('-', ' ', $faq->category)) }}
                                </span>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Status</label>
                            <div>
                                <span class="badge bg-{{ $faq->published ? 'success' : 'secondary' }} fs-6">
                                    {{ $faq->published ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Display Order</label>
                            <div class="form-control-plaintext">
                                {{ $faq->order }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Helpful Votes</label>
                            <div class="form-control-plaintext">
                                <span class="text-success">
                                    <i class="bi bi-hand-thumbs-up"></i> {{ $faq->helpful_votes }}
                                </span>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Unhelpful Votes</label>
                            <div class="form-control-plaintext">
                                <span class="text-danger">
                                    <i class="bi bi-hand-thumbs-down"></i> {{ $faq->unhelpful_votes }}
                                </span>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Created</label>
                            <div class="form-control-plaintext">
                                {{ $faq->created_at->format('M j, Y') }}
                                <br>
                                <small class="text-muted">{{ $faq->created_at->format('g:i A') }}</small>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Last Updated</label>
                            <div class="form-control-plaintext">
                                {{ $faq->updated_at->format('M j, Y') }}
                                <br>
                                <small class="text-muted">{{ $faq->updated_at->format('g:i A') }}</small>
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
                        @if(!$faq->published)
                            <button type="button" class="btn btn-success btn-sm" onclick="togglePublishStatus({{ $faq->id }}, true)">
                                <i class="bi bi-check-circle"></i> Publish FAQ
                            </button>
                        @else
                            <button type="button" class="btn btn-warning btn-sm" onclick="togglePublishStatus({{ $faq->id }}, false)">
                                <i class="bi bi-pause-circle"></i> Unpublish FAQ
                            </button>
                        @endif

                        <button type="button" class="btn btn-info btn-sm" onclick="duplicateFaq({{ $faq->id }})">
                            <i class="bi bi-files"></i> Duplicate FAQ
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
                <p>Are you sure you want to delete this FAQ?</p>
                <p class="text-muted"><strong>This action cannot be undone.</strong></p>
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

function togglePublishStatus(faqId, publish) {
    if (confirm(`Are you sure you want to ${publish ? 'publish' : 'unpublish'} this FAQ?`)) {
        // Create a form to submit the status update
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/help/faqs/${faqId}`;

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';

        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = '{{ csrf_token() }}';

        const publishedInput = document.createElement('input');
        publishedInput.type = 'hidden';
        publishedInput.name = 'published';
        publishedInput.value = publish ? '1' : '0';

        // We need to preserve other fields, so we'll redirect to edit instead
        window.location.href = `/admin/help/faqs/${faqId}/edit`;
    }
}

function duplicateFaq(faqId) {
    if (confirm('Create a copy of this FAQ?')) {
        // This would need to be implemented in the controller
        alert('Duplicate functionality would need to be implemented in the controller.');
    }
}

function viewPublicFaq() {
    // Since we don't have a direct public FAQ URL, we'll go to the help center
    window.open('{{ route("help.index") }}#faq-{{ $faq->id }}', '_blank');
}
</script>
@endpush
