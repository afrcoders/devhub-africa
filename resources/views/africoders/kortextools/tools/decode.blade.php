{{-- URL/HTML Decoder --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-code me-2"></i>
    Decode URL-encoded and HTML-encoded strings back to readable text.
</div>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-unlock fa-3x text-primary"></i>
                </div>
                <h1 class="h2 mb-3">Base64 Decoder</h1>
                <p class="lead text-muted">
                    Decode Base64 encoded text back to its original format
                </p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="base64-decode-form">
                        @csrf
                        <div class="mb-4">
                            <label for="text" class="form-label">
                                <i class="fas fa-edit me-2"></i>Base64 Text to Decode
                            </label>
                            <textarea
                                class="form-control"
                                id="text"
                                name="text"
                                rows="6"
                                placeholder="Enter Base64 encoded text here..."
                                required
                            ></textarea>
                            <small class="form-text text-muted">
                                Paste the Base64 encoded text you want to decode
                            </small>
                        </div>

                        <div class="text-center mb-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-unlock me-2"></i>Decode Base64
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Results Section -->
            <div id="results-section" class="card shadow-sm mt-4" style="display: none;">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-check-circle text-success me-2"></i>Decoded Result</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Base64 Input:</h6>
                            <div class="border p-3 bg-light rounded" style="max-height: 200px; overflow-y: auto;">
                                <code id="original-text"></code>
                            </div>
                            <p class="text-muted mt-2 mb-0">Length: <span id="original-length"></span> characters</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Decoded Text:</h6>
                            <div class="border p-3 bg-light rounded" style="max-height: 200px; overflow-y: auto;">
                                <code id="decoded-text"></code>
                            </div>
                            <p class="text-muted mt-2 mb-0">Length: <span id="decoded-length"></span> characters</p>
                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="copyToClipboard('decoded-text')">
                                <i class="fas fa-copy me-1"></i>Copy Result
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('base64-decode-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;

    try {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Decoding...';
        submitBtn.disabled = true;

        const formData = new FormData(this);
        const response = await fetch('{{ route("tools.kortex.tool.submit", "decode") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const result = await response.json();

        if (result.success) {
            document.getElementById('original-text').textContent = result.data.original;
            document.getElementById('decoded-text').textContent = result.data.decoded;
            document.getElementById('original-length').textContent = result.data.original_length;
            document.getElementById('decoded-length').textContent = result.data.decoded_length;
            document.getElementById('results-section').style.display = 'block';
            document.getElementById('results-section').scrollIntoView({ behavior: 'smooth' });
        } else {
            alert('Error: ' + (result.message || 'Invalid Base64 input'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while decoding');
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

