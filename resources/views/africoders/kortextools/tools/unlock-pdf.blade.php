{{-- unlock pdf --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    unlock pdf tool for your development and productivity needs.
</div>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-unlock fa-3x text-primary"></i>
                </div>
                <h1 class="h2 mb-3">PDF Password Removal</h1>
                <p class="lead text-muted">
                    Remove password protection from PDF files to make them freely accessible
                </p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="unlock-pdf-form" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="pdf_file" class="form-label">
                                <i class="fas fa-file-pdf me-2"></i>Password-Protected PDF File
                            </label>
                            <div class="drop-zone" id="drop-zone">
                                <div class="drop-zone-content">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <h5>Drop PDF file here or click to browse</h5>
                                    <p class="text-muted">Maximum file size: 50MB</p>
                                </div>
                                <input
                                    type="file"
                                    class="form-control"
                                    id="pdf_file"
                                    name="pdf_file"
                                    accept=".pdf"
                                    required
                                    style="display: none;"
                                >
                            </div>
                            <div id="file-info" class="mt-3" style="display: none;">
                                <div class="alert alert-info">
                                    <i class="fas fa-file-pdf me-2"></i>
                                    <span id="file-name"></span>
                                    <span class="badge bg-secondary ms-2" id="file-size"></span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">
                                <i class="fas fa-key me-2"></i>PDF Password
                            </label>
                            <input
                                type="password"
                                class="form-control form-control-lg"
                                id="password"
                                name="password"
                                placeholder="Enter the current PDF password"
                                required
                            >
                            <small class="form-text text-muted">
                                Enter the password currently protecting this PDF
                            </small>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg" disabled id="unlock-btn">
                                <i class="fas fa-unlock me-2"></i>Remove Password Protection
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Loading State -->
            <div id="loading" class="text-center mt-4" style="display: none;">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <div class="spinner-border text-primary me-3" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span class="text-muted">Removing password protection...</span>
                        <div class="progress mt-3">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results -->
            <div id="results" class="mt-4" style="display: none;">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-unlock-alt me-2"></i>Password Removal Complete
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="results-content"></div>
                    </div>
                </div>
            </div>

            <!-- Security Warning -->
            <div class="alert alert-warning mt-4">
                <h6 class="alert-heading">
                    <i class="fas fa-exclamation-triangle me-2"></i>Security Notice
                </h6>
                <p class="mb-2">
                    <strong>Important:</strong> Only remove password protection from PDFs that you own or have permission to modify.
                </p>
                <ul class="mb-2">
                    <li>This tool requires the correct password to unlock the PDF</li>
                    <li>All files are processed securely and deleted after 1 hour</li>
                    <li>No passwords or file content is stored on our servers</li>
                    <li>Use this tool responsibly and respect copyright laws</li>
                </ul>
            </div>

            <!-- Info Section -->
            <div class="alert alert-info mt-4">
                <h6 class="alert-heading">
                    <i class="fas fa-info-circle me-2"></i>About PDF Password Removal
                </h6>
                <p class="mb-2">
                    This tool can remove different types of PDF protection:
                </p>
                <ul class="mb-2">
                    <li><strong>User Password</strong> - Required to open and view the PDF</li>
                    <li><strong>Owner Password</strong> - Controls editing and permission restrictions</li>
                    <li><strong>Printing Restrictions</strong> - Removes print limitations</li>
                    <li><strong>Copy Protection</strong> - Enables text copying and selection</li>
                    <li><strong>Edit Restrictions</strong> - Allows document modifications</li>
                </ul>
                <p class="mb-0">
                    <small><strong>Best for:</strong> Making your own protected PDFs accessible, legacy document recovery, workflow optimization.</small>
                </p>
            </div>
        </div>
    </div>
</div>

<style>
.drop-zone {
    border: 2px dashed #ddd;
    border-radius: 10px;
    text-align: center;
    padding: 40px 20px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.drop-zone:hover,
.drop-zone.dragover {
    border-color: #007bff;
    background-color: #f8f9fa;
}

.drop-zone-content h5 {
    color: #6c757d;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('pdf_file');
    const fileInfo = document.getElementById('file-info');
    const unlockBtn = document.getElementById('unlock-btn');

    // Click to select file
    dropZone.addEventListener('click', function() {
        fileInput.click();
    });

    // Drag and drop functionality
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropZone.classList.add('dragover');
    });

    dropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        dropZone.classList.remove('dragover');
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropZone.classList.remove('dragover');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelect();
        }
    });

    // File input change
    fileInput.addEventListener('change', handleFileSelect);

    function handleFileSelect() {
        const file = fileInput.files[0];
        if (file) {
            if (file.type !== 'application/pdf') {
                alert('Please select a PDF file');
                return;
            }

            if (file.size > 50 * 1024 * 1024) { // 50MB
                alert('File size must be less than 50MB');
                return;
            }

            document.getElementById('file-name').textContent = file.name;
            document.getElementById('file-size').textContent = formatFileSize(file.size);
            fileInfo.style.display = 'block';
            unlockBtn.disabled = false;
        }
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
});

