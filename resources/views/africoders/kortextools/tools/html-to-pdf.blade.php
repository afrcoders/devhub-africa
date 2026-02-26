{{-- html to pdf --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    html to pdf tool for your development and productivity needs.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-file-pdf me-3"></i>HTML to PDF Converter
                </h1>
                <p class="lead text-muted">
                    Convert HTML code to PDF documents while preserving formatting and styles
                </p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-code me-2"></i>HTML to PDF Conversion</h5>
                </div>
                <div class="card-body">
                    <form id="htmlToPdfForm">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="mb-4">
                                    <label for="htmlInput" class="form-label fw-semibold">
                                        <i class="fas fa-code me-2"></i>HTML Content
                                    </label>
                                    <textarea class="form-control" id="htmlInput" rows="12"
                                        placeholder="Paste your HTML content here..."
                                        style="font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace; font-size: 0.9rem;"></textarea>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Paste complete HTML with CSS styles for best results.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-cog me-2"></i>PDF Options
                                    </label>

                                    <div class="mb-3">
                                        <label for="pageFormat" class="form-label small">Page Format</label>
                                        <select class="form-select" id="pageFormat">
                                            <option value="A4">A4 (210 × 297 mm)</option>
                                            <option value="A3">A3 (297 × 420 mm)</option>
                                            <option value="Letter">Letter (8.5 × 11 in)</option>
                                            <option value="Legal">Legal (8.5 × 14 in)</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="orientation" class="form-label small">Orientation</label>
                                        <select class="form-select" id="orientation">
                                            <option value="portrait">Portrait</option>
                                            <option value="landscape">Landscape</option>
                                        </select>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="includeCSS" checked>
                                        <label class="form-check-label" for="includeCSS">
                                            Include CSS Styles
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="printBackground">
                                        <label class="form-check-label" for="printBackground">
                                            Print Background
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mb-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-file-pdf me-2"></i>Convert to PDF
                            </button>
                            <button type="button" id="clearBtn" class="btn btn-outline-secondary btn-lg ms-3">
                                <i class="fas fa-trash-alt me-2"></i>Clear
                            </button>
                            <button type="button" id="previewBtn" class="btn btn-outline-info btn-lg ms-2">
                                <i class="fas fa-eye me-2"></i>Preview
                            </button>
                        </div>
                    </form>

                    <div id="previewSection" style="display: none;">
                        <div class="border-top pt-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-eye me-2"></i>HTML Preview
                            </h6>
                            <div class="border rounded" style="max-height: 400px; overflow: auto;">
                                <iframe id="htmlPreview" style="width: 100%; height: 380px; border: none;"></iframe>
                            </div>
                        </div>
                    </div>

                    <div id="resultSection" style="display: none;">
                        <div class="border-top pt-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h6 class="fw-semibold mb-0">
                                    <i class="fas fa-check-circle text-success me-2"></i>PDF Generated Successfully!
                                </h6>
                                <span class="badge bg-success">Ready for Download</span>
                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" id="downloadBtn" class="btn btn-success btn-lg">
                                    <i class="fas fa-download me-2"></i>Download PDF
                                </button>
                                <button type="button" id="newConversionBtn" class="btn btn-outline-primary">
                                    <i class="fas fa-plus me-2"></i>New Conversion
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="card-title text-primary">
                                <i class="fas fa-info-circle me-2"></i>Features
                            </h6>
                            <ul class="small mb-0">
                                <li>Preserves CSS styling and formatting</li>
                                <li>Multiple page formats supported</li>
                                <li>Portrait and landscape orientation</li>
                                <li>Background graphics option</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="card-title text-primary">
                                <i class="fas fa-lightbulb me-2"></i>Tips
                            </h6>
                            <ul class="small mb-0">
                                <li>Include inline CSS for best results</li>
                                <li>Avoid external resources when possible</li>
                                <li>Use web-safe fonts</li>
                                <li>Test with preview before converting</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="card-title text-primary">
                                <i class="fas fa-cogs me-2"></i>Use Cases
                            </h6>
                            <ul class="small mb-0">
                                <li>Reports and documentation</li>
                                <li>Invoices and receipts</li>
                                <li>Web page archiving</li>
                                <li>Print-ready documents</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('htmlToPdfForm');
    const htmlInput = document.getElementById('htmlInput');
    const previewSection = document.getElementById('previewSection');
    const resultSection = document.getElementById('resultSection');
    const htmlPreview = document.getElementById('htmlPreview');
    const clearBtn = document.getElementById('clearBtn');
    const previewBtn = document.getElementById('previewBtn');
    const downloadBtn = document.getElementById('downloadBtn');
    const newConversionBtn = document.getElementById('newConversionBtn');

    let generatedPdfBlob = null;

    // Sample HTML for demonstration
    const sampleHTML = `<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h1 { color: #2c3e50; border-bottom: 2px solid #3498db; }
        h2 { color: #34495e; }
        .highlight { background-color: #f39c12; color: white; padding: 5px; }
        .info-box { border: 1px solid #bdc3c7; padding: 15px; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>Sample HTML Document</h1>
    <h2>Introduction</h2>
    <p>This is a sample HTML document with <span class="highlight">styling</span> that demonstrates the HTML to PDF conversion.</p>

    <div class="info-box">
        <h3>Information Box</h3>
        <p>This box shows how CSS styling is preserved during conversion.</p>
    </div>

    <h2>Features</h2>
    <ul>
        <li>CSS styling support</li>
        <li>Custom fonts and colors</li>
        <li>Layout preservation</li>
        <li>High quality output</li>
    </ul>
</body>
</html>`;

    function showPreview() {
        const htmlContent = htmlInput.value.trim();
        if (!htmlContent) {
            alert('Please enter some HTML content to preview.');
            return;
        }

        const blob = new Blob([htmlContent], { type: 'text/html' });
        const url = URL.createObjectURL(blob);
        htmlPreview.src = url;
        previewSection.style.display = 'block';
    }

    function generatePDF() {
        const htmlContent = htmlInput.value.trim();

        if (!htmlContent) {
            alert('Please enter some HTML content to convert.');
            return;
        }

        // Create a temporary iframe to render the HTML
        const tempFrame = document.createElement('iframe');
        tempFrame.style.position = 'absolute';
        tempFrame.style.left = '-9999px';
        tempFrame.style.width = '794px'; // A4 width in pixels at 96 DPI
        tempFrame.style.height = '1123px'; // A4 height in pixels at 96 DPI
        document.body.appendChild(tempFrame);

        tempFrame.contentDocument.open();
        tempFrame.contentDocument.write(htmlContent);
        tempFrame.contentDocument.close();

        // Wait for content to load, then convert
        setTimeout(() => {
            html2canvas(tempFrame.contentDocument.body, {
                width: 794,
                height: 1123,
                useCORS: true
            }).then(canvas => {
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF({
                    orientation: document.getElementById('orientation').value,
                    unit: 'pt',
                    format: document.getElementById('pageFormat').value.toLowerCase()
                });

                const imgData = canvas.toDataURL('image/png');
                const imgWidth = pdf.internal.pageSize.getWidth();
                const imgHeight = (canvas.height * imgWidth) / canvas.width;

                pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);

                generatedPdfBlob = pdf.output('blob');
                document.body.removeChild(tempFrame);

                resultSection.style.display = 'block';
            }).catch(error => {
                console.error('Error generating PDF:', error);
                alert('Error generating PDF. Please check your HTML content.');
                document.body.removeChild(tempFrame);
            });
        }, 1000);
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        generatePDF();
    });

    previewBtn.addEventListener('click', showPreview);

    clearBtn.addEventListener('click', function() {
        htmlInput.value = '';
        previewSection.style.display = 'none';
        resultSection.style.display = 'none';
        generatedPdfBlob = null;
    });

    downloadBtn.addEventListener('click', function() {
        if (generatedPdfBlob) {
            const url = URL.createObjectURL(generatedPdfBlob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'converted-document.pdf';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }
    });

    newConversionBtn.addEventListener('click', function() {
        htmlInput.value = '';
        previewSection.style.display = 'none';
        resultSection.style.display = 'none';
        generatedPdfBlob = null;
    });

    // Load sample HTML on page load
    if (!htmlInput.value.trim()) {
        htmlInput.value = sampleHTML;
    }
});
</script>

