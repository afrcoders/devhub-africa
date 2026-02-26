{{-- Get HTTP Headers --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Check HTTP response headers from any website.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-heading me-3"></i>Get HTTP Headers
                </h1>
                <p class="lead text-muted">
                    Check HTTP response headers from any website
                </p>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Website URL</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="url" class="form-label fw-semibold">Enter URL:</label>
                                <input type="url" class="form-control" id="url" placeholder="https://example.com">
                            </div>

                            <button type="button" id="getBtn" class="btn btn-primary w-100">
                                <i class="fas fa-magnifying-glass me-2"></i>Get Headers
                            </button>

                            <hr class="my-4">

                            <div class="alert alert-info">
                                <strong><i class="fas fa-info-circle me-2"></i>Note:</strong>
                                This tool uses a CORS proxy to fetch headers. Some servers may block this.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-code me-2"></i>HTTP Headers</h5>
                        </div>
                        <div class="card-body" id="results" style="max-height: 600px; overflow-y: auto; font-size: 12px;">
                            <p class="text-muted text-center">Enter URL and click "Get Headers"</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Common HTTP Headers</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <strong>Content-Type:</strong> MIME type of the response (e.g., text/html)
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Server:</strong> Information about the server software
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Content-Length:</strong> Size of the response in bytes
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Cache-Control:</strong> Caching directives for browsers
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Set-Cookie:</strong> Cookies sent by the server
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Content-Encoding:</strong> Compression method (e.g., gzip)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const url = document.getElementById('url');
    const getBtn = document.getElementById('getBtn');
    const results = document.getElementById('results');

    function getHeaders() {
        const urlValue = url.value.trim();

        if (!urlValue) {
            alert('Please enter a URL');
            return;
        }

        try {
            new URL(urlValue);
        } catch (e) {
            alert('Invalid URL format');
            return;
        }

        results.innerHTML = `
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Fetching headers...</p>
            </div>
        `;

        // Use CORS proxy to fetch headers
        const proxyUrl = 'https://cors-anywhere.herokuapp.com/';

        fetch(proxyUrl + urlValue, {
            method: 'HEAD'
        })
        .then(response => {
            const headers = {};
            response.headers.forEach((value, key) => {
                headers[key] = value;
            });

            displayHeaders(urlValue, response.status, response.statusText, headers);
        })
        .catch(error => {
            // Try alternative approach - fetch with full document
            fetch(urlValue, { mode: 'no-cors' })
                .then(response => {
                    results.innerHTML = `
                        <div class="alert alert-warning">
                            <strong>Note:</strong> Could not retrieve headers due to CORS restrictions.
                            <p class="mb-0 mt-2">To check headers, you can:</p>
                            <ul class="mb-0 mt-2" style="font-size: 12px;">
                                <li>Use browser DevTools: Open the website, press F12, go to Network tab</li>
                                <li>Use online tools like <a href="https://www.webconfs.com/http-header-check.php" target="_blank">WebConfs</a></li>
                                <li>Use curl command: <code>curl -i ${escapeHtml(urlValue)}</code></li>
                            </ul>
                        </div>
                    `;
                })
                .catch(err => {
                    results.innerHTML = `
                        <div class="alert alert-danger">
                            <strong>Error:</strong> Could not fetch the URL. The server may not allow external requests.
                        </div>
                    `;
                });
        });
    }

    function displayHeaders(urlValue, status, statusText, headers) {
        let html = `
            <div class="mb-3">
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-globe me-2"></i>Headers for: <code>${escapeHtml(urlValue)}</code>
                </h6>
            </div>

            <div class="card card-sm mb-3">
                <div class="card-body p-2">
                    <strong>Status: ${status} ${statusText}</strong>
                </div>
            </div>
        `;

        for (const [key, value] of Object.entries(headers)) {
            html += `
                <div class="card card-sm mb-2">
                    <div class="card-body p-2">
                        <div style="font-weight: bold; color: #0066cc;">${escapeHtml(key)}:</div>
                        <div style="margin-top: 5px; color: #333; word-break: break-all;">${escapeHtml(value)}</div>
                    </div>
                </div>
            `;
        }

        results.innerHTML = html;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    getBtn.addEventListener('click', getHeaders);
    url.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            getHeaders();
        }
    });
});
</script>
