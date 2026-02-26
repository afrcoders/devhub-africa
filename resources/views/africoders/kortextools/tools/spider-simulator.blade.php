{{-- Spider Simulator --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Simulate how search engines see your website.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-spider me-3"></i>Spider Simulator
                </h1>
                <p class="lead text-muted">
                    Simulate how search engine crawlers see your pages
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
                                <textarea class="form-control" id="htmlContent" rows="10" placeholder="<html>&#10;<head>..."></textarea>
                            </div>
                            <button type="button" id="analyzeBtn" class="btn btn-primary w-100">
                                <i class="fas fa-magnifying-glass me-2"></i>Analyze
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-bot me-2"></i>Bot View</h5>
                        </div>
                        <div class="card-body" id="botView" style="max-height: 600px; overflow-y: auto;">
                            <p class="text-muted text-center">Analysis will appear here</p>
                        </div>
                    </div>

                    <div class="card shadow-sm mt-3">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Analysis Summary</h5>
                        </div>
                        <div class="card-body" id="summary">
                            <p class="text-muted">Click "Analyze" to see results</p>
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
    const botView = document.getElementById('botView');
    const summary = document.getElementById('summary');

    function analyze() {
        try {
            const html = htmlContent.value;
            if (!html.trim()) {
                alert('Please paste HTML content');
                return;
            }

            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');

            // Extract all text content
            let botText = '';
            const walker = document.createTreeWalker(
                doc.body,
                NodeFilter.SHOW_TEXT,
                null,
                false
            );

            let node;
            while (node = walker.nextNode()) {
                const text = node.textContent.trim();
                if (text) {
                    botText += text + ' ';
                }
            }

            // Extract meta tags
            const title = doc.querySelector('title')?.textContent || 'No title found';
            const metaDescription = doc.querySelector('meta[name="description"]')?.getAttribute('content') || 'No description found';
            const metaKeywords = doc.querySelector('meta[name="keywords"]')?.getAttribute('content') || 'No keywords found';

            // Extract all links
            const links = Array.from(doc.querySelectorAll('a[href]')).map(a => ({
                text: a.textContent.trim(),
                href: a.getAttribute('href')
            }));

            // Extract all images
            const images = Array.from(doc.querySelectorAll('img')).map(img => ({
                src: img.getAttribute('src'),
                alt: img.getAttribute('alt') || 'No alt text'
            }));

            // Extract headings
            const headings = Array.from(doc.querySelectorAll('h1, h2, h3, h4, h5, h6')).map(h => ({
                level: h.tagName,
                text: h.textContent.trim()
            }));

            // Generate bot view
            let botHtml = `
                <div class="bg-light p-3 rounded mb-3">
                    <h6 class="fw-bold mb-2">
                        <i class="fas fa-file-text me-2"></i>Extracted Text Content:
                    </h6>
                    <p style="font-size: 12px; white-space: pre-wrap; word-break: break-word; max-height: 200px; overflow-y: auto;">
                        ${escapeHtml(botText.substring(0, 500))}${botText.length > 500 ? '...' : ''}
                    </p>
                </div>
            `;

            // Generate summary
            let summaryHtml = `
                <div class="mb-3">
                    <strong><i class="fas fa-heading me-2"></i>Title:</strong>
                    <p style="font-size: 14px; margin-top: 5px;">${escapeHtml(title)}</p>
                </div>

                <div class="mb-3">
                    <strong><i class="fas fa-text-width me-2"></i>Meta Description:</strong>
                    <p style="font-size: 14px; margin-top: 5px;">${escapeHtml(metaDescription)}</p>
                </div>

                <div class="mb-3">
                    <strong><i class="fas fa-tags me-2"></i>Meta Keywords:</strong>
                    <p style="font-size: 14px; margin-top: 5px;">${escapeHtml(metaKeywords)}</p>
                </div>

                <div class="mb-3">
                    <strong><i class="fas fa-link me-2"></i>Links Found:</strong>
                    <div style="background: #f8f9fa; padding: 10px; border-radius: 4px; max-height: 150px; overflow-y: auto;">
                        ${links.length > 0 ? links.slice(0, 10).map(l => `
                            <div style="font-size: 12px; margin-bottom: 5px;">
                                <span class="badge bg-primary">${escapeHtml(l.href.substring(0, 30))}${l.href.length > 30 ? '...' : ''}</span>
                                <small>${escapeHtml(l.text.substring(0, 30))}${l.text.length > 30 ? '...' : ''}</small>
                            </div>
                        `).join('') : '<small class="text-muted">No links found</small>'}
                        ${links.length > 10 ? `<small class="text-muted">...and ${links.length - 10} more</small>` : ''}
                    </div>
                </div>

                <div class="mb-3">
                    <strong><i class="fas fa-image me-2"></i>Images Found:</strong>
                    <small class="badge bg-info">${images.length} images</small>
                    <div style="background: #f8f9fa; padding: 10px; border-radius: 4px; max-height: 150px; overflow-y: auto; margin-top: 5px;">
                        ${images.length > 0 ? images.slice(0, 5).map(img => `
                            <div style="font-size: 12px; margin-bottom: 5px;">
                                <span class="badge bg-secondary">${escapeHtml(img.src.substring(0, 25))}${img.src.length > 25 ? '...' : ''}</span><br>
                                <small><strong>Alt:</strong> ${escapeHtml(img.alt.substring(0, 30))}${img.alt.length > 30 ? '...' : ''}</small>
                            </div>
                        `).join('') : '<small class="text-muted">No images found</small>'}
                    </div>
                </div>

                <div class="mb-3">
                    <strong><i class="fas fa-heading me-2"></i>Headings Found:</strong>
                    <small class="badge bg-warning">${headings.length} headings</small>
                    <div style="background: #f8f9fa; padding: 10px; border-radius: 4px; max-height: 150px; overflow-y: auto; margin-top: 5px;">
                        ${headings.length > 0 ? headings.slice(0, 10).map(h => `
                            <div style="font-size: 12px; margin-bottom: 3px;">
                                <span class="badge bg-secondary">${h.level}</span>
                                <small>${escapeHtml(h.text.substring(0, 40))}${h.text.length > 40 ? '...' : ''}</small>
                            </div>
                        `).join('') : '<small class="text-muted">No headings found</small>'}
                    </div>
                </div>

                <div class="alert alert-info mb-0">
                    <strong>Summary:</strong>
                    <ul class="mb-0 mt-2" style="font-size: 13px;">
                        <li>Total text: ${botText.length} characters</li>
                        <li>Total links: ${links.length}</li>
                        <li>Total images: ${images.length}</li>
                        <li>Total headings: ${headings.length}</li>
                    </ul>
                </div>
            `;

            botView.innerHTML = botHtml;
            summary.innerHTML = summaryHtml;

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
