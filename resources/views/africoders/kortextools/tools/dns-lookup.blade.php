{{-- dns lookup --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    dns lookup tool for your development and productivity needs.
</div>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-search-plus fa-3x text-primary"></i>
                </div>
                <h1 class="h2 mb-3">DNS Lookup Tool</h1>
                <p class="lead text-muted">
                    Find all DNS records for any domain including A, AAAA, MX, NS, CNAME, TXT and SOA records
                </p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="dns-lookup-form">
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
                                Enter a domain name without http:// or www
                            </small>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-search me-2"></i>Lookup DNS Records
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
                        <span class="text-muted">Looking up DNS records...</span>
                    </div>
                </div>
            </div>

            <!-- Results -->
            <div id="results" class="mt-4" style="display: none;">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-list-alt me-2"></i>DNS Records
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
                    <i class="fas fa-info-circle me-2"></i>About DNS Records
                </h6>
                <p class="mb-2">
                    DNS records are essential for domain functionality:
                </p>
                <ul class="mb-2">
                    <li><strong>A Records</strong> - Maps domain to IPv4 address</li>
                    <li><strong>AAAA Records</strong> - Maps domain to IPv6 address</li>
                    <li><strong>CNAME Records</strong> - Creates aliases for domains</li>
                    <li><strong>MX Records</strong> - Specifies mail servers and priorities</li>
                    <li><strong>NS Records</strong> - Lists authoritative name servers</li>
                    <li><strong>TXT Records</strong> - Contains text information (SPF, DKIM, etc.)</li>
                    <li><strong>SOA Records</strong> - Contains zone authority information</li>
                </ul>
                <p class="mb-0">
                    <small><strong>Best for:</strong> Network troubleshooting, domain configuration, email setup verification.</small>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('dns-lookup-form').addEventListener('submit', async function(e) {
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
    const records = result.dns_records;
    const domain = result.domain;

    let recordsHtml = '';
    let totalRecords = 0;

    // Record type descriptions and icons
    const recordTypes = {
        'A': { icon: 'fas fa-server', description: 'IPv4 Address Records' },
        'AAAA': { icon: 'fas fa-server', description: 'IPv6 Address Records' },
        'CNAME': { icon: 'fas fa-link', description: 'Canonical Name Records' },
        'MX': { icon: 'fas fa-envelope', description: 'Mail Exchange Records' },
        'NS': { icon: 'fas fa-dns', description: 'Name Server Records' },
        'TXT': { icon: 'fas fa-file-alt', description: 'Text Records' },
        'SOA': { icon: 'fas fa-database', description: 'Start of Authority Records' }
    };

    for (const [recordType, values] of Object.entries(records)) {
        if (values && values.length > 0) {
            totalRecords += values.length;
            const typeInfo = recordTypes[recordType] || { icon: 'fas fa-question', description: recordType + ' Records' };

            recordsHtml += `
                <div class="mb-4">
                    <h6 class="border-bottom pb-2">
                        <i class="${typeInfo.icon} me-2 text-primary"></i>
                        ${typeInfo.description} (${values.length})
                    </h6>
                    <div class="ps-3">
            `;

            values.forEach(value => {
                recordsHtml += `
                    <div class="d-flex align-items-center py-2 border-bottom">
                        <code class="flex-grow-1 bg-light p-2 rounded small">${value}</code>
                        <button class="btn btn-sm btn-outline-secondary ms-2" onclick="copyToClipboard('${value}')">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                `;
            });

            recordsHtml += `
                    </div>
                </div>
            `;
        }
    }

    if (totalRecords === 0) {
        recordsHtml = `
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                No DNS records found for <strong>${domain}</strong>
            </div>
        `;
    }

    const html = `
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-success">
                    <h6 class="mb-2">
                        <i class="fas fa-check-circle me-2"></i>
                        DNS Lookup Results for: <strong>${domain}</strong>
                    </h6>
                    <div class="text-center">
                        <span class="fs-5 fw-bold">${totalRecords}</span> DNS records found
                    </div>
                </div>
            </div>
        </div>

        ${recordsHtml}

        ${totalRecords > 0 ? `
            <div class="alert alert-info mt-3">
                <h6><i class="fas fa-lightbulb me-2"></i>Tips</h6>
                <ul class="mb-0">
                    <li>Click the copy button next to any record to copy it to clipboard</li>
                    <li>A records point to server IP addresses</li>
                    <li>MX records show mail server priorities (lower number = higher priority)</li>
                    <li>TXT records often contain SPF, DKIM, and verification data</li>
                </ul>
            </div>
        ` : ''}
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

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show temporary success message
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
</script>

