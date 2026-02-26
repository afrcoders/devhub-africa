{{-- Text Case Converter --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-font me-2"></i>
    Convert text between different cases: uppercase, lowercase, title case, and more.
</div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-font me-2"></i>
                        {{ $tool->name }}
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">{{ $tool->description }}</p>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="inputText" class="form-label">Input Text</label>
                                <textarea class="form-control" id="inputText" rows="6"
                                    placeholder="Enter text to convert case..."></textarea>
                                <div class="form-text">Enter any text to convert to different cases</div>
                            </div>

                            <div class="mb-3">
                                <label for="caseType" class="form-label">Case Conversion Type</label>
                                <select class="form-select" id="caseType">
                                    <option value="upper">UPPERCASE</option>
                                    <option value="lower">lowercase</option>
                                    <option value="title">Title Case</option>
                                    <option value="sentence">Sentence case</option>
                                    <option value="camel">camelCase</option>
                                    <option value="pascal">PascalCase</option>
                                    <option value="snake">snake_case</option>
                                    <option value="kebab">kebab-case</option>
                                    <option value="constant">CONSTANT_CASE</option>
                                    <option value="dot">dot.case</option>
                                    <option value="path">path/case</option>
                                    <option value="toggle">tOgGlE cAsE</option>
                                    <option value="inverse">iNVERSE cASE</option>
                                </select>
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button type="button" class="btn btn-primary" id="convertBtn">
                                    <i class="fas fa-exchange-alt me-2"></i>Convert Case
                                </button>
                            </div>

                            <div class="mb-3">
                                <label for="outputText" class="form-label">Converted Text</label>
                                <textarea class="form-control" id="outputText" rows="6" readonly
                                    placeholder="Converted text will appear here..."></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-secondary w-100" id="copyBtn">
                                        <i class="fas fa-copy me-2"></i>Copy
                                    </button>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-success w-100" id="downloadBtn">
                                        <i class="fas fa-download me-2"></i>Download
                                    </button>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-info w-100" id="previewAllBtn">
                                        <i class="fas fa-eye me-2"></i>Preview All
                                    </button>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-warning w-100" id="clearBtn">
                                        <i class="fas fa-trash me-2"></i>Clear
                                    </button>
                                </div>
                            </div>

                            <div class="mt-3" id="previewSection" style="display: none;">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">All Case Previews</h6>
                                    </div>
                                    <div class="card-body" id="previewContent">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const inputText = document.getElementById('inputText');
const outputText = document.getElementById('outputText');
const caseType = document.getElementById('caseType');
const convertBtn = document.getElementById('convertBtn');
const copyBtn = document.getElementById('copyBtn');
const downloadBtn = document.getElementById('downloadBtn');
const previewAllBtn = document.getElementById('previewAllBtn');
const clearBtn = document.getElementById('clearBtn');
const previewSection = document.getElementById('previewSection');
const previewContent = document.getElementById('previewContent');

// Case conversion functions
function convertCase(text, type) {
    switch(type) {
        case 'upper':
            return text.toUpperCase();

        case 'lower':
            return text.toLowerCase();

        case 'title':
            return text.replace(/\w\S*/g, (txt) =>
                txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()
            );

        case 'sentence':
            return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();

        case 'camel':
            return text.replace(/(?:^\w|[A-Z]|\b\w)/g, (word, index) => {
                return index === 0 ? word.toLowerCase() : word.toUpperCase();
            }).replace(/\s+/g, '');

        case 'pascal':
            return text.replace(/(?:^\w|[A-Z]|\b\w)/g, (word) => {
                return word.toUpperCase();
            }).replace(/\s+/g, '');

        case 'snake':
            return text.toLowerCase().replace(/\s+/g, '_').replace(/[^\w_]/g, '');

        case 'kebab':
            return text.toLowerCase().replace(/\s+/g, '-').replace(/[^\w-]/g, '');

        case 'constant':
            return text.toUpperCase().replace(/\s+/g, '_').replace(/[^\w_]/g, '');

        case 'dot':
            return text.toLowerCase().replace(/\s+/g, '.').replace(/[^\w.]/g, '');

        case 'path':
            return text.toLowerCase().replace(/\s+/g, '/').replace(/[^\w/]/g, '');

        case 'toggle':
            return text.split('').map((char, index) =>
                index % 2 === 0 ? char.toLowerCase() : char.toUpperCase()
            ).join('');

        case 'inverse':
            return text.split('').map(char =>
                char === char.toUpperCase() ? char.toLowerCase() : char.toUpperCase()
            ).join('');

        default:
            return text;
    }
}

// Convert button click
convertBtn.addEventListener('click', function() {
    const text = inputText.value;

    if (!text.trim()) {
        alert('Please enter some text to convert.');
        return;
    }

    const converted = convertCase(text, caseType.value);
    outputText.value = converted;
});

// Auto-convert on input change
inputText.addEventListener('input', function() {
    if (this.value.trim()) {
        convertBtn.click();
    } else {
        outputText.value = '';
    }
});

caseType.addEventListener('change', function() {
    if (inputText.value.trim()) {
        convertBtn.click();
    }
});

// Preview all cases
previewAllBtn.addEventListener('click', function() {
    const text = inputText.value.trim();

    if (!text) {
        alert('Please enter some text first.');
        return;
    }

    const cases = [
        { name: 'UPPERCASE', value: 'upper' },
        { name: 'lowercase', value: 'lower' },
        { name: 'Title Case', value: 'title' },
        { name: 'Sentence case', value: 'sentence' },
        { name: 'camelCase', value: 'camel' },
        { name: 'PascalCase', value: 'pascal' },
        { name: 'snake_case', value: 'snake' },
        { name: 'kebab-case', value: 'kebab' },
        { name: 'CONSTANT_CASE', value: 'constant' },
        { name: 'dot.case', value: 'dot' },
        { name: 'path/case', value: 'path' },
        { name: 'tOgGlE cAsE', value: 'toggle' },
        { name: 'iNVERSE cASE', value: 'inverse' }
    ];

    let html = '<div class="row">';
    cases.forEach(caseOption => {
        const converted = convertCase(text, caseOption.value);
        html += `
            <div class="col-md-6 mb-3">
                <div class="border rounded p-2">
                    <strong>${caseOption.name}:</strong><br>
                    <code class="text-break">${converted}</code>
                    <button class="btn btn-sm btn-outline-primary ms-2" onclick="copyToClipboard('${converted.replace(/'/g, "\\'")}')">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            </div>
        `;
    });
    html += '</div>';

    previewContent.innerHTML = html;
    previewSection.style.display = 'block';
});

// Copy specific text to clipboard
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Visual feedback could be added here
    });
}

// Copy to clipboard
copyBtn.addEventListener('click', function() {
    if (!outputText.value) {
        alert('Nothing to copy. Please convert some text first.');
        return;
    }

    outputText.select();
    navigator.clipboard.writeText(outputText.value).then(function() {
        const originalText = copyBtn.innerHTML;
        copyBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
        setTimeout(function() {
            copyBtn.innerHTML = originalText;
        }, 2000);
    });
});

// Download as text file
downloadBtn.addEventListener('click', function() {
    if (!outputText.value) {
        alert('Nothing to download. Please convert some text first.');
        return;
    }

    const blob = new Blob([outputText.value], { type: 'text/plain' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'case-converted-text.txt';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
});

// Clear all
clearBtn.addEventListener('click', function() {
    inputText.value = '';
    outputText.value = '';
    previewSection.style.display = 'none';
    caseType.value = 'upper';
    inputText.focus();
});
</script>
