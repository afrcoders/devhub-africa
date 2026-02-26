{{-- Domain Name Search --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Check domain name availability and get information.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-globe me-3"></i>Domain Name Search
                </h1>
                <p class="lead text-muted">
                    Check domain availability and get domain information
                </p>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Domain Search</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="domainName" class="form-label fw-semibold">Domain Name:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="domainName" placeholder="example">
                                    <select class="form-select" id="tld" style="max-width: 100px;">
                                        <option value=".com">.com</option>
                                        <option value=".net">.net</option>
                                        <option value=".org">.org</option>
                                        <option value=".io">.io</option>
                                        <option value=".co">.co</option>
                                        <option value=".uk">.uk</option>
                                        <option value=".ca">.ca</option>
                                        <option value=".de">.de</option>
                                        <option value=".fr">.fr</option>
                                        <option value=".app">.app</option>
                                    </select>
                                </div>
                            </div>

                            <button type="button" id="searchBtn" class="btn btn-primary w-100 mb-3">
                                <i class="fas fa-search me-2"></i>Check Availability
                            </button>

                            <button type="button" id="suggestBtn" class="btn btn-secondary w-100">
                                <i class="fas fa-lightbulb me-2"></i>Suggest Alternatives
                            </button>

                            <hr class="my-4">

                            <div class="alert alert-warning">
                                <strong><i class="fas fa-info-circle me-2"></i>Note:</strong>
                                This is a demonstration tool. For real domain availability checks, use registrars like Namecheap, GoDaddy, or Domain.com.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-check-circle me-2"></i>Results</h5>
                        </div>
                        <div class="card-body" id="results" style="max-height: 600px; overflow-y: auto;">
                            <p class="text-muted text-center">Enter a domain name and click "Check Availability"</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Domain Naming Tips</h5>
                        </div>
                        <div class="card-body">
                            <ul class="mb-0">
                                <li>Keep domains short and memorable (ideally under 15 characters)</li>
                                <li>Avoid numbers and hyphens when possible</li>
                                <li>.com domains are most recognizable and valuable</li>
                                <li>Include keywords relevant to your business</li>
                                <li>Check for trademark conflicts before registering</li>
                                <li>Consider getting the .com, .net, and .org versions</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const domainName = document.getElementById('domainName');
    const tld = document.getElementById('tld');
    const searchBtn = document.getElementById('searchBtn');
    const suggestBtn = document.getElementById('suggestBtn');
    const results = document.getElementById('results');

    // Mock domain data
    const takenDomains = ['example.com', 'test.com', 'demo.io', 'sample.net'];

    function isAvailable(domain) {
        return !takenDomains.some(d => d.toLowerCase() === domain.toLowerCase());
    }

    function search() {
        const domain = domainName.value.trim().toLowerCase();
        const extension = tld.value;
        const fullDomain = domain + extension;

        if (!domain) {
            alert('Please enter a domain name');
            return;
        }

        if (!/^[a-z0-9-]{2,}$/.test(domain)) {
            alert('Domain can only contain letters, numbers, and hyphens');
            return;
        }

        const available = isAvailable(fullDomain);

        let html = `
            <div class="mb-3">
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-globe me-2"></i>Domain: <code>${escapeHtml(fullDomain)}</code>
                </h6>
            </div>

            <div class="card card-sm mb-3">
                <div class="card-body">
                    <div class="alert ${available ? 'alert-success' : 'alert-danger'} mb-2">
                        <strong><i class="fas fa-${available ? 'check-circle' : 'times-circle'} me-2"></i>${available ? 'Available' : 'Not Available'}</strong>
                    </div>
        `;

        if (available) {
            html += `
                    <p class="mb-0">
                        <a href="https://www.namecheap.com/domains/registration/search/?domain=${domain}" target="_blank" class="btn btn-sm btn-success">
                            <i class="fas fa-external-link-alt me-1"></i>Register Now
                        </a>
                    </p>
            `;
        } else {
            html += `
                    <p class="mb-0 text-muted">This domain is already registered. Try a different name or extension.</p>
            `;
        }

        html += `
                </div>
            </div>

            <div class="card card-sm">
                <div class="card-body p-2">
                    <strong>Domain Details:</strong>
                    <ul class="mb-0 mt-2" style="font-size: 13px;">
                        <li><strong>Name:</strong> ${escapeHtml(domain)}</li>
                        <li><strong>Extension:</strong> ${extension}</li>
                        <li><strong>Length:</strong> ${domain.length} characters</li>
                        <li><strong>Status:</strong> ${available ? '<span class="badge bg-success">Available</span>' : '<span class="badge bg-danger">Registered</span>'}</li>
                    </ul>
                </div>
            </div>
        `;

        results.innerHTML = html;
    }

    function suggest() {
        const domain = domainName.value.trim().toLowerCase();

        if (!domain) {
            alert('Please enter a domain name');
            return;
        }

        const suggestions = [
            { name: domain + 'hub.com', available: Math.random() > 0.5 },
            { name: domain + 'ify.com', available: Math.random() > 0.5 },
            { name: domain + 'ly.com', available: Math.random() > 0.5 },
            { name: 'my' + domain + '.com', available: Math.random() > 0.5 },
            { name: domain + '.io', available: Math.random() > 0.5 },
            { name: domain + '.co', available: Math.random() > 0.5 },
            { name: domain + 'app.com', available: Math.random() > 0.5 },
            { name: domain + '.cloud', available: Math.random() > 0.5 }
        ];

        let html = `
            <div class="mb-3">
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-lightbulb me-2"></i>Alternative Suggestions
                </h6>
            </div>
        `;

        suggestions.forEach(s => {
            html += `
                <div class="card card-sm mb-2">
                    <div class="card-body p-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong><code>${escapeHtml(s.name)}</code></strong>
                                <span class="badge ${s.available ? 'bg-success' : 'bg-danger'}">${s.available ? 'Available' : 'Taken'}</span>
                            </div>
                            ${s.available ? `<a href="https://www.namecheap.com/domains/registration/search/?domain=${s.name.split('.')[0]}" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-external-link-alt"></i></a>` : ''}
                        </div>
                    </div>
                </div>
            `;
        });

        results.innerHTML = html;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    searchBtn.addEventListener('click', search);
    suggestBtn.addEventListener('click', suggest);
    domainName.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            search();
        }
    });
});
</script>
