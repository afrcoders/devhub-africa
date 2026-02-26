{{-- HTML Validator --}}
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-check-double me-3"></i>HTML Validator
                </h1>
                <p class="lead text-muted">
                    Validate your HTML code for syntax errors and best practices
                </p>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-code me-2"></i>HTML to Validate</h5>
                        </div>
                        <div class="card-body">
                            <textarea id="htmlInput" class="form-control" rows="10" placeholder="Paste your HTML code here..." style="font-family: 'Courier New', monospace;"></textarea>
                            <div class="mt-3 d-grid gap-2">
                                <button type="button" id="validateBtn" class="btn btn-primary">
                                    <i class="fas fa-check-circle me-2"></i>Validate HTML
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
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-report me-2"></i>Validation Results</h5>
                        </div>
                        <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                            <div id="resultsContainer" style="display: none;">
                                <div id="statusBadge" class="mb-3"></div>
                                <div id="errorsList"></div>
                                <div id="warningsList" style="margin-top: 20px;"></div>
                                <div id="successMessage" class="alert alert-success" style="display: none; margin-top: 20px;">
                                    <i class="fas fa-check-circle me-2"></i>HTML is valid!
                                </div>
                            </div>
                            <div id="noResults" class="alert alert-secondary">
                                Validation results will appear here
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
    const validateBtn = document.getElementById('validateBtn');
    const clearBtn = document.getElementById('clearBtn');
    const resultsContainer = document.getElementById('resultsContainer');
    const noResults = document.getElementById('noResults');
    const statusBadge = document.getElementById('statusBadge');
    const errorsList = document.getElementById('errorsList');
    const warningsList = document.getElementById('warningsList');
    const successMessage = document.getElementById('successMessage');

    validateBtn.addEventListener('click', function() {
        const html = input.value.trim();
        if (!html) {
            resultsContainer.style.display = 'none';
            noResults.style.display = 'block';
            return;
        }

        const results = validateHTML(html);
        displayResults(results);
    });

    clearBtn.addEventListener('click', function() {
        input.value = '';
        resultsContainer.style.display = 'none';
        noResults.style.display = 'block';
        input.focus();
    });

    function validateHTML(html) {
        const errors = [];
        const warnings = [];
        const tagStack = [];
        const selfClosingTags = ['br', 'hr', 'img', 'input', 'link', 'meta', 'area', 'base', 'col', 'embed', 'source', 'track', 'wbr'];

        // Check for opening and closing tags
        const tagRegex = /<\/?([a-zA-Z][a-zA-Z0-9\-]*)[^>]*>/g;
        let match;
        let lineNum = 1;

        while ((match = tagRegex.exec(html)) !== null) {
            const fullTag = match[0];
            const tagName = match[1].toLowerCase();

            lineNum = html.substring(0, match.index).split('\n').length;

            if (fullTag.startsWith('</')) {
                // Closing tag
                if (tagStack.length === 0) {
                    errors.push({
                        line: lineNum,
                        message: `Unexpected closing tag: &lt;/${tagName}&gt;`,
                        type: 'error'
                    });
                } else if (tagStack[tagStack.length - 1] !== tagName) {
                    errors.push({
                        line: lineNum,
                        message: `Mismatched closing tag. Expected &lt;/${tagStack[tagStack.length - 1]}&gt;, found &lt;/${tagName}&gt;`,
                        type: 'error'
                    });
                    tagStack.pop();
                } else {
                    tagStack.pop();
                }
            } else if (fullTag.endsWith('/>') || selfClosingTags.includes(tagName)) {
                // Self-closing tag - OK
            } else {
                // Opening tag
                if (!fullTag.endsWith('/>')) {
                    tagStack.push(tagName);
                }
            }
        }

        // Check unclosed tags
        if (tagStack.length > 0) {
            tagStack.forEach(tag => {
                errors.push({
                    line: '-',
                    message: `Unclosed tag: &lt;${tag}&gt;`,
                    type: 'error'
                });
            });
        }

        // Check for common issues
        if (!html.match(/<\s*!doctype/i)) {
            warnings.push({
                message: 'Missing DOCTYPE declaration',
                type: 'warning'
            });
        }

        if (!html.match(/<\s*html/i)) {
            warnings.push({
                message: 'Missing &lt;html&gt; root element',
                type: 'warning'
            });
        }

        if (!html.match(/<\s*head/i)) {
            warnings.push({
                message: 'Missing &lt;head&gt; element',
                type: 'warning'
            });
        }

        if (!html.match(/<\s*body/i)) {
            warnings.push({
                message: 'Missing &lt;body&gt; element',
                type: 'warning'
            });
        }

        // Check for deprecated attributes
        const deprecatedRegex = /\s(bgcolor|border|cellpadding|cellspacing|align|valign)\s*=/gi;
        let deprecatedMatch;
        while ((deprecatedMatch = deprecatedRegex.exec(html)) !== null) {
            warnings.push({
                message: `Deprecated attribute: ${deprecatedMatch[1]}`,
                type: 'warning'
            });
        }

        return { errors, warnings };
    }

    function displayResults(results) {
        noResults.style.display = 'none';
        resultsContainer.style.display = 'block';

        errorsList.innerHTML = '';
        warningsList.innerHTML = '';
        successMessage.style.display = 'none';

        if (results.errors.length > 0) {
            errorsList.innerHTML = '<h6 class="text-danger mb-3"><i class="fas fa-exclamation-circle me-2"></i>Errors (' + results.errors.length + ')</h6>';
            const errorHtml = results.errors.map(err =>
                `<div class="alert alert-danger mb-2">
                    <small><strong>Line ${err.line}:</strong> ${err.message}</small>
                </div>`
            ).join('');
            errorsList.innerHTML += errorHtml;
            statusBadge.innerHTML = '<span class="badge bg-danger fs-6"><i class="fas fa-times-circle me-2"></i>Invalid HTML</span>';
        } else {
            statusBadge.innerHTML = '<span class="badge bg-success fs-6"><i class="fas fa-check-circle me-2"></i>No Errors Found</span>';
        }

        if (results.warnings.length > 0) {
            warningsList.innerHTML = '<h6 class="text-warning mb-3"><i class="fas fa-exclamation-triangle me-2"></i>Warnings (' + results.warnings.length + ')</h6>';
            const warningHtml = results.warnings.map(warn =>
                `<div class="alert alert-warning mb-2">
                    <small>${warn.message}</small>
                </div>`
            ).join('');
            warningsList.innerHTML += warningHtml;
        }

        if (results.errors.length === 0 && results.warnings.length === 0) {
            successMessage.style.display = 'block';
        }
    }
});
</script>
