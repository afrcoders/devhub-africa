{{-- Image to Text Converter (OCR) --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-font me-2"></i>
    Extract text from images using Optical Character Recognition (OCR).
</div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-file-alt me-2"></i>
                        {{ $tool->name }}
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">{{ $tool->description }}</p>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="fileInput" class="form-label">Select Images</label>
                                <input type="file" class="form-control" id="fileInput" accept="image/*" multiple>
                                <div class="form-text">Upload images containing text (JPG, PNG, GIF, etc.)</div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="language" class="form-label">Text Language</label>
                                        <select class="form-select" id="language">
                                            <option value="eng">English</option>
                                            <option value="spa">Spanish</option>
                                            <option value="fra">French</option>
                                            <option value="deu">German</option>
                                            <option value="ita">Italian</option>
                                            <option value="por">Portuguese</option>
                                            <option value="rus">Russian</option>
                                            <option value="chi_sim">Chinese (Simplified)</option>
                                            <option value="jpn">Japanese</option>
                                            <option value="kor">Korean</option>
                                            <option value="ara">Arabic</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="outputFormat" class="form-label">Output Format</label>
                                        <select class="form-select" id="outputFormat">
                                            <option value="text">Plain Text</option>
                                            <option value="formatted">Formatted Text</option>
                                            <option value="json">JSON Structure</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3" style="display: none;" id="previewSection">
                                <label class="form-label">Image Previews</label>
                                <div id="imagePreview" class="border rounded p-3" style="max-height: 300px; overflow-y: auto;"></div>
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button type="button" class="btn btn-primary" id="extractBtn" disabled>
                                    <i class="fas fa-eye me-2"></i>Extract Text from Images
                                </button>
                            </div>

                            <div class="mb-3" style="display: none;" id="resultSection">
                                <label class="form-label">Extracted Text</label>
                                <div id="textResults" class="border rounded p-3" style="max-height: 400px; overflow-y: auto;"></div>
                            </div>

                            <div class="row" style="display: none;" id="actionSection">
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-secondary w-100" id="copyBtn">
                                        <i class="fas fa-copy me-2"></i>Copy Text
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-success w-100" id="downloadBtn">
                                        <i class="fas fa-download me-2"></i>Download
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-warning w-100" id="clearBtn">
                                        <i class="fas fa-trash me-2"></i>Clear
                                    </button>
                                </div>
                            </div>

                            <div class="mt-3" style="display: none;" id="warningSection">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Note:</strong> This is a demonstration of OCR (Optical Character Recognition) functionality.
                                    For production use, integrate with services like Google Cloud Vision API, Amazon Textract, or Tesseract.js.
                                </div>
                            </div>

                            <div class="progress" style="display: none;" id="progressSection">
                                <div class="progress-bar" role="progressbar" style="width: 0%" id="progressBar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const fileInput = document.getElementById('fileInput');
const language = document.getElementById('language');
const outputFormat = document.getElementById('outputFormat');
const previewSection = document.getElementById('previewSection');
const imagePreview = document.getElementById('imagePreview');
const extractBtn = document.getElementById('extractBtn');
const resultSection = document.getElementById('resultSection');
const textResults = document.getElementById('textResults');
const actionSection = document.getElementById('actionSection');
const copyBtn = document.getElementById('copyBtn');
const downloadBtn = document.getElementById('downloadBtn');
const clearBtn = document.getElementById('clearBtn');
const warningSection = document.getElementById('warningSection');
const progressSection = document.getElementById('progressSection');
const progressBar = document.getElementById('progressBar');

let selectedFiles = [];
let extractedTexts = [];

// File input change handler
fileInput.addEventListener('change', function(e) {
    selectedFiles = Array.from(e.target.files);

    if (selectedFiles.length > 0) {
        showPreviews();
        extractBtn.disabled = false;
    } else {
        previewSection.style.display = 'none';
        extractBtn.disabled = true;
    }
});

// Show image previews
function showPreviews() {
    imagePreview.innerHTML = '';

    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const imgContainer = document.createElement('div');
            imgContainer.className = 'mb-2 p-2 border rounded d-flex align-items-center';
            imgContainer.innerHTML = `
                <img src="${e.target.result}" alt="Preview" style="width: 80px; height: 80px; object-fit: cover;" class="rounded me-3">
                <div class="flex-grow-1">
                    <strong>${file.name}</strong><br>
                    <small class="text-muted">
                        Size: ${(file.size / 1024).toFixed(1)} KB |
                        Type: ${file.type}
                    </small>
                </div>
                <div class="text-end">
                    <span class="badge bg-primary">→ TEXT</span>
                </div>
            `;
            imagePreview.appendChild(imgContainer);
        };
        reader.readAsDataURL(file);
    });

    previewSection.style.display = 'block';
}

