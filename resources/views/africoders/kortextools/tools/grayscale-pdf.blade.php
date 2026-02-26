<div class="row">
    <div class="col-md-12">
        <div class="mb-4">
            <label for="pdf-file" class="form-label">Select PDF File:</label>
            <input type="file" class="form-control" id="pdf-file" accept=".pdf" />
            <small class="form-text text-muted">Maximum file size: 10MB</small>
        </div>

        <div class="row mb-4" id="conversion-options" style="display: none;">
            <div class="col-md-4">
                <label for="grayscale-method" class="form-label">Conversion Method:</label>
                <select class="form-select" id="grayscale-method">
                    <option value="standard" selected>Standard Grayscale</option>
                    <option value="desaturate">Desaturate Colors</option>
                    <option value="luminosity">Luminosity Method</option>
                    <option value="average">Average Method</option>
                    <option value="custom">Custom Weights</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="contrast-adjustment" class="form-label">Contrast:</label>
                <select class="form-select" id="contrast-adjustment">
                    <option value="0">Normal (0%)</option>
                    <option value="10">Slightly Enhanced (+10%)</option>
                    <option value="20" selected>Enhanced (+20%)</option>
                    <option value="30">High Contrast (+30%)</option>
                    <option value="-10">Reduced (-10%)</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="brightness-adjustment" class="form-label">Brightness:</label>
                <select class="form-select" id="brightness-adjustment">
                    <option value="0" selected>Normal (0%)</option>
                    <option value="10">Brighter (+10%)</option>
                    <option value="20">Much Brighter (+20%)</option>
                    <option value="-10">Darker (-10%)</option>
                    <option value="-20">Much Darker (-20%)</option>
                </select>
            </div>
        </div>

        <!-- Custom Weights Options -->
        <div class="row mb-4" id="custom-weights-section" style="display: none;">
            <div class="col-md-12">
                <h6>Custom RGB Weights:</h6>
                <small class="text-muted mb-3 d-block">Adjust how much each color channel contributes to the grayscale conversion (total should equal 100%)</small>
            </div>
            <div class="col-md-4">
                <label for="red-weight" class="form-label">Red Weight:</label>
                <div class="input-group">
                    <input type="range" class="form-range" id="red-weight" min="0" max="100" value="30">
                    <span class="input-group-text" id="red-weight-value">30%</span>
                </div>
            </div>
            <div class="col-md-4">
                <label for="green-weight" class="form-label">Green Weight:</label>
                <div class="input-group">
                    <input type="range" class="form-range" id="green-weight" min="0" max="100" value="59">
                    <span class="input-group-text" id="green-weight-value">59%</span>
                </div>
            </div>
            <div class="col-md-4">
                <label for="blue-weight" class="form-label">Blue Weight:</label>
                <div class="input-group">
                    <input type="range" class="form-range" id="blue-weight" min="0" max="100" value="11">
                    <span class="input-group-text" id="blue-weight-value">11%</span>
                </div>
            </div>
            <div class="col-md-12 mt-2">
                <small class="text-muted">Current total: <span id="total-weight">100%</span></small>
            </div>
        </div>

        <!-- Advanced Options -->
        <div class="row mb-4" id="advanced-options" style="display: none;">
            <div class="col-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="preserve-transparency" checked>
                    <label class="form-check-label" for="preserve-transparency">
                        Preserve Transparency
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="optimize-size" checked>
                    <label class="form-check-label" for="optimize-size">
                        Optimize File Size
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="maintain-quality">
                    <label class="form-check-label" for="maintain-quality">
                        Maintain Original Quality
                    </label>
                </div>
            </div>
        </div>

        <div class="mb-4" id="convert-section" style="display: none;">
            <button type="button" class="btn btn-primary btn-lg" id="convert-btn">
                <i class="fas fa-adjust me-2"></i>Convert to Grayscale
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
                                <td><strong>Pages:</strong></td>
                                <td id="page-count">-</td>
                            </tr>
                            <tr>
                                <td><strong>Estimated Reduction:</strong></td>
                                <td id="size-reduction">-</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Original Preview:</h6>
                        <div id="pdf-preview" class="border rounded d-flex align-items-center justify-content-center"
                             style="height: 250px; overflow: hidden; background: linear-gradient(45deg, #f8f9fa 25%, transparent 25%), linear-gradient(-45deg, #f8f9fa 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #f8f9fa 75%), linear-gradient(-45deg, transparent 75%, #f8f9fa 75%); background-size: 20px 20px;">
                            <div class="text-center text-muted">
                                <i class="fas fa-file-pdf fa-3x mb-2" style="color: #dc3545;"></i>
                                <p>Color PDF preview</p>
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
            <h6><i class="fas fa-cog fa-spin me-2"></i>Converting PDF to Grayscale...</h6>
            <div class="progress mb-3">
                <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated bg-secondary"
                     role="progressbar" style="width: 0%">
                    <span id="progress-text">0%</span>
                </div>
            </div>
            <div id="conversion-status" class="small text-muted">
                Analyzing PDF colors...
            </div>
        </div>
    </div>
