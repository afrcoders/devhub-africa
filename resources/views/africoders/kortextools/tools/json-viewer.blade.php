{{-- JSON Viewer --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-eye me-2"></i>
    View, format, and explore JSON data with syntax highlighting, tree view, and validation.
</div>>
            <!-- Header -->
            <div class="text-center mb-4">
                <h1 class="h2 mb-3">
                    <i class="fas fa-eye text-primary me-2"></i>
                    JSON Viewer
                </h1>
                <p class="text-muted">View, explore, and analyze JSON data with interactive tree view</p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- View Options -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">View Mode</label>
                            <select class="form-select" id="viewMode">
                                <option value="tree">Tree View</option>
                                <option value="formatted">Formatted Text</option>
                                <option value="raw">Raw JSON</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Theme</label>
                            <select class="form-select" id="theme">
                                <option value="light">Light</option>
                                <option value="dark">Dark</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Options</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="showLineNumbers" checked>
                                <label class="form-check-label" for="showLineNumbers">
                                    Show line numbers
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Input -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-semibold mb-0">JSON Input</label>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-secondary" id="loadSampleBtn">
                                    <i class="fas fa-file-code"></i> Load Sample
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="clearInputBtn">
                                    <i class="fas fa-trash"></i> Clear
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="loadFromFileBtn">
                                    <i class="fas fa-upload"></i> Load File
                                </button>
                            </div>
                        </div>
                        <textarea class="form-control font-monospace" id="jsonInput" rows="8"
                                  placeholder="Paste your JSON data here..."></textarea>
                        <input type="file" id="fileInput" accept=".json" style="display: none;">
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 mb-3 flex-wrap">
                        <button type="button" class="btn btn-primary" id="viewJsonBtn">
                            <i class="fas fa-eye"></i> View JSON
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="validateBtn">
                            <i class="fas fa-check-circle"></i> Validate
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="expandAllBtn">
                            <i class="fas fa-expand-alt"></i> Expand All
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="collapseAllBtn">
                            <i class="fas fa-compress-alt"></i> Collapse All
                        </button>
                    </div>

                    <!-- Validation Results -->
                    <div id="validationResult" class="mb-3" style="display: none;">
                        <div class="alert" id="validationAlert">
                            <div id="validationMessage"></div>
                        </div>
                    </div>

                    <!-- JSON Stats -->
                    <div id="jsonStats" class="mb-3" style="display: none;">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="text-center p-2 bg-light rounded">
                                    <div class="h5 mb-1" id="objectCount">0</div>
                                    <small class="text-muted">Objects</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-2 bg-light rounded">
                                    <div class="h5 mb-1" id="arrayCount">0</div>
                                    <small class="text-muted">Arrays</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-2 bg-light rounded">
                                    <div class="h5 mb-1" id="propertyCount">0</div>
                                    <small class="text-muted">Properties</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-2 bg-light rounded">
                                    <div class="h5 mb-1" id="depthLevel">0</div>
                                    <small class="text-muted">Max Depth</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- JSON Viewer -->
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-semibold mb-0">JSON View</label>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-secondary" id="copyJsonBtn">
                                    <i class="fas fa-copy"></i> Copy
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="downloadBtn">
                                    <i class="fas fa-download"></i> Download
                                </button>
                            </div>
                        </div>
                        <div id="jsonViewer" class="json-viewer border rounded p-3"></div>
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="card mt-4 bg-light border-0">
                <div class="card-body">
                    <h5 class="card-title">JSON Viewer Features</h5>
                    <div class="row text-muted small">
                        <div class="col-md-6">
                            <ul class="mb-0">
                                <li>Interactive tree view navigation</li>
                                <li>Syntax highlighting and validation</li>
                                <li>Expand/collapse all nodes</li>
                                <li>JSON statistics and analysis</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="mb-0">
                                <li>Multiple view modes (tree, formatted, raw)</li>
                                <li>Light and dark themes</li>
                                <li>Load from file or sample data</li>
                                <li>Export formatted JSON</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const jsonInput = document.getElementById('jsonInput');
    const jsonViewer = document.getElementById('jsonViewer');
    const viewJsonBtn = document.getElementById('viewJsonBtn');
    const validateBtn = document.getElementById('validateBtn');
    const expandAllBtn = document.getElementById('expandAllBtn');
    const collapseAllBtn = document.getElementById('collapseAllBtn');
    const copyJsonBtn = document.getElementById('copyJsonBtn');
    const downloadBtn = document.getElementById('downloadBtn');
    const loadSampleBtn = document.getElementById('loadSampleBtn');
    const clearInputBtn = document.getElementById('clearInputBtn');
    const loadFromFileBtn = document.getElementById('loadFromFileBtn');
    const fileInput = document.getElementById('fileInput');
    const viewMode = document.getElementById('viewMode');
    const theme = document.getElementById('theme');
    const showLineNumbers = document.getElementById('showLineNumbers');
    const validationResult = document.getElementById('validationResult');
    const validationAlert = document.getElementById('validationAlert');
    const validationMessage = document.getElementById('validationMessage');
    const jsonStats = document.getElementById('jsonStats');

    let currentJsonData = null;

    // Sample JSON data
    const sampleJson = {
        "name": "John Doe",
        "age": 30,
        "email": "john.doe@example.com",
        "address": {
            "street": "123 Main St",
            "city": "New York",
            "country": "USA",
            "coordinates": {
                "lat": 40.7128,
                "lng": -74.0060
            }
        },
        "hobbies": ["reading", "traveling", "photography"],
        "active": true,
        "scores": [85, 92, 78, 96],
        "metadata": {
            "created": "2023-01-15T10:30:00Z",
            "updated": "2023-12-30T15:45:00Z",
            "version": 2.1
        }
    };

    // Show validation result
    function showValidationResult(isValid, message) {
        validationResult.style.display = 'block';
        if (isValid) {
            validationAlert.className = 'alert alert-success';
            validationMessage.innerHTML = '<i class="fas fa-check-circle me-2"></i>' + message;
        } else {
            validationAlert.className = 'alert alert-danger';
            validationMessage.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>' + message;
        }
    }

    // Hide validation result
    function hideValidationResult() {
        validationResult.style.display = 'none';
    }

    // Calculate JSON statistics
    function calculateStats(obj, depth = 0) {
        let stats = {
            objects: 0,
            arrays: 0,
            properties: 0,
            maxDepth: depth
        };

        if (Array.isArray(obj)) {
            stats.arrays = 1;
            obj.forEach(item => {
                const childStats = calculateStats(item, depth + 1);
                stats.objects += childStats.objects;
                stats.arrays += childStats.arrays;
                stats.properties += childStats.properties;
                stats.maxDepth = Math.max(stats.maxDepth, childStats.maxDepth);
            });
        } else if (obj && typeof obj === 'object') {
            stats.objects = 1;
            const keys = Object.keys(obj);
            stats.properties += keys.length;

            keys.forEach(key => {
                const childStats = calculateStats(obj[key], depth + 1);
                stats.objects += childStats.objects;
                stats.arrays += childStats.arrays;
                stats.properties += childStats.properties;
                stats.maxDepth = Math.max(stats.maxDepth, childStats.maxDepth);
            });
        }

        return stats;
    }

    // Display statistics
    function displayStats(stats) {
        document.getElementById('objectCount').textContent = stats.objects;
        document.getElementById('arrayCount').textContent = stats.arrays;
        document.getElementById('propertyCount').textContent = stats.properties;
        document.getElementById('depthLevel').textContent = stats.maxDepth;
        jsonStats.style.display = 'block';
    }

    // Create tree view HTML
    function createTreeView(obj, key = '', level = 0) {
        const indent = '  '.repeat(level);
        let html = '';

        if (Array.isArray(obj)) {
            html += `<div class="json-item" data-level="${level}">`;
            html += `<span class="json-key">${key ? key + ': ' : ''}</span>`;
            html += `<span class="json-bracket expand-toggle" data-expanded="true">[</span>`;
            html += `<span class="json-count">${obj.length} items</span>`;
            html += `<div class="json-content">`;

            obj.forEach((item, index) => {
                html += createTreeView(item, `[${index}]`, level + 1);
            });

            html += `</div>`;
            html += `<span class="json-bracket">]</span>`;
            html += `</div>`;
        } else if (obj && typeof obj === 'object') {
            const keys = Object.keys(obj);
            html += `<div class="json-item" data-level="${level}">`;
            html += `<span class="json-key">${key ? key + ': ' : ''}</span>`;
            html += `<span class="json-bracket expand-toggle" data-expanded="true">{</span>`;
            html += `<span class="json-count">${keys.length} properties</span>`;
            html += `<div class="json-content">`;

            keys.forEach(objKey => {
                html += createTreeView(obj[objKey], objKey, level + 1);
            });

            html += `</div>`;
            html += `<span class="json-bracket">}</span>`;
            html += `</div>`;
        } else {
            // Leaf value
            let valueClass = 'json-string';
            let displayValue = JSON.stringify(obj);

            if (typeof obj === 'number') valueClass = 'json-number';
            else if (typeof obj === 'boolean') valueClass = 'json-boolean';
            else if (obj === null) valueClass = 'json-null';

            html += `<div class="json-item" data-level="${level}">`;
            html += `<span class="json-key">${key}: </span>`;
            html += `<span class="${valueClass}">${displayValue}</span>`;
            html += `</div>`;
        }

        return html;
    }

    // Render JSON view
    function renderJsonView(data) {
        const mode = viewMode.value;
        const isDark = theme.value === 'dark';

        jsonViewer.className = `json-viewer border rounded p-3 ${isDark ? 'json-dark' : ''}`;

        if (mode === 'tree') {
            jsonViewer.innerHTML = createTreeView(data);
            addTreeInteractivity();
        } else if (mode === 'formatted') {
            const formatted = JSON.stringify(data, null, 2);
            jsonViewer.innerHTML = `<pre class="json-formatted">${highlightJson(formatted)}</pre>`;
        } else {
            const raw = JSON.stringify(data);
            jsonViewer.innerHTML = `<pre class="json-raw">${escapeHtml(raw)}</pre>`;
        }
    }

    // Add expand/collapse functionality
    function addTreeInteractivity() {
        const toggles = jsonViewer.querySelectorAll('.expand-toggle');
        toggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const item = this.closest('.json-item');
                const content = item.querySelector('.json-content');
                const isExpanded = this.getAttribute('data-expanded') === 'true';

                if (isExpanded) {
                    content.style.display = 'none';
                    this.setAttribute('data-expanded', 'false');
                    this.classList.add('collapsed');
                } else {
                    content.style.display = 'block';
                    this.setAttribute('data-expanded', 'true');
                    this.classList.remove('collapsed');
                }
            });
        });
    }

    // Expand all nodes
    function expandAll() {
        const toggles = jsonViewer.querySelectorAll('.expand-toggle');
        toggles.forEach(toggle => {
            const content = toggle.closest('.json-item').querySelector('.json-content');
            if (content) {
                content.style.display = 'block';
                toggle.setAttribute('data-expanded', 'true');
                toggle.classList.remove('collapsed');
            }
        });
    }

    // Collapse all nodes
    function collapseAll() {
        const toggles = jsonViewer.querySelectorAll('.expand-toggle');
        toggles.forEach(toggle => {
            const content = toggle.closest('.json-item').querySelector('.json-content');
            if (content) {
                content.style.display = 'none';
                toggle.setAttribute('data-expanded', 'false');
                toggle.classList.add('collapsed');
            }
        });
    }

    // Highlight JSON syntax
    function highlightJson(json) {
        return json
            .replace(/(".*?")\s*:/g, '<span class="json-key">$1</span>:')
            .replace(/:\s*(".*?")/g, ': <span class="json-string">$1</span>')
            .replace(/:\s*(\d+\.?\d*)/g, ': <span class="json-number">$1</span>')
            .replace(/:\s*(true|false)/g, ': <span class="json-boolean">$1</span>')
            .replace(/:\s*(null)/g, ': <span class="json-null">$1</span>');
    }

    // Escape HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Event listeners
    viewJsonBtn.addEventListener('click', function() {
        const input = jsonInput.value.trim();
        if (!input) {
            alert('Please enter JSON data to view.');
            return;
        }

        try {
            currentJsonData = JSON.parse(input);
            renderJsonView(currentJsonData);

            const stats = calculateStats(currentJsonData);
            displayStats(stats);

            showValidationResult(true, 'JSON is valid and has been rendered successfully.');
        } catch (error) {
            showValidationResult(false, 'Invalid JSON: ' + error.message);
            jsonViewer.innerHTML = '<div class="text-muted">Invalid JSON data</div>';
            jsonStats.style.display = 'none';
        }
    });

    validateBtn.addEventListener('click', function() {
        const input = jsonInput.value.trim();
        if (!input) {
            alert('Please enter JSON data to validate.');
            return;
        }

        try {
            JSON.parse(input);
            showValidationResult(true, 'JSON is valid!');
        } catch (error) {
            showValidationResult(false, 'Invalid JSON: ' + error.message);
        }
    });

    expandAllBtn.addEventListener('click', expandAll);
    collapseAllBtn.addEventListener('click', collapseAll);

    viewMode.addEventListener('change', function() {
        if (currentJsonData) {
            renderJsonView(currentJsonData);
        }
    });

    theme.addEventListener('change', function() {
        if (currentJsonData) {
            renderJsonView(currentJsonData);
        }
    });

    copyJsonBtn.addEventListener('click', function() {
        if (!currentJsonData) {
            alert('No JSON data to copy.');
            return;
        }

        const formatted = JSON.stringify(currentJsonData, null, 2);
        navigator.clipboard.writeText(formatted).then(() => {
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-check"></i> Copied!';
            this.classList.replace('btn-outline-secondary', 'btn-success');

            setTimeout(() => {
                this.innerHTML = originalText;
                this.classList.replace('btn-success', 'btn-outline-secondary');
            }, 2000);
        });
    });

    downloadBtn.addEventListener('click', function() {
        if (!currentJsonData) {
            alert('No JSON data to download.');
            return;
        }

        const formatted = JSON.stringify(currentJsonData, null, 2);
        const blob = new Blob([formatted], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'data.json';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    });

    loadSampleBtn.addEventListener('click', function() {
        jsonInput.value = JSON.stringify(sampleJson, null, 2);
        hideValidationResult();
    });

    clearInputBtn.addEventListener('click', function() {
        jsonInput.value = '';
        jsonViewer.innerHTML = '';
        hideValidationResult();
        jsonStats.style.display = 'none';
        currentJsonData = null;
    });

    loadFromFileBtn.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.type === 'application/json') {
            const reader = new FileReader();
            reader.onload = function(e) {
                jsonInput.value = e.target.result;
                hideValidationResult();
            };
            reader.readAsText(file);
        } else {
            alert('Please select a JSON file.');
        }
    });
});
</script>

