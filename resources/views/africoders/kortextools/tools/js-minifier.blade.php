<div class="row">
    <div class="col-md-12">
        <div class="mb-4">
            <label for="js-input" class="form-label">JavaScript Code to Minify:</label>
            <textarea
                class="form-control"
                id="js-input"
                rows="12"
                placeholder="// Enter your JavaScript code here
function calculateSum(a, b) {
    // This function adds two numbers
    const result = a + b;
    console.log('Sum calculated:', result);
    return result;
}

const numbers = [1, 2, 3, 4, 5];
const total = numbers.reduce((sum, num) => {
    return sum + num;
}, 0);

document.addEventListener('DOMContentLoaded', function() {
    console.log('Page loaded, total:', total);
});"
            ></textarea>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="preserve-js-comments" checked>
                    <label class="form-check-label" for="preserve-js-comments">
                        Preserve important comments (/*! */ and //!)
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="mangle-variables">
                    <label class="form-check-label" for="mangle-variables">
                        Shorten variable names (basic)
                    </label>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <button type="button" class="btn btn-primary" onclick="minifyJS()">
                <i class="bi bi-arrows-collapse"></i> Minify JavaScript
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="clearJS()">
                <i class="bi bi-x-circle"></i> Clear
            </button>
            <button type="button" class="btn btn-outline-info" onclick="formatJS()">
                <i class="bi bi-arrows-expand"></i> Format/Beautify
            </button>
        </div>

        <!-- Output -->
        <div id="js-output" style="display: none;">
            <label for="js-result" class="form-label">Minified JavaScript:</label>
            <div class="output-box">
                <textarea id="js-result" class="form-control" rows="8" readonly></textarea>
                <div class="d-flex justify-content-between mt-2">
                    <small class="text-muted" id="js-stats"></small>
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="copyToClipboard('js-result')">
                            <i class="bi bi-clipboard"></i> Copy
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-success" onclick="downloadJS()">
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
    <h6><i class="bi bi-info-circle"></i> About JavaScript Minification</h6>
    <p class="mb-0">
        JavaScript minification removes unnecessary characters, shortens variable names, and eliminates comments to reduce file size.
        This improves page load times and reduces bandwidth usage. For production use, consider advanced minifiers like UglifyJS or Terser.
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
function minifyJS() {
    const jsInput = document.getElementById('js-input').value.trim();
    const preserveComments = document.getElementById('preserve-js-comments').checked;
    const mangleVariables = document.getElementById('mangle-variables').checked;

    if (!jsInput) {
        alert('Please enter JavaScript code to minify.');
        return;
    }

    let minified = jsInput;

    // Remove comments
    if (!preserveComments) {
        // Remove single-line comments
        minified = minified.replace(/\/\/(?!\!).*$/gm, '');
        // Remove multi-line comments
        minified = minified.replace(/\/\*(?!\!)[\s\S]*?\*\//g, '');
    } else {
        // Remove regular comments but preserve important ones
        minified = minified.replace(/\/\/(?!\!).*$/gm, '');
        minified = minified.replace(/\/\*(?!\!)[\s\S]*?\*\//g, '');
    }

    // Basic minification
    minified = minified
        // Remove extra whitespace
        .replace(/\s+/g, ' ')
        // Remove spaces around operators
        .replace(/\s*([{}();,=+\-*/<>!&|])\s*/g, '$1')
        // Remove spaces around brackets
        .replace(/\s*\[\s*/g, '[')
        .replace(/\s*\]\s*/g, ']')
        .replace(/\s*\(\s*/g, '(')
        .replace(/\s*\)\s*/g, ')')
        // Remove trailing semicolons before }
        .replace(/;}/g, '}')
        // Fix spacing issues
        .replace(/}([a-zA-Z])/g, '}$1')
        .replace(/([a-zA-Z0-9])else/g, '$1 else')
        .replace(/else([a-zA-Z0-9])/g, 'else $1')
        .replace(/([a-zA-Z0-9])if/g, '$1 if')
        .replace(/if([a-zA-Z0-9])/g, 'if $1')
        .replace(/([a-zA-Z0-9])for/g, '$1 for')
        .replace(/for([a-zA-Z0-9])/g, 'for $1')
        .replace(/([a-zA-Z0-9])while/g, '$1 while')
        .replace(/while([a-zA-Z0-9])/g, 'while $1')
        .replace(/([a-zA-Z0-9])function/g, '$1 function')
        .replace(/function([a-zA-Z0-9])/g, 'function $1')
        .replace(/([a-zA-Z0-9])return/g, '$1 return')
        .replace(/return([a-zA-Z0-9])/g, 'return $1')
        .replace(/([a-zA-Z0-9])var/g, '$1 var')
        .replace(/var([a-zA-Z0-9])/g, 'var $1')
        .replace(/([a-zA-Z0-9])let/g, '$1 let')
        .replace(/let([a-zA-Z0-9])/g, 'let $1')
        .replace(/([a-zA-Z0-9])const/g, '$1 const')
        .replace(/const([a-zA-Z0-9])/g, 'const $1')
        // Remove leading/trailing whitespace
        .trim();

    document.getElementById('js-result').value = minified;
    document.getElementById('js-output').style.display = 'block';

    // Update stats
    updateJSStats(jsInput, minified);
}

function formatJS() {
    const jsInput = document.getElementById('js-input').value.trim();

    if (!jsInput) {
        alert('Please enter JavaScript code to format.');
        return;
    }

    let formatted = jsInput;
    let indentLevel = 0;
    const indentSize = 2;

    // Basic formatting (simplified)
    formatted = formatted
        // Add newlines after semicolons and braces
        .replace(/;/g, ';\\n')
        .replace(/{/g, '{\\n')
        .replace(/}/g, '\\n}\\n')
        // Clean up extra newlines
        .replace(/\\n\\s*\\n/g, '\\n')
        // Add basic indentation (simplified)
        .split('\\n')
        .map(line => {
            line = line.trim();
            if (line.includes('}')) indentLevel = Math.max(0, indentLevel - 1);
            const indentedLine = ' '.repeat(indentLevel * indentSize) + line;
            if (line.includes('{')) indentLevel++;
            return indentedLine;
        })
        .join('\\n')
        .trim();

    document.getElementById('js-result').value = formatted;
    document.getElementById('js-output').style.display = 'block';

    updateJSStats(jsInput, formatted);
}

function clearJS() {
    document.getElementById('js-input').value = '';
    document.getElementById('js-result').value = '';
    document.getElementById('js-output').style.display = 'none';
}

function updateJSStats(original, processed) {
    const originalSize = new Blob([original]).size;
    const processedSize = new Blob([processed]).size;
    const savings = originalSize - processedSize;
    const percentage = originalSize > 0 ? ((savings / originalSize) * 100).toFixed(1) : 0;

    document.getElementById('js-stats').textContent =
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

function downloadJS() {
    const content = document.getElementById('js-result').value;
    if (content) {
        const blob = new Blob([content], { type: 'text/javascript' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'minified.js';
        a.click();
        URL.revokeObjectURL(url);
    }
}
</script>
