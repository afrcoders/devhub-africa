{{-- Hash Generator --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-hashtag me-2"></i>
    Generate MD5, SHA256, SHA512, and CRC32 hashes from text input.
</div>
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-fingerprint fa-3x text-primary"></i>
                </div>
                <h1 class="h2 mb-3">Hash Generator</h1>
                <p class="lead text-muted">
                    Generate MD5, SHA256, SHA512, and CRC32 hashes from your text
                </p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="hash-form">
                        @csrf
                        <div class="mb-4">
                            <label for="text" class="form-label">
                                <i class="fas fa-edit me-2"></i>Text to Hash
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
                                Enter any text to generate multiple hash formats
                            </small>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-fingerprint me-2"></i>Generate Hashes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Results Section -->
            <div id="results-section" class="card shadow-sm mt-4" style="display: none;">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-check-circle text-success me-2"></i>Generated Hashes</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Input text length: <span id="input-length"></span> characters</small>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <h6>MD5:</h6>
                            <div class="input-group">
                                <input type="text" class="form-control font-monospace" id="md5-hash" readonly>
                                <button class="btn btn-outline-secondary" type="button" onclick="copyHash('md5-hash')">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>SHA1:</h6>
                            <div class="input-group">
                                <input type="text" class="form-control font-monospace" id="sha1-hash" readonly>
                                <button class="btn btn-outline-secondary" type="button" onclick="copyHash('sha1-hash')">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>SHA256:</h6>
                            <div class="input-group">
                                <input type="text" class="form-control font-monospace" id="sha256-hash" readonly>
                                <button class="btn btn-outline-secondary" type="button" onclick="copyHash('sha256-hash')">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>SHA512:</h6>
                            <div class="input-group">
                                <input type="text" class="form-control font-monospace" id="sha512-hash" readonly>
                                <button class="btn btn-outline-secondary" type="button" onclick="copyHash('sha512-hash')">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>CRC32:</h6>
                            <div class="input-group">
                                <input type="text" class="form-control font-monospace" id="crc32-hash" readonly>
                                <button class="btn btn-outline-secondary" type="button" onclick="copyHash('crc32-hash')">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('hash-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;

    try {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Generating...';
        submitBtn.disabled = true;

        const formData = new FormData(this);
        const response = await fetch('{{ route("tools.kortex.tool.submit", "hash") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const result = await response.json();

        if (result.success) {
            const data = result.data;
            const hashes = data.hashes;

            document.getElementById('input-length').textContent = data.length;
            document.getElementById('md5-hash').value = hashes.md5;
            document.getElementById('sha1-hash').value = hashes.sha1;
            document.getElementById('sha256-hash').value = hashes.sha256;
            document.getElementById('sha512-hash').value = hashes.sha512;
            document.getElementById('crc32-hash').value = hashes.crc32;

            document.getElementById('results-section').style.display = 'block';
            document.getElementById('results-section').scrollIntoView({ behavior: 'smooth' });
        } else {
            alert('Error: ' + (result.message || 'Hash generation failed'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while generating hashes');
    } finally {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
});

function copyHash(hashId) {
    const input = document.getElementById(hashId);
    input.select();
    document.execCommand('copy');

    const btn = event.target.closest('button');
    const icon = btn.querySelector('i');
    const originalClass = icon.className;

    icon.className = 'fas fa-check text-success';

    setTimeout(() => {
        icon.className = originalClass;
    }, 2000);
}
</script>
