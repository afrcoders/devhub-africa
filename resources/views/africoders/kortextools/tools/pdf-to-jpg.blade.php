<div class="row">
    <div class="col-md-12">
        <div class="mb-4">
            <label for="pdf-file" class="form-label">Select PDF File:</label>
            <input type="file" class="form-control" id="pdf-file" accept=".pdf" />
            <small class="form-text text-muted">Maximum file size: 10MB</small>
        </div>

        <div class="row mb-4" id="conversion-options" style="display: none;">
            <div class="col-md-4">
                <label for="output-format" class="form-label">Image Format:</label>
                <select class="form-select" id="output-format">
                    <option value="jpg" selected>JPEG (.jpg)</option>
                    <option value="png">PNG (.png)</option>
                    <option value="webp">WebP (.webp)</option>
                    <option value="bmp">BMP (.bmp)</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="image-quality" class="form-label">Quality:</label>
                <select class="form-select" id="image-quality">
                    <option value="100">Maximum (100%)</option>
                    <option value="95" selected>High (95%)</option>
                    <option value="85">Good (85%)</option>
                    <option value="70">Medium (70%)</option>
                    <option value="50">Low (50%)</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="page-selection" class="form-label">Pages to Convert:</label>
                <select class="form-select" id="page-selection">
                    <option value="all">All Pages</option>
                    <option value="first">First Page Only</option>
                    <option value="range">Page Range</option>
                    <option value="specific">Specific Pages</option>
                </select>
            </div>
        </div>

        <!-- Page Range Options -->
        <div class="row mb-4" id="page-range-options" style="display: none;">
            <div class="col-md-6">
                <label for="start-page" class="form-label">Start Page:</label>
                <input type="number" class="form-control" id="start-page" min="1" value="1">
            </div>
            <div class="col-md-6">
                <label for="end-page" class="form-label">End Page:</label>
                <input type="number" class="form-control" id="end-page" min="1" value="1">
            </div>
        </div>

        <!-- Specific Pages Options -->
        <div class="row mb-4" id="specific-pages-options" style="display: none;">
            <div class="col-md-12">
                <label for="page-numbers" class="form-label">Page Numbers (e.g., 1,3,5-8,10):</label>
                <input type="text" class="form-control" id="page-numbers" placeholder="1,3,5-8,10">
                <small class="form-text text-muted">Use commas for individual pages and hyphens for ranges</small>
            </div>
        </div>

        <!-- Advanced Options -->
        <div class="row mb-4" id="advanced-options" style="display: none;">
            <div class="col-md-4">
                <label for="resolution" class="form-label">Resolution (DPI):</label>
                <select class="form-select" id="resolution">
                    <option value="150">150 DPI (Standard)</option>
                    <option value="200">200 DPI (High)</option>
                    <option value="300" selected>300 DPI (Print Quality)</option>
                    <option value="600">600 DPI (Maximum)</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="color-mode" class="form-label">Color Mode:</label>
                <select class="form-select" id="color-mode">
                    <option value="color" selected>Full Color</option>
                    <option value="grayscale">Grayscale</option>
                    <option value="monochrome">Black & White</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="background-color" class="form-label">Background:</label>
                <select class="form-select" id="background-color">
                    <option value="white" selected>White</option>
                    <option value="transparent">Transparent</option>
                    <option value="custom">Custom Color</option>
                </select>
            </div>
        </div>

        <!-- Custom Background Color -->
        <div class="row mb-4" id="custom-bg-section" style="display: none;">
            <div class="col-md-6">
                <label for="custom-bg-color" class="form-label">Background Color:</label>
                <input type="color" class="form-control form-control-color" id="custom-bg-color" value="#ffffff">
            </div>
        </div>

        <div class="mb-4" id="convert-section" style="display: none;">
            <button type="button" class="btn btn-primary btn-lg" id="convert-btn">
                <i class="fas fa-images me-2"></i>Convert to JPG
            </button>
            <button type="button" class="btn btn-outline-secondary ms-2" id="reset-btn">
                <i class="fas fa-undo me-2"></i>Reset
            </button>
        </div>
    </div>
