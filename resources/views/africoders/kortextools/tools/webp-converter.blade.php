<div class="card">
    <div class="card-header">
        <h5>WebP Converter</h5>
        <p class="text-muted small mb-0">Convert images to modern WebP format for better compression</p>
    </div>
    <div class="card-body">
        <form id="webpForm" class="tool-form">
            @csrf
            <div class="mb-3">
                <label for="imageInput" class="form-label">Upload Image</label>
                <input type="file" class="form-control" id="imageInput" accept="image/*" required>
            </div>
            <div class="mb-3">
                <label for="quality" class="form-label">Quality: <span id="qValue">80</span>%</label>
                <input type="range" class="form-range" id="quality" name="quality" min="1" max="100" value="80">
            </div>
            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-images"></i> Convert to WebP</button>
            <div id="result" class="mt-4" style="display:none;">
                <div class="alert alert-success">
                    <p><strong>Original:</strong> <span id="originalSize"></span></p>
                    <p><strong>WebP Size:</strong> <span id="webpSize"></span></p>
                    <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="downloadWebP()">
                        <i class="fas fa-download"></i> Download
                    </button>
                </div>
            </div>
            <div id="errorMessage" class="alert alert-danger" style="display:none;"></div>
        </form>
    </div>
</div>

<script>
document.getElementById('quality').addEventListener('input', function() {
    document.getElementById('qValue').textContent = this.value;
});
document.getElementById('imageInput').addEventListener('change', function(e) {
    const reader = new FileReader();
    reader.onload = function(event) { document.getElementById('webpForm').dataset.imageData = event.target.result; };
    reader.readAsDataURL(e.target.files[0]);
});
document.getElementById('webpForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = {tool: 'webp-converter', image: this.dataset.imageData, quality: document.getElementById('quality').value, _token: document.querySelector('[name="_token"]').value};
    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "webp-converter") }}', {method: 'POST', headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value}, body: JSON.stringify(formData)});
        const data = await response.json();
        if(data.success) {
            document.getElementById('originalSize').textContent = data.original_size;
            document.getElementById('webpSize').textContent = data.webp_size;
            this.dataset.webpData = data.result;
            document.getElementById('result').style.display = 'block';
        }
    } catch(e) { document.getElementById('errorMessage').textContent = e.message; document.getElementById('errorMessage').style.display = 'block'; }
});
function downloadWebP() {
    const link = document.createElement('a');
    link.href = 'data:image/webp;base64,' + document.getElementById('webpForm').dataset.webpData;
    link.download = 'converted.webp';
    link.click();
}
</script>