{{-- protect pdf --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    protect pdf tool for your development and productivity needs.
</div>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-lock fa-3x text-primary"></i>
                </div>
                <h1 class="h2 mb-3">PDF Password Protection</h1>
                <p class="lead text-muted">
                    Secure your PDF documents by adding password protection and access restrictions
                </p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="protect-pdf-form" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="pdf_file" class="form-label">
                                <i class="fas fa-file-pdf me-2"></i>PDF File
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

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="user_password" class="form-label">
                                    <i class="fas fa-key me-2"></i>User Password
                                </label>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="user_password"
                                    name="user_password"
                                    placeholder="Password to open PDF"
                                    required
                                >
                                <small class="form-text text-muted">
                                    Required to open and view the PDF
                                </small>
                            </div>
                            <div class="col-md-6">
                                <label for="owner_password" class="form-label">
                                    <i class="fas fa-shield-alt me-2"></i>Owner Password (Optional)
                                </label>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="owner_password"
                                    name="owner_password"
                                    placeholder="Password to modify PDF"
                                >
                                <small class="form-text text-muted">
                                    Required to change permissions
                                </small>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-cog me-2"></i>Permissions
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="allow_printing" name="permissions[]" value="printing">
                                        <label class="form-check-label" for="allow_printing">
                                            <i class="fas fa-print me-2"></i>Allow Printing
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="allow_copying" name="permissions[]" value="copying">
                                        <label class="form-check-label" for="allow_copying">
                                            <i class="fas fa-copy me-2"></i>Allow Text Copying
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="allow_editing" name="permissions[]" value="editing">
                                        <label class="form-check-label" for="allow_editing">
                                            <i class="fas fa-edit me-2"></i>Allow Editing
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="allow_annotations" name="permissions[]" value="annotations">
                                        <label class="form-check-label" for="allow_annotations">
                                            <i class="fas fa-comment me-2"></i>Allow Annotations
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg" disabled id="protect-btn">
                                <i class="fas fa-lock me-2"></i>Protect PDF
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
                        <span class="text-muted">Protecting PDF...</span>
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
                            <i class="fas fa-shield-check me-2"></i>PDF Protected Successfully
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="results-content"></div>
                    </div>
                </div>
            </div>

            <!-- Info Section -->
            <div class="alert alert-info mt-4">
                <h6 class="alert-heading">
                    <i class="fas fa-info-circle me-2"></i>About PDF Protection
                </h6>
                <p class="mb-2">
                    PDF password protection provides two levels of security:
                </p>
                <ul class="mb-2">
                    <li><strong>User Password</strong> - Required to open and view the PDF document</li>
                    <li><strong>Owner Password</strong> - Required to change security settings and permissions</li>
                    <li><strong>Permissions</strong> - Control what users can do with the document</li>
                    <li><strong>Encryption</strong> - Uses strong encryption to protect document content</li>
                </ul>
                <p class="mb-0">
                    <small><strong>Best for:</strong> Confidential documents, contracts, reports, and any sensitive PDF content.</small>
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
    const protectBtn = document.getElementById('protect-btn');

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
            protectBtn.disabled = false;
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

document.getElementById('protect-pdf-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const fileInput = document.getElementById('pdf_file');
    const userPassword = document.getElementById('user_password').value;
    const ownerPassword = document.getElementById('owner_password').value;

    if (!fileInput.files[0]) {
        alert('Please select a PDF file');
        return;
    }

    if (!userPassword.trim()) {
        alert('Please enter a user password');
        return;
    }

    // Show loading
    document.getElementById('loading').style.display = 'block';
    document.getElementById('results').style.display = 'none';

    const formData = new FormData();
    formData.append('pdf_file', fileInput.files[0]);
    formData.append('user_password', userPassword);
    formData.append('owner_password', ownerPassword);

    // Get permissions
    const permissions = [];
    document.querySelectorAll('input[name="permissions[]"]:checked').forEach(checkbox => {
        permissions.push(checkbox.value);
    });
    formData.append('permissions', JSON.stringify(permissions));

    formData.append('_token', document.querySelector('[name="_token"]').value);

    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "protect-pdf") }}', {
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
    const permissions = result.permissions;

    const html = `
        <div class="alert alert-success mb-4">
            <h5 class="mb-2">
                <i class="fas fa-shield-check me-2"></i>
                PDF Successfully Protected!
            </h5>
            <p class="mb-0">Your PDF has been secured with password protection and the specified permissions.</p>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-cog me-2"></i>Applied Security Settings</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <i class="fas fa-key me-2 text-primary"></i>
                                    <strong>User Password:</strong> <span class="badge bg-success">Set</span>
                                </div>
                                <div class="mb-2">
                                    <i class="fas fa-shield-alt me-2 text-primary"></i>
                                    <strong>Owner Password:</strong>
                                    <span class="badge ${result.has_owner_password ? 'bg-success' : 'bg-secondary'}">
                                        ${result.has_owner_password ? 'Set' : 'Not Set'}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2"><strong>Permissions:</strong></div>
                                <div>
                                    ${permissions.length > 0 ?
                                        permissions.map(permission => `
                                            <span class="badge bg-info me-1">${permission}</span>
                                        `).join('')
                                        : '<span class="badge bg-warning">No permissions granted</span>'
                                    }
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="${downloadUrl}" class="btn btn-success btn-lg" download>
                <i class="fas fa-download me-2"></i>Download Protected PDF
            </a>
        </div>

        <div class="alert alert-warning mt-3">
            <h6><i class="fas fa-exclamation-triangle me-2"></i>Important Notes</h6>
            <ul class="mb-0">
                <li>Keep your passwords safe - they cannot be recovered if lost</li>
                <li>The protected file will be automatically deleted after 1 hour</li>
                <li>Password protection uses industry-standard encryption</li>
                <li>Some PDF viewers may not support all permission restrictions</li>
            </ul>
        </div>
    `;

    document.getElementById('results-content').innerHTML = html;
    document.getElementById('results').style.display = 'block';
}

function displayError(error) {
    const html = `
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Error:</strong> ${error}
        </div>
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

