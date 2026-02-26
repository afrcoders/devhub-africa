
                    <form id="minifierForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="codeType" class="form-label">Code Type</label>
                                    <select class="form-select" id="codeType" required>
                                        <option value="">Select code type</option>
                                        <option value="javascript">JavaScript</option>
                                        <option value="css">CSS</option>
                                        <option value="html">HTML</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="sourceCode" class="form-label">Source Code</label>
                                    <textarea class="form-control font-monospace" id="sourceCode" rows="15" placeholder="Paste your code here..."></textarea>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-compress-alt me-2"></i>Minify Code
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="minifiedCode" class="form-label">Minified Code</label>
                                    <textarea class="form-control font-monospace" id="minifiedCode" rows="15" placeholder="Minified code will appear here..." readonly></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-outline-primary w-100" onclick="copyToClipboard('minifiedCode')">
                                            <i class="fas fa-copy me-2"></i>Copy
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button type="button" class="btn btn-outline-success w-100" onclick="downloadMinified()">
                                            <i class="fas fa-download me-2"></i>Download
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div id="compressionStats" class="mt-4" style="display: none;">
                        <div class="alert alert-info">
                            <h6>Compression Results:</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Original Size:</strong> <span id="originalSize"></span>
                                </div>
                                <div class="col-md-4">
                                    <strong>Minified Size:</strong> <span id="minifiedSize"></span>
                                </div>
                                <div class="col-md-4">
                                    <strong>Reduction:</strong> <span id="reductionPercent"></span>
                                </div>
                            </div>
                        </div>
                    </div>

<script>
document.getElementById('minifierForm').addEventListener('submit', function(e) {
    e.preventDefault();
    minifyCode();
});

function minifyCode() {
    const codeType = document.getElementById('codeType').value;
    const sourceCode = document.getElementById('sourceCode').value;

    if (!codeType || !sourceCode.trim()) {
        alert('Please select a code type and enter source code.');
        return;
    }

    let minifiedCode = '';

    try {
        switch(codeType) {
            case 'javascript':
                minifiedCode = minifyJavaScript(sourceCode);
                break;
            case 'css':
                minifiedCode = minifyCSS(sourceCode);
                break;
            case 'html':
                minifiedCode = minifyHTML(sourceCode);
                break;
            default:
                throw new Error('Invalid code type');
        }

        document.getElementById('minifiedCode').value = minifiedCode;
        showCompressionStats(sourceCode, minifiedCode);

    } catch (error) {
        alert('Error minifying code: ' + error.message);
    }
}

function minifyJavaScript(code) {
    return code
        .replace(/\/\*[\s\S]*?\*\//g, '') // Remove multi-line comments
        .replace(/\/\/.*$/gm, '') // Remove single-line comments
        .replace(/\s+/g, ' ') // Replace multiple whitespace with single space
        .replace(/;\s*}/g, '}') // Remove semicolons before closing braces
        .replace(/\s*([{}();,:])\s*/g, '$1') // Remove spaces around operators
        .replace(/^\s+|\s+$/g, ''); // Trim
}

function minifyCSS(code) {
    return code
        .replace(/\/\*[\s\S]*?\*\//g, '') // Remove comments
        .replace(/\s+/g, ' ') // Replace multiple whitespace with single space
        .replace(/\s*([{}:;,>+~])\s*/g, '$1') // Remove spaces around CSS operators
        .replace(/;\s*}/g, '}') // Remove last semicolon in declaration block
        .replace(/^\s+|\s+$/g, ''); // Trim
}

function minifyHTML(code) {
    return code
        .replace(/<!--[\s\S]*?-->/g, '') // Remove HTML comments
        .replace(/\s+/g, ' ') // Replace multiple whitespace with single space
        .replace(/>\s+</g, '><') // Remove spaces between tags
        .replace(/^\s+|\s+$/g, ''); // Trim
}

function showCompressionStats(original, minified) {
    const originalSize = new Blob([original]).size;
    const minifiedSize = new Blob([minified]).size;
    const reduction = ((originalSize - minifiedSize) / originalSize * 100).toFixed(1);

    document.getElementById('originalSize').textContent = formatBytes(originalSize);
    document.getElementById('minifiedSize').textContent = formatBytes(minifiedSize);
    document.getElementById('reductionPercent').textContent = reduction + '%';
    document.getElementById('compressionStats').style.display = 'block';
}

function formatBytes(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    element.select();
    document.execCommand('copy');

    // Show success feedback
    const btn = event.target.closest('button');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
    btn.classList.add('btn-success');
    btn.classList.remove('btn-outline-primary');

    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.classList.remove('btn-success');
        btn.classList.add('btn-outline-primary');
    }, 2000);
}

function downloadMinified() {
    const codeType = document.getElementById('codeType').value;
    const minifiedCode = document.getElementById('minifiedCode').value;

    if (!minifiedCode) {
        alert('Please minify code first.');
        return;
    }

    const extensions = {
        'javascript': 'js',
        'css': 'css',
        'html': 'html'
    };

    const filename = `minified.${extensions[codeType] || 'txt'}`;
    const blob = new Blob([minifiedCode], { type: 'text/plain' });
    const url = URL.createObjectURL(blob);

    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.click();

    URL.revokeObjectURL(url);
</script>
