<div class="row">
    <div class="col-md-12">
        <!-- Mode Selection -->
        <div class="mb-4">
            <div class="btn-group w-100" role="group" aria-label="Mode selection">
                <input type="radio" class="btn-check" name="mode" id="image-to-base64-mode" value="image-to-base64" checked>
                <label class="btn btn-outline-primary" for="image-to-base64-mode">
                    <i class="bi bi-image"></i> Image to Base64
                </label>

                <input type="radio" class="btn-check" name="mode" id="base64-to-image-mode" value="base64-to-image">
                <label class="btn btn-outline-primary" for="base64-to-image-mode">
                    <i class="bi bi-code-slash"></i> Base64 to Image
                </label>
            </div>
        </div>

        <!-- Image to Base64 Section -->
        <div id="image-to-base64-section">
            <div class="mb-4">
                <label for="imageInput" class="form-label">Select Image File</label>
                <input type="file" class="form-control" id="imageInput" accept="image/*" onchange="handleImageUpload(event)">
                <div class="form-text">
                    <small class="text-muted">Supports JPG, PNG, WebP, GIF, BMP formats. Max size: 5MB</small>
                </div>
            </div>

            <!-- Drag and Drop Zone -->
            <div class="mb-4">
                <div id="dropZone" class="border border-dashed rounded p-4 text-center">
                    <i class="bi bi-cloud-upload display-4 text-muted"></i>
                    <p class="mt-2 mb-0">Drag and drop an image here or click to browse</p>
                </div>
            </div>

            <!-- Image Preview -->
            <div id="imagePreview" style="display: none;" class="mb-4">
                <h6>Selected Image:</h6>
                <div class="row">
                    <div class="col-md-6">
                        <img id="previewImage" class="img-fluid rounded border" style="max-height: 200px;">
                    </div>
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <th>Filename</th>
                                        <td id="imageFilename">-</td>
                                    </tr>
                                    <tr>
                                        <th>File Size</th>
                                        <td id="imageFileSize">-</td>
                                    </tr>
                                    <tr>
                                        <th>Dimensions</th>
                                        <td id="imageDimensions">-</td>
                                    </tr>
                                    <tr>
                                        <th>Type</th>
                                        <td id="imageType">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Base64 to Image Section -->
        <div id="base64-to-image-section" style="display: none;">
            <div class="mb-4">
                <label for="base64Input" class="form-label">Enter Base64 String</label>
                <textarea
                    class="form-control"
                    id="base64Input"
                    rows="8"
                    placeholder="Paste your Base64 encoded image string here..."
                ></textarea>
                <div class="form-text">
                    <small class="text-muted">Enter the full Base64 string (with or without data:image/... prefix)</small>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="mb-4">
            <button type="button" class="btn btn-primary" onclick="processConversion()">
                <i class="bi bi-arrow-right" id="action-icon"></i> <span id="action-text">Convert to Base64</span>
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="clearAll()">
                <i class="bi bi-x-circle"></i> Clear
            </button>
        </div>

        <!-- Results Section -->
        <div id="resultsContainer" style="display: none;">
            <h6 id="results-title">Base64 Result:</h6>

            <!-- Base64 Result -->
            <div id="base64Results" style="display: none;">
                <div class="mb-4">
                    <label for="base64Output" class="form-label">Base64 String</label>
                    <textarea id="base64Output" class="form-control" rows="6" readonly></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label">Data URI (for HTML/CSS)</label>
                    <textarea id="dataUriOutput" class="form-control" rows="4" readonly></textarea>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="text-center p-3 bg-primary text-white rounded">
                            <h5 id="base64Length" class="mb-1">0</h5>
                            <small>Characters</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 bg-info text-white rounded">
                            <h5 id="base64Size" class="mb-1">0 KB</h5>
                            <small>Base64 Size</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 bg-success text-white rounded">
                            <h5 id="originalSize" class="mb-1">0 KB</h5>
                            <small>Original Size</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image Result -->
            <div id="imageResults" style="display: none;">
                <div class="row">
                    <div class="col-md-6">
                        <img id="resultImage" class="img-fluid rounded border" style="max-height: 300px;">
                    </div>
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <th>Image Type</th>
                                        <td id="resultImageType">-</td>
                                    </tr>
                                    <tr>
                                        <th>Dimensions</th>
                                        <td id="resultImageDimensions">-</td>
                                    </tr>
                                    <tr>
                                        <th>Base64 Length</th>
                                        <td id="resultBase64Length">-</td>
                                    </tr>
                                    <tr>
                                        <th>Estimated Size</th>
                                        <td id="resultEstimatedSize">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="button" class="btn btn-outline-primary" onclick="copyResult()">
                    <i class="bi bi-clipboard"></i> Copy Result
                </button>
                <button type="button" class="btn btn-outline-success" onclick="downloadResult()" id="downloadBtn">
                    <i class="bi bi-download"></i> Download
                </button>
                <button type="button" class="btn btn-outline-info" onclick="showUsageExamples()">
                    <i class="bi bi-info-circle"></i> Usage Examples
                </button>
            </div>
        </div>

        <!-- Usage Examples Modal Trigger Content -->
        <div id="usageExamples" style="display: none;" class="mt-4">
            <div class="alert alert-light">
                <h6>Usage Examples:</h6>
                <div class="row">
                    <div class="col-md-6">
                        <strong>HTML:</strong>
                        <pre><code>&lt;img src="data:image/jpeg;base64,/9j/4AAQ..." alt="Image"&gt;</code></pre>
                    </div>
                    <div class="col-md-6">
                        <strong>CSS:</strong>
                        <pre><code>background-image: url('data:image/jpeg;base64,/9j/4AAQ...');</code></pre>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Examples -->
        <div class="mt-4">
            <h6>Quick Test:</h6>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="loadSampleBase64()">
                    Load Sample Base64
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="switchMode()">
                    Switch Mode
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Information -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> About Base64 Image Encoding</h6>
    <p class="mb-0">
        Base64 encoding converts binary image data into ASCII text format. This is useful for embedding images
        directly in HTML, CSS, or JSON. Note that Base64 encoding increases file size by about 33% compared
        to the original binary format.
    </p>
