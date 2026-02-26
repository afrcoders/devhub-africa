{{-- fake address generator --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    fake address generator tool for your development and productivity needs.
</div>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-map-marker-alt fa-3x text-primary"></i>
                </div>
                <h1 class="h2 mb-3">Fake Address Generator</h1>
                <p class="lead text-muted">
                    Generate realistic fake addresses for testing and development purposes
                </p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="fake-address-form">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <label for="country" class="form-label">
                                    <i class="fas fa-globe me-2"></i>Country
                                </label>
                                <select class="form-select form-select-lg" id="country" name="country" required>
                                    <option value="US" selected>🇺🇸 United States</option>
                                    <option value="UK">🇬🇧 United Kingdom</option>
                                    <option value="CA">🇨🇦 Canada</option>
                                    <option value="AU">🇦🇺 Australia</option>
                                    <option value="DE">🇩🇪 Germany</option>
                                    <option value="FR">🇫🇷 France</option>
                                    <option value="ES">🇪🇸 Spain</option>
                                    <option value="IT">🇮🇹 Italy</option>
                                    <option value="NL">🇳🇱 Netherlands</option>
                                    <option value="BR">🇧🇷 Brazil</option>
                                    <option value="IN">🇮🇳 India</option>
                                    <option value="JP">🇯🇵 Japan</option>
                                    <option value="CN">🇨🇳 China</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="count" class="form-label">
                                    <i class="fas fa-hashtag me-2"></i>Number of Addresses
                                </label>
                                <select class="form-select form-select-lg" id="count" name="count">
                                    <option value="1" selected>1 Address</option>
                                    <option value="3">3 Addresses</option>
                                    <option value="5">5 Addresses</option>
                                    <option value="10">10 Addresses</option>
                                    <option value="20">20 Addresses</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-magic me-2"></i>Generate Addresses
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
                        <span class="text-muted">Generating fake addresses...</span>
                    </div>
                </div>
            </div>

            <!-- Results -->
            <div id="results" class="mt-4" style="display: none;">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-list-alt me-2"></i>Generated Addresses
                        </h5>
                        <button class="btn btn-outline-primary btn-sm" onclick="copyAllAddresses()">
                            <i class="fas fa-copy me-1"></i>Copy All
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="results-content"></div>
                    </div>
                </div>
            </div>

            <!-- Info Section -->
            <div class="alert alert-warning mt-4">
                <h6 class="alert-heading">
                    <i class="fas fa-exclamation-triangle me-2"></i>Disclaimer
                </h6>
                <p class="mb-2">
                    These are fake addresses generated for testing purposes only:
                </p>
                <ul class="mb-2">
                    <li><strong>Not Real</strong> - These addresses do not represent real locations</li>
                    <li><strong>Testing Only</strong> - Use for software testing, development, and demos</li>
                    <li><strong>No Verification</strong> - Addresses are not verified against postal databases</li>
                    <li><strong>Privacy Safe</strong> - No real personal information is used</li>
                </ul>
                <p class="mb-0">
                    <small><strong>Best for:</strong> Form testing, database population, software development, and demos.</small>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('fake-address-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const country = document.getElementById('country').value;
    const count = document.getElementById('count').value;

    // Show loading
    document.getElementById('loading').style.display = 'block';
    document.getElementById('results').style.display = 'none';

    const formData = new FormData();
    formData.append('country', country);
    formData.append('count', count);
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
    const addresses = result.addresses;
    const country = result.country;
    const count = result.count;

    let addressesHtml = '';

    addresses.forEach((address, index) => {
        addressesHtml += `
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-map-pin me-2 text-primary"></i>
                            Address ${index + 1}
                        </h6>
                        <button class="btn btn-sm btn-outline-secondary" onclick="copyAddress(${index})">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="address-text" id="address-${index}">
                                <div class="fw-semibold">${address.street}</div>
                                <div>${address.city}, ${address.state} ${address.zip_code}</div>
                                <div class="text-muted">${address.country}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="small text-muted">
                                <div><strong>Street:</strong> ${address.street}</div>
                                <div><strong>City:</strong> ${address.city}</div>
                                <div><strong>State:</strong> ${address.state}</div>
                                <div><strong>Zip:</strong> ${address.zip_code}</div>
                                <div><strong>Country:</strong> ${address.country}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });

    const html = `
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-success">
                    <div class="text-center">
                        <h6 class="mb-2">
                            <i class="fas fa-check-circle me-2"></i>
                            Successfully generated <strong>${count}</strong> fake addresses for <strong>${getCountryName(country)}</strong>
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        ${addressesHtml}

        <div class="row mt-3">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <button class="btn btn-outline-primary" onclick="exportAddresses('json')">
                        <i class="fas fa-download me-1"></i>Export as JSON
                    </button>
                    <button class="btn btn-outline-secondary" onclick="exportAddresses('csv')">
                        <i class="fas fa-download me-1"></i>Export as CSV
                    </button>
                </div>
            </div>
        </div>
    `;

    document.getElementById('results-content').innerHTML = html;
    document.getElementById('results').style.display = 'block';

    // Store addresses globally for export
    window.generatedAddresses = addresses;
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

function getCountryName(code) {
    const countries = {
        'US': 'United States',
        'UK': 'United Kingdom',
        'CA': 'Canada',
        'AU': 'Australia',
        'DE': 'Germany',
        'FR': 'France',
        'ES': 'Spain',
        'IT': 'Italy',
        'NL': 'Netherlands',
        'BR': 'Brazil',
        'IN': 'India',
        'JP': 'Japan',
        'CN': 'China'
    };
    return countries[code] || code;
}

function copyAddress(index) {
    const addressDiv = document.getElementById(`address-${index}`);
    const addressText = addressDiv.innerText;

    navigator.clipboard.writeText(addressText).then(function() {
        // Show success feedback
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

function copyAllAddresses() {
    if (!window.generatedAddresses) return;

    const allText = window.generatedAddresses.map(addr =>
        `${addr.street}\n${addr.city}, ${addr.state} ${addr.zip_code}\n${addr.country}`
    ).join('\n\n');

    navigator.clipboard.writeText(allText).then(function() {
        const btn = event.target.closest('button');
        const originalContent = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check me-1"></i>Copied!';
        btn.classList.remove('btn-outline-primary');
        btn.classList.add('btn-success');

        setTimeout(function() {
            btn.innerHTML = originalContent;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-primary');
        }, 2000);
    });
}

function exportAddresses(format) {
    if (!window.generatedAddresses) return;

    let content, filename, mimeType;

    if (format === 'json') {
        content = JSON.stringify(window.generatedAddresses, null, 2);
        filename = 'fake_addresses.json';
        mimeType = 'application/json';
    } else if (format === 'csv') {
        const headers = 'Street,City,State,Zip Code,Country\n';
        const rows = window.generatedAddresses.map(addr =>
            `"${addr.street}","${addr.city}","${addr.state}","${addr.zip_code}","${addr.country}"`
        ).join('\n');
        content = headers + rows;
        filename = 'fake_addresses.csv';
        mimeType = 'text/csv';
    }

    const blob = new Blob([content], { type: mimeType });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}
</script>

