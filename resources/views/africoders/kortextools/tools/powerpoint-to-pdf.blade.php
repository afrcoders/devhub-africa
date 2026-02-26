{{-- powerpoint to pdf --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    powerpoint to pdf tool for your development and productivity needs.
</div>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-file-powerpoint fa-3x text-warning me-2"></i>
                    <i class="fas fa-arrow-right fa-2x text-muted me-2"></i>
                    <i class="fas fa-file-pdf fa-3x text-danger"></i>
                </div>
                <h1 class="h2 mb-3">PowerPoint to PDF Converter</h1>
                <p class="lead text-muted">
                    Convert PowerPoint presentations to PDF format while preserving layouts and animations
                </p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="powerpoint-to-pdf-form" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="ppt_file" class="form-label">
                                <i class="fas fa-file-powerpoint me-2"></i>PowerPoint File
                            </label>
                            <div class="drop-zone" id="drop-zone">
                                <div class="drop-zone-content">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <h5>Drop PowerPoint file here or click to browse</h5>
                                    <p class="text-muted">Supports PPT, PPTX files • Maximum size: 50MB</p>
                                </div>
                                <input
                                    type="file"
                                    class="form-control"
                                    id="ppt_file"
                                    name="ppt_file"
                                    accept=".ppt,.pptx"
                                    required
                                    style="display: none;"
                                >
                            </div>
                            <div id="file-info" class="mt-3" style="display: none;">
                                <div class="alert alert-info">
                                    <i class="fas fa-file-powerpoint me-2"></i>
                                    <span id="file-name"></span>
                                    <span class="badge bg-secondary ms-2" id="file-size"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="slide_range" class="form-label">
                                    <i class="fas fa-images me-2"></i>Slide Range
                                </label>
                                <select class="form-select" id="slide_range" name="slide_range">
                                    <option value="all">All Slides</option>
                                    <option value="current">Current Slide Only</option>
                                    <option value="custom">Custom Range</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="quality" class="form-label">
                                    <i class="fas fa-sliders-h me-2"></i>Output Quality
                                </label>
                                <select class="form-select" id="quality" name="quality">
                                    <option value="high">High Quality</option>
                                    <option value="medium" selected>Medium Quality</option>
                                    <option value="low">Low Quality (Smaller File)</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4" id="custom-range-input" style="display: none;">
                            <label for="custom_slides" class="form-label">
                                <i class="fas fa-list-ol me-2"></i>Slide Numbers
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="custom_slides"
                                name="custom_slides"
                                placeholder="e.g., 1-5, 8, 10-12"
                            >
                            <small class="form-text text-muted">
                                Specify slide numbers (e.g., 1-5, 8, 10-12) or leave blank for all slides
                            </small>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="include_notes" name="include_notes">
                                    <label class="form-check-label" for="include_notes">
                                        <i class="fas fa-sticky-note me-2"></i>Include Speaker Notes
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="include_hidden" name="include_hidden">
                                    <label class="form-check-label" for="include_hidden">
                                        <i class="fas fa-eye-slash me-2"></i>Include Hidden Slides
                                    </label>
                                </div>
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
                        <span class="text-muted">Converting PowerPoint to PDF...</span>
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
                    <i class="fas fa-info-circle me-2"></i>PowerPoint to PDF Conversion
                </h6>
                <p class="mb-2">
                    Our converter preserves:
                </p>
                <ul class="mb-2">
                    <li><strong>Layouts</strong> - Slide layouts and formatting</li>
                    <li><strong>Images & Graphics</strong> - All embedded media</li>
                    <li><strong>Text Formatting</strong> - Fonts, colors, and styling</li>
                    <li><strong>Transitions</strong> - Static representation of slide transitions</li>
                    <li><strong>Speaker Notes</strong> - Optional inclusion of presentation notes</li>
                </ul>
                <p class="mb-0">
                    <small><strong>Best for:</strong> Sharing presentations, document archiving, printing handouts, and email distribution.</small>
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
    border-color: #ffc107;
    background-color: #f8f9fa;
}

.drop-zone-content h5 {
    color: #6c757d;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('ppt_file');
    const fileInfo = document.getElementById('file-info');
    const convertBtn = document.getElementById('convert-btn');
    const slideRangeSelect = document.getElementById('slide_range');
    const customRangeInput = document.getElementById('custom-range-input');

    // Show/hide custom range input
    slideRangeSelect.addEventListener('change', function() {
        if (this.value === 'custom') {
            customRangeInput.style.display = 'block';
        } else {
            customRangeInput.style.display = 'none';
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
            const validTypes = [
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation'
            ];

            if (!validTypes.includes(file.type) && !file.name.toLowerCase().match(/\.(ppt|pptx)$/)) {
                alert('Please select a PowerPoint file (PPT or PPTX)');
                return;
            }

            if (file.size > 50 * 1024 * 1024) { // 50MB
                alert('File size must be less than 50MB');
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

document.getElementById('powerpoint-to-pdf-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const fileInput = document.getElementById('ppt_file');

    if (!fileInput.files[0]) {
        alert('Please select a PowerPoint file');
        return;
    }

    // Show loading
    document.getElementById('loading').style.display = 'block';
    document.getElementById('results').style.display = 'none';

    const formData = new FormData();
    formData.append('ppt_file', fileInput.files[0]);
    formData.append('slide_range', document.getElementById('slide_range').value);
    formData.append('quality', document.getElementById('quality').value);
    formData.append('custom_slides', document.getElementById('custom_slides').value);
    formData.append('include_notes', document.getElementById('include_notes').checked);
    formData.append('include_hidden', document.getElementById('include_hidden').checked);
    formData.append('_token', document.querySelector('[name="_token"]').value);

    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "powerpoint-to-pdf") }}', {
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
    const slideCount = result.slide_count || 0;
    const pageCount = result.page_count || slideCount;

    const html = `
        <div class="alert alert-success mb-4">
            <h5 class="mb-2">
                <i class="fas fa-check-circle me-2"></i>
                PowerPoint Successfully Converted to PDF!
            </h5>
            <div class="row text-center">
                <div class="col-6">
                    <div class="border-end">
                        <div class="fs-4 text-primary">${slideCount}</div>
                        <small class="text-muted">Slide${slideCount !== 1 ? 's' : ''} Converted</small>
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
                                <div class="mb-2"><strong>Slides:</strong> ${result.slide_selection}</div>
                                <div class="mb-2"><strong>Quality:</strong> ${result.quality}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong>Speaker Notes:</strong>
                                    <span class="badge ${result.includes_notes ? 'bg-success' : 'bg-secondary'}">
                                        ${result.includes_notes ? 'Included' : 'Not Included'}
                                    </span>
                                </div>
                                <div class="mb-2">
                                    <strong>Hidden Slides:</strong>
                                    <span class="badge ${result.includes_hidden ? 'bg-success' : 'bg-secondary'}">
                                        ${result.includes_hidden ? 'Included' : 'Not Included'}
                                    </span>
                                </div>
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
                <li>All slide layouts, images, and formatting have been preserved</li>
                <li>For presentations with animations, consider using high quality setting</li>
                <li>PDF format provides excellent compatibility across all devices</li>
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
                <li>Make sure your PowerPoint file is not corrupted</li>
                <li>Try saving the file as a newer PowerPoint format (.pptx)</li>
                <li>Check that the file is not password protected</li>
                <li>Ensure all media files referenced in slides are embedded</li>
                <li>Large files with many images may take longer to process</li>
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

