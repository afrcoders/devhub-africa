{{-- XML to JSON Converter --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    XML to JSON Converter for transforming data between XML and JSON formats.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-exchange-alt me-3"></i>XML ⇄ JSON Converter
                </h1>
                <p class="lead text-muted">
                    Convert between XML and JSON formats with ease
                </p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-code me-2"></i>Format Converter</h5>
                        <div class="btn-group btn-group-sm" role="group">
                            <input type="radio" class="btn-check" name="conversionMode" id="xmlToJson" value="xml-to-json" checked>
                            <label class="btn btn-outline-light" for="xmlToJson">XML → JSON</label>

                            <input type="radio" class="btn-check" name="conversionMode" id="jsonToXml" value="json-to-xml">
                            <label class="btn btn-outline-light" for="jsonToXml">JSON → XML</label>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="inputData" class="form-label fw-semibold">
                                <i class="fas fa-file-code me-2"></i><span id="inputLabel">Input XML</span>
                            </label>
                            <textarea class="form-control font-monospace" id="inputData" rows="20"
                                placeholder="Paste your XML here..."></textarea>
                            <div class="mt-2">
                                <button type="button" id="convertBtn" class="btn btn-primary">
                                    <i class="fas fa-magic me-2"></i>Convert
                                </button>
                                <button type="button" id="clearBtn" class="btn btn-outline-secondary ms-2">
                                    <i class="fas fa-trash-alt me-2"></i>Clear
                                </button>
                                <button type="button" id="loadSampleBtn" class="btn btn-outline-info ms-2">
                                    <i class="fas fa-play me-2"></i>Load Sample
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="outputData" class="form-label fw-semibold">
                                <i class="fas fa-check-circle me-2 text-success"></i><span id="outputLabel">Output JSON</span>
                            </label>
                            <textarea class="form-control font-monospace" id="outputData" rows="20" readonly></textarea>
                            <div class="mt-2">
                                <button type="button" id="copyBtn" class="btn btn-outline-primary">
                                    <i class="fas fa-copy me-2"></i>Copy Result
                                </button>
                                <button type="button" id="downloadBtn" class="btn btn-outline-secondary ms-2">
                                    <i class="fas fa-download me-2"></i>Download
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="validationStatus" class="mt-3"></div>
                </div>
            </div>

            {{-- Options Panel --}}
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Conversion Options</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="prettyPrint" checked>
                                <label class="form-check-label" for="prettyPrint">
                                    Pretty print output
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="includeAttributes">
                                <label class="form-check-label" for="includeAttributes">
                                    Include XML attributes
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="arrayWrap">
                                <label class="form-check-label" for="arrayWrap">
                                    Wrap single items in arrays
                                </label>
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
    const inputData = document.getElementById('inputData');
    const outputData = document.getElementById('outputData');
    const validationStatus = document.getElementById('validationStatus');
    const inputLabel = document.getElementById('inputLabel');
    const outputLabel = document.getElementById('outputLabel');
    const prettyPrint = document.getElementById('prettyPrint');
    const includeAttributes = document.getElementById('includeAttributes');
    const arrayWrap = document.getElementById('arrayWrap');
    const convertBtn = document.getElementById('convertBtn');
    const clearBtn = document.getElementById('clearBtn');
    const copyBtn = document.getElementById('copyBtn');
    const downloadBtn = document.getElementById('downloadBtn');
    const loadSampleBtn = document.getElementById('loadSampleBtn');
    const xmlToJsonRadio = document.getElementById('xmlToJson');
    const jsonToXmlRadio = document.getElementById('jsonToXml');

    function showStatus(isSuccess, message) {
        const alertClass = isSuccess ? 'alert-success' : 'alert-danger';
        const icon = isSuccess ? 'fa-check-circle' : 'fa-exclamation-circle';

        validationStatus.innerHTML = `
            <div class="alert ${alertClass} mb-0">
                <i class="fas ${icon} me-2"></i>${message}
            </div>
        `;
    }

    function updateLabels() {
        if (xmlToJsonRadio.checked) {
            inputLabel.textContent = 'Input XML';
            outputLabel.textContent = 'Output JSON';
            inputData.placeholder = 'Paste your XML here...';
        } else {
            inputLabel.textContent = 'Input JSON';
            outputLabel.textContent = 'Output XML';
            inputData.placeholder = 'Paste your JSON here...';
        }
        outputData.value = '';
        validationStatus.innerHTML = '';
    }

    function xmlToJson(xmlString) {
        try {
            const parser = new DOMParser();
            const xmlDoc = parser.parseFromString(xmlString, 'application/xml');

            // Check for parsing errors
            const parseError = xmlDoc.getElementsByTagName('parsererror');
            if (parseError.length > 0) {
                throw new Error('Invalid XML format');
            }

            function xmlNodeToJson(node) {
                const obj = {};

                // Handle attributes
                if (includeAttributes.checked && node.attributes && node.attributes.length > 0) {
                    obj['@attributes'] = {};
                    for (let i = 0; i < node.attributes.length; i++) {
                        const attr = node.attributes[i];
                        obj['@attributes'][attr.name] = attr.value;
                    }
                }

                // Handle child nodes
                if (node.childNodes && node.childNodes.length > 0) {
                    for (let i = 0; i < node.childNodes.length; i++) {
                        const child = node.childNodes[i];

                        if (child.nodeType === 3) { // Text node
                            const text = child.nodeValue.trim();
                            if (text) {
                                if (Object.keys(obj).length === 0) {
                                    return text;
                                } else {
                                    obj['#text'] = text;
                                }
                            }
                        } else if (child.nodeType === 1) { // Element node
                            const childName = child.nodeName;
                            const childValue = xmlNodeToJson(child);

                            if (obj[childName]) {
                                if (!Array.isArray(obj[childName])) {
                                    obj[childName] = [obj[childName]];
                                }
                                obj[childName].push(childValue);
                            } else {
                                obj[childName] = arrayWrap.checked ? [childValue] : childValue;
                            }
                        }
                    }
                }

                return obj;
            }

            const result = xmlNodeToJson(xmlDoc.documentElement);
            const finalResult = {};
            finalResult[xmlDoc.documentElement.nodeName] = result;

            return JSON.stringify(finalResult, null, prettyPrint.checked ? 2 : 0);
        } catch (error) {
            throw new Error(`XML parsing error: ${error.message}`);
        }
    }

    function jsonToXml(jsonString) {
        try {
            const jsonObj = JSON.parse(jsonString);

            function jsonToXmlString(obj, rootName = 'root') {
                let xml = '';

                if (typeof obj === 'object' && obj !== null) {
                    if (Array.isArray(obj)) {
                        obj.forEach(item => {
                            xml += `<${rootName}>${jsonToXmlString(item)}</${rootName}>`;
                        });
                    } else {
                        for (const [key, value] of Object.entries(obj)) {
                            if (key === '@attributes') {
                                // Handle attributes (skip for now in simple conversion)
                                continue;
                            } else if (key === '#text') {
                                xml += value;
                            } else if (Array.isArray(value)) {
                                value.forEach(item => {
                                    xml += `<${key}>${jsonToXmlString(item)}</${key}>`;
                                });
                            } else {
                                xml += `<${key}>${jsonToXmlString(value)}</${key}>`;
                            }
                        }
                    }
                } else {
                    xml = obj;
                }

                return xml;
            }

            // Get root element name
            const rootKeys = Object.keys(jsonObj);
            let xmlResult = '<?xml version="1.0" encoding="UTF-8"?>\n';

            if (rootKeys.length === 1) {
                const rootKey = rootKeys[0];
                xmlResult += `<${rootKey}>${jsonToXmlString(jsonObj[rootKey])}</${rootKey}>`;
            } else {
                xmlResult += `<root>${jsonToXmlString(jsonObj)}</root>`;
            }

            // Pretty print XML
            if (prettyPrint.checked) {
                return formatXml(xmlResult);
            }

            return xmlResult;
        } catch (error) {
            throw new Error(`JSON parsing error: ${error.message}`);
        }
    }

    function formatXml(xml) {
        const PADDING = '  ';
        const reg = /(>)(<)(\/*)/g;
        let formatted = xml.replace(reg, '$1\r\n$2$3');

        let pad = 0;
        return formatted.split('\r\n').map(line => {
            let indent = 0;
            if (line.match(/.+<\/\w[^>]*>$/)) {
                indent = 0;
            } else if (line.match(/^<\/\w/) && pad > 0) {
                pad -= 1;
            } else if (line.match(/^<\w[^>]*[^/]>.*$/)) {
                indent = 1;
            }

            const padding = PADDING.repeat(pad);
            pad += indent;
            return padding + line;
        }).join('\n');
    }

    function convert() {
        const input = inputData.value.trim();
        if (!input) {
            showStatus(false, 'Please enter some data to convert.');
            return;
        }

        try {
            if (xmlToJsonRadio.checked) {
                const result = xmlToJson(input);
                outputData.value = result;
                showStatus(true, 'XML successfully converted to JSON!');
            } else {
                const result = jsonToXml(input);
                outputData.value = result;
                showStatus(true, 'JSON successfully converted to XML!');
            }
        } catch (error) {
            showStatus(false, error.message);
            outputData.value = '';
        }
    }

    function clearAll() {
        inputData.value = '';
        outputData.value = '';
        validationStatus.innerHTML = '';
    }

    function copyResult() {
        if (!outputData.value) {
            alert('No converted data to copy.');
            return;
        }

        outputData.select();
        document.execCommand('copy');

        const originalText = copyBtn.innerHTML;
        copyBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
        copyBtn.classList.replace('btn-outline-primary', 'btn-success');

        setTimeout(() => {
            copyBtn.innerHTML = originalText;
            copyBtn.classList.replace('btn-success', 'btn-outline-primary');
        }, 2000);
    }

    function downloadResult() {
        if (!outputData.value) {
            alert('No converted data to download.');
            return;
        }

        const extension = xmlToJsonRadio.checked ? 'json' : 'xml';
        const mimeType = xmlToJsonRadio.checked ? 'application/json' : 'application/xml';

        const blob = new Blob([outputData.value], { type: mimeType });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `converted.${extension}`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }

    function loadSample() {
        if (xmlToJsonRadio.checked) {
            const sampleXml = `<?xml version="1.0" encoding="UTF-8"?>
<library>
    <book id="1" category="fiction">
        <title>To Kill a Mockingbird</title>
        <author>Harper Lee</author>
        <year>1960</year>
        <price currency="USD">12.99</price>
    </book>
    <book id="2" category="science">
        <title>A Brief History of Time</title>
        <author>Stephen Hawking</author>
        <year>1988</year>
        <price currency="USD">15.99</price>
    </book>
</library>`;
            inputData.value = sampleXml;
        } else {
            const sampleJson = {
                "library": {
                    "book": [
                        {
                            "id": "1",
                            "category": "fiction",
                            "title": "To Kill a Mockingbird",
                            "author": "Harper Lee",
                            "year": "1960",
                            "price": "12.99"
                        },
                        {
                            "id": "2",
                            "category": "science",
                            "title": "A Brief History of Time",
                            "author": "Stephen Hawking",
                            "year": "1988",
                            "price": "15.99"
                        }
                    ]
                }
            };
            inputData.value = JSON.stringify(sampleJson, null, 2);
        }
        convert();
    }

    // Event listeners
    convertBtn.addEventListener('click', convert);
    clearBtn.addEventListener('click', clearAll);
    copyBtn.addEventListener('click', copyResult);
    downloadBtn.addEventListener('click', downloadResult);
    loadSampleBtn.addEventListener('click', loadSample);

    xmlToJsonRadio.addEventListener('change', updateLabels);
    jsonToXmlRadio.addEventListener('change', updateLabels);

    // Auto-convert on input
    inputData.addEventListener('input', function() {
        if (inputData.value.trim()) {
            convert();
        } else {
            validationStatus.innerHTML = '';
            outputData.value = '';
        }
    });

    // Re-convert when options change
    [prettyPrint, includeAttributes, arrayWrap].forEach(element => {
        element.addEventListener('change', function() {
            if (inputData.value.trim()) {
                convert();
            }
        });
    });
});
</script>
