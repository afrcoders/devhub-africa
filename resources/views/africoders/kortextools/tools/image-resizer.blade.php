<div class="row">
    <div class="col-md-12">
        <!-- Image Upload -->
        <div class="mb-4">
            <label for="imageInput" class="form-label">Select Image to Resize</label>
            <input type="file" class="form-control" id="imageInput" accept="image/*" onchange="handleImageUpload(event)">
            <div class="form-text">
                <small class="text-muted">Supports JPG, PNG, WebP, BMP formats. Max size: 10MB</small>
            </div>
        </div>

        <!-- Drag and Drop Zone -->
        <div class="mb-4">
            <div id="dropZone" class="border border-dashed rounded p-4 text-center">
                <i class="bi bi-arrows-angle-expand display-4 text-muted"></i>
                <p class="mt-2 mb-0">Drag and drop an image here or click to browse</p>
            </div>
        </div>

        <!-- Resize Settings -->
        <div id="resizeSettings" style="display: none;">
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="targetWidth" class="form-label">Target Width (px)</label>
                    <input type="number" class="form-control" id="targetWidth" min="1" max="5000" onchange="updateDimensions('width')">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="targetHeight" class="form-label">Target Height (px)</label>
                    <input type="number" class="form-control" id="targetHeight" min="1" max="5000" onchange="updateDimensions('height')">
                </div>
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="maintainAspect" checked onchange="toggleAspectRatio()">
                    <label class="form-check-label" for="maintainAspect">
                        Lock aspect ratio (maintain proportions)
                    </label>
                </div>
            </div>

            <!-- Preset Sizes -->
            <div class="mb-4">
                <h6>Quick Presets:</h6>
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="applyPreset(1920, 1080)">
                        1920×1080 (Full HD)
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="applyPreset(1280, 720)">
                        1280×720 (HD)
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="applyPreset(800, 600)">
                        800×600 (4:3)
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="applyPreset(400, 400)">
                        400×400 (Square)
                    </button>
                </div>
            </div>

            <!-- Resize Method -->
            <div class="mb-4">
                <label class="form-label">Resize Method</label>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="resizeMethod" id="exactSize" value="exact" checked>
                            <label class="form-check-label" for="exactSize">
                                Exact dimensions
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="resizeMethod" id="fitInside" value="fit">
                            <label class="form-check-label" for="fitInside">
                                Fit inside (may be smaller)
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="resizeMethod" id="cover" value="cover">
                            <label class="form-check-label" for="cover">
                                Cover (crop if needed)
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Output Quality -->
            <div class="mb-4">
                <label for="outputQuality" class="form-label">Output Quality</label>
                <div class="d-flex align-items-center gap-3">
                    <input type="range" class="form-range" id="outputQuality" min="1" max="100" value="90">
                    <span id="qualityValue" class="badge bg-primary">90%</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div id="actionButtons" style="display: none;" class="mb-4">
            <button type="button" class="btn btn-primary" onclick="resizeImage()">
                <i class="bi bi-arrows-angle-expand"></i> Resize Image
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
                    <div class="position-relative">
                        <img id="originalImage" class="img-fluid rounded border" style="max-height: 300px;">
                        <span class="position-absolute top-0 start-0 badge bg-primary m-2" id="originalDimensionsBadge">0×0</span>
                    </div>
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
                                    <th>File Size</th>
                                    <td id="originalFileSize">-</td>
                                </tr>
                                <tr>
                                    <th>Dimensions</th>
                                    <td id="originalDimensions">-</td>
                                </tr>
                                <tr>
                                    <th>Aspect Ratio</th>
                                    <td id="originalAspectRatio">-</td>
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

        <!-- Resize Results -->
        <div id="resizeResults" style="display: none;">
            <h6>Resized Image:</h6>
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="text-center p-3 bg-primary text-white rounded">
                        <h5 id="newDimensions" class="mb-1">0×0</h5>
                        <small>New Size</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-info text-white rounded">
                        <h5 id="newFileSize" class="mb-1">0 KB</h5>
                        <small>File Size</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-success text-white rounded">
                        <h5 id="scaleFactor" class="mb-1">1x</h5>
                        <small>Scale Factor</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-warning text-dark rounded">
                        <h5 id="qualityUsed" class="mb-1">90%</h5>
                        <small>Quality</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="position-relative">
                        <img id="resizedImage" class="img-fluid rounded border" style="max-height: 300px;">
                        <span class="position-absolute top-0 start-0 badge bg-success m-2" id="resizedDimensionsBadge">0×0</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="comparison-stats">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Original</th>
                                        <th>Resized</th>
                                        <th>Change</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Width</th>
                                        <td id="originalWidthCompare">-</td>
                                        <td id="resizedWidthCompare">-</td>
                                        <td id="widthChange">-</td>
                                    </tr>
                                    <tr>
                                        <th>Height</th>
                                        <td id="originalHeightCompare">-</td>
                                        <td id="resizedHeightCompare">-</td>
                                        <td id="heightChange">-</td>
                                    </tr>
                                    <tr>
                                        <th>File Size</th>
                                        <td id="originalSizeCompare">-</td>
                                        <td id="resizedSizeCompare">-</td>
                                        <td id="sizeChange">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="button" class="btn btn-success" onclick="downloadResized()">
                    <i class="bi bi-download"></i> Download Resized Image
                </button>
                <button type="button" class="btn btn-outline-primary" onclick="resizeAnother()">
                    <i class="bi bi-arrow-repeat"></i> Resize Another
                </button>
            </div>
        </div>

        <!-- Processing Indicator -->
        <div id="processingIndicator" style="display: none;" class="text-center p-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Resizing...</span>
            </div>
            <p class="mt-2">Resizing image, please wait...</p>
        </div>
    </div>
