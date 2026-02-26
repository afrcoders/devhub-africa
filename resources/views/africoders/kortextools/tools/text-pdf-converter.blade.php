<form id="textToPdfForm">@csrf
    <div class="mb-3">
        <label for="textContent" class="form-label">Text Content</label>
        <textarea class="form-control" id="textContent" name="text" rows="10" placeholder="Enter your text content here..." required></textarea>
        <div class="form-text">Enter the text you want to convert to PDF format.</div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="fontSize" class="form-label">Font Size</label>
            <select class="form-select" id="fontSize" name="font_size">
                <option value="8">8pt</option>
                <option value="10">10pt</option>
                <option value="12" selected>12pt</option>
                <option value="14">14pt</option>
                <option value="16">16pt</option>
                <option value="18">18pt</option>
                <option value="24">24pt</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="fontFamily" class="form-label">Font Family</label>
            <select class="form-select" id="fontFamily" name="font_family">
                <option value="helvetica" selected>Helvetica</option>
                <option value="times">Times</option>
                <option value="courier">Courier</option>
                <option value="arial">Arial</option>
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="pageSize" class="form-label">Page Size</label>
            <select class="form-select" id="pageSize" name="page_size">
                <option value="A4" selected>A4</option>
                <option value="A3">A3</option>
                <option value="A5">A5</option>
                <option value="Letter">Letter</option>
                <option value="Legal">Legal</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="lineSpacing" class="form-label">Line Spacing</label>
            <select class="form-select" id="lineSpacing" name="line_spacing">
                <option value="1.0">Single</option>
                <option value="1.5" selected>1.5x</option>
                <option value="2.0">Double</option>
            </select>
        </div>
    </div>

    <div class="mb-3">
        <label for="margins" class="form-label">Margins (mm)</label>
        <input type="number" class="form-control" id="margins" name="margins" value="20" min="10" max="50">
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
            <span>Converting text to PDF...</span>
        </div>
    </div>
</div>

<script>
document.getElementById('textToPdfForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = {
        text: document.getElementById('textContent').value,
        font_size: document.getElementById('fontSize').value,
        font_family: document.getElementById('fontFamily').value,
        page_size: document.getElementById('pageSize').value,
        line_spacing: document.getElementById('lineSpacing').value,
        margins: document.getElementById('margins').value,
        tool: 'text-pdf-converter'
    };

    if (!formData.text.trim()) {
        alert('Please enter some text content');
        return;
    }

    // Show loading
    document.getElementById('loading').style.display = 'block';
    document.getElementById('result').style.display = 'none';

    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "text-pdf-converter") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
            },
            body: JSON.stringify(formData)
        });

        const result = await response.json();

        document.getElementById('loading').style.display = 'none';

        if (result.success) {
            document.getElementById('resultMessage').textContent = 'Text converted to PDF successfully!';
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
