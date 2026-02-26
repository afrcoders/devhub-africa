{{-- PNG to SVG Converter --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Convert PNG raster images to SVG vector format using tracing.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-image me-3"></i>PNG to SVG Converter
                </h1>
                <p class="lead text-muted">
                    Convert raster PNG images to scalable SVG vector format
                </p>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-upload me-2"></i>Upload PNG</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="imageFile" class="form-label fw-semibold">Select PNG Image:</label>
                                <input type="file" class="form-control" id="imageFile" accept=".png,image/png">
                                <small class="text-muted">Max 10MB, PNG format only</small>
                            </div>

                            <div class="mb-3">
                                <label for="colors" class="form-label fw-semibold">Color Depth:</label>
                                <select class="form-select" id="colors">
                                    <option value="2">2 Colors (B&W)</option>
                                    <option value="4">4 Colors</option>
                                    <option value="8" selected>8 Colors</option>
                                    <option value="16">16 Colors</option>
                                    <option value="32">32 Colors</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="threshold" class="form-label fw-semibold">Color Threshold:</label>
                                <input type="range" class="form-range" id="threshold" min="10" max="500" value="128">
                                <small class="text-muted">Threshold: <span id="thresholdValue">128</span></small>
                            </div>

                            <div id="preview" style="display: none; margin-bottom: 15px;">
                                <label class="form-label fw-semibold">Preview:</label>
                                <img id="previewImg" style="max-width: 100%; max-height: 200px; border-radius: 8px;">
                            </div>

                            <button type="button" id="convertBtn" class="btn btn-primary w-100" disabled>
                                <i class="fas fa-wand-magic-sparkles me-2"></i>Convert to SVG
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
                                <i class="fas fa-download me-2"></i>Download SVG
                            </button>
                        </div>
                    </div>

                    <div class="card shadow-sm mt-3">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Benefits</h5>
                        </div>
                        <div class="card-body" style="font-size: 14px;">
                            <ul class="mb-0">
                                <li><strong>Scalable:</strong> SVG images scale without quality loss</li>
                                <li><strong>Editable:</strong> Modify vectors in any editor</li>
                                <li><strong>Smaller file size:</strong> For simple graphics</li>
                                <li><strong>Responsive:</strong> Perfect for logos and icons</li>
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
    const colors = document.getElementById('colors');
    const threshold = document.getElementById('threshold');
    const thresholdValue = document.getElementById('thresholdValue');
    const convertBtn = document.getElementById('convertBtn');
    const results = document.getElementById('results');
    const preview = document.getElementById('preview');
    const previewImg = document.getElementById('previewImg');
    const downloadFooter = document.getElementById('downloadFooter');
    const downloadBtn = document.getElementById('downloadBtn');
    let selectedFile = null;
    let convertedBlob = null;

    threshold.addEventListener('input', function() {
        thresholdValue.textContent = this.value;
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
        results.innerHTML = '<p class="text-center text-muted">Tracing image to SVG...</p>';
        downloadFooter.style.display = 'none';

        const formData = new FormData();
        formData.append('image', selectedFile);
        formData.append('colors', colors.value);
        formData.append('threshold', threshold.value);

        fetch('/api/convert/png-to-svg', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) throw new Error('Conversion failed');
            return response.blob();
        })
        .then(blob => {
            convertedBlob = blob;

            results.innerHTML = `
                <div class="alert alert-success">
                    <strong><i class="fas fa-check-circle me-2"></i>Conversion Successful!</strong>
                </div>
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="mb-2">
                            <strong>Original PNG:</strong>
                            <div style="font-size: 14px; color: #666;">
                                ${(selectedFile.size / 1024).toFixed(2)} KB
                            </div>
                        </div>
                        <div>
                            <strong>SVG Vector:</strong>
                            <div style="font-size: 14px; color: #28a745;">
                                ${(blob.size / 1024).toFixed(2)} KB
                            </div>
                        </div>
                    </div>
                </div>
                <div class="alert alert-info mt-2 mb-0">
                    <small>SVG is now scalable without quality loss. Perfect for logos, icons, and illustrations.</small>
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
            convertBtn.innerHTML = '<i class="fas fa-wand-magic-sparkles me-2"></i>Convert to SVG';
        });
    });

    downloadBtn.addEventListener('click', function() {
        if (convertedBlob) {
            const url = URL.createObjectURL(convertedBlob);
            const link = document.createElement('a');
            link.href = url;
            link.download = selectedFile.name.replace('.png', '.svg');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
        }
    });
});
</script>
