{{-- Twitter Card Generator --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Generate Twitter Card meta tags for optimal social media sharing.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fab fa-twitter me-3"></i>Twitter Card Generator
                </h1>
                <p class="lead text-muted">
                    Create Twitter Card meta tags for better social sharing
                </p>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Card Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="cardType" class="form-label fw-semibold">Card Type:</label>
                                <select class="form-select" id="cardType">
                                    <option value="summary">Summary Card</option>
                                    <option value="summary_large_image">Summary Card with Large Image</option>
                                    <option value="app">App Card</option>
                                    <option value="player">Player Card</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label fw-semibold">Title:</label>
                                <input type="text" class="form-control" id="title" placeholder="Tweet title (70 characters)">
                                <small class="text-muted">Max 70 characters</small>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-semibold">Description:</label>
                                <textarea class="form-control" id="description" rows="3" placeholder="Brief description (200 characters)"></textarea>
                                <small class="text-muted">Max 200 characters</small>
                            </div>

                            <div class="mb-3">
                                <label for="imageUrl" class="form-label fw-semibold">Image URL:</label>
                                <input type="url" class="form-control" id="imageUrl" placeholder="https://example.com/image.jpg">
                            </div>

                            <div class="mb-3">
                                <label for="url" class="form-label fw-semibold">Page URL:</label>
                                <input type="url" class="form-control" id="url" placeholder="https://example.com">
                            </div>

                            <div class="mb-3">
                                <label for="siteHandle" class="form-label fw-semibold">Site Twitter Handle:</label>
                                <div class="input-group">
                                    <span class="input-group-text">@</span>
                                    <input type="text" class="form-control" id="siteHandle" placeholder="twitter_handle">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="creatorHandle" class="form-label fw-semibold">Creator Twitter Handle:</label>
                                <div class="input-group">
                                    <span class="input-group-text">@</span>
                                    <input type="text" class="form-control" id="creatorHandle" placeholder="twitter_handle">
                                </div>
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
    const imageUrl = document.getElementById('imageUrl');
    const url = document.getElementById('url');
    const siteHandle = document.getElementById('siteHandle');
    const creatorHandle = document.getElementById('creatorHandle');
    const cardType = document.getElementById('cardType');
    const output = document.querySelector('#output code');
    const preview = document.getElementById('preview');
    const copyBtn = document.getElementById('copyBtn');

    function generateCode() {
        let code = `<!-- Twitter Card Meta Tags -->\n`;
        code += `<meta name="twitter:card" content="${cardType.value}">\n`;
        code += `<meta name="twitter:title" content="${title.value || 'Your Title'}">\n`;
        code += `<meta name="twitter:description" content="${description.value || 'Your description'}">\n`;

        if (imageUrl.value) {
            code += `<meta name="twitter:image" content="${imageUrl.value}">\n`;
        }

        if (url.value) {
            code += `<meta name="twitter:url" content="${url.value}">\n`;
        }

        if (siteHandle.value) {
            code += `<meta name="twitter:site" content="@${siteHandle.value}">\n`;
        }

        if (creatorHandle.value) {
            code += `<meta name="twitter:creator" content="@${creatorHandle.value}">\n`;
        }

        output.textContent = code;

        // Update preview
        preview.innerHTML = `
            <div style="border: 1px solid #ddd; padding: 15px; border-radius: 8px; background: #f8f9fa;">
                <strong>${title.value || 'Your Title'}</strong>
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
    imageUrl.addEventListener('input', generateCode);
    url.addEventListener('input', generateCode);
    siteHandle.addEventListener('input', generateCode);
    creatorHandle.addEventListener('input', generateCode);
    cardType.addEventListener('change', generateCode);
    copyBtn.addEventListener('click', copyCode);

    generateCode();
});
</script>
