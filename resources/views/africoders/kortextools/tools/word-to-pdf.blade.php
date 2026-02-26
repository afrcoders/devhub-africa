{{-- word to pdf --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    word to pdf tool for your development and productivity needs.
</div>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-file-word fa-3x text-primary"></i>
                </div>
                <h1 class="h2 mb-3">Word to PDF Converter</h1>
                <p class="lead text-muted">
                    Convert your Word documents (DOC, DOCX) to PDF format instantly
                </p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="word-to-pdf-form" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="file" class="form-label">
                                <i class="fas fa-upload me-2"></i>Select Word Document
                            </label>
                            <input
                                type="file"
                                class="form-control form-control-lg"
                                id="file"
                                name="file"
                                accept=".doc,.docx"
                                required
                            >
                            <small class="form-text text-muted">
                                Supported formats: DOC, DOCX (Maximum size: 20MB)
                            </small>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-exchange-alt me-2"></i>Convert to PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Results Section -->
            <div id="results-section" class="card shadow-sm mt-4" style="display: none;">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-info-circle text-info me-2"></i>Conversion Status</h5>
                </div>
                <div class="card-body">
                    <div id="conversion-result"></div>
                </div>
            </div>

            <!-- Features -->
            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-shield-alt fa-2x text-success mb-3"></i>
                            <h6>Secure Processing</h6>
                            <p class="text-muted small">Your files are processed securely</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-magic fa-2x text-warning mb-3"></i>
                            <h6>Format Preservation</h6>
                            <p class="text-muted small">Maintains original document formatting</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-bolt fa-2x text-info mb-3"></i>
                            <h6>Fast Conversion</h6>
                            <p class="text-muted small">Quick processing for all file sizes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('word-to-pdf-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;

    try {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Converting...';
        submitBtn.disabled = true;

        const formData = new FormData(this);
        const response = await fetch('{{ route("tools.kortex.tool.submit", "word-to-pdf") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const result = await response.json();

        if (result.success) {
            const data = result.data;
            document.getElementById('conversion-result').innerHTML = `
                <div class="alert alert-info">
                    <h6><i class="fas fa-clock me-2"></i>${result.message}</h6>
                    <ul class="mb-0">
                        <li><strong>File:</strong> ${data.original_name}</li>
                        <li><strong>Size:</strong> ${data.file_size}</li>
                        <li><strong>Type:</strong> ${data.file_type.toUpperCase()}</li>
                        <li><strong>Status:</strong> ${data.status}</li>
                    </ul>
                </div>
            `;
            document.getElementById('results-section').style.display = 'block';
            document.getElementById('results-section').scrollIntoView({ behavior: 'smooth' });
        } else {
            alert('Error: ' + (result.message || 'Conversion failed'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred during conversion');
    } finally {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
});
</script>

