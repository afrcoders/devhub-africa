{{-- Image Format Converter --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-image me-2"></i>
    Convert images between different formats: JPG, PNG, GIF, BMP, WebP, and more.
</div>
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-image fa-3x text-primary"></i>
                </div>
                <h1 class="h2 mb-3">Image Format Converter</h1>
                <p class="lead text-muted">
                    Convert images between popular formats including JPG, PNG, GIF, BMP, WebP, and TIFF
                </p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="image-converter-form" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="image_files" class="form-label">
                                <i class="fas fa-images me-2"></i>Image Files
                            </label>
                            <div class="drop-zone" id="drop-zone">
                                <div class="drop-zone-content">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <h5>Drop images here or click to browse</h5>
                                    <p class="text-muted">Support multiple files • JPG, PNG, GIF, BMP, WebP, TIFF • 10MB each</p>
                                </div>
                                <input
                                    type="file"
                                    class="form-control"
                                    id="image_files"
                                    name="image_files[]"
                                    accept="image/*"
                                    multiple
                                    required
                                    style="display: none;"
                                >
                            </div>
                            <div id="files-preview" class="mt-3" style="display: none;"></div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="output_format" class="form-label">
                                    <i class="fas fa-exchange-alt me-2"></i>Convert To
                                </label>
                                <select class="form-select form-select-lg" id="output_format" name="output_format" required>
                                    <option value="">Select output format...</option>
                                    <option value="jpg">JPG (JPEG)</option>
                                    <option value="png">PNG</option>
                                    <option value="gif">GIF</option>
                                    <option value="bmp">BMP</option>
                                    <option value="webp">WebP</option>
                                    <option value="tiff">TIFF</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="quality" class="form-label">
                                    <i class="fas fa-sliders-h me-2"></i>Quality (for JPG/WebP)
                                </label>
                                <select class="form-select" id="quality" name="quality">
                                    <option value="95">High (95%)</option>
                                    <option value="85" selected>Medium (85%)</option>
                                    <option value="75">Low (75%)</option>
                                    <option value="60">Very Low (60%)</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="resize_option" class="form-label">
                                    <i class="fas fa-expand-arrows-alt me-2"></i>Resize Images
                                </label>
                                <select class="form-select" id="resize_option" name="resize_option">
                                    <option value="none">Keep Original Size</option>
                                    <option value="percentage">Resize by Percentage</option>
                                    <option value="dimensions">Specific Dimensions</option>
                                    <option value="max_width">Max Width</option>
                                </select>
                            </div>
                            <div class="col-md-6" id="resize-controls" style="display: none;">
                                <label class="form-label" id="resize-label">Resize Value</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="resize_value" name="resize_value" min="1" placeholder="100">
                                    <span class="input-group-text" id="resize-unit">%</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4" id="dimensions-input" style="display: none;">
                            <div class="col-md-6">
                                <label for="width" class="form-label">Width (px)</label>
                                <input type="number" class="form-control" id="width" name="width" min="1" placeholder="800">
                            </div>
                            <div class="col-md-6">
                                <label for="height" class="form-label">Height (px)</label>
                                <input type="number" class="form-control" id="height" name="height" min="1" placeholder="600">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="maintain_aspect" name="maintain_aspect" checked>
                                    <label class="form-check-label" for="maintain_aspect">
                                        Maintain aspect ratio
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg" disabled id="convert-btn">
                                <i class="fas fa-magic me-2"></i>Convert Images
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
                        <span class="text-muted">Converting images...</span>
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

            <!-- Format Guide -->
            <div class="alert alert-info mt-4">
                <h6 class="alert-heading">
                    <i class="fas fa-info-circle me-2"></i>Image Format Guide
                </h6>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="mb-2">
                            <li><strong>JPG</strong> - Best for photos, smaller file sizes</li>
                            <li><strong>PNG</strong> - Supports transparency, lossless</li>
                            <li><strong>GIF</strong> - Supports animation, limited colors</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="mb-0">
                            <li><strong>WebP</strong> - Modern format, great compression</li>
                            <li><strong>BMP</strong> - Uncompressed, large file sizes</li>
                            <li><strong>TIFF</strong> - High quality, used in printing</li>
                        </ul>
                    </div>
                </div>
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

.image-preview .format-badge {
    position: absolute;
    bottom: 2px;
    left: 2px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    font-size: 10px;
    padding: 2px 4px;
    border-radius: 3px;
}
</style>

<script>
let selectedFiles = [];

document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('image_files');
    const filesPreview = document.getElementById('files-preview');
    const convertBtn = document.getElementById('convert-btn');
    const outputFormat = document.getElementById('output_format');
    const resizeOption = document.getElementById('resize_option');
    const resizeControls = document.getElementById('resize-controls');
    const dimensionsInput = document.getElementById('dimensions-input');
    const resizeLabel = document.getElementById('resize-label');
    const resizeUnit = document.getElementById('resize-unit');

    // Handle resize option changes
    resizeOption.addEventListener('change', function() {
        const option = this.value;
        resizeControls.style.display = option === 'none' ? 'none' : 'block';
        dimensionsInput.style.display = option === 'dimensions' ? 'block' : 'none';

        switch(option) {
            case 'percentage':
                resizeLabel.textContent = 'Percentage';
                resizeUnit.textContent = '%';
                document.getElementById('resize_value').placeholder = '100';
                break;
            case 'max_width':
                resizeLabel.textContent = 'Max Width';
                resizeUnit.textContent = 'px';
                document.getElementById('resize_value').placeholder = '1920';
                break;
            case 'dimensions':
                resizeLabel.textContent = 'Width';
                resizeUnit.textContent = 'px';
                break;
        }
    });

    // Enable/disable convert button based on format selection
    outputFormat.addEventListener('change', function() {
        convertBtn.disabled = !this.value || selectedFiles.length === 0;
    });

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
            if (!file.type.startsWith('image/')) {
                return false;
            }
            if (file.size > 10 * 1024 * 1024) { // 10MB
                return false;
            }
            return true;
        });

        if (validFiles.length === 0) {
            alert('Please select valid image files (max 10MB each)');
            return;
        }

        selectedFiles = selectedFiles.concat(validFiles);
        updateFilesPreview();
        convertBtn.disabled = !outputFormat.value || selectedFiles.length === 0;
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
            <div id="image-previews"></div>
        `;

        const imagePreviewsContainer = document.getElementById('image-previews');

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const fileExtension = file.name.split('.').pop().toUpperCase();
                const previewDiv = document.createElement('div');
                previewDiv.className = 'image-preview';
                previewDiv.innerHTML = `
                    <img src="${e.target.result}" alt="${file.name}">
                    <div class="format-badge">${fileExtension}</div>
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
        convertBtn.disabled = !outputFormat.value || selectedFiles.length === 0;
    };
});

