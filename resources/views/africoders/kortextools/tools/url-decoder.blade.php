{{-- URL Decoder --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-link me-2"></i>
    Decode URL encoded strings and parameters.
</div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-unlock me-2"></i>
                        {{ $tool->name }}
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">{{ $tool->description }}</p>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="inputText" class="form-label">URL Encoded Text to Decode</label>
                                <textarea class="form-control" id="inputText" rows="6"
                                    placeholder="Enter URL encoded text to decode..."></textarea>
                                <div class="form-text">Paste URL encoded string here</div>
                            </div>

                            <div class="mb-3">
                                <label for="decodingType" class="form-label">Decoding Type</label>
                                <select class="form-select" id="decodingType">
                                    <option value="component">Component Decoding (decodeURIComponent)</option>
                                    <option value="uri">URI Decoding (decodeURI)</option>
                                    <option value="standard">Standard URL Decoding</option>
                                </select>
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button type="button" class="btn btn-primary" id="decodeBtn">
                                    <i class="fas fa-unlock me-2"></i>Decode URL
                                </button>
                            </div>

                            <div class="mb-3">
                                <label for="outputText" class="form-label">Decoded Output</label>
                                <textarea class="form-control" id="outputText" rows="6" readonly
                                    placeholder="Decoded text will appear here..."></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-secondary w-100" id="copyBtn">
                                        <i class="fas fa-copy me-2"></i>Copy
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

                            <div class="mt-3" id="analysisSection" style="display: none;">
                                <div class="alert alert-info">
                                    <strong>Analysis:</strong>
                                    <div id="analysisResult"></div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <small class="text-muted">
                                    <strong>Decoding Types:</strong><br>
                                    • <strong>Component:</strong> Decodes all URL encoded characters<br>
                                    • <strong>URI:</strong> Decodes only illegal characters, preserves URL structure<br>
                                    • <strong>Standard:</strong> Converts + to spaces and decodes % sequences
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const inputText = document.getElementById('inputText');
const outputText = document.getElementById('outputText');
const decodingType = document.getElementById('decodingType');
const decodeBtn = document.getElementById('decodeBtn');
const copyBtn = document.getElementById('copyBtn');
const downloadBtn = document.getElementById('downloadBtn');
const clearBtn = document.getElementById('clearBtn');
const analysisSection = document.getElementById('analysisSection');
const analysisResult = document.getElementById('analysisResult');

// URL decoding functions
function urlDecode(text, type) {
    try {
        switch(type) {
            case 'component':
                return decodeURIComponent(text);

            case 'uri':
                return decodeURI(text);

            case 'standard':
                // Standard URL decoding (+ to space, then decode % sequences)
                return decodeURIComponent(text.replace(/\+/g, ' '));

            default:
                return decodeURIComponent(text);
        }
    } catch (error) {
        throw new Error('Invalid URL encoded string: ' + error.message);
    }
}

// Analyze the decoded text
function analyzeDecoded(original, decoded) {
    const analysis = [];

    // Count encoded characters
    const encodedChars = (original.match(/%[0-9A-Fa-f]{2}/g) || []).length;
    const plusSigns = (original.match(/\+/g) || []).length;

    if (encodedChars > 0) {
        analysis.push(`Found ${encodedChars} percent-encoded character(s)`);
    }

    if (plusSigns > 0) {
        analysis.push(`Found ${plusSigns} plus sign(s) (spaces)`);
    }

    // Check if it's a URL
    try {
        new URL(decoded);
        analysis.push('Decoded text appears to be a valid URL');
    } catch (e) {
        // Not a URL, check for common patterns
        if (decoded.includes('@')) {
            analysis.push('Might contain email address(es)');
        }
        if (decoded.match(/^[a-zA-Z0-9\s.,!?-]+$/)) {
            analysis.push('Contains plain text');
        }
    }

    analysis.push(`Original length: ${original.length} → Decoded length: ${decoded.length}`);

    return analysis;
}

// Decode button click
decodeBtn.addEventListener('click', function() {
    const text = inputText.value.trim();

    if (!text) {
        alert('Please enter URL encoded text to decode.');
        return;
    }

    try {
        const decoded = urlDecode(text, decodingType.value);
        outputText.value = decoded;

        // Show analysis
        const analysis = analyzeDecoded(text, decoded);
        analysisResult.innerHTML = analysis.join('<br>');
        analysisSection.style.display = 'block';

    } catch (error) {
        alert('Error: ' + error.message);
        outputText.value = '';
        analysisSection.style.display = 'none';
    }
});

// Auto-decode on input change
inputText.addEventListener('input', function() {
    if (this.value.trim()) {
        decodeBtn.click();
    } else {
        outputText.value = '';
        analysisSection.style.display = 'none';
    }
});

decodingType.addEventListener('change', function() {
    if (inputText.value.trim()) {
        decodeBtn.click();
    }
});

// Copy to clipboard
copyBtn.addEventListener('click', function() {
    if (!outputText.value) {
        alert('Nothing to copy. Please decode some text first.');
        return;
    }

    outputText.select();
    navigator.clipboard.writeText(outputText.value).then(function() {
        const originalText = copyBtn.innerHTML;
        copyBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
        setTimeout(function() {
            copyBtn.innerHTML = originalText;
        }, 2000);
    });
});

// Download as text file
downloadBtn.addEventListener('click', function() {
    if (!outputText.value) {
        alert('Nothing to download. Please decode some text first.');
        return;
    }

    const blob = new Blob([outputText.value], { type: 'text/plain' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'url-decoded.txt';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
});

// Clear all
clearBtn.addEventListener('click', function() {
    inputText.value = '';
    outputText.value = '';
    decodingType.value = 'component';
    analysisSection.style.display = 'none';
    inputText.focus();
});

// Common examples
const examplesBtn = document.createElement('button');
examplesBtn.type = 'button';
examplesBtn.className = 'btn btn-outline-info mt-2';
examplesBtn.innerHTML = '<i class="fas fa-lightbulb me-2"></i>Examples';
examplesBtn.onclick = function() {
    const examples = [
        'Hello%20World%21',
        'user%40example.com',
        'https%3A//example.com%3Fquery%3Dtest',
        'Special+chars%3A+%21%40%23%24%25%5E%26%2A%28%29',
        '%E4%BD%A0%E5%A5%BD%E4%B8%96%E7%95%8C'
    ];

    const selectedExample = examples[Math.floor(Math.random() * examples.length)];
    inputText.value = selectedExample;
    decodeBtn.click();
};

// Add examples button
inputText.parentNode.appendChild(examplesBtn);
</script>
