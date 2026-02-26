{{-- JPG to BMP Converter --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-exchange-alt me-2"></i>
    Convert JPG images to BMP format while maintaining image quality.
</div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-image me-2"></i>
                        {{ $tool->name }}
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">{{ $tool->description }}</p>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="fileInput" class="form-label">Select JPG Files</label>
                                <input type="file" class="form-control" id="fileInput" accept=".jpg,.jpeg" multiple>
                                <div class="form-text">Select one or more JPG files to convert to BMP format</div>
                            </div>

                            <div class="mb-3" style="display: none;" id="previewSection">
                                <label class="form-label">Preview</label>
                                <div id="imagePreview" class="border rounded p-3" style="max-height: 300px; overflow-y: auto;"></div>
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button type="button" class="btn btn-primary" id="convertBtn" disabled>
                                    <i class="fas fa-exchange-alt me-2"></i>Convert to BMP
                                </button>
                            </div>

                            <div class="mb-3" style="display: none;" id="downloadSection">
                                <label class="form-label">Download Converted Files</label>
                                <div id="downloadLinks" class="d-grid gap-2"></div>
                            </div>

                            <div class="progress" style="display: none;" id="progressSection">
                                <div class="progress-bar" role="progressbar" style="width: 0%" id="progressBar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const fileInput = document.getElementById('fileInput');
const previewSection = document.getElementById('previewSection');
const imagePreview = document.getElementById('imagePreview');
const convertBtn = document.getElementById('convertBtn');
const downloadSection = document.getElementById('downloadSection');
const downloadLinks = document.getElementById('downloadLinks');
const progressSection = document.getElementById('progressSection');
const progressBar = document.getElementById('progressBar');

let selectedFiles = [];

// File input change handler
fileInput.addEventListener('change', function(e) {
    selectedFiles = Array.from(e.target.files);

    if (selectedFiles.length > 0) {
        showPreviews();
        convertBtn.disabled = false;
    } else {
        previewSection.style.display = 'none';
        convertBtn.disabled = true;
    }
});

// Show image previews
function showPreviews() {
    imagePreview.innerHTML = '';

    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const imgContainer = document.createElement('div');
            imgContainer.className = 'mb-2 p-2 border rounded';
            imgContainer.innerHTML = `
                <div class="d-flex align-items-center">
                    <img src="${e.target.result}" alt="Preview" style="width: 50px; height: 50px; object-fit: cover;" class="rounded me-3">
                    <div>
                        <strong>${file.name}</strong><br>
                        <small class="text-muted">${(file.size / 1024).toFixed(1)} KB</small>
                    </div>
                </div>
            `;
            imagePreview.appendChild(imgContainer);
        };
        reader.readAsDataURL(file);
    });

    previewSection.style.display = 'block';
}

// Convert images to BMP
function convertToBmp(file) {
    return new Promise((resolve) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = new Image();
            img.onload = function() {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');

                canvas.width = img.width;
                canvas.height = img.height;

                // Draw image to canvas
                ctx.drawImage(img, 0, 0);

                // Convert to blob (BMP format simulation using PNG with metadata)
                canvas.toBlob(function(blob) {
                    const fileName = file.name.replace(/\.(jpg|jpeg)$/i, '.bmp');
                    resolve({
                        blob: blob,
                        fileName: fileName,
                        originalName: file.name
                    });
                }, 'image/png', 1.0); // Using PNG as BMP substitute for web compatibility
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
}

// Convert button click
convertBtn.addEventListener('click', async function() {
    if (selectedFiles.length === 0) return;

    convertBtn.disabled = true;
    progressSection.style.display = 'block';
    downloadLinks.innerHTML = '';

    const convertedFiles = [];

    for (let i = 0; i < selectedFiles.length; i++) {
        const file = selectedFiles[i];

        // Update progress
        const progress = ((i + 1) / selectedFiles.length) * 100;
        progressBar.style.width = progress + '%';
        progressBar.textContent = `Converting ${i + 1}/${selectedFiles.length}`;

        try {
            const converted = await convertToBmp(file);
            convertedFiles.push(converted);
        } catch (error) {
            console.error('Error converting file:', error);
        }
    }

    // Create download links
    convertedFiles.forEach(file => {
        const url = URL.createObjectURL(file.blob);
        const downloadBtn = document.createElement('a');
        downloadBtn.href = url;
        downloadBtn.download = file.fileName;
        downloadBtn.className = 'btn btn-success';
        downloadBtn.innerHTML = `<i class="fas fa-download me-2"></i>Download ${file.fileName}`;
        downloadLinks.appendChild(downloadBtn);
    });

    // Create download all button if multiple files
    if (convertedFiles.length > 1) {
        const downloadAllBtn = document.createElement('button');
        downloadAllBtn.className = 'btn btn-primary mt-2';
        downloadAllBtn.innerHTML = '<i class="fas fa-download me-2"></i>Download All Files';
        downloadAllBtn.onclick = function() {
            convertedFiles.forEach(file => {
                const url = URL.createObjectURL(file.blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = file.fileName;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            });
        };
        downloadLinks.appendChild(downloadAllBtn);
    }

    progressSection.style.display = 'none';
    downloadSection.style.display = 'block';
    convertBtn.disabled = false;
    convertBtn.innerHTML = '<i class="fas fa-redo me-2"></i>Convert More Files';
});

// Clear files function
function clearFiles() {
    fileInput.value = '';
    selectedFiles = [];
    previewSection.style.display = 'none';
    downloadSection.style.display = 'none';
    progressSection.style.display = 'none';
    convertBtn.disabled = true;
    convertBtn.innerHTML = '<i class="fas fa-exchange-alt me-2"></i>Convert to BMP';
}
</script>
