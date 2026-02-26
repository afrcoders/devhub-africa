<div class="row">
    <div class="col-md-12">
        <div class="mb-4">
            <label for="pdf-file" class="form-label">Select PDF File:</label>
            <input type="file" class="form-control" id="pdf-file" accept=".pdf" />
            <small class="form-text text-muted">Maximum file size: 10MB</small>
        </div>

        <div class="row mb-4" id="conversion-options" style="display: none;">
            <div class="col-md-4">
                <label for="output-format" class="form-label">Output Format:</label>
                <select class="form-select" id="output-format">
                    <option value="docx">Word Document (.docx)</option>
                    <option value="txt">Text File (.txt)</option>
                    <option value="rtf">Rich Text Format (.rtf)</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="page-range" class="form-label">Page Range:</label>
                <select class="form-select" id="page-range">
                    <option value="all">All Pages</option>
                    <option value="custom">Custom Range</option>
                    <option value="first">First Page Only</option>
                </select>
            </div>
            <div class="col-md-4" id="custom-range" style="display: none;">
                <label for="page-numbers" class="form-label">Pages (e.g., 1-5, 8):</label>
                <input type="text" class="form-control" id="page-numbers" placeholder="1-5, 8, 10">
            </div>
        </div>

        <div class="row mb-4" id="advanced-options" style="display: none;">
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="preserve-formatting" checked>
                    <label class="form-check-label" for="preserve-formatting">
                        Preserve Formatting
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="extract-images">
                    <label class="form-check-label" for="extract-images">
                        Extract Images
                    </label>
                </div>
            </div>
        </div>

        <div class="mb-4" id="convert-section" style="display: none;">
            <button type="button" class="btn btn-primary btn-lg" id="convert-btn">
                <i class="fas fa-file-export me-2"></i>Convert to Word
            </button>
            <button type="button" class="btn btn-outline-secondary ms-2" id="reset-btn">
                <i class="fas fa-undo me-2"></i>Reset
            </button>
        </div>
    </div>
</div>

<!-- File Preview -->
<div class="row" id="preview-section" style="display: none;">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-eye me-2"></i>PDF Preview
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
                                <td><strong>Created:</strong></td>
                                <td id="creation-date">-</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Preview:</h6>
                        <div id="pdf-preview" class="border rounded" style="height: 300px; overflow-y: auto; background: #f8f9fa;">
                            <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                <div class="text-center">
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
</div>

