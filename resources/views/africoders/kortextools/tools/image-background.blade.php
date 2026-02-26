{{-- Image Background Remover --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-cut me-2"></i>
    Remove backgrounds from images automatically using AI. Create transparent PNG images.
</div>
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-cut fa-3x text-primary"></i>
                </div>
                <h1 class="h2 mb-3">Image Background Remover</h1>
                <p class="lead text-muted">
                    Automatically remove backgrounds from images using AI technology. Perfect for creating transparent PNGs
                </p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="background-remover-form" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="image_files" class="form-label">
                                <i class="fas fa-images me-2"></i>Image Files
                            </label>
                            <div class="drop-zone" id="drop-zone">
                                <div class="drop-zone-content">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <h5>Drop images here or click to browse</h5>
                                    <p class="text-muted">Support multiple files • JPG, PNG, WebP • 5MB each</p>
                                </div>
                                <input
                                    type="file"
                                    class="form-control"
                                    id="image_files"
                                    name="image_files[]"
                                    accept="image/jpeg,image/png,image/webp"
                                    multiple
                                    required
                                    style="display: none;"
                                >
                            </div>
                            <div id="files-preview" class="mt-3" style="display: none;"></div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="precision" class="form-label">
                                    <i class="fas fa-crosshairs me-2"></i>Precision Level
                                </label>
                                <select class="form-select" id="precision" name="precision">
                                    <option value="automatic" selected>Automatic (Best for most images)</option>
                                    <option value="high">High Precision (Clean edges)</option>
                                    <option value="fast">Fast Processing (Quick results)</option>
                                </select>
                                <small class="form-text text-muted">
                                    Higher precision takes longer but gives cleaner results
                                </small>
                            </div>
                            <div class="col-md-6">
                                <label for="output_size" class="form-label">
                                    <i class="fas fa-expand-arrows-alt me-2"></i>Output Size
                                </label>
                                <select class="form-select" id="output_size" name="output_size">
                                    <option value="original">Keep Original Size</option>
                                    <option value="hd" selected>HD Quality (1920px max)</option>
                                    <option value="preview">Preview Size (800px max)</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="smooth_edges" name="smooth_edges" checked>
                                        <label class="form-check-label" for="smooth_edges">
                                            <i class="fas fa-bezier-curve me-2"></i>Smooth Edges
                                        </label>
                                        <small class="form-text text-muted">Apply anti-aliasing to edges</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="preserve_details" name="preserve_details">
                                        <label class="form-check-label" for="preserve_details">
                                            <i class="fas fa-eye me-2"></i>Preserve Fine Details
                                        </label>
                                        <small class="form-text text-muted">Keep hair and fur details</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg" disabled id="remove-bg-btn">
                                <i class="fas fa-magic me-2"></i>Remove Background
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
                        <span class="text-muted">Processing images with AI...</span>
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
                            <i class="fas fa-check-circle me-2"></i>Background Removal Complete
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="results-content"></div>
                    </div>
                </div>
            </div>

            <!-- Before/After Comparison -->
            <div id="comparison" class="mt-4" style="display: none;">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-eye me-2"></i>Before & After
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="comparison-content"></div>
                    </div>
                </div>
            </div>

            <!-- Info Section -->
            <div class="alert alert-info mt-4">
                <h6 class="alert-heading">
                    <i class="fas fa-info-circle me-2"></i>AI Background Removal
                </h6>
                <p class="mb-2">
                    Features and capabilities:
                </p>
                <ul class="mb-2">
                    <li><strong>AI-Powered</strong> - Advanced machine learning algorithms</li>
                    <li><strong>Automatic Detection</strong> - Identifies subjects and backgrounds</li>
                    <li><strong>Edge Refinement</strong> - Smooth and natural-looking edges</li>
                    <li><strong>Batch Processing</strong> - Remove backgrounds from multiple images</li>
                    <li><strong>PNG Output</strong> - Transparent background support</li>
                </ul>
                <p class="mb-0">
                    <small><strong>Best for:</strong> Product photos, portraits, social media images, and graphic design projects.</small>
                </p>
            </div>

            <!-- Tips Section -->
            <div class="alert alert-success mt-4">
                <h6 class="alert-heading">
                    <i class="fas fa-lightbulb me-2"></i>Best Results Tips
                </h6>
                <ul class="mb-0">
                    <li>Use high-contrast images (subject vs background)</li>
                    <li>Avoid complex backgrounds with similar colors to the subject</li>
                    <li>Good lighting helps the AI identify the subject better</li>
                    <li>Portrait and product photos work best</li>
                </ul>
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

.image-preview {
    display: inline-block;
    position: relative;
    margin: 5px;
    border: 1px solid #ddd;
    border-radius: 5px;
    overflow: hidden;
}

.image-preview img {
    width: 100px;
    height: 100px;
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
    width: 24px;
    height: 24px;
    font-size: 12px;
    cursor: pointer;
}

.comparison-item {
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 20px;
}

.comparison-images {
    display: flex;
    height: 250px;
}

.comparison-images > div {
    flex: 1;
    position: relative;
    overflow: hidden;
}

.comparison-images img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.comparison-label {
    position: absolute;
    top: 10px;
    left: 10px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
}

.transparent-bg {
    background-image:
        linear-gradient(45deg, #f0f0f0 25%, transparent 25%),
        linear-gradient(-45deg, #f0f0f0 25%, transparent 25%),
        linear-gradient(45deg, transparent 75%, #f0f0f0 75%),
        linear-gradient(-45deg, transparent 75%, #f0f0f0 75%);
    background-size: 20px 20px;
    background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
}
</style>

<script>
let selectedFiles = [];

document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('image_files');
    const filesPreview = document.getElementById('files-preview');
    const removeBgBtn = document.getElementById('remove-bg-btn');

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
            if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
                return false;
            }
            if (file.size > 5 * 1024 * 1024) { // 5MB
                return false;
            }
            return true;
        });

        if (validFiles.length === 0) {
            alert('Please select valid image files (JPG, PNG, WebP, max 5MB each)');
            return;
        }

        if (selectedFiles.length + validFiles.length > 10) {
            alert('Maximum 10 images allowed');
            return;
        }

        selectedFiles = selectedFiles.concat(validFiles);
        updateFilesPreview();
        removeBgBtn.disabled = selectedFiles.length === 0;
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
                <strong>${selectedFiles.length}</strong> image${selectedFiles.length !== 1 ? 's' : ''} selected for background removal
            </div>
            <div id="image-previews"></div>
        `;

        const imagePreviewsContainer = document.getElementById('image-previews');

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewDiv = document.createElement('div');
                previewDiv.className = 'image-preview';
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
        removeBgBtn.disabled = selectedFiles.length === 0;
    };
});

document.getElementById('background-remover-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    if (selectedFiles.length === 0) {
        alert('Please select at least one image');
        return;
    }

    // Show loading
    document.getElementById('loading').style.display = 'block';
    document.getElementById('results').style.display = 'none';
    document.getElementById('comparison').style.display = 'none';

    const formData = new FormData();
    selectedFiles.forEach((file) => {
        formData.append('image_files[]', file);
    });

    formData.append('precision', document.getElementById('precision').value);
    formData.append('output_size', document.getElementById('output_size').value);
    formData.append('smooth_edges', document.getElementById('smooth_edges').checked);
    formData.append('preserve_details', document.getElementById('preserve_details').checked);
    formData.append('_token', document.querySelector('[name="_token"]').value);

    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "image-background") }}', {
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
    const processedCount = result.processed_count || selectedFiles.length;
    const downloadUrl = result.download_url;
    const previews = result.previews || [];

    const html = `
        <div class="alert alert-success mb-4">
            <h5 class="mb-2">
                <i class="fas fa-check-circle me-2"></i>
                Background Removal Complete!
            </h5>
            <div class="text-center">
                <div class="fs-4 text-primary">${processedCount}</div>
                <small class="text-muted">Image${processedCount !== 1 ? 's' : ''} processed with transparent backgrounds</small>
            </div>
        </div>

        <div class="text-center mb-4">
            <a href="${downloadUrl}" class="btn btn-success btn-lg" download>
                <i class="fas fa-download me-2"></i>Download ${processedCount === 1 ? 'PNG Image' : 'ZIP Archive'}
            </a>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-cog me-2"></i>Processing Settings</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2"><strong>Precision:</strong> ${result.precision}</div>
                                <div class="mb-2"><strong>Output Size:</strong> ${result.output_size}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong>Smooth Edges:</strong>
                                    <span class="badge ${result.smooth_edges ? 'bg-success' : 'bg-secondary'}">
                                        ${result.smooth_edges ? 'Applied' : 'Not Applied'}
                                    </span>
                                </div>
                                <div class="mb-2">
                                    <strong>Fine Details:</strong>
                                    <span class="badge ${result.preserve_details ? 'bg-success' : 'bg-secondary'}">
                                        ${result.preserve_details ? 'Preserved' : 'Standard'}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-info mt-3">
            <h6><i class="fas fa-lightbulb me-2"></i>What's Next?</h6>
            <ul class="mb-0">
                <li>Download your images with transparent backgrounds</li>
                <li>Use them in design software, presentations, or web projects</li>
                <li>The processed files will be automatically deleted after 1 hour</li>
                <li>PNG format preserves transparency across all platforms</li>
            </ul>
        </div>
    `;

    document.getElementById('results-content').innerHTML = html;
    document.getElementById('results').style.display = 'block';

    // Show comparison if previews are available
    if (previews.length > 0) {
        displayComparison(previews);
    }
}

function displayComparison(previews) {
    let comparisonHtml = '';

    previews.forEach((preview, index) => {
        comparisonHtml += `
            <div class="comparison-item">
                <div class="comparison-images">
                    <div>
                        <div class="comparison-label">Original</div>
                        <img src="${preview.original}" alt="Original">
                    </div>
                    <div class="transparent-bg">
                        <div class="comparison-label">Background Removed</div>
                        <img src="${preview.processed}" alt="Processed">
                    </div>
                </div>
            </div>
        `;
    });

    document.getElementById('comparison-content').innerHTML = comparisonHtml;
    document.getElementById('comparison').style.display = 'block';
}

function displayError(error) {
    const html = `
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Error:</strong> ${error}
        </div>

        <div class="alert alert-info">
            <h6><i class="fas fa-lightbulb me-2"></i>Troubleshooting</h6>
            <ul class="mb-0">
                <li>Make sure images are in JPG, PNG, or WebP format</li>
                <li>Check that files are under 5MB each</li>
                <li>Try with fewer images if processing fails</li>
                <li>Images with clear subject-background contrast work best</li>
                <li>Very complex backgrounds may not process perfectly</li>
            </ul>
        </div>
    `;

    document.getElementById('results-content').innerHTML = html;
    document.getElementById('results').style.display = 'block';
}
</script>
