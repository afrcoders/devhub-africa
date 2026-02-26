{{-- XML Sitemap Generator --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Generate XML sitemaps for your website.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-sitemap me-3"></i>XML Sitemap Generator
                </h1>
                <p class="lead text-muted">
                    Create XML sitemaps for search engine optimization
                </p>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Add URLs</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="urlInput" class="form-label fw-semibold">URL:</label>
                                <input type="url" class="form-control" id="urlInput" placeholder="https://example.com/page">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="priority" class="form-label fw-semibold">Priority (0.0-1.0):</label>
                                    <input type="number" class="form-control" id="priority" min="0" max="1" step="0.1" value="0.8">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="changefreq" class="form-label fw-semibold">Change Frequency:</label>
                                    <select class="form-select" id="changefreq">
                                        <option value="always">Always</option>
                                        <option value="hourly">Hourly</option>
                                        <option value="daily" selected>Daily</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="monthly">Monthly</option>
                                        <option value="yearly">Yearly</option>
                                        <option value="never">Never</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="lastmod" class="form-label fw-semibold">Last Modified:</label>
                                <input type="date" class="form-control" id="lastmod">
                            </div>

                            <button type="button" id="addBtn" class="btn btn-primary w-100">
                                <i class="fas fa-plus me-2"></i>Add URL
                            </button>

                            <hr class="my-4">

                            <h6 class="fw-bold mb-3">URL List <span class="badge bg-info" id="urlCount">0</span></h6>
                            <div id="urlList" style="max-height: 300px; overflow-y: auto;">
                                <p class="text-muted text-center">No URLs added yet</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-code me-2"></i>XML Output</h5>
                        </div>
                        <div class="card-body">
                            <pre id="output" style="background: #f8f9fa; padding: 15px; border-radius: 8px; max-height: 600px; overflow-y: auto; font-size: 12px;"><code></code></pre>
                        </div>
                        <div class="card-footer d-grid gap-2">
                            <button type="button" id="copyBtn" class="btn btn-success">
                                <i class="fas fa-copy me-2"></i>Copy XML
                            </button>
                            <button type="button" id="downloadBtn" class="btn btn-info">
                                <i class="fas fa-download me-2"></i>Download sitemap.xml
                            </button>
                            <button type="button" id="clearBtn" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i>Clear All
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let urls = [];

    const urlInput = document.getElementById('urlInput');
    const priority = document.getElementById('priority');
    const changefreq = document.getElementById('changefreq');
    const lastmod = document.getElementById('lastmod');
    const addBtn = document.getElementById('addBtn');
    const urlList = document.getElementById('urlList');
    const urlCount = document.getElementById('urlCount');
    const output = document.querySelector('#output code');
    const copyBtn = document.getElementById('copyBtn');
    const downloadBtn = document.getElementById('downloadBtn');
    const clearBtn = document.getElementById('clearBtn');

    function generateXML() {
        let xml = `<?xml version="1.0" encoding="UTF-8"?>\n`;
        xml += `<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n`;

        urls.forEach(item => {
            xml += `  <url>\n`;
            xml += `    <loc>${escapeXml(item.url)}</loc>\n`;
            if (item.lastmod) {
                xml += `    <lastmod>${item.lastmod}</lastmod>\n`;
            }
            xml += `    <changefreq>${item.changefreq}</changefreq>\n`;
            xml += `    <priority>${item.priority}</priority>\n`;
            xml += `  </url>\n`;
        });

        xml += `</urlset>`;
        output.textContent = xml;
    }

    function escapeXml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&apos;');
    }

    function renderURLList() {
        if (urls.length === 0) {
            urlList.innerHTML = '<p class="text-muted text-center">No URLs added yet</p>';
            urlCount.textContent = '0';
            return;
        }

        urlList.innerHTML = urls.map((item, index) => `
            <div class="card card-sm mb-2">
                <div class="card-body p-2">
                    <small><strong>${escapeHtml(item.url)}</strong></small>
                    <div style="font-size: 11px; color: #666; margin-top: 4px;">
                        <i class="fas fa-circle-notch me-1"></i>Priority: ${item.priority}
                        <i class="fas fa-sync-alt me-1 ms-2"></i>Frequency: ${item.changefreq}
                        ${item.lastmod ? `<i class="fas fa-calendar me-1 ms-2"></i>Modified: ${item.lastmod}` : ''}
                    </div>
                    <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeURL(${index})">
                        <i class="fas fa-trash me-1"></i>Remove
                    </button>
                </div>
            </div>
        `).join('');

        urlCount.textContent = urls.length;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    window.removeURL = function(index) {
        urls.splice(index, 1);
        renderURLList();
        generateXML();
    };

    function addURL() {
        if (!urlInput.value.trim()) {
            alert('Please enter a URL');
            return;
        }

        try {
            new URL(urlInput.value);
        } catch (e) {
            alert('Invalid URL format');
            return;
        }

        urls.push({
            url: urlInput.value.trim(),
            priority: priority.value,
            changefreq: changefreq.value,
            lastmod: lastmod.value
        });

        urlInput.value = '';
        lastmod.value = '';
        renderURLList();
        generateXML();
    }

    function copyXML() {
        const xml = output.textContent;
        navigator.clipboard.writeText(xml).then(() => {
            copyBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
            setTimeout(() => {
                copyBtn.innerHTML = '<i class="fas fa-copy me-2"></i>Copy XML';
            }, 2000);
        });
    }

    function downloadXML() {
        const xml = output.textContent;
        const blob = new Blob([xml], { type: 'application/xml' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'sitemap.xml';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function clearAll() {
        if (confirm('Are you sure you want to clear all URLs?')) {
            urls = [];
            renderURLList();
            generateXML();
        }
    }

    addBtn.addEventListener('click', addURL);
    urlInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') addURL();
    });
    copyBtn.addEventListener('click', copyXML);
    downloadBtn.addEventListener('click', downloadXML);
    clearBtn.addEventListener('click', clearAll);

    generateXML();
});
</script>
