{{-- Google Cache Checker --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Check how Google cached your webpage.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-database me-3"></i>Google Cache Checker
                </h1>
                <p class="lead text-muted">
                    Check the Google cache status of your webpage
                </p>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-edit me-2"></i>URL</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="urlInput" class="form-label fw-semibold">Enter URL:</label>
                                <input type="url" class="form-control" id="urlInput" placeholder="https://example.com">
                            </div>
                            <button type="button" id="checkBtn" class="btn btn-primary w-100">
                                <i class="fas fa-magnifying-glass me-2"></i>Check Cache Status
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Results</h5>
                        </div>
                        <div class="card-body" id="results" style="max-height: 600px; overflow-y: auto;">
                            <p class="text-muted text-center">Enter a URL and click "Check Cache Status"</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Tips</h5>
                        </div>
                        <div class="card-body">
                            <ul class="mb-0">
                                <li>Google caches pages when they are crawled by Googlebot</li>
                                <li>The cache may be outdated - Google updates caches regularly</li>
                                <li>A missing cache typically means the page is new or hasn't been indexed yet</li>
                                <li>Use <code>site:example.com</code> in Google Search to find cached pages</li>
                                <li>To force a re-cache, submit your URL to Google Search Console</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlInput = document.getElementById('urlInput');
    const checkBtn = document.getElementById('checkBtn');
    const results = document.getElementById('results');

    function generateCacheURLs(url) {
        try {
            new URL(url);
        } catch (e) {
            alert('Invalid URL format');
            return null;
        }

        // Generate different Google cache URLs
        const cacheUrls = {
            'Google Web Cache': `https://webcache.googleusercontent.com/cache:${url}`,
            'Google Info': `https://www.google.com/search?q=cache:${url}`,
            'Google Mobile': `https://www.google.com/search?q=site:${new URL(url).hostname}&hl=en`
        };

        return cacheUrls;
    }

    function check() {
        const url = urlInput.value.trim();

        if (!url) {
            alert('Please enter a URL');
            return;
        }

        try {
            new URL(url);
        } catch (e) {
            alert('Invalid URL format');
            return;
        }

        const cacheUrls = generateCacheURLs(url);
        const hostname = new URL(url).hostname;

        let html = `
            <div class="mb-3">
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-globe me-2"></i>Cache Information for: <code>${escapeHtml(url)}</code>
                </h6>
            </div>

            <div class="card card-sm mb-3">
                <div class="card-body">
                    <div class="mb-2">
                        <strong><i class="fas fa-info-circle text-info me-2"></i>URL Status:</strong>
                    </div>
                    <p class="mb-0">
                        The URL you entered is: <code style="background: #f8f9fa; padding: 2px 6px; border-radius: 3px;">${escapeHtml(url)}</code>
                    </p>
                </div>
            </div>

            <div class="card card-sm mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <strong><i class="fas fa-link me-2"></i>View Cached Version:</strong>
                    </div>
        `;

        html += `
                    <p class="mb-2">
                        <a href="${cacheUrls['Google Web Cache']}" target="_blank" class="btn btn-sm btn-primary me-2">
                            <i class="fas fa-external-link-alt me-1"></i>View Cached Page
                        </a>
                    </p>
                    <small class="text-muted">
                        This will show you how Google last cached your page
                    </small>
                </div>
            </div>

            <div class="card card-sm mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <strong><i class="fas fa-search me-2"></i>Site Information:</strong>
                    </div>
        `;

        html += `
                    <p class="mb-2">
                        <a href="${cacheUrls['Google Info']}" target="_blank" class="btn btn-sm btn-success me-2">
                            <i class="fas fa-external-link-alt me-1"></i>Check in Google
                        </a>
                    </p>
                    <small class="text-muted">
                        View all cached pages from this URL in Google Search
                    </small>
                </div>
            </div>

            <div class="card card-sm mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <strong><i class="fas fa-mobile-alt me-2"></i>Mobile View:</strong>
                    </div>
                    <p class="mb-2">
                        <a href="${cacheUrls['Google Mobile']}" target="_blank" class="btn btn-sm btn-info me-2">
                            <i class="fas fa-external-link-alt me-1"></i>Site on Google
                        </a>
                    </p>
                    <small class="text-muted">
                        View your site's presence on Google Search
                    </small>
                </div>
            </div>

            <div class="alert alert-info">
                <strong><i class="fas fa-lightbulb me-2"></i>What This Means:</strong>
                <ul class="mb-0 mt-2" style="font-size: 13px;">
                    <li>If the cached page exists, your site has been indexed by Google</li>
                    <li>The cache date shows when Google last crawled your page</li>
                    <li>If there's no cache, the page may be too new or blocked from indexing</li>
                    <li>Use <strong>robots.txt</strong> and <strong>meta robots</strong> to control caching</li>
                </ul>
            </div>
        `;

        results.innerHTML = html;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    checkBtn.addEventListener('click', check);
    urlInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            check();
        }
    });
});
</script>
