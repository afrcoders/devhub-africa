{{-- website screenshot generator --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    website screenshot generator tool for your development and productivity needs.
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
                    Generate high-quality screenshots of websites in various resolutions and formats
                </p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="screenshot-form">
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
                                Enter the complete URL including http:// or https://
                            </small>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="device_type" class="form-label">
                                    <i class="fas fa-desktop me-2"></i>Device Type
                                </label>
                                <select class="form-select" id="device_type" name="device_type">
                                    <option value="desktop" selected>Desktop</option>
                                    <option value="tablet">Tablet</option>
                                    <option value="mobile">Mobile</option>
                                    <option value="custom">Custom Resolution</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="format" class="form-label">
                                    <i class="fas fa-file-image me-2"></i>Output Format
                                </label>
                                <select class="form-select" id="format" name="format">
                                    <option value="png" selected>PNG (Best Quality)</option>
                                    <option value="jpg">JPG (Smaller Size)</option>
                                    <option value="webp">WebP (Modern)</option>
                                    <option value="pdf">PDF (Document)</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4" id="custom-resolution" style="display: none;">
                            <div class="col-md-6">
                                <label for="width" class="form-label">Width (px)</label>
                                <input type="number" class="form-control" id="width" name="width" min="320" max="3840" value="1920">
                            </div>
                            <div class="col-md-6">
                                <label for="height" class="form-label">Height (px)</label>
                                <input type="number" class="form-control" id="height" name="height" min="240" max="2160" value="1080">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="capture_type" class="form-label">
                                    <i class="fas fa-arrows-alt-v me-2"></i>Capture Type
                                </label>
                                <select class="form-select" id="capture_type" name="capture_type">
                                    <option value="viewport">Viewport Only</option>
                                    <option value="fullpage" selected>Full Page</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="delay" class="form-label">
                                    <i class="fas fa-clock me-2"></i>Load Delay
                                </label>
                                <select class="form-select" id="delay" name="delay">
                                    <option value="0">No Delay</option>
                                    <option value="2" selected>2 seconds</option>
                                    <option value="5">5 seconds</option>
                                    <option value="10">10 seconds</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="hide_cookie_banners" name="hide_cookie_banners">
                                    <label class="form-check-label" for="hide_cookie_banners">
                                        <i class="fas fa-cookie-bite me-2"></i>Hide Cookie Banners
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="block_ads" name="block_ads">
                                    <label class="form-check-label" for="block_ads">
                                        <i class="fas fa-ad me-2"></i>Block Advertisements
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="dark_mode" name="dark_mode">
                                    <label class="form-check-label" for="dark_mode">
                                        <i class="fas fa-moon me-2"></i>Force Dark Mode
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-camera me-2"></i>Generate Screenshot
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
                        <span class="text-muted">Capturing screenshot...</span>
                        <div class="progress mt-3">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
                        </div>
                        <small class="text-muted mt-2 d-block">This may take 10-30 seconds depending on the website</small>
                    </div>
                </div>
            </div>

            <!-- Results -->
            <div id="results" class="mt-4" style="display: none;">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-image me-2"></i>Screenshot Generated
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
                    <i class="fas fa-info-circle me-2"></i>Screenshot Features
                </h6>
                <p class="mb-2">
                    Our screenshot generator offers:
                </p>
                <ul class="mb-2">
                    <li><strong>Multiple Devices</strong> - Desktop, tablet, and mobile viewports</li>
                    <li><strong>Full Page Capture</strong> - Capture entire page or just viewport</li>
                    <li><strong>Multiple Formats</strong> - PNG, JPG, WebP, and PDF output</li>
                    <li><strong>Smart Features</strong> - Hide cookie banners and block ads</li>
                    <li><strong>Custom Resolutions</strong> - Specify exact dimensions</li>
                </ul>
                <p class="mb-0">
                    <small><strong>Best for:</strong> Website previews, documentation, testing, and design reviews.</small>
                </p>
            </div>

            <!-- Usage Tips -->
            <div class="alert alert-success mt-4">
                <h6 class="alert-heading">
                    <i class="fas fa-lightbulb me-2"></i>Tips for Better Screenshots
                </h6>
                <ul class="mb-0">
                    <li>Use load delay for JavaScript-heavy websites</li>
                    <li>Full page capture works best for most websites</li>
                    <li>PNG format provides the best quality for detailed images</li>
                    <li>PDF format is great for documentation purposes</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deviceTypeSelect = document.getElementById('device_type');
    const customResolution = document.getElementById('custom-resolution');
    const widthInput = document.getElementById('width');
    const heightInput = document.getElementById('height');

    // Show/hide custom resolution inputs
    deviceTypeSelect.addEventListener('change', function() {
        if (this.value === 'custom') {
            customResolution.style.display = 'block';
        } else {
            customResolution.style.display = 'none';
            // Set predefined resolutions
            switch(this.value) {
                case 'desktop':
                    widthInput.value = 1920;
                    heightInput.value = 1080;
                    break;
                case 'tablet':
                    widthInput.value = 768;
                    heightInput.value = 1024;
                    break;
                case 'mobile':
                    widthInput.value = 375;
                    heightInput.value = 667;
                    break;
            }
        }
    });
});

