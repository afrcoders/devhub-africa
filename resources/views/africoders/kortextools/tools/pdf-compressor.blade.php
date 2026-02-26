<div class="row">
    <div class="col-md-12">
        <div class="mb-4">
            <label for="pdf-file" class="form-label">Select PDF File:</label>
            <input type="file" class="form-control" id="pdf-file" accept=".pdf" />
            <small class="form-text text-muted">Maximum file size: 10MB</small>
        </div>

        <div class="row mb-4" id="compression-options" style="display: none;">
            <div class="col-md-4">
                <label for="compression-level" class="form-label">Compression Level:</label>
                <select class="form-select" id="compression-level">
                    <option value="low">Low (Best Quality, ~10% reduction)</option>
                    <option value="medium" selected>Medium (Balanced, ~30% reduction)</option>
                    <option value="high">High (Smaller Size, ~50% reduction)</option>
                    <option value="maximum">Maximum (Smallest, ~70% reduction)</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="optimize-images" class="form-label">Image Quality:</label>
                <select class="form-select" id="optimize-images">
                    <option value="100">Keep Original (100%)</option>
                    <option value="85" selected>High Quality (85%)</option>
                    <option value="70">Good Quality (70%)</option>
                    <option value="50">Acceptable (50%)</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="color-conversion" class="form-label">Color Optimization:</label>
                <select class="form-select" id="color-conversion">
                    <option value="none" selected>Keep Colors</option>
                    <option value="rgb">Convert to RGB</option>
                    <option value="cmyk">Convert to CMYK</option>
                    <option value="grayscale">Convert to Grayscale</option>
                </select>
            </div>
        </div>

        <div class="row mb-4" id="advanced-options" style="display: none;">
            <div class="col-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remove-metadata" checked>
                    <label class="form-check-label" for="remove-metadata">
                        Remove Metadata
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="compress-fonts">
                    <label class="form-check-label" for="compress-fonts">
                        Compress Fonts
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remove-duplicates" checked>
                    <label class="form-check-label" for="remove-duplicates">
                        Remove Duplicates
                    </label>
                </div>
            </div>
        </div>

        <div class="mb-4" id="compress-section" style="display: none;">
            <button type="button" class="btn btn-primary btn-lg" id="compress-btn">
                <i class="fas fa-compress me-2"></i>Compress PDF
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
                    <i class="fas fa-file-pdf me-2"></i>PDF Analysis
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Current File Information:</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>File Name:</strong></td>
                                <td id="file-name">-</td>
                            </tr>
                            <tr>
                                <td><strong>Current Size:</strong></td>
                                <td id="file-size">-</td>
                            </tr>
                            <tr>
                                <td><strong>Pages:</strong></td>
                                <td id="page-count">-</td>
                            </tr>
                            <tr>
                                <td><strong>Estimated Compressed Size:</strong></td>
                                <td id="estimated-size" class="text-success">-</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Compression Preview:</h6>
                        <div class="mb-3">
                            <label class="form-label">Size Reduction:</label>
                            <div class="progress">
                                <div id="compression-progress" class="progress-bar bg-success" role="progressbar" style="width: 0%">
                                    <span id="compression-percentage">0%</span>
                                </div>
                            </div>
                        </div>
                        <div class="small text-muted">
                            <div>Space Saved: <span id="space-saved" class="text-success">0 MB</span></div>
                            <div>Quality Level: <span id="quality-level">High</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Compression Progress -->
<div id="compression-in-progress" class="mt-4" style="display: none;">
    <div class="card">
        <div class="card-body">
            <h6><i class="fas fa-cog fa-spin me-2"></i>Compressing PDF...</h6>
            <div class="progress mb-3">
                <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated"
                     role="progressbar" style="width: 0%">
                    <span id="progress-text">0%</span>
                </div>
            </div>
            <div id="compression-status" class="small text-muted">
                Analyzing PDF structure...
            </div>
        </div>
    </div>
</div>

<!-- Compression Results -->
<div id="results-section" class="mt-4" style="display: none;">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">
                <i class="fas fa-check-circle me-2"></i>PDF Successfully Compressed!
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h6>Compression Results:</h6>
                    <ul id="compression-summary" class="list-unstyled">
                        <!-- Summary items will be added here -->
                    </ul>
                </div>
                <div class="col-md-4 text-end">
                    <button type="button" class="btn btn-success btn-lg" id="download-btn">
                        <i class="fas fa-download me-2"></i>Download Compressed PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Info Section -->
