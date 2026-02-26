<div class="card">
    <div class="card-header">
        <h5>PNG to JPG Converter</h5>
        <p class="text-muted small mb-0">Convert PNG images to JPG format</p>
    </div>
    <div class="card-body">
        <form id="pngForm" class="tool-form">
            @csrf
            <div class="mb-3">
                <label for="imageInput" class="form-label">Upload PNG Image</label>
                <input type="file" class="form-control" id="imageInput" accept="image/png" required>
            </div>
            <div class="mb-3">
                <label for="quality" class="form-label">Quality: <span id="qVal">85</span>%</label>
                <input type="range" class="form-range" id="quality" name="quality" min="1" max="100" value="85">
            </div>
            <div class="mb-3">
                <label for="bgColor" class="form-label">Background Color (for transparency)</label>
                <input type="color" class="form-control" id="bgColor" name="bg_color" value="#ffffff">
            </div>
            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-image"></i> Convert to JPG</button>
            <div id="result" class="mt-4" style="display:none;">
                <div class="alert alert-success">
                    <p><strong>Original:</strong> <span id="originalSize"></span></p>
                    <p><strong>Converted:</strong> <span id="convertedSize"></span></p>
                    <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="downloadJpg()">
                        <i class="fas fa-download"></i> Download
                    </button>
                </div>
            </div>
            <div id="errorMessage" class="alert alert-danger" style="display:none;"></div>
        </form>
    </div>
</div>

<script>
document.getElementById('quality').addEventListener('input', function() { document.getElementById('qVal').textContent = this.value; });
document.getElementById('imageInput').addEventListener('change', function(e) {
    const reader = new FileReader();
    reader.onload = function(event) { document.getElementById('pngForm').dataset.imageData = event.target.result; };
    reader.readAsDataURL(e.target.files[0]);
});
document.getElementById('pngForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = {
        tool: 'png-to-jpg',
        image: this.dataset.imageData,
        quality: document.getElementById('quality').value,
        bg_color: document.getElementById('bgColor').value,
        _token: document.querySelector('[name="_token"]').value
    };
    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "png-to-jpg") }}', {
            method: 'POST',
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value},
            body: JSON.stringify(formData)
        });
        const data = await response.json();
        if(data.success) {
            document.getElementById('originalSize').textContent = data.original_size;
            document.getElementById('convertedSize').textContent = data.converted_size;
            this.dataset.jpgData = data.result;
            document.getElementById('result').style.display = 'block';
        }
    } catch(e) { document.getElementById('errorMessage').textContent = e.message; document.getElementById('errorMessage').style.display = 'block'; }
});

function downloadJpg() {
    const link = document.createElement('a');
    link.href = 'data:image/jpeg;base64,' + document.getElementById('pngForm').dataset.jpgData;
    link.download = 'converted.jpg';
    link.click();
}
</script>