// Simulate OCR text extraction
function simulateTextExtraction(file) {
    return new Promise((resolve) => {
        // In a real implementation, you would use an OCR library like Tesseract.js
        // For demonstration, we'll generate simulated extracted text

        const sampleTexts = [
            "Sample extracted text from image analysis.\nThis demonstrates OCR functionality.",
            "Invoice #12345\nDate: 2024-01-15\nAmount: $125.50\nThank you for your business!",
            "Lorem ipsum dolor sit amet, consectetur adipiscing elit.\nSed do eiusmod tempor incididunt ut labore.",
            "RECEIPT\nStore: Tech Shop\nItem: Laptop Computer\nPrice: $899.99\nTax: $72.00\nTotal: $971.99",
            "Meeting Notes\n- Project timeline: 3 months\n- Budget: $50,000\n- Team size: 5 developers",
            "Address:\n123 Main Street\nNew York, NY 10001\nUnited States",
            "Phone: (555) 123-4567\nEmail: contact@example.com\nWebsite: www.example.com"
        ];

        // Simulate processing time
        setTimeout(() => {
            const randomText = sampleTexts[Math.floor(Math.random() * sampleTexts.length)];
            const confidence = Math.floor(Math.random() * 20) + 80; // 80-99% confidence

            resolve({
                filename: file.name,
                text: randomText,
                confidence: confidence,
                language: language.value,
                wordCount: randomText.split(/\s+/).length,
                characterCount: randomText.length
            });
        }, Math.random() * 1000 + 500); // 500-1500ms delay
    });
}

// Format extracted text based on output format
function formatExtractedText(results) {
    const format = outputFormat.value;

    switch (format) {
        case 'text':
            return results.map(result =>
                `=== ${result.filename} ===\n${result.text}\n\n`
            ).join('');

        case 'formatted':
            return results.map(result =>
                `File: ${result.filename}\n` +
                `Language: ${result.language}\n` +
                `Confidence: ${result.confidence}%\n` +
                `Words: ${result.wordCount} | Characters: ${result.characterCount}\n` +
                `Text:\n${result.text}\n\n` +
                `${'='.repeat(50)}\n\n`
            ).join('');

        case 'json':
            return JSON.stringify(results, null, 2);

        default:
            return results.map(result => result.text).join('\n\n');
    }
}

// Extract button click
extractBtn.addEventListener('click', async function() {
    if (selectedFiles.length === 0) return;

    extractBtn.disabled = true;
    progressSection.style.display = 'block';
    resultSection.style.display = 'none';
    actionSection.style.display = 'none';
    warningSection.style.display = 'block';

    extractedTexts = [];

    for (let i = 0; i < selectedFiles.length; i++) {
        const file = selectedFiles[i];

        // Update progress
        const progress = ((i + 1) / selectedFiles.length) * 100;
        progressBar.style.width = progress + '%';
        progressBar.textContent = `Extracting text from ${i + 1}/${selectedFiles.length}`;

        try {
            const result = await simulateTextExtraction(file);
            extractedTexts.push(result);
        } catch (error) {
            console.error('Error extracting text:', error);
        }
    }

    displayResults();
    progressSection.style.display = 'none';
    resultSection.style.display = 'block';
    actionSection.style.display = 'block';
    extractBtn.disabled = false;
    extractBtn.innerHTML = '<i class="fas fa-redo me-2"></i>Extract More Images';
});

// Display extraction results
function displayResults() {
    textResults.innerHTML = '';

    extractedTexts.forEach((result, index) => {
        const resultDiv = document.createElement('div');
        resultDiv.className = 'card mb-3';

        resultDiv.innerHTML = `
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">${result.filename}</h6>
                <div>
                    <span class="badge bg-success">Confidence: ${result.confidence}%</span>
                    <button class="btn btn-sm btn-outline-primary ms-2" onclick="copyIndividualText(${index})">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <small class="text-muted">
                        Language: ${result.language} |
                        Words: ${result.wordCount} |
                        Characters: ${result.characterCount}
                    </small>
                </div>
                <pre class="mb-0" style="white-space: pre-wrap; font-family: inherit;">${result.text}</pre>
            </div>
        `;

        textResults.appendChild(resultDiv);
    });
}

// Copy individual text result
function copyIndividualText(index) {
    const result = extractedTexts[index];
    navigator.clipboard.writeText(result.text);
}

// Copy all extracted text
copyBtn.addEventListener('click', function() {
    const formattedText = formatExtractedText(extractedTexts);
    navigator.clipboard.writeText(formattedText);

    const originalText = copyBtn.innerHTML;
    copyBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
    setTimeout(() => {
        copyBtn.innerHTML = originalText;
    }, 2000);
});

// Download extracted text
downloadBtn.addEventListener('click', function() {
    const formattedText = formatExtractedText(extractedTexts);
    const format = outputFormat.value;

    let filename = 'extracted-text.txt';
    let mimeType = 'text/plain';

    if (format === 'json') {
        filename = 'extracted-text.json';
        mimeType = 'application/json';
    }

    const blob = new Blob([formattedText], { type: mimeType });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
});

// Clear results
clearBtn.addEventListener('click', function() {
    selectedFiles = [];
    extractedTexts = [];
    fileInput.value = '';
    previewSection.style.display = 'none';
    resultSection.style.display = 'none';
    actionSection.style.display = 'none';
    warningSection.style.display = 'none';
    progressSection.style.display = 'none';
    extractBtn.disabled = true;
    extractBtn.innerHTML = '<i class="fas fa-eye me-2"></i>Extract Text from Images';
});

// Output format change handler
outputFormat.addEventListener('change', function() {
    if (extractedTexts.length > 0) {
        displayResults();
    }
});
</script>
