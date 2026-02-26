{{-- Domain to API Tool --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-globe me-2"></i>
    Convert domain names to API endpoints and analyze domain information.
</div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-exchange-alt me-2"></i>
                        {{ $tool->name }}
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">{{ $tool->description }}</p>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="domainInput" class="form-label">Domain Name</label>
                                <input type="text" class="form-control" id="domainInput"
                                    placeholder="Enter domain name (e.g., example.com)">
                                <div class="form-text">Enter a domain name to get API endpoint suggestions</div>
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button type="button" class="btn btn-primary" id="generateBtn">
                                    <i class="fas fa-magic me-2"></i>Generate API Endpoints
                                </button>
                            </div>

                            <div id="resultSection" style="display: none;">
                                <h5>Suggested API Endpoints:</h5>
                                <div id="apiResults"></div>

                                <div class="mt-3">
                                    <button type="button" class="btn btn-secondary" id="copyBtn">
                                        <i class="fas fa-copy me-2"></i>Copy All Endpoints
                                    </button>
                                    <button type="button" class="btn btn-success ms-2" id="downloadBtn">
                                        <i class="fas fa-download me-2"></i>Download as JSON
                                    </button>
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
const domainInput = document.getElementById('domainInput');
const generateBtn = document.getElementById('generateBtn');
const resultSection = document.getElementById('resultSection');
const apiResults = document.getElementById('apiResults');
const copyBtn = document.getElementById('copyBtn');
const downloadBtn = document.getElementById('downloadBtn');

let generatedEndpoints = [];

// Common API endpoint patterns
const apiPatterns = [
    { path: '/api/v1', description: 'Main API version 1' },
    { path: '/api/v2', description: 'Main API version 2' },
    { path: '/api/users', description: 'User management endpoints' },
    { path: '/api/auth', description: 'Authentication endpoints' },
    { path: '/api/login', description: 'Login endpoint' },
    { path: '/api/logout', description: 'Logout endpoint' },
    { path: '/api/register', description: 'User registration' },
    { path: '/api/profile', description: 'User profile management' },
    { path: '/api/dashboard', description: 'Dashboard data' },
    { path: '/api/search', description: 'Search functionality' },
    { path: '/api/data', description: 'Data retrieval endpoints' },
    { path: '/api/upload', description: 'File upload endpoints' },
    { path: '/api/download', description: 'File download endpoints' },
    { path: '/api/settings', description: 'Application settings' },
    { path: '/api/admin', description: 'Administrative endpoints' },
    { path: '/api/public', description: 'Public API endpoints' },
    { path: '/api/private', description: 'Private API endpoints' },
    { path: '/api/health', description: 'Health check endpoint' },
    { path: '/api/status', description: 'Service status endpoint' },
    { path: '/api/version', description: 'API version information' }
];

// Generate API endpoints
generateBtn.addEventListener('click', function() {
    const domain = domainInput.value.trim();

    if (!domain) {
        alert('Please enter a domain name.');
        return;
    }

    // Clean domain name
    let cleanDomain = domain.replace(/^https?:\/\//, '').replace(/\/$/, '');
    if (!cleanDomain.includes('.')) {
        alert('Please enter a valid domain name.');
        return;
    }

    generatedEndpoints = [];
    apiResults.innerHTML = '';

    // Generate endpoints
    apiPatterns.forEach(pattern => {
        const endpoint = {
            url: `https://${cleanDomain}${pattern.path}`,
            description: pattern.description,
            methods: ['GET', 'POST', 'PUT', 'DELETE']
        };
        generatedEndpoints.push(endpoint);
    });

    // Display results
    const endpointsHtml = generatedEndpoints.map(endpoint => `
        <div class="card mb-2">
            <div class="card-body">
                <h6 class="card-title">
                    <code>${endpoint.url}</code>
                </h6>
                <p class="card-text text-muted mb-2">${endpoint.description}</p>
                <div class="d-flex gap-1">
                    ${endpoint.methods.map(method =>
                        `<span class="badge bg-primary">${method}</span>`
                    ).join('')}
                </div>
            </div>
        </div>
    `).join('');

    apiResults.innerHTML = endpointsHtml;
    resultSection.style.display = 'block';
});

// Copy all endpoints
copyBtn.addEventListener('click', function() {
    if (!generatedEndpoints.length) return;

    const endpointsText = generatedEndpoints.map(endpoint => endpoint.url).join('\n');

    navigator.clipboard.writeText(endpointsText).then(function() {
        const originalText = copyBtn.innerHTML;
        copyBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
        setTimeout(function() {
            copyBtn.innerHTML = originalText;
        }, 2000);
    });
});

// Download as JSON
downloadBtn.addEventListener('click', function() {
    if (!generatedEndpoints.length) return;

    const jsonData = {
        domain: domainInput.value.trim(),
        timestamp: new Date().toISOString(),
        endpoints: generatedEndpoints
    };

    const blob = new Blob([JSON.stringify(jsonData, null, 2)], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `${domainInput.value.trim()}-api-endpoints.json`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
});

// Allow Enter key to generate
domainInput.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        generateBtn.click();
    }
});
</script>
