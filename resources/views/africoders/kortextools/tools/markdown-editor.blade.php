{{-- Markdown Editor with Live Preview --}}
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-markdown me-3"></i>Markdown Editor
                </h1>
                <p class="lead text-muted">
                    Write Markdown with live preview
                </p>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-pen me-2"></i>Markdown Input</h5>
                        </div>
                        <div class="card-body p-0">
                            <textarea id="markdownInput" class="form-control border-0" rows="15" placeholder="# Heading
## Subheading

**Bold text** and *italic text*

[Link text](https://example.com)

- List item 1
- List item 2
  - Nested item

1. Numbered item 1
2. Numbered item 2

\`inline code\`

\`\`\`
code block
\`\`\`" style="font-family: 'Courier New', monospace; resize: none;"></textarea>
                            <div class="p-3 border-top bg-light d-flex gap-2">
                                <button type="button" id="downloadBtn" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download me-1"></i>Download
                                </button>
                                <button type="button" id="clearBtn" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-trash me-1"></i>Clear
                                </button>
                                <button type="button" id="copyBtn" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-copy me-1"></i>Copy
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-eye me-2"></i>Live Preview</h5>
                        </div>
                        <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                            <div id="preview" class="preview-content"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.preview-content {
    line-height: 1.6;
}
.preview-content h1 { font-size: 2.5rem; margin: 0.67em 0; font-weight: bold; }
.preview-content h2 { font-size: 2rem; margin: 0.75em 0; font-weight: bold; }
.preview-content h3 { font-size: 1.5rem; margin: 0.83em 0; font-weight: bold; }
.preview-content h4 { font-size: 1.17rem; margin: 1em 0; font-weight: bold; }
.preview-content h5 { font-size: 0.83rem; margin: 1.17em 0; font-weight: bold; }
.preview-content h6 { font-size: 0.67rem; margin: 1.33em 0; font-weight: bold; }
.preview-content p { margin: 1em 0; }
.preview-content ul, .preview-content ol { margin: 1em 0; padding-left: 2em; }
.preview-content li { margin: 0.5em 0; }
.preview-content code { background-color: #f4f4f4; padding: 2px 4px; border-radius: 3px; font-family: monospace; }
.preview-content pre { background-color: #f4f4f4; padding: 1em; border-radius: 5px; overflow-x: auto; margin: 1em 0; }
.preview-content pre code { background-color: transparent; padding: 0; }
.preview-content blockquote { border-left: 4px solid #ddd; padding-left: 1em; margin-left: 0; color: #666; }
.preview-content a { color: #0066cc; text-decoration: none; }
.preview-content a:hover { text-decoration: underline; }
.preview-content strong { font-weight: bold; }
.preview-content em { font-style: italic; }
.preview-content table { border-collapse: collapse; margin: 1em 0; }
.preview-content table td, .preview-content table th { border: 1px solid #ddd; padding: 8px; }
.preview-content table th { background-color: #f9f9f9; }
.preview-content hr { border: none; border-top: 2px solid #ddd; margin: 2em 0; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('markdownInput');
    const preview = document.getElementById('preview');
    const clearBtn = document.getElementById('clearBtn');
    const copyBtn = document.getElementById('copyBtn');
    const downloadBtn = document.getElementById('downloadBtn');

    input.addEventListener('input', function() {
        preview.innerHTML = markdownToHTML(input.value);
    });

    clearBtn.addEventListener('click', function() {
        input.value = '';
        preview.innerHTML = '';
        input.focus();
    });

    copyBtn.addEventListener('click', function() {
        input.select();
        document.execCommand('copy');
        const originalText = copyBtn.innerHTML;
        copyBtn.innerHTML = '<i class="fas fa-check me-1"></i>Copied!';
        setTimeout(() => {
            copyBtn.innerHTML = originalText;
        }, 2000);
    });

    downloadBtn.addEventListener('click', function() {
        const text = input.value;
        const element = document.createElement('a');
        element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
        element.setAttribute('download', 'document.md');
        element.style.display = 'none';
        document.body.appendChild(element);
        element.click();
        document.body.removeChild(element);
    });

    function markdownToHTML(markdown) {
        let html = markdown;

        // Escape HTML special characters
        html = html.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');

        // Headers
        html = html.replace(/^### (.*?)$/gm, '<h3>$1</h3>');
        html = html.replace(/^## (.*?)$/gm, '<h2>$1</h2>');
        html = html.replace(/^# (.*?)$/gm, '<h1>$1</h1>');

        // Horizontal rules
        html = html.replace(/^\s*[-*_]{3,}\s*$/gm, '<hr>');

        // Code blocks
        html = html.replace(/```(.*?)```/gs, '<pre><code>$1</code></pre>');

        // Inline code
        html = html.replace(/`([^`]+)`/g, '<code>$1</code>');

        // Bold
        html = html.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        html = html.replace(/__(.+?)__/g, '<strong>$1</strong>');

        // Italic
        html = html.replace(/\*(.*?)\*/g, '<em>$1</em>');
        html = html.replace(/_(.+?)_/g, '<em>$1</em>');

        // Links
        html = html.replace(/\[(.*?)\]\((.*?)\)/g, '<a href="$2" target="_blank">$1</a>');

        // Images
        html = html.replace(/!\[(.*?)\]\((.*?)\)/g, '<img src="$2" alt="$1" style="max-width: 100%; height: auto;">');

        // Blockquotes
        html = html.replace(/^&gt; (.*?)$/gm, '<blockquote>$1</blockquote>');

        // Unordered lists
        html = html.replace(/^\* (.*?)$/gm, '<li>$1</li>');
        html = html.replace(/^- (.*?)$/gm, '<li>$1</li>');
        html = html.replace(/^  \* (.*?)$/gm, '<li style="margin-left: 2em;">$1</li>');
        html = html.replace(/^  - (.*?)$/gm, '<li style="margin-left: 2em;">$1</li>');
        html = html.replace(/(<li>.*<\/li>)/s, '<ul>$1</ul>');
        html = html.replace(/<\/ul>\s*<ul>/g, '');

        // Ordered lists
        html = html.replace(/^\d+\. (.*?)$/gm, '<li>$1</li>');
        html = html.replace(/(<li>.*<\/li>)/s, (match) => {
            if (match.includes('<ul>')) return match;
            return '<ol>' + match + '</ol>';
        });
        html = html.replace(/<\/ol>\s*<ol>/g, '');

        // Paragraphs
        html = html.replace(/\n\n/g, '</p><p>');
        html = '<p>' + html + '</p>';

        // Clean up
        html = html.replace(/<p><\/p>/g, '');
        html = html.replace(/<p>(<h[1-6]>)/g, '$1');
        html = html.replace(/(<\/h[1-6]>)<\/p>/g, '$1');
        html = html.replace(/<p>(<ul>)/g, '$1');
        html = html.replace(/(<\/ul>)<\/p>/g, '$1');
        html = html.replace(/<p>(<ol>)/g, '$1');
        html = html.replace(/(<\/ol>)<\/p>/g, '$1');
        html = html.replace(/<p>(<blockquote>)/g, '$1');
        html = html.replace(/(<\/blockquote>)<\/p>/g, '$1');
        html = html.replace(/<p>(<pre>)/g, '$1');
        html = html.replace(/(<\/pre>)<\/p>/g, '$1');
        html = html.replace(/<p>(<hr>)/g, '$1');
        html = html.replace(/(<hr>)<\/p>/g, '$1');

        return html;
    }

    // Initial preview
    preview.innerHTML = markdownToHTML(input.value);
});
</script>
