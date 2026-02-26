{{-- Find DNS Record --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Look up DNS records for any domain.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-globe me-3"></i>Find DNS Record
                </h1>
                <p class="lead text-muted">
                    Lookup DNS records for any domain (Educational Tool)
                </p>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Domain Lookup</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="domain" class="form-label fw-semibold">Domain Name:</label>
                                <input type="text" class="form-control" id="domain" placeholder="example.com">
                            </div>

                            <div class="mb-3">
                                <label for="recordType" class="form-label fw-semibold">Record Type:</label>
                                <select class="form-select" id="recordType">
                                    <option value="A">A (IPv4)</option>
                                    <option value="AAAA">AAAA (IPv6)</option>
                                    <option value="MX">MX (Mail Exchange)</option>
                                    <option value="CNAME">CNAME (Canonical Name)</option>
                                    <option value="TXT">TXT (Text Record)</option>
                                    <option value="NS">NS (Nameserver)</option>
                                    <option value="SOA">SOA (Start of Authority)</option>
                                </select>
                            </div>

                            <button type="button" id="lookupBtn" class="btn btn-primary w-100">
                                <i class="fas fa-search me-2"></i>Lookup DNS
                            </button>

                            <hr class="my-4">

                            <div class="alert alert-warning">
                                <strong><i class="fas fa-info-circle me-2"></i>Note:</strong>
                                This tool provides educational information about DNS record structure. For actual DNS lookups, you can:
                                <ul class="mb-0 mt-2" style="font-size: 13px;">
                                    <li>Use online DNS lookup tools</li>
                                    <li>Use command: <code>nslookup example.com</code></li>
                                    <li>Use command: <code>dig example.com</code></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-list me-2"></i>DNS Records</h5>
                        </div>
                        <div class="card-body" id="results" style="max-height: 600px; overflow-y: auto;">
                            <p class="text-muted text-center">Enter domain and click "Lookup DNS"</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>DNS Record Types Explained</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>A Record:</strong> Maps domain to IPv4 address
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>AAAA Record:</strong> Maps domain to IPv6 address
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>MX Record:</strong> Directs mail to mail servers
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>CNAME Record:</strong> Creates alias for domain name
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>TXT Record:</strong> Stores text info (SPF, DKIM, etc.)
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>NS Record:</strong> Specifies authoritative nameservers
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const domain = document.getElementById('domain');
    const recordType = document.getElementById('recordType');
    const lookupBtn = document.getElementById('lookupBtn');
    const results = document.getElementById('results');

    // Mock DNS data for demonstration
    const mockDNS = {
        'example.com': {
            'A': ['93.184.216.34'],
            'AAAA': ['2606:2800:220:1:248:1893:25c8:1946'],
            'MX': ['10 mail.example.com', '20 mail2.example.com'],
            'CNAME': ['www example is an alias for example.com'],
            'TXT': ['v=spf1 include:_spf.google.com ~all', 'google-site-verification=abcdefg123456'],
            'NS': ['ns1.example.com', 'ns2.example.com'],
            'SOA': ['ns1.example.com. hostmaster.example.com. 2023010101 3600 1800 604800 86400']
        },
        'google.com': {
            'A': ['142.250.185.46'],
            'MX': ['10 smtp.google.com'],
            'NS': ['ns1.google.com', 'ns2.google.com'],
        }
    };

    function lookup() {
        const domainName = domain.value.trim().toLowerCase();
        const type = recordType.value;

        if (!domainName) {
            alert('Please enter a domain name');
            return;
        }

        // Simulate lookup
        let html = `
            <div class="mb-3">
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-globe me-2"></i>DNS Records for: <code>${escapeHtml(domainName)}</code>
                </h6>
            </div>

            <div class="card card-sm mb-3">
                <div class="card-body">
                    <strong><i class="fas fa-server me-2"></i>Record Type: ${type}</strong>
                    <hr>
        `;

        const data = mockDNS[domainName] || null;

        if (data && data[type]) {
            html += `<div class="alert alert-success">`;
            data[type].forEach((record, index) => {
                html += `
                    <div class="mb-2">
                        <code style="background: #f8f9fa; padding: 8px; border-radius: 4px; display: block;">
                            ${escapeHtml(record)}
                        </code>
                    </div>
                `;
            });
            html += `</div>`;
        } else {
            html += `
                <div class="alert alert-info">
                    <strong>Note:</strong> No specific data available for this domain/record combination.
                    <br><br>
                    For real DNS lookups, use:
                    <ul class="mb-0 mt-2" style="font-size: 12px;">
                        <li>Command line: <code>dig ${escapeHtml(domainName)} ${type}</code></li>
                        <li>Command line: <code>nslookup -type=${type} ${escapeHtml(domainName)}</code></li>
                        <li>Online tools: MXToolbox, DNSChecker, etc.</li>
                    </ul>
                </div>
            `;
        }

        html += `
                </div>
            </div>
        `;

        results.innerHTML = html;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    lookupBtn.addEventListener('click', lookup);
    domain.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            lookup();
        }
    });
});
</script>
