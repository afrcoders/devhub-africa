<form id="webpToPngForm" enctype="multipart/form-data">@csrf
    <div class="mb-3">
        <label for="webpFile" class="form-label">Select WebP Image</label>
        <input type="file" class="form-control" id="webpFile" name="file" accept=".webp" required>
        <div class="form-text">Upload a WebP image file to convert to PNG format.</div>
    </div>
    <button type="submit" class="btn btn-primary w-100">
        <i class="fas fa-exchange-alt me-1"></i>
        Convert to PNG
    </button>
</form>

<div id="result" class="mt-4" style="display:none;">
    <div class="alert alert-success">
        <h6>Conversion Complete!</h6>
        <p id="resultMessage" class="mb-2"></p>
        <a id="downloadLink" href="#" class="btn btn-success btn-sm" download>
            <i class="fas fa-download me-1"></i>
            Download PNG
        </a>
    </div>
</div>

<div id="loading" class="mt-4" style="display:none;">
    <div class="alert alert-info">
        <div class="d-flex align-items-center">
            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
            <span>Converting image...</span>
        </div>
    </div>
</div>

<script>
document.getElementById('webpToPngForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData();
    const fileInput = document.getElementById('webpFile');

    if (!fileInput.files[0]) {
        alert('Please select a WebP file');
        return;
    }

    formData.append('file', fileInput.files[0]);
    formData.append('tool', 'webp-to-png');

    // Show loading
    document.getElementById('loading').style.display = 'block';
    document.getElementById('result').style.display = 'none';

    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "webp-to-png") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
            },
            body: formData
        });

        const result = await response.json();

        document.getElementById('loading').style.display = 'none';

        if (result.success) {
            document.getElementById('resultMessage').textContent = 'Image converted successfully!';
            document.getElementById('downloadLink').href = result.download_url;
            document.getElementById('result').style.display = 'block';
        } else {
            alert('Conversion failed: ' + (result.message || 'Unknown error'));
        }
    } catch (error) {
        document.getElementById('loading').style.display = 'none';
        alert('Error: ' + error.message);
    }
});
</script>
