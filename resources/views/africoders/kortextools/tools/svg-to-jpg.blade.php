<div class="row">
    <div class="col-md-12">
        <div class="mb-4">
            <label for="svg-file" class="form-label">Select SVG File:</label>
            <input type="file" class="form-control" id="svg-file" accept=".svg" />
            <small class="form-text text-muted">Maximum file size: 5MB</small>
        </div>

        <div class="row mb-4" id="conversion-options" style="display: none;">
            <div class="col-md-4">
                <label for="output-format" class="form-label">Output Format:</label>
                <select class="form-select" id="output-format">
                    <option value="jpg">JPEG (.jpg)</option>
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
                <label for="resize-option" class="form-label">Resize:</label>
                <select class="form-select" id="resize-option">
                    <option value="original">Keep Original Size</option>
                    <option value="custom">Custom Size</option>
                    <option value="preset">Preset Sizes</option>
                </select>
            </div>
        </div>

        <!-- Custom Size Options -->
        <div class="row mb-4" id="custom-size-options" style="display: none;">
            <div class="col-md-3">
                <label for="custom-width" class="form-label">Width (px):</label>
                <input type="number" class="form-control" id="custom-width" min="1" max="5000" value="800">
            </div>
            <div class="col-md-3">
                <label for="custom-height" class="form-label">Height (px):</label>
                <input type="number" class="form-control" id="custom-height" min="1" max="5000" value="600">
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="maintain-aspect" checked>
                    <label class="form-check-label" for="maintain-aspect">
                        Maintain aspect ratio
                    </label>
                </div>
            </div>
            <div class="col-md-3">
                <label for="background-color" class="form-label">Background:</label>
                <select class="form-select" id="background-color">
                    <option value="transparent">Transparent</option>
                    <option value="white">White</option>
                    <option value="black">Black</option>
                    <option value="custom">Custom Color</option>
                </select>
            </div>
        </div>

        <!-- Preset Size Options -->
        <div class="row mb-4" id="preset-size-options" style="display: none;">
            <div class="col-md-12">
                <label class="form-label">Choose preset size:</label>
                <div class="btn-group d-block" role="group">
                    <input type="radio" class="btn-check" name="preset-size" id="size-icon" value="32x32">
                    <label class="btn btn-outline-primary btn-sm" for="size-icon">Icon (32×32)</label>

                    <input type="radio" class="btn-check" name="preset-size" id="size-thumbnail" value="150x150">
                    <label class="btn btn-outline-primary btn-sm" for="size-thumbnail">Thumbnail (150×150)</label>

                    <input type="radio" class="btn-check" name="preset-size" id="size-small" value="400x300">
                    <label class="btn btn-outline-primary btn-sm" for="size-small">Small (400×300)</label>

                    <input type="radio" class="btn-check" name="preset-size" id="size-medium" value="800x600" checked>
                    <label class="btn btn-outline-primary btn-sm" for="size-medium">Medium (800×600)</label>

                    <input type="radio" class="btn-check" name="preset-size" id="size-large" value="1200x900">
                    <label class="btn btn-outline-primary btn-sm" for="size-large">Large (1200×900)</label>

                    <input type="radio" class="btn-check" name="preset-size" id="size-hd" value="1920x1080">
                    <label class="btn btn-outline-primary btn-sm" for="size-hd">HD (1920×1080)</label>
                </div>
            </div>
        </div>

        <!-- Color Picker -->
        <div class="row mb-4" id="color-picker-section" style="display: none;">
            <div class="col-md-6">
                <label for="custom-bg-color" class="form-label">Background Color:</label>
                <input type="color" class="form-control form-control-color" id="custom-bg-color" value="#ffffff">
            </div>
        </div>

        <div class="mb-4" id="convert-section" style="display: none;">
            <button type="button" class="btn btn-primary btn-lg" id="convert-btn">
                <i class="fas fa-exchange-alt me-2"></i>Convert to JPG
            </button>
            <button type="button" class="btn btn-outline-secondary ms-2" id="reset-btn">
                <i class="fas fa-undo me-2"></i>Reset
            </button>
        </div>
    </div>
</div>

