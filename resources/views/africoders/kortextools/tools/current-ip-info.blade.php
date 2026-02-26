{{-- current ip info --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    current ip info tool for your development and productivity needs.
</div>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-globe-americas fa-3x text-primary"></i>
                </div>
                <h1 class="h2 mb-3">IP Address Information</h1>
                <p class="lead text-muted">
                    Get detailed information about any IP address including location, ISP, and network details
                </p>
            </div>

            <!-- Current IP Display -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center p-4">
                    <h5 class="mb-3">Your Current IP Address</h5>
                    <div class="fs-4 text-primary mb-2" id="current-ip">Loading...</div>
                    <button class="btn btn-outline-primary btn-sm" onclick="lookupCurrentIP()">
                        <i class="fas fa-search me-2"></i>Get My IP Info
                    </button>
                </div>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="ip-info-form">
                        @csrf
                        <div class="mb-4">
                            <label for="ip" class="form-label">
                                <i class="fas fa-network-wired me-2"></i>IP Address
                            </label>
                            <input
                                type="text"
                                class="form-control form-control-lg"
                                id="ip"
                                name="ip"
                                placeholder="8.8.8.8 or 2001:4860:4860::8888"
                                required
                            >
                            <small class="form-text text-muted">
                                Enter an IPv4 or IPv6 address to lookup
                            </small>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-search me-2"></i>Lookup IP Information
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
                        <span class="text-muted">Looking up IP information...</span>
                    </div>
                </div>
            </div>

            <!-- Results -->
            <div id="results" class="mt-4" style="display: none;">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>IP Address Details
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
                    <i class="fas fa-info-circle me-2"></i>About IP Address Lookup
                </h6>
                <p class="mb-2">
                    IP address lookup provides valuable network information:
                </p>
                <ul class="mb-2">
                    <li><strong>Geolocation</strong> - Country, region, city, and coordinates</li>
                    <li><strong>ISP Information</strong> - Internet Service Provider details</li>
                    <li><strong>Network Details</strong> - ASN, organization, and network range</li>
                    <li><strong>Timezone</strong> - Local timezone and UTC offset</li>
                    <li><strong>Security Info</strong> - Proxy, VPN, and threat detection</li>
                </ul>
                <p class="mb-0">
                    <small><strong>Best for:</strong> Network troubleshooting, security analysis, geotargeting, and access control.</small>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
// Get current IP on page load
document.addEventListener('DOMContentLoaded', function() {
    getCurrentIP();
});

async function getCurrentIP() {
    try {
        const response = await fetch('https://api.ipify.org?format=json');
        const data = await response.json();
        document.getElementById('current-ip').textContent = data.ip;
    } catch (error) {
        document.getElementById('current-ip').textContent = 'Unable to detect';
    }
}

function lookupCurrentIP() {
    const currentIP = document.getElementById('current-ip').textContent;
    if (currentIP && currentIP !== 'Loading...' && currentIP !== 'Unable to detect') {
        document.getElementById('ip').value = currentIP;
        document.getElementById('ip-info-form').dispatchEvent(new Event('submit'));
    }
}

document.getElementById('ip-info-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const ip = document.getElementById('ip').value.trim();
    if (!ip) {
        alert('Please enter an IP address');
        return;
    }

    // Show loading
    document.getElementById('loading').style.display = 'block';
    document.getElementById('results').style.display = 'none';

    const formData = new FormData();
    formData.append('ip', ip);
    formData.append('_token', document.querySelector('[name="_token"]').value);

    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "current-ip-info") }}', {
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
    const info = result.ip_info;

    const html = `
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Location</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2"><strong>IP Address:</strong> <code>${info.ip || 'N/A'}</code></div>
                        <div class="mb-2"><strong>Country:</strong> ${info.country || 'N/A'}</div>
                        <div class="mb-2"><strong>Region:</strong> ${info.region || 'N/A'}</div>
                        <div class="mb-2"><strong>City:</strong> ${info.city || 'N/A'}</div>
                        <div class="mb-2"><strong>Postal Code:</strong> ${info.postal || 'N/A'}</div>
                        <div class="mb-2"><strong>Coordinates:</strong> ${info.latitude && info.longitude ? `${info.latitude}, ${info.longitude}` : 'N/A'}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-building me-2"></i>ISP & Network</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2"><strong>ISP:</strong> ${info.isp || 'N/A'}</div>
                        <div class="mb-2"><strong>Organization:</strong> ${info.organization || 'N/A'}</div>
                        <div class="mb-2"><strong>ASN:</strong> ${info.asn || 'N/A'}</div>
                        <div class="mb-2"><strong>Network:</strong> ${info.network || 'N/A'}</div>
                        <div class="mb-2"><strong>Type:</strong> ${info.type || 'N/A'}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-clock me-2"></i>Time & Zone</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2"><strong>Timezone:</strong> ${info.timezone || 'N/A'}</div>
                        <div class="mb-2"><strong>UTC Offset:</strong> ${info.utc_offset || 'N/A'}</div>
                        <div class="mb-2"><strong>Local Time:</strong> ${info.local_time || 'N/A'}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-shield-alt me-2"></i>Security</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <strong>Proxy:</strong>
                            <span class="badge ${info.is_proxy ? 'bg-warning' : 'bg-success'}">
                                ${info.is_proxy ? 'Detected' : 'None'}
                            </span>
                        </div>
                        <div class="mb-2">
                            <strong>VPN:</strong>
                            <span class="badge ${info.is_vpn ? 'bg-warning' : 'bg-success'}">
                                ${info.is_vpn ? 'Detected' : 'None'}
                            </span>
                        </div>
                        <div class="mb-2">
                            <strong>Threat:</strong>
                            <span class="badge ${info.is_threat ? 'bg-danger' : 'bg-success'}">
                                ${info.is_threat ? 'Detected' : 'Clean'}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-success mt-3">
            <h6><i class="fas fa-lightbulb me-2"></i>Additional Information</h6>
            <ul class="mb-0">
                <li>This data is provided by multiple IP geolocation services</li>
                <li>Accuracy may vary, especially for mobile and VPN connections</li>
                <li>Use this information for general reference only</li>
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
    `;

    document.getElementById('results-content').innerHTML = html;
    document.getElementById('results').style.display = 'block';
}
</script>

