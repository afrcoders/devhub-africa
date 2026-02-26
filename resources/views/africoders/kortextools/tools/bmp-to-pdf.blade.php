{{-- BMP to PDF Converter --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-file-pdf me-2"></i>
    Convert BMP images to PDF format while maintaining image quality.
</div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-exchange-alt me-2"></i>
                        {{ $tool->name }}
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">{{ $tool->description }}</p>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="fileInput" class="form-label">Select BMP File(s)</label>
                                <input type="file" class="form-control" id="fileInput" accept=".bmp" multiple>
                                <div class="form-text">Choose one or more BMP image files to convert to PDF</div>
                            </div>

                            <div class="mb-3">
                                <label for="pageSize" class="form-label">Page Size</label>
                                <select class="form-select" id="pageSize">
                                    <option value="a4">A4</option>
                                    <option value="letter">Letter</option>
                                    <option value="legal">Legal</option>
                                    <option value="a3">A3</option>
                                    <option value="custom">Fit to Image</option>
                                </select>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-primary" id="convertBtn" disabled>
                                    <i class="fas fa-magic me-2"></i>Convert to PDF
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="resultSection" class="mt-4" style="display: none;">
                        <hr>
                        <h5>PDF Ready:</h5>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            Your BMP images have been converted to PDF successfully!
                        </div>
                        <button type="button" class="btn btn-success" id="downloadBtn">
                            <i class="fas fa-download me-2"></i>Download PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
const fileInput = document.getElementById('fileInput');
const convertBtn = document.getElementById('convertBtn');
const pageSize = document.getElementById('pageSize');
const resultSection = document.getElementById('resultSection');
const downloadBtn = document.getElementById('downloadBtn');

let pdfBlob = null;

// Page size configurations
const pageSizes = {
    a4: [210, 297],
    letter: [216, 279],
    legal: [216, 356],
    a3: [297, 420],
    custom: null
};

// Enable convert button when files are selected
fileInput.addEventListener('change', function() {
    convertBtn.disabled = !this.files.length;
});

// Convert BMP to PDF
convertBtn.addEventListener('click', function() {
    const files = fileInput.files;
    if (!files.length) return;

    this.disabled = true;
    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Converting...';

    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF();
    let loadedImages = 0;
    const totalImages = files.length;

    // Remove the default empty page
    pdf.deletePage(1);

    Array.from(files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = new Image();
            img.onload = function() {
                const selectedSize = pageSize.value;
                let pageWidth, pageHeight;

                if (selectedSize === 'custom') {
                    // Fit to image size (in mm, assuming 96 DPI)
                    pageWidth = (img.width * 25.4) / 96;
                    pageHeight = (img.height * 25.4) / 96;
                } else {
                    [pageWidth, pageHeight] = pageSizes[selectedSize];
                }

                // Add new page for each image
                pdf.addPage([pageWidth, pageHeight]);

                // Calculate dimensions to fit image properly
                const imgRatio = img.width / img.height;
                const pageRatio = pageWidth / pageHeight;

                let finalWidth, finalHeight, x, y;

                if (imgRatio > pageRatio) {
                    // Image is wider relative to page
                    finalWidth = pageWidth;
                    finalHeight = pageWidth / imgRatio;
                    x = 0;
                    y = (pageHeight - finalHeight) / 2;
                } else {
                    // Image is taller relative to page
                    finalHeight = pageHeight;
                    finalWidth = pageHeight * imgRatio;
                    y = 0;
                    x = (pageWidth - finalWidth) / 2;
                }

                pdf.addImage(img, 'BMP', x, y, finalWidth, finalHeight);

                loadedImages++;

                if (loadedImages === totalImages) {
                    // All images processed
                    pdfBlob = pdf.output('blob');
                    resultSection.style.display = 'block';

                    // Re-enable button
                    convertBtn.disabled = false;
                    convertBtn.innerHTML = '<i class="fas fa-magic me-2"></i>Convert to PDF';
                }
            };

            img.onerror = function() {
                alert(`Error loading image: ${file.name}`);
                convertBtn.disabled = false;
                convertBtn.innerHTML = '<i class="fas fa-magic me-2"></i>Convert to PDF';
            };

            img.src = e.target.result;
        };

        reader.readAsDataURL(file);
    });
});

// Download PDF
downloadBtn.addEventListener('click', function() {
    if (!pdfBlob) return;

    const url = URL.createObjectURL(pdfBlob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'bmp-to-pdf-conversion.pdf';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
});
</script>
