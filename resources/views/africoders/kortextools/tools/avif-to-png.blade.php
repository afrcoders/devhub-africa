{{-- AVIF to PNG Converter --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-exchange-alt me-2"></i>
    Convert AVIF image files to PNG format while maintaining image quality and preserving transparency.
</div>

<div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-exchange-alt me-2"></i>
                        {{ $tool->name }}
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">{{ $tool->description }}</p>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="fileInput" class="form-label">Select AVIF File</label>
                                <input type="file" class="form-control" id="fileInput" accept=".avif">
                                <div class="form-text">Choose an AVIF image file to convert to PNG format</div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-primary" id="convertBtn" disabled>
                                    <i class="fas fa-magic me-2"></i>Convert to PNG
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="resultSection" class="mt-4" style="display: none;">
                        <hr>
                        <h5>Converted Image:</h5>
                        <div id="resultContainer"></div>
                        <button type="button" class="btn btn-success mt-3" id="downloadBtn">
                            <i class="fas fa-download me-2"></i>Download PNG
                        </button>
                    </div>
                </div>
</div>

<script>
const fileInput = document.getElementById('fileInput');
const convertBtn = document.getElementById('convertBtn');
const resultSection = document.getElementById('resultSection');
const resultContainer = document.getElementById('resultContainer');
const downloadBtn = document.getElementById('downloadBtn');

let convertedBlob = null;

// Enable convert button when file is selected
fileInput.addEventListener('change', function() {
    convertBtn.disabled = !this.files.length;
});

// Convert AVIF to PNG
convertBtn.addEventListener('click', function() {
    const file = fileInput.files[0];
    if (!file) return;

    this.disabled = true;
    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Converting...';

    const reader = new FileReader();
    reader.onload = function(e) {
        const img = new Image();
        img.onload = function() {
            // Create canvas for conversion
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            canvas.width = img.width;
            canvas.height = img.height;

            // Draw image on canvas with transparency support
            ctx.drawImage(img, 0, 0);

            // Convert to PNG
            canvas.toBlob(function(blob) {
                convertedBlob = blob;

                // Display result
                const imgElement = document.createElement('img');
                imgElement.src = URL.createObjectURL(blob);
                imgElement.className = 'img-fluid border';
                imgElement.style.maxHeight = '300px';

                resultContainer.innerHTML = '';
                resultContainer.appendChild(imgElement);
                resultSection.style.display = 'block';

                // Re-enable button
                convertBtn.disabled = false;
                convertBtn.innerHTML = '<i class="fas fa-magic me-2"></i>Convert to PNG';
            }, 'image/png');
        };

        img.onerror = function() {
            alert('Error loading image. Please make sure it\'s a valid AVIF file.');
            convertBtn.disabled = false;
            convertBtn.innerHTML = '<i class="fas fa-magic me-2"></i>Convert to PNG';
        };

        img.src = e.target.result;
    };

    reader.readAsDataURL(file);
});

// Download converted image
downloadBtn.addEventListener('click', function() {
    if (!convertedBlob) return;

    const url = URL.createObjectURL(convertedBlob);
    const a = document.createElement('a');
    a.href = url;
    a.download = fileInput.files[0].name.replace(/\.[^/.]+$/, '') + '.png';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
});
</script>
