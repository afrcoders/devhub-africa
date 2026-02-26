{{-- JSON Beautifier --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    JSON Beautifier tool for formatting and prettifying JSON data.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-code me-3"></i>JSON Beautifier
                </h1>
                <p class="lead text-muted">
                    Format, validate, and beautify your JSON data with syntax highlighting
                </p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>JSON Formatter</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="jsonInput" class="form-label fw-semibold">
                                <i class="fas fa-file-code me-2"></i>Input JSON
                            </label>
                            <textarea class="form-control font-monospace" id="jsonInput" rows="20"
                                placeholder='Paste your JSON here... e.g., {"name": "John", "age": 30}'></textarea>
                            <div class="mt-2">
                                <button type="button" id="formatBtn" class="btn btn-primary">
                                    <i class="fas fa-magic me-2"></i>Format JSON
                                </button>
                                <button type="button" id="minifyBtn" class="btn btn-secondary ms-2">
                                    <i class="fas fa-compress me-2"></i>Minify
                                </button>
                                <button type="button" id="clearBtn" class="btn btn-outline-secondary ms-2">
                                    <i class="fas fa-trash-alt me-2"></i>Clear
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="jsonOutput" class="form-label fw-semibold">
                                <i class="fas fa-check-circle me-2 text-success"></i>Formatted JSON
                            </label>
                            <textarea class="form-control font-monospace" id="jsonOutput" rows="20" readonly></textarea>
                            <div class="mt-2">
                                <button type="button" id="copyBtn" class="btn btn-outline-primary">
                                    <i class="fas fa-copy me-2"></i>Copy Result
                                </button>
                                <button type="button" id="downloadBtn" class="btn btn-outline-secondary ms-2">
                                    <i class="fas fa-download me-2"></i>Download JSON
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="validationStatus" class="mt-3"></div>
                </div>
            </div>

            {{-- JSON Tools --}}
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-wrench me-2"></i>Additional Options</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="indentSize" class="form-label">Indentation Size</label>
                            <select class="form-select" id="indentSize">
                                <option value="2" selected>2 Spaces</option>
                                <option value="4">4 Spaces</option>
                                <option value="tab">Tab</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="sortKeys">
                                <label class="form-check-label" for="sortKeys">
                                    Sort object keys alphabetically
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="escapeUnicode">
                                <label class="form-check-label" for="escapeUnicode">
                                    Escape Unicode characters
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Example section --}}
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Example JSON</h5>
                </div>
                <div class="card-body">
                    <button type="button" id="loadExample" class="btn btn-outline-primary">
                        <i class="fas fa-play me-2"></i>Load Sample JSON
                    </button>
                    <p class="mt-2 mb-0 text-muted">Click to load a sample JSON for testing</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const jsonInput = document.getElementById('jsonInput');
    const jsonOutput = document.getElementById('jsonOutput');
    const validationStatus = document.getElementById('validationStatus');
    const indentSize = document.getElementById('indentSize');
    const sortKeys = document.getElementById('sortKeys');
    const escapeUnicode = document.getElementById('escapeUnicode');
    const formatBtn = document.getElementById('formatBtn');
    const minifyBtn = document.getElementById('minifyBtn');
    const clearBtn = document.getElementById('clearBtn');
    const copyBtn = document.getElementById('copyBtn');
    const downloadBtn = document.getElementById('downloadBtn');
    const loadExample = document.getElementById('loadExample');

    function showValidationStatus(isValid, message) {
        validationStatus.innerHTML = '';
        const alertClass = isValid ? 'alert-success' : 'alert-danger';
        const icon = isValid ? 'fa-check-circle' : 'fa-exclamation-circle';

        validationStatus.innerHTML = `
            <div class="alert ${alertClass} mb-0">
                <i class="fas ${icon} me-2"></i>${message}
            </div>
        `;
    }

    function formatJSON() {
        const input = jsonInput.value.trim();
        if (!input) {
            showValidationStatus(false, 'Please enter JSON to format.');
            return;
        }

        try {
            let parsed = JSON.parse(input);

            // Sort keys if requested
            if (sortKeys.checked) {
                parsed = sortObjectKeys(parsed);
            }

            // Get indent
            let indent = indentSize.value === 'tab' ? '\t' : parseInt(indentSize.value);

            // Format with options
            const formatted = JSON.stringify(parsed, null, indent);

            jsonOutput.value = formatted;
            showValidationStatus(true, 'JSON is valid and formatted successfully!');
        } catch (error) {
            showValidationStatus(false, `Invalid JSON: ${error.message}`);
            jsonOutput.value = '';
        }
    }

    function minifyJSON() {
        const input = jsonInput.value.trim();
        if (!input) {
            showValidationStatus(false, 'Please enter JSON to minify.');
            return;
        }

        try {
            const parsed = JSON.parse(input);
            const minified = JSON.stringify(parsed);

            jsonOutput.value = minified;
            showValidationStatus(true, 'JSON minified successfully!');
        } catch (error) {
            showValidationStatus(false, `Invalid JSON: ${error.message}`);
            jsonOutput.value = '';
        }
    }

    function sortObjectKeys(obj) {
        if (Array.isArray(obj)) {
            return obj.map(sortObjectKeys);
        } else if (obj !== null && typeof obj === 'object') {
            const sorted = {};
            Object.keys(obj).sort().forEach(key => {
                sorted[key] = sortObjectKeys(obj[key]);
            });
            return sorted;
        }
        return obj;
    }

    function clearAll() {
        jsonInput.value = '';
        jsonOutput.value = '';
        validationStatus.innerHTML = '';
    }

    function copyResult() {
        if (!jsonOutput.value) {
            alert('No formatted JSON to copy.');
            return;
        }

        jsonOutput.select();
        document.execCommand('copy');

        const originalText = copyBtn.innerHTML;
        copyBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
        copyBtn.classList.replace('btn-outline-primary', 'btn-success');

        setTimeout(() => {
            copyBtn.innerHTML = originalText;
            copyBtn.classList.replace('btn-success', 'btn-outline-primary');
        }, 2000);
    }

    function downloadJSON() {
        if (!jsonOutput.value) {
            alert('No formatted JSON to download.');
            return;
        }

        const blob = new Blob([jsonOutput.value], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'formatted.json';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }

    function loadSampleJSON() {
        const sampleJSON = {
            "name": "John Doe",
            "age": 30,
            "email": "john.doe@example.com",
            "address": {
                "street": "123 Main St",
                "city": "Anytown",
                "zipCode": "12345",
                "coordinates": {
                    "latitude": 40.7128,
                    "longitude": -74.0060
                }
            },
            "hobbies": ["reading", "photography", "traveling"],
            "isActive": true,
            "spouse": null,
            "children": [
                {"name": "Alice", "age": 8},
                {"name": "Bob", "age": 5}
            ]
        };

        jsonInput.value = JSON.stringify(sampleJSON);
        formatJSON();
    }

    // Event listeners
    formatBtn.addEventListener('click', formatJSON);
    minifyBtn.addEventListener('click', minifyJSON);
    clearBtn.addEventListener('click', clearAll);
    copyBtn.addEventListener('click', copyResult);
    downloadBtn.addEventListener('click', downloadJSON);
    loadExample.addEventListener('click', loadSampleJSON);

    // Auto-format on input change
    jsonInput.addEventListener('input', function() {
        if (jsonInput.value.trim()) {
            formatJSON();
        } else {
            validationStatus.innerHTML = '';
        }
    });

    // Re-format when options change
    [indentSize, sortKeys, escapeUnicode].forEach(element => {
        element.addEventListener('change', function() {
            if (jsonInput.value.trim()) {
                formatJSON();
            }
        });
    });
});
</script>