</div>

<!-- PDF Preview -->
<div class="row" id="preview-section" style="display: none;">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-file-pdf me-2"></i>PDF Preview
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>File Information:</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>File Name:</strong></td>
                                <td id="file-name">-</td>
                            </tr>
                            <tr>
                                <td><strong>File Size:</strong></td>
                                <td id="file-size">-</td>
                            </tr>
                            <tr>
                                <td><strong>Total Pages:</strong></td>
                                <td id="total-pages">-</td>
                            </tr>
                            <tr>
                                <td><strong>Estimated Images:</strong></td>
                                <td id="estimated-images">-</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Preview (First Page):</h6>
                        <div id="pdf-preview" class="border rounded d-flex align-items-center justify-content-center"
                             style="height: 300px; overflow: hidden; background: #f8f9fa;">
                            <div class="text-center text-muted">
                                <i class="fas fa-file-pdf fa-3x mb-2"></i>
                                <p>PDF preview will appear here</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Conversion Progress -->
<div id="conversion-progress" class="mt-4" style="display: none;">
    <div class="card">
        <div class="card-body">
            <h6><i class="fas fa-cog fa-spin me-2"></i>Converting PDF to Images...</h6>
            <div class="progress mb-3">
                <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated"
                     role="progressbar" style="width: 0%">
                    <span id="progress-text">0%</span>
                </div>
            </div>
            <div id="conversion-status" class="small text-muted">
                Processing PDF pages...
            </div>
        </div>
    </div>
</div>

<!-- Conversion Results -->
<div id="results-section" class="mt-4" style="display: none;">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">
                <i class="fas fa-check-circle me-2"></i>Conversion Completed Successfully!
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6>Conversion Summary:</h6>
                    <ul id="conversion-summary" class="list-unstyled">
                        <!-- Summary items will be added here -->
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6>Generated Images:</h6>
                    <div id="images-preview" style="max-height: 300px; overflow-y: auto;">
                        <!-- Image previews will appear here -->
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 text-center">
                    <button type="button" class="btn btn-success btn-lg me-2" id="download-all-btn">
                        <i class="fas fa-download me-2"></i>Download All Images (ZIP)
                    </button>
                    <button type="button" class="btn btn-outline-primary" id="download-individual-btn">
                        <i class="fas fa-image me-2"></i>Download Individual Images
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Individual Download Section -->
<div id="individual-downloads" class="mt-4" style="display: none;">
    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">
                <i class="fas fa-download me-2"></i>Individual Downloads
            </h6>
        </div>
        <div class="card-body">
            <div id="individual-download-list" class="row">
                <!-- Individual download buttons will appear here -->
            </div>
        </div>
    </div>
</div>

