{{-- jpg to pdf --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    jpg to pdf tool for your development and productivity needs.
</div>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-file-image fa-3x text-info me-2"></i>
                    <i class="fas fa-arrow-right fa-2x text-muted me-2"></i>
                    <i class="fas fa-file-pdf fa-3x text-danger"></i>
                </div>
                <h1 class="h2 mb-3">JPG to PDF Converter</h1>
                <p class="lead text-muted">
                    Convert JPG images to PDF format. Upload multiple images to create a single PDF document
                </p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="jpg-to-pdf-form" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="jpg_files" class="form-label">
                                <i class="fas fa-file-image me-2"></i>JPG Images
                            </label>
                            <div class="drop-zone" id="drop-zone">
                                <div class="drop-zone-content">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <h5>Drop JPG images here or click to browse</h5>
                                    <p class="text-muted">Select multiple images • Maximum 20 files • 10MB each</p>
                                </div>
                                <input
                                    type="file"
                                    class="form-control"
                                    id="jpg_files"
                                    name="jpg_files[]"
                                    accept=".jpg,.jpeg"
                                    multiple
                                    required
                                    style="display: none;"
                                >
                            </div>
                            <div id="files-preview" class="mt-3" style="display: none;"></div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="page_size" class="form-label">
                                    <i class="fas fa-file me-2"></i>Page Size
                                </label>
                                <select class="form-select" id="page_size" name="page_size">
                                    <option value="auto">Auto (Fit Image)</option>
                                    <option value="A4">A4</option>
                                    <option value="Letter">Letter</option>
                                    <option value="A3">A3</option>
                                    <option value="Legal">Legal</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="orientation" class="form-label">
                                    <i class="fas fa-rotate me-2"></i>Orientation
                                </label>
                                <select class="form-select" id="orientation" name="orientation">
                                    <option value="auto">Auto</option>
                                    <option value="portrait">Portrait</option>
                                    <option value="landscape">Landscape</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="image_quality" class="form-label">
                                    <i class="fas fa-sliders-h me-2"></i>Image Quality
                                </label>
                                <select class="form-select" id="image_quality" name="image_quality">
                                    <option value="high">High Quality</option>
                                    <option value="medium" selected>Medium Quality</option>
                                    <option value="low">Low Quality (Smaller File)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="margin" class="form-label">
                                    <i class="fas fa-border-style me-2"></i>Page Margins
                                </label>
                                <select class="form-select" id="margin" name="margin">
                                    <option value="none">No Margins</option>
                                    <option value="small" selected>Small Margins</option>
                                    <option value="medium">Medium Margins</option>
                                    <option value="large">Large Margins</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg" disabled id="convert-btn">
                                <i class="fas fa-exchange-alt me-2"></i>Convert to PDF
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
                        <span class="text-muted">Converting images to PDF...</span>
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
                            <i class="fas fa-check-circle me-2"></i>Conversion Complete
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
                    <i class="fas fa-info-circle me-2"></i>JPG to PDF Conversion
                </h6>
                <p class="mb-2">
                    Features and options:
                </p>
                <ul class="mb-2">
                    <li><strong>Multiple Images</strong> - Combine up to 20 JPG files in one PDF</li>
                    <li><strong>Page Sizing</strong> - Auto-fit images or use standard page sizes</li>
                    <li><strong>Quality Control</strong> - Adjust compression for file size optimization</li>
                    <li><strong>Orientation</strong> - Automatic or manual page orientation</li>
                    <li><strong>Margins</strong> - Add spacing around images on pages</li>
                </ul>
                <p class="mb-0">
                    <small><strong>Best for:</strong> Photo albums, document scanning, image archiving, and creating portfolios.</small>
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
    border-color: #17a2b8;
    background-color: #f8f9fa;
}

.drop-zone-content h5 {
    color: #6c757d;
}

.image-preview {
    display: inline-block;
    position: relative;
    margin: 5px;
    border: 1px solid #ddd;
    border-radius: 5px;
    overflow: hidden;
}

.image-preview img {
    width: 80px;
    height: 80px;
    object-fit: cover;
}

.image-preview .remove-btn {
    position: absolute;
    top: 2px;
    right: 2px;
    background: rgba(220, 53, 69, 0.8);
    color: white;
    border: none;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 12px;
    cursor: pointer;
}

.sortable {
    min-height: 100px;
}
</style>

<script>
let selectedFiles = [];

document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('jpg_files');
    const filesPreview = document.getElementById('files-preview');
    const convertBtn = document.getElementById('convert-btn');

    // Click to select files
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

        const files = Array.from(e.dataTransfer.files);
        handleFileSelect(files);
    });

    // File input change
    fileInput.addEventListener('change', function() {
        const files = Array.from(this.files);
        handleFileSelect(files);
    });

    function handleFileSelect(files) {
        const validFiles = files.filter(file => {
            if (!file.type.match('image/jpeg')) {
                return false;
            }
            if (file.size > 10 * 1024 * 1024) { // 10MB
                return false;
            }
            return true;
        });

        if (validFiles.length === 0) {
            alert('Please select valid JPG files (max 10MB each)');
            return;
        }

        if (selectedFiles.length + validFiles.length > 20) {
            alert('Maximum 20 images allowed');
            return;
        }

        selectedFiles = selectedFiles.concat(validFiles);
        updateFilesPreview();
        convertBtn.disabled = selectedFiles.length === 0;
    }

    function updateFilesPreview() {
        if (selectedFiles.length === 0) {
            filesPreview.style.display = 'none';
            return;
        }

        filesPreview.style.display = 'block';
        filesPreview.innerHTML = `
            <div class="alert alert-success">
                <i class="fas fa-images me-2"></i>
                <strong>${selectedFiles.length}</strong> image${selectedFiles.length !== 1 ? 's' : ''} selected
            </div>
            <div id="image-previews" class="sortable"></div>
            <small class="text-muted">
                <i class="fas fa-hand-paper me-1"></i>Drag images to reorder them in the PDF
            </small>
        `;

        const imagePreviewsContainer = document.getElementById('image-previews');

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewDiv = document.createElement('div');
                previewDiv.className = 'image-preview';
                previewDiv.draggable = true;
                previewDiv.innerHTML = `
                    <img src="${e.target.result}" alt="${file.name}">
                    <button type="button" class="remove-btn" onclick="removeImage(${index})">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                imagePreviewsContainer.appendChild(previewDiv);
            };
            reader.readAsDataURL(file);
        });
    }

    window.removeImage = function(index) {
        selectedFiles.splice(index, 1);
        updateFilesPreview();
        convertBtn.disabled = selectedFiles.length === 0;
    };
});

document.getElementById('jpg-to-pdf-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    if (selectedFiles.length === 0) {
        alert('Please select at least one JPG image');
        return;
    }

    // Show loading
    document.getElementById('loading').style.display = 'block';
    document.getElementById('results').style.display = 'none';

    const formData = new FormData();
    selectedFiles.forEach((file, index) => {
        formData.append('jpg_files[]', file);
    });

    formData.append('page_size', document.getElementById('page_size').value);
    formData.append('orientation', document.getElementById('orientation').value);
    formData.append('image_quality', document.getElementById('image_quality').value);
    formData.append('margin', document.getElementById('margin').value);
    formData.append('_token', document.querySelector('[name="_token"]').value);

    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "jpg-to-pdf") }}', {
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
    const imageCount = result.image_count || selectedFiles.length;
    const fileSize = result.file_size;

    const html = `
        <div class="alert alert-success mb-4">
            <h5 class="mb-2">
                <i class="fas fa-check-circle me-2"></i>
                Images Successfully Converted to PDF!
            </h5>
            <div class="row text-center">
                <div class="col-6">
                    <div class="border-end">
                        <div class="fs-4 text-primary">${imageCount}</div>
                        <small class="text-muted">Image${imageCount !== 1 ? 's' : ''} Converted</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="fs-4 text-primary">${formatFileSize(fileSize)}</div>
                    <small class="text-muted">PDF File Size</small>
                </div>
            </div>
        </div>

        <div class="text-center mb-4">
            <a href="${downloadUrl}" class="btn btn-success btn-lg" download>
                <i class="fas fa-download me-2"></i>Download PDF
            </a>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-cog me-2"></i>Conversion Settings</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2"><strong>Page Size:</strong> ${result.page_size}</div>
                                <div class="mb-2"><strong>Orientation:</strong> ${result.orientation}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2"><strong>Image Quality:</strong> ${result.image_quality}</div>
                                <div class="mb-2"><strong>Margins:</strong> ${result.margin}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-info mt-3">
            <h6><i class="fas fa-lightbulb me-2"></i>Tips</h6>
            <ul class="mb-0">
                <li>The converted PDF will be automatically deleted after 1 hour</li>
                <li>Images are arranged in the order you selected them</li>
                <li>Each image becomes a separate page in the PDF</li>
                <li>High quality images create larger PDF files</li>
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

        <div class="alert alert-info">
            <h6><i class="fas fa-lightbulb me-2"></i>Common Issues</h6>
            <ul class="mb-0">
                <li>Make sure all files are valid JPG/JPEG images</li>
                <li>Check that no individual file exceeds 10MB</li>
                <li>Ensure you haven't selected more than 20 images</li>
                <li>Try reducing image file sizes if conversion fails</li>
            </ul>
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

