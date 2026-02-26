{{-- HTTP Header Viewer --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-eye me-2"></i>
    View and analyze HTTP headers for any website or URL.
</div>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-eye fa-3x text-primary"></i>
                </div>
                <h1 class="h2 mb-3">HTTP Header Viewer</h1>
                <p class="lead text-muted">
                    View HTTP response headers and analyze website security configuration
                </p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="http-header-form">
                        @csrf
                        <div class="mb-4">
                            <label for="url" class="form-label">
                                <i class="fas fa-link me-2"></i>Website URL
                            </label>
                            <input
                                type="url"
                                class="form-control form-control-lg"
                                id="url"
                                name="url"
                                placeholder="https://example.com"
                                required
                            >
                            <small class="form-text text-muted">
                                Enter the full URL of the website you want to analyze
                            </small>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-search me-2"></i>Analyze HTTP Headers
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Loading State -->
            <div id="loading" class="text-center mt-4" style="display: none;">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <div class="spinner-border text-primary me-3" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span class="text-muted">Fetching HTTP headers...</span>
                    </div>
                </div>
            </div>

            <!-- Results -->
            <div id="results" class="mt-4" style="display: none;">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-list-alt me-2"></i>HTTP Headers Analysis
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="results-content"></div>
                    </div>
                </div>
            </div>

            <!-- Info Section -->
            <div class="alert alert-info mt-4">
                <h6 class="alert-heading">
                    <i class="fas fa-info-circle me-2"></i>About HTTP Headers
                </h6>
                <p class="mb-2">
                    HTTP headers provide important information about web responses:
                </p>
                <ul class="mb-2">
                    <li><strong>Status Code</strong> - Indicates if the request was successful</li>
                    <li><strong>Security Headers</strong> - Control browser behavior for security</li>
                    <li><strong>Content Headers</strong> - Specify content type and encoding</li>
                    <li><strong>Cache Headers</strong> - Control how browsers cache content</li>
                    <li><strong>Server Headers</strong> - Identify web server software</li>
                </ul>
                <p class="mb-0">
                    <small><strong>Best for:</strong> Website security analysis, debugging, performance optimization.</small>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('http-header-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const url = document.getElementById('url').value.trim();
    if (!url) {
        alert('Please enter a website URL');
        return;
    }

    // Show loading
    document.getElementById('loading').style.display = 'block';
    document.getElementById('results').style.display = 'none';

    const formData = new FormData();
    formData.append('url', url);
    formData.append('_token', document.querySelector('[name="_token"]').value);

    try {
        const response = await fetch('{{ request()->url() }}', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        // Hide loading
        document.getElementById('loading').style.display = 'none';

        if (result.success) {
            displayResults(result);
        } else {
            displayError(result.error || 'An error occurred');
        }
    } catch (error) {
        document.getElementById('loading').style.display = 'none';
        displayError('Network error: ' + error.message);
    }
});

function displayResults(result) {
    const headers = result.headers;
    const url = result.url;

    // Parse status line to get status code
    const statusLine = headers.status_line || '';
    const statusMatch = statusLine.match(/\d{3}/);
    const statusCode = statusMatch ? statusMatch[0] : 'Unknown';
    const statusClass = getStatusClass(statusCode);

    let headersHtml = '';
    if (headers.headers) {
        for (const [name, value] of Object.entries(headers.headers)) {
            headersHtml += `
                <tr>
                    <td class="fw-bold">${name}</td>
                    <td>
                        <code class="small">${value}</code>
                        <button class="btn btn-sm btn-outline-secondary ms-2" onclick="copyToClipboard('${value}')">
                            <i class="fas fa-copy"></i>
                        </button>
                    </td>
                </tr>
            `;
        }
    }

    let securityHtml = '';
    if (headers.security_analysis) {
        for (const [header, analysis] of Object.entries(headers.security_analysis)) {
            const statusIcon = analysis.present ? 'fas fa-check-circle text-success' : 'fas fa-times-circle text-danger';
            const statusText = analysis.present ? 'Present' : 'Missing';

            securityHtml += `
                <tr>
                    <td class="fw-bold">${header}</td>
                    <td>
                        <i class="${statusIcon} me-2"></i>${statusText}
                        ${analysis.value ? '<br><small class="text-muted">' + analysis.value + '</small>' : ''}
                    </td>
                    <td class="small">${analysis.description}</td>
                </tr>
            `;
        }
    }

    const html = `
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-${statusClass}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Response Status</h6>
                            <span class="fs-4 fw-bold">${statusCode}</span>
                            <small class="text-muted ms-2">${statusLine}</small>
                        </div>
                        <div class="text-end">
                            <small class="text-muted">URL: ${url}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <ul class="nav nav-tabs" id="headerTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="all-headers-tab" data-bs-toggle="tab" data-bs-target="#all-headers" type="button" role="tab">
                            All Headers
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab">
                            Security Analysis
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="headerTabsContent">
                    <div class="tab-pane fade show active" id="all-headers" role="tabpanel">
                        <div class="table-responsive mt-3">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 30%">Header Name</th>
                                        <th>Header Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${headersHtml}
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="security" role="tabpanel">
                        <div class="table-responsive mt-3">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 30%">Security Header</th>
                                        <th style="width: 20%">Status</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${securityHtml}
                                </tbody>
                            </table>
                        </div>

                        <div class="alert alert-warning mt-3">
                            <h6><i class="fas fa-shield-alt me-2"></i>Security Recommendations</h6>
                            <ul class="mb-0">
                                <li>Ensure HTTPS is enforced with HSTS header</li>
                                <li>Implement Content Security Policy (CSP) to prevent XSS</li>
                                <li>Set X-Frame-Options to prevent clickjacking</li>
                                <li>Use X-Content-Type-Options to prevent MIME sniffing</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.getElementById('results-content').innerHTML = html;
    document.getElementById('results').style.display = 'block';
}

function displayError(error) {
    const html = `
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Error:</strong> ${error}
        </div>
    `;

    document.getElementById('results-content').innerHTML = html;
    document.getElementById('results').style.display = 'block';
}

function getStatusClass(statusCode) {
    const code = parseInt(statusCode);
    if (code >= 200 && code < 300) return 'success';
    if (code >= 300 && code < 400) return 'warning';
    if (code >= 400) return 'danger';
    return 'info';
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show temporary success message
        const btn = event.target.closest('button');
        const originalContent = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i>';
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('btn-success');

        setTimeout(function() {
            btn.innerHTML = originalContent;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-secondary');
        }, 2000);
    });
}
</script>

