<form id="markdown-to-html-form" method="POST" action="/tool/markdown-to-html" class="needs-validation">
    @csrf

    <!-- Markdown Input -->
    <div class="mb-3">
        <label for="markdown-input" class="form-label">
            <i class="bi bi-markdown me-2"></i>Markdown
        </label>
        <textarea
            class="form-control @error('markdown') is-invalid @enderror"
            id="markdown-input"
            name="markdown"
            rows="10"
            placeholder="# Heading
## Subheading

**Bold text** and *italic text*

[Link text](https://example.com)

- List item 1
- List item 2
  - Nested item"
            required
        ></textarea>
        @error('markdown')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
        <small class="form-text text-muted d-block mt-2">
            Supports: Headers (#, ##, ###), **bold**, *italic*, `code`, [links](url)
        </small>
    </div>

    <!-- Output Section -->
    <div id="html-output-section" class="mt-4" style="display: none;">
        <ul class="nav nav-tabs mb-3" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="preview-tab" data-bs-toggle="tab" data-bs-target="#preview-pane" type="button" role="tab">
                    <i class="bi bi-eye me-2"></i>Preview
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="source-tab" data-bs-toggle="tab" data-bs-target="#source-pane" type="button" role="tab">
                    <i class="bi bi-code me-2"></i>Source
                </button>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="preview-pane" role="tabpanel">
                <div class="output-box preview-box">
                    <div id="html-preview"></div>
                </div>
            </div>
            <div class="tab-pane fade" id="source-pane" role="tabpanel">
                <div class="output-box">
                    <pre id="html-source" class="html-source"></pre>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="copyHtmlToClipboard()">
            <i class="bi bi-clipboard me-2"></i>Copy HTML
        </button>
    </div>

    <!-- Action Buttons -->
    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
        <button
            type="reset"
            class="btn btn-secondary"
            onclick="document.getElementById('html-output-section').style.display='none'"
        >
            <i class="bi bi-arrow-clockwise me-2"></i>Clear
        </button>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-arrow-right-square me-2"></i>Convert to HTML
        </button>
    </div>
</form>

<script>
document.getElementById('markdown-to-html-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const markdown = document.getElementById('markdown-input').value;

    if (!markdown.trim()) {
        alert('Please enter markdown to convert');
        return;
    }

    try {
        const response = await fetch('/tool/markdown-to-html', {
            method: 'POST',
            body: new FormData(this),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const data = await response.json();

        if (data.success) {
            document.getElementById('html-preview').innerHTML = data.data.html;
            document.getElementById('html-source').textContent = data.data.html;
            document.getElementById('html-output-section').style.display = 'block';
        } else {
            alert('Error: ' + (data.message || 'Failed to convert'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred');
    }
});

function copyHtmlToClipboard() {
    const html = document.getElementById('html-source').textContent;
    navigator.clipboard.writeText(html);
    alert('HTML copied to clipboard!');
}
</script>

<style>
.output-box {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 1rem;
}

.preview-box {
    min-height: 300px;
    background-color: #fff;
}

.preview-box h1, .preview-box h2, .preview-box h3 {
    margin-top: 1rem;
    margin-bottom: 0.5rem;
}

.preview-box p {
    margin-bottom: 0.5rem;
}

.preview-box code {
    background-color: #f8f9fa;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    color: #d63384;
}

.preview-box strong {
    font-weight: 700;
}

.preview-box em {
    font-style: italic;
}

.preview-box a {
    color: #0d6efd;
    text-decoration: none;
}

.preview-box a:hover {
    text-decoration: underline;
}

.html-source {
    background-color: #fff;
    padding: 0.75rem;
    border-radius: 0.375rem;
    font-size: 0.85rem;
    overflow-x: auto;
    margin-bottom: 0;
}
</style>
