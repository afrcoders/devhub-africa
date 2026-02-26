{{-- What Is My IP --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    What Is My IP tool shows your current public IP address and location information.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-globe me-3"></i>What Is My IP Address?
                </h1>
                <p class="lead text-muted">
                    Find your public IP address and network information
                </p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0"><i class="fas fa-wifi me-2"></i>Your IP Information</h5>
                </div>
                <div class="card-body text-center">
                    <div id="loadingSection">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3 text-muted">Detecting your IP address...</p>
                    </div>

                    <div id="ipInfoSection" style="display: none;">
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="bg-light p-4 rounded">
                                    <h2 class="text-primary mb-0" id="ipAddress">Loading...</h2>
                                    <p class="text-muted mb-0">Your Public IP Address</p>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="detailsSection">
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title text-primary">
                                            <i class="fas fa-map-marker-alt me-2"></i>Location
                                        </h6>
                                        <p class="card-text">
                                            <strong>Country:</strong> <span id="country">-</span><br>
                                            <strong>Region:</strong> <span id="region">-</span><br>
                                            <strong>City:</strong> <span id="city">-</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title text-primary">
                                            <i class="fas fa-building me-2"></i>Internet Provider
                                        </h6>
                                        <p class="card-text">
                                            <strong>ISP:</strong> <span id="isp">-</span><br>
                                            <strong>Organization:</strong> <span id="org">-</span><br>
                                            <strong>AS:</strong> <span id="as">-</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title text-primary">
                                            <i class="fas fa-clock me-2"></i>Time Zone
                                        </h6>
                                        <p class="card-text">
                                            <strong>Time Zone:</strong> <span id="timezone">-</span><br>
                                            <strong>UTC Offset:</strong> <span id="offset">-</span><br>
                                            <strong>Local Time:</strong> <span id="localTime">-</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title text-primary">
                                            <i class="fas fa-map me-2"></i>Coordinates
                                        </h6>
                                        <p class="card-text">
                                            <strong>Latitude:</strong> <span id="lat">-</span><br>
                                            <strong>Longitude:</strong> <span id="lon">-</span><br>
                                            <strong>Postal Code:</strong> <span id="zip">-</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="button" id="refreshBtn" class="btn btn-primary">
                                <i class="fas fa-sync me-2"></i>Refresh Information
                            </button>
                            <button type="button" id="copyIpBtn" class="btn btn-outline-secondary ms-2">
                                <i class="fas fa-copy me-2"></i>Copy IP Address
                            </button>
                        </div>
                    </div>

                    <div id="errorSection" style="display: none;">
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Error:</strong> <span id="errorMessage">Unable to detect IP information.</span>
                        </div>
                        <button type="button" id="retryBtn" class="btn btn-primary">
                            <i class="fas fa-redo me-2"></i>Try Again
                        </button>
                    </div>
                </div>
            </div>

            {{-- Additional Info --}}
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>About IP Addresses</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>What is an IP Address?</h6>
                            <p class="text-muted small">
                                An IP (Internet Protocol) address is a unique numerical identifier assigned to every device connected to the internet. It allows devices to communicate with each other.
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6>Public vs Private IP</h6>
                            <p class="text-muted small">
                                Your public IP address is visible to websites and services on the internet. Private IP addresses are used within your local network (router, devices at home).
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadingSection = document.getElementById('loadingSection');
    const ipInfoSection = document.getElementById('ipInfoSection');
    const errorSection = document.getElementById('errorSection');
    const detailsSection = document.getElementById('detailsSection');

    // IP info elements
    const ipAddress = document.getElementById('ipAddress');
    const country = document.getElementById('country');
    const region = document.getElementById('region');
    const city = document.getElementById('city');
    const isp = document.getElementById('isp');
    const org = document.getElementById('org');
    const as = document.getElementById('as');
    const timezone = document.getElementById('timezone');
    const offset = document.getElementById('offset');
    const localTime = document.getElementById('localTime');
    const lat = document.getElementById('lat');
    const lon = document.getElementById('lon');
    const zip = document.getElementById('zip');
    const errorMessage = document.getElementById('errorMessage');

    // Buttons
    const refreshBtn = document.getElementById('refreshBtn');
    const copyIpBtn = document.getElementById('copyIpBtn');
    const retryBtn = document.getElementById('retryBtn');

    function showLoading() {
        loadingSection.style.display = 'block';
        ipInfoSection.style.display = 'none';
        errorSection.style.display = 'none';
    }

    function showError(message) {
        loadingSection.style.display = 'none';
        ipInfoSection.style.display = 'none';
        errorSection.style.display = 'block';
        errorMessage.textContent = message;
    }

    function showIpInfo(data) {
        loadingSection.style.display = 'none';
        errorSection.style.display = 'none';
        ipInfoSection.style.display = 'block';

        // Basic IP
        ipAddress.textContent = data.ip || data.query || 'Unknown';

        // Location info
        country.textContent = data.country || 'Unknown';
        region.textContent = data.regionName || data.region || 'Unknown';
        city.textContent = data.city || 'Unknown';

        // ISP info
        isp.textContent = data.isp || 'Unknown';
        org.textContent = data.org || data.as || 'Unknown';
        as.textContent = data.as || 'Unknown';

        // Time zone
        timezone.textContent = data.timezone || 'Unknown';
        offset.textContent = data.offset ? `UTC${data.offset >= 0 ? '+' : ''}${data.offset}` : 'Unknown';

        // Try to get local time
        if (data.timezone) {
            try {
                const now = new Date();
                const localTimeStr = now.toLocaleString('en-US', { timeZone: data.timezone });
                localTime.textContent = localTimeStr;
            } catch (e) {
                localTime.textContent = 'Unknown';
            }
        } else {
            localTime.textContent = 'Unknown';
        }

        // Coordinates
        lat.textContent = data.lat || 'Unknown';
        lon.textContent = data.lon || 'Unknown';
        zip.textContent = data.zip || 'Unknown';
    }

    async function fetchIpInfo() {
        showLoading();

        try {
            // Try ip-api.com first (free, no key required)
            const response = await fetch('http://ip-api.com/json/');

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();

            if (data.status === 'success') {
                showIpInfo(data);
            } else {
                throw new Error(data.message || 'Failed to get IP information');
            }
        } catch (error) {
            console.error('Error fetching IP info:', error);

            // Fallback: try to get just the IP address
            try {
                const ipResponse = await fetch('https://api.ipify.org?format=json');
                const ipData = await ipResponse.json();

                showIpInfo({ ip: ipData.ip });
                detailsSection.style.display = 'none';
            } catch (ipError) {
                showError('Unable to fetch IP information. Please check your connection and try again.');
            }
        }
    }

    function copyIpAddress() {
        const ip = ipAddress.textContent;
        if (ip && ip !== 'Loading...' && ip !== 'Unknown') {
            navigator.clipboard.writeText(ip).then(() => {
                const originalText = copyIpBtn.innerHTML;
                copyIpBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
                copyIpBtn.classList.replace('btn-outline-secondary', 'btn-success');

                setTimeout(() => {
                    copyIpBtn.innerHTML = originalText;
                    copyIpBtn.classList.replace('btn-success', 'btn-outline-secondary');
                }, 2000);
            }).catch(() => {
                alert('Failed to copy IP address');
            });
        }
    }

    // Event listeners
    refreshBtn.addEventListener('click', fetchIpInfo);
    retryBtn.addEventListener('click', fetchIpInfo);
    copyIpBtn.addEventListener('click', copyIpAddress);

    // Initial load
    fetchIpInfo();
});
</script>
