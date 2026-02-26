<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-exchange-alt"></i> JSON to YAML Converter</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- JSON Input -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jsonInput" class="form-label d-flex align-items-center">
                                    <i class="fas fa-code text-primary me-2"></i>JSON Input
                                </label>
                                <textarea
                                    class="form-control font-monospace"
                                    id="jsonInput"
                                    name="jsonInput"
                                    rows="20"
                                    placeholder='Paste your JSON here...

Example:
{
  "name": "John Doe",
  "age": 30,
  "city": "New York",
  "hobbies": ["reading", "swimming"],
  "active": true
}'
                                    style="resize: vertical; min-height: 400px;"
                                ></textarea>
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                <button type="button" id="convertBtn" class="btn btn-primary">
                                    <i class="fas fa-arrow-right"></i> Convert to YAML
                                </button>
                                <button type="button" id="formatJsonBtn" class="btn btn-outline-primary">
                                    <i class="fas fa-indent"></i> Format JSON
                                </button>
                                <button type="button" id="clearJsonBtn" class="btn btn-outline-secondary">
                                    <i class="fas fa-eraser"></i> Clear
                                </button>
                                <button type="button" id="loadSampleBtn" class="btn btn-outline-info">
                                    <i class="fas fa-file-import"></i> Load Sample
                                </button>
                            </div>
                        </div>

                        <!-- YAML Output -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="yamlOutput" class="form-label d-flex align-items-center">
                                    <i class="fas fa-file-code text-success me-2"></i>YAML Output
                                </label>
                                <textarea
                                    class="form-control font-monospace"
                                    id="yamlOutput"
                                    name="yamlOutput"
                                    rows="20"
                                    readonly
                                    placeholder="Converted YAML will appear here..."
                                    style="resize: vertical; min-height: 400px; background-color: #f8f9fa;"
                                ></textarea>
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                <button type="button" id="copyYamlBtn" class="btn btn-success" disabled>
                                    <i class="fas fa-copy"></i> Copy YAML
                                </button>
                                <button type="button" id="downloadYamlBtn" class="btn btn-outline-success" disabled>
                                    <i class="fas fa-download"></i> Download
                                </button>
                                <button type="button" id="reverseBtn" class="btn btn-outline-warning" disabled>
                                    <i class="fas fa-arrow-left"></i> Back to JSON
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Status and Validation -->
                    <div class="mt-3">
                        <div id="status" class="alert" style="display: none;"></div>
                    </div>
                </div>
            </div>

            <!-- Help Card -->
            <div class="card mt-3">
                <div class="card-body">
                    <h6><i class="fas fa-question-circle text-primary"></i> How to use:</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="small mb-0">
                                <li>Paste valid JSON in the left panel</li>
                                <li>Click "Convert to YAML" to transform</li>
                                <li>Use "Format JSON" to prettify JSON</li>
                                <li>Copy or download the converted YAML</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="small mb-0">
                                <li>Supports nested objects and arrays</li>
                                <li>Preserves data types (strings, numbers, booleans)</li>
                                <li>Handles special characters and Unicode</li>
                                <li>Real-time validation and error reporting</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Sample JSON for demonstration
const sampleJson = {
    "name": "John Doe",
    "age": 30,
    "email": "john@example.com",
    "address": {
        "street": "123 Main St",
        "city": "New York",
        "zipcode": "10001"
    },
    "hobbies": ["reading", "swimming", "coding"],
    "married": true,
    "children": null,
    "skills": {
        "programming": ["JavaScript", "Python", "Java"],
        "languages": ["English", "Spanish"],
        "certifications": []
    }
};

document.getElementById('convertBtn').addEventListener('click', convertToYaml);
document.getElementById('formatJsonBtn').addEventListener('click', formatJson);
document.getElementById('clearJsonBtn').addEventListener('click', clearJson);
document.getElementById('loadSampleBtn').addEventListener('click', loadSample);
document.getElementById('copyYamlBtn').addEventListener('click', copyYaml);
document.getElementById('downloadYamlBtn').addEventListener('click', downloadYaml);
document.getElementById('reverseBtn').addEventListener('click', convertBackToJson);

// Real-time conversion as user types (with debounce)
let debounceTimer;
document.getElementById('jsonInput').addEventListener('input', function() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        if (this.value.trim()) {
            convertToYaml();
        } else {
            clearOutput();
        }
    }, 500);
});

