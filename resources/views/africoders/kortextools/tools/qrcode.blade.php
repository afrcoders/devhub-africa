{{-- qrcode --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    qrcode tool for your development and productivity needs.
</div>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-qrcode fa-3x text-primary"></i>
                </div>
                <h1 class="h2 mb-3">QR Code Generator</h1>
                <p class="lead text-muted">
                    Generate QR codes from text, URLs, contact info, and more
                </p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="qrcode-form">
                        @csrf
                        <div class="mb-4">
                            <label for="text" class="form-label">
                                <i class="fas fa-edit me-2"></i>Text or URL
                            </label>
                            <textarea
                                class="form-control"
                                id="text"
                                name="text"
                                rows="4"
                                placeholder="Enter text, URL, or data for your QR code..."
                                required
                            ></textarea>
                            <small class="form-text text-muted">
                                Enter any text, URL, contact info, or data (max 2000 characters)
                            </small>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="size" class="form-label">Size (px)</label>
                                <select class="form-control" id="size" name="size">
                                    <option value="200">200x200</option>
                                    <option value="300" selected>300x300</option>
                                    <option value="400">400x400</option>
                                    <option value="500">500x500</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="error_correction" class="form-label">Error Correction</label>
                                <select class="form-control" id="error_correction" name="error_correction">
                                    <option value="L">Low (7%)</option>
                                    <option value="M" selected>Medium (15%)</option>
                                    <option value="Q">Quartile (25%)</option>
                                    <option value="H">High (30%)</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="format" class="form-label">Format</label>
                                <select class="form-control" id="format" name="format">
                                    <option value="PNG" selected>PNG</option>
                                    <option value="JPG">JPG</option>
                                    <option value="SVG">SVG</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-qrcode me-2"></i>Generate QR Code
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Results Section -->
            <div id="results-section" class="card shadow-sm mt-4" style="display: none;">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-check-circle text-success me-2"></i>Generated QR Code</h5>
                </div>
                <div class="card-body text-center">
                    <div id="qr-code-container" class="mb-4">
                        <img id="qr-code-image" src="" alt="Generated QR Code" class="img-fluid border rounded">
                    </div>
                    <div class="mb-3">
                        <p><strong>Text:</strong> <span id="qr-text"></span></p>
                        <p><strong>Size:</strong> <span id="qr-size"></span>px</p>
                    </div>
                    <div>
                        <a id="download-link" href="" download="qrcode.png" class="btn btn-success">
                            <i class="fas fa-download me-2"></i>Download QR Code
                        </a>
                        <button type="button" class="btn btn-outline-primary ms-2" onclick="copyQRToClipboard()">
                            <i class="fas fa-copy me-1"></i>Copy Image URL
                        </button>
                    </div>
                    <small class="text-muted d-block mt-2" id="download-instructions"></small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentQRUrl = '';

document.getElementById('qrcode-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;

    try {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Generating...';
        submitBtn.disabled = true;

        const formData = new FormData(this);
        const response = await fetch('{{ route("tools.kortex.tool.submit", "qrcode") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const result = await response.json();

        if (result.success) {
            const data = result.data;
            currentQRUrl = data.qr_code_url;

            document.getElementById('qr-code-image').src = currentQRUrl;
            document.getElementById('qr-text').textContent = data.text;
            document.getElementById('qr-size').textContent = data.size;
            document.getElementById('download-link').href = currentQRUrl;
            document.getElementById('download-instructions').textContent = data.download_instructions;

            document.getElementById('results-section').style.display = 'block';
            document.getElementById('results-section').scrollIntoView({ behavior: 'smooth' });
        } else {
            alert('Error: ' + (result.message || 'QR code generation failed'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while generating QR code');
    } finally {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
});

function copyQRToClipboard() {
    navigator.clipboard.writeText(currentQRUrl).then(() => {
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
        alert('Failed to copy URL to clipboard');
    });
}
</script>

