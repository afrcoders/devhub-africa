{{-- Open Graph Generator --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Generate Open Graph meta tags for social media sharing.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fab fa-facebook me-3"></i>Open Graph Generator
                </h1>
                <p class="lead text-muted">
                    Create Open Graph meta tags for better social sharing
                </p>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Page Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="title" class="form-label fw-semibold">Title:</label>
                                <input type="text" class="form-control" id="title" placeholder="Page title">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-semibold">Description:</label>
                                <textarea class="form-control" id="description" rows="3" placeholder="Page description"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="url" class="form-label fw-semibold">URL:</label>
                                <input type="url" class="form-control" id="url" placeholder="https://example.com">
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label fw-semibold">Type:</label>
                                <select class="form-select" id="type">
                                    <option value="website">Website</option>
                                    <option value="article">Article</option>
                                    <option value="blog">Blog</option>
                                    <option value="video">Video</option>
                                    <option value="image">Image</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="imageUrl" class="form-label fw-semibold">Image URL:</label>
                                <input type="url" class="form-control" id="imageUrl" placeholder="https://example.com/image.jpg">
                            </div>

                            <div class="mb-3">
                                <label for="imageWidth" class="form-label fw-semibold">Image Width (px):</label>
                                <input type="number" class="form-control" id="imageWidth" placeholder="1200" value="1200">
                            </div>

                            <div class="mb-3">
                                <label for="imageHeight" class="form-label fw-semibold">Image Height (px):</label>
                                <input type="number" class="form-control" id="imageHeight" placeholder="630" value="630">
                            </div>

                            <div class="mb-3">
                                <label for="siteName" class="form-label fw-semibold">Site Name:</label>
                                <input type="text" class="form-control" id="siteName" placeholder="Your website name">
                            </div>

                            <div class="mb-3">
                                <label for="locale" class="form-label fw-semibold">Locale:</label>
                                <select class="form-select" id="locale">
                                    <option value="en_US">English (US)</option>
                                    <option value="en_GB">English (UK)</option>
                                    <option value="fr_FR">French</option>
                                    <option value="es_ES">Spanish</option>
                                    <option value="de_DE">German</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-code me-2"></i>Generated Code</h5>
                        </div>
                        <div class="card-body">
                            <pre id="output" style="background: #f8f9fa; padding: 15px; border-radius: 8px; max-height: 600px; overflow-y: auto;"><code></code></pre>
                        </div>
                        <div class="card-footer">
                            <button type="button" id="copyBtn" class="btn btn-success w-100">
                                <i class="fas fa-copy me-2"></i>Copy Code
                            </button>
                        </div>
                    </div>

                    <div class="card shadow-sm mt-3">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Preview</h5>
                        </div>
                        <div class="card-body" id="preview">
                            <p class="text-muted text-center">Preview will appear here</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const title = document.getElementById('title');
    const description = document.getElementById('description');
    const url = document.getElementById('url');
    const type = document.getElementById('type');
    const imageUrl = document.getElementById('imageUrl');
    const imageWidth = document.getElementById('imageWidth');
    const imageHeight = document.getElementById('imageHeight');
    const siteName = document.getElementById('siteName');
    const locale = document.getElementById('locale');
    const output = document.querySelector('#output code');
    const preview = document.getElementById('preview');
    const copyBtn = document.getElementById('copyBtn');

    function generateCode() {
        let code = `<!-- Open Graph Meta Tags -->\n`;
        code += `<meta property="og:title" content="${title.value || 'Your Title'}">\n`;
        code += `<meta property="og:description" content="${description.value || 'Your description'}">\n`;
        code += `<meta property="og:url" content="${url.value || 'https://example.com'}">\n`;
        code += `<meta property="og:type" content="${type.value}">\n`;

        if (imageUrl.value) {
            code += `<meta property="og:image" content="${imageUrl.value}">\n`;
            code += `<meta property="og:image:width" content="${imageWidth.value || '1200'}">\n`;
            code += `<meta property="og:image:height" content="${imageHeight.value || '630'}">\n`;
        }

        if (siteName.value) {
            code += `<meta property="og:site_name" content="${siteName.value}">\n`;
        }

        code += `<meta property="og:locale" content="${locale.value}">\n`;

        output.textContent = code;

        // Update preview
        preview.innerHTML = `
            <div style="border: 1px solid #ddd; padding: 15px; border-radius: 8px; background: #f8f9fa;">
                <strong style="font-size: 16px;">${title.value || 'Your Title'}</strong>
                <p style="margin: 8px 0; color: #666; font-size: 14px;">${description.value || 'Your description'}</p>
                ${imageUrl.value ? `<img src="${imageUrl.value}" style="max-width: 100%; margin: 8px 0; border-radius: 4px;" alt="Preview">` : ''}
                <small style="color: #999;">${url.value || 'https://example.com'}</small>
            </div>
        `;
    }

    function copyCode() {
        const code = output.textContent;
        navigator.clipboard.writeText(code).then(() => {
            copyBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
            setTimeout(() => {
                copyBtn.innerHTML = '<i class="fas fa-copy me-2"></i>Copy Code';
            }, 2000);
        });
    }

    title.addEventListener('input', generateCode);
    description.addEventListener('input', generateCode);
    url.addEventListener('input', generateCode);
    type.addEventListener('change', generateCode);
    imageUrl.addEventListener('input', generateCode);
    imageWidth.addEventListener('input', generateCode);
    imageHeight.addEventListener('input', generateCode);
    siteName.addEventListener('input', generateCode);
    locale.addEventListener('change', generateCode);
    copyBtn.addEventListener('click', copyCode);

    generateCode();
});
</script>
