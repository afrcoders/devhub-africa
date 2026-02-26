<div class="card">
    <div class="card-header">
        <h5>URL Extractor</h5>
        <p class="text-muted small mb-0">Extract all URLs from text</p>
    </div>
    <div class="card-body">
        <form id="urlExtractorForm" class="tool-form">
            @csrf

            <div class="mb-3">
                <label for="text" class="form-label">Text to Extract URLs From</label>
                <textarea class="form-control" id="text" name="text" rows="8" placeholder="Paste your text here..."></textarea>
                <small class="text-muted">Enter text containing URLs (e.g., https://example.com)</small>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-external-link-alt"></i> Extract URLs
                </button>
            </div>

            <!-- Results -->
            <div id="resultsContainer" style="display: none;">
                <div class="mt-4">
                    <h6>Extracted URLs (<span id="urlCount">0</span>):</h6>
                    <div class="list-group" id="urlList">
                        <!-- URLs will be appended here -->
                    </div>

                    <div class="mt-3">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="copyAllUrls()">
                            <i class="fas fa-copy"></i> Copy All URLs
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="downloadUrls()">
                            <i class="fas fa-download"></i> Download as Text
                        </button>
                    </div>
                </div>
            </div>

            <!-- Error message -->
            <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
        </form>
    </div>
</div>

<script>
document.getElementById('urlExtractorForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const text = document.getElementById('text').value;
    const errorMessage = document.getElementById('errorMessage');
    const resultsContainer = document.getElementById('resultsContainer');

    if (!text.trim()) {
        errorMessage.textContent = 'Please enter some text';
        errorMessage.style.display = 'block';
        return;
    }

    errorMessage.style.display = 'none';

    fetch('{{ route("tools.kortex.tool.submit", "url-extractor") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
        },
        body: JSON.stringify({ text: text })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const urlList = document.getElementById('urlList');
            urlList.innerHTML = '';

            data.data.urls.forEach(url => {
                const item = document.createElement('div');
                item.className = 'list-group-item d-flex justify-content-between align-items-center';
                item.innerHTML = `
                    <span><code>${url}</code></span>
                    <div>
                        <a href="${url}" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="copyUrl('${url}')">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                `;
                urlList.appendChild(item);
            });

            document.getElementById('urlCount').textContent = data.data.count;
            resultsContainer.style.display = 'block';
        } else {
            errorMessage.textContent = data.message || 'An error occurred';
            errorMessage.style.display = 'block';
        }
    })
    .catch(error => {
        errorMessage.textContent = 'Error: ' + error.message;
        errorMessage.style.display = 'block';
    });
});

function copyUrl(url) {
    navigator.clipboard.writeText(url).then(() => {
        alert('URL copied to clipboard!');
    });
}

function copyAllUrls() {
    const urls = Array.from(document.querySelectorAll('#urlList code')).map(el => el.textContent).join('\n');
    navigator.clipboard.writeText(urls).then(() => {
        alert('All URLs copied to clipboard!');
    });
}

function downloadUrls() {
    const urls = Array.from(document.querySelectorAll('#urlList code')).map(el => el.textContent).join('\n');
    const element = document.createElement('a');
    element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(urls));
    element.setAttribute('download', 'urls.txt');
    element.style.display = 'none';
    document.body.appendChild(element);
    element.click();
    document.body.removeChild(element);
}
</script>