document.getElementById('screenshot-form').addEventListener('submit', async function(e) {
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
    document.getElementById('results').style.display = 'none';

    const formData = new FormData();
    formData.append('website_url', websiteUrl);
    formData.append('device_type', document.getElementById('device_type').value);
    formData.append('format', document.getElementById('format').value);
    formData.append('width', document.getElementById('width').value);
    formData.append('height', document.getElementById('height').value);
    formData.append('capture_type', document.getElementById('capture_type').value);
    formData.append('delay', document.getElementById('delay').value);
    formData.append('hide_cookie_banners', document.getElementById('hide_cookie_banners').checked);
    formData.append('block_ads', document.getElementById('block_ads').checked);
    formData.append('dark_mode', document.getElementById('dark_mode').checked);
    formData.append('_token', document.querySelector('[name="_token"]').value);

    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "website-screenshot-generator") }}', {
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
    const screenshotUrl = result.screenshot_url;
    const downloadUrl = result.download_url;
    const websiteUrl = result.website_url;
    const dimensions = result.dimensions;
    const fileSize = result.file_size;
    const format = result.format.toUpperCase();

    const html = `
        <div class="text-center mb-4">
            <div class="screenshot-preview mb-3">
                <img src="${screenshotUrl}" alt="Website Screenshot" class="img-fluid border rounded shadow-sm" style="max-height: 400px;">
            </div>
            <a href="${downloadUrl}" class="btn btn-success btn-lg" download>
                <i class="fas fa-download me-2"></i>Download ${format} Screenshot
            </a>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Screenshot Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2"><strong>Website:</strong> <a href="${websiteUrl}" target="_blank" class="text-break">${websiteUrl}</a></div>
                                <div class="mb-2"><strong>Dimensions:</strong> ${dimensions}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2"><strong>Format:</strong> ${format}</div>
                                <div class="mb-2"><strong>File Size:</strong> ${formatFileSize(fileSize)}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Capture Settings</div>
                    <div class="card-body">
                        <div class="mb-2"><strong>Device:</strong> ${result.device_type}</div>
                        <div class="mb-2"><strong>Capture:</strong> ${result.capture_type}</div>
                        <div class="mb-2"><strong>Load Delay:</strong> ${result.delay}s</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Applied Filters</div>
                    <div class="card-body">
                        <div class="mb-2">
                            <span class="badge ${result.hide_cookie_banners ? 'bg-success' : 'bg-secondary'}">
                                Cookie Banners ${result.hide_cookie_banners ? 'Hidden' : 'Visible'}
                            </span>
                        </div>
                        <div class="mb-2">
                            <span class="badge ${result.block_ads ? 'bg-success' : 'bg-secondary'}">
                                Ads ${result.block_ads ? 'Blocked' : 'Allowed'}
                            </span>
                        </div>
                        <div class="mb-2">
                            <span class="badge ${result.dark_mode ? 'bg-success' : 'bg-secondary'}">
                                Dark Mode ${result.dark_mode ? 'Enabled' : 'Disabled'}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-info mt-3">
            <h6><i class="fas fa-lightbulb me-2"></i>What's Next?</h6>
            <ul class="mb-0">
                <li>Right-click the screenshot to save or copy to clipboard</li>
                <li>Use the download button to get the full-resolution file</li>
                <li>The screenshot will be automatically deleted after 2 hours</li>
                <li>Share the preview link with others for quick viewing</li>
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
                <li>Make sure the URL is accessible and not behind authentication</li>
                <li>Check that the website allows screenshots (some sites block this)</li>
                <li>Try increasing the load delay for slow-loading websites</li>
                <li>Some websites may have anti-bot measures that prevent screenshots</li>
                <li>Verify the URL is correct and includes the protocol (http/https)</li>
            </ul>
        </div>
    `;

    document.getElementById('results-content').innerHTML = html;
    document.getElementById('results').style.display = 'block';
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}
</script>

