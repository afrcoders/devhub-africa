{{-- Base64 Encoder --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-code me-2"></i>
    Encode text, HTML, JSON, or binary data to Base64 format with URL-safe option.
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
                                <label for="inputText" class="form-label">Text to Encode</label>
                                <textarea class="form-control" id="inputText" rows="6"
                                    placeholder="Enter text to encode to Base64..."></textarea>
                                <div class="form-text">Enter any text, HTML, JSON, or binary data</div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="urlSafe">
                                    <label class="form-check-label" for="urlSafe">
                                        URL-Safe Encoding (replace + and / with - and _)
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button type="button" class="btn btn-primary" id="encodeBtn">
                                    <i class="fas fa-code me-2"></i>Encode to Base64
                                </button>
                            </div>

                            <div class="mb-3">
                                <label for="outputText" class="form-label">Base64 Encoded Output</label>
                                <textarea class="form-control" id="outputText" rows="6" readonly
                                    placeholder="Encoded Base64 will appear here..."></textarea>
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

                            <div class="mt-3">
                                <small class="text-muted">
                                    <strong>Info:</strong> Base64 encoding is used to encode binary data as ASCII text.
                                    It's commonly used in email attachments, data URLs, and web APIs.
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
const encodeBtn = document.getElementById('encodeBtn');
const copyBtn = document.getElementById('copyBtn');
const downloadBtn = document.getElementById('downloadBtn');
const clearBtn = document.getElementById('clearBtn');

// Encode to Base64
function encodeToBase64(text, isUrlSafe = false) {
    try {
        let encoded = btoa(unescape(encodeURIComponent(text)));

        if (isUrlSafe) {
            encoded = encoded.replace(/\+/g, '-').replace(/\//g, '_').replace(/=/g, '');
        }

        return encoded;
    } catch (error) {
        throw new Error('Failed to encode text: ' + error.message);
    }
}

// Encode button click
encodeBtn.addEventListener('click', function() {
    const text = inputText.value;

    if (!text.trim()) {
        alert('Please enter some text to encode.');
        return;
    }

    try {
        const encoded = encodeToBase64(text, urlSafe.checked);
        outputText.value = encoded;
    } catch (error) {
        alert('Error: ' + error.message);
    }
});

// Auto-encode on input change
inputText.addEventListener('input', function() {
    if (this.value.trim()) {
        encodeBtn.click();
    } else {
        outputText.value = '';
    }
});

urlSafe.addEventListener('change', function() {
    if (inputText.value.trim()) {
        encodeBtn.click();
    }
});

// Copy to clipboard
copyBtn.addEventListener('click', function() {
    if (!outputText.value) {
        alert('Nothing to copy. Please encode some text first.');
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
        alert('Nothing to download. Please encode some text first.');
        return;
    }

    const blob = new Blob([outputText.value], { type: 'text/plain' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'base64-encoded.txt';
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
    inputText.focus();
});

// File upload support
const fileUploadBtn = document.createElement('button');
fileUploadBtn.type = 'button';
fileUploadBtn.className = 'btn btn-outline-primary mt-2';
fileUploadBtn.innerHTML = '<i class="fas fa-upload me-2"></i>Upload File';
fileUploadBtn.onclick = function() {
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.onchange = function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                inputText.value = e.target.result;
                encodeBtn.click();
            };
            reader.readAsText(file);
        }
    };
    fileInput.click();
};

// Add file upload button after the input
inputText.parentNode.appendChild(fileUploadBtn);
</script>
