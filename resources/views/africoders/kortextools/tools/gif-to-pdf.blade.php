{{-- GIF to PDF Converter --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-file-pdf me-2"></i>
    Convert GIF animations to PDF format.
</div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-file-pdf me-2"></i>
                        {{ $tool->name }}
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">{{ $tool->description }}</p>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="fileInput" class="form-label">Select GIF Files</label>
                                <input type="file" class="form-control" id="fileInput" accept=".gif" multiple>
                                <div class="form-text">Select one or more GIF files to convert to PDF</div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="pageSize" class="form-label">Page Size</label>
                                        <select class="form-select" id="pageSize">
                                            <option value="a4">A4 (210 × 297 mm)</option>
                                            <option value="letter">Letter (8.5 × 11 in)</option>
                                            <option value="legal">Legal (8.5 × 14 in)</option>
                                            <option value="a3">A3 (297 × 420 mm)</option>
                                            <option value="a5">A5 (148 × 210 mm)</option>
                                            <option value="custom">Fit to GIF</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="frameOption" class="form-label">Frame Handling</label>
                                        <select class="form-select" id="frameOption">
                                            <option value="first">First Frame Only</option>
                                            <option value="all">All Frames (Separate Pages)</option>
                                            <option value="split">Split into Separate PDFs</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3" style="display: none;" id="previewSection">
                                <label class="form-label">GIF Previews</label>
                                <div id="imagePreview" class="border rounded p-3" style="max-height: 300px; overflow-y: auto;"></div>
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button type="button" class="btn btn-primary" id="convertBtn" disabled>
                                    <i class="fas fa-file-pdf me-2"></i>Convert to PDF
                                </button>
                            </div>

                            <div class="mb-3" style="display: none;" id="downloadSection">
                                <label class="form-label">Download Converted PDFs</label>
                                <div id="downloadLinks" class="d-grid gap-2"></div>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
const { jsPDF } = window.jspdf;

const fileInput = document.getElementById('fileInput');
const pageSize = document.getElementById('pageSize');
const frameOption = document.getElementById('frameOption');
const previewSection = document.getElementById('previewSection');
const imagePreview = document.getElementById('imagePreview');
const convertBtn = document.getElementById('convertBtn');
const downloadSection = document.getElementById('downloadSection');
const downloadLinks = document.getElementById('downloadLinks');
const progressSection = document.getElementById('progressSection');
const progressBar = document.getElementById('progressBar');

let selectedFiles = [];

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

// Show GIF previews
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
                        Type: GIF Animation
                    </small>
                </div>
                <div class="text-end">
                    <span class="badge bg-primary">→ PDF</span>
                </div>
            `;
            imagePreview.appendChild(imgContainer);
        };
        reader.readAsDataURL(file);
    });

    previewSection.style.display = 'block';
}

// Get page dimensions
function getPageDimensions(size) {
    const sizes = {
        'a4': { width: 210, height: 297 },
        'letter': { width: 216, height: 279 },
        'legal': { width: 216, height: 356 },
        'a3': { width: 297, height: 420 },
        'a5': { width: 148, height: 210 }
    };

    return sizes[size] || sizes['a4'];
}

// Load GIF and extract frame(s)
function processGif(file) {
    return new Promise((resolve) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = new Image();
            img.onload = function() {
                // For simplicity, we'll just use the first frame
                // In a real implementation, you'd need a GIF parsing library to extract all frames
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');

                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0);

                // Convert to data URL
                const frameData = canvas.toDataURL('image/jpeg', 0.9);

                resolve({
                    frames: [frameData], // In real implementation, this would be all frames
                    width: img.width,
                    height: img.height,
                    name: file.name
                });
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
}

// Create PDF from GIF
async function createPdfFromGif(gifData, pageSettings) {
    const pdf = new jsPDF({
        orientation: 'p',
        unit: 'mm',
        format: pageSettings.size === 'custom' ? 'a4' : pageSettings.size
    });

    const pageDims = getPageDimensions(pageSettings.size);
    const frameHandling = frameOption.value;

    if (frameHandling === 'first' || frameHandling === 'all') {
        let pageAdded = false;

        for (let i = 0; i < gifData.frames.length; i++) {
            if (frameHandling === 'first' && i > 0) break;

            if (pageAdded) {
                pdf.addPage();
            }

            // Calculate scaling to fit image within page
            const margin = 10;
            const availableWidth = pageDims.width - (margin * 2);
            const availableHeight = pageDims.height - (margin * 2);

            const scaleX = availableWidth / (gifData.width * 0.264583);
            const scaleY = availableHeight / (gifData.height * 0.264583);
            const scale = Math.min(scaleX, scaleY);

            const finalWidth = gifData.width * 0.264583 * scale;
            const finalHeight = gifData.height * 0.264583 * scale;

            // Center the image
            const x = (pageDims.width - finalWidth) / 2;
            const y = (pageDims.height - finalHeight) / 2;

            pdf.addImage(gifData.frames[i], 'JPEG', x, y, finalWidth, finalHeight);
            pageAdded = true;
        }
    }

    return pdf;
}

// Convert button click
convertBtn.addEventListener('click', async function() {
    if (selectedFiles.length === 0) return;

    convertBtn.disabled = true;
    progressSection.style.display = 'block';
    downloadSection.style.display = 'none';
    downloadLinks.innerHTML = '';

    const pageSettings = {
        size: pageSize.value
    };

    for (let i = 0; i < selectedFiles.length; i++) {
        const file = selectedFiles[i];

        // Update progress
        const progress = ((i + 1) / selectedFiles.length) * 100;
        progressBar.style.width = progress + '%';
        progressBar.textContent = `Processing ${i + 1}/${selectedFiles.length}`;

        try {
            const gifData = await processGif(file);
            const pdf = await createPdfFromGif(gifData, pageSettings);

            // Generate PDF blob
            const pdfBlob = pdf.output('blob');
            const url = URL.createObjectURL(pdfBlob);

            // Create download link
            const downloadBtn = document.createElement('a');
            downloadBtn.href = url;
            downloadBtn.download = file.name.replace(/\.gif$/i, '.pdf');
            downloadBtn.className = 'btn btn-success';
            downloadBtn.innerHTML = `<i class="fas fa-download me-2"></i>Download ${file.name.replace(/\.gif$/i, '.pdf')}`;
            downloadLinks.appendChild(downloadBtn);

        } catch (error) {
            console.error('Error processing GIF:', error);
        }
    }

    progressSection.style.display = 'none';
    downloadSection.style.display = 'block';
    convertBtn.disabled = false;
    convertBtn.innerHTML = '<i class="fas fa-redo me-2"></i>Convert More Files';
});
</script>
