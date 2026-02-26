{{-- Base64 Decoder --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-code me-2"></i>
    Decode Base64 encoded data back to its original format.
</div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-code me-2"></i>
                        {{ $tool->name }}
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">{{ $tool->description }}</p>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="inputText" class="form-label">Base64 to Decode</label>
                                <textarea class="form-control" id="inputText" rows="6"
                                    placeholder="Enter Base64 encoded text to decode..."></textarea>
                                <div class="form-text">Paste Base64 encoded string here</div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="urlSafe">
                                    <label class="form-check-label" for="urlSafe">
                                        URL-Safe Decoding (expects - and _ instead of + and /)
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button type="button" class="btn btn-primary" id="decodeBtn">
                                    <i class="fas fa-unlock me-2"></i>Decode Base64
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

                            <div class="mt-3" id="infoSection" style="display: none;">
                                <div class="alert alert-info">
                                    <strong>Decoded Info:</strong>
                                    <div id="decodedInfo"></div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <small class="text-muted">
                                    <strong>Info:</strong> Base64 decoding converts Base64 encoded text back to its original format.
                                    Common use cases include decoding data URLs, email attachments, and API responses.
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
const urlSafe = document.getElementById('urlSafe');
const decodeBtn = document.getElementById('decodeBtn');
const copyBtn = document.getElementById('copyBtn');
const downloadBtn = document.getElementById('downloadBtn');
const clearBtn = document.getElementById('clearBtn');
const infoSection = document.getElementById('infoSection');
const decodedInfo = document.getElementById('decodedInfo');

// Decode from Base64
function decodeFromBase64(text, isUrlSafe = false) {
    try {
        let decoded = text.trim();

        if (isUrlSafe) {
            decoded = decoded.replace(/-/g, '+').replace(/_/g, '/');
            // Add padding if needed
            while (decoded.length % 4) {
                decoded += '=';
            }
        }

        const result = decodeURIComponent(escape(atob(decoded)));
        return result;
    } catch (error) {
        throw new Error('Invalid Base64 string: ' + error.message);
    }
}

// Check if text is JSON
function isJSON(str) {
    try {
        JSON.parse(str);
        return true;
    } catch (e) {
        return false;
    }
}

// Check if text is HTML
function isHTML(str) {
    return /<[a-z][\s\S]*>/i.test(str);
}

// Get file info
function getDecodedInfo(text) {
    const info = [];
    info.push(`Length: ${text.length} characters`);
    info.push(`Size: ${new Blob([text]).size} bytes`);

    if (isJSON(text)) {
        info.push('Format: JSON detected');
    } else if (isHTML(text)) {
        info.push('Format: HTML detected');
    } else if (text.includes('\n')) {
        info.push('Format: Multi-line text');
    } else {
        info.push('Format: Plain text');
    }

    return info;
}

// Decode button click
decodeBtn.addEventListener('click', function() {
    const text = inputText.value.trim();

    if (!text) {
        alert('Please enter Base64 encoded text to decode.');
        return;
    }

    try {
        const decoded = decodeFromBase64(text, urlSafe.checked);
        outputText.value = decoded;

        // Show info
        const info = getDecodedInfo(decoded);
        decodedInfo.innerHTML = info.join('<br>');
        infoSection.style.display = 'block';

    } catch (error) {
        alert('Error: ' + error.message);
        outputText.value = '';
        infoSection.style.display = 'none';
    }
});

// Auto-decode on input change
inputText.addEventListener('input', function() {
    if (this.value.trim()) {
        decodeBtn.click();
    } else {
        outputText.value = '';
        infoSection.style.display = 'none';
    }
});

urlSafe.addEventListener('change', function() {
    if (inputText.value.trim()) {
        decodeBtn.click();
    }
});

// Copy to clipboard
copyBtn.addEventListener('click', function() {
    if (!outputText.value) {
        alert('Nothing to copy. Please decode some Base64 first.');
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
        alert('Nothing to download. Please decode some Base64 first.');
        return;
    }

    const blob = new Blob([outputText.value], { type: 'text/plain' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'base64-decoded.txt';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
});

// Clear all
clearBtn.addEventListener('click', function() {
    inputText.value = '';
    outputText.value = '';
    urlSafe.checked = false;
    infoSection.style.display = 'none';
    inputText.focus();
});
</script>