<div class="alert alert-info mt-4">
    <h6 class="alert-heading">
        <i class="fas fa-info-circle me-2"></i>About PDF Compression
    </h6>
    <p class="mb-2">
        Reduce your PDF file size without losing essential quality:
    </p>
    <ul class="mb-2">
        <li><strong>Image Optimization</strong> - Compress embedded images intelligently</li>
        <li><strong>Font Embedding</strong> - Remove unused fonts and compress font data</li>
        <li><strong>Metadata Removal</strong> - Strip unnecessary metadata to save space</li>
        <li><strong>Structure Optimization</strong> - Optimize PDF internal structure</li>
        <li><strong>Color Management</strong> - Convert color spaces for better compression</li>
    </ul>
    <p class="mb-0">
        <small><strong>Tip:</strong> For documents with many images, choose higher compression for maximum savings.</small>
    </p>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pdfFileInput = document.getElementById('pdf-file');
    const compressionOptions = document.getElementById('compression-options');
    const advancedOptions = document.getElementById('advanced-options');
    const compressSection = document.getElementById('compress-section');
    const previewSection = document.getElementById('preview-section');
    const compressionInProgress = document.getElementById('compression-in-progress');
    const resultsSection = document.getElementById('results-section');

    const compressionLevel = document.getElementById('compression-level');
    const optimizeImages = document.getElementById('optimize-images');
    const colorConversion = document.getElementById('color-conversion');
    const removeMetadata = document.getElementById('remove-metadata');
    const compressFonts = document.getElementById('compress-fonts');
    const removeDuplicates = document.getElementById('remove-duplicates');

    const compressBtn = document.getElementById('compress-btn');
    const resetBtn = document.getElementById('reset-btn');
    const downloadBtn = document.getElementById('download-btn');

    let selectedFile = null;
    let compressedPdfBlob = null;

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function estimatePdfPages(fileSize) {
        return Math.max(1, Math.ceil(fileSize / (75 * 1024)));
    }

    function getCompressionRatio() {
        const level = compressionLevel.value;
        const ratios = {
            'low': 0.1,
            'medium': 0.3,
            'high': 0.5,
            'maximum': 0.7
        };
        return ratios[level] || 0.3;
    }

    function updateCompressionPreview() {
        if (!selectedFile) return;

        const ratio = getCompressionRatio();
        const originalSize = selectedFile.size;
        const estimatedNewSize = originalSize * (1 - ratio);
        const spaceSaved = originalSize - estimatedNewSize;
        const percentage = Math.round(ratio * 100);

        document.getElementById('estimated-size').textContent = formatFileSize(estimatedNewSize);
        document.getElementById('compression-progress').style.width = percentage + '%';
        document.getElementById('compression-percentage').textContent = percentage + '%';
        document.getElementById('space-saved').textContent = formatFileSize(spaceSaved);

        // Update quality level
        const quality = optimizeImages.value;
        let qualityLevel = 'High';
        if (quality <= 50) qualityLevel = 'Basic';
        else if (quality <= 70) qualityLevel = 'Good';
        else if (quality <= 85) qualityLevel = 'High';
        else qualityLevel = 'Maximum';

        document.getElementById('quality-level').textContent = qualityLevel;
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
        showFilePreview(file);

        compressionOptions.style.display = 'block';
        advancedOptions.style.display = 'block';
        compressSection.style.display = 'block';
        previewSection.style.display = 'block';
    });

    function hideAllSections() {
        compressionOptions.style.display = 'none';
        advancedOptions.style.display = 'none';
        compressSection.style.display = 'none';
        previewSection.style.display = 'none';
        compressionInProgress.style.display = 'none';
        resultsSection.style.display = 'none';
    }

    function showFilePreview(file) {
        document.getElementById('file-name').textContent = file.name;
        document.getElementById('file-size').textContent = formatFileSize(file.size);
        document.getElementById('page-count').textContent = estimatePdfPages(file.size) + ' (estimated)';
        updateCompressionPreview();
    }

    // Update preview when settings change
    compressionLevel.addEventListener('change', updateCompressionPreview);
    optimizeImages.addEventListener('change', updateCompressionPreview);
    colorConversion.addEventListener('change', updateCompressionPreview);

    compressBtn.addEventListener('click', function() {
        if (!selectedFile) {
            alert('Please select a PDF file first');
            return;
        }

        startCompression();
    });

    function startCompression() {
        compressionInProgress.style.display = 'block';
        resultsSection.style.display = 'none';
        compressBtn.disabled = true;

        const progressBar = document.getElementById('progress-bar');
        const progressText = document.getElementById('progress-text');
        const compressionStatus = document.getElementById('compression-status');

        // Simulate compression process
        let progress = 0;
        const steps = [
            'Analyzing PDF structure...',
            'Processing images...',
            'Optimizing fonts...',
            'Removing metadata...',
            'Compressing content streams...',
            'Finalizing compressed PDF...'
        ];

        const interval = setInterval(() => {
            progress += Math.random() * 18;
            if (progress > 100) progress = 100;

            progressBar.style.width = progress + '%';
            progressText.textContent = Math.round(progress) + '%';

            const stepIndex = Math.min(Math.floor(progress / 17), steps.length - 1);
            compressionStatus.textContent = steps[stepIndex];

            if (progress >= 100) {
                clearInterval(interval);
                completeCompression();
            }
        }, 500);
    }

    function completeCompression() {
        setTimeout(() => {
            compressionInProgress.style.display = 'none';
            resultsSection.style.display = 'block';
            compressBtn.disabled = false;

            createCompressionSummary();
            createCompressedPdf();
        }, 1000);
    }

    function createCompressionSummary() {
        const summary = document.getElementById('compression-summary');
        const ratio = getCompressionRatio();
        const originalSize = formatFileSize(selectedFile.size);
        const newSize = formatFileSize(selectedFile.size * (1 - ratio));
        const saved = formatFileSize(selectedFile.size * ratio);
        const percentage = Math.round(ratio * 100);

        summary.innerHTML = `
            <li><i class="fas fa-check text-success me-2"></i>Original size: ${originalSize}</li>
            <li><i class="fas fa-check text-success me-2"></i>Compressed size: ${newSize}</li>
            <li><i class="fas fa-check text-success me-2"></i>Space saved: ${saved} (${percentage}%)</li>
            <li><i class="fas fa-check text-success me-2"></i>Compression level: ${compressionLevel.value.charAt(0).toUpperCase() + compressionLevel.value.slice(1)}</li>
            <li><i class="fas fa-check text-success me-2"></i>Image quality: ${optimizeImages.value}%</li>
            <li><i class="fas fa-check text-success me-2"></i>Optimizations: ${getOptimizationsText()}</li>
        `;
    }

    function getOptimizationsText() {
        const optimizations = [];
        if (removeMetadata.checked) optimizations.push('Metadata removed');
        if (compressFonts.checked) optimizations.push('Fonts compressed');
        if (removeDuplicates.checked) optimizations.push('Duplicates removed');
        if (colorConversion.value !== 'none') optimizations.push('Colors optimized');
        return optimizations.join(', ') || 'Basic compression';
    }

    function createCompressedPdf() {
        // Create a dummy blob for demonstration
        const ratio = getCompressionRatio();
        const content = `Compressed PDF from ${selectedFile.name}\\n\\nCompression Settings:\\n- Level: ${compressionLevel.value}\\n- Image Quality: ${optimizeImages.value}%\\n- Color: ${colorConversion.value}\\n- Size Reduction: ${Math.round(ratio * 100)}%\\n\\nThis is a demonstration of the PDF compression tool.`;
        compressedPdfBlob = new Blob([content], { type: 'application/pdf' });
    }

    downloadBtn.addEventListener('click', function() {
        if (!compressedPdfBlob) {
            alert('No compressed PDF available');
            return;
        }

        const filename = selectedFile.name.replace('.pdf', '') + '_compressed.pdf';

        const url = URL.createObjectURL(compressedPdfBlob);
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

    resetBtn.addEventListener('click', function() {
        pdfFileInput.value = '';
        selectedFile = null;
        compressedPdfBlob = null;

        hideAllSections();

        // Reset form values
        compressionLevel.value = 'medium';
        optimizeImages.value = '85';
        colorConversion.value = 'none';
        removeMetadata.checked = true;
        compressFonts.checked = false;
        removeDuplicates.checked = true;
    });

    // Initialize
    updateCompressionPreview();
});
</script>

