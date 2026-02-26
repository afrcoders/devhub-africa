<form id="url-encode-form" method="POST" action="/tool/url-encode" class="needs-validation">
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
            <div class="mb-3">
                <label for="encode-type" class="form-label">Encoding Type</label>
                <select class="form-select" id="encode-type">
                    <option value="encode">Standard URL Encode (urlencode)</option>
                    <option value="encode_component" selected>Component Encode (rawurlencode)</option>
                </select>
            </div>
            <button type="button" class="btn btn-primary" onclick="encodeUrl()">
                <i class="bi bi-arrow-right me-2"></i>Encode
            </button>
        </div>

        <!-- Decode Tab -->
        <div class="tab-pane fade" id="decode-panel" role="tabpanel">
            <div class="mb-3">
                <label for="decode-input" class="form-label">URL-Encoded Text to Decode</label>
                <textarea
                    class="form-control"
                    id="decode-input"
                    rows="6"
                    placeholder="Paste encoded URL or text..."
                ></textarea>
            </div>
            <div class="mb-3">
                <label for="decode-type" class="form-label">Decoding Type</label>
                <select class="form-select" id="decode-type">
                    <option value="decode">Standard URL Decode (urldecode)</option>
                    <option value="decode_component" selected>Component Decode (rawurldecode)</option>
                </select>
            </div>
            <button type="button" class="btn btn-primary" onclick="decodeUrl()">
                <i class="bi bi-arrow-right me-2"></i>Decode
            </button>
        </div>
    </div>

    <!-- Output Section -->
    <div id="output-section" class="mt-4" style="display: none;">
        <label class="form-label">Output</label>
        <div class="output-box">
            <textarea id="url-output" class="form-control" rows="6" readonly></textarea>
            <div class="mt-2">
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="copyUrlToClipboard()">
                    <i class="bi bi-clipboard me-2"></i>Copy
                </button>
            </div>
        </div>
    </div>
</form>

<script>
function encodeUrl() {
    const input = document.getElementById('encode-input').value;
    const type = document.getElementById('encode-type').value;

    if (!input.trim()) {
        alert('Please enter text to encode');
        return;
    }

    fetch('/tool/url-encode', {
        method: 'POST',
        body: new URLSearchParams({
            text: input,
            operation: type,
            '_token': document.querySelector('meta[name="csrf-token"]').content
        }),
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('url-output').value = data.data.result;
            document.getElementById('output-section').style.display = 'block';
        } else {
            alert('Error: ' + data.message);
        }
    });
}

function decodeUrl() {
    const input = document.getElementById('decode-input').value;
    const type = document.getElementById('decode-type').value;

    if (!input.trim()) {
        alert('Please enter text to decode');
        return;
    }

    fetch('/tool/url-encode', {
        method: 'POST',
        body: new URLSearchParams({
            text: input,
            operation: type,
            '_token': document.querySelector('meta[name="csrf-token"]').content
        }),
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('url-output').value = data.data.result;
            document.getElementById('output-section').style.display = 'block';
        } else {
            alert('Error: ' + data.message);
        }
    });
}

function copyUrlToClipboard() {
    const textarea = document.getElementById('url-output');
    textarea.select();
    document.execCommand('copy');
    alert('Copied to clipboard!');
}
</script>

<style>
.output-box {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 1rem;
}

.output-box .form-control {
    border: none;
    background: white;
    padding: 0.75rem;
    margin-bottom: 0;
}
</style>
