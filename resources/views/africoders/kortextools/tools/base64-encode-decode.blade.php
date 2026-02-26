<div class="row">
    <div class="col-md-12">
        <!-- Mode Selection -->
        <div class="mb-4">
            <div class="btn-group w-100" role="group" aria-label="Mode selection">
                <input type="radio" class="btn-check" name="mode" id="encode-mode" value="encode" checked>
                <label class="btn btn-outline-primary" for="encode-mode">
                    <i class="bi bi-lock"></i> Encode
                </label>

                <input type="radio" class="btn-check" name="mode" id="decode-mode" value="decode">
                <label class="btn btn-outline-primary" for="decode-mode">
                    <i class="bi bi-unlock"></i> Decode
                </label>
            </div>
        </div>

        <!-- Input Section -->
        <div class="mb-4">
            <label for="input-text" class="form-label" id="input-label">Enter text to encode:</label>
            <textarea
                class="form-control"
                id="input-text"
                rows="6"
                placeholder="Type or paste your text here..."
            ></textarea>
            <div class="form-text">
                <small class="text-muted" id="input-help">Enter plain text to convert to Base64 format.</small>
            </div>
        </div>

        <!-- Options -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="url-safe">
                    <label class="form-check-label" for="url-safe">
                        URL-safe Base64 (use - and _ instead of + and /)
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remove-padding">
                    <label class="form-check-label" for="remove-padding">
                        Remove padding (=)
                    </label>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="mb-3">
            <button type="button" class="btn btn-primary" onclick="processBase64()">
                <i class="bi bi-arrow-right" id="action-icon"></i> <span id="action-text">Encode</span>
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="clearAll()">
                <i class="bi bi-x-circle"></i> Clear
            </button>
            <button type="button" class="btn btn-outline-info" onclick="swapInputOutput()">
                <i class="bi bi-arrow-up-down"></i> Swap
            </button>
        </div>

        <!-- Output Section -->
        <div id="output-section" style="display: none;">
            <label for="output-text" class="form-label" id="output-label">Encoded result:</label>
            <div class="output-box">
                <textarea id="output-text" class="form-control" rows="6" readonly></textarea>
                <div class="d-flex justify-content-between mt-2">
                    <small class="text-muted" id="output-stats"></small>
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="copyToClipboard('output-text')">
                            <i class="bi bi-clipboard"></i> Copy
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-success" onclick="downloadResult()">
                            <i class="bi bi-download"></i> Download
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Examples -->
        <div class="mt-4">
            <h6>Quick Examples:</h6>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('Hello, World!')">
                    "Hello, World!"
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('Lorem ipsum dolor sit amet')">
                    Sample text
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('user:password')">
                    Credentials
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Information -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> About Base64 Encoding</h6>
    <p class="mb-0">
        Base64 is a binary-to-text encoding scheme that represents binary data in printable ASCII characters.
        It's commonly used for encoding data in email, HTTP, and other protocols. URL-safe Base64 uses different characters
        to avoid conflicts with URL special characters.
    </p>
</div>

<style>
.output-box {
    position: relative;
}
.output-box .form-control {
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
}
.btn-check:checked + .btn-outline-primary {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
    color: white;
}
</style>

<script>
// Mode change handler
document.querySelectorAll('input[name="mode"]').forEach(radio => {
    radio.addEventListener('change', updateMode);
});

function updateMode() {
    const mode = document.querySelector('input[name="mode"]:checked').value;
    const isEncode = mode === 'encode';

    document.getElementById('input-label').textContent = isEncode ? 'Enter text to encode:' : 'Enter Base64 to decode:';
    document.getElementById('input-help').textContent = isEncode ?
        'Enter plain text to convert to Base64 format.' :
        'Enter Base64 encoded text to decode back to plain text.';
    document.getElementById('action-text').textContent = isEncode ? 'Encode' : 'Decode';
    document.getElementById('action-icon').className = isEncode ? 'bi bi-lock' : 'bi bi-unlock';

    // Clear output when mode changes
    document.getElementById('output-section').style.display = 'none';
    document.getElementById('output-text').value = '';
}