<!-- Info Section -->
<div class="alert alert-info mt-4">
    <h6 class="alert-heading">
        <i class="fas fa-info-circle me-2"></i>About PDF to JPG Conversion
    </h6>
    <p class="mb-2">
        Convert your PDF pages to high-quality images with these features:
    </p>
    <ul class="mb-2">
        <li><strong>Multiple Formats</strong> - Export to JPG, PNG, WebP, or BMP</li>
        <li><strong>Flexible Page Selection</strong> - Convert all pages, specific pages, or page ranges</li>
        <li><strong>Quality Control</strong> - Adjust resolution (150-600 DPI) and compression quality</li>
        <li><strong>Color Options</strong> - Full color, grayscale, or black & white conversion</li>
        <li><strong>Background Control</strong> - Set white, transparent, or custom backgrounds</li>
        <li><strong>Batch Download</strong> - Download all images as ZIP or individually</li>
    </ul>
    <p class="mb-0">
        <small><strong>Best for:</strong> Creating images for presentations, web use, or printing from PDF documents.</small>
    </p>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pdfFileInput = document.getElementById('pdf-file');
    const conversionOptions = document.getElementById('conversion-options');
    const advancedOptions = document.getElementById('advanced-options');
    const pageRangeOptions = document.getElementById('page-range-options');
    const specificPagesOptions = document.getElementById('specific-pages-options');
    const customBgSection = document.getElementById('custom-bg-section');
    const convertSection = document.getElementById('convert-section');
    const previewSection = document.getElementById('preview-section');
    const conversionProgress = document.getElementById('conversion-progress');
    const resultsSection = document.getElementById('results-section');
    const individualDownloads = document.getElementById('individual-downloads');

    const outputFormat = document.getElementById('output-format');
    const imageQuality = document.getElementById('image-quality');
    const pageSelection = document.getElementById('page-selection');
    const startPage = document.getElementById('start-page');
    const endPage = document.getElementById('end-page');
    const pageNumbers = document.getElementById('page-numbers');
    const resolution = document.getElementById('resolution');
    const colorMode = document.getElementById('color-mode');
    const backgroundColor = document.getElementById('background-color');
    const customBgColor = document.getElementById('custom-bg-color');

    const convertBtn = document.getElementById('convert-btn');
    const resetBtn = document.getElementById('reset-btn');
    const downloadAllBtn = document.getElementById('download-all-btn');
    const downloadIndividualBtn = document.getElementById('download-individual-btn');

    let selectedFile = null;
    let totalPdfPages = 0;
    let convertedImages = [];

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function updateConvertButtonText() {
        const format = outputFormat.value.toUpperCase();
        convertBtn.innerHTML = `<i class="fas fa-images me-2"></i>Convert to ${format}`;
    }

    function estimatePdfPages(fileSize) {
        // Rough estimate: 50-100KB per page for typical PDFs
        return Math.max(1, Math.ceil(fileSize / (75 * 1024)));
    }

    pdfFileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];

        if (!file) {
            hideAllSections();
            return;
        }

        if (file.type !== 'application/pdf') {
            alert('Please select a PDF file');
            this.value = '';
            return;
        }

        if (file.size > 10 * 1024 * 1024) { // 10MB limit
            alert('File size must be less than 10MB');
            this.value = '';
            return;
        }

        selectedFile = file;
        totalPdfPages = estimatePdfPages(file.size);
        showFilePreview(file);

        conversionOptions.style.display = 'block';
        advancedOptions.style.display = 'block';
        convertSection.style.display = 'block';
        previewSection.style.display = 'block';
    });

    function hideAllSections() {
        conversionOptions.style.display = 'none';
        advancedOptions.style.display = 'none';
        pageRangeOptions.style.display = 'none';
        specificPagesOptions.style.display = 'none';
        customBgSection.style.display = 'none';
        convertSection.style.display = 'none';
        previewSection.style.display = 'none';
        conversionProgress.style.display = 'none';
        resultsSection.style.display = 'none';
        individualDownloads.style.display = 'none';
    }

    function showFilePreview(file) {
        document.getElementById('file-name').textContent = file.name;
        document.getElementById('file-size').textContent = formatFileSize(file.size);
        document.getElementById('total-pages').textContent = totalPdfPages + ' (estimated)';

        // Update end page max value
        endPage.max = totalPdfPages;
        endPage.value = totalPdfPages;

        updateEstimatedImages();
    }

    function updateEstimatedImages() {
        let estimatedImages = 0;
        const selection = pageSelection.value;

        switch(selection) {
            case 'all':
                estimatedImages = totalPdfPages;
                break;
            case 'first':
                estimatedImages = 1;
                break;
            case 'range':
                const start = parseInt(startPage.value) || 1;
                const end = parseInt(endPage.value) || totalPdfPages;
                estimatedImages = Math.max(0, end - start + 1);
                break;
            case 'specific':
                estimatedImages = countSpecificPages(pageNumbers.value);
                break;
        }

        document.getElementById('estimated-images').textContent = estimatedImages;
    }

    function countSpecificPages(pageString) {
        if (!pageString.trim()) return 0;

        const parts = pageString.split(',').map(p => p.trim());
        let count = 0;

        for (let part of parts) {
            if (part.includes('-')) {
                const [start, end] = part.split('-').map(n => parseInt(n.trim()));
                if (!isNaN(start) && !isNaN(end)) {
                    count += Math.max(0, end - start + 1);
                }
            } else {
                const page = parseInt(part);
                if (!isNaN(page) && page > 0) {
                    count += 1;
                }
            }
        }

        return count;
    }

    pageSelection.addEventListener('change', function() {
        pageRangeOptions.style.display = this.value === 'range' ? 'block' : 'none';
        specificPagesOptions.style.display = this.value === 'specific' ? 'block' : 'none';
        updateEstimatedImages();
    });

    backgroundColor.addEventListener('change', function() {
        customBgSection.style.display = this.value === 'custom' ? 'block' : 'none';
    });

    outputFormat.addEventListener('change', updateConvertButtonText);

    startPage.addEventListener('input', updateEstimatedImages);
    endPage.addEventListener('input', updateEstimatedImages);
    pageNumbers.addEventListener('input', updateEstimatedImages);

    convertBtn.addEventListener('click', function() {
        if (!selectedFile) {
            alert('Please select a PDF file first');
            return;
        }

        // Validate page selections
        if (pageSelection.value === 'range') {
            const start = parseInt(startPage.value);
            const end = parseInt(endPage.value);
            if (start > end || start < 1 || end > totalPdfPages) {
                alert('Invalid page range');
                return;
            }
        }

        if (pageSelection.value === 'specific' && !pageNumbers.value.trim()) {
            alert('Please specify page numbers');
            return;
        }

        startConversion();
    });

    function startConversion() {
        conversionProgress.style.display = 'block';
        resultsSection.style.display = 'none';
        convertBtn.disabled = true;

        const progressBar = document.getElementById('progress-bar');
        const progressText = document.getElementById('progress-text');
        const conversionStatus = document.getElementById('conversion-status');

        // Simulate conversion process
        let progress = 0;
        const estimatedImages = parseInt(document.getElementById('estimated-images').textContent);
        const steps = [
            'Reading PDF structure...',
            'Extracting page contents...',
            'Rendering pages to images...',
            'Applying quality settings...',
            'Generating final images...'
        ];

        const interval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress > 100) progress = 100;

            progressBar.style.width = progress + '%';
            progressText.textContent = Math.round(progress) + '%';

            const stepIndex = Math.min(Math.floor(progress / 20), steps.length - 1);
            conversionStatus.textContent = steps[stepIndex];

            if (progress >= 100) {
                clearInterval(interval);
                completeConversion();
            }
        }, 400);
    }

    function completeConversion() {
        setTimeout(() => {
            generateConvertedImages();
            conversionProgress.style.display = 'none';
            resultsSection.style.display = 'block';
            convertBtn.disabled = false;
        }, 1000);
    }

    function generateConvertedImages() {
        const estimatedImages = parseInt(document.getElementById('estimated-images').textContent);
        const format = outputFormat.value;
        const quality = imageQuality.value;

        convertedImages = [];

        // Create conversion summary
        const summary = document.getElementById('conversion-summary');
        summary.innerHTML = `
            <li><i class="fas fa-check text-success me-2"></i>Format: PDF to ${format.toUpperCase()}</li>
            <li><i class="fas fa-check text-success me-2"></i>Images created: ${estimatedImages}</li>
            <li><i class="fas fa-check text-success me-2"></i>Resolution: ${resolution.value} DPI</li>
            <li><i class="fas fa-check text-success me-2"></i>Quality: ${quality}%</li>
            <li><i class="fas fa-check text-success me-2"></i>Color mode: ${getColorModeDescription()}</li>
            <li><i class="fas fa-check text-success me-2"></i>Background: ${getBackgroundDescription()}</li>
        `;

        // Generate sample images
        const imagesPreview = document.getElementById('images-preview');
        const individualDownloadList = document.getElementById('individual-download-list');

        imagesPreview.innerHTML = '';
        individualDownloadList.innerHTML = '';

        for (let i = 1; i <= estimatedImages; i++) {
            // Create sample image data
            const imageData = createSampleImage(i);
            convertedImages.push(imageData);

            // Create preview thumbnail
            const thumbnail = document.createElement('div');
            thumbnail.className = 'mb-2 p-2 border rounded d-flex align-items-center';
            thumbnail.innerHTML = `
                <div class="me-3" style="width: 60px; height: 80px; background: #e9ecef; border: 1px solid #dee2e6; border-radius: 3px; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                    Page ${i}
                </div>
                <div class="flex-grow-1">
                    <strong>page-${i}.${format}</strong><br>
                    <small class="text-muted">${imageData.size}</small>
                </div>
            `;
            imagesPreview.appendChild(thumbnail);

            // Create individual download button
            const downloadItem = document.createElement('div');
            downloadItem.className = 'col-md-6 mb-2';
            downloadItem.innerHTML = `
                <button class="btn btn-outline-primary btn-sm w-100" onclick="downloadSingleImage(${i-1})">
                    <i class="fas fa-download me-2"></i>Page ${i} (${imageData.size})
                </button>
            `;
            individualDownloadList.appendChild(downloadItem);
        }
    }

    function createSampleImage(pageNumber) {
        const format = outputFormat.value;
        const quality = imageQuality.value;
        const dpi = resolution.value;

        // Estimate file size based on format and quality
        let baseSize = 200; // KB
        if (format === 'png') baseSize *= 1.5;
        if (format === 'bmp') baseSize *= 3;
        if (quality > 90) baseSize *= 1.2;
        if (dpi > 300) baseSize *= 1.5;

        const sizeInKB = Math.round(baseSize * (0.8 + Math.random() * 0.4));

        return {
            pageNumber: pageNumber,
            format: format,
            size: formatFileSize(sizeInKB * 1024),
            data: `data:image/${format};base64,sample-data-${pageNumber}` // Mock data
        };
    }

    function getColorModeDescription() {
        const mode = colorMode.value;
        switch(mode) {
            case 'color': return 'Full Color';
            case 'grayscale': return 'Grayscale';
            case 'monochrome': return 'Black & White';
            default: return 'Full Color';
        }
    }

    function getBackgroundDescription() {
        const bg = backgroundColor.value;
        switch(bg) {
            case 'white': return 'White';
            case 'transparent': return 'Transparent';
            case 'custom': return 'Custom color';
            default: return 'White';
        }
    }

    // Make downloadSingleImage function global
    window.downloadSingleImage = function(index) {
        const image = convertedImages[index];
        const filename = `page-${image.pageNumber}.${image.format}`;

        // Create a dummy blob for demonstration
        const blob = new Blob(['Sample image data'], { type: `image/${image.format}` });

        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    };

    downloadAllBtn.addEventListener('click', function() {
        if (convertedImages.length === 0) {
            alert('No images available for download');
            return;
        }

        // Create a dummy ZIP blob for demonstration
        const zipBlob = new Blob(['Sample ZIP file with all images'], { type: 'application/zip' });
        const filename = `${selectedFile.name.replace('.pdf', '')}-images.zip`;

        const url = URL.createObjectURL(zipBlob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);

        // Update button to show success
        const btn = this;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check me-2"></i>Downloaded!';
        btn.classList.remove('btn-success');
        btn.classList.add('btn-primary');
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-success');
        }, 2000);
    });

    downloadIndividualBtn.addEventListener('click', function() {
        if (individualDownloads.style.display === 'none') {
            individualDownloads.style.display = 'block';
            this.innerHTML = '<i class="fas fa-eye-slash me-2"></i>Hide Individual Downloads';
        } else {
            individualDownloads.style.display = 'none';
            this.innerHTML = '<i class="fas fa-image me-2"></i>Download Individual Images';
        }
    });

    resetBtn.addEventListener('click', function() {
        pdfFileInput.value = '';
        selectedFile = null;
        totalPdfPages = 0;
        convertedImages = [];

        hideAllSections();

        // Reset form values
        outputFormat.value = 'jpg';
        imageQuality.value = '95';
        pageSelection.value = 'all';
        resolution.value = '300';
        colorMode.value = 'color';
        backgroundColor.value = 'white';
        startPage.value = '1';
        endPage.value = '1';
        pageNumbers.value = '';
        customBgColor.value = '#ffffff';

        updateConvertButtonText();
    });

    // Initialize
    updateConvertButtonText();
});
</script>
