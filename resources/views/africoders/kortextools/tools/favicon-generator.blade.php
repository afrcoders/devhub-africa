<div class="card">
    <div class="card-header">
        <h5>Favicon Generator</h5>
        <p class="text-muted small mb-0">Create a simple favicon from text</p>
    </div>
    <div class="card-body">
        <form id="faviconForm" class="tool-form">
            @csrf
            <div class="mb-3">
                <label for="text" class="form-label">Letter</label>
                <input type="text" class="form-control" id="text" name="text" maxlength="1" value="A" required>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="bgColor" class="form-label">Background Color</label>
                        <input type="color" class="form-control" id="bgColor" name="bg_color" value="#3498db">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="textColor" class="form-label">Text Color</label>
                        <input type="color" class="form-control" id="textColor" name="text_color" value="#ffffff">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="size" class="form-label">Size</label>
                <select class="form-select" id="size" name="size">
                    <option value="32">32×32px</option>
                    <option value="64">64×64px</option>
                    <option value="128" selected>128×128px</option>
                    <option value="256">256×256px</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-star"></i> Generate Favicon</button>
            <div id="result" class="mt-4" style="display:none;">
                <div class="alert alert-success">
                    <img id="faviconImage" src="" style="width: 128px; height: 128px; border-radius: 8px;">
                    <button type="button" class="btn btn-sm btn-outline-primary mt-3" onclick="downloadFavicon()">
                        <i class="fas fa-download"></i> Download
                    </button>
                </div>
            </div>
            <div id="errorMessage" class="alert alert-danger" style="display:none;"></div>
        </form>
    </div>
</div>

<script>
document.getElementById('faviconForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = {
        tool: 'favicon-generator',
        text: document.getElementById('text').value,
        bg_color: document.getElementById('bgColor').value,
        text_color: document.getElementById('textColor').value,
        size: document.getElementById('size').value,
        _token: document.querySelector('[name="_token"]').value
    };
    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "favicon-generator") }}', {
            method: 'POST',
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value},
            body: JSON.stringify(formData)
        });
        const data = await response.json();
        if(data.success) {
            document.getElementById('faviconImage').src = 'data:image/png;base64,' + data.result;
            this.dataset.faviconData = data.result;
            document.getElementById('result').style.display = 'block';
        }
    } catch(e) { document.getElementById('errorMessage').textContent = e.message; document.getElementById('errorMessage').style.display = 'block'; }
});

function downloadFavicon() {
    const link = document.createElement('a');
    link.href = 'data:image/png;base64,' + document.getElementById('faviconForm').dataset.faviconData;
    link.download = 'favicon.png';
    link.click();
}
</script>