function processBase64() {
    const inputText = document.getElementById('input-text').value;
    const mode = document.querySelector('input[name="mode"]:checked').value;
    const urlSafe = document.getElementById('url-safe').checked;
    const removePadding = document.getElementById('remove-padding').checked;

    if (!inputText.trim()) {
        alert('Please enter some text to process.');
        return;
    }

    try {
        let result = '';

        if (mode === 'encode') {
            // Encode to Base64
            result = btoa(unescape(encodeURIComponent(inputText)));

            if (urlSafe) {
                result = result.replace(/\+/g, '-').replace(/\//g, '_');
            }

            if (removePadding) {
                result = result.replace(/=/g, '');
            }

            document.getElementById('output-label').textContent = 'Encoded result:';
        } else {
            // Decode from Base64
            let base64Input = inputText;

            if (urlSafe) {
                base64Input = base64Input.replace(/-/g, '+').replace(/_/g, '/');
            }

            // Add padding if removed
            while (base64Input.length % 4) {
                base64Input += '=';
            }

            result = decodeURIComponent(escape(atob(base64Input)));
            document.getElementById('output-label').textContent = 'Decoded result:';
        }

        document.getElementById('output-text').value = result;
        document.getElementById('output-section').style.display = 'block';

        // Update stats
        updateStats(inputText, result);

    } catch (error) {
        alert('Error processing Base64: ' + error.message + '\\nPlease check your input.');
    }
}

function clearAll() {
    document.getElementById('input-text').value = '';
    document.getElementById('output-text').value = '';
    document.getElementById('output-section').style.display = 'none';
}

function swapInputOutput() {
    const inputText = document.getElementById('input-text').value;
    const outputText = document.getElementById('output-text').value;

    if (outputText) {
        document.getElementById('input-text').value = outputText;
        document.getElementById('output-text').value = inputText;

        // Toggle mode
        const currentMode = document.querySelector('input[name="mode"]:checked').value;
        const newMode = currentMode === 'encode' ? 'decode' : 'encode';
        document.getElementById(newMode + '-mode').checked = true;
        updateMode();

        if (inputText) {
            updateStats(outputText, inputText);
        }
    }
}

function useExample(example) {
    document.getElementById('input-text').value = example;
    document.getElementById('encode-mode').checked = true;
    updateMode();
    processBase64();
}

function updateStats(input, output) {
    const inputSize = new Blob([input]).size;
    const outputSize = new Blob([output]).size;
    const ratio = inputSize > 0 ? (outputSize / inputSize * 100).toFixed(1) : 0;

    const mode = document.querySelector('input[name="mode"]:checked').value;
    if (mode === 'encode') {
        document.getElementById('output-stats').textContent =
            `Input: ${inputSize} bytes | Output: ${outputSize} bytes | Expansion: ${ratio}%`;
    } else {
        document.getElementById('output-stats').textContent =
            `Input: ${inputSize} bytes | Output: ${outputSize} bytes | Reduction: ${(100 - parseFloat(ratio)).toFixed(1)}%`;
    }
}

function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    if (element.value) {
        navigator.clipboard.writeText(element.value).then(function() {
            // Show success feedback
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="bi bi-check"></i> Copied!';
            button.classList.remove('btn-outline-primary');
            button.classList.add('btn-success');

            setTimeout(function() {
                button.innerHTML = originalText;
                button.classList.remove('btn-success');
                button.classList.add('btn-outline-primary');
            }, 2000);
        });
    }
}

function downloadResult() {
    const content = document.getElementById('output-text').value;
    const mode = document.querySelector('input[name="mode"]:checked').value;

    if (content) {
        const blob = new Blob([content], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = mode === 'encode' ? 'encoded-base64.txt' : 'decoded-text.txt';
        a.click();
        URL.revokeObjectURL(url);
    }
}

// Handle Enter key
document.getElementById('input-text').addEventListener('keypress', function(e) {
    if (e.key === 'Enter' && e.ctrlKey) {
        processBase64();
    }
});

// Initialize
updateMode();
</script>
