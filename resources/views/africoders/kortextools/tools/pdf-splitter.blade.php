<div class="card">
    <div class="card-header">
        <h5>PDF Splitter</h5>
        <p class="text-muted small mb-0">Extract specific pages from a PDF</p>
    </div>
    <div class="card-body">
        <form id="pdfSplitterForm" class="tool-form">
            @csrf
            <div class="mb-3">
                <label for="pdfFile" class="form-label">Upload PDF File</label>
                <input type="file" class="form-control" id="pdfFile" accept="application/pdf" required>
            </div>
            <div class="mb-3">
                <label for="pages" class="form-label">Pages to Extract</label>
                <input type="text" class="form-control" id="pages" name="pages" placeholder="e.g., 1,3,5 or 2-4" required>
                <small class="text-muted">Enter page numbers separated by commas, or ranges like 2-5</small>
            </div>
            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-cut"></i> Split PDF</button>
            <div id="result" class="mt-4" style="display:none;">
                <div class="alert alert-info">
                    <p><i class="fas fa-info-circle"></i> PDF splitting requires file upload backend integration.</p>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('pdfSplitterForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData();
    formData.append('tool', 'pdf-splitter');
    formData.append('pdf_file', document.getElementById('pdfFile').files[0]);
    formData.append('pages', document.getElementById('pages').value);
    formData.append('_token', document.querySelector('[name="_token"]').value);
    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "pdf-splitter") }}', { method: 'POST', body: formData });
        const data = await response.json();
        if(data.success) document.getElementById('result').style.display = 'block';
    } catch(e) { console.error(e); }
});
</script>