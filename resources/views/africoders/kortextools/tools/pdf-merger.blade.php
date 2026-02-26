<div class="card">
    <div class="card-header">
        <h5>PDF Merger</h5>
        <p class="text-muted small mb-0">Combine multiple PDF files into one</p>
    </div>
    <div class="card-body">
        <form id="pdfMergerForm" class="tool-form">
            @csrf
            <div class="mb-3">
                <label for="pdfFiles" class="form-label">Upload PDF Files</label>
                <input type="file" class="form-control" id="pdfFiles" name="pdf_files" accept="application/pdf" multiple required>
                <small class="text-muted">Select 2 or more PDF files to merge</small>
            </div>
            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-object-group"></i> Merge PDFs</button>
            <div id="result" class="mt-4" style="display:none;">
                <div class="alert alert-info">
                    <p><i class="fas fa-info-circle"></i> PDF merging requires file upload backend integration with mPDF or TCPDF library.</p>
                    <p>This tool is available in the web interface with file upload support.</p>
                </div>
            </div>
            <div id="errorMessage" class="alert alert-danger" style="display:none;"></div>
        </form>
    </div>
</div>

<script>
document.getElementById('pdfMergerForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const files = document.getElementById('pdfFiles').files;
    if(files.length < 2) {
        document.getElementById('errorMessage').textContent = 'Please select at least 2 PDF files';
        document.getElementById('errorMessage').style.display = 'block';
        return;
    }
    const formData = new FormData();
    formData.append('tool', 'pdf-merger');
    formData.append('_token', document.querySelector('[name="_token"]').value);
    for(let i = 0; i < files.length; i++) {
        formData.append('pdfs[]', files[i]);
    }
    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "pdf-merger") }}', { method: 'POST', body: formData });
        const data = await response.json();
        if(data.success) {
            document.getElementById('result').style.display = 'block';
            document.getElementById('errorMessage').style.display = 'none';
        }
    } catch(e) { document.getElementById('errorMessage').textContent = e.message; document.getElementById('errorMessage').style.display = 'block'; }
});
</script>