</div>

<!-- Information -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> About Image Resizing</h6>
    <p class="mb-0">
        This tool allows you to resize images to specific dimensions. You can maintain aspect ratio to prevent distortion,
        or use different resize methods like fit (scales to fit within bounds) or cover (scales to fill and crops if needed).
        All processing is done client-side for privacy.
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

.position-relative .badge {
    font-size: 0.7rem;
}
</style>

<script>
let originalFile = null;
let resizedBlob = null;
let originalAspectRatio = 1;

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
document.getElementById('outputQuality').addEventListener('input', function() {
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
            originalAspectRatio = img.width / img.height;

            document.getElementById('originalImage').src = e.target.result;
            document.getElementById('originalFilename').textContent = file.name;
            document.getElementById('originalFileSize').textContent = formatFileSize(file.size);
            document.getElementById('originalDimensions').textContent = `${img.width} × ${img.height}`;
            document.getElementById('originalAspectRatio').textContent = originalAspectRatio.toFixed(2) + ':1';
            document.getElementById('originalType').textContent = file.type;
            document.getElementById('originalDimensionsBadge').textContent = `${img.width}×${img.height}`;

            // Set default target dimensions to original
            document.getElementById('targetWidth').value = img.width;
            document.getElementById('targetHeight').value = img.height;

            // Show UI elements
            document.getElementById('resizeSettings').style.display = 'block';
            document.getElementById('actionButtons').style.display = 'block';
            document.getElementById('originalPreview').style.display = 'block';
        };
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
}

function updateDimensions(changedField) {
    if (!document.getElementById('maintainAspect').checked) return;

    const width = parseInt(document.getElementById('targetWidth').value) || 0;
    const height = parseInt(document.getElementById('targetHeight').value) || 0;

    if (changedField === 'width' && width > 0) {
        document.getElementById('targetHeight').value = Math.round(width / originalAspectRatio);
    } else if (changedField === 'height' && height > 0) {
        document.getElementById('targetWidth').value = Math.round(height * originalAspectRatio);
    }
}

function toggleAspectRatio() {
    const width = parseInt(document.getElementById('targetWidth').value) || 0;
    if (document.getElementById('maintainAspect').checked && width > 0) {
        updateDimensions('width');
    }
}

function applyPreset(width, height) {
    document.getElementById('targetWidth').value = width;
    document.getElementById('targetHeight').value = height;
    document.getElementById('maintainAspect').checked = false;
}

function resizeImage() {
    if (!originalFile) return;

    const targetWidth = parseInt(document.getElementById('targetWidth').value);
    const targetHeight = parseInt(document.getElementById('targetHeight').value);

    if (!targetWidth || !targetHeight || targetWidth <= 0 || targetHeight <= 0) {
        alert('Please enter valid dimensions.');
        return;
    }

    document.getElementById('processingIndicator').style.display = 'block';
    document.getElementById('resizeResults').style.display = 'none';

    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    const img = new Image();

    img.onload = function() {
        const quality = parseInt(document.getElementById('outputQuality').value) / 100;
        const resizeMethod = document.querySelector('input[name="resizeMethod"]:checked').value;

        const dimensions = calculateResizeDimensions(img.width, img.height, targetWidth, targetHeight, resizeMethod);

        canvas.width = dimensions.canvasWidth;
        canvas.height = dimensions.canvasHeight;

        // Clear canvas with white background
        ctx.fillStyle = 'white';
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        // Draw resized image
        ctx.drawImage(img, dimensions.dx, dimensions.dy, dimensions.dw, dimensions.dh);

        canvas.toBlob(function(blob) {
            resizedBlob = blob;
            showResizeResults(blob, dimensions.canvasWidth, dimensions.canvasHeight, quality, img.width, img.height);
            document.getElementById('processingIndicator').style.display = 'none';
        }, 'image/jpeg', quality);
    };

    const reader = new FileReader();
    reader.onload = function(e) {
        img.src = e.target.result;
    };
    reader.readAsDataURL(originalFile);
}

