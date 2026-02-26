<form id="pdf-merge-form" method="POST" action="/tool/pdf-merge" enctype="multipart/form-data" class="needs-validation">
    @csrf

    <!-- PDF File Upload -->
    <div class="mb-3">
        <label for="pdf-files" class="form-label">
            <i class="bi bi-file-pdf me-2"></i>Select PDF Files
        </label>
        <input
            type="file"
            class="form-control @error('files') is-invalid @enderror"
            id="pdf-files"
            name="files[]"
            multiple
            accept=".pdf"
            required
        >
        <small class="form-text text-muted d-block mt-2">
            Upload 2 or more PDF files. Maximum 50MB per file.
        </small>
        @error('files')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <!-- File List Preview -->
    <div id="file-list" class="mb-3" style="display: none;">
        <label class="form-label">Selected Files</label>
        <div id="files-container" class="list-group">
            <!-- Files will be added here dynamically -->
        </div>
    </div>

    <!-- Merge Options -->
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="output-name" class="form-label">Output Filename</label>
            <input
                type="text"
                class="form-control"
                id="output-name"
                name="output_name"
                placeholder="merged.pdf"
                value="merged.pdf"
            >
        </div>
        <div class="col-md-6">
            <label for="compression" class="form-label">Compression</label>
            <select class="form-select" id="compression" name="compression">
                <option value="none">No Compression</option>
                <option value="low">Low Compression</option>
                <option value="medium" selected>Medium Compression</option>
                <option value="high">High Compression</option>
            </select>
        </div>
    </div>

    <!-- Processing Status -->
    <div id="processing-status" class="alert alert-info d-none" role="alert">
        <div class="spinner-border spinner-border-sm me-2" role="status">
            <span class="visually-hidden">Processing...</span>
        </div>
        <span id="status-text">Processing your PDFs...</span>
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
        <button
            type="submit"
            class="btn btn-primary"
            id="merge-btn"
        >
            <i class="bi bi-file-pdf me-2"></i>Merge PDFs
        </button>
    </div>
</form>

<script>
const fileInput = document.getElementById('pdf-files');
const fileList = document.getElementById('file-list');
const filesContainer = document.getElementById('files-container');
const form = document.getElementById('pdf-merge-form');
const mergeBtn = document.getElementById('merge-btn');
const processingStatus = document.getElementById('processing-status');

// Monitor file selection
fileInput.addEventListener('change', function(e) {
    const files = Array.from(this.files);

    if (files.length === 0) {
        fileList.style.display = 'none';
        filesContainer.innerHTML = '';
        return;
    }

    // Display file list
    fileList.style.display = 'block';
    filesContainer.innerHTML = '';

    files.forEach((file, index) => {
        const size = (file.size / 1024 / 1024).toFixed(2); // Convert to MB
        const item = document.createElement('div');
        item.className = 'list-group-item d-flex justify-content-between align-items-center';
        item.innerHTML = `
            <div>
                <i class="bi bi-file-pdf text-danger me-2"></i>
                <strong>${file.name}</strong>
                <small class="text-muted d-block">${size} MB</small>
            </div>
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFile(${index})">
                <i class="bi bi-trash"></i>
            </button>
        `;
        filesContainer.appendChild(item);
    });

    // Update the actual input with current files
    updateFileInput();
});

function removeFile(index) {
    const newFileList = new DataTransfer();
    Array.from(fileInput.files).forEach((file, i) => {
        if (i !== index) {
            newFileList.items.add(file);
        }
    });
    fileInput.files = newFileList.files;

    // Trigger change event to update display
    fileInput.dispatchEvent(new Event('change', { bubbles: true }));
}

function updateFileInput() {
    // This is handled by the browser's file input automatically
    if (fileInput.files.length === 0) {
        fileInput.removeAttribute('required');
    } else {
        fileInput.setAttribute('required', 'required');
    }
}

function resetForm() {
    form.reset();
    fileList.style.display = 'none';
    filesContainer.innerHTML = '';
    processingStatus.classList.add('d-none');
}

// Handle form submission
form.addEventListener('submit', async function(e) {
    e.preventDefault();

    if (fileInput.files.length < 2) {
        alert('Please select at least 2 PDF files');
        return;
    }

    // Show processing status
    processingStatus.classList.remove('d-none');
    mergeBtn.disabled = true;

    const formData = new FormData(this);

    try {
        const response = await fetch('/tool/pdf-merge', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        if (response.ok) {
            // Get the filename from response headers or default
            const disposition = response.headers.get('content-disposition');
            let filename = 'merged.pdf';

            if (disposition) {
                const matches = /filename="(.+?)"/.exec(disposition);
                if (matches) filename = matches[1];
            }

            // Create blob and download
            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            a.remove();

            // Reset form after successful download
            resetForm();
            alert('PDFs merged successfully!');
        } else {
            const data = await response.json();
            alert('Error: ' + (data.message || 'Failed to merge PDFs'));
            processingStatus.classList.add('d-none');
            mergeBtn.disabled = false;
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while merging PDFs');
        processingStatus.classList.add('d-none');
        mergeBtn.disabled = false;
    }
});
</script>

<style>
.list-group-item {
    border-left: 3px solid #dc3545;
}

#file-list {
    animation: slideIn 0.3s ease-in-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
