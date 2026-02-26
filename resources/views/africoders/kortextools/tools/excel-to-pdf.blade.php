{{-- Excel to PDF Converter --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-file-excel me-2"></i>
    Convert Excel files (XLS, XLSX) to PDF format with high fidelity.
</div>
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-file-excel fa-3x text-success me-2"></i>
                    <i class="fas fa-arrow-right fa-2x text-muted me-2"></i>
                    <i class="fas fa-file-pdf fa-3x text-danger"></i>
                </div>
                <h1 class="h2 mb-3">Excel to PDF Converter</h1>
                <p class="lead text-muted">
                    Convert Excel spreadsheets to PDF format while preserving formatting and layout
                </p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="excel-to-pdf-form" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="excel_file" class="form-label">
                                <i class="fas fa-file-excel me-2"></i>Excel File
                            </label>
                            <div class="drop-zone" id="drop-zone">
                                <div class="drop-zone-content">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <h5>Drop Excel file here or click to browse</h5>
                                    <p class="text-muted">Supports XLS, XLSX files • Maximum size: 25MB</p>
                                </div>
                                <input
                                    type="file"
                                    class="form-control"
                                    id="excel_file"
                                    name="excel_file"
                                    accept=".xls,.xlsx"
                                    required
                                    style="display: none;"
                                >
                            </div>
                            <div id="file-info" class="mt-3" style="display: none;">
                                <div class="alert alert-info">
                                    <i class="fas fa-file-excel me-2"></i>
                                    <span id="file-name"></span>
                                    <span class="badge bg-secondary ms-2" id="file-size"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="worksheet" class="form-label">
                                    <i class="fas fa-table me-2"></i>Worksheet Selection
                                </label>
                                <select class="form-select" id="worksheet" name="worksheet">
                                    <option value="all">All Worksheets</option>
                                    <option value="active">Active Worksheet Only</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="orientation" class="form-label">
                                    <i class="fas fa-rotate me-2"></i>Page Orientation
                                </label>
                                <select class="form-select" id="orientation" name="orientation">
                                    <option value="portrait">Portrait</option>
                                    <option value="landscape">Landscape</option>
                                    <option value="auto">Auto (Best Fit)</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="page_size" class="form-label">
                                    <i class="fas fa-file me-2"></i>Page Size
                                </label>
                                <select class="form-select" id="page_size" name="page_size">
                                    <option value="A4">A4</option>
                                    <option value="Letter">Letter</option>
                                    <option value="A3">A3</option>
                                    <option value="Legal">Legal</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="scaling" class="form-label">
                                    <i class="fas fa-search me-2"></i>Scaling
                                </label>
                                <select class="form-select" id="scaling" name="scaling">
                                    <option value="fit_to_page">Fit to Page</option>
                                    <option value="actual_size">Actual Size</option>
                                    <option value="fit_to_width">Fit to Width</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg" disabled id="convert-btn">
                                <i class="fas fa-exchange-alt me-2"></i>Convert to PDF
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
                        <span class="text-muted">Converting Excel to PDF...</span>
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
                    <i class="fas fa-info-circle me-2"></i>Excel to PDF Conversion
                </h6>
                <p class="mb-2">
                    Our converter preserves:
                </p>
                <ul class="mb-2">
                    <li><strong>Formatting</strong> - Colors, fonts, and cell styling</li>
                    <li><strong>Layout</strong> - Column widths and row heights</li>
                    <li><strong>Charts & Graphics</strong> - Embedded charts and images</li>
                    <li><strong>Multiple Sheets</strong> - All worksheets in separate PDF pages</li>
                    <li><strong>Print Settings</strong> - Headers, footers, and page breaks</li>
                </ul>
                <p class="mb-0">
                    <small><strong>Best for:</strong> Reports, financial statements, data presentations, and document archiving.</small>
                </p>
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
    const fileInput = document.getElementById('excel_file');
    const fileInfo = document.getElementById('file-info');
    const convertBtn = document.getElementById('convert-btn');

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
            const validTypes = [
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ];

            if (!validTypes.includes(file.type) && !file.name.toLowerCase().match(/\.(xls|xlsx)$/)) {
                alert('Please select an Excel file (XLS or XLSX)');
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

document.getElementById('excel-to-pdf-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const fileInput = document.getElementById('excel_file');

    if (!fileInput.files[0]) {
        alert('Please select an Excel file');
        return;
    }

    // Show loading
    document.getElementById('loading').style.display = 'block';
    document.getElementById('results').style.display = 'none';

    const formData = new FormData();
    formData.append('excel_file', fileInput.files[0]);
    formData.append('worksheet', document.getElementById('worksheet').value);
    formData.append('orientation', document.getElementById('orientation').value);
    formData.append('page_size', document.getElementById('page_size').value);
    formData.append('scaling', document.getElementById('scaling').value);
    formData.append('_token', document.querySelector('[name="_token"]').value);

    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "excel-to-pdf") }}', {
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
    const worksheetCount = result.worksheet_count || 1;
    const pageCount = result.page_count || 1;

    const html = `
        <div class="alert alert-success mb-4">
            <h5 class="mb-2">
                <i class="fas fa-check-circle me-2"></i>
                Excel Successfully Converted to PDF!
            </h5>
            <div class="row text-center">
                <div class="col-6">
                    <div class="border-end">
                        <div class="fs-4 text-primary">${worksheetCount}</div>
                        <small class="text-muted">Worksheet${worksheetCount !== 1 ? 's' : ''}</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="fs-4 text-primary">${pageCount}</div>
                    <small class="text-muted">PDF Page${pageCount !== 1 ? 's' : ''}</small>
                </div>
            </div>
        </div>

        <div class="text-center mb-4">
            <a href="${downloadUrl}" class="btn btn-success btn-lg" download>
                <i class="fas fa-download me-2"></i>Download PDF
            </a>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-cog me-2"></i>Conversion Settings</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2"><strong>Worksheets:</strong> ${result.worksheet_selection}</div>
                                <div class="mb-2"><strong>Orientation:</strong> ${result.orientation}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2"><strong>Page Size:</strong> ${result.page_size}</div>
                                <div class="mb-2"><strong>Scaling:</strong> ${result.scaling}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-info mt-3">
            <h6><i class="fas fa-lightbulb me-2"></i>Tips</h6>
            <ul class="mb-0">
                <li>The converted PDF will be automatically deleted after 1 hour</li>
                <li>All formatting, formulas, and charts have been preserved</li>
                <li>For best results, check your print preview in Excel before converting</li>
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
            <h6><i class="fas fa-lightbulb me-2"></i>Common Issues</h6>
            <ul class="mb-0">
                <li>Make sure your Excel file is not corrupted</li>
                <li>Try saving the file as a newer Excel format (.xlsx)</li>
                <li>Check that the file is not password protected</li>
                <li>Ensure all referenced external files are included</li>
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
