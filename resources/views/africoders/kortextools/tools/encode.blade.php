{{-- Base64 Encoder --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-code me-2"></i>
    Encode text and files to Base64 format quickly and securely.
</div>>
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-code fa-3x text-primary"></i>
                </div>
                <h1 class="h2 mb-3">Base64 Encoder</h1>
                <p class="lead text-muted">
                    Convert text and data to Base64 encoded format for safe transmission
                </p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="base64-encode-form">
                        @csrf
                        <div class="mb-4">
                            <label for="text" class="form-label">
                                <i class="fas fa-edit me-2"></i>Text to Encode
                            </label>
                            <textarea
                                class="form-control"
                                id="text"
                                name="text"
                                rows="6"
                                placeholder="Enter your text here..."
                                required
                            ></textarea>
                            <small class="form-text text-muted">
                                Enter the text you want to encode to Base64 format
                            </small>
                        </div>

                        <div class="text-center mb-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-code me-2"></i>Encode to Base64
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Results Section -->
            <div id="results-section" class="card shadow-sm mt-4" style="display: none;">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-check-circle text-success me-2"></i>Encoded Result</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Original Text:</h6>
                            <div class="border p-3 bg-light rounded" style="max-height: 200px; overflow-y: auto;">
                                <code id="original-text"></code>
                            </div>
                            <p class="text-muted mt-2 mb-0">Length: <span id="original-length"></span> characters</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Base64 Encoded:</h6>
                            <div class="border p-3 bg-light rounded" style="max-height: 200px; overflow-y: auto;">
                                <code id="encoded-text"></code>
                            </div>
                            <p class="text-muted mt-2 mb-0">Length: <span id="encoded-length"></span> characters</p>
                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="copyToClipboard('encoded-text')">
                                <i class="fas fa-copy me-1"></i>Copy Result
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tool Information -->
            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-shield-alt fa-2x text-success mb-3"></i>
                            <h6>Secure Encoding</h6>
                            <p class="text-muted small">Base64 encoding is safe and reversible</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-bolt fa-2x text-warning mb-3"></i>
                            <h6>Fast Processing</h6>
                            <p class="text-muted small">Instant encoding for any text size</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-download fa-2x text-info mb-3"></i>
                            <h6>Copy & Use</h6>
                            <p class="text-muted small">Easily copy encoded result to clipboard</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('base64-encode-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;

    try {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Encoding...';
        submitBtn.disabled = true;

        const formData = new FormData(this);
        const response = await fetch('{{ route("tools.kortex.tool.submit", "encode") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const result = await response.json();

        if (result.success) {
            document.getElementById('original-text').textContent = result.data.original;
            document.getElementById('encoded-text').textContent = result.data.encoded;
            document.getElementById('original-length').textContent = result.data.original_length;
            document.getElementById('encoded-length').textContent = result.data.encoded_length;
            document.getElementById('results-section').style.display = 'block';
            document.getElementById('results-section').scrollIntoView({ behavior: 'smooth' });
        } else {
            alert('Error: ' + (result.message || 'Something went wrong'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while encoding');
    } finally {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
});

function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    const text = element.textContent;

    navigator.clipboard.writeText(text).then(() => {
        const btn = event.target.closest('button');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check me-1"></i>Copied!';
        btn.classList.remove('btn-outline-primary');
        btn.classList.add('btn-success');

        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-primary');
        }, 2000);
    }).catch(() => {
        alert('Failed to copy to clipboard');
    });
}
</script>