</div>

<style>
.btn-check:checked + .btn-outline-primary {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
    color: white;
}

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

pre {
    font-size: 0.8rem;
    background: #f8f9fa;
    padding: 8px;
    border-radius: 4px;
    overflow-x: auto;
}
</style>

<script>
let currentFile = null;
let resultData = null;

// Mode change handler
document.querySelectorAll('input[name="mode"]').forEach(radio => {
    radio.addEventListener('change', updateMode);
});

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

function updateMode() {
    const mode = document.querySelector('input[name="mode"]:checked').value;
    const isImageToBase64 = mode === 'image-to-base64';

    document.getElementById('image-to-base64-section').style.display = isImageToBase64 ? 'block' : 'none';
    document.getElementById('base64-to-image-section').style.display = isImageToBase64 ? 'none' : 'block';

    document.getElementById('action-text').textContent = isImageToBase64 ? 'Convert to Base64' : 'Convert to Image';
    document.getElementById('action-icon').className = isImageToBase64 ? 'bi bi-arrow-right' : 'bi bi-arrow-left';

    // Clear results when mode changes
    document.getElementById('resultsContainer').style.display = 'none';
    document.getElementById('imagePreview').style.display = 'none';
}

function handleImageUpload(event) {
    const file = event.target.files[0];
    if (!file) return;

    if (!file.type.startsWith('image/')) {
        alert('Please select a valid image file.');
        return;
    }

    if (file.size > 5 * 1024 * 1024) { // 5MB limit
        alert('File size must be less than 5MB.');
        return;
    }

    currentFile = file;

    const reader = new FileReader();
    reader.onload = function(e) {
        const img = new Image();
        img.onload = function() {
            document.getElementById('previewImage').src = e.target.result;
            document.getElementById('imageFilename').textContent = file.name;
            document.getElementById('imageFileSize').textContent = formatFileSize(file.size);
            document.getElementById('imageDimensions').textContent = `${img.width} × ${img.height}`;
            document.getElementById('imageType').textContent = file.type;

            document.getElementById('imagePreview').style.display = 'block';
        };
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
}

function processConversion() {
    const mode = document.querySelector('input[name="mode"]:checked').value;

    if (mode === 'image-to-base64') {
        convertImageToBase64();
    } else {
        convertBase64ToImage();
    }
}

function convertImageToBase64() {
    if (!currentFile) {
        alert('Please select an image file first.');
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        const base64String = e.target.result;
        const base64Data = base64String.split(',')[1]; // Remove data:image/...;base64, prefix
        const dataUri = base64String; // Keep full data URI

        // Show results
        document.getElementById('base64Output').value = base64Data;
        document.getElementById('dataUriOutput').value = dataUri;

        // Update statistics
        document.getElementById('base64Length').textContent = base64Data.length.toLocaleString();
        document.getElementById('base64Size').textContent = formatFileSize(base64Data.length);
        document.getElementById('originalSize').textContent = formatFileSize(currentFile.size);

        document.getElementById('results-title').textContent = 'Base64 Result:';
        document.getElementById('base64Results').style.display = 'block';
        document.getElementById('imageResults').style.display = 'none';
        document.getElementById('resultsContainer').style.display = 'block';

        resultData = {
            type: 'base64',
            data: base64Data,
            dataUri: dataUri
        };
    };
    reader.readAsDataURL(currentFile);
}

function convertBase64ToImage() {
    const base64Input = document.getElementById('base64Input').value.trim();

    if (!base64Input) {
        alert('Please enter a Base64 string.');
        return;
    }

    try {
        let dataUri = base64Input;

        // If input doesn't start with data:, add the prefix
        if (!base64Input.startsWith('data:')) {
            // Try to detect image type from Base64 header
            const imageType = detectImageTypeFromBase64(base64Input);
            dataUri = `data:${imageType};base64,${base64Input}`;
        }

        const img = new Image();
        img.onload = function() {
            document.getElementById('resultImage').src = dataUri;
            document.getElementById('resultImageType').textContent = extractImageTypeFromDataUri(dataUri);
            document.getElementById('resultImageDimensions').textContent = `${img.width} × ${img.height}`;
            document.getElementById('resultBase64Length').textContent = base64Input.length.toLocaleString();
            document.getElementById('resultEstimatedSize').textContent = formatFileSize(base64Input.length * 0.75); // Base64 is ~33% larger

            document.getElementById('results-title').textContent = 'Image Result:';
            document.getElementById('base64Results').style.display = 'none';
            document.getElementById('imageResults').style.display = 'block';
            document.getElementById('resultsContainer').style.display = 'block';

            resultData = {
                type: 'image',
                dataUri: dataUri,
                width: img.width,
                height: img.height
            };
        };

        img.onerror = function() {
            alert('Invalid Base64 image data. Please check your input.');
        };

        img.src = dataUri;

    } catch (error) {
        alert('Error processing Base64 data: ' + error.message);
    }
}

function detectImageTypeFromBase64(base64) {
    // Basic detection based on Base64 header signatures
    if (base64.startsWith('/9j/')) return 'image/jpeg';
    if (base64.startsWith('iVBOR')) return 'image/png';
    if (base64.startsWith('R0lGO')) return 'image/gif';
    if (base64.startsWith('Qk0')) return 'image/bmp';
    if (base64.startsWith('UklGR')) return 'image/webp';
    return 'image/jpeg'; // Default fallback
}

function extractImageTypeFromDataUri(dataUri) {
    const match = dataUri.match(/data:([^;]+);/);
    return match ? match[1] : 'unknown';
}

function copyResult() {
    let textToCopy = '';

    if (resultData?.type === 'base64') {
        textToCopy = document.getElementById('base64Output').value;
    } else if (resultData?.type === 'image') {
        textToCopy = resultData.dataUri;
    }

    if (textToCopy) {
        navigator.clipboard.writeText(textToCopy).then(function() {
            // Show success feedback
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="bi bi-check"></i> Copied!';
            button.classList.remove('btn-outline-primary');
            button.classList.add('btn-success');

            setTimeout(function() {
                button.innerHTML = originalText;
                button.classList.remove('btn-success');
                button.classList.add('btn-outline-primary');
            }, 2000);
        });
    }
}

function downloadResult() {
    if (!resultData) return;

    if (resultData.type === 'base64') {
        // Download Base64 as text file
        const blob = new Blob([resultData.data], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'base64-encoded.txt';
        a.click();
        URL.revokeObjectURL(url);
    } else if (resultData.type === 'image') {
        // Download image
        const a = document.createElement('a');
        a.href = resultData.dataUri;
        a.download = 'decoded-image.png';
        a.click();
    }
}

function showUsageExamples() {
    const examples = document.getElementById('usageExamples');
    examples.style.display = examples.style.display === 'none' ? 'block' : 'none';
}

function loadSampleBase64() {
    // A small red square PNG as sample
    const sampleBase64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';
    document.getElementById('base64-to-image-mode').checked = true;
    updateMode();
    document.getElementById('base64Input').value = sampleBase64;
    convertBase64ToImage();
}

function switchMode() {
    const currentMode = document.querySelector('input[name="mode"]:checked').value;
    const newMode = currentMode === 'image-to-base64' ? 'base64-to-image' : 'image-to-base64';
    document.getElementById(newMode + '-mode').checked = true;
    updateMode();
}

function clearAll() {
    currentFile = null;
    resultData = null;

    document.getElementById('imageInput').value = '';
    document.getElementById('base64Input').value = '';
    document.getElementById('base64Output').value = '';
    document.getElementById('dataUriOutput').value = '';

    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('resultsContainer').style.display = 'none';
    document.getElementById('usageExamples').style.display = 'none';
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Initialize
updateMode();
</script>