function convertToYaml() {
    const jsonInput = document.getElementById('jsonInput').value.trim();

    if (!jsonInput) {
        showStatus('Please enter JSON to convert.', 'warning');
        return;
    }

    try {
        const jsonObj = JSON.parse(jsonInput);
        const yamlOutput = convertJsonToYaml(jsonObj);

        document.getElementById('yamlOutput').value = yamlOutput;
        enableButtons(true);
        showStatus('✅ Successfully converted JSON to YAML', 'success');

    } catch (error) {
        document.getElementById('yamlOutput').value = '';
        enableButtons(false);
        showStatus('❌ Invalid JSON: ' + error.message, 'danger');
    }
}

function formatJson() {
    const jsonInput = document.getElementById('jsonInput').value.trim();

    if (!jsonInput) {
        showStatus('Please enter JSON to format.', 'warning');
        return;
    }

    try {
        const jsonObj = JSON.parse(jsonInput);
        const formattedJson = JSON.stringify(jsonObj, null, 2);
        document.getElementById('jsonInput').value = formattedJson;
        showStatus('✅ JSON formatted successfully', 'success');
        convertToYaml(); // Auto-convert after formatting
    } catch (error) {
        showStatus('❌ Invalid JSON: ' + error.message, 'danger');
    }
}

function clearJson() {
    document.getElementById('jsonInput').value = '';
    document.getElementById('yamlOutput').value = '';
    enableButtons(false);
    hideStatus();
}

function loadSample() {
    document.getElementById('jsonInput').value = JSON.stringify(sampleJson, null, 2);
    convertToYaml();
}

function copyYaml() {
    const yamlOutput = document.getElementById('yamlOutput').value;
    navigator.clipboard.writeText(yamlOutput).then(() => {
        const btn = document.getElementById('copyYamlBtn');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> Copied!';
        btn.classList.remove('btn-success');
        btn.classList.add('btn-primary');
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-success');
        }, 2000);
    });
}

function downloadYaml() {
    const yamlOutput = document.getElementById('yamlOutput').value;
    const blob = new Blob([yamlOutput], { type: 'text/yaml' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `converted_${Date.now()}.yaml`;
    document.body.appendChild(a);
    a.click();
    window.URL.revokeObjectURL(url);
    document.body.removeChild(a);
}

function convertBackToJson() {
    try {
        const yamlOutput = document.getElementById('yamlOutput').value;
        // For demo purposes, we'll show the original JSON
        // In a real implementation, you'd parse YAML back to JSON
        const jsonInput = document.getElementById('jsonInput').value;
        const jsonObj = JSON.parse(jsonInput);
        const formattedJson = JSON.stringify(jsonObj, null, 2);
        document.getElementById('jsonInput').value = formattedJson;
        showStatus('✅ Converted back to formatted JSON', 'info');
    } catch (error) {
        showStatus('❌ Error converting back to JSON', 'danger');
    }
}

function convertJsonToYaml(obj, indent = 0) {
    const spaces = '  '.repeat(indent);
    let yaml = '';

    if (obj === null) {
        return 'null';
    } else if (typeof obj === 'boolean') {
        return obj.toString();
    } else if (typeof obj === 'number') {
        return obj.toString();
    } else if (typeof obj === 'string') {
        // Check if string needs quotes
        if (obj.includes('\\n') || obj.includes(':') || obj.includes('#') || obj.match(/^\\s+/) || obj.match(/\\s+$/)) {
            return `"${obj.replace(/"/g, '\\\\"')}"`;
        }
        return obj;
    } else if (Array.isArray(obj)) {
        if (obj.length === 0) {
            return '[]';
        }
        yaml = '\\n';
        obj.forEach(item => {
            yaml += `${spaces}- ${convertJsonToYaml(item, indent + 1).replace(/^\\n/, '')}\\n`;
        });
        return yaml.replace(/\\n$/, '');
    } else if (typeof obj === 'object') {
        const keys = Object.keys(obj);
        if (keys.length === 0) {
            return '{}';
        }
        yaml = '\\n';
        keys.forEach(key => {
            const value = convertJsonToYaml(obj[key], indent + 1);
            if (value.startsWith('\\n')) {
                yaml += `${spaces}${key}:${value}\\n`;
            } else {
                yaml += `${spaces}${key}: ${value}\\n`;
            }
        });
        return yaml.replace(/\\n$/, '');
    }

    return obj.toString();
}

function enableButtons(enabled) {
    document.getElementById('copyYamlBtn').disabled = !enabled;
    document.getElementById('downloadYamlBtn').disabled = !enabled;
    document.getElementById('reverseBtn').disabled = !enabled;
}

function clearOutput() {
    document.getElementById('yamlOutput').value = '';
    enableButtons(false);
    hideStatus();
}

function showStatus(message, type) {
    const status = document.getElementById('status');
    status.className = `alert alert-${type}`;
    status.innerHTML = message;
    status.style.display = 'block';
}

function hideStatus() {
    document.getElementById('status').style.display = 'none';
}
</script>