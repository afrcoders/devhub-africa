{{-- CSS Formatter --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-code me-2"></i>
    Format and beautify your CSS code
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-palette me-3"></i>CSS Formatter
                </h1>
                <p class="lead text-muted">
                    Automatically format and beautify CSS code
                </p>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-input-text me-2"></i>Input CSS</h5>
                        </div>
                        <div class="card-body">
                            <textarea id="cssInput" class="form-control" rows="10" placeholder="Paste your CSS code here..." style="font-family: 'Courier New', monospace;"></textarea>
                            <div class="mt-3 d-grid gap-2">
                                <button type="button" id="formatBtn" class="btn btn-primary">
                                    <i class="fas fa-wand-magic-sparkles me-2"></i>Format CSS
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
                            <textarea id="cssOutput" class="form-control" rows="10" readonly style="font-family: 'Courier New', monospace;"></textarea>
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
    const input = document.getElementById('cssInput');
    const output = document.getElementById('cssOutput');
    const formatBtn = document.getElementById('formatBtn');
    const clearBtn = document.getElementById('clearBtn');
    const copyBtn = document.getElementById('copyBtn');

    formatBtn.addEventListener('click', function() {
        const css = input.value.trim();
        if (!css) {
            output.value = '';
            return;
        }
        const formatted = formatCSS(css);
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

    function formatCSS(css) {
        let formatted = '';
        let indent = 0;
        let inComment = false;
        let inString = false;
        let stringChar = '';

        for (let i = 0; i < css.length; i++) {
            const char = css[i];
            const nextChar = css[i + 1];
            const prevChar = i > 0 ? css[i - 1] : '';

            // Handle comments
            if (char === '/' && nextChar === '*' && !inString) {
                inComment = true;
                formatted += char;
                continue;
            }
            if (char === '*' && nextChar === '/' && inComment) {
                formatted += char + '/';
                inComment = false;
                i++;
                continue;
            }
            if (inComment) {
                formatted += char;
                continue;
            }

            // Handle strings
            if ((char === '"' || char === "'") && prevChar !== '\\' && !inComment) {
                if (!inString) {
                    inString = true;
                    stringChar = char;
                } else if (char === stringChar) {
                    inString = false;
                }
                formatted += char;
                continue;
            }
            if (inString) {
                formatted += char;
                continue;
            }

            // Format CSS
            if (char === '{') {
                formatted += ' {\n' + '  '.repeat(++indent);
            } else if (char === '}') {
                formatted = formatted.trimEnd();
                formatted += '\n' + '  '.repeat(--indent) + '}\n';
            } else if (char === ';') {
                formatted += ';\n' + '  '.repeat(indent);
            } else if (char === ',') {
                formatted += ',\n' + '  '.repeat(indent);
            } else if (char === ':' && !inString) {
                formatted += ': ';
            } else if (char !== ' ' || (prevChar !== ' ' && prevChar !== '\n' && prevChar !== '' && nextChar && nextChar !== ' ' && nextChar !== '\n')) {
                formatted += char;
            }
        }

        return formatted.trim();
    }
});
</script>
