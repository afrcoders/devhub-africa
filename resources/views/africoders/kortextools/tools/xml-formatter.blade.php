{{-- xml formatter --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    xml formatter tool for your development and productivity needs.
</div>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header -->
            <div class="text-center mb-4">
                <h1 class="h2 mb-3">
                    <i class="fas fa-code text-primary me-2"></i>
                    XML Formatter & Beautifier
                </h1>
                <p class="text-muted">Format, beautify, and validate XML code with syntax highlighting</p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Options -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Indentation</label>
                            <select class="form-select" id="indentationType">
                                <option value="spaces">Spaces</option>
                                <option value="tabs">Tabs</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Indent Size</label>
                            <select class="form-select" id="indentSize">
                                <option value="2" selected>2</option>
                                <option value="4">4</option>
                                <option value="6">6</option>
                                <option value="8">8</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="validateXML" checked>
                                <label class="form-check-label" for="validateXML">
                                    Validate XML syntax
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Input -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-semibold mb-0">XML Input</label>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-secondary" id="loadSampleBtn">
                                    <i class="fas fa-file-code"></i> Load Sample
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="clearInputBtn">
                                    <i class="fas fa-trash"></i> Clear
                                </button>
                            </div>
                        </div>
                        <textarea class="form-control font-monospace" id="xmlInput" rows="8"
                                  placeholder="Paste your XML code here..."></textarea>
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i>
                            Characters: <span id="inputCount">0</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 mb-3 flex-wrap">
                        <button type="button" class="btn btn-primary" id="formatBtn">
                            <i class="fas fa-magic"></i> Format XML
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="minifyBtn">
                            <i class="fas fa-compress"></i> Minify
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="validateBtn">
                            <i class="fas fa-check-circle"></i> Validate Only
                        </button>
                    </div>

                    <!-- Validation Results -->
                    <div id="validationResult" class="mb-3" style="display: none;">
                        <div class="alert" id="validationAlert">
                            <div id="validationMessage"></div>
                        </div>
                    </div>

                    <!-- Output -->
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-semibold mb-0">Formatted XML</label>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-secondary" id="copyBtn">
                                    <i class="fas fa-copy"></i> Copy
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="downloadBtn">
                                    <i class="fas fa-download"></i> Download
                                </button>
                            </div>
                        </div>
                        <textarea class="form-control font-monospace" id="xmlOutput" rows="8"
                                  readonly placeholder="Formatted XML will appear here..."></textarea>
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i>
                            Characters: <span id="outputCount">0</span> |
                            Size: <span id="outputSize">0 B</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="card mt-4 bg-light border-0">
                <div class="card-body">
                    <h5 class="card-title">XML Formatter Features</h5>
                    <div class="row text-muted small">
                        <div class="col-md-6">
                            <ul class="mb-0">
                                <li>Format and beautify XML code</li>
                                <li>Customizable indentation</li>
                                <li>XML syntax validation</li>
                                <li>Character and size counting</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="mb-0">
                                <li>Minify XML for production</li>
                                <li>Download formatted files</li>
                                <li>Load sample XML data</li>
                                <li>Real-time error detection</li>
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
    const xmlInput = document.getElementById('xmlInput');
    const xmlOutput = document.getElementById('xmlOutput');
    const formatBtn = document.getElementById('formatBtn');
    const minifyBtn = document.getElementById('minifyBtn');
    const validateBtn = document.getElementById('validateBtn');
    const copyBtn = document.getElementById('copyBtn');
    const downloadBtn = document.getElementById('downloadBtn');
    const loadSampleBtn = document.getElementById('loadSampleBtn');
    const clearInputBtn = document.getElementById('clearInputBtn');
    const inputCount = document.getElementById('inputCount');
    const outputCount = document.getElementById('outputCount');
    const outputSize = document.getElementById('outputSize');
    const validationResult = document.getElementById('validationResult');
    const validationAlert = document.getElementById('validationAlert');
    const validationMessage = document.getElementById('validationMessage');

    // Sample XML data
    const sampleXML = `<?xml version="1.0" encoding="UTF-8"?>
<bookstore>
<book id="1">
<title>The Great Gatsby</title>
<author>F. Scott Fitzgerald</author>
<year>1925</year>
<price currency="USD">12.99</price>
</book>
<book id="2">
<title>To Kill a Mockingbird</title>
<author>Harper Lee</author>
<year>1960</year>
<price currency="USD">14.99</price>
</book>
</bookstore>`;

    // Update character counts
    function updateCounts() {
        const input = xmlInput.value;
        const output = xmlOutput.value;

        inputCount.textContent = input.length.toLocaleString();
        outputCount.textContent = output.length.toLocaleString();
        outputSize.textContent = formatBytes(new Blob([output]).size);
    }

    // Format bytes
    function formatBytes(bytes) {
        if (bytes === 0) return '0 B';
        const k = 1024;
        const sizes = ['B', 'KB', 'MB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
    }

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

    // Parse and validate XML
    function parseXML(xmlString) {
        try {
            const parser = new DOMParser();
            const xmlDoc = parser.parseFromString(xmlString, 'text/xml');

            const parserError = xmlDoc.getElementsByTagName('parsererror');
            if (parserError.length > 0) {
                throw new Error(parserError[0].textContent);
            }

            return { isValid: true, document: xmlDoc };
        } catch (error) {
            return { isValid: false, error: error.message };
        }
    }

    // Format XML
    function formatXML(xmlString) {
        try {
            const indentType = document.getElementById('indentationType').value;
            const indentSize = parseInt(document.getElementById('indentSize').value);
            const indent = indentType === 'tabs' ? '\t' : ' '.repeat(indentSize);

            const parser = new DOMParser();
            const xmlDoc = parser.parseFromString(xmlString, 'text/xml');

            const parserError = xmlDoc.getElementsByTagName('parsererror');
            if (parserError.length > 0) {
                throw new Error(parserError[0].textContent);
            }

            return formatNode(xmlDoc, '', indent);
        } catch (error) {
            throw error;
        }
    }

    // Format XML node recursively
    function formatNode(node, currentIndent, indent) {
        const nextIndent = currentIndent + indent;
        let result = '';

        if (node.nodeType === Node.ELEMENT_NODE) {
            result += currentIndent + '<' + node.nodeName;

            // Add attributes
            if (node.attributes && node.attributes.length > 0) {
                for (let i = 0; i < node.attributes.length; i++) {
                    const attr = node.attributes[i];
                    result += ' ' + attr.nodeName + '="' + attr.nodeValue + '"';
                }
            }

            if (node.childNodes.length === 0) {
                result += '/>\n';
            } else {
                result += '>\n';

                let hasElementChildren = false;
                for (let i = 0; i < node.childNodes.length; i++) {
                    const child = node.childNodes[i];
                    if (child.nodeType === Node.ELEMENT_NODE) {
                        hasElementChildren = true;
                        result += formatNode(child, nextIndent, indent);
                    } else if (child.nodeType === Node.TEXT_NODE && child.nodeValue.trim()) {
                        if (!hasElementChildren) {
                            result = result.slice(0, -1) + child.nodeValue.trim() + '\n';
                        } else {
                            result += nextIndent + child.nodeValue.trim() + '\n';
                        }
                    }
                }

                result += currentIndent + '</' + node.nodeName + '>\n';
            }
        } else if (node.nodeType === Node.DOCUMENT_NODE) {
            // Handle document node
            let declaration = '<?xml version="1.0" encoding="UTF-8"?>\n';
            for (let i = 0; i < node.childNodes.length; i++) {
                const child = node.childNodes[i];
                if (child.nodeType === Node.PROCESSING_INSTRUCTION_NODE && child.nodeName === 'xml') {
                    // Skip, we'll add our own declaration
                } else {
                    result += formatNode(child, currentIndent, indent);
                }
            }
            result = declaration + result;
        }

        return result;
    }

    // Minify XML
    function minifyXML(xmlString) {
        return xmlString.replace(/>\s+</g, '><').replace(/^\s+|\s+$/gm, '').replace(/\n/g, '');
    }

    // Event listeners
    xmlInput.addEventListener('input', updateCounts);
    xmlOutput.addEventListener('input', updateCounts);

    formatBtn.addEventListener('click', function() {
        const input = xmlInput.value.trim();
        if (!input) {
            alert('Please enter XML code to format.');
            return;
        }

        try {
            const formatted = formatXML(input);
            xmlOutput.value = formatted;
            hideValidationResult();

            if (document.getElementById('validateXML').checked) {
                showValidationResult(true, 'XML is valid and has been formatted successfully.');
            }
        } catch (error) {
            showValidationResult(false, 'XML formatting failed: ' + error.message);
            xmlOutput.value = '';
        }

        updateCounts();
    });

    minifyBtn.addEventListener('click', function() {
        const input = xmlInput.value.trim();
        if (!input) {
            alert('Please enter XML code to minify.');
            return;
        }

        try {
            const parseResult = parseXML(input);
            if (!parseResult.isValid) {
                throw new Error(parseResult.error);
            }

            const minified = minifyXML(input);
            xmlOutput.value = minified;
            showValidationResult(true, 'XML has been minified successfully.');
        } catch (error) {
            showValidationResult(false, 'XML minification failed: ' + error.message);
            xmlOutput.value = '';
        }

        updateCounts();
    });

    validateBtn.addEventListener('click', function() {
        const input = xmlInput.value.trim();
        if (!input) {
            alert('Please enter XML code to validate.');
            return;
        }

        const parseResult = parseXML(input);
        if (parseResult.isValid) {
            showValidationResult(true, 'XML is valid!');
        } else {
            showValidationResult(false, 'XML is invalid: ' + parseResult.error);
        }
    });

    copyBtn.addEventListener('click', function() {
        if (!xmlOutput.value) {
            alert('No formatted XML to copy.');
            return;
        }

        xmlOutput.select();
        document.execCommand('copy');

        const originalText = this.innerHTML;
        this.innerHTML = '<i class="fas fa-check"></i> Copied!';
        this.classList.replace('btn-outline-secondary', 'btn-success');

        setTimeout(() => {
            this.innerHTML = originalText;
            this.classList.replace('btn-success', 'btn-outline-secondary');
        }, 2000);
    });

    downloadBtn.addEventListener('click', function() {
        if (!xmlOutput.value) {
            alert('No formatted XML to download.');
            return;
        }

        const blob = new Blob([xmlOutput.value], { type: 'application/xml' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'formatted.xml';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    });

    loadSampleBtn.addEventListener('click', function() {
        xmlInput.value = sampleXML;
        updateCounts();
        hideValidationResult();
    });

    clearInputBtn.addEventListener('click', function() {
        xmlInput.value = '';
        xmlOutput.value = '';
        updateCounts();
        hideValidationResult();
    });

    // Initial setup
    updateCounts();
});
</script>

<style>
.font-monospace {
    font-family: 'Courier New', monospace;
    font-size: 0.95em;
}

textarea.font-monospace {
    line-height: 1.4;
}

.btn-group .btn {
    border-radius: 0.375rem;
}

.btn-group .btn:not(:last-child) {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.btn-group .btn:not(:first-child) {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    border-left: 0;
}
</style>

