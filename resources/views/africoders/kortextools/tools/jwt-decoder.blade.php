<form id="jwt-decoder-form" method="POST" action="/tool/jwt-decoder" class="needs-validation">
    @csrf

    <!-- JWT Token Input -->
    <div class="mb-3">
        <label for="jwt-token" class="form-label">
            <i class="bi bi-shield-lock me-2"></i>JWT Token
        </label>
        <textarea
            class="form-control @error('token') is-invalid @enderror"
            id="jwt-token"
            name="token"
            rows="4"
            placeholder="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIn0..."
            required
        ></textarea>
        @error('token')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
        <small class="form-text text-muted d-block mt-2">
            Paste your JWT token. It should have 3 parts separated by dots (header.payload.signature)
        </small>
    </div>

    <!-- Output Section -->
    <div id="jwt-output-section" class="mt-4" style="display: none;">
        <label class="form-label">Decoded Token</label>

        <!-- Header -->
        <div class="output-box mb-3">
            <h6 class="text-muted mb-3">
                <i class="bi bi-card-heading me-2"></i>Header
            </h6>
            <pre id="jwt-header" class="json-output"></pre>
        </div>

        <!-- Payload -->
        <div class="output-box mb-3">
            <h6 class="text-muted mb-3">
                <i class="bi bi-box me-2"></i>Payload
            </h6>
            <pre id="jwt-payload" class="json-output"></pre>
        </div>

        <!-- Signature -->
        <div class="output-box mb-3">
            <h6 class="text-muted mb-3">
                <i class="bi bi-pencil me-2"></i>Signature
            </h6>
            <code id="jwt-signature" class="signature-output"></code>
        </div>

        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="copyJwtResult()">
            <i class="bi bi-clipboard me-2"></i>Copy All
        </button>
    </div>

    <!-- Action Buttons -->
    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
        <button
            type="reset"
            class="btn btn-secondary"
            onclick="document.getElementById('jwt-output-section').style.display='none'"
        >
            <i class="bi bi-arrow-clockwise me-2"></i>Clear
        </button>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-lock-open me-2"></i>Decode JWT
        </button>
    </div>
</form>

<script>
document.getElementById('jwt-decoder-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const token = document.getElementById('jwt-token').value.trim();

    if (!token) {
        alert('Please enter a JWT token');
        return;
    }

    try {
        const response = await fetch('/tool/jwt-decoder', {
            method: 'POST',
            body: new FormData(this),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const data = await response.json();

        if (data.success) {
            displayJwtResult(data.data);
        } else {
            alert('Error: ' + (data.message || 'Failed to decode JWT'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred');
    }
});

function displayJwtResult(data) {
    document.getElementById('jwt-header').textContent = JSON.stringify(data.header, null, 2);
    document.getElementById('jwt-payload').textContent = JSON.stringify(data.payload, null, 2);
    document.getElementById('jwt-signature').textContent = data.signature;
    document.getElementById('jwt-output-section').style.display = 'block';
}

function copyJwtResult() {
    const header = JSON.stringify(document.querySelector('#jwt-header').textContent);
    const payload = JSON.stringify(document.querySelector('#jwt-payload').textContent);
    const signature = document.getElementById('jwt-signature').textContent;

    const text = `Header:\n${header}\n\nPayload:\n${payload}\n\nSignature:\n${signature}`;
    navigator.clipboard.writeText(text);
    alert('JWT data copied!');
}
</script>

<style>
.output-box {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 1rem;
}

.json-output {
    background-color: #fff;
    padding: 0.75rem;
    border-radius: 0.375rem;
    font-size: 0.85rem;
    overflow-x: auto;
    margin-bottom: 0;
}

.signature-output {
    background-color: #fff;
    padding: 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.85rem;
    display: block;
    word-break: break-all;
}
</style>
