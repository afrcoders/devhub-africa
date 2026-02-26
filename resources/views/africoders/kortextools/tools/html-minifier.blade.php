<div class="row">
    <div class="col-md-12">
        <div class="mb-4">
            <label for="html-input" class="form-label">HTML Code to Minify:</label>
            <textarea
                class="form-control"
                id="html-input"
                rows="12"
                placeholder="<!DOCTYPE html>
<html lang=&quot;en&quot;>
<head>
    <meta charset=&quot;UTF-8&quot;>
    <meta name=&quot;viewport&quot; content=&quot;width=device-width, initial-scale=1.0&quot;>
    <title>Sample HTML Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class=&quot;container&quot;>
        <h1>Welcome to Our Website</h1>
        <p>This is a sample paragraph with some text content.</p>

        <!-- This is a comment -->
        <ul>
            <li>Item 1</li>
            <li>Item 2</li>
            <li>Item 3</li>
        </ul>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded');
        });
    </script>
</body>
</html>"
            ></textarea>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remove-html-comments" checked>
                    <label class="form-check-label" for="remove-html-comments">
                        Remove HTML comments
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="preserve-line-breaks">
                    <label class="form-check-label" for="preserve-line-breaks">
                        Preserve line breaks in text
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remove-empty-attributes" checked>
                    <label class="form-check-label" for="remove-empty-attributes">
                        Remove empty attributes
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="collapse-whitespace" checked>
                    <label class="form-check-label" for="collapse-whitespace">
                        Collapse whitespace
                    </label>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <button type="button" class="btn btn-primary" onclick="minifyHTML()">
                <i class="bi bi-arrows-collapse"></i> Minify HTML
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="clearHTML()">
                <i class="bi bi-x-circle"></i> Clear
            </button>
            <button type="button" class="btn btn-outline-info" onclick="formatHTML()">
                <i class="bi bi-arrows-expand"></i> Format/Beautify
            </button>
        </div>

        <!-- Output -->
        <div id="html-output" style="display: none;">
            <label for="html-result" class="form-label">Minified HTML:</label>
            <div class="output-box">
                <textarea id="html-result" class="form-control" rows="8" readonly></textarea>
                <div class="d-flex justify-content-between mt-2">
                    <small class="text-muted" id="html-stats"></small>
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="copyToClipboard('html-result')">
                            <i class="bi bi-clipboard"></i> Copy
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-success" onclick="downloadHTML()">
                            <i class="bi bi-download"></i> Download
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Information -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> About HTML Minification</h6>
    <p class="mb-0">
        HTML minification removes unnecessary characters like extra spaces, newlines, and comments to reduce file size.
        This improves page load times by reducing the amount of data transferred. Be careful with text content that relies on whitespace for formatting.
    </p>
</div>

<style>
.output-box {
    position: relative;
}
.output-box .form-control {
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
}
</style>

<script>
function minifyHTML() {
    const htmlInput = document.getElementById('html-input').value.trim();
    const removeComments = document.getElementById('remove-html-comments').checked;
    const preserveLineBreaks = document.getElementById('preserve-line-breaks').checked;
    const removeEmptyAttributes = document.getElementById('remove-empty-attributes').checked;
    const collapseWhitespace = document.getElementById('collapse-whitespace').checked;

    if (!htmlInput) {
        alert('Please enter HTML code to minify.');
        return;
    }

    let minified = htmlInput;

    // Remove HTML comments
    if (removeComments) {
        minified = minified.replace(/<!--[\s\S]*?-->/g, '');
    }

    // Remove empty attributes
    if (removeEmptyAttributes) {
        minified = minified.replace(/\s+(?:class|id|style|title|alt|src|href)=["']['"]/g, '');
    }

    // Collapse whitespace
    if (collapseWhitespace) {
        // Preserve content within <pre>, <code>, <textarea> tags
        const preserveTags = [];
        const tagRegex = /<(pre|code|textarea)[^>]*>[\s\S]*?<\/\1>/gi;
        let match;
        let index = 0;

        while ((match = tagRegex.exec(minified)) !== null) {
            const placeholder = `__PRESERVE_${index}__`;
            preserveTags.push({placeholder, content: match[0]});
            minified = minified.replace(match[0], placeholder);
            index++;
        }

        // Collapse whitespace
        if (!preserveLineBreaks) {
            minified = minified.replace(/\s+/g, ' ');
        } else {
            minified = minified.replace(/[ \t]+/g, ' ');
        }

        // Remove spaces around tags
        minified = minified
            .replace(/>\s+</g, '><')
            .replace(/^\s+|\s+$/g, '');

        // Restore preserved content
        preserveTags.forEach(tag => {
            minified = minified.replace(tag.placeholder, tag.content);
        });
    }

    document.getElementById('html-result').value = minified;
    document.getElementById('html-output').style.display = 'block';

    // Update stats
    updateHTMLStats(htmlInput, minified);
}

function formatHTML() {
    const htmlInput = document.getElementById('html-input').value.trim();

    if (!htmlInput) {
        alert('Please enter HTML code to format.');
        return;
    }

    let formatted = htmlInput;
    let indentLevel = 0;
    const indentSize = 2;

    // Basic HTML formatting (simplified)
    formatted = formatted
        // Add newlines before and after tags
        .replace(/></g, '>\\n<')
        .replace(/^\s+|\s+$/gm, '') // Remove leading/trailing spaces on each line
        .split('\\n')
        .map(line => {
            line = line.trim();
            if (!line) return '';

            // Decrease indent for closing tags
            if (line.match(/^<\//)) {
                indentLevel = Math.max(0, indentLevel - 1);
            }

            const indentedLine = ' '.repeat(indentLevel * indentSize) + line;

            // Increase indent for opening tags (but not self-closing or closing tags)
            if (line.match(/^<[^\/][^>]*[^\/]>$/)) {
                // Skip certain tags that don't typically have children on new lines
                if (!line.match(/^<(br|hr|img|input|meta|link|area|base|col|embed|source|track|wbr)/i)) {
                    indentLevel++;
                }
            }

            return indentedLine;
        })
        .filter(line => line.trim() !== '')
        .join('\\n');

    document.getElementById('html-result').value = formatted;
    document.getElementById('html-output').style.display = 'block';

    updateHTMLStats(htmlInput, formatted);
}

function clearHTML() {
    document.getElementById('html-input').value = '';
    document.getElementById('html-result').value = '';
    document.getElementById('html-output').style.display = 'none';
}

function updateHTMLStats(original, processed) {
    const originalSize = new Blob([original]).size;
    const processedSize = new Blob([processed]).size;
    const savings = originalSize - processedSize;
    const percentage = originalSize > 0 ? ((savings / originalSize) * 100).toFixed(1) : 0;

    document.getElementById('html-stats').textContent =
        `Original: ${originalSize} bytes | Processed: ${processedSize} bytes | Saved: ${savings} bytes (${percentage}%)`;
}

function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    if (element.value) {
        navigator.clipboard.writeText(element.value).then(function() {
            // Show success feedback
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="bi bi-check"></i> Copied!';
            button.classList.remove('btn-outline-primary');
            button.classList.add('btn-success');

            setTimeout(function() {
                button.innerHTML = originalText;
                button.classList.remove('btn-success');
                button.classList.add('btn-outline-primary');
            }, 2000);
        });
    }
}

function downloadHTML() {
    const content = document.getElementById('html-result').value;
    if (content) {
        const blob = new Blob([content], { type: 'text/html' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'minified.html';
        a.click();
        URL.revokeObjectURL(url);
    }
}
</script>
