{{-- SVG to PNG Converter --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Convert SVG vector images to PNG raster format.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-image me-3"></i>SVG to PNG Converter
                </h1>
                <p class="lead text-muted">
                    Convert SVG vector images to PNG raster format
                </p>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-upload me-2"></i>Upload SVG</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="svgFile" class="form-label fw-semibold">Select SVG Image:</label>
                                <input type="file" class="form-control" id="svgFile" accept=".svg,image/svg+xml">
                                <small class="text-muted">Max 10MB, SVG format only</small>
                            </div>

                            <div class="mb-3">
                                <label for="width" class="form-label fw-semibold">Width (pixels):</label>
                                <input type="number" class="form-control" id="width" value="800" min="100" max="4000">
                            </div>

                            <div class="mb-3">
                                <label for="height" class="form-label fw-semibold">Height (pixels):</label>
                                <input type="number" class="form-control" id="height" value="600" min="100" max="4000">
                            </div>

                            <div id="preview" style="display: none; margin-bottom: 15px;">
                                <label class="form-label fw-semibold">Preview:</label>
                                <img id="previewImg" style="max-width: 100%; max-height: 200px; border-radius: 8px;">
                            </div>

                            <button type="button" id="convertBtn" class="btn btn-primary w-100" disabled>
                                <i class="fas fa-wand-magic-sparkles me-2"></i>Convert to PNG
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
                            <p class="text-muted text-center">Upload an SVG image to convert</p>
                        </div>
                        <div class="card-footer" id="downloadFooter" style="display: none;">
                            <button type="button" id="downloadBtn" class="btn btn-success w-100">
                                <i class="fas fa-download me-2"></i>Download PNG
                            </button>
                        </div>
                    </div>

                    <div class="card shadow-sm mt-3">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Use Cases</h5>
                        </div>
                        <div class="card-body" style="font-size: 14px;">
                            <ul class="mb-0">
                                <li>Export logos to PNG format</li>
                                <li>Create previews for web design</li>
                                <li>Generate social media images</li>
                                <li>Export graphics for presentations</li>
                                <li>Create screenshots of vector art</li>
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
    const svgFile = document.getElementById('svgFile');
    const width = document.getElementById('width');
    const height = document.getElementById('height');
    const convertBtn = document.getElementById('convertBtn');
    const results = document.getElementById('results');
    const preview = document.getElementById('preview');
    const previewImg = document.getElementById('previewImg');
    const downloadFooter = document.getElementById('downloadFooter');
    const downloadBtn = document.getElementById('downloadBtn');
    let selectedFile = null;
    let convertedBlob = null;

    svgFile.addEventListener('change', function() {
        selectedFile = this.files[0];
        if (selectedFile) {
            if (!selectedFile.type.includes('svg')) {
                alert('Please select an SVG image');
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
            alert('Please select an SVG image');
            return;
        }

        convertBtn.disabled = true;
        convertBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Converting...';
        results.innerHTML = '<p class="text-center text-muted">Converting image...</p>';
        downloadFooter.style.display = 'none';

        const formData = new FormData();
        formData.append('image', selectedFile);
        formData.append('width', width.value);
        formData.append('height', height.value);

        fetch('/api/convert/svg-to-png', {
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
                            <strong>Output Dimensions:</strong>
                            <div style="font-size: 14px; color: #666;">
                                ${width.value} × ${height.value} pixels
                            </div>
                        </div>
                        <div>
                            <strong>File Size:</strong>
                            <div style="font-size: 14px; color: #28a745;">
                                ${(blob.size / 1024).toFixed(2)} KB
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
            convertBtn.innerHTML = '<i class="fas fa-wand-magic-sparkles me-2"></i>Convert to PNG';
        });
    });

    downloadBtn.addEventListener('click', function() {
        if (convertedBlob) {
            const url = URL.createObjectURL(convertedBlob);
            const link = document.createElement('a');
            link.href = url;
            link.download = selectedFile.name.replace('.svg', '.png');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
        }
    });
});
</script>
