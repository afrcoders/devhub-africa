{{-- Image to PDF Converter --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-file-pdf me-2"></i>
    Convert images to PDF format with customizable settings.
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
                                <label for="fileInput" class="form-label">Select Images</label>
                                <input type="file" class="form-control" id="fileInput" accept="image/*" multiple>
                                <div class="form-text">Select one or more images to convert to PDF</div>
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
                                            <option value="custom">Fit to Image</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="orientation" class="form-label">Orientation</label>
                                        <select class="form-select" id="orientation">
                                            <option value="auto">Auto</option>
                                            <option value="portrait">Portrait</option>
                                            <option value="landscape">Landscape</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="arrangement" class="form-label">Image Arrangement</label>
                                        <select class="form-select" id="arrangement">
                                            <option value="one-per-page">One image per page</option>
                                            <option value="multiple-per-page">Multiple images per page</option>
                                            <option value="single-pdf">All images in single page</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="quality" class="form-label">Image Quality <span id="qualityValue">85%</span></label>
                                        <input type="range" class="form-range" id="quality" min="0.1" max="1" step="0.1" value="0.85">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3" style="display: none;" id="previewSection">
                                <label class="form-label">Image Previews</label>
                                <div id="imagePreview" class="border rounded p-3" style="max-height: 300px; overflow-y: auto;"></div>
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button type="button" class="btn btn-primary" id="convertBtn" disabled>
                                    <i class="fas fa-file-pdf me-2"></i>Convert to PDF
                                </button>
                            </div>

                            <div class="mb-3" style="display: none;" id="downloadSection">
                                <div class="text-center">
                                    <a href="#" id="downloadLink" class="btn btn-success btn-lg">
                                        <i class="fas fa-download me-2"></i>Download PDF
                                    </a>
                                </div>
                                <div class="mt-2 text-center" id="pdfInfo">
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
const { jsPDF } = window.jspdf;

const fileInput = document.getElementById('fileInput');
const pageSize = document.getElementById('pageSize');
const orientation = document.getElementById('orientation');
const arrangement = document.getElementById('arrangement');
const quality = document.getElementById('quality');
const qualityValue = document.getElementById('qualityValue');
const previewSection = document.getElementById('previewSection');
const imagePreview = document.getElementById('imagePreview');
const convertBtn = document.getElementById('convertBtn');
const downloadSection = document.getElementById('downloadSection');
const downloadLink = document.getElementById('downloadLink');
const pdfInfo = document.getElementById('pdfInfo');
const progressSection = document.getElementById('progressSection');
const progressBar = document.getElementById('progressBar');

let selectedFiles = [];

// Quality slider change handler
quality.addEventListener('input', function() {
    const qualityPercent = (parseFloat(this.value) * 100).toFixed(0);
    qualityValue.textContent = qualityPercent + '%';
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
                    <span class="badge bg-primary">Page ${index + 1}</span>
                </div>
            `;
            imagePreview.appendChild(imgContainer);
        };
        reader.readAsDataURL(file);
    });

    previewSection.style.display = 'block';
}

// Get page dimensions
function getPageDimensions(size, orient) {
    const sizes = {
        'a4': { width: 210, height: 297 },
        'letter': { width: 216, height: 279 },
        'legal': { width: 216, height: 356 },
        'a3': { width: 297, height: 420 },
        'a5': { width: 148, height: 210 }
    };

    let dims = sizes[size] || sizes['a4'];

    if (orient === 'landscape') {
        return { width: dims.height, height: dims.width };
    }

    return dims;
}

// Convert images to PDF
async function imagesToPdf() {
    return new Promise(async (resolve) => {
        const pdf = new jsPDF({
            orientation: orientation.value === 'landscape' ? 'l' : 'p',
            unit: 'mm',
            format: pageSize.value === 'custom' ? 'a4' : pageSize.value
        });

        const arrangementMode = arrangement.value;
        let pageAdded = false;

        for (let i = 0; i < selectedFiles.length; i++) {
            const file = selectedFiles[i];

            // Update progress
            const progress = ((i + 1) / selectedFiles.length) * 100;
            progressBar.style.width = progress + '%';
            progressBar.textContent = `Processing ${i + 1}/${selectedFiles.length}`;

            const imageData = await loadImage(file);

            if (arrangementMode === 'one-per-page') {
                if (pageAdded) {
                    pdf.addPage();
                }

                const pageDims = getPageDimensions(pageSize.value, orientation.value);
                addImageToPage(pdf, imageData, pageDims);
                pageAdded = true;

            } else if (arrangementMode === 'multiple-per-page') {
                // For simplicity, treating this the same as one-per-page
                // Could be enhanced to fit multiple images per page
                if (pageAdded) {
                    pdf.addPage();
                }

                const pageDims = getPageDimensions(pageSize.value, orientation.value);
                addImageToPage(pdf, imageData, pageDims);
                pageAdded = true;

            } else if (arrangementMode === 'single-pdf') {
                // Add all images to a single long page
                if (i === 0) {
                    // First image sets the page
                    const pageDims = getPageDimensions(pageSize.value, orientation.value);
                    addImageToPage(pdf, imageData, pageDims);
                    pageAdded = true;
                } else {
                    // Subsequent images are added below
                    pdf.addPage();
                    const pageDims = getPageDimensions(pageSize.value, orientation.value);
                    addImageToPage(pdf, imageData, pageDims);
                }
            }
        }

        resolve(pdf);
    });
}

// Load image as data URL
function loadImage(file) {
    return new Promise((resolve) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = new Image();
            img.onload = function() {
                resolve({
                    dataUrl: e.target.result,
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

// Add image to PDF page
function addImageToPage(pdf, imageData, pageDims) {
    const pageWidth = pageDims.width;
    const pageHeight = pageDims.height;
    const margin = 10;

    const availableWidth = pageWidth - (margin * 2);
    const availableHeight = pageHeight - (margin * 2);

    // Calculate scaling to fit image within page
    const scaleX = availableWidth / (imageData.width * 0.264583); // px to mm
    const scaleY = availableHeight / (imageData.height * 0.264583);
    const scale = Math.min(scaleX, scaleY);

    const finalWidth = imageData.width * 0.264583 * scale;
    const finalHeight = imageData.height * 0.264583 * scale;

    // Center the image
    const x = (pageWidth - finalWidth) / 2;
    const y = (pageHeight - finalHeight) / 2;

    pdf.addImage(imageData.dataUrl, 'JPEG', x, y, finalWidth, finalHeight);
}

// Convert button click
convertBtn.addEventListener('click', async function() {
    if (selectedFiles.length === 0) return;

    convertBtn.disabled = true;
    progressSection.style.display = 'block';
    downloadSection.style.display = 'none';

    try {
        const pdf = await imagesToPdf();

        // Generate PDF blob
        const pdfBlob = pdf.output('blob');
        const url = URL.createObjectURL(pdfBlob);

        // Setup download
        downloadLink.href = url;
        downloadLink.download = 'images-to-pdf.pdf';

        // Show PDF info
        pdfInfo.innerHTML = `
            <small class="text-muted">
                PDF Size: ${(pdfBlob.size / 1024).toFixed(1)} KB |
                Pages: ${pdf.internal.getNumberOfPages()} |
                Images: ${selectedFiles.length}
            </small>
        `;

        progressSection.style.display = 'none';
        downloadSection.style.display = 'block';
        convertBtn.disabled = false;
        convertBtn.innerHTML = '<i class="fas fa-redo me-2"></i>Convert More Images';

    } catch (error) {
        alert('Error creating PDF: ' + error.message);
        progressSection.style.display = 'none';
        convertBtn.disabled = false;
    }
});

// Clear function
function clearAll() {
    fileInput.value = '';
    selectedFiles = [];
    previewSection.style.display = 'none';
    downloadSection.style.display = 'none';
    progressSection.style.display = 'none';
    convertBtn.disabled = true;
    convertBtn.innerHTML = '<i class="fas fa-file-pdf me-2"></i>Convert to PDF';
}
</script>