<!-- SVG Preview -->
<div class="row" id="preview-section" style="display: none;">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-eye me-2"></i>SVG Preview
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
                                <td><strong>Dimensions:</strong></td>
                                <td id="svg-dimensions">-</td>
                            </tr>
                            <tr>
                                <td><strong>Elements:</strong></td>
                                <td id="svg-elements">-</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Preview:</h6>
                        <div id="svg-preview" class="border rounded d-flex align-items-center justify-content-center"
                             style="height: 300px; overflow: hidden; background: #f8f9fa;">
                            <!-- SVG preview will appear here -->
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
            <h6><i class="fas fa-cog fa-spin me-2"></i>Converting SVG to <span id="converting-format">JPG</span>...</h6>
            <div class="progress mb-3">
                <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated"
                     role="progressbar" style="width: 0%">
                    <span id="progress-text">0%</span>
                </div>
            </div>
            <div id="conversion-status" class="small text-muted">
                Preparing conversion...
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
                    <h6>Preview:</h6>
                    <div id="result-preview" class="border rounded d-flex align-items-center justify-content-center"
                         style="height: 200px; overflow: hidden; background: #f8f9fa;">
                        <!-- Converted image preview -->
                    </div>
                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-success btn-lg" id="download-btn">
                            <i class="fas fa-download me-2"></i>Download <span id="download-format">JPG</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Info Section -->
