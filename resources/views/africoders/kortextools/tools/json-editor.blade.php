{{-- JSON Editor --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    JSON Editor for editing, validating, and testing JSON data with live preview.
</div>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-code me-3"></i>JSON Editor
                </h1>
                <p class="lead text-muted">
                    Edit, validate, and test JSON with real-time tree view
                </p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>JSON Editor</h5>
                        <div>
                            <button type="button" id="formatBtn" class="btn btn-sm btn-outline-light">
                                <i class="fas fa-magic me-1"></i>Format
                            </button>
                            <button type="button" id="minifyBtn" class="btn btn-sm btn-outline-light ms-1">
                                <i class="fas fa-compress me-1"></i>Minify
                            </button>
                            <button type="button" id="clearBtn" class="btn btn-sm btn-outline-light ms-1">
                                <i class="fas fa-trash-alt me-1"></i>Clear
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0" style="height: 600px;">
                    <textarea class="form-control border-0 font-monospace h-100" id="jsonInput"
                        placeholder='Enter JSON here... e.g., {"name": "John", "age": 30}'
                        style="resize: none; outline: none; font-size: 14px; line-height: 1.5;"></textarea>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-tree me-2"></i>JSON Tree View</h5>
                        <button type="button" id="copyBtn" class="btn btn-sm btn-outline-light">
                            <i class="fas fa-copy me-1"></i>Copy
                        </button>
                    </div>
                </div>
                <div class="card-body" style="height: 600px; overflow-y: auto;">
                    <div id="treeView" class="font-monospace small">
                        <p class="text-muted text-center mt-5">JSON structure will appear here...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-check-circle me-2"></i>Validation Status</h5>
                </div>
                <div class="card-body">
                    <div id="validationStatus" class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>Enter JSON to validate
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const jsonInput = document.getElementById('jsonInput');
    const treeView = document.getElementById('treeView');
    const validationStatus = document.getElementById('validationStatus');
    const formatBtn = document.getElementById('formatBtn');
    const minifyBtn = document.getElementById('minifyBtn');
    const clearBtn = document.getElementById('clearBtn');
    const copyBtn = document.getElementById('copyBtn');

    function parseAndValidate() {
        const input = jsonInput.value.trim();
        if (!input) {
            treeView.innerHTML = '<p class="text-muted text-center mt-5">JSON structure will appear here...</p>';
            validationStatus.innerHTML = '<i class="fas fa-info-circle me-2"></i>Enter JSON to validate';
            validationStatus.className = 'alert alert-info';
            return null;
        }

        try {
            const parsed = JSON.parse(input);
            validationStatus.innerHTML = '<i class="fas fa-check-circle me-2"></i>Valid JSON';
            validationStatus.className = 'alert alert-success';
            renderTree(parsed);
            return parsed;
        } catch (error) {
            validationStatus.innerHTML = `<i class="fas fa-exclamation-circle me-2"></i><strong>Invalid JSON:</strong> ${error.message}`;
            validationStatus.className = 'alert alert-danger';
            treeView.innerHTML = '<p class="text-danger">JSON parsing failed</p>';
            return null;
        }
    }

    function renderTree(obj, level = 0) {
        const indent = '&nbsp;'.repeat(level * 3);
        let html = '';

        if (Array.isArray(obj)) {
            html += `<div>${indent}[</div>`;
            obj.forEach((item, index) => {
                if (typeof item === 'object' && item !== null) {
                    html += renderTree(item, level + 1);
                } else {
                    html += `<div>${indent}&nbsp;&nbsp;&nbsp;${JSON.stringify(item)}${index < obj.length - 1 ? ',' : ''}</div>`;
                }
            });
            html += `<div>${indent}]</div>`;
        } else if (typeof obj === 'object') {
            html += `<div>${indent}{</div>`;
            const keys = Object.keys(obj);
            keys.forEach((key, index) => {
                const value = obj[key];
                if (typeof value === 'object' && value !== null) {
                    html += `<div>${indent}&nbsp;&nbsp;"${key}": `;
                    html += renderTree(value, level + 1);
                    html += `${index < keys.length - 1 ? ',' : ''}</div>`;
                } else {
                    html += `<div>${indent}&nbsp;&nbsp;"${key}": ${JSON.stringify(value)}${index < keys.length - 1 ? ',' : ''}</div>`;
                }
            });
            html += `<div>${indent}}</div>`;
        } else {
            html = `<div>${indent}${JSON.stringify(obj)}</div>`;
        }

        return html;
    }

    function formatJSON() {
        const input = jsonInput.value.trim();
        if (!input) return;

        try {
            const parsed = JSON.parse(input);
            jsonInput.value = JSON.stringify(parsed, null, 2);
            parseAndValidate();
        } catch (e) {
            alert('Invalid JSON cannot be formatted.');
        }
    }

    function minifyJSON() {
        const input = jsonInput.value.trim();
        if (!input) return;

        try {
            const parsed = JSON.parse(input);
            jsonInput.value = JSON.stringify(parsed);
            parseAndValidate();
        } catch (e) {
            alert('Invalid JSON cannot be minified.');
        }
    }

    function clearEditor() {
        jsonInput.value = '';
        parseAndValidate();
    }

    function copyTree() {
        const text = treeView.innerText;
        navigator.clipboard.writeText(text).then(() => {
            const originalText = copyBtn.innerHTML;
            copyBtn.innerHTML = '<i class="fas fa-check me-1"></i>Copied!';
            copyBtn.classList.replace('btn-outline-light', 'btn-success');
            setTimeout(() => {
                copyBtn.innerHTML = originalText;
                copyBtn.classList.replace('btn-success', 'btn-outline-light');
            }, 2000);
        });
    }

    formatBtn.addEventListener('click', formatJSON);
    minifyBtn.addEventListener('click', minifyJSON);
    clearBtn.addEventListener('click', clearEditor);
    copyBtn.addEventListener('click', copyTree);

    jsonInput.addEventListener('input', parseAndValidate);
});
</script>
