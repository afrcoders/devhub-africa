{{-- Meta Tag Analyzer --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Analyze and optimize your webpage's meta tags.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-tags me-3"></i>Meta Tag Analyzer
                </h1>
                <p class="lead text-muted">
                    Analyze and optimize your webpage's meta tags for SEO
                </p>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-edit me-2"></i>HTML Content</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="htmlContent" class="form-label fw-semibold">Paste HTML Head:</label>
                                <textarea class="form-control" id="htmlContent" rows="10" placeholder="<head>..."></textarea>
                            </div>
                            <button type="button" id="analyzeBtn" class="btn btn-primary w-100">
                                <i class="fas fa-magnifying-glass me-2"></i>Analyze Meta Tags
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-list-check me-2"></i>Analysis Results</h5>
                        </div>
                        <div class="card-body" id="results" style="max-height: 600px; overflow-y: auto;">
                            <p class="text-muted text-center">Paste HTML and click "Analyze Meta Tags"</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Meta Tag Best Practices</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>Title:</strong> 30-60 characters, include keywords
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Description:</strong> 120-160 characters, compelling summary
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Viewport:</strong> Enable responsive design with <code>width=device-width</code>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Charset:</strong> Always use UTF-8
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Open Graph:</strong> Improve social sharing with og: tags
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Robots:</strong> Control crawlers with <code>robots</code> meta tag
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
    const htmlContent = document.getElementById('htmlContent');
    const analyzeBtn = document.getElementById('analyzeBtn');
    const results = document.getElementById('results');

    function analyze() {
        try {
            const html = htmlContent.value;
            if (!html.trim()) {
                alert('Please paste HTML content');
                return;
            }

            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');

            let checks = [];
            let metatags = [];

            // Extract meta tags
            const allMetaTags = doc.querySelectorAll('meta');
            allMetaTags.forEach(tag => {
                const name = tag.getAttribute('name') || tag.getAttribute('property') || 'unnamed';
                const content = tag.getAttribute('content') || '';
                metatags.push({ name, content });
            });

            // 1. Check title
            const title = doc.querySelector('title')?.textContent || '';
            checks.push({
                name: 'Title Tag',
                status: title.length > 0 ? 'PASS' : 'FAIL',
                value: title,
                recommendation: title.length > 0 ?
                    (title.length < 30 ? 'Too short (min 30)' : title.length > 60 ? 'Too long (max 60)' : 'Good length') :
                    'Add a title tag',
                icon: title.length > 0 && title.length >= 30 && title.length <= 60 ? 'check-circle' : 'times-circle'
            });

            // 2. Check meta description
            const description = doc.querySelector('meta[name="description"]')?.getAttribute('content') || '';
            checks.push({
                name: 'Meta Description',
                status: description.length > 0 ? 'PASS' : 'FAIL',
                value: description || 'Missing',
                recommendation: description.length > 0 ?
                    (description.length < 120 ? 'Too short (min 120)' : description.length > 160 ? 'Too long (max 160)' : 'Good length') :
                    'Add a meta description',
                icon: description.length > 0 && description.length >= 120 && description.length <= 160 ? 'check-circle' : 'times-circle'
            });

            // 3. Check charset
            const charset = doc.querySelector('meta[charset]') || doc.querySelector('meta[http-equiv="Content-Type"]');
            checks.push({
                name: 'Charset',
                status: charset ? 'PASS' : 'FAIL',
                value: charset?.getAttribute('charset') || 'UTF-8',
                recommendation: charset ? 'UTF-8 is recommended' : 'Add charset meta tag',
                icon: charset ? 'check-circle' : 'times-circle'
            });

            // 4. Check viewport
            const viewport = doc.querySelector('meta[name="viewport"]');
            checks.push({
                name: 'Viewport',
                status: viewport ? 'PASS' : 'FAIL',
                value: viewport?.getAttribute('content') || 'Missing',
                recommendation: viewport ? 'Mobile-friendly' : 'Add viewport meta tag for responsive design',
                icon: viewport ? 'check-circle' : 'times-circle'
            });

            // 5. Check Open Graph tags
            const ogTitle = doc.querySelector('meta[property="og:title"]');
            const ogDesc = doc.querySelector('meta[property="og:description"]');
            const ogImage = doc.querySelector('meta[property="og:image"]');
            const ogCheck = ogTitle && ogDesc && ogImage ? 'PASS' : 'WARN';
            checks.push({
                name: 'Open Graph Tags',
                status: ogCheck,
                value: `${ogTitle ? '✓ og:title' : ''} ${ogDesc ? '✓ og:description' : ''} ${ogImage ? '✓ og:image' : ''}`.trim(),
                recommendation: ogCheck === 'PASS' ? 'Good for social sharing' : 'Add Open Graph tags for better social media sharing',
                icon: ogCheck === 'PASS' ? 'check-circle' : 'exclamation-circle'
            });

            // 6. Check robots
            const robots = doc.querySelector('meta[name="robots"]');
            checks.push({
                name: 'Robots Meta',
                status: robots ? 'PASS' : 'INFO',
                value: robots?.getAttribute('content') || 'Default (index, follow)',
                recommendation: robots ? 'Controls search engine crawling' : 'Optional - controls crawler behavior',
                icon: 'info-circle'
            });

            // Render results
            let html_result = `<div class="mb-3">
                <h6 class="fw-bold mb-3">Meta Tag Analysis</h6>
            `;

            checks.forEach(check => {
                const badgeClass = check.status === 'PASS' ? 'bg-success' :
                                   check.status === 'FAIL' ? 'bg-danger' :
                                   check.status === 'WARN' ? 'bg-warning' : 'bg-info';

                html_result += `
                    <div class="card card-sm mb-2">
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <strong><i class="fas fa-${check.icon} me-2"></i>${check.name}</strong>
                                <span class="badge ${badgeClass}">${check.status}</span>
                            </div>
                            <small class="text-muted d-block mb-2">Value: <code>${escapeHtml(check.value.substring(0, 50))}${check.value.length > 50 ? '...' : ''}</code></small>
                            <small>${check.recommendation}</small>
                        </div>
                    </div>
                `;
            });

            const passCount = checks.filter(c => c.status === 'PASS').length;
            const failCount = checks.filter(c => c.status === 'FAIL').length;
            const warnCount = checks.filter(c => c.status === 'WARN').length;

            html_result += `
                </div>
                <div class="alert alert-info mb-0">
                    <strong>Summary:</strong>
                    <ul class="mb-0 mt-2" style="font-size: 13px;">
                        <li><span class="badge bg-success">${passCount}</span> Passed</li>
                        <li><span class="badge bg-danger">${failCount}</span> Failed</li>
                        <li><span class="badge bg-warning">${warnCount}</span> Warnings</li>
                        <li>Total meta tags: ${allMetaTags.length}</li>
                    </ul>
                </div>
            `;

            results.innerHTML = html_result;

        } catch (e) {
            alert('Error parsing HTML: ' + e.message);
        }
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    analyzeBtn.addEventListener('click', analyze);
    htmlContent.addEventListener('keydown', (e) => {
        if (e.ctrlKey && e.key === 'Enter') {
            analyze();
        }
    });
});
</script>
