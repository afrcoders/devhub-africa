{{-- websites broken link checker --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    websites broken link checker tool for your development and productivity needs.
</div>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-link fa-3x text-primary"></i>
                </div>
                <h1 class="h2 mb-3">Broken Links Checker</h1>
                <p class="lead text-muted">
                    Scan websites for broken links, dead URLs, and connectivity issues. Improve your site's SEO and user experience
                </p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="broken-links-form">
                        @csrf
                        <div class="mb-4">
                            <label for="website_url" class="form-label">
                                <i class="fas fa-globe me-2"></i>Website URL
                            </label>
                            <input
                                type="url"
                                class="form-control form-control-lg"
                                id="website_url"
                                name="website_url"
                                placeholder="https://example.com"
                                required
                            >
                            <small class="form-text text-muted">
                                Enter the website URL to scan for broken links
                            </small>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="scan_depth" class="form-label">
                                    <i class="fas fa-layer-group me-2"></i>Scan Depth
                                </label>
                                <select class="form-select" id="scan_depth" name="scan_depth">
                                    <option value="1" selected>Current Page Only</option>
                                    <option value="2">1 Level Deep</option>
                                    <option value="3">2 Levels Deep</option>
                                    <option value="unlimited">Entire Website</option>
                                </select>
                                <small class="form-text text-muted">
                                    How deep to crawl the website
                                </small>
                            </div>
                            <div class="col-md-6">
                                <label for="max_links" class="form-label">
                                    <i class="fas fa-hashtag me-2"></i>Maximum Links
                                </label>
                                <select class="form-select" id="max_links" name="max_links">
                                    <option value="50" selected>50 links</option>
                                    <option value="100">100 links</option>
                                    <option value="250">250 links</option>
                                    <option value="500">500 links</option>
                                </select>
                                <small class="form-text text-muted">
                                    Limit the number of links to check
                                </small>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check_internal" name="check_internal" checked>
                                    <label class="form-check-label" for="check_internal">
                                        <i class="fas fa-home me-2"></i>Check Internal Links
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check_external" name="check_external" checked>
                                    <label class="form-check-label" for="check_external">
                                        <i class="fas fa-external-link-alt me-2"></i>Check External Links
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check_images" name="check_images">
                                    <label class="form-check-label" for="check_images">
                                        <i class="fas fa-image me-2"></i>Check Image Links
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check_css_js" name="check_css_js">
                                    <label class="form-check-label" for="check_css_js">
                                        <i class="fas fa-code me-2"></i>Check CSS/JS Resources
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-search me-2"></i>Start Link Check
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
                        <span class="text-muted">Scanning website for broken links...</span>
                        <div class="progress mt-3">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
                        </div>
                        <small class="text-muted mt-2 d-block">This may take several minutes depending on website size</small>
                    </div>
                </div>
            </div>

            <!-- Progress Updates -->
            <div id="progress" class="mt-4" style="display: none;">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <div id="progress-content"></div>
                    </div>
                </div>
            </div>

            <!-- Results -->
            <div id="results" class="mt-4" style="display: none;">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-line me-2"></i>Link Check Results
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
                    <i class="fas fa-info-circle me-2"></i>Broken Link Checker Features
                </h6>
                <p class="mb-2">
                    Our comprehensive link checker provides:
                </p>
                <ul class="mb-2">
                    <li><strong>Deep Crawling</strong> - Scan single pages or entire websites</li>
                    <li><strong>Link Types</strong> - Check internal, external, images, and resources</li>
                    <li><strong>Status Codes</strong> - Identify 404s, 500s, redirects, and timeouts</li>
                    <li><strong>Performance Metrics</strong> - Response times and accessibility</li>
                    <li><strong>Detailed Reports</strong> - Export results for further analysis</li>
                </ul>
                <p class="mb-0">
                    <small><strong>Best for:</strong> SEO optimization, website maintenance, quality assurance, and user experience improvement.</small>
                </p>
            </div>

            <!-- Best Practices -->
            <div class="alert alert-success mt-4">
                <h6 class="alert-heading">
                    <i class="fas fa-lightbulb me-2"></i>Best Practices
                </h6>
                <ul class="mb-0">
                    <li>Run regular link checks to maintain website health</li>
                    <li>Fix broken links promptly to improve SEO rankings</li>
                    <li>Check both internal and external links for comprehensive coverage</li>
                    <li>Consider using 301 redirects for moved content</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
let checkInterval;

document.getElementById('broken-links-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const websiteUrl = document.getElementById('website_url').value.trim();

    if (!websiteUrl) {
        alert('Please enter a website URL');
        return;
    }

    // Validate URL
    try {
        new URL(websiteUrl);
    } catch {
        alert('Please enter a valid URL (including http:// or https://)');
        return;
    }

    // Show loading
    document.getElementById('loading').style.display = 'block';
    document.getElementById('progress').style.display = 'none';
    document.getElementById('results').style.display = 'none';

    const formData = new FormData();
    formData.append('website_url', websiteUrl);
    formData.append('scan_depth', document.getElementById('scan_depth').value);
    formData.append('max_links', document.getElementById('max_links').value);
    formData.append('check_internal', document.getElementById('check_internal').checked);
    formData.append('check_external', document.getElementById('check_external').checked);
    formData.append('check_images', document.getElementById('check_images').checked);
    formData.append('check_css_js', document.getElementById('check_css_js').checked);
    formData.append('_token', document.querySelector('[name="_token"]').value);

    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "websites-broken-link-checker") }}', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        // Hide loading
        document.getElementById('loading').style.display = 'none';

        if (result.success) {
            if (result.job_id) {
                // Long-running job, start polling for progress
                startProgressPolling(result.job_id);
            } else {
                // Immediate results
                displayResults(result);
            }
        } else {
            displayError(result.error || 'An error occurred');
        }
    } catch (error) {
        document.getElementById('loading').style.display = 'none';
        displayError('Network error: ' + error.message);
    }
});

