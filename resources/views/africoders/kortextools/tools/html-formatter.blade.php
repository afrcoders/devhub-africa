{{-- HTML Formatter --}}
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-code me-3"></i>HTML Formatter
                </h1>
                <p class="lead text-muted">
                    Automatically format and beautify your HTML code with proper indentation
                </p>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-input-text me-2"></i>Input HTML</h5>
                        </div>
                        <div class="card-body">
                            <textarea id="htmlInput" class="form-control" rows="10" placeholder="Paste your HTML code here..." style="font-family: 'Courier New', monospace;"></textarea>
                            <div class="mt-3 d-grid gap-2">
                                <button type="button" id="formatBtn" class="btn btn-primary">
                                    <i class="fas fa-wand-magic-sparkles me-2"></i>Format HTML
                                </button>
                                <button type="button" id="clearBtn" class="btn btn-secondary">
                                    <i class="fas fa-trash me-2"></i>Clear
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-check-circle me-2"></i>Formatted Output</h5>
                        </div>
                        <div class="card-body">
                            <textarea id="htmlOutput" class="form-control" rows="10" readonly style="font-family: 'Courier New', monospace;"></textarea>
                            <div class="mt-3">
                                <button type="button" id="copyBtn" class="btn btn-info w-100">
                                    <i class="fas fa-copy me-2"></i>Copy to Clipboard
                                </button>
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
    const input = document.getElementById('htmlInput');
    const output = document.getElementById('htmlOutput');
    const formatBtn = document.getElementById('formatBtn');
    const clearBtn = document.getElementById('clearBtn');
    const copyBtn = document.getElementById('copyBtn');

    formatBtn.addEventListener('click', function() {
        const html = input.value.trim();
        if (!html) {
            output.value = '';
            return;
        }
        const formatted = formatHTML(html);
        output.value = formatted;
    });

    clearBtn.addEventListener('click', function() {
        input.value = '';
        output.value = '';
        input.focus();
    });

    copyBtn.addEventListener('click', function() {
        output.select();
        document.execCommand('copy');
        const originalText = copyBtn.innerHTML;
        copyBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
        setTimeout(() => {
            copyBtn.innerHTML = originalText;
        }, 2000);
    });

    function formatHTML(html) {
        let formatted = '';
        let indent = 0;
        let inTag = false;
        let tagName = '';
        let selfClosingTags = ['br', 'hr', 'img', 'input', 'link', 'meta', 'area', 'base', 'col', 'embed', 'source', 'track', 'wbr'];

        const lines = html.split(/>\s*</);

        for (let i = 0; i < lines.length; i++) {
            let line = lines[i].trim();
            if (!line) continue;

            if (i > 0) line = '<' + line;
            if (i < lines.length - 1) line = line + '>';

            // Check if closing tag
            if (line.startsWith('</')) {
                indent = Math.max(0, indent - 1);
                formatted += '  '.repeat(indent) + line + '\n';
            }
            // Check if self-closing or void tag
            else if (line.endsWith('/>') || selfClosingTags.some(tag => line.match(new RegExp(`^<${tag}[\\s>]`, 'i')))) {
                formatted += '  '.repeat(indent) + line + '\n';
            }
            // Check if opening tag
            else if (line.startsWith('<') && !line.startsWith('<!') && !line.startsWith('<?')) {
                formatted += '  '.repeat(indent) + line + '\n';

                // Extract tag name
                const tagMatch = line.match(/^<(\w+)/i);
                if (tagMatch && !line.endsWith('/>')) {
                    // Check if tag is not self-closing
                    if (!line.includes('/>')) {
                        indent++;
                    }
                }
            } else {
                formatted += '  '.repeat(indent) + line + '\n';
            }
        }

        return formatted.trim();
    }
});
</script>