document.getElementById('image-converter-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    if (selectedFiles.length === 0) {
        alert('Please select at least one image');
        return;
    }

    const outputFormat = document.getElementById('output_format').value;
    if (!outputFormat) {
        alert('Please select an output format');
        return;
    }

    // Show loading
    document.getElementById('loading').style.display = 'block';
    document.getElementById('results').style.display = 'none';

    const formData = new FormData();
    selectedFiles.forEach((file, index) => {
        formData.append('image_files[]', file);
    });

    formData.append('output_format', outputFormat);
    formData.append('quality', document.getElementById('quality').value);
    formData.append('resize_option', document.getElementById('resize_option').value);
    formData.append('resize_value', document.getElementById('resize_value').value);
    formData.append('width', document.getElementById('width').value);
    formData.append('height', document.getElementById('height').value);
    formData.append('maintain_aspect', document.getElementById('maintain_aspect').checked);
    formData.append('_token', document.querySelector('[name="_token"]').value);

    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "image-converter") }}', {
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
    const convertedCount = result.converted_count || selectedFiles.length;
    const downloadUrl = result.download_url;
    const outputFormat = result.output_format.toUpperCase();

    const html = `
        <div class="alert alert-success mb-4">
            <h5 class="mb-2">
                <i class="fas fa-check-circle me-2"></i>
                Images Successfully Converted!
            </h5>
            <div class="text-center">
                <div class="fs-4 text-primary">${convertedCount}</div>
                <small class="text-muted">Image${convertedCount !== 1 ? 's' : ''} converted to ${outputFormat}</small>
            </div>
        </div>

        <div class="text-center mb-4">
            <a href="${downloadUrl}" class="btn btn-success btn-lg" download>
                <i class="fas fa-download me-2"></i>Download ${convertedCount === 1 ? 'Image' : 'ZIP Archive'}
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
                                <div class="mb-2"><strong>Output Format:</strong> ${outputFormat}</div>
                                <div class="mb-2"><strong>Quality:</strong> ${result.quality}%</div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2"><strong>Resize:</strong> ${result.resize_info}</div>
                                <div class="mb-2"><strong>Total Size:</strong> ${formatFileSize(result.total_size)}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-info mt-3">
            <h6><i class="fas fa-lightbulb me-2"></i>Tips</h6>
            <ul class="mb-0">
                <li>The converted files will be automatically deleted after 1 hour</li>
                <li>${convertedCount === 1 ? 'Your image has' : 'Multiple images have'} been packaged ${convertedCount === 1 ? '' : 'in a ZIP file'} for download</li>
                <li>Check the image quality and adjust settings if needed for future conversions</li>
                <li>WebP format offers the best compression while maintaining quality</li>
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
                <li>Make sure all files are valid image formats</li>
                <li>Check that no individual file exceeds 10MB</li>
                <li>Some image formats may not support transparency</li>
                <li>Try reducing the number of images if processing fails</li>
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
