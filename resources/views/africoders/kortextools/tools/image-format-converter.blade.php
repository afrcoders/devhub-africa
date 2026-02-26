{{-- Image Format Converter --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-image me-2"></i>
    Convert images between different formats while maintaining quality.
</div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-images me-2"></i>
                        {{ $tool->name }}
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">{{ $tool->description }}</p>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="fileInput" class="form-label">Select Images</label>
                                <input type="file" class="form-control" id="fileInput" accept="image/*" multiple>
                                <div class="form-text">Select one or more images to convert formats</div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="outputFormat" class="form-label">Output Format</label>
                                        <select class="form-select" id="outputFormat">
                                            <option value="jpeg">JPEG (.jpg)</option>
                                            <option value="png">PNG (.png)</option>
                                            <option value="webp">WebP (.webp)</option>
                                            <option value="bmp">BMP (.bmp)</option>
                                            <option value="gif">GIF (.gif)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3" id="qualitySection">
                                        <label for="qualitySlider" class="form-label">Quality <span id="qualityValue">90%</span></label>
                                        <input type="range" class="form-range" id="qualitySlider" min="0.1" max="1" step="0.1" value="0.9">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3" style="display: none;" id="previewSection">
                                <label class="form-label">Image Previews</label>
                                <div id="imagePreview" class="border rounded p-3" style="max-height: 300px; overflow-y: auto;"></div>
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button type="button" class="btn btn-primary" id="convertBtn" disabled>
                                    <i class="fas fa-exchange-alt me-2"></i>Convert Images
                                </button>
                            </div>

                            <div class="mb-3" style="display: none;" id="downloadSection">
                                <label class="form-label">Download Converted Images</label>
                                <div id="downloadLinks" class="d-grid gap-2"></div>
                            </div>

                            <div class="progress" style="display: none;" id="progressSection">
                                <div class="progress-bar" role="progressbar" style="width: 0%" id="progressBar"></div>
                            </div>

                            <div class="mt-3" id="conversionInfo" style="display: none;">
                                <div class="alert alert-success">
                                    <h6>Conversion Summary:</h6>
                                    <div id="summaryContent"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const fileInput = document.getElementById('fileInput');
const outputFormat = document.getElementById('outputFormat');
const qualitySlider = document.getElementById('qualitySlider');
const qualityValue = document.getElementById('qualityValue');
const qualitySection = document.getElementById('qualitySection');
const previewSection = document.getElementById('previewSection');
const imagePreview = document.getElementById('imagePreview');
const convertBtn = document.getElementById('convertBtn');
const downloadSection = document.getElementById('downloadSection');
const downloadLinks = document.getElementById('downloadLinks');
const progressSection = document.getElementById('progressSection');
const progressBar = document.getElementById('progressBar');
const conversionInfo = document.getElementById('conversionInfo');
const summaryContent = document.getElementById('summaryContent');

let selectedFiles = [];

// Quality slider change handler
qualitySlider.addEventListener('input', function() {
    const quality = (parseFloat(this.value) * 100).toFixed(0);
    qualityValue.textContent = quality + '%';
});

// Output format change handler
outputFormat.addEventListener('change', function() {
    // Hide quality for lossless formats
    if (this.value === 'png' || this.value === 'bmp') {
        qualitySection.style.display = 'none';
    } else {
        qualitySection.style.display = 'block';
    }
});

// File input change handler
fileInput.addEventListener('change', function(e) {
    selectedFiles = Array.from(e.target.files);

    if (selectedFiles.length > 0) {
        showPreviews();
        convertBtn.disabled = false;
    } else {
        previewSection.style.display = 'none';
        convertBtn.disabled = true;
    }
});

// Show image previews
function showPreviews() {
    imagePreview.innerHTML = '';

    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const imgContainer = document.createElement('div');
            imgContainer.className = 'mb-2 p-2 border rounded d-flex align-items-center';
            imgContainer.innerHTML = `
                <img src="${e.target.result}" alt="Preview" style="width: 60px; height: 60px; object-fit: cover;" class="rounded me-3">
                <div class="flex-grow-1">
                    <strong>${file.name}</strong><br>
                    <small class="text-muted">
                        Size: ${(file.size / 1024).toFixed(1)} KB |
                        Type: ${file.type}
                    </small>
                </div>
                <div class="text-end">
                    <span class="badge bg-info">→ ${outputFormat.value.toUpperCase()}</span>
                </div>
            `;
            imagePreview.appendChild(imgContainer);
        };
        reader.readAsDataURL(file);
    });

    previewSection.style.display = 'block';
}

