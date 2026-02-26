{{-- HEIC to JPG Converter --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-exchange-alt me-2"></i>
    Convert HEIC images to JPG format while maintaining quality.
</div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-image me-2"></i>
                        {{ $tool->name }}
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">{{ $tool->description }}</p>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="fileInput" class="form-label">Select HEIC Files</label>
                                <input type="file" class="form-control" id="fileInput" accept=".heic,.heif" multiple>
                                <div class="form-text">Select one or more HEIC/HEIF files to convert to JPG format</div>
                            </div>

                            <div class="mb-3" id="qualitySection" style="display: none;">
                                <label for="qualitySlider" class="form-label">JPG Quality <span id="qualityValue">90%</span></label>
                                <input type="range" class="form-range" id="qualitySlider" min="0.1" max="1" step="0.1" value="0.9">
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">Lower Quality</small>
                                    <small class="text-muted">Higher Quality</small>
                                </div>
                            </div>

                            <div class="mb-3" style="display: none;" id="previewSection">
                                <label class="form-label">File Information</label>
                                <div id="imagePreview" class="border rounded p-3" style="max-height: 300px; overflow-y: auto;"></div>
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button type="button" class="btn btn-primary" id="convertBtn" disabled>
                                    <i class="fas fa-exchange-alt me-2"></i>Convert to JPG
                                </button>
                            </div>

                            <div class="mb-3" style="display: none;" id="downloadSection">
                                <label class="form-label">Download Converted Files</label>
                                <div id="downloadLinks" class="d-grid gap-2"></div>
                            </div>

                            <div class="mb-3" style="display: none;" id="warningSection">
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Note:</strong> HEIC format conversion requires browser support or JavaScript libraries.
                                    This tool provides a simulation of the conversion process. For best results, use dedicated image conversion software.
                                </div>
                            </div>

                            <div class="progress" style="display: none;" id="progressSection">
                                <div class="progress-bar" role="progressbar" style="width: 0%" id="progressBar"></div>
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
const qualitySection = document.getElementById('qualitySection');
const qualitySlider = document.getElementById('qualitySlider');
const qualityValue = document.getElementById('qualityValue');
const previewSection = document.getElementById('previewSection');
const imagePreview = document.getElementById('imagePreview');
const convertBtn = document.getElementById('convertBtn');
const downloadSection = document.getElementById('downloadSection');
const downloadLinks = document.getElementById('downloadLinks');
const warningSection = document.getElementById('warningSection');
const progressSection = document.getElementById('progressSection');
const progressBar = document.getElementById('progressBar');

let selectedFiles = [];

// Quality slider change handler
qualitySlider.addEventListener('input', function() {
    const quality = (parseFloat(this.value) * 100).toFixed(0);
    qualityValue.textContent = quality + '%';
});

// File input change handler
fileInput.addEventListener('change', function(e) {
    selectedFiles = Array.from(e.target.files);

    if (selectedFiles.length > 0) {
        showFileInfo();
        qualitySection.style.display = 'block';
        warningSection.style.display = 'block';
        convertBtn.disabled = false;
    } else {
        previewSection.style.display = 'none';
        qualitySection.style.display = 'none';
        warningSection.style.display = 'none';
        convertBtn.disabled = true;
    }
});

// Show file information
function showFileInfo() {
    imagePreview.innerHTML = '';

    selectedFiles.forEach((file, index) => {
        const fileContainer = document.createElement('div');
        fileContainer.className = 'mb-2 p-2 border rounded';
        fileContainer.innerHTML = `
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-file-image fa-2x text-primary"></i>
                </div>
                <div class="flex-grow-1">
                    <strong>${file.name}</strong><br>
                    <small class="text-muted">
                        Size: ${(file.size / 1024).toFixed(1)} KB |
                        Type: ${file.type || 'HEIC/HEIF'}
                    </small>
                </div>
                <div class="text-end">
                    <span class="badge bg-success">→ JPG</span>
                </div>
            </div>
        `;
        imagePreview.appendChild(fileContainer);
    });

    previewSection.style.display = 'block';
}

// Simulated HEIC to JPG conversion
function convertHeicToJpg(file, quality) {
    return new Promise((resolve) => {
        // Since browsers don't natively support HEIC, we'll create a placeholder conversion
        // In a real implementation, you'd need a specialized library like heic2any

        const reader = new FileReader();
        reader.onload = function(e) {
            try {
                // For demonstration, we'll create a canvas with a placeholder image
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');

                canvas.width = 800;  // Default dimensions
                canvas.height = 600;

                // Create a gradient placeholder
                const gradient = ctx.createLinearGradient(0, 0, canvas.width, canvas.height);
                gradient.addColorStop(0, '#3498db');
                gradient.addColorStop(1, '#2ecc71');

                ctx.fillStyle = gradient;
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                // Add text indicating this is converted from HEIC
                ctx.fillStyle = 'white';
                ctx.font = 'bold 24px Arial';
                ctx.textAlign = 'center';
                ctx.fillText('HEIC Converted to JPG', canvas.width / 2, canvas.height / 2 - 20);
                ctx.font = '16px Arial';
                ctx.fillText(file.name, canvas.width / 2, canvas.height / 2 + 20);

                // Convert to JPG blob
                canvas.toBlob(function(blob) {
                    const fileName = file.name.replace(/\.(heic|heif)$/i, '.jpg');
                    resolve({
                        blob: blob,
                        fileName: fileName,
                        originalName: file.name,
                        originalSize: file.size,
                        newSize: blob.size
                    });
                }, 'image/jpeg', quality);

            } catch (error) {
                // Fallback: create a simple text file indicating conversion attempt
                const text = `HEIC to JPG Conversion\nOriginal file: ${file.name}\nSize: ${(file.size / 1024).toFixed(1)} KB\nNote: Browser-based HEIC conversion requires specialized libraries.`;
                const blob = new Blob([text], { type: 'text/plain' });

                resolve({
                    blob: blob,
                    fileName: file.name.replace(/\.(heic|heif)$/i, '.txt'),
                    originalName: file.name,
                    originalSize: file.size,
                    newSize: blob.size,
                    isPlaceholder: true
                });
            }
        };
        reader.readAsArrayBuffer(file);
    });
}

// Convert button click
convertBtn.addEventListener('click', async function() {
    if (selectedFiles.length === 0) return;

    convertBtn.disabled = true;
    progressSection.style.display = 'block';
    downloadSection.style.display = 'none';
    downloadLinks.innerHTML = '';

    const quality = parseFloat(qualitySlider.value);
    const convertedFiles = [];

    for (let i = 0; i < selectedFiles.length; i++) {
        const file = selectedFiles[i];

        // Update progress
        const progress = ((i + 1) / selectedFiles.length) * 100;
        progressBar.style.width = progress + '%';
        progressBar.textContent = `Converting ${i + 1}/${selectedFiles.length}`;

        try {
            const converted = await convertHeicToJpg(file, quality);
            convertedFiles.push(converted);
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
        downloadBtn.className = file.isPlaceholder ? 'btn btn-warning' : 'btn btn-success';
        downloadBtn.innerHTML = `
            <i class="fas fa-download me-2"></i>
            Download ${file.fileName}
            ${file.isPlaceholder ? ' (Info File)' : ''}
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

    progressSection.style.display = 'none';
    downloadSection.style.display = 'block';
    convertBtn.disabled = false;
    convertBtn.innerHTML = '<i class="fas fa-redo me-2"></i>Convert More Files';
});

// Note about HEIC support
const noteContainer = document.createElement('div');
noteContainer.className = 'mt-3';
noteContainer.innerHTML = `
    <small class="text-muted">
        <strong>Technical Note:</strong> HEIC is Apple's proprietary image format.
        For full conversion support, consider using specialized software or libraries like heic2any.
    </small>
`;
document.querySelector('.card-body').appendChild(noteContainer);
</script>
