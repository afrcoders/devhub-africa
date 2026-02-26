<div class="row">
    <div class="col-md-12">
        <div class="mb-4">
            <label for="css-input" class="form-label">CSS Code to Minify:</label>
            <textarea
                class="form-control"
                id="css-input"
                rows="12"
                placeholder="/* Enter your CSS code here */
body {
    background-color: #ffffff;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 20px;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
}"
            ></textarea>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="preserve-comments" checked>
                    <label class="form-check-label" for="preserve-comments">
                        Preserve important comments (/*! */)
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remove-unused" checked>
                    <label class="form-check-label" for="remove-unused">
                        Remove unnecessary whitespace
                    </label>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <button type="button" class="btn btn-primary" onclick="minifyCSS()">
                <i class="bi bi-arrows-collapse"></i> Minify CSS
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="clearCSS()">
                <i class="bi bi-x-circle"></i> Clear
            </button>
            <button type="button" class="btn btn-outline-info" onclick="formatCSS()">
                <i class="bi bi-arrows-expand"></i> Format/Beautify
            </button>
        </div>

        <!-- Output -->
        <div id="css-output" style="display: none;">
            <label for="css-result" class="form-label">Minified CSS:</label>
            <div class="output-box">
                <textarea id="css-result" class="form-control" rows="8" readonly></textarea>
                <div class="d-flex justify-content-between mt-2">
                    <small class="text-muted" id="css-stats"></small>
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="copyToClipboard('css-result')">
                            <i class="bi bi-clipboard"></i> Copy
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-success" onclick="downloadCSS()">
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
    <h6><i class="bi bi-info-circle"></i> About CSS Minification</h6>
    <p class="mb-0">
        CSS minification removes unnecessary characters like spaces, newlines, and comments to reduce file size.
        This improves page load times by reducing the amount of data that needs to be transferred.
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
function minifyCSS() {
    const cssInput = document.getElementById('css-input').value.trim();
    const preserveComments = document.getElementById('preserve-comments').checked;
    const removeUnused = document.getElementById('remove-unused').checked;

    if (!cssInput) {
        alert('Please enter CSS code to minify.');
        return;
    }

    let minified = cssInput;

    // Remove regular comments but preserve important ones (/*! */)
    if (!preserveComments) {
        minified = minified.replace(/\/\*[^!][\s\S]*?\*\//g, '');
    } else {
        minified = minified.replace(/\/\*(?!\!)[\s\S]*?\*\//g, '');
    }

    if (removeUnused) {
        // Remove unnecessary whitespace
        minified = minified
            // Remove extra spaces and tabs
            .replace(/\s+/g, ' ')
            // Remove spaces around specific characters
            .replace(/\s*{\s*/g, '{')
            .replace(/\s*}\s*/g, '}')
            .replace(/\s*:\s*/g, ':')
            .replace(/\s*;\s*/g, ';')
            .replace(/\s*,\s*/g, ',')
            .replace(/\s*>\s*/g, '>')
            .replace(/\s*\+\s*/g, '+')
            .replace(/\s*~\s*/g, '~')
            // Remove trailing semicolons before }
            .replace(/;}/g, '}')
            // Remove leading/trailing whitespace
            .trim();
    }

    document.getElementById('css-result').value = minified;
    document.getElementById('css-output').style.display = 'block';

    // Update stats
    updateCSSStats(cssInput, minified);
}

function formatCSS() {
    const cssInput = document.getElementById('css-input').value.trim();

    if (!cssInput) {
        alert('Please enter CSS code to format.');
        return;
    }

    let formatted = cssInput
        // Add newlines after braces
        .replace(/{/g, ' {\\n    ')
        .replace(/}/g, '\\n}\\n')
        // Add newlines after semicolons
        .replace(/;/g, ';\\n    ')
        // Clean up extra spaces
        .replace(/\s+/g, ' ')
        // Fix indentation
        .replace(/\\n\s*\\n/g, '\\n')
        .replace(/    }/g, '}')
        .replace(/\\n\\s*{/g, ' {')
        .trim();

    document.getElementById('css-result').value = formatted;
    document.getElementById('css-output').style.display = 'block';

    updateCSSStats(cssInput, formatted);
}

function clearCSS() {
    document.getElementById('css-input').value = '';
    document.getElementById('css-result').value = '';
    document.getElementById('css-output').style.display = 'none';
}

function updateCSSStats(original, processed) {
    const originalSize = new Blob([original]).size;
    const processedSize = new Blob([processed]).size;
    const savings = originalSize - processedSize;
    const percentage = originalSize > 0 ? ((savings / originalSize) * 100).toFixed(1) : 0;

    document.getElementById('css-stats').textContent =
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

function downloadCSS() {
    const content = document.getElementById('css-result').value;
    if (content) {
        const blob = new Blob([content], { type: 'text/css' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'minified.css';
        a.click();
        URL.revokeObjectURL(url);
    }
}
</script>
