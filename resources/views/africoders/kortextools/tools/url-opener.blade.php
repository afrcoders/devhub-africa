{{-- URL Opener --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    URL Opener for opening multiple URLs at once with configurable options.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-link me-3"></i>URL Opener
                </h1>
                <p class="lead text-muted">
                    Open multiple URLs at once with customizable options
                </p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-globe me-2"></i>Bulk URL Opener</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label for="urlInput" class="form-label fw-semibold">
                            <i class="fas fa-list me-2"></i>URLs to Open
                        </label>
                        <textarea class="form-control" id="urlInput" rows="10"
                            placeholder="Enter URLs, one per line:\nhttps://google.com\nhttps://github.com\nhttps://stackoverflow.com"></textarea>
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Enter one URL per line. Include http:// or https://
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-cogs me-2"></i>Open Options
                            </label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="openNewTab" checked>
                                <label class="form-check-label" for="openNewTab">
                                    Open in new tabs
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="addDelay">
                                <label class="form-check-label" for="addDelay">
                                    Add delay between opens
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="delayInput" class="form-label fw-semibold">
                                <i class="fas fa-clock me-2"></i>Delay (ms)
                            </label>
                            <input type="number" class="form-control" id="delayInput" value="1000" min="100" max="10000" disabled>
                            <div class="form-text">Milliseconds between opening URLs</div>
                        </div>
                    </div>

                    <div class="text-center mb-4">
                        <button type="button" id="openBtn" class="btn btn-primary btn-lg">
                            <i class="fas fa-external-link-alt me-2"></i>Open All URLs
                        </button>
                        <button type="button" id="validateBtn" class="btn btn-outline-secondary btn-lg ms-3">
                            <i class="fas fa-check me-2"></i>Validate URLs
                        </button>
                    </div>

                    <div id="resultSection" style="display: none;">
                        <div class="border-top pt-4">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <span class="badge bg-success fs-6 p-2">
                                            <i class="fas fa-check-circle me-2"></i>
                                            <span id="validCount">0</span> Valid URLs
                                        </span>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <span class="badge bg-warning fs-6 p-2">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            <span id="invalidCount">0</span> Invalid URLs
                                        </span>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <span class="badge bg-info fs-6 p-2">
                                            <i class="fas fa-list-ol me-2"></i>
                                            <span id="totalCount">0</span> Total
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <label class="form-label fw-semibold">
                                <i class="fas fa-list me-2 text-success"></i>URL List
                            </label>
                            <div id="urlList" class="bg-light p-3 rounded" style="max-height: 300px; overflow-y: auto;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tips section --}}
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Tips</h5>
                </div>
                <div class="card-body">
                    <ul class="text-muted small mb-0">
                        <li><strong>Format:</strong> Include the full URL with http:// or https://</li>
                        <li><strong>One per line:</strong> Enter each URL on a separate line</li>
                        <li><strong>Validation:</strong> Use the Validate button to check URLs before opening</li>
                        <li><strong>Browser popup blocker:</strong> You may need to allow popups for this tool</li>
                        <li><strong>Delay:</strong> Add delays between opens to avoid overwhelming your browser</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlInput = document.getElementById('urlInput');
    const openNewTab = document.getElementById('openNewTab');
    const addDelay = document.getElementById('addDelay');
    const delayInput = document.getElementById('delayInput');
    const openBtn = document.getElementById('openBtn');
    const validateBtn = document.getElementById('validateBtn');
    const resultSection = document.getElementById('resultSection');
    const urlList = document.getElementById('urlList');
    const validCount = document.getElementById('validCount');
    const invalidCount = document.getElementById('invalidCount');
    const totalCount = document.getElementById('totalCount');

    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }

    function parseUrls() {
        return urlInput.value
            .split('\n')
            .map(url => url.trim())
            .filter(url => url.length > 0);
    }

    function validateUrls() {
        const urls = parseUrls();
        if (urls.length === 0) {
            alert('Please enter at least one URL.');
            return;
        }

        const validUrls = urls.filter(url => isValidUrl(url));
        const invalid = urls.filter(url => !isValidUrl(url));

        // Display results
        urlList.innerHTML = validUrls.map(url =>
            `<div class="mb-2"><i class="fas fa-check text-success me-2"></i><code class="text-success small">${url}</code></div>`
        ).join('') +
        invalid.map(url =>
            `<div class="mb-2"><i class="fas fa-times text-danger me-2"></i><code class="text-danger small">${url}</code></div>`
        ).join('');

        validCount.textContent = validUrls.length;
        invalidCount.textContent = invalid.length;
        totalCount.textContent = urls.length;
        resultSection.style.display = 'block';
    }

    function openUrls() {
        const urls = parseUrls().filter(url => isValidUrl(url));

        if (urls.length === 0) {
            alert('No valid URLs to open.');
            return;
        }

        if (urls.length > 10) {
            const confirm_open = confirm(`You're about to open ${urls.length} URLs. This may take a while. Continue?`);
            if (!confirm_open) return;
        }

        const useDelay = addDelay.checked;
        const delay = useDelay ? parseInt(delayInput.value) : 0;
        const target = openNewTab.checked ? '_blank' : '_self';

        urls.forEach((url, index) => {
            setTimeout(() => {
                window.open(url, target);
            }, delay * index);
        });

        alert(`${urls.length} URL${urls.length !== 1 ? 's' : ''} opened!`);
    }

    addDelay.addEventListener('change', function() {
        delayInput.disabled = !this.checked;
    });

    openBtn.addEventListener('click', openUrls);
    validateBtn.addEventListener('click', validateUrls);
});
</script>
