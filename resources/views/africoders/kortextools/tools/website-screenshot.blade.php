{{-- website screenshot --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    website screenshot tool for your development and productivity needs.
</div>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-camera fa-3x text-primary"></i>
                </div>
                <h1 class="h2 mb-3">Website Screenshot Generator</h1>
                <p class="lead text-muted">
                    Capture high-quality screenshots of any website for previews and documentation
                </p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="screenshot-form">
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
                                Enter the full URL of the website you want to screenshot
                            </small>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="width" class="form-label">
                                    <i class="fas fa-arrows-alt-h me-2"></i>Width (px)
                                </label>
                                <select class="form-select" id="width" name="width">
                                    <option value="1920">Desktop Full HD (1920px)</option>
                                    <option value="1366">Desktop Standard (1366px)</option>
                                    <option value="1024">Tablet Landscape (1024px)</option>
                                    <option value="768">Tablet Portrait (768px)</option>
                                    <option value="375">Mobile (375px)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="height" class="form-label">
                                    <i class="fas fa-arrows-alt-v me-2"></i>Height (px)
                                </label>
                                <select class="form-select" id="height" name="height">
                                    <option value="1080">Full HD (1080px)</option>
                                    <option value="768">Standard (768px)</option>
                                    <option value="600">Compact (600px)</option>
                                    <option value="full">Full Page</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-palette me-2"></i>Format
                                </label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="format" id="format-png" value="png" checked>
                                    <label class="form-check-label" for="format-png">
                                        PNG (Better quality, larger file)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="format" id="format-jpg" value="jpg">
                                    <label class="form-check-label" for="format-jpg">
                                        JPEG (Smaller file, faster loading)
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="delay" class="form-label">
                                    <i class="fas fa-clock me-2"></i>Delay (seconds)
                                </label>
                                <select class="form-select" id="delay" name="delay">
                                    <option value="0">No delay</option>
                                    <option value="1">1 second</option>
                                    <option value="2" selected>2 seconds</option>
                                    <option value="3">3 seconds</option>
                                    <option value="5">5 seconds</option>
                                </select>
                                <small class="form-text text-muted">Wait time for page to load completely</small>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-camera me-2"></i>Capture Screenshot
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
                        <span class="text-muted">Capturing website screenshot...</span>
                        <div class="mt-2">
                            <small class="text-muted">This may take a few seconds while the page loads</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results -->
            <div id="results" class="mt-4" style="display: none;">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-image me-2"></i>Screenshot Result
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
                    <i class="fas fa-info-circle me-2"></i>About Website Screenshots
                </h6>
                <p class="mb-2">
                    This tool helps you capture website screenshots for various purposes:
                </p>
                <ul class="mb-2">
                    <li><strong>Documentation</strong> - Create visual records of web pages</li>
                    <li><strong>Monitoring</strong> - Track website changes over time</li>
                    <li><strong>Presentations</strong> - Include website previews in reports</li>
                    <li><strong>Quality Assurance</strong> - Compare different device views</li>
                    <li><strong>Marketing</strong> - Create thumbnails for link previews</li>
                </ul>
                <p class="mb-0">
                    <small><strong>Best for:</strong> Web developers, designers, marketers, and documentation needs.</small>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('screenshot-form').addEventListener('submit', async function(e) {
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
    formData.append('width', document.getElementById('width').value);
    formData.append('height', document.getElementById('height').value);
    formData.append('format', document.querySelector('input[name="format"]:checked').value);
    formData.append('delay', document.getElementById('delay').value);
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
    const screenshot = result.screenshot;

    // For demo purposes, we'll show a placeholder
    const imageHtml = screenshot.demo_mode ?
        `<div class="text-center p-5 bg-light border rounded">
            <i class="fas fa-image fa-4x text-muted mb-3"></i>
            <h5 class="text-muted">Screenshot Demo</h5>
            <p class="text-muted mb-0">
                This is a demo version. In production, you would see the actual screenshot of:<br>
                <strong>${result.url}</strong>
            </p>
        </div>` :
        `<img src="data:image/${screenshot.format};base64,${screenshot.data}"
              class="img-fluid rounded shadow"
              alt="Screenshot of ${result.url}">`;

    const html = `
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="mb-1">Screenshot of:</h6>
                        <a href="${result.url}" target="_blank" class="text-decoration-none">
                            ${result.url}
                        </a>
                    </div>
                    ${!screenshot.demo_mode ? `
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="downloadScreenshot()">
                                <i class="fas fa-download me-1"></i>Download
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="copyToClipboard()">
                                <i class="fas fa-copy me-1"></i>Copy Link
                            </button>
                        </div>
                    ` : ''}
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                ${imageHtml}
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card bg-light">
                    <div class="card-body p-3">
                        <h6 class="card-title mb-3">Screenshot Details</h6>
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">${screenshot.width}x${screenshot.height}</span>
                                    <small class="text-muted">Dimensions</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">${screenshot.format.toUpperCase()}</span>
                                    <small class="text-muted">Format</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">${screenshot.file_size}</span>
                                    <small class="text-muted">File Size</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">${screenshot.capture_time}ms</span>
                                    <small class="text-muted">Capture Time</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        ${screenshot.demo_mode ? `
            <div class="alert alert-warning mt-3">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Demo Mode:</strong> This tool requires additional server configuration to capture real screenshots.
                The actual implementation would use headless browser technology to generate high-quality website screenshots.
            </div>
        ` : ''}
    `;

    document.getElementById('results-content').innerHTML = html;
    document.getElementById('results').style.display = 'block';

    // Store screenshot data for download
    if (!screenshot.demo_mode) {
        window.screenshotData = {
            data: screenshot.data,
            format: screenshot.format,
            filename: screenshot.filename || 'screenshot.' + screenshot.format
        };
    }
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

function downloadScreenshot() {
    if (!window.screenshotData) return;

    const link = document.createElement('a');
    link.href = 'data:image/' + window.screenshotData.format + ';base64,' + window.screenshotData.data;
    link.download = window.screenshotData.filename;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function copyToClipboard() {
    if (!window.screenshotData) return;

    const dataUrl = 'data:image/' + window.screenshotData.format + ';base64,' + window.screenshotData.data;
    navigator.clipboard.writeText(dataUrl).then(function() {
        // Show temporary success message
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check me-1"></i>Copied!';
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('btn-success');

        setTimeout(function() {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-secondary');
        }, 2000);
    });
}
</script>

