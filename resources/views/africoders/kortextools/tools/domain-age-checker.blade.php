{{-- Domain Age Checker --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-clock me-2"></i>
    Check the registration date and age of any domain name.
</div>>
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-calendar-alt fa-3x text-primary"></i>
                </div>
                <h1 class="h2 mb-3">Domain Age Checker</h1>
                <p class="lead text-muted">
                    Find out when a domain was registered and get detailed domain information
                </p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="domain-age-form">
                        @csrf
                        <div class="mb-4">
                            <label for="domain" class="form-label">
                                <i class="fas fa-globe me-2"></i>Domain Name
                            </label>
                            <input
                                type="text"
                                class="form-control form-control-lg"
                                id="domain"
                                name="domain"
                                placeholder="example.com"
                                required
                            >
                            <small class="form-text text-muted">
                                Enter a domain name without http:// or https://
                            </small>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-search me-2"></i>Check Domain Age
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
                        <span class="text-muted">Checking domain information...</span>
                    </div>
                </div>
            </div>

            <!-- Results -->
            <div id="results" class="mt-4" style="display: none;">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>Domain Information
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
                    <i class="fas fa-info-circle me-2"></i>About Domain Age Checking
                </h6>
                <p class="mb-2">
                    This tool helps you research domain history and credibility:
                </p>
                <ul class="mb-2">
                    <li><strong>Registration Date</strong> - When the domain was first registered</li>
                    <li><strong>Domain Age</strong> - How long the domain has been active</li>
                    <li><strong>Expiration Date</strong> - When the domain registration expires</li>
                    <li><strong>Registrar Info</strong> - Which company manages the domain</li>
                    <li><strong>Name Servers</strong> - DNS servers handling the domain</li>
                </ul>
                <p class="mb-0">
                    <small><strong>Useful for:</strong> SEO research, competitor analysis, domain valuation, and trustworthiness assessment.</small>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('domain-age-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const domain = document.getElementById('domain').value.trim();
    if (!domain) {
        alert('Please enter a domain name');
        return;
    }

    // Show loading
    document.getElementById('loading').style.display = 'block';
    document.getElementById('results').style.display = 'none';

    const formData = new FormData();
    formData.append('domain', domain);
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
    const info = result.domain_info;
    const domain = result.domain;

    let nameServersHtml = '';
    if (info.name_servers && info.name_servers.length > 0) {
        nameServersHtml = info.name_servers.map(ns => `<span class="badge bg-secondary me-1">${ns}</span>`).join('');
    } else {
        nameServersHtml = '<span class="text-muted">Not available</span>';
    }

    const html = `
        <div class="row">
            <div class="col-md-6">
                <h6>Domain Details</h6>
                <table class="table table-sm">
                    <tr>
                        <td><strong>Domain:</strong></td>
                        <td><span class="badge bg-primary">${domain}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Age:</strong></td>
                        <td class="text-success"><strong>${info.age_formatted}</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Registration Date:</strong></td>
                        <td>${info.creation_date}</td>
                    </tr>
                    <tr>
                        <td><strong>Expiration Date:</strong></td>
                        <td>${info.expiration_date}</td>
                    </tr>
                    <tr>
                        <td><strong>Registrar:</strong></td>
                        <td>${info.registrar}</td>
                    </tr>
                    ${info.ip_address ? `<tr><td><strong>IP Address:</strong></td><td>${info.ip_address}</td></tr>` : ''}
                </table>
            </div>
            <div class="col-md-6">
                <h6>Age Analysis</h6>
                <div class="mb-3">
                    ${info.age_days !== null ? `
                        <div class="alert ${info.age_days > 365 ? 'alert-success' : info.age_days > 90 ? 'alert-warning' : 'alert-info'}">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-birthday-cake fa-2x"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Domain Age: ${info.age_formatted}</h6>
                                    <small>${info.age_days} days old</small>
                                </div>
                            </div>
                        </div>
                    ` : `
                        <div class="alert alert-warning">
                            <i class="fas fa-question-circle me-2"></i>
                            Domain age could not be determined from WHOIS data
                        </div>
                    `}
                </div>

                <h6>Name Servers</h6>
                <div class="mb-3">
                    ${nameServersHtml}
                </div>

                <div class="row text-center">
                    <div class="col-6">
                        <div class="border rounded p-2">
                            <h6 class="text-muted mb-1">Trust Score</h6>
                            <span class="badge bg-${info.age_days > 365 ? 'success' : info.age_days > 90 ? 'warning' : 'secondary'} fs-6">
                                ${info.age_days > 365 ? 'High' : info.age_days > 90 ? 'Medium' : 'New'}
                            </span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-2">
                            <h6 class="text-muted mb-1">SEO Value</h6>
                            <span class="badge bg-${info.age_days > 1095 ? 'success' : info.age_days > 365 ? 'warning' : 'secondary'} fs-6">
                                ${info.age_days > 1095 ? 'Excellent' : info.age_days > 365 ? 'Good' : 'Building'}
                            </span>
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
</script>
