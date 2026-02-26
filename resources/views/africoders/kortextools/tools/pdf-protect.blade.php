<div class="card">
    <div class="card-header">
        <h5>PDF Password Protect</h5>
        <p class="text-muted small mb-0">Add password protection to PDF files</p>
    </div>
    <div class="card-body">
        <form id="pdfProtectForm" class="tool-form">
            @csrf
            <div class="mb-3">
                <label for="pdfFile" class="form-label">Upload PDF File</label>
                <input type="file" class="form-control" id="pdfFile" accept="application/pdf" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">User Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <small class="text-muted">Password for opening the PDF</small>
            </div>
            <div class="mb-3">
                <label for="ownerPassword" class="form-label">Owner Password (Optional)</label>
                <input type="password" class="form-control" id="ownerPassword" name="owner_password">
                <small class="text-muted">Password for admin features</small>
            </div>
            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-lock"></i> Protect PDF</button>
            <div id="result" class="mt-4" style="display:none;">
                <div class="alert alert-info">
                    <p><i class="fas fa-info-circle"></i> PDF protection requires backend integration.</p>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('pdfProtectForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData();
    formData.append('tool', 'pdf-protect');
    formData.append('pdf_file', document.getElementById('pdfFile').files[0]);
    formData.append('password', document.getElementById('password').value);
    formData.append('owner_password', document.getElementById('ownerPassword').value || '');
    formData.append('_token', document.querySelector('[name="_token"]').value);
    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "pdf-protect") }}', { method: 'POST', body: formData });
        const data = await response.json();
        if(data.success) document.getElementById('result').style.display = 'block';
    } catch(e) { console.error(e); }
});
</script>