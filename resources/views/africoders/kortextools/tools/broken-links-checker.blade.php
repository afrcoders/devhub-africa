{{-- broken links checker --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    broken links checker tool for your development and productivity needs.
</div>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-unlink fa-3x text-primary"></i>
                </div>
                <h1 class="h2 mb-3">Broken Links Checker</h1>
                <p class="lead text-muted">
                    Find and fix broken links on your website to improve SEO and user experience
                </p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="broken-links-form">
                        @csrf
                        <div class="mb-4">
                            <label for="url" class="form-label">
                                <i class="fas fa-link me-2"></i>Website URL to Check
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
                                Enter the full URL of the webpage you want to check for broken links
                            </small>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-search me-2"></i>Check for Broken Links
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
                        <div class="mt-2">
                            <small class="text-muted">This may take a few moments depending on the number of links</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results -->
            <div id="results" class="mt-4" style="display: none;">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-list-alt me-2"></i>Link Analysis Results
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
                    <i class="fas fa-info-circle me-2"></i>About Broken Links Checking
                </h6>
                <p class="mb-2">
                    This tool helps you maintain website quality by finding broken links:
                </p>
                <ul class="mb-2">
                    <li><strong>SEO Benefits</strong> - Fix broken links to improve search engine rankings</li>
                    <li><strong>User Experience</strong> - Ensure visitors don't encounter dead pages</li>
                    <li><strong>Internal Links</strong> - Focus on links within your domain</li>
                    <li><strong>Status Codes</strong> - Identify 404, 500, and other error responses</li>
                    <li><strong>Response Times</strong> - Check link loading performance</li>
                </ul>
                <p class="mb-0">
                    <small><strong>Best for:</strong> Website maintenance, SEO audits, quality assurance, and user experience optimization.</small>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('broken-links-form').addEventListener('submit', async function(e) {
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
    const analysis = result.analysis;
    const url = result.url;

    let summaryClass = 'success';
    if (analysis.broken_links > 0) {
        summaryClass = analysis.broken_links > analysis.working_links ? 'danger' : 'warning';
    }

    let linksHtml = '';
    if (analysis.links && analysis.links.length > 0) {
        linksHtml = analysis.links.map(link => {
            const statusClass = link.is_broken ? 'danger' : 'success';
            const statusIcon = link.is_broken ? 'times-circle' : 'check-circle';

            return `
                <tr>
                    <td>
                        <a href="${link.url}" target="_blank" class="text-decoration-none">
                            ${link.url.length > 50 ? link.url.substring(0, 50) + '...' : link.url}
                        </a>
                    </td>
                    <td>
                        <span class="badge bg-${statusClass}">
                            <i class="fas fa-${statusIcon} me-1"></i>
                            ${link.status_code} ${link.status_text}
                        </span>
                    </td>
                    <td class="text-end">
                        <small class="text-muted">${link.response_time}ms</small>
                    </td>
                </tr>
            `;
        }).join('');
    }

    const html = `
        <div class="row mb-4">
            <div class="col-12">
                <h6>Summary for: <span class="text-primary">${url}</span></h6>
                <div class="alert alert-${summaryClass}">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="d-flex flex-column">
                                <span class="fs-4 fw-bold">${analysis.total_links}</span>
                                <small>Total Links</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex flex-column">
                                <span class="fs-4 fw-bold text-success">${analysis.working_links}</span>
                                <small>Working Links</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex flex-column">
                                <span class="fs-4 fw-bold text-danger">${analysis.broken_links}</span>
                                <small>Broken Links</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex flex-column">
                                <span class="fs-4 fw-bold">${Math.round((analysis.working_links / analysis.total_links) * 100)}%</span>
                                <small>Success Rate</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        ${analysis.total_links > 0 ? `
            <div class="row">
                <div class="col-12">
                    <h6>Detailed Link Analysis ${analysis.links.length < analysis.total_links ? `(Showing first ${analysis.links.length} links)` : ''}</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>URL</th>
                                    <th>Status</th>
                                    <th class="text-end">Response Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${linksHtml}
                            </tbody>
                        </table>
                    </div>

                    ${analysis.broken_links > 0 ? `
                        <div class="alert alert-warning mt-3">
                            <h6><i class="fas fa-exclamation-triangle me-2"></i>Recommendations</h6>
                            <ul class="mb-0">
                                <li>Fix or remove broken links to improve SEO</li>
                                <li>Update redirects (301/302) if they're permanent</li>
                                <li>Check external links regularly as they may change</li>
                                <li>Consider implementing proper 404 error pages</li>
                            </ul>
                        </div>
                    ` : `
                        <div class="alert alert-success mt-3">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Great!</strong> No broken links were found on this page.
                        </div>
                    `}
                </div>
            </div>
        ` : `
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                No links were found on this page to check.
            </div>
        `}
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
</script>