<style>
.json-viewer {
    background: #fff;
    font-family: 'Courier New', monospace;
    font-size: 0.9em;
    line-height: 1.4;
    max-height: 500px;
    overflow: auto;
}

.json-viewer.json-dark {
    background: #2d3748;
    color: #e2e8f0;
}

.json-item {
    margin: 2px 0;
    padding-left: calc(var(--level, 0) * 20px);
}

.json-key {
    color: #0066cc;
    font-weight: 600;
}

.json-string {
    color: #22863a;
}

.json-number {
    color: #005cc5;
}

.json-boolean {
    color: #d73a49;
    font-weight: 600;
}

.json-null {
    color: #6f42c1;
    font-weight: 600;
}

.json-bracket {
    color: #586069;
    font-weight: bold;
    cursor: pointer;
}

.json-bracket.expand-toggle {
    color: #0366d6;
}

.json-bracket.expand-toggle:hover {
    background: #f1f8ff;
    border-radius: 3px;
}

.json-bracket.collapsed::after {
    content: " ... ";
    color: #6a737d;
}

.json-count {
    color: #6a737d;
    font-size: 0.85em;
    margin-left: 5px;
}

.json-content {
    margin-left: 10px;
}

.json-formatted, .json-raw {
    margin: 0;
    background: transparent;
}

.json-dark .json-key {
    color: #79b8ff;
}

.json-dark .json-string {
    color: #85e89d;
}

.json-dark .json-number {
    color: #79b8ff;
}

.json-dark .json-boolean {
    color: #ffab70;
}

.json-dark .json-null {
    color: #b392f0;
}

.json-dark .json-bracket.expand-toggle:hover {
    background: #444c56;
}
</style>

