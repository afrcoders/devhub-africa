{{-- pdf to excel --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    pdf to excel tool for your development and productivity needs.
</div>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-file-pdf fa-3x text-danger me-2"></i>
                    <i class="fas fa-arrow-right fa-2x text-muted me-2"></i>
                    <i class="fas fa-file-excel fa-3x text-success"></i>
                </div>
                <h1 class="h2 mb-3">PDF to Excel Converter</h1>
                <p class="lead text-muted">
                    Extract tables and data from PDF documents and convert them to Excel spreadsheets
                </p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="pdf-to-excel-form" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="pdf_file" class="form-label">
                                <i class="fas fa-file-pdf me-2"></i>PDF File
                            </label>
                            <div class="drop-zone" id="drop-zone">
                                <div class="drop-zone-content">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <h5>Drop PDF file here or click to browse</h5>
                                    <p class="text-muted">Maximum file size: 25MB</p>
                                </div>
                                <input
                                    type="file"
                                    class="form-control"
                                    id="pdf_file"
                                    name="pdf_file"
                                    accept=".pdf"
                                    required
                                    style="display: none;"
                                >
                            </div>
                            <div id="file-info" class="mt-3" style="display: none;">
                                <div class="alert alert-info">
                                    <i class="fas fa-file-pdf me-2"></i>
                                    <span id="file-name"></span>
                                    <span class="badge bg-secondary ms-2" id="file-size"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="page_range" class="form-label">
                                    <i class="fas fa-file-alt me-2"></i>Page Range
                                </label>
                                <select class="form-select" id="page_range" name="page_range">
                                    <option value="all">All Pages</option>
                                    <option value="first">First Page Only</option>
                                    <option value="custom">Custom Range</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="output_format" class="form-label">
                                    <i class="fas fa-file-excel me-2"></i>Output Format
                                </label>
                                <select class="form-select" id="output_format" name="output_format">
                                    <option value="xlsx">Excel (.xlsx)</option>
                                    <option value="csv">CSV (.csv)</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4" id="custom-pages-input" style="display: none;">
                            <label for="custom_pages" class="form-label">
                                <i class="fas fa-list-ol me-2"></i>Page Numbers
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="custom_pages"
                                name="custom_pages"
                                placeholder="e.g., 1-3, 5, 8-10"
                            >
                            <small class="form-text text-muted">
                                Specify page numbers (e.g., 1-3, 5, 8-10) or leave blank for all pages
                            </small>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="detect_tables" name="detect_tables" checked>
                                    <label class="form-check-label" for="detect_tables">
                                        <i class="fas fa-table me-2"></i>Auto-detect Tables
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="merge_cells" name="merge_cells">
                                    <label class="form-check-label" for="merge_cells">
                                        <i class="fas fa-compress-alt me-2"></i>Preserve Merged Cells
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg" disabled id="convert-btn">
                                <i class="fas fa-exchange-alt me-2"></i>Convert to Excel
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
                        <span class="text-muted">Converting PDF to Excel...</span>
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

            <!-- Info Section -->
            <div class="alert alert-info mt-4">
                <h6 class="alert-heading">
                    <i class="fas fa-info-circle me-2"></i>PDF to Excel Conversion
                </h6>
                <p class="mb-2">
                    Conversion capabilities:
                </p>
                <ul class="mb-2">
                    <li><strong>Table Detection</strong> - Automatically identifies tabular data</li>
                    <li><strong>Data Extraction</strong> - Preserves numbers, text, and formatting</li>
                    <li><strong>Multiple Sheets</strong> - Creates separate sheets for each page/table</li>
                    <li><strong>Cell Formatting</strong> - Maintains basic text formatting where possible</li>
                    <li><strong>Custom Ranges</strong> - Process specific pages only</li>
                </ul>
                <p class="mb-0">
                    <small><strong>Best for:</strong> Financial reports, data tables, invoices, and structured documents.</small>
                </p>
            </div>

            <!-- Warning -->
            <div class="alert alert-warning mt-4">
                <h6 class="alert-heading">
                    <i class="fas fa-exclamation-triangle me-2"></i>Important Notes
                </h6>
                <ul class="mb-0">
                    <li>Works best with PDFs containing clearly structured tables</li>
                    <li>Scanned PDFs may require OCR processing for optimal results</li>
                    <li>Complex layouts may need manual adjustment in Excel</li>
                    <li>Password-protected PDFs must be unlocked first</li>
                </ul>
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
    border-color: #28a745;
    background-color: #f8f9fa;
}

.drop-zone-content h5 {
    color: #6c757d;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('pdf_file');
    const fileInfo = document.getElementById('file-info');
    const convertBtn = document.getElementById('convert-btn');
    const pageRangeSelect = document.getElementById('page_range');
    const customPagesInput = document.getElementById('custom-pages-input');

    // Show/hide custom pages input
    pageRangeSelect.addEventListener('change', function() {
        if (this.value === 'custom') {
            customPagesInput.style.display = 'block';
        } else {
            customPagesInput.style.display = 'none';
        }
    });

    // Click to select file
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

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelect();
        }
    });

    // File input change
    fileInput.addEventListener('change', handleFileSelect);

    function handleFileSelect() {
        const file = fileInput.files[0];
        if (file) {
            if (file.type !== 'application/pdf') {
                alert('Please select a PDF file');
                return;
            }

            if (file.size > 25 * 1024 * 1024) { // 25MB
                alert('File size must be less than 25MB');
                return;
            }

            document.getElementById('file-name').textContent = file.name;
            document.getElementById('file-size').textContent = formatFileSize(file.size);
            fileInfo.style.display = 'block';
            convertBtn.disabled = false;
        }
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
});