// Convert image format
function convertImageFormat(file, format, quality) {
    return new Promise((resolve) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = new Image();
            img.onload = function() {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');

                canvas.width = img.width;
                canvas.height = img.height;

                // Handle transparency for formats that don't support it
                if (format === 'jpeg' || format === 'bmp') {
                    ctx.fillStyle = 'white';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);
                }

                ctx.drawImage(img, 0, 0);

                // Convert to target format
                const mimeType = `image/${format === 'jpeg' ? 'jpeg' : format}`;
                canvas.toBlob(function(blob) {
                    const fileName = file.name.replace(/\.[^/.]+$/, `.${format === 'jpeg' ? 'jpg' : format}`);
                    resolve({
                        blob: blob,
                        fileName: fileName,
                        originalName: file.name,
                        originalSize: file.size,
                        newSize: blob.size,
                        format: format.toUpperCase()
                    });
                }, mimeType, quality);
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
}

// Convert button click
convertBtn.addEventListener('click', async function() {
    if (selectedFiles.length === 0) return;

    convertBtn.disabled = true;
    progressSection.style.display = 'block';
    downloadSection.style.display = 'none';
    conversionInfo.style.display = 'none';
    downloadLinks.innerHTML = '';

    const format = outputFormat.value;
    const quality = parseFloat(qualitySlider.value);
    const convertedFiles = [];
    let totalOriginalSize = 0;
    let totalNewSize = 0;

    for (let i = 0; i < selectedFiles.length; i++) {
        const file = selectedFiles[i];

        // Update progress
        const progress = ((i + 1) / selectedFiles.length) * 100;
        progressBar.style.width = progress + '%';
        progressBar.textContent = `Converting ${i + 1}/${selectedFiles.length}`;

        try {
            const converted = await convertImageFormat(file, format, quality);
            convertedFiles.push(converted);
            totalOriginalSize += converted.originalSize;
            totalNewSize += converted.newSize;
        } catch (error) {
            console.error('Error converting file:', error);
        }
    }

    // Create download links
    convertedFiles.forEach(file => {
        const url = URL.createObjectURL(file.blob);
        const downloadBtn = document.createElement('a');
        downloadBtn.href = url;
        downloadBtn.download = file.fileName;
        downloadBtn.className = 'btn btn-success d-flex justify-content-between align-items-center';
        downloadBtn.innerHTML = `
            <span><i class="fas fa-download me-2"></i>${file.fileName}</span>
            <span class="badge bg-light text-dark">
                ${(file.originalSize / 1024).toFixed(1)} KB → ${(file.newSize / 1024).toFixed(1)} KB
            </span>
        `;
        downloadLinks.appendChild(downloadBtn);
    });

    // Create download all button if multiple files
    if (convertedFiles.length > 1) {
        const downloadAllBtn = document.createElement('button');
        downloadAllBtn.className = 'btn btn-primary mt-2';
        downloadAllBtn.innerHTML = '<i class="fas fa-download me-2"></i>Download All Files';
        downloadAllBtn.onclick = function() {
            convertedFiles.forEach(file => {
                const url = URL.createObjectURL(file.blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = file.fileName;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            });
        };
        downloadLinks.appendChild(downloadAllBtn);
    }

    // Show conversion summary
    const compressionRatio = ((totalOriginalSize - totalNewSize) / totalOriginalSize * 100).toFixed(1);
    summaryContent.innerHTML = `
        <strong>Files converted:</strong> ${convertedFiles.length}<br>
        <strong>Original size:</strong> ${(totalOriginalSize / 1024).toFixed(1)} KB<br>
        <strong>New size:</strong> ${(totalNewSize / 1024).toFixed(1)} KB<br>
        <strong>Size change:</strong> ${compressionRatio > 0 ? '-' : '+'}${Math.abs(compressionRatio)}%<br>
        <strong>Format:</strong> ${format.toUpperCase()}
    `;

    progressSection.style.display = 'none';
    downloadSection.style.display = 'block';
    conversionInfo.style.display = 'block';
    convertBtn.disabled = false;
    convertBtn.innerHTML = '<i class="fas fa-redo me-2"></i>Convert More Images';
});

// Update preview when format changes
outputFormat.addEventListener('change', function() {
    if (selectedFiles.length > 0) {
        showPreviews();
    }
});
</script>
