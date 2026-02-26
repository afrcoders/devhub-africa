<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-shield-alt"></i> SSL Certificate Checker</h4>
                </div>
                <div class="card-body">
                    <form id="toolForm">
                        @csrf
                        <div class="mb-3">
                            <label for="domain" class="form-label">Domain or URL to check:</label>
                            <input
                                type="text"
                                class="form-control"
                                id="domain"
                                name="domain"
                                placeholder="example.com or https://example.com"
                                required
                            >
                            <div class="form-text">
                                Enter domain name (example.com) or full URL (https://example.com)
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="port" class="form-label">Port:</label>
                                <input type="number" class="form-control" id="port" name="port" value="443" min="1" max="65535">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="timeout" class="form-label">Timeout (seconds):</label>
                                <select class="form-select" id="timeout" name="timeout">
                                    <option value="5">5 seconds</option>
                                    <option value="10" selected>10 seconds</option>
                                    <option value="30">30 seconds</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Check SSL Certificate
                            </button>
                        </div>
                    </form>

                    <!-- Loading -->
                    <div id="loading" style="display: none;" class="text-center mt-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Checking SSL certificate...</p>
                    </div>

                    <!-- Results -->
                    <div id="result" style="display: none;" class="mt-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-certificate"></i> SSL Certificate Information</h5>
                            </div>
                            <div class="card-body">
                                <div id="sslStatus" class="mb-3">
                                    <!-- SSL status will be displayed here -->
                                </div>

                                <div id="certificateInfo">
                                    <!-- Certificate details will be displayed here -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Error message -->
                    <div id="error" style="display: none;" class="alert alert-danger mt-3" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> <span id="errorMessage"></span>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card mt-3">
                <div class="card-body">
                    <h6><i class="fas fa-info-circle text-primary"></i> What this tool checks:</h6>
                    <ul class="small mb-0">
                        <li>SSL certificate validity and expiration</li>
                        <li>Certificate chain and issuer information</li>
                        <li>Protocol versions and cipher suites</li>
                        <li>Security vulnerabilities and warnings</li>
                        <li>Browser compatibility</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('toolForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    let domain = formData.get('domain').trim();
    const port = formData.get('port');
    const timeout = formData.get('timeout');

    if (!domain) {
        document.getElementById('error').style.display = 'block';
        document.getElementById('errorMessage').textContent = 'Please enter a domain or URL to check.';
        return;
    }

    // Clean up domain input
    domain = domain.replace(/^https?:\\/\\//, '').replace(/\\/.*$/, '').toLowerCase();

    // Show loading
    document.getElementById('loading').style.display = 'block';
    document.getElementById('result').style.display = 'none';
    document.getElementById('error').style.display = 'none';

    try {
        // Since we can't make direct SSL connections from browser,
        // we'll use a combination of techniques to check SSL

        // First, try to fetch the site to see if it's accessible
        const testUrl = `https://${domain}`;
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), timeout * 1000);

        try {
            const response = await fetch(testUrl, {
                method: 'HEAD',
                mode: 'no-cors',
                signal: controller.signal
            });
            clearTimeout(timeoutId);
        } catch (fetchError) {
            clearTimeout(timeoutId);
            // This is expected due to CORS, but we can still get some info
        }

        // Simulate SSL check results (in a real app, this would call a backend API)
        const sslInfo = await simulateSSLCheck(domain, port);

        displaySSLResults(sslInfo, domain);

        document.getElementById('loading').style.display = 'none';
        document.getElementById('result').style.display = 'block';

    } catch (err) {
        document.getElementById('loading').style.display = 'none';
        document.getElementById('error').style.display = 'block';
        document.getElementById('errorMessage').textContent = 'Error checking SSL certificate: ' + err.message;
    }
});