document.getElementById('pdf-to-excel-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const fileInput = document.getElementById('pdf_file');

    if (!fileInput.files[0]) {
        alert('Please select a PDF file');
        return;
    }

    // Show loading
    document.getElementById('loading').style.display = 'block';
    document.getElementById('results').style.display = 'none';

    const formData = new FormData();
    formData.append('pdf_file', fileInput.files[0]);
    formData.append('page_range', document.getElementById('page_range').value);
    formData.append('output_format', document.getElementById('output_format').value);
    formData.append('custom_pages', document.getElementById('custom_pages').value);
    formData.append('detect_tables', document.getElementById('detect_tables').checked);
    formData.append('merge_cells', document.getElementById('merge_cells').checked);
    formData.append('_token', document.querySelector('[name="_token"]').value);

    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "pdf-to-excel") }}', {
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
    const fileName = result.filename;
    const downloadUrl = result.download_url;
    const tablesFound = result.tables_found || 0;
    const pagesProcessed = result.pages_processed || 0;

    const html = `
        <div class="alert alert-success mb-4">
            <h5 class="mb-2">
                <i class="fas fa-check-circle me-2"></i>
                PDF Successfully Converted to Excel!
            </h5>
            <div class="row text-center">
                <div class="col-6">
                    <div class="border-end">
                        <div class="fs-4 text-primary">${pagesProcessed}</div>
                        <small class="text-muted">Page${pagesProcessed !== 1 ? 's' : ''} Processed</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="fs-4 text-primary">${tablesFound}</div>
                    <small class="text-muted">Table${tablesFound !== 1 ? 's' : ''} Found</small>
                </div>
            </div>
        </div>

        <div class="text-center mb-4">
            <a href="${downloadUrl}" class="btn btn-success btn-lg" download>
                <i class="fas fa-download me-2"></i>Download ${result.output_format.toUpperCase()} File
            </a>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Conversion Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2"><strong>Pages:</strong> ${result.page_selection}</div>
                                <div class="mb-2"><strong>Format:</strong> ${result.output_format.toUpperCase()}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong>Table Detection:</strong>
                                    <span class="badge ${result.detect_tables ? 'bg-success' : 'bg-secondary'}">
                                        ${result.detect_tables ? 'Enabled' : 'Disabled'}
                                    </span>
                                </div>
                                <div class="mb-2">
                                    <strong>Merged Cells:</strong>
                                    <span class="badge ${result.merge_cells ? 'bg-success' : 'bg-secondary'}">
                                        ${result.merge_cells ? 'Preserved' : 'Not Preserved'}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        ${tablesFound > 0 ? `
            <div class="alert alert-success mt-3">
                <h6><i class="fas fa-table me-2"></i>Tables Extracted Successfully</h6>
                <p class="mb-0">
                    ${tablesFound} table${tablesFound !== 1 ? 's were' : ' was'} found and converted.
                    Each table has been placed in a separate worksheet.
                </p>
            </div>
        ` : `
            <div class="alert alert-warning mt-3">
                <h6><i class="fas fa-exclamation-triangle me-2"></i>No Tables Detected</h6>
                <p class="mb-0">
                    The PDF content has been extracted as text. You may need to manually format the data in Excel.
                </p>
            </div>
        `}

        <div class="alert alert-info mt-3">
            <h6><i class="fas fa-lightbulb me-2"></i>Tips</h6>
            <ul class="mb-0">
                <li>The converted file will be automatically deleted after 1 hour</li>
                <li>Open the file in Excel or Google Sheets to view and edit the data</li>
                <li>You may need to adjust column widths and formatting</li>
                <li>Complex tables may require manual cleanup</li>
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
            <h6><i class="fas fa-lightbulb me-2"></i>Troubleshooting</h6>
            <ul class="mb-0">
                <li>Ensure the PDF is not password protected</li>
                <li>Try converting specific pages instead of the entire document</li>
                <li>Check that the PDF contains actual text (not just scanned images)</li>
                <li>For scanned PDFs, consider using OCR tools first</li>
                <li>Large or complex PDFs may require more processing time</li>
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

