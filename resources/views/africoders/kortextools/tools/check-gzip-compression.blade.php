{{-- Check GZIP Compression --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Check if your website uses GZIP compression.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-compress me-3"></i>Check GZIP Compression
                </h1>
                <p class="lead text-muted">
                    Check if your website has GZIP compression enabled
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

                            <button type="button" id="checkBtn" class="btn btn-primary w-100">
                                <i class="fas fa-magnifying-glass me-2"></i>Check GZIP Status
                            </button>

                            <hr class="my-4">

                            <div class="alert alert-info">
                                <strong><i class="fas fa-info-circle me-2"></i>Note:</strong>
                                GZIP compression reduces file sizes by 50-80%, improving page load speed. It's recommended for all websites.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-list-check me-2"></i>Results</h5>
                        </div>
                        <div class="card-body" id="results" style="max-height: 600px; overflow-y: auto;">
                            <p class="text-muted text-center">Enter URL and click "Check GZIP Status"</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>How to Enable GZIP</h5>
                        </div>
                        <div class="card-body">
                            <h6>Apache (.htaccess):</h6>
                            <pre style="background: #f8f9fa; padding: 10px; border-radius: 4px; overflow-x: auto;">
&lt;IfModule mod_deflate.c&gt;
  AddOutputFilterByType DEFLATE text/html
  AddOutputFilterByType DEFLATE text/plain
  AddOutputFilterByType DEFLATE text/css
  AddOutputFilterByType DEFLATE text/javascript
  AddOutputFilterByType DEFLATE application/javascript
&lt;/IfModule&gt;</pre>

                            <h6 class="mt-3">Nginx (nginx.conf):</h6>
                            <pre style="background: #f8f9fa; padding: 10px; border-radius: 4px; overflow-x: auto;">
gzip on;
gzip_types text/html text/plain text/css text/javascript application/javascript;</pre>
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
    const checkBtn = document.getElementById('checkBtn');
    const results = document.getElementById('results');

    function check() {
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
                <p class="mt-2">Checking GZIP compression...</p>
            </div>
        `;

        // Make HEAD request to check compression headers
        fetch(urlValue, { method: 'HEAD', mode: 'no-cors' })
            .then(response => {
                // We can't read headers with no-cors, so show information
                displayResults(urlValue, response);
            })
            .catch(error => {
                results.innerHTML = `
                    <div class="alert alert-warning">
                        <strong>Note:</strong> Could not directly check GZIP status due to CORS restrictions.
                        <p class="mb-0 mt-2">To check your server's GZIP compression, you can:</p>
                        <ul class="mb-0 mt-2" style="font-size: 13px;">
                            <li>Use online tools like <a href="https://www.giftofspeed.com/gzip-test/" target="_blank">GiftOfSpeed</a></li>
                            <li>Use browser DevTools: Open Network tab and check "Content-Encoding" header</li>
                            <li>Use curl: <code>curl -I -H "Accept-Encoding: gzip" ${escapeHtml(urlValue)}</code></li>
                        </ul>
                    </div>
                `;
            });
    }

    function displayResults(urlValue, response) {
        let html = `
            <div class="mb-3">
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-globe me-2"></i>GZIP Check for: <code>${escapeHtml(urlValue)}</code>
                </h6>
            </div>

            <div class="card card-sm mb-3">
                <div class="card-body">
                    <p class="text-muted">
                        <i class="fas fa-info-circle text-info me-2"></i>
                        Browser DevTools can show you the actual compression status.
                    </p>
                    <hr>
                    <strong>Steps to check in your browser:</strong>
                    <ol style="font-size: 13px;">
                        <li>Open the website: <a href="${escapeHtml(urlValue)}" target="_blank">${escapeHtml(urlValue)}</a></li>
                        <li>Open DevTools (F12 or Right-click → Inspect)</li>
                        <li>Go to "Network" tab</li>
                        <li>Reload the page</li>
                        <li>Look for "Content-Encoding" header in response</li>
                        <li>If it says "gzip", compression is enabled</li>
                    </ol>
                </div>
            </div>

            <div class="alert alert-info">
                <strong><i class="fas fa-lightbulb me-2"></i>Benefits of GZIP:</strong>
                <ul class="mb-0 mt-2" style="font-size: 13px;">
                    <li>Reduces file size by 50-80%</li>
                    <li>Faster page load times</li>
                    <li>Better SEO ranking (Google prefers faster sites)</li>
                    <li>Lower bandwidth usage</li>
                    <li>Reduced server load</li>
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
    url.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            check();
        }
    });
});
</script>