<div class="alert alert-info mt-4">
    <h6 class="alert-heading">
        <i class="fas fa-info-circle me-2"></i>About SVG to Image Conversion
    </h6>
    <p class="mb-2">
        Convert your SVG vector graphics to raster images with these features:
    </p>
    <ul class="mb-2">
        <li><strong>Multiple Formats</strong> - Convert to JPG, PNG, WebP, or BMP</li>
        <li><strong>Custom Sizing</strong> - Resize to any dimensions or use presets</li>
        <li><strong>Quality Control</strong> - Adjust compression quality for optimal file size</li>
        <li><strong>Background Options</strong> - Transparent or colored backgrounds</li>
        <li><strong>Aspect Ratio</strong> - Maintain original proportions or stretch to fit</li>
    </ul>
    <p class="mb-0">
        <small><strong>Tip:</strong> PNG format preserves transparency, while JPG creates smaller file sizes with solid backgrounds.</small>
    </p>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const svgFileInput = document.getElementById('svg-file');
    const conversionOptions = document.getElementById('conversion-options');
    const customSizeOptions = document.getElementById('custom-size-options');
    const presetSizeOptions = document.getElementById('preset-size-options');
    const colorPickerSection = document.getElementById('color-picker-section');
    const convertSection = document.getElementById('convert-section');
    const previewSection = document.getElementById('preview-section');
    const conversionProgress = document.getElementById('conversion-progress');
    const resultsSection = document.getElementById('results-section');

    const outputFormat = document.getElementById('output-format');
    const imageQuality = document.getElementById('image-quality');
    const resizeOption = document.getElementById('resize-option');
    const customWidth = document.getElementById('custom-width');
    const customHeight = document.getElementById('custom-height');
    const maintainAspect = document.getElementById('maintain-aspect');
    const backgroundColor = document.getElementById('background-color');
    const customBgColor = document.getElementById('custom-bg-color');

    const convertBtn = document.getElementById('convert-btn');
    const resetBtn = document.getElementById('reset-btn');
    const downloadBtn = document.getElementById('download-btn');

    let selectedFile = null;
    let svgContent = '';
    let originalDimensions = { width: 0, height: 0 };
    let convertedImageBlob = null;

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function updateConvertButtonText() {
        const format = outputFormat.value.toUpperCase();
        convertBtn.innerHTML = `<i class="fas fa-exchange-alt me-2"></i>Convert to ${format}`;
        document.getElementById('converting-format').textContent = format;
        document.getElementById('download-format').textContent = format;
    }

    function parseSVGDimensions(svgText) {
        const parser = new DOMParser();
        const svgDoc = parser.parseFromString(svgText, 'image/svg+xml');
        const svgElement = svgDoc.querySelector('svg');

        let width = 0, height = 0;

        if (svgElement) {
            // Try to get dimensions from width/height attributes
            const widthAttr = svgElement.getAttribute('width');
            const heightAttr = svgElement.getAttribute('height');

            if (widthAttr && heightAttr) {
                width = parseInt(widthAttr) || 0;
                height = parseInt(heightAttr) || 0;
            } else {
                // Try to get from viewBox
                const viewBox = svgElement.getAttribute('viewBox');
                if (viewBox) {
                    const values = viewBox.split(/\\s+|,/);
                    if (values.length >= 4) {
                        width = parseInt(values[2]) || 0;
                        height = parseInt(values[3]) || 0;
                    }
                }
            }
        }

        return { width: width || 300, height: height || 300 };
    }

    function countSVGElements(svgText) {
        const parser = new DOMParser();
        const svgDoc = parser.parseFromString(svgText, 'image/svg+xml');
        const elements = svgDoc.querySelectorAll('path, rect, circle, ellipse, line, polyline, polygon, text');
        return elements.length;
    }

    svgFileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];

        if (!file) {
            hideAllSections();
            return;
        }

        if (!file.name.toLowerCase().endsWith('.svg')) {
            alert('Please select an SVG file');
            this.value = '';
            return;
        }

        if (file.size > 5 * 1024 * 1024) { // 5MB limit
            alert('File size must be less than 5MB');
            this.value = '';
            return;
        }

        selectedFile = file;
        loadSVGFile(file);
    });

    function loadSVGFile(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            svgContent = e.target.result;
            originalDimensions = parseSVGDimensions(svgContent);
            showFilePreview(file);

            conversionOptions.style.display = 'block';
            convertSection.style.display = 'block';
            previewSection.style.display = 'block';
        };
        reader.readAsText(file);
    }

    function showFilePreview(file) {
        document.getElementById('file-name').textContent = file.name;
        document.getElementById('file-size').textContent = formatFileSize(file.size);
        document.getElementById('svg-dimensions').textContent = `${originalDimensions.width} × ${originalDimensions.height}`;
        document.getElementById('svg-elements').textContent = countSVGElements(svgContent);

        // Show SVG preview
        const preview = document.getElementById('svg-preview');
        preview.innerHTML = svgContent;

        // Scale the SVG to fit the preview
        const svgElement = preview.querySelector('svg');
        if (svgElement) {
            svgElement.style.width = '100%';
            svgElement.style.height = '100%';
            svgElement.style.maxWidth = '280px';
            svgElement.style.maxHeight = '280px';
        }
    }

    function hideAllSections() {
        conversionOptions.style.display = 'none';
        customSizeOptions.style.display = 'none';
        presetSizeOptions.style.display = 'none';
        colorPickerSection.style.display = 'none';
        convertSection.style.display = 'none';
        previewSection.style.display = 'none';
        conversionProgress.style.display = 'none';
        resultsSection.style.display = 'none';
    }

    resizeOption.addEventListener('change', function() {
        customSizeOptions.style.display = this.value === 'custom' ? 'block' : 'none';
        presetSizeOptions.style.display = this.value === 'preset' ? 'block' : 'none';
    });

    backgroundColor.addEventListener('change', function() {
        colorPickerSection.style.display = this.value === 'custom' ? 'block' : 'none';
    });

    outputFormat.addEventListener('change', updateConvertButtonText);

    // Maintain aspect ratio functionality
    maintainAspect.addEventListener('change', function() {
        if (this.checked) {
            updateAspectRatio();
        }
    });

    customWidth.addEventListener('input', function() {
        if (maintainAspect.checked) {
            const ratio = originalDimensions.height / originalDimensions.width;
            customHeight.value = Math.round(this.value * ratio);
        }
    });

    customHeight.addEventListener('input', function() {
        if (maintainAspect.checked) {
            const ratio = originalDimensions.width / originalDimensions.height;
            customWidth.value = Math.round(this.value * ratio);
        }
    });

    function updateAspectRatio() {
        if (originalDimensions.width > 0) {
            const ratio = originalDimensions.height / originalDimensions.width;
            customHeight.value = Math.round(customWidth.value * ratio);
        }
    }

    convertBtn.addEventListener('click', function() {
        if (!selectedFile || !svgContent) {
            alert('Please select an SVG file first');
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
        const steps = [
            'Parsing SVG structure...',
            'Rendering to canvas...',
            'Applying transformations...',
            'Setting quality and format...',
            'Generating final image...'
        ];

        const interval = setInterval(() => {
            progress += Math.random() * 25;
            if (progress > 100) progress = 100;

            progressBar.style.width = progress + '%';
            progressText.textContent = Math.round(progress) + '%';

            const stepIndex = Math.min(Math.floor(progress / 20), steps.length - 1);
            conversionStatus.textContent = steps[stepIndex];

            if (progress >= 100) {
                clearInterval(interval);
                completeConversion();
            }
        }, 300);
    }

    function completeConversion() {
        setTimeout(() => {
            // Convert SVG to canvas and then to image
            convertSVGToImage();
        }, 500);
    }

    function convertSVGToImage() {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');

        // Get dimensions
        let targetWidth, targetHeight;

        if (resizeOption.value === 'custom') {
            targetWidth = parseInt(customWidth.value);
            targetHeight = parseInt(customHeight.value);
        } else if (resizeOption.value === 'preset') {
            const selectedPreset = document.querySelector('input[name="preset-size"]:checked');
            if (selectedPreset) {
                const [w, h] = selectedPreset.value.split('x').map(n => parseInt(n));
                targetWidth = w;
                targetHeight = h;
            } else {
                targetWidth = originalDimensions.width;
                targetHeight = originalDimensions.height;
            }
        } else {
            targetWidth = originalDimensions.width;
            targetHeight = originalDimensions.height;
        }

        canvas.width = targetWidth;
        canvas.height = targetHeight;

        // Set background
        const bgColor = backgroundColor.value;
        if (bgColor !== 'transparent') {
            if (bgColor === 'white') {
                ctx.fillStyle = '#ffffff';
            } else if (bgColor === 'black') {
                ctx.fillStyle = '#000000';
            } else if (bgColor === 'custom') {
                ctx.fillStyle = customBgColor.value;
            }

            if (bgColor !== 'transparent') {
                ctx.fillRect(0, 0, canvas.width, canvas.height);
            }
        }

        // Create image from SVG
        const img = new Image();
        const svgBlob = new Blob([svgContent], { type: 'image/svg+xml' });
        const url = URL.createObjectURL(svgBlob);

        img.onload = function() {
            ctx.drawImage(img, 0, 0, targetWidth, targetHeight);
            URL.revokeObjectURL(url);

            // Convert canvas to blob
            const format = outputFormat.value;
            const quality = parseInt(imageQuality.value) / 100;
            const mimeType = format === 'png' ? 'image/png' :
                           format === 'webp' ? 'image/webp' :
                           format === 'bmp' ? 'image/bmp' : 'image/jpeg';

            canvas.toBlob(function(blob) {
                convertedImageBlob = blob;
                showResults(targetWidth, targetHeight);
            }, mimeType, quality);
        };

        img.src = url;
    }

    function showResults(width, height) {
        conversionProgress.style.display = 'none';
        resultsSection.style.display = 'block';
        convertBtn.disabled = false;

        // Create conversion summary
        const summary = document.getElementById('conversion-summary');
        const format = outputFormat.value.toUpperCase();

        summary.innerHTML = `
            <li><i class="fas fa-check text-success me-2"></i>Format: SVG to ${format}</li>
            <li><i class="fas fa-check text-success me-2"></i>Dimensions: ${width} × ${height}</li>
            <li><i class="fas fa-check text-success me-2"></i>Quality: ${imageQuality.value}%</li>
            <li><i class="fas fa-check text-success me-2"></i>Background: ${getBackgroundDescription()}</li>
            <li><i class="fas fa-check text-success me-2"></i>File size: ${formatFileSize(convertedImageBlob.size)}</li>
        `;

        // Show preview of converted image
        const resultPreview = document.getElementById('result-preview');
        const previewImg = document.createElement('img');
        previewImg.src = URL.createObjectURL(convertedImageBlob);
        previewImg.style.maxWidth = '100%';
        previewImg.style.maxHeight = '100%';
        previewImg.style.objectFit = 'contain';

        resultPreview.innerHTML = '';
        resultPreview.appendChild(previewImg);
    }

    function getBackgroundDescription() {
        const bg = backgroundColor.value;
        switch(bg) {
            case 'transparent': return 'Transparent';
            case 'white': return 'White';
            case 'black': return 'Black';
            case 'custom': return 'Custom color';
            default: return 'Default';
        }
    }

    downloadBtn.addEventListener('click', function() {
        if (!convertedImageBlob) {
            alert('No converted image available');
            return;
        }

        const format = outputFormat.value;
        const filename = selectedFile.name.replace('.svg', '') + '.' + format;

        const url = URL.createObjectURL(convertedImageBlob);
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
        svgFileInput.value = '';
        selectedFile = null;
        svgContent = '';
        convertedImageBlob = null;
        originalDimensions = { width: 0, height: 0 };

        hideAllSections();

        // Reset form values
        outputFormat.value = 'jpg';
        imageQuality.value = '95';
        resizeOption.value = 'original';
        backgroundColor.value = 'transparent';
        customWidth.value = '800';
        customHeight.value = '600';
        maintainAspect.checked = true;
        customBgColor.value = '#ffffff';

        // Reset preset selection
        document.getElementById('size-medium').checked = true;

        updateConvertButtonText();
    });

    // Initialize
    updateConvertButtonText();
});
</script>