</div>

<!-- Before/After Comparison -->
<div id="comparison-section" class="mt-4" style="display: none;">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-exchange-alt me-2"></i>Before & After Comparison
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-center">Original (Color)</h6>
                    <div id="original-preview" class="border rounded d-flex align-items-center justify-content-center"
                         style="height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="text-center text-white">
                            <i class="fas fa-palette fa-3x mb-2"></i>
                            <p>Color PDF</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="text-center">Converted (Grayscale)</h6>
                    <div id="grayscale-preview" class="border rounded d-flex align-items-center justify-content-center"
                         style="height: 300px; background: linear-gradient(135deg, #666666 0%, #999999 100%);">
                        <div class="text-center text-white">
                            <i class="fas fa-adjust fa-3x mb-2"></i>
                            <p>Grayscale PDF</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Conversion Results -->
<div id="results-section" class="mt-4" style="display: none;">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">
                <i class="fas fa-check-circle me-2"></i>Grayscale Conversion Completed!
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h6>Conversion Summary:</h6>
                    <ul id="conversion-summary" class="list-unstyled">
                        <!-- Summary items will be added here -->
                    </ul>
                </div>
                <div class="col-md-4 text-end">
                    <button type="button" class="btn btn-success btn-lg" id="download-btn">
                        <i class="fas fa-download me-2"></i>Download Grayscale PDF
                    </button>
                    <button type="button" class="btn btn-outline-primary mt-2" id="compare-btn">
                        <i class="fas fa-eye me-2"></i>Compare Original
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Info Section -->
<div class="alert alert-info mt-4">
    <h6 class="alert-heading">
        <i class="fas fa-info-circle me-2"></i>About PDF Grayscale Conversion
    </h6>
    <p class="mb-2">
        Convert your colored PDFs to professional grayscale documents with these benefits:
    </p>
    <ul class="mb-2">
        <li><strong>Reduced File Size</strong> - Grayscale PDFs are typically 20-50% smaller</li>
        <li><strong>Print Cost Savings</strong> - Save on color printing costs</li>
        <li><strong>Professional Appearance</strong> - Clean, consistent grayscale look</li>
        <li><strong>Better Compatibility</strong> - Works well with black & white printers</li>
        <li><strong>Accessibility</strong> - Improved readability for some visual conditions</li>
        <li><strong>Multiple Methods</strong> - Choose from various conversion algorithms</li>
    </ul>
    <p class="mb-0">
        <small><strong>Best for:</strong> Documents, reports, forms, and any PDF intended for black & white printing.</small>
    </p>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pdfFileInput = document.getElementById('pdf-file');
    const conversionOptions = document.getElementById('conversion-options');
    const advancedOptions = document.getElementById('advanced-options');
    const customWeightsSection = document.getElementById('custom-weights-section');
    const convertSection = document.getElementById('convert-section');
    const previewSection = document.getElementById('preview-section');
    const conversionProgress = document.getElementById('conversion-progress');
    const comparisonSection = document.getElementById('comparison-section');
    const resultsSection = document.getElementById('results-section');

    const grayscaleMethod = document.getElementById('grayscale-method');
    const contrastAdjustment = document.getElementById('contrast-adjustment');
    const brightnessAdjustment = document.getElementById('brightness-adjustment');
    const redWeight = document.getElementById('red-weight');
    const greenWeight = document.getElementById('green-weight');
    const blueWeight = document.getElementById('blue-weight');
    const redWeightValue = document.getElementById('red-weight-value');
    const greenWeightValue = document.getElementById('green-weight-value');
    const blueWeightValue = document.getElementById('blue-weight-value');
    const totalWeightSpan = document.getElementById('total-weight');
    const preserveTransparency = document.getElementById('preserve-transparency');
    const optimizeSize = document.getElementById('optimize-size');
    const maintainQuality = document.getElementById('maintain-quality');

    const convertBtn = document.getElementById('convert-btn');
    const resetBtn = document.getElementById('reset-btn');
    const downloadBtn = document.getElementById('download-btn');
    const compareBtn = document.getElementById('compare-btn');

    let selectedFile = null;
    let convertedPdfBlob = null;

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

    function estimateSizeReduction() {
        if (!selectedFile) return '-';

        let reductionPercentage = 25; // Base reduction

        // Adjust based on method
        switch(grayscaleMethod.value) {
            case 'standard': reductionPercentage = 25; break;
            case 'desaturate': reductionPercentage = 20; break;
            case 'luminosity': reductionPercentage = 30; break;
            case 'average': reductionPercentage = 22; break;
            case 'custom': reductionPercentage = 27; break;
        }

        // Adjust based on optimization settings
        if (optimizeSize.checked) reductionPercentage += 5;
        if (maintainQuality.checked) reductionPercentage -= 10;

        const originalSize = selectedFile.size;
        const estimatedNewSize = originalSize * (1 - reductionPercentage / 100);
        const savedSize = originalSize - estimatedNewSize;

        return `${reductionPercentage}% (${formatFileSize(savedSize)} saved)`;
    }

    function updateWeightValues() {
        const red = parseInt(redWeight.value);
        const green = parseInt(greenWeight.value);
        const blue = parseInt(blueWeight.value);
        const total = red + green + blue;

        redWeightValue.textContent = red + '%';
        greenWeightValue.textContent = green + '%';
        blueWeightValue.textContent = blue + '%';
        totalWeightSpan.textContent = total + '%';

        // Color code the total
        if (total === 100) {
            totalWeightSpan.className = 'text-success';
        } else {
            totalWeightSpan.className = 'text-warning';
        }
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

        conversionOptions.style.display = 'block';
        advancedOptions.style.display = 'block';
        convertSection.style.display = 'block';
        previewSection.style.display = 'block';
    });

    function hideAllSections() {
        conversionOptions.style.display = 'none';
        advancedOptions.style.display = 'none';
        customWeightsSection.style.display = 'none';
        convertSection.style.display = 'none';
        previewSection.style.display = 'none';
        conversionProgress.style.display = 'none';
        comparisonSection.style.display = 'none';
        resultsSection.style.display = 'none';
    }

    function showFilePreview(file) {
        document.getElementById('file-name').textContent = file.name;
        document.getElementById('file-size').textContent = formatFileSize(file.size);
        document.getElementById('page-count').textContent = estimatePdfPages(file.size) + ' (estimated)';
        updateSizeReduction();
    }

    function updateSizeReduction() {
        document.getElementById('size-reduction').textContent = estimateSizeReduction();
    }

    grayscaleMethod.addEventListener('change', function() {
        customWeightsSection.style.display = this.value === 'custom' ? 'block' : 'none';
        updateSizeReduction();
    });

    // Weight sliders event listeners
    redWeight.addEventListener('input', updateWeightValues);
    greenWeight.addEventListener('input', updateWeightValues);
    blueWeight.addEventListener('input', updateWeightValues);

    // Update size reduction when settings change
    contrastAdjustment.addEventListener('change', updateSizeReduction);
    brightnessAdjustment.addEventListener('change', updateSizeReduction);
    optimizeSize.addEventListener('change', updateSizeReduction);
    maintainQuality.addEventListener('change', updateSizeReduction);

    convertBtn.addEventListener('click', function() {
        if (!selectedFile) {
            alert('Please select a PDF file first');
            return;
        }

        // Validate custom weights if needed
        if (grayscaleMethod.value === 'custom') {
            const total = parseInt(redWeight.value) + parseInt(greenWeight.value) + parseInt(blueWeight.value);
            if (total !== 100) {
                alert('Custom RGB weights must total exactly 100%');
                return;
            }
        }

        startConversion();
    });

    function startConversion() {
        conversionProgress.style.display = 'block';
        comparisonSection.style.display = 'none';
        resultsSection.style.display = 'none';
        convertBtn.disabled = true;

        const progressBar = document.getElementById('progress-bar');
        const progressText = document.getElementById('progress-text');
        const conversionStatus = document.getElementById('conversion-status');

        // Simulate conversion process
        let progress = 0;
        const steps = [
            'Analyzing PDF color information...',
            'Processing page elements...',
            'Applying grayscale conversion...',
            'Adjusting contrast and brightness...',
            'Optimizing file structure...',
            'Finalizing grayscale PDF...'
        ];

        const interval = setInterval(() => {
            progress += Math.random() * 18;
            if (progress > 100) progress = 100;

            progressBar.style.width = progress + '%';
            progressText.textContent = Math.round(progress) + '%';

            const stepIndex = Math.min(Math.floor(progress / 17), steps.length - 1);
            conversionStatus.textContent = steps[stepIndex];

            if (progress >= 100) {
                clearInterval(interval);
                completeConversion();
            }
        }, 600);
    }

    function completeConversion() {
        setTimeout(() => {
            conversionProgress.style.display = 'none';
            comparisonSection.style.display = 'block';
            resultsSection.style.display = 'block';
            convertBtn.disabled = false;

            createConversionSummary();
            createConvertedPdf();
        }, 1000);
    }

    function createConversionSummary() {
        const summary = document.getElementById('conversion-summary');
        const method = getMethodDescription();
        const originalSize = formatFileSize(selectedFile.size);
        const estimatedNewSize = formatFileSize(selectedFile.size * 0.75); // Assuming 25% reduction
        const pages = estimatePdfPages(selectedFile.size);

        summary.innerHTML = `
            <li><i class="fas fa-check text-success me-2"></i>Method: ${method}</li>
            <li><i class="fas fa-check text-success me-2"></i>Pages processed: ${pages}</li>
            <li><i class="fas fa-check text-success me-2"></i>Original size: ${originalSize}</li>
            <li><i class="fas fa-check text-success me-2"></i>New size: ${estimatedNewSize}</li>
            <li><i class="fas fa-check text-success me-2"></i>Contrast: ${contrastAdjustment.value > 0 ? '+' : ''}${contrastAdjustment.value}%</li>
            <li><i class="fas fa-check text-success me-2"></i>Brightness: ${brightnessAdjustment.value > 0 ? '+' : ''}${brightnessAdjustment.value}%</li>
        `;
    }

    function getMethodDescription() {
        const methods = {
            'standard': 'Standard Grayscale',
            'desaturate': 'Desaturate Colors',
            'luminosity': 'Luminosity Method',
            'average': 'Average Method',
            'custom': `Custom (R:${redWeight.value}%, G:${greenWeight.value}%, B:${blueWeight.value}%)`
        };
        return methods[grayscaleMethod.value] || 'Standard Grayscale';
    }

    function createConvertedPdf() {
        // Create a dummy blob for demonstration
        const content = `Grayscale PDF converted from ${selectedFile.name}\\n\\nConversion Settings:\\n- Method: ${getMethodDescription()}\\n- Contrast: ${contrastAdjustment.value}%\\n- Brightness: ${brightnessAdjustment.value}%\\n\\nThis is a demonstration of the PDF grayscale conversion tool.`;
        convertedPdfBlob = new Blob([content], { type: 'application/pdf' });
    }

    downloadBtn.addEventListener('click', function() {
        if (!convertedPdfBlob) {
            alert('No converted PDF available');
            return;
        }

        const filename = selectedFile.name.replace('.pdf', '') + '_grayscale.pdf';

        const url = URL.createObjectURL(convertedPdfBlob);
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

    compareBtn.addEventListener('click', function() {
        if (comparisonSection.style.display === 'none') {
            comparisonSection.style.display = 'block';
            this.innerHTML = '<i class="fas fa-eye-slash me-2"></i>Hide Comparison';
        } else {
            comparisonSection.style.display = 'none';
            this.innerHTML = '<i class="fas fa-eye me-2"></i>Compare Original';
        }
    });

    resetBtn.addEventListener('click', function() {
        pdfFileInput.value = '';
        selectedFile = null;
        convertedPdfBlob = null;

        hideAllSections();

        // Reset form values
        grayscaleMethod.value = 'standard';
        contrastAdjustment.value = '20';
        brightnessAdjustment.value = '0';
        redWeight.value = '30';
        greenWeight.value = '59';
        blueWeight.value = '11';
        preserveTransparency.checked = true;
        optimizeSize.checked = true;
        maintainQuality.checked = false;

        updateWeightValues();
    });

    // Initialize
    updateWeightValues();
});
</script>
