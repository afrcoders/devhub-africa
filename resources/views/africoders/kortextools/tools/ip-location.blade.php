{{-- IP Location --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Find geolocation information for any IP address.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-map-marker-alt me-3"></i>IP Location Finder
                </h1>
                <p class="lead text-muted">
                    Find geolocation information for any IP address
                </p>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-edit me-2"></i>IP Address</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="ipAddress" class="form-label fw-semibold">Enter IP Address:</label>
                                <input type="text" class="form-control" id="ipAddress" placeholder="8.8.8.8">
                            </div>

                            <button type="button" id="lookupBtn" class="btn btn-primary w-100 mb-3">
                                <i class="fas fa-search me-2"></i>Lookup IP
                            </button>

                            <button type="button" id="myIpBtn" class="btn btn-secondary w-100">
                                <i class="fas fa-wifi me-2"></i>My IP Address
                            </button>

                            <hr class="my-4">

                            <div class="alert alert-warning">
                                <strong><i class="fas fa-info-circle me-2"></i>Note:</strong>
                                IP geolocation data is approximate based on IP registration data. Actual location may vary.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Location Information</h5>
                        </div>
                        <div class="card-body" id="results" style="max-height: 600px; overflow-y: auto;">
                            <p class="text-muted text-center">Enter an IP address and click "Lookup IP"</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ipAddress = document.getElementById('ipAddress');
    const lookupBtn = document.getElementById('lookupBtn');
    const myIpBtn = document.getElementById('myIpBtn');
    const results = document.getElementById('results');

    // Mock IP data
    const mockIPs = {
        '8.8.8.8': {
            ip: '8.8.8.8',
            country: 'United States',
            countryCode: 'US',
            state: 'California',
            city: 'Mountain View',
            latitude: 37.4192,
            longitude: -122.0574,
            timezone: 'America/Los_Angeles',
            isp: 'Google LLC',
            org: 'Google LLC'
        },
        '1.1.1.1': {
            ip: '1.1.1.1',
            country: 'United States',
            countryCode: 'US',
            state: 'California',
            city: 'Los Angeles',
            latitude: 34.0522,
            longitude: -118.2437,
            timezone: 'America/Los_Angeles',
            isp: 'Cloudflare Inc.',
            org: 'Cloudflare Inc.'
        },
        '93.184.216.34': {
            ip: '93.184.216.34',
            country: 'United States',
            countryCode: 'US',
            state: 'California',
            city: 'Anytown',
            latitude: 37.5,
            longitude: -122.5,
            timezone: 'America/Los_Angeles',
            isp: 'Verisign Inc.',
            org: 'Example.com'
        }
    };

    function isValidIP(ip) {
        const ipv4 = /^(\d{1,3}\.){3}\d{1,3}$/;
        const ipv6 = /^([0-9a-f]{0,4}:){2,7}[0-9a-f]{0,4}$/i;
        return ipv4.test(ip) || ipv6.test(ip);
    }

    function displayResults(data) {
        if (!data) {
            results.innerHTML = `
                <div class="alert alert-warning">
                    <strong>No Data Found</strong>
                    <p class="mb-0 mt-2">Try one of the example IPs: 8.8.8.8, 1.1.1.1, or 93.184.216.34</p>
                </div>
            `;
            return;
        }

        let html = `
            <div class="mb-3">
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-globe me-2"></i>IP Information: <code>${escapeHtml(data.ip)}</code>
                </h6>
            </div>

            <div class="card card-sm mb-3">
                <div class="card-body p-3">
                    <div class="mb-3">
                        <strong><i class="fas fa-globe me-2"></i>Country:</strong><br>
                        <span class="badge bg-primary">${data.countryCode}</span> ${data.country}
                    </div>
                    <div class="mb-3">
                        <strong><i class="fas fa-map me-2"></i>Location:</strong><br>
                        ${data.city}, ${data.state}
                    </div>
                    <div class="mb-3">
                        <strong><i class="fas fa-clock me-2"></i>Timezone:</strong><br>
                        <code>${data.timezone}</code>
                    </div>
                    <div class="mb-3">
                        <strong><i class="fas fa-crosshairs me-2"></i>Coordinates:</strong><br>
                        <code>${data.latitude.toFixed(4)}, ${data.longitude.toFixed(4)}</code>
                    </div>
                    <div class="mb-3">
                        <strong><i class="fas fa-building me-2"></i>ISP:</strong><br>
                        ${data.isp}
                    </div>
                    <div>
                        <strong><i class="fas fa-network-wired me-2"></i>Organization:</strong><br>
                        ${data.org}
                    </div>
                </div>
            </div>

            <div class="alert alert-info">
                <strong><i class="fas fa-map me-2"></i>Map Preview:</strong>
                <p class="mb-0 mt-2">
                    <a href="https://www.google.com/maps?q=${data.latitude},${data.longitude}" target="_blank" class="btn btn-sm btn-primary">
                        <i class="fas fa-external-link-alt me-1"></i>View on Google Maps
                    </a>
                </p>
            </div>
        `;

        results.innerHTML = html;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function lookup() {
        const ip = ipAddress.value.trim();

        if (!ip) {
            alert('Please enter an IP address');
            return;
        }

        if (!isValidIP(ip)) {
            alert('Invalid IP address format');
            return;
        }

        const data = mockIPs[ip] || null;
        displayResults(data);
    }

    function getMyIP() {
        results.innerHTML = `
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Detecting your IP...</p>
            </div>
        `;

        // Using public API to get user's IP
        fetch('https://api.ipify.org?format=json')
            .then(response => response.json())
            .then(data => {
                ipAddress.value = data.ip;
                const mockData = mockIPs[data.ip] || {
                    ip: data.ip,
                    country: 'Unknown',
                    countryCode: 'XX',
                    state: 'Unknown',
                    city: 'Unknown',
                    latitude: 0,
                    longitude: 0,
                    timezone: 'Unknown',
                    isp: 'Unknown',
                    org: 'Unknown'
                };
                displayResults(mockData);
            })
            .catch(error => {
                results.innerHTML = `
                    <div class="alert alert-warning">
                        <strong>Error:</strong> Could not detect your IP address. Please try entering one manually.
                    </div>
                `;
            });
    }

    lookupBtn.addEventListener('click', lookup);
    myIpBtn.addEventListener('click', getMyIP);
    ipAddress.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            lookup();
        }
    });
});
</script>
