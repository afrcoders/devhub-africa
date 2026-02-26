{{-- ASCII to Binary Converter Tool --}}

<div class="alert alert-info mb-4">
    <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>About ASCII to Binary Conversion</h6>
    <p class="mb-0">This tool converts ASCII text to binary code representation. Each ASCII character is converted to its 8-bit binary representation. For example, 'A' (ASCII 65) becomes 01000001.</p>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="mb-4">
            <label for="ascii-input" class="form-label">ASCII Text to Convert:</label>
            <textarea
                class="form-control"
                id="ascii-input"
                rows="5"
                placeholder="Enter ASCII text to convert to binary..."
                style="font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;"
            ></textarea>
            <div class="form-text">
                <i class="fas fa-info-circle me-1"></i>
                Enter any ASCII text. Special characters and spaces are supported.
            </div>
        </div>

        <div class="mb-4">
            <button type="button" class="btn btn-primary btn-lg" id="convert-btn">
                <i class="fas fa-exchange-alt me-2"></i>Convert to Binary
            </button>
            <button type="button" class="btn btn-outline-secondary ms-2" id="clear-btn">
                <i class="fas fa-broom me-2"></i>Clear
            </button>
        </div>
    </div>
</div>

<div class="row" id="results-section" style="display: none;">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-binary me-2"></i>Binary Output
                </h5>
            </div>
            <div class="card-body">
                <div id="binary-results">
                    <!-- Binary results will be populated here -->
                </div>

                <div class="d-flex flex-wrap gap-2 mt-3" id="action-buttons" style="display: none;">
                    <button type="button" id="copy-btn" class="btn btn-success">
                        <i class="fas fa-copy me-2"></i>Copy Result
                    </button>
                    <button type="button" id="download-btn" class="btn btn-outline-primary">
                        <i class="fas fa-download me-2"></i>Download as TXT
                    </button>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-title text-primary">
                            <i class="fas fa-info-circle me-2"></i>How it Works
                        </h6>
                        <p class="card-text">
                            Each ASCII character is converted to its 8-bit binary representation using the ASCII character code.
                        </p>
                        <ul class="small">
                            <li>'A' (ASCII 65) → 01000001</li>
                            <li>'B' (ASCII 66) → 01000010</li>
                            <li>' ' (space, ASCII 32) → 00100000</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-title text-primary">
                            <i class="fas fa-lightbulb me-2"></i>Use Cases
                        </h6>
                        <ul class="mb-0">
                            <li>Programming and computer science education</li>
                            <li>Data encoding and transmission</li>
                            <li>Understanding binary representation</li>
                            <li>Digital communications protocols</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const asciiInput = document.getElementById('ascii-input');
    const convertBtn = document.getElementById('convert-btn');
    const clearBtn = document.getElementById('clear-btn');
    const resultsSection = document.getElementById('results-section');
    const binaryResults = document.getElementById('binary-results');
    const actionButtons = document.getElementById('action-buttons');
    const copyBtn = document.getElementById('copy-btn');
    const downloadBtn = document.getElementById('download-btn');

    function asciiToBinary(str) {
        return str.split('').map(char => {
            const binary = char.charCodeAt(0).toString(2).padStart(8, '0');
            return binary;
        }).join(' ');
    }

    convertBtn.addEventListener('click', function() {
        const asciiText = asciiInput.value.trim();

        if (!asciiText) {
            alert('Please enter some ASCII text to convert.');
            return;
        }

        try {
            const binaryResult = asciiToBinary(asciiText);

            binaryResults.innerHTML = `
                <div class="mb-3">
                    <label class="form-label fw-semibold">Binary Output:</label>
                    <textarea class="form-control" readonly rows="6"
                        style="font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace; font-size: 0.9rem; background-color: #f8f9fa;"
                        id="binary-output">${binaryResult}</textarea>
                </div>
                <div class="text-muted small">
                    <i class="fas fa-info-circle me-1"></i>
                    Input: ${asciiText.length} character(s) → Output: ${binaryResult.split(' ').length} binary bytes
                </div>
            `;

            resultsSection.style.display = 'block';
            actionButtons.style.display = 'block';
        } catch (error) {
            alert('Error converting to binary. Please check your input.');
        }
    });

    clearBtn.addEventListener('click', function() {
        asciiInput.value = '';
        binaryResults.innerHTML = '';
        resultsSection.style.display = 'none';
        actionButtons.style.display = 'none';
    });

    copyBtn.addEventListener('click', function() {
        const output = document.getElementById('binary-output');
        if (output) {
            navigator.clipboard.writeText(output.value).then(() => {
                const originalText = copyBtn.innerHTML;
                copyBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';

                setTimeout(() => {
                    copyBtn.innerHTML = originalText;
                }, 2000);
            });
        }
    });

    downloadBtn.addEventListener('click', function() {
        const output = document.getElementById('binary-output');
        if (output) {
            const content = output.value;
            const blob = new Blob([content], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'ascii-to-binary-result.txt';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }
    });
});
</script>