document.getElementById('unlock-pdf-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const fileInput = document.getElementById('pdf_file');
    const password = document.getElementById('password').value;

    if (!fileInput.files[0]) {
        alert('Please select a PDF file');
        return;
    }

    if (!password.trim()) {
        alert('Please enter the PDF password');
        return;
    }

    // Show loading
    document.getElementById('loading').style.display = 'block';
    document.getElementById('results').style.display = 'none';

    const formData = new FormData();
    formData.append('pdf_file', fileInput.files[0]);
    formData.append('password', password);
    formData.append('_token', document.querySelector('[name="_token"]').value);

    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "unlock-pdf") }}', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        // Hide loading
        document.getElementById('loading').style.display = 'none';

        if (result.success) {
            displayResults(result);
        } else {
            displayError(result.error || 'An error occurred');
        }
    } catch (error) {
        document.getElementById('loading').style.display = 'none';
        displayError('Network error: ' + error.message);
    }
});

function displayResults(result) {
    const fileName = result.filename;
    const downloadUrl = result.download_url;
    const removedRestrictions = result.removed_restrictions || [];

    const html = `
        <div class="alert alert-success mb-4">
            <h5 class="mb-2">
                <i class="fas fa-unlock-alt me-2"></i>
                PDF Successfully Unlocked!
            </h5>
            <p class="mb-0">Password protection has been removed from your PDF file.</p>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-list me-2"></i>Removed Restrictions</h6>
                    </div>
                    <div class="card-body">
                        ${removedRestrictions.length > 0 ? `
                            <div class="row">
                                ${removedRestrictions.map(restriction => `
                                    <div class="col-md-6 mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        ${restriction}
                                    </div>
                                `).join('')}
                            </div>
                        ` : `
                            <div class="text-center text-muted">
                                <i class="fas fa-info-circle me-2"></i>
                                PDF is now completely unlocked and unrestricted
                            </div>
                        `}
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="${downloadUrl}" class="btn btn-success btn-lg" download>
                <i class="fas fa-download me-2"></i>Download Unlocked PDF
            </a>
        </div>

        <div class="alert alert-info mt-3">
            <h6><i class="fas fa-lightbulb me-2"></i>What's Next?</h6>
            <ul class="mb-0">
                <li>Your PDF is now accessible without any password requirements</li>
                <li>All editing, printing, and copying restrictions have been removed</li>
                <li>The unlocked file will be automatically deleted after 1 hour</li>
                <li>Save the file to your device to keep it permanently</li>
            </ul>
        </div>
    `;

    document.getElementById('results-content').innerHTML = html;
    document.getElementById('results').style.display = 'block';
}

function displayError(error) {
    let errorMessage = error;
    let suggestions = [];

    // Provide helpful suggestions based on common errors
    if (error.toLowerCase().includes('password') || error.toLowerCase().includes('incorrect')) {
        suggestions = [
            'Double-check that you entered the correct password',
            'Passwords are case-sensitive',
            'Make sure there are no extra spaces in the password',
            'Try the owner password if the user password doesn\'t work'
        ];
    } else if (error.toLowerCase().includes('encrypted') || error.toLowerCase().includes('protected')) {
        suggestions = [
            'This PDF may have advanced encryption',
            'Some PDFs cannot be unlocked with standard methods',
            'Contact the document owner for assistance'
        ];
    }

    const html = `
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Error:</strong> ${errorMessage}
        </div>

        ${suggestions.length > 0 ? `
            <div class="alert alert-info">
                <h6><i class="fas fa-lightbulb me-2"></i>Suggestions</h6>
                <ul class="mb-0">
                    ${suggestions.map(suggestion => `<li>${suggestion}</li>`).join('')}
                </ul>
            </div>
        ` : ''}
    `;

    document.getElementById('results-content').innerHTML = html;
    document.getElementById('results').style.display = 'block';
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}
</script>

