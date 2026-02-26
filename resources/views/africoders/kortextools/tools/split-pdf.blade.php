{{-- split pdf --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    split pdf tool for your development and productivity needs.
</div>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-cut fa-3x text-primary"></i>
                </div>
                <h1 class="h2 mb-3">Split PDF</h1>
                <p class="lead text-muted">
                    Break large PDF files into smaller, manageable documents with multiple splitting options
                </p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="split-pdf-form" enctype="multipart/form-data" class="needs-validation">
                        @csrf

                        <!-- PDF File Upload -->
                        <div class="mb-3">
                            <label for="split-pdf-file" class="form-label">
                                <i class="bi bi-file-pdf me-2"></i>Select PDF File
                            </label>
                            <input
                                type="file"
                                class="form-control @error('file') is-invalid @enderror"
                                id="split-pdf-file"
                                name="file"
                                accept=".pdf"
                                required
                            >
                            <small class="form-text text-muted d-block mt-2">
                                Upload a PDF file to split. Maximum 50MB.
                            </small>
                            @error('file')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

    <!-- Split Options -->
    <div class="mb-3">
        <label class="form-label">Split Method</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" id="split-by-pages" name="split_method" value="pages" checked>
            <label class="form-check-label" for="split-by-pages">
                Split by Page Range
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" id="split-every-page" name="split_method" value="single">
            <label class="form-check-label" for="split-every-page">
                Split Every Page (Separate PDFs)
            </label>
        </div>
    </div>

    <!-- Page Range (for split by pages method) -->
    <div id="page-range-section" class="mb-3">
        <label for="page-ranges" class="form-label">Page Ranges</label>
        <input
            type="text"
            class="form-control"
            id="page-ranges"
            name="page_ranges"
            placeholder="e.g., 1-3, 5, 7-10"
        >
        <small class="form-text text-muted d-block mt-2">
            Specify pages or ranges to extract. Examples: 1-3, 5, 7-10
        </small>
    </div>

    <!-- Processing Status -->
    <div id="processing-status" class="alert alert-info d-none" role="alert">
        <div class="spinner-border spinner-border-sm me-2" role="status">
            <span class="visually-hidden">Processing...</span>
        </div>
        <span id="status-text">Processing your PDF...</span>
    </div>

    <!-- Error Display -->
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Action Buttons -->
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button
            type="reset"
            class="btn btn-secondary"
            onclick="resetForm()"
        >
            <i class="bi bi-arrow-clockwise me-2"></i>Clear
        </button>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-file-earmark-pdf me-2"></i>Split PDF
        </button>
    </div>
                    </form>
                </div>
            </div>

            <!-- Features Section -->
            <div class="alert alert-info mt-4">
                <h6 class="alert-heading">
                    <i class="fas fa-info-circle me-2"></i>About PDF Splitting
                </h6>
                <p class="mb-2">
                    Split your large PDF files into smaller, more manageable documents:
                </p>
                <ul class="mb-2">
                    <li><strong>Multiple Split Methods</strong> - By pages, ranges, file size, or bookmarks</li>
                    <li><strong>Flexible Output</strong> - Choose file naming and numbering formats</li>
                    <li><strong>Batch Download</strong> - Download all files as ZIP or individually</li>
                    <li><strong>Quality Control</strong> - Option to reduce file size during splitting</li>
                    <li><strong>Preserve Quality</strong> - Maintain original PDF quality by default</li>
                </ul>
                <p class="mb-0">
                    <small><strong>Best for:</strong> Breaking up large documents, sharing specific sections, or reducing file sizes for email.</small>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
const splitMethodRadios = document.querySelectorAll('input[name="split_method"]');
const pageRangeSection = document.getElementById('page-range-section');
const pageRangesInput = document.getElementById('page-ranges');
const form = document.querySelector('form');
const processingStatus = document.getElementById('processing-status');

// Toggle page range visibility
splitMethodRadios.forEach(radio => {
    radio.addEventListener('change', function() {
        if (this.value === 'pages') {
            pageRangeSection.style.display = 'block';
            pageRangesInput.required = true;
        } else {
            pageRangeSection.style.display = 'none';
            pageRangesInput.required = false;
        }
    });
});

function resetForm() {
    form.reset();
    processingStatus.classList.add('d-none');
    pageRangeSection.style.display = 'block';
}

// Handle form submission
form.addEventListener('submit', async function(e) {
    e.preventDefault();

    const fileInput = document.getElementById('split-pdf-file');
    if (!fileInput.files.length) {
        alert('Please select a PDF file');
        return;
    }

    processingStatus.classList.remove('d-none');
    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.disabled = true;

    const formData = new FormData(this);

    try {
        const response = await fetch('/tool/split-pdf', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        if (response.ok && response.headers.get('content-type').includes('application/pdf')) {
            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'split-pdf.pdf';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            a.remove();

            resetForm();
            alert('PDF split successfully!');
        } else {
            const data = await response.json();
            alert('Error: ' + (data.message || 'Failed to split PDF'));
            processingStatus.classList.add('d-none');
            submitBtn.disabled = false;
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while splitting PDF');
        processingStatus.classList.add('d-none');
        submitBtn.disabled = false;
    }
});
</script>


