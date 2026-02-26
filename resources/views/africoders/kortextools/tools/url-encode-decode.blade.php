<div class="row">
    <div class="col-md-12">
        <!-- Mode Selection -->
        <div class="mb-4">
            <div class="btn-group w-100" role="group" aria-label="Mode selection">
                <input type="radio" class="btn-check" name="mode" id="encode-mode" value="encode" checked>
                <label class="btn btn-outline-primary" for="encode-mode">
                    <i class="bi bi-lock"></i> URL Encode
                </label>

                <input type="radio" class="btn-check" name="mode" id="decode-mode" value="decode">
                <label class="btn btn-outline-primary" for="decode-mode">
                    <i class="bi bi-unlock"></i> URL Decode
                </label>
            </div>
        </div>

        <!-- Input Section -->
        <div class="mb-4">
            <label for="input-text" class="form-label" id="input-label">Enter text to URL encode:</label>
            <textarea
                class="form-control"
                id="input-text"
                rows="6"
                placeholder="Type or paste your text here..."
            ></textarea>
            <div class="form-text">
                <small class="text-muted" id="input-help">Enter text to convert special characters to URL-safe format.</small>
            </div>
        </div>

        <!-- Options -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="encode-spaces-plus" checked>
                    <label class="form-check-label" for="encode-spaces-plus">
                        Encode spaces as + (application/x-www-form-urlencoded)
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="encode-all-chars">
                    <label class="form-check-label" for="encode-all-chars">
                        Encode all non-alphanumeric characters
                    </label>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="mb-3">
            <button type="button" class="btn btn-primary" onclick="processURL()">
                <i class="bi bi-arrow-right" id="action-icon"></i> <span id="action-text">URL Encode</span>
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
            <label for="output-text" class="form-label" id="output-label">URL encoded result:</label>
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

        <!-- Character Reference Table -->
        <div class="mt-4">
            <h6>Common URL Encoded Characters:</h6>
            <div class="row">
                <div class="col-md-6">
                    <div class="character-table">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr><th>Character</th><th>Encoded</th></tr>
                                </thead>
                                <tbody>
                                    <tr><td>Space</td><td>%20 or +</td></tr>
                                    <tr><td>!</td><td>%21</td></tr>
                                    <tr><td>"</td><td>%22</td></tr>
                                    <tr><td>#</td><td>%23</td></tr>
                                    <tr><td>$</td><td>%24</td></tr>
                                    <tr><td>%</td><td>%25</td></tr>
                                    <tr><td>&</td><td>%26</td></tr>
                                    <tr><td>'</td><td>%27</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="character-table">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr><th>Character</th><th>Encoded</th></tr>
                                </thead>
                                <tbody>
                                    <tr><td>(</td><td>%28</td></tr>
                                    <tr><td>)</td><td>%29</td></tr>
                                    <tr><td>*</td><td>%2A</td></tr>
                                    <tr><td>+</td><td>%2B</td></tr>
                                    <tr><td>,</td><td>%2C</td></tr>
                                    <tr><td>/</td><td>%2F</td></tr>
                                    <tr><td>:</td><td>%3A</td></tr>
                                    <tr><td>?</td><td>%3F</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Examples -->
        <div class="mt-4">
            <h6>Quick Examples:</h6>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('Hello World!')">
                    "Hello World!"
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('email@domain.com?subject=Test&body=Hello!')">
                    Email with params
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('https://example.com/path?query=value&another=test')">
                    Full URL
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('Special chars: @#$%^&*()')">
                    Special characters
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Information -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> About URL Encoding</h6>
    <p class="mb-0">
        URL encoding (percent encoding) is used to encode special characters in URLs. Characters that have special meaning
        in URLs or are not printable ASCII characters are converted to their percent-encoded representation (%XX).
        This ensures URLs are transmitted correctly across different systems and protocols.
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
.character-table {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
}
.character-table .table {
    margin-bottom: 0;
    font-size: 0.9rem;
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

    document.getElementById('input-label').textContent = isEncode ? 'Enter text to URL encode:' : 'Enter URL encoded text to decode:';
    document.getElementById('input-help').textContent = isEncode ?
        'Enter text to convert special characters to URL-safe format.' :
        'Enter URL encoded text to decode back to original format.';
    document.getElementById('action-text').textContent = isEncode ? 'URL Encode' : 'URL Decode';
    document.getElementById('action-icon').className = isEncode ? 'bi bi-lock' : 'bi bi-unlock';

    // Clear output when mode changes
    document.getElementById('output-section').style.display = 'none';
    document.getElementById('output-text').value = '';
}

function processURL() {
    const inputText = document.getElementById('input-text').value;
    const mode = document.querySelector('input[name="mode"]:checked').value;
    const encodeSpacesPlus = document.getElementById('encode-spaces-plus').checked;
    const encodeAllChars = document.getElementById('encode-all-chars').checked;

    if (!inputText.trim()) {
        alert('Please enter some text to process.');
        return;
    }

    try {
        let result = '';

        if (mode === 'encode') {
            if (encodeAllChars) {
                // Encode all non-alphanumeric characters
                result = inputText.replace(/[^A-Za-z0-9]/g, function(char) {
                    const code = char.charCodeAt(0);
                    if (code <= 0xFF) {
                        return '%' + code.toString(16).toUpperCase().padStart(2, '0');
                    } else {
                        // Handle Unicode characters
                        return encodeURIComponent(char);
                    }
                });
            } else {
                // Standard URL encoding
                result = encodeURIComponent(inputText);

                // Convert %20 to + if option is selected
                if (encodeSpacesPlus) {
                    result = result.replace(/%20/g, '+');
                }
            }

            document.getElementById('output-label').textContent = 'URL encoded result:';
        } else {
            // Decode URL encoding
            let urlInput = inputText;

            // Convert + to %20 if needed
            if (encodeSpacesPlus) {
                urlInput = urlInput.replace(/\+/g, '%20');
            }

            result = decodeURIComponent(urlInput);
            document.getElementById('output-label').textContent = 'URL decoded result:';
        }

        document.getElementById('output-text').value = result;
        document.getElementById('output-section').style.display = 'block';

        // Update stats
        updateStats(inputText, result);

    } catch (error) {
        alert('Error processing URL encoding: ' + error.message + '\\nPlease check your input format.');
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
    processURL();
}

function updateStats(input, output) {
    const inputSize = new Blob([input]).size;
    const outputSize = new Blob([output]).size;
    const encodedChars = (output.match(/%[0-9A-F]{2}/g) || []).length;

    const mode = document.querySelector('input[name="mode"]:checked').value;
    if (mode === 'encode') {
        document.getElementById('output-stats').textContent =
            `Input: ${inputSize} bytes | Output: ${outputSize} bytes | Encoded characters: ${encodedChars}`;
    } else {
        document.getElementById('output-stats').textContent =
            `Input: ${inputSize} bytes | Output: ${outputSize} bytes | Decoded characters: ${inputSize - outputSize + encodedChars}`;
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
        a.download = mode === 'encode' ? 'url-encoded.txt' : 'url-decoded.txt';
        a.click();
        URL.revokeObjectURL(url);
    }
}

// Handle Enter key
document.getElementById('input-text').addEventListener('keypress', function(e) {
    if (e.key === 'Enter' && e.ctrlKey) {
        processURL();
    }
});

// Initialize
updateMode();
</script>