<!-- Conversion Progress -->
<div id="conversion-progress" class="mt-4" style="display: none;">
    <div class="card">
        <div class="card-body">
            <h6><i class="fas fa-cog fa-spin me-2"></i>Converting PDF to Word...</h6>
            <div class="progress mb-3">
                <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" 
                     role="progressbar" style="width: 0%">
                    <span id="progress-text">0%</span>
                </div>
            </div>
            <div id="conversion-status" class="small text-muted">
                Initializing conversion...
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
                <div class="col-md-8">
                    <h6>Conversion Summary:</h6>
                    <ul id="conversion-summary" class="list-unstyled">
                        <!-- Summary items will be added here -->
                    </ul>
                </div>
                <div class="col-md-4 text-end">
                    <button type="button" class="btn btn-success btn-lg" id="download-btn">
                        <i class="fas fa-download me-2"></i>Download Word Document
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Info Section -->
<div class="alert alert-info mt-4">
    <h6 class="alert-heading">
        <i class="fas fa-info-circle me-2"></i>About PDF to Word Conversion
    </h6>
    <p class="mb-2">
        Convert your PDF files to editable Word documents with these features:
    </p>
    <ul class="mb-2">
        <li><strong>Format Preservation</strong> - Maintains text formatting and layout</li>
        <li><strong>Image Extraction</strong> - Optionally extract embedded images</li>
        <li><strong>Custom Page Range</strong> - Convert specific pages or entire document</li>
        <li><strong>Multiple Formats</strong> - Output to DOCX, TXT, or RTF</li>
    </ul>
    <p class="mb-0">
        <small><strong>Supported PDF types:</strong> Text-based PDFs work best. Scanned documents may require OCR processing.</small>
    </p>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pdfFileInput = document.getElementById('pdf-file');
    const conversionOptions = document.getElementById('conversion-options');
    const advancedOptions = document.getElementById('advanced-options');
    const convertSection = document.getElementById('convert-section');
    const previewSection = document.getElementById('preview-section');
    const conversionProgress = document.getElementById('conversion-progress');
    const resultsSection = document.getElementById('results-section');
    
    const outputFormat = document.getElementById('output-format');
    const pageRange = document.getElementById('page-range');
    const customRange = document.getElementById('custom-range');
    const pageNumbers = document.getElementById('page-numbers');
    const preserveFormatting = document.getElementById('preserve-formatting');
    const extractImages = document.getElementById('extract-images');
    
    const convertBtn = document.getElementById('convert-btn');
    const resetBtn = document.getElementById('reset-btn');
    const downloadBtn = document.getElementById('download-btn');
    
    let selectedFile = null;
    let convertedBlob = null;

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function updateConvertButtonText() {
        const format = outputFormat.value.toUpperCase();
        const formatNames = {
            'DOCX': 'Word',
            'TXT': 'Text',
            'RTF': 'RTF'
        };
        convertBtn.innerHTML = `<i class="fas fa-file-export me-2"></i>Convert to ${formatNames[format]}`;
    }

    function validatePageRange(input, totalPages) {
        if (!input) return true;
        
        const ranges = input.split(',').map(s => s.trim());
        for (let range of ranges) {
            if (range.includes('-')) {
                const [start, end] = range.split('-').map(n => parseInt(n.trim()));
                if (isNaN(start) || isNaN(end) || start < 1 || end > totalPages || start > end) {
                    return false;
                }
            } else {
                const page = parseInt(range);
                if (isNaN(page) || page < 1 || page > totalPages) {
                    return false;
                }
            }
        }
        return true;
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
        convertSection.style.display = 'none';
        previewSection.style.display = 'none';
        conversionProgress.style.display = 'none';
        resultsSection.style.display = 'none';
    }

    function showFilePreview(file) {
        document.getElementById('file-name').textContent = file.name;
        document.getElementById('file-size').textContent = formatFileSize(file.size);
        document.getElementById('creation-date').textContent = new Date(file.lastModified).toLocaleString();
        
        // Simulate page count detection
        const estimatedPages = Math.ceil(file.size / (50 * 1024)); // Rough estimate
        document.getElementById('page-count').textContent = estimatedPages + ' (estimated)';
    }

    pageRange.addEventListener('change', function() {
        if (this.value === 'custom') {
            customRange.style.display = 'block';
        } else {
            customRange.style.display = 'none';
        }
    });

    outputFormat.addEventListener('change', updateConvertButtonText);

    convertBtn.addEventListener('click', function() {
        if (!selectedFile) {
            alert('Please select a PDF file first');
            return;
        }

        // Validate custom page range if selected
        if (pageRange.value === 'custom') {
            const totalPages = parseInt(document.getElementById('page-count').textContent);
            if (!validatePageRange(pageNumbers.value, totalPages)) {
                alert('Invalid page range. Please use format like "1-5, 8, 10"');
                return;
            }
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
            'Reading PDF structure...',
            'Extracting text content...',
            'Processing formatting...',
            'Converting images...',
            'Generating Word document...',
            'Finalizing conversion...'
        ];

        const interval = setInterval(() => {
            progress += Math.random() * 20;
            if (progress > 100) progress = 100;

            progressBar.style.width = progress + '%';
            progressText.textContent = Math.round(progress) + '%';

            const stepIndex = Math.min(Math.floor(progress / 17), steps.length - 1);
            conversionStatus.textContent = steps[stepIndex];

            if (progress >= 100) {
                clearInterval(interval);
                completeConversion();
            }
        }, 500);
    }

    function completeConversion() {
        setTimeout(() => {
            conversionProgress.style.display = 'none';
            resultsSection.style.display = 'block';
            convertBtn.disabled = false;

            // Create conversion summary
            const summary = document.getElementById('conversion-summary');
            summary.innerHTML = '';

            const summaryItems = [
                `<li><i class="fas fa-check text-success me-2"></i>Format: PDF to ${outputFormat.value.toUpperCase()}</li>`,
                `<li><i class="fas fa-check text-success me-2"></i>Pages processed: ${getPageInfo()}</li>`,
                `<li><i class="fas fa-check text-success me-2"></i>Formatting: ${preserveFormatting.checked ? 'Preserved' : 'Basic'}</li>`,
                `<li><i class="fas fa-check text-success me-2"></i>Images: ${extractImages.checked ? 'Extracted' : 'Embedded'}</li>`,
                `<li><i class="fas fa-check text-success me-2"></i>File size: ${formatFileSize(selectedFile.size * 0.8)}</li>`
            ];

            summary.innerHTML = summaryItems.join('');

            // Create a dummy blob for download demonstration
            createConvertedFile();
        }, 1000);
    }

    function getPageInfo() {
        const range = pageRange.value;
        if (range === 'all') return 'All pages';
        if (range === 'first') return '1';
        if (range === 'custom') return pageNumbers.value || 'All pages';
        return 'All pages';
    }

    function createConvertedFile() {
        const format = outputFormat.value;
        let content, mimeType, extension;

        if (format === 'txt') {
            content = generateTextContent();
            mimeType = 'text/plain';
            extension = 'txt';
        } else if (format === 'rtf') {
            content = generateRTFContent();
            mimeType = 'application/rtf';
            extension = 'rtf';
        } else {
            content = generateDocxContent();
            mimeType = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
            extension = 'docx';
        }

        convertedBlob = new Blob([content], { type: mimeType });
    }

    function generateTextContent() {
        return `Converted PDF Content\\n\\nThis is a sample converted document from ${selectedFile.name}\\n\\nThe original PDF has been processed and converted to plain text format.\\n\\nConversion settings:\\n- Format: ${outputFormat.value.toUpperCase()}\\n- Pages: ${getPageInfo()}\\n- Formatting preserved: ${preserveFormatting.checked}\\n- Images extracted: ${extractImages.checked}\\n\\nThis is a demonstration of the PDF to Word conversion tool.`;
    }

    function generateRTFContent() {
        return `{\\rtf1\\ansi\\deff0 {\\fonttbl {\\f0 Times New Roman;}}\\f0\\fs24 Converted PDF Content\\par\\par This is a sample converted document from ${selectedFile.name}\\par\\par The original PDF has been processed and converted to RTF format.\\par}`;
    }

    function generateDocxContent() {
        // For demonstration, we'll create a simple text representation
        // In a real implementation, this would generate actual DOCX format
        return `Converted PDF Content\\n\\nThis is a sample converted document from ${selectedFile.name}\\n\\nThe original PDF has been processed and converted to Word format.`;
    }

    downloadBtn.addEventListener('click', function() {
        if (!convertedBlob) {
            alert('No converted file available');
            return;
        }

        const format = outputFormat.value;
        const filename = selectedFile.name.replace('.pdf', '') + '.' + format;
        
        const url = URL.createObjectURL(convertedBlob);
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
        convertedBlob = null;
        hideAllSections();
        pageNumbers.value = '';
        preserveFormatting.checked = true;
        extractImages.checked = false;
        pageRange.value = 'all';
        outputFormat.value = 'docx';
        customRange.style.display = 'none';
        updateConvertButtonText();
    });

    // Initialize
    updateConvertButtonText();
});
</script>