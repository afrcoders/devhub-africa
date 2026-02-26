{{-- PNG to WebP Converter --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Convert PNG images to WebP format for better compression.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-image me-3"></i>PNG to WebP Converter
                </h1>
                <p class="lead text-muted">
                    Convert PNG images to WebP format with custom quality settings
                </p>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-upload me-2"></i>Upload Image</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="imageFile" class="form-label fw-semibold">Select PNG Image:</label>
                                <input type="file" class="form-control" id="imageFile" accept=".png,image/png">
                                <small class="text-muted">Max 50MB, PNG format only</small>
                            </div>

                            <div class="mb-3">
                                <label for="quality" class="form-label fw-semibold">WebP Quality:</label>
                                <input type="range" class="form-range" id="quality" min="1" max="100" value="80">
                                <small class="text-muted">Quality: <span id="qualityValue">80</span>%</small>
                            </div>

                            <div class="mb-3">
                                <label for="method" class="form-label fw-semibold">Compression Method:</label>
                                <select class="form-select" id="method">
                                    <option value="0">Fastest (method 0)</option>
                                    <option value="4" selected>Balanced (method 4)</option>
                                    <option value="6">Best Quality (method 6)</option>
                                </select>
                            </div>

                            <div id="preview" style="display: none; margin-bottom: 15px;">
                                <label class="form-label fw-semibold">Preview:</label>
                                <img id="previewImg" style="max-width: 100%; max-height: 200px; border-radius: 8px;">
                            </div>

                            <button type="button" id="convertBtn" class="btn btn-primary w-100" disabled>
                                <i class="fas fa-wand-magic-sparkles me-2"></i>Convert to WebP
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Results</h5>
                        </div>
                        <div class="card-body" id="results" style="max-height: 400px; overflow-y: auto;">
                            <p class="text-muted text-center">Upload a PNG image to convert</p>
                        </div>
                        <div class="card-footer" id="downloadFooter" style="display: none;">
                            <button type="button" id="downloadBtn" class="btn btn-success w-100">
                                <i class="fas fa-download me-2"></i>Download WebP
                            </button>
                        </div>
                    </div>

                    <div class="card shadow-sm mt-3">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Benefits</h5>
                        </div>
                        <div class="card-body" style="font-size: 14px;">
                            <ul class="mb-0">
                                <li><strong>Smaller file size:</strong> 25-35% smaller than PNG</li>
                                <li><strong>Better quality:</strong> Same visual quality at lower size</li>
                                <li><strong>Faster loading:</strong> Improved page speed</li>
                                <li><strong>Browser support:</strong> Modern browsers support WebP</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageFile = document.getElementById('imageFile');
    const quality = document.getElementById('quality');
    const qualityValue = document.getElementById('qualityValue');
    const method = document.getElementById('method');
    const convertBtn = document.getElementById('convertBtn');
    const results = document.getElementById('results');
    const preview = document.getElementById('preview');
    const previewImg = document.getElementById('previewImg');
    const downloadFooter = document.getElementById('downloadFooter');
    const downloadBtn = document.getElementById('downloadBtn');
    let selectedFile = null;
    let convertedBlob = null;

    quality.addEventListener('input', function() {
        qualityValue.textContent = this.value;
    });

    imageFile.addEventListener('change', function() {
        selectedFile = this.files[0];
        if (selectedFile) {
            if (selectedFile.type !== 'image/png') {
                alert('Please select a PNG image');
                selectedFile = null;
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(selectedFile);

            convertBtn.disabled = false;
        }
    });

    convertBtn.addEventListener('click', function() {
        if (!selectedFile) {
            alert('Please select a PNG image');
            return;
        }

        convertBtn.disabled = true;
        convertBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Converting...';
        results.innerHTML = '<p class="text-center text-muted">Converting image...</p>';
        downloadFooter.style.display = 'none';

        const formData = new FormData();
        formData.append('image', selectedFile);
        formData.append('quality', quality.value);
        formData.append('method', method.value);

        fetch('/api/convert/png-to-webp', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) throw new Error('Conversion failed');
            return response.blob();
        })
        .then(blob => {
            convertedBlob = blob;

            const originalSize = selectedFile.size;
            const newSize = blob.size;
            const reduction = ((originalSize - newSize) / originalSize * 100).toFixed(2);

            results.innerHTML = `
                <div class="alert alert-success">
                    <strong><i class="fas fa-check-circle me-2"></i>Conversion Successful!</strong>
                </div>
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="mb-2">
                            <strong>Original PNG:</strong>
                            <div style="font-size: 14px; color: #666;">
                                ${(originalSize / 1024).toFixed(2)} KB
                            </div>
                        </div>
                        <div class="mb-2">
                            <strong>Converted WebP:</strong>
                            <div style="font-size: 14px; color: #28a745;">
                                ${(newSize / 1024).toFixed(2)} KB
                            </div>
                        </div>
                        <div>
                            <strong>Size Reduction:</strong>
                            <div style="font-size: 14px; color: #007bff;">
                                ${reduction}%
                            </div>
                        </div>
                    </div>
                </div>
            `;

            downloadFooter.style.display = 'block';
        })
        .catch(error => {
            results.innerHTML = `
                <div class="alert alert-danger">
                    <strong>Error:</strong> ${error.message}
                </div>
            `;
            downloadFooter.style.display = 'none';
        })
        .finally(() => {
            convertBtn.disabled = false;
            convertBtn.innerHTML = '<i class="fas fa-wand-magic-sparkles me-2"></i>Convert to WebP';
        });
    });

    downloadBtn.addEventListener('click', function() {
        if (convertedBlob) {
            const url = URL.createObjectURL(convertedBlob);
            const link = document.createElement('a');
            link.href = url;
            link.download = selectedFile.name.replace('.png', '.webp');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
        }
    });
});
</script>
