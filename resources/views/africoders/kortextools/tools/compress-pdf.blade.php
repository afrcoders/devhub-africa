{{-- compress pdf --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    compress pdf tool for your development and productivity needs.
</div>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-compress fa-3x text-primary"></i>
                </div>
                <h1 class="h2 mb-3">PDF Compressor</h1>
                <p class="lead text-muted">
                    Reduce PDF file size while maintaining document quality for easier sharing and storage
                </p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="compress-pdf-form" enctype="multipart/form-data">
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

                        <div class="mb-4">
                            <label for="compression_level" class="form-label">
                                <i class="fas fa-sliders-h me-2"></i>Compression Level
                            </label>
                            <select class="form-select" id="compression_level" name="compression_level">
                                <option value="low">Low Compression (Better Quality)</option>
                                <option value="medium" selected>Medium Compression (Balanced)</option>
                                <option value="high">High Compression (Smaller Size)</option>
                            </select>
                            <small class="form-text text-muted">
                                Higher compression reduces file size but may affect image quality
                            </small>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg" disabled id="compress-btn">
                                <i class="fas fa-compress me-2"></i>Compress PDF
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
                        <span class="text-muted">Compressing PDF...</span>
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
                            <i class="fas fa-check-circle me-2"></i>Compression Complete
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
                    <i class="fas fa-info-circle me-2"></i>About PDF Compression
                </h6>
                <p class="mb-2">
                    PDF compression techniques used:
                </p>
                <ul class="mb-2">
                    <li><strong>Image Optimization</strong> - Reduces image file sizes within the PDF</li>
                    <li><strong>Font Subsetting</strong> - Includes only used characters from fonts</li>
                    <li><strong>Stream Compression</strong> - Compresses text and vector content</li>
                    <li><strong>Object Deduplication</strong> - Removes duplicate objects</li>
                    <li><strong>Metadata Cleanup</strong> - Removes unnecessary metadata</li>
                </ul>
                <p class="mb-0">
                    <small><strong>Best for:</strong> Reducing file sizes for email, web uploads, or storage optimization.</small>
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
    const compressBtn = document.getElementById('compress-btn');

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
            compressBtn.disabled = false;
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

document.getElementById('compress-pdf-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const fileInput = document.getElementById('pdf_file');
    const compressionLevel = document.getElementById('compression_level').value;

    if (!fileInput.files[0]) {
        alert('Please select a PDF file');
        return;
    }

    // Show loading
    document.getElementById('loading').style.display = 'block';
    document.getElementById('results').style.display = 'none';

    const formData = new FormData();
    formData.append('pdf_file', fileInput.files[0]);
    formData.append('compression_level', compressionLevel);
    formData.append('_token', document.querySelector('[name="_token"]').value);

    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "compress-pdf") }}', {
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
    const originalSize = result.original_size;
    const compressedSize = result.compressed_size;
    const compressionRatio = ((originalSize - compressedSize) / originalSize * 100).toFixed(1);
    const downloadUrl = result.download_url;

    const html = `
        <div class="row">
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="text-muted">Original Size</h6>
                        <div class="fs-4 text-secondary">${formatFileSize(originalSize)}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="text-muted">Compressed Size</h6>
                        <div class="fs-4 text-success">${formatFileSize(compressedSize)}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center my-4">
            <div class="alert alert-success">
                <h5 class="mb-2">
                    <i class="fas fa-check-circle me-2"></i>
                    Size Reduced by ${compressionRatio}%
                </h5>
                <p class="mb-0">You saved ${formatFileSize(originalSize - compressedSize)} of storage space!</p>
            </div>
        </div>

        <div class="text-center">
            <a href="${downloadUrl}" class="btn btn-success btn-lg" download>
                <i class="fas fa-download me-2"></i>Download Compressed PDF
            </a>
        </div>

        <div class="alert alert-info mt-3">
            <h6><i class="fas fa-lightbulb me-2"></i>Tips</h6>
            <ul class="mb-0">
                <li>The compressed file will be automatically deleted after 1 hour</li>
                <li>For best results, use medium compression level</li>
                <li>Large images in PDFs benefit most from compression</li>
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

