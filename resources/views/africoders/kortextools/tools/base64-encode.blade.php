<form id="base64-form" method="POST" action="/tool/base64-encode" class="needs-validation">
    @csrf

    <!-- Input Tabs -->
    <ul class="nav nav-tabs mb-3" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="encode-tab" data-bs-toggle="tab" data-bs-target="#encode-panel" type="button" role="tab">
                <i class="bi bi-lock me-2"></i>Encode
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="decode-tab" data-bs-toggle="tab" data-bs-target="#decode-panel" type="button" role="tab">
                <i class="bi bi-unlock me-2"></i>Decode
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Encode Tab -->
        <div class="tab-pane fade show active" id="encode-panel" role="tabpanel">
            <div class="mb-3">
                <label for="encode-input" class="form-label">Text to Encode</label>
                <textarea
                    class="form-control"
                    id="encode-input"
                    rows="6"
                    placeholder="Enter text to encode..."
                ></textarea>
            </div>
            <button type="button" class="btn btn-primary" onclick="encodeBase64()">
                <i class="bi bi-arrow-right me-2"></i>Encode
            </button>
        </div>

        <!-- Decode Tab -->
        <div class="tab-pane fade" id="decode-panel" role="tabpanel">
            <div class="mb-3">
                <label for="decode-input" class="form-label">Base64 to Decode</label>
                <textarea
                    class="form-control"
                    id="decode-input"
                    rows="6"
                    placeholder="Paste Base64 encoded text..."
                ></textarea>
            </div>
            <button type="button" class="btn btn-primary" onclick="decodeBase64()">
                <i class="bi bi-arrow-right me-2"></i>Decode
            </button>
        </div>
    </div>

    <!-- Output Section -->
    <div id="output-section" class="mt-4" style="display: none;">
        <label class="form-label">Output</label>
        <div class="output-box">
            <pre id="base64-output"></pre>
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="copyToClipboard('base64-output')">
                <i class="bi bi-clipboard me-2"></i>Copy
            </button>
        </div>
    </div>
</form>

<script>
function encodeBase64() {
    const input = document.getElementById('encode-input').value;
    if (!input.trim()) {
        alert('Please enter text to encode');
        return;
    }
    try {
        const encoded = btoa(unescape(encodeURIComponent(input)));
        document.getElementById('base64-output').textContent = encoded;
        document.getElementById('output-section').style.display = 'block';
    } catch (error) {
        alert('Error encoding: ' + error.message);
    }
}

function decodeBase64() {
    const input = document.getElementById('decode-input').value;
    if (!input.trim()) {
        alert('Please enter Base64 text to decode');
        return;
    }
    try {
        const decoded = decodeURIComponent(escape(atob(input)));
        document.getElementById('base64-output').textContent = decoded;
        document.getElementById('output-section').style.display = 'block';
    } catch (error) {
        alert('Error decoding: Invalid Base64');
    }
}

function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    const text = element.textContent;
    navigator.clipboard.writeText(text).then(() => {
        alert('Copied to clipboard!');
    });
}
</script>

<style>
.output-box {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 1rem;
    position: relative;
}

.output-box pre {
    margin-bottom: 0;
    max-height: 300px;
    overflow-y: auto;
    font-size: 0.875rem;
}
</style>
