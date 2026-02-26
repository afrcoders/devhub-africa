<form id="tiffToPdfForm" enctype="multipart/form-data">@csrf
    <div class="mb-3">
        <label for="tiffFiles" class="form-label">Select TIFF Images</label>
        <input type="file" class="form-control" id="tiffFiles" name="files[]" accept=".tiff,.tif" multiple required>
        <div class="form-text">Upload one or more TIFF image files to convert to PDF.</div>
    </div>

    <div class="mb-3">
        <label for="pageSize" class="form-label">Page Size</label>
        <select class="form-select" id="pageSize" name="page_size">
            <option value="A4" selected>A4</option>
            <option value="A3">A3</option>
            <option value="A5">A5</option>
            <option value="Letter">Letter</option>
            <option value="Legal">Legal</option>
            <option value="Custom">Custom</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="orientation" class="form-label">Orientation</label>
        <select class="form-select" id="orientation" name="orientation">
            <option value="auto" selected>Auto</option>
            <option value="portrait">Portrait</option>
            <option value="landscape">Landscape</option>
        </select>
    </div>

    <div class="mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="fitToPage" name="fit_to_page" checked>
            <label class="form-check-label" for="fitToPage">
                Fit images to page
            </label>
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100">
        <i class="fas fa-file-pdf me-1"></i>
        Convert to PDF
    </button>
</form>

<div id="result" class="mt-4" style="display:none;">
    <div class="alert alert-success">
        <h6>Conversion Complete!</h6>
        <p id="resultMessage" class="mb-2"></p>
        <a id="downloadLink" href="#" class="btn btn-success btn-sm" download>
            <i class="fas fa-download me-1"></i>
            Download PDF
        </a>
    </div>
</div>

<div id="loading" class="mt-4" style="display:none;">
    <div class="alert alert-info">
        <div class="d-flex align-items-center">
            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
            <span>Converting TIFF to PDF...</span>
        </div>
    </div>
</div>

<script>
document.getElementById('tiffToPdfForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData();
    const fileInput = document.getElementById('tiffFiles');

    if (!fileInput.files.length) {
        alert('Please select at least one TIFF file');
        return;
    }

    for (let i = 0; i < fileInput.files.length; i++) {
        formData.append('files[]', fileInput.files[i]);
    }

    formData.append('page_size', document.getElementById('pageSize').value);
    formData.append('orientation', document.getElementById('orientation').value);
    formData.append('fit_to_page', document.getElementById('fitToPage').checked ? '1' : '0');
    formData.append('tool', 'tiff-to-pdf');

    // Show loading
    document.getElementById('loading').style.display = 'block';
    document.getElementById('result').style.display = 'none';

    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "tiff-to-pdf") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
            },
            body: formData
        });

        const result = await response.json();

        document.getElementById('loading').style.display = 'none';

        if (result.success) {
            document.getElementById('resultMessage').textContent = `PDF created with ${fileInput.files.length} TIFF image(s)!`;
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
