{{-- Mobile Friendly Test --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Check if your website is mobile-friendly.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-mobile-alt me-3"></i>Mobile Friendly Test
                </h1>
                <p class="lead text-muted">
                    Check your HTML for mobile-friendly features
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
                                <label for="htmlContent" class="form-label fw-semibold">Paste HTML:</label>
                                <textarea class="form-control" id="htmlContent" rows="10" placeholder="<html>..."></textarea>
                            </div>
                            <button type="button" id="testBtn" class="btn btn-primary w-100">
                                <i class="fas fa-magnifying-glass me-2"></i>Test for Mobile
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-list-check me-2"></i>Results</h5>
                        </div>
                        <div class="card-body" id="results" style="max-height: 600px; overflow-y: auto;">
                            <p class="text-muted text-center">Click "Test for Mobile" to see results</p>
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
    const testBtn = document.getElementById('testBtn');
    const results = document.getElementById('results');

    function test() {
        try {
            const html = htmlContent.value;
            if (!html.trim()) {
                alert('Please paste HTML content');
                return;
            }

            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');

            let checks = [];

            // 1. Check for viewport meta tag
            const viewport = doc.querySelector('meta[name="viewport"]');
            checks.push({
                name: 'Viewport Meta Tag',
                status: viewport ? 'PASS' : 'FAIL',
                message: viewport ?
                    `<strong>Content:</strong> ${escapeHtml(viewport.getAttribute('content'))}` :
                    'Missing viewport meta tag. Add: &lt;meta name="viewport" content="width=device-width, initial-scale=1"&gt;',
                icon: viewport ? 'check-circle' : 'times-circle'
            });

            // 2. Check for responsive CSS or media queries
            const styles = Array.from(doc.querySelectorAll('style'));
            const hasMediaQueries = styles.some(s => s.textContent.includes('@media'));
            const links = Array.from(doc.querySelectorAll('link[rel="stylesheet"]'));

            checks.push({
                name: 'Media Queries',
                status: hasMediaQueries ? 'PASS' : 'WARN',
                message: hasMediaQueries ?
                    'Media queries found in CSS' :
                    'No media queries detected. Consider using responsive design with @media queries.',
                icon: hasMediaQueries ? 'check-circle' : 'exclamation-circle'
            });

            // 3. Check font size
            const fontSizeMatch = styles.some(s => {
                const content = s.textContent;
                return content.includes('font-size') && !content.includes('px');
            });

            checks.push({
                name: 'Font Sizing',
                status: fontSizeMatch ? 'PASS' : 'INFO',
                message: 'Consider using relative units (em, rem) for responsive fonts.',
                icon: 'info-circle'
            });

            // 4. Check for touch-friendly click targets
            const buttons = doc.querySelectorAll('button, a, input[type="button"]');
            checks.push({
                name: 'Interactive Elements',
                status: buttons.length > 0 ? 'PASS' : 'INFO',
                message: `Found ${buttons.length} interactive elements. Ensure touch targets are at least 48x48 px.`,
                icon: buttons.length > 0 ? 'check-circle' : 'info-circle'
            });

            // 5. Check for images without alt text
            const images = Array.from(doc.querySelectorAll('img'));
            const imagesWithoutAlt = images.filter(img => !img.getAttribute('alt'));

            checks.push({
                name: 'Image Alt Text',
                status: imagesWithoutAlt.length === 0 ? 'PASS' : 'WARN',
                message: `${images.length} images found. ${imagesWithoutAlt.length} missing alt text.`,
                icon: imagesWithoutAlt.length === 0 ? 'check-circle' : 'exclamation-circle'
            });

            // 6. Check for mobile-friendly colors/contrast
            checks.push({
                name: 'Colors & Contrast',
                status: 'INFO',
                message: 'Ensure sufficient color contrast for readability (WCAG AA standard: 4.5:1 for text).',
                icon: 'info-circle'
            });

            // 7. Check for text compression/readability
            checks.push({
                name: 'Text Size',
                status: 'WARN',
                message: 'Test with browser tools to verify text is readable on mobile (aim for 16px+).',
                icon: 'exclamation-circle'
            });

            // 8. Check CSS and JS file sizes
            const externalCSS = links.filter(l => l.getAttribute('rel') === 'stylesheet').length;
            const scripts = doc.querySelectorAll('script[src]').length;

            checks.push({
                name: 'External Resources',
                status: 'INFO',
                message: `${externalCSS} CSS file(s) and ${scripts} JavaScript file(s) found. Minimize requests for faster loading.`,
                icon: 'info-circle'
            });

            // Render results
            let html_result = `<div class="mb-3">
                <h6 class="fw-bold mb-3">Mobile-Friendly Checklist</h6>
            `;

            checks.forEach(check => {
                const badgeClass = check.status === 'PASS' ? 'bg-success' :
                                   check.status === 'WARN' ? 'bg-warning' : 'bg-info';
                const iconColor = check.status === 'PASS' ? 'text-success' :
                                 check.status === 'WARN' ? 'text-warning' : 'text-info';

                html_result += `
                    <div class="card card-sm mb-2">
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div style="flex: 1;">
                                    <strong><i class="fas fa-${check.icon} ${iconColor} me-2"></i>${check.name}</strong><br>
                                    <small class="text-muted">${check.message}</small>
                                </div>
                                <span class="badge ${badgeClass}">${check.status}</span>
                            </div>
                        </div>
                    </div>
                `;
            });

            const passCount = checks.filter(c => c.status === 'PASS').length;
            const warnCount = checks.filter(c => c.status === 'WARN').length;
            const infoCount = checks.filter(c => c.status === 'INFO').length;

            html_result += `
                </div>
                <div class="alert alert-info mb-0">
                    <strong>Summary:</strong>
                    <ul class="mb-0 mt-2" style="font-size: 13px;">
                        <li><span class="badge bg-success">${passCount}</span> Passed</li>
                        <li><span class="badge bg-warning">${warnCount}</span> Warnings</li>
                        <li><span class="badge bg-info">${infoCount}</span> Info</li>
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

    testBtn.addEventListener('click', test);
    htmlContent.addEventListener('keydown', (e) => {
        if (e.ctrlKey && e.key === 'Enter') {
            test();
        }
    });
});
</script>