function startProgressPolling(jobId) {
    document.getElementById('progress').style.display = 'block';

    checkInterval = setInterval(async () => {
        try {
            const response = await fetch(`{{ route("tools.kortex.tool.submit", "websites-broken-link-checker") }}?job_id=${jobId}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
                }
            });

            const result = await response.json();

            if (result.status === 'completed') {
                clearInterval(checkInterval);
                document.getElementById('progress').style.display = 'none';
                displayResults(result);
            } else if (result.status === 'failed') {
                clearInterval(checkInterval);
                document.getElementById('progress').style.display = 'none';
                displayError(result.error || 'Link check failed');
            } else {
                updateProgress(result);
            }
        } catch (error) {
            clearInterval(checkInterval);
            document.getElementById('progress').style.display = 'none';
            displayError('Error checking progress: ' + error.message);
        }
    }, 3000); // Poll every 3 seconds
}

function updateProgress(result) {
    const progress = result.progress || {};
    const checkedLinks = progress.checked_links || 0;
    const totalLinks = progress.total_links || 0;
    const currentPage = progress.current_page || '';

    const percentage = totalLinks > 0 ? Math.round((checkedLinks / totalLinks) * 100) : 0;

    const html = `
        <div class="mb-3">
            <div class="d-flex justify-content-between mb-2">
                <span><i class="fas fa-link me-2"></i>Checking links...</span>
                <span>${checkedLinks} / ${totalLinks} links</span>
            </div>
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated"
                     role="progressbar"
                     style="width: ${percentage}%"
                     aria-valuenow="${percentage}"
                     aria-valuemin="0"
                     aria-valuemax="100">
                    ${percentage}%
                </div>
            </div>
        </div>
        ${currentPage ? `<small class="text-muted">Currently scanning: ${currentPage}</small>` : ''}
    `;

    document.getElementById('progress-content').innerHTML = html;
}

function displayResults(result) {
    const summary = result.summary || {};
    const brokenLinks = result.broken_links || [];
    const warnings = result.warnings || [];
    const downloadUrl = result.download_url;

    const totalLinks = summary.total_checked || 0;
    const brokenCount = summary.broken_count || 0;
    const warningCount = summary.warning_count || 0;
    const healthScore = Math.round(((totalLinks - brokenCount) / totalLinks) * 100) || 0;

    let html = `
        <div class="row mb-4">
            <div class="col-md-3 col-6">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="fs-4 text-primary">${totalLinks}</div>
                        <small class="text-muted">Total Links</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="fs-4 text-success">${totalLinks - brokenCount - warningCount}</div>
                        <small class="text-muted">Working Links</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="fs-4 text-danger">${brokenCount}</div>
                        <small class="text-muted">Broken Links</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="fs-4 text-warning">${warningCount}</div>
                        <small class="text-muted">Warnings</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-heart-pulse me-2"></i>Website Health Score
                        </h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="fs-1 ${healthScore >= 90 ? 'text-success' : healthScore >= 70 ? 'text-warning' : 'text-danger'} mb-2">
                            ${healthScore}%
                        </div>
                        <div class="progress mb-2">
                            <div class="progress-bar ${healthScore >= 90 ? 'bg-success' : healthScore >= 70 ? 'bg-warning' : 'bg-danger'}"
                                 role="progressbar"
                                 style="width: ${healthScore}%">
                            </div>
                        </div>
                        <small class="text-muted">
                            ${healthScore >= 90 ? 'Excellent' : healthScore >= 70 ? 'Good' : 'Needs Improvement'}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        ${downloadUrl ? `
            <div class="text-center mb-4">
                <a href="${downloadUrl}" class="btn btn-outline-primary" download>
                    <i class="fas fa-download me-2"></i>Download Full Report
                </a>
            </div>
        ` : ''}
    `;

    // Broken Links Section
    if (brokenLinks.length > 0) {
        html += `
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-times-circle text-danger me-2"></i>Broken Links (${brokenLinks.length})
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>URL</th>
                                    <th>Status</th>
                                    <th>Found On</th>
                                    <th>Error</th>
                                </tr>
                            </thead>
                            <tbody>
        `;

        brokenLinks.slice(0, 20).forEach(link => {
            html += `
                <tr>
                    <td class="text-break">
                        <a href="${link.url}" target="_blank" class="text-decoration-none">
                            ${link.url.length > 60 ? link.url.substring(0, 60) + '...' : link.url}
                        </a>
                    </td>
                    <td><span class="badge bg-danger">${link.status_code}</span></td>
                    <td class="text-break">
                        <small>${link.found_on.length > 40 ? link.found_on.substring(0, 40) + '...' : link.found_on}</small>
                    </td>
                    <td><small class="text-muted">${link.error}</small></td>
                </tr>
            `;
        });

        html += `
                            </tbody>
                        </table>
                    </div>
                    ${brokenLinks.length > 20 ? `
                        <small class="text-muted">Showing 20 of ${brokenLinks.length} broken links. Download full report for complete list.</small>
                    ` : ''}
                </div>
            </div>
        `;
    }

    // Warnings Section
    if (warnings.length > 0) {
        html += `
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>Warnings (${warnings.length})
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>URL</th>
                                    <th>Status</th>
                                    <th>Issue</th>
                                </tr>
                            </thead>
                            <tbody>
        `;

        warnings.slice(0, 10).forEach(warning => {
            html += `
                <tr>
                    <td class="text-break">
                        <a href="${warning.url}" target="_blank" class="text-decoration-none">
                            ${warning.url.length > 60 ? warning.url.substring(0, 60) + '...' : warning.url}
                        </a>
                    </td>
                    <td><span class="badge bg-warning">${warning.status_code}</span></td>
                    <td><small class="text-muted">${warning.issue}</small></td>
                </tr>
            `;
        });

        html += `
                            </tbody>
                        </table>
                    </div>
                    ${warnings.length > 10 ? `
                        <small class="text-muted">Showing 10 of ${warnings.length} warnings. Download full report for complete list.</small>
                    ` : ''}
                </div>
            </div>
        `;
    }

    // Success message if no issues
    if (brokenCount === 0 && warningCount === 0) {
        html += `
            <div class="alert alert-success">
                <h5><i class="fas fa-check-circle me-2"></i>Great News!</h5>
                <p class="mb-0">No broken links were found on your website. All ${totalLinks} links are working properly!</p>
            </div>
        `;
    }

    html += `
        <div class="alert alert-info mt-3">
            <h6><i class="fas fa-lightbulb me-2"></i>Next Steps</h6>
            <ul class="mb-0">
                <li>Fix all broken links to improve user experience and SEO</li>
                <li>Set up regular monitoring to catch issues early</li>
                <li>Consider implementing 301 redirects for moved content</li>
                <li>Update or remove links to external sites that are no longer available</li>
            </ul>
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

        <div class="alert alert-info">
            <h6><i class="fas fa-lightbulb me-2"></i>Common Issues</h6>
            <ul class="mb-0">
                <li>Make sure the website is publicly accessible</li>
                <li>Check that the URL is correct and includes the protocol</li>
                <li>Some websites may block automated scanners</li>
                <li>Large websites may time out - try reducing the scan depth</li>
                <li>Websites with authentication may not be fully scannable</li>
            </ul>
        </div>
    `;

    document.getElementById('results-content').innerHTML = html;
    document.getElementById('results').style.display = 'block';
}

// Cleanup interval on page unload
window.addEventListener('beforeunload', function() {
    if (checkInterval) {
        clearInterval(checkInterval);
    }
});
</script>

