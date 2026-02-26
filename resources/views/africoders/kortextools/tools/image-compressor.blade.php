<div class="row">
    <div class="col-md-12">
        <!-- Image Upload -->
        <div class="mb-4">
            <label for="imageInput" class="form-label">Select Image to Compress</label>
            <input type="file" class="form-control" id="imageInput" accept="image/*" onchange="handleImageUpload(event)">
            <div class="form-text">
                <small class="text-muted">Supports JPG, PNG, WebP, BMP formats. Max size: 10MB</small>
            </div>
        </div>

        <!-- Drag and Drop Zone -->
        <div class="mb-4">
            <div id="dropZone" class="border border-dashed rounded p-4 text-center">
                <i class="bi bi-cloud-upload display-4 text-muted"></i>
                <p class="mt-2 mb-0">Drag and drop an image here or click to browse</p>
            </div>
        </div>

        <!-- Compression Settings -->
        <div id="compressionSettings" style="display: none;">
            <div class="mb-4">
                <label for="quality" class="form-label">Quality Level</label>
                <div class="d-flex align-items-center gap-3">
                    <input type="range" class="form-range" id="quality" min="1" max="100" value="75">
                    <span id="qualityValue" class="badge bg-primary">75%</span>
                </div>
                <div class="row mt-2">
                    <div class="col-3"><small class="text-muted">Smallest</small></div>
                    <div class="col-6 text-center"><small class="text-muted">Balanced</small></div>
                    <div class="col-3 text-end"><small class="text-muted">Best Quality</small></div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="maxWidth" class="form-label">Max Width (px)</label>
                    <input type="number" class="form-control" id="maxWidth" placeholder="Original width" min="1">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="maxHeight" class="form-label">Max Height (px)</label>
                    <input type="number" class="form-control" id="maxHeight" placeholder="Original height" min="1">
                </div>
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="maintainAspect" checked>
                    <label class="form-check-label" for="maintainAspect">
                        Maintain aspect ratio when resizing
                    </label>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div id="actionButtons" style="display: none;" class="mb-4">
            <button type="button" class="btn btn-primary" onclick="compressImage()">
                <i class="fas fa-compress"></i> Compress Image
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="resetAll()">
                <i class="bi bi-x-circle"></i> Clear
            </button>
        </div>

        <!-- Original Image Preview -->
        <div id="originalPreview" style="display: none;" class="mb-4">
            <h6>Original Image:</h6>
            <div class="row">
                <div class="col-md-6">
                    <img id="originalImage" class="img-fluid rounded border" style="max-height: 300px;">
                </div>
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <th>Filename</th>
                                    <td id="originalFilename">-</td>
                                </tr>
                                <tr>
                                    <th>Size</th>
                                    <td id="originalFileSize">-</td>
                                </tr>
                                <tr>
                                    <th>Dimensions</th>
                                    <td id="originalDimensions">-</td>
                                </tr>
                                <tr>
                                    <th>Type</th>
                                    <td id="originalType">-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Compressed Image Results -->
        <div id="compressionResults" style="display: none;">
            <h6>Compressed Image:</h6>
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="text-center p-3 bg-success text-white rounded">
                        <h5 id="compressionRatio" class="mb-1">0%</h5>
                        <small>Size Reduction</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-3 bg-info text-white rounded">
                        <h5 id="newFileSize" class="mb-1">0 KB</h5>
                        <small>New Size</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-3 bg-primary text-white rounded">
                        <h5 id="qualityUsed" class="mb-1">0%</h5>
                        <small>Quality Used</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <img id="compressedImage" class="img-fluid rounded border" style="max-height: 300px;">
                </div>
                <div class="col-md-6">
                    <div class="comparison-stats">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Original</th>
                                        <th>Compressed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Size</th>
                                        <td id="originalSizeCompare">-</td>
                                        <td id="compressedSizeCompare">-</td>
                                    </tr>
                                    <tr>
                                        <th>Dimensions</th>
                                        <td id="originalDimensionsCompare">-</td>
                                        <td id="compressedDimensionsCompare">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="button" class="btn btn-success" onclick="downloadCompressed()">
                    <i class="bi bi-download"></i> Download Compressed Image
                </button>
                <button type="button" class="btn btn-outline-primary" onclick="compressAnother()">
                    <i class="bi bi-arrow-repeat"></i> Compress Another
                </button>
            </div>
        </div>

        <!-- Processing Indicator -->
        <div id="processingIndicator" style="display: none;" class="text-center p-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Compressing...</span>
            </div>
            <p class="mt-2">Compressing image, please wait...</p>
        </div>
    </div>
</div>

<!-- Information -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> About Image Compression</h6>
    <p class="mb-0">
        This tool reduces image file size by adjusting quality and optionally resizing dimensions.
        Lower quality settings result in smaller files but may reduce image clarity. The tool uses
        client-side compression, so your images never leave your device.
    </p>
</div>

<style>
#dropZone {
    cursor: pointer;
    transition: all 0.3s ease;
}

#dropZone:hover {
    background-color: #f8f9fa;
    border-color: #007bff;
}

#dropZone.dragover {
    background-color: #e3f2fd;
    border-color: #2196f3;
    transform: scale(1.02);
}

.comparison-stats {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
}
</style>

<script>
let originalFile = null;
let compressedBlob = null;

// Drag and drop functionality
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('imageInput');

