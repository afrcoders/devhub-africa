{{-- Hex to Binary Converter --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-exchange-alt me-2"></i>
    Convert hexadecimal numbers to binary format with real-time validation.
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
                                <label for="hexInput" class="form-label">Hexadecimal Input</label>
                                <textarea class="form-control" id="hexInput" rows="4"
                                    placeholder="Enter hexadecimal values (e.g., FF, 1A3, ABC123)..."></textarea>
                                <div class="form-text">Separate multiple hex values with spaces, commas, or newlines</div>
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button type="button" class="btn btn-primary" id="convertBtn">
                                    <i class="fas fa-exchange-alt me-2"></i>Convert to Binary
                                </button>
                            </div>

                            <div class="mb-3">
                                <label for="binaryOutput" class="form-label">Binary Output</label>
                                <textarea class="form-control" id="binaryOutput" rows="4" readonly
                                    placeholder="Binary values will appear here..."></textarea>
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
const hexInput = document.getElementById('hexInput');
const binaryOutput = document.getElementById('binaryOutput');
const convertBtn = document.getElementById('convertBtn');
const copyBtn = document.getElementById('copyBtn');
const downloadBtn = document.getElementById('downloadBtn');

// Convert hexadecimal to binary
function hexToBinary(hex) {
    // Remove any prefixes and clean input
    hex = hex.replace(/^0x/i, '').trim();

    // Validate hex input
    if (!/^[0-9A-Fa-f]+$/.test(hex)) {
        return null;
    }

    // Convert each hex digit to 4-bit binary
    return hex.split('').map(digit => {
        const decimal = parseInt(digit, 16);
        return decimal.toString(2).padStart(4, '0');
    }).join('');
}

// Convert button click
convertBtn.addEventListener('click', function() {
    const input = hexInput.value.trim();

    if (!input) {
        alert('Please enter hexadecimal values to convert.');
        return;
    }

    // Split by various delimiters
    const hexValues = input.split(/[\s,\n\r]+/).filter(val => val.length > 0);
    const results = [];

    for (let hex of hexValues) {
        const binary = hexToBinary(hex);
        if (binary === null) {
            results.push(`${hex} → Invalid hexadecimal`);
        } else {
            results.push(`${hex.toUpperCase()} → ${binary}`);
        }
    }

    binaryOutput.value = results.join('\n');
});

// Auto-convert on input change
hexInput.addEventListener('input', function() {
    if (this.value.trim()) {
        convertBtn.click();
    }
});

// Copy to clipboard
copyBtn.addEventListener('click', function() {
    if (!binaryOutput.value) {
        alert('Nothing to copy. Please convert some hexadecimal values first.');
        return;
    }

    binaryOutput.select();
    navigator.clipboard.writeText(binaryOutput.value).then(function() {
        const originalText = copyBtn.innerHTML;
        copyBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
        setTimeout(function() {
            copyBtn.innerHTML = originalText;
        }, 2000);
    });
});

// Download as text file
downloadBtn.addEventListener('click', function() {
    if (!binaryOutput.value) {
        alert('Nothing to download. Please convert some hexadecimal values first.');
        return;
    }

    const blob = new Blob([binaryOutput.value], { type: 'text/plain' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'hex-to-binary-conversion.txt';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
});
</script>
