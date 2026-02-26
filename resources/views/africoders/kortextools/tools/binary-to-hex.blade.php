{{-- Binary to Hex Converter --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-exchange-alt me-2"></i>
    Convert binary numbers to hexadecimal format with real-time validation.
</div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-exchange-alt me-2"></i>
                        {{ $tool->name }}
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">{{ $tool->description }}</p>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="binaryInput" class="form-label">Binary Input</label>
                                <textarea class="form-control" id="binaryInput" rows="4"
                                    placeholder="Enter binary numbers (e.g., 1010 1111 0001)"></textarea>
                                <div class="form-text">Enter binary numbers separated by spaces or newlines</div>
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button type="button" class="btn btn-primary" id="convertBtn">
                                    <i class="fas fa-exchange-alt me-2"></i>Convert to Hexadecimal
                                </button>
                            </div>

                            <div class="mb-3">
                                <label for="hexOutput" class="form-label">Hexadecimal Output</label>
                                <textarea class="form-control" id="hexOutput" rows="4" readonly
                                    placeholder="Hexadecimal result will appear here"></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-secondary w-100" id="copyBtn">
                                        <i class="fas fa-copy me-2"></i>Copy to Clipboard
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-success w-100" id="downloadBtn">
                                        <i class="fas fa-download me-2"></i>Download as TXT
                                    </button>
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
const binaryInput = document.getElementById('binaryInput');
const hexOutput = document.getElementById('hexOutput');
const convertBtn = document.getElementById('convertBtn');
const copyBtn = document.getElementById('copyBtn');
const downloadBtn = document.getElementById('downloadBtn');

// Convert binary to hexadecimal
convertBtn.addEventListener('click', function() {
    const binaryText = binaryInput.value.trim();

    if (!binaryText) {
        alert('Please enter binary numbers to convert.');
        return;
    }

    try {
        // Split input by spaces, newlines, or commas and filter out empty strings
        const binaryNumbers = binaryText.split(/[\s,]+/).filter(b => b.length > 0);
        const hexResults = [];

        for (let binary of binaryNumbers) {
            // Validate binary input
            if (!/^[01]+$/.test(binary)) {
                throw new Error(`Invalid binary number: ${binary}`);
            }

            // Convert binary to decimal then to hex
            const decimal = parseInt(binary, 2);
            const hex = decimal.toString(16).toUpperCase();
            hexResults.push(hex);
        }

        hexOutput.value = hexResults.join(' ');
    } catch (error) {
        alert('Error: ' + error.message);
    }
});

// Copy to clipboard
copyBtn.addEventListener('click', function() {
    if (!hexOutput.value) {
        alert('Nothing to copy. Please convert some binary numbers first.');
        return;
    }

    hexOutput.select();
    navigator.clipboard.writeText(hexOutput.value).then(function() {
        const originalText = copyBtn.innerHTML;
        copyBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
        setTimeout(function() {
            copyBtn.innerHTML = originalText;
        }, 2000);
    });
});

// Download as text file
downloadBtn.addEventListener('click', function() {
    if (!hexOutput.value) {
        alert('Nothing to download. Please convert some binary numbers first.');
        return;
    }

    const blob = new Blob([hexOutput.value], { type: 'text/plain' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'binary-to-hex-conversion.txt';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
});

// Auto-convert on input change
binaryInput.addEventListener('input', function() {
    if (this.value.trim()) {
        convertBtn.click();
    }
});
</script>