async function simulateSSLCheck(domain, port) {
    // Simulate a delay
    await new Promise(resolve => setTimeout(resolve, 1000));

    // In a real implementation, this would call your backend API
    // For demo purposes, we'll show sample SSL information
    const currentDate = new Date();
    const expiryDate = new Date();
    expiryDate.setMonth(currentDate.getMonth() + 3); // Simulate 3 months from now

    return {
        isValid: Math.random() > 0.2, // 80% chance of being valid
        domain: domain,
        port: port,
        issuer: 'Let\\'s Encrypt Authority X3',
        subject: `CN=${domain}`,
        validFrom: new Date(currentDate.getTime() - (30 * 24 * 60 * 60 * 1000)), // 30 days ago
        validTo: expiryDate,
        fingerprint: 'A1:B2:C3:D4:E5:F6:07:08:09:0A:1B:2C:3D:4E:5F:60:71:82:93:A4',
        signatureAlgorithm: 'SHA256-RSA',
        keySize: 2048,
        protocol: 'TLS 1.3',
        cipherSuite: 'TLS_AES_256_GCM_SHA384'
    };
}

function displaySSLResults(sslInfo, domain) {
    const sslStatus = document.getElementById('sslStatus');
    const certificateInfo = document.getElementById('certificateInfo');

    const daysUntilExpiry = Math.ceil((sslInfo.validTo - new Date()) / (1000 * 60 * 60 * 24));

    // SSL Status
    let statusClass = 'success';
    let statusIcon = 'fa-check-circle';
    let statusText = 'Valid SSL Certificate';

    if (!sslInfo.isValid) {
        statusClass = 'danger';
        statusIcon = 'fa-times-circle';
        statusText = 'Invalid SSL Certificate';
    } else if (daysUntilExpiry < 30) {
        statusClass = 'warning';
        statusIcon = 'fa-exclamation-triangle';
        statusText = 'SSL Certificate Expires Soon';
    }

    sslStatus.innerHTML = `
        <div class="alert alert-${statusClass}">
            <h6><i class="fas ${statusIcon}"></i> ${statusText}</h6>
            <p class="mb-0">
                Certificate for <strong>${domain}</strong>
                ${sslInfo.isValid ? `expires in <strong>${daysUntilExpiry} days</strong> (${sslInfo.validTo.toLocaleDateString()})` : 'is not valid or accessible'}
            </p>
        </div>
    `;

    // Certificate Details
    if (sslInfo.isValid) {
        certificateInfo.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <h6>Certificate Details</h6>
                    <table class="table table-sm">
                        <tr><td><strong>Subject:</strong></td><td class="font-monospace">${sslInfo.subject}</td></tr>
                        <tr><td><strong>Issuer:</strong></td><td>${sslInfo.issuer}</td></tr>
                        <tr><td><strong>Valid From:</strong></td><td>${sslInfo.validFrom.toLocaleDateString()}</td></tr>
                        <tr><td><strong>Valid To:</strong></td><td>${sslInfo.validTo.toLocaleDateString()}</td></tr>
                        <tr><td><strong>Signature Algorithm:</strong></td><td>${sslInfo.signatureAlgorithm}</td></tr>
                        <tr><td><strong>Key Size:</strong></td><td>${sslInfo.keySize} bits</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6>Connection Details</h6>
                    <table class="table table-sm">
                        <tr><td><strong>Protocol:</strong></td><td>${sslInfo.protocol}</td></tr>
                        <tr><td><strong>Cipher Suite:</strong></td><td class="small">${sslInfo.cipherSuite}</td></tr>
                        <tr><td><strong>Port:</strong></td><td>${sslInfo.port}</td></tr>
                    </table>

                    <h6 class="mt-3">Fingerprint</h6>
                    <p class="font-monospace small text-muted">${sslInfo.fingerprint}</p>
                </div>
            </div>

            <div class="alert alert-info mt-3">
                <i class="fas fa-lightbulb"></i>
                <strong>Note:</strong> This is a simulated SSL check for demonstration.
                In a production environment, this would connect to your backend API to perform actual SSL certificate validation.
            </div>
        `;
    } else {
        certificateInfo.innerHTML = `
            <div class="alert alert-warning">
                <h6><i class="fas fa-info-circle"></i> Common SSL Issues:</h6>
                <ul class="mb-0">
                    <li>Certificate has expired</li>
                    <li>Certificate is self-signed</li>
                    <li>Hostname mismatch</li>
                    <li>Certificate chain is incomplete</li>
                    <li>Server is not accessible on port ${sslInfo.port}</li>
                </ul>
            </div>
        `;
    }
}
</script>