dropZone.addEventListener('click', () => fileInput.click());

dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('dragover');
});

dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('dragover');
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('dragover');
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        handleImageUpload({ target: { files: files } });
    }
});

// Quality slider
document.getElementById('quality').addEventListener('input', function() {
    document.getElementById('qualityValue').textContent = this.value + '%';
});

function handleImageUpload(event) {
    const file = event.target.files[0];
    if (!file) return;

    if (!file.type.startsWith('image/')) {
        alert('Please select a valid image file.');
        return;
    }

    if (file.size > 10 * 1024 * 1024) { // 10MB limit
        alert('File size must be less than 10MB.');
        return;
    }

    originalFile = file;

    // Show image preview and settings
    const reader = new FileReader();
    reader.onload = function(e) {
        const img = new Image();
        img.onload = function() {
            document.getElementById('originalImage').src = e.target.result;
            document.getElementById('originalFilename').textContent = file.name;
            document.getElementById('originalFileSize').textContent = formatFileSize(file.size);
            document.getElementById('originalDimensions').textContent = `${img.width} × ${img.height}`;
            document.getElementById('originalType').textContent = file.type;

            // Set max dimensions to original dimensions
            document.getElementById('maxWidth').placeholder = `${img.width} (original)`;
            document.getElementById('maxHeight').placeholder = `${img.height} (original)`;

            // Show UI elements
            document.getElementById('compressionSettings').style.display = 'block';
            document.getElementById('actionButtons').style.display = 'block';
            document.getElementById('originalPreview').style.display = 'block';
        };
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
}

function compressImage() {
    if (!originalFile) return;

    document.getElementById('processingIndicator').style.display = 'block';
    document.getElementById('compressionResults').style.display = 'none';

    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    const img = new Image();

    img.onload = function() {
        const quality = parseInt(document.getElementById('quality').value) / 100;
        const maxWidth = parseInt(document.getElementById('maxWidth').value) || img.width;
        const maxHeight = parseInt(document.getElementById('maxHeight').value) || img.height;
        const maintainAspect = document.getElementById('maintainAspect').checked;

        let { width, height } = calculateDimensions(img.width, img.height, maxWidth, maxHeight, maintainAspect);

        canvas.width = width;
        canvas.height = height;

        // Draw and compress
        ctx.drawImage(img, 0, 0, width, height);

        canvas.toBlob(function(blob) {
            compressedBlob = blob;
            showCompressionResults(blob, width, height, quality);
            document.getElementById('processingIndicator').style.display = 'none';
        }, 'image/jpeg', quality);
    };

    const reader = new FileReader();
    reader.onload = function(e) {
        img.src = e.target.result;
    };
    reader.readAsDataURL(originalFile);
}

function calculateDimensions(originalWidth, originalHeight, maxWidth, maxHeight, maintainAspect) {
    if (!maintainAspect) {
        return { width: maxWidth, height: maxHeight };
    }

    const aspectRatio = originalWidth / originalHeight;

    let width = Math.min(maxWidth, originalWidth);
    let height = Math.min(maxHeight, originalHeight);

    if (width / height > aspectRatio) {
        width = height * aspectRatio;
    } else {
        height = width / aspectRatio;
    }

    return { width: Math.round(width), height: Math.round(height) };
}

function showCompressionResults(blob, width, height, quality) {
    const originalSize = originalFile.size;
    const compressedSize = blob.size;
    const reduction = ((originalSize - compressedSize) / originalSize * 100).toFixed(1);

    // Update statistics
    document.getElementById('compressionRatio').textContent = reduction + '%';
    document.getElementById('newFileSize').textContent = formatFileSize(compressedSize);
    document.getElementById('qualityUsed').textContent = Math.round(quality * 100) + '%';

    // Update comparison table
    document.getElementById('originalSizeCompare').textContent = formatFileSize(originalSize);
    document.getElementById('compressedSizeCompare').textContent = formatFileSize(compressedSize);

    const originalImg = document.getElementById('originalImage');
    document.getElementById('originalDimensionsCompare').textContent = `${originalImg.naturalWidth} × ${originalImg.naturalHeight}`;
    document.getElementById('compressedDimensionsCompare').textContent = `${width} × ${height}`;

    // Show compressed image
    const compressedUrl = URL.createObjectURL(blob);
    document.getElementById('compressedImage').src = compressedUrl;

    document.getElementById('compressionResults').style.display = 'block';
}

function downloadCompressed() {
    if (!compressedBlob) return;

    const url = URL.createObjectURL(compressedBlob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'compressed-' + (originalFile.name || 'image.jpg');
    a.click();
    URL.revokeObjectURL(url);
}

function compressAnother() {
    resetAll();
    fileInput.click();
}

function resetAll() {
    originalFile = null;
    compressedBlob = null;

    document.getElementById('imageInput').value = '';
    document.getElementById('quality').value = 75;
    document.getElementById('qualityValue').textContent = '75%';
    document.getElementById('maxWidth').value = '';
    document.getElementById('maxHeight').value = '';

    document.getElementById('compressionSettings').style.display = 'none';
    document.getElementById('actionButtons').style.display = 'none';
    document.getElementById('originalPreview').style.display = 'none';
    document.getElementById('compressionResults').style.display = 'none';
    document.getElementById('processingIndicator').style.display = 'none';
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}
</script>