function calculateResizeDimensions(originalWidth, originalHeight, targetWidth, targetHeight, method) {
    switch (method) {
        case 'exact':
            return {
                canvasWidth: targetWidth,
                canvasHeight: targetHeight,
                dx: 0,
                dy: 0,
                dw: targetWidth,
                dh: targetHeight
            };

        case 'fit':
            const fitScale = Math.min(targetWidth / originalWidth, targetHeight / originalHeight);
            const fitWidth = Math.round(originalWidth * fitScale);
            const fitHeight = Math.round(originalHeight * fitScale);
            return {
                canvasWidth: fitWidth,
                canvasHeight: fitHeight,
                dx: 0,
                dy: 0,
                dw: fitWidth,
                dh: fitHeight
            };

        case 'cover':
            const coverScale = Math.max(targetWidth / originalWidth, targetHeight / originalHeight);
            const scaledWidth = originalWidth * coverScale;
            const scaledHeight = originalHeight * coverScale;
            return {
                canvasWidth: targetWidth,
                canvasHeight: targetHeight,
                dx: (targetWidth - scaledWidth) / 2,
                dy: (targetHeight - scaledHeight) / 2,
                dw: scaledWidth,
                dh: scaledHeight
            };

        default:
            return calculateResizeDimensions(originalWidth, originalHeight, targetWidth, targetHeight, 'exact');
    }
}

function showResizeResults(blob, width, height, quality, originalWidth, originalHeight) {
    const originalSize = originalFile.size;
    const resizedSize = blob.size;
    const scaleFactor = Math.max(width / originalWidth, height / originalHeight);

    // Update statistics
    document.getElementById('newDimensions').textContent = `${width}×${height}`;
    document.getElementById('newFileSize').textContent = formatFileSize(resizedSize);
    document.getElementById('scaleFactor').textContent = scaleFactor.toFixed(2) + 'x';
    document.getElementById('qualityUsed').textContent = Math.round(quality * 100) + '%';

    // Update comparison table
    document.getElementById('originalWidthCompare').textContent = originalWidth + 'px';
    document.getElementById('resizedWidthCompare').textContent = width + 'px';
    document.getElementById('widthChange').textContent = ((width - originalWidth) / originalWidth * 100).toFixed(1) + '%';

    document.getElementById('originalHeightCompare').textContent = originalHeight + 'px';
    document.getElementById('resizedHeightCompare').textContent = height + 'px';
    document.getElementById('heightChange').textContent = ((height - originalHeight) / originalHeight * 100).toFixed(1) + '%';

    document.getElementById('originalSizeCompare').textContent = formatFileSize(originalSize);
    document.getElementById('resizedSizeCompare').textContent = formatFileSize(resizedSize);
    document.getElementById('sizeChange').textContent = ((resizedSize - originalSize) / originalSize * 100).toFixed(1) + '%';

    // Show resized image
    const resizedUrl = URL.createObjectURL(blob);
    document.getElementById('resizedImage').src = resizedUrl;
    document.getElementById('resizedDimensionsBadge').textContent = `${width}×${height}`;

    document.getElementById('resizeResults').style.display = 'block';
}

function downloadResized() {
    if (!resizedBlob) return;

    const url = URL.createObjectURL(resizedBlob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'resized-' + (originalFile.name || 'image.jpg');
    a.click();
    URL.revokeObjectURL(url);
}

function resizeAnother() {
    resetAll();
    fileInput.click();
}

function resetAll() {
    originalFile = null;
    resizedBlob = null;
    originalAspectRatio = 1;

    document.getElementById('imageInput').value = '';
    document.getElementById('targetWidth').value = '';
    document.getElementById('targetHeight').value = '';
    document.getElementById('maintainAspect').checked = true;
    document.getElementById('exactSize').checked = true;
    document.getElementById('outputQuality').value = 90;
    document.getElementById('qualityValue').textContent = '90%';

    document.getElementById('resizeSettings').style.display = 'none';
    document.getElementById('actionButtons').style.display = 'none';
    document.getElementById('originalPreview').style.display = 'none';
    document.getElementById('resizeResults').style.display = 'none';
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
