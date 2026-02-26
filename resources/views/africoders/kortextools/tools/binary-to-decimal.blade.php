{{-- binary to decimal --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    binary to decimal tool for your development and productivity needs.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-exchange-alt me-3"></i>Binary to Decimal Converter
                </h1>
                <p class="lead text-muted">
                    Convert binary numbers to decimal format instantly
                </p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>Binary to Decimal Conversion</h5>
                </div>
                <div class="card-body">
                    <form id="binaryToDecimalForm">
                        <div class="mb-4">
                            <label for="binaryInput" class="form-label fw-semibold">
                                <i class="fas fa-binary me-2"></i>Binary Number
                            </label>
                            <input type="text" class="form-control form-control-lg" id="binaryInput"
                                placeholder="Enter binary number (e.g., 1101, 10110101)"
                                style="font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace; letter-spacing: 1px;">
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Enter a binary number using only 0s and 1s (no spaces).
                            </div>
                        </div>

                        <div class="text-center mb-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-exchange-alt me-2"></i>Convert to Decimal
                            </button>
                            <button type="button" id="clearBtn" class="btn btn-outline-secondary btn-lg ms-3">
                                <i class="fas fa-trash-alt me-2"></i>Clear
                            </button>
                        </div>
                    </form>

                    <div id="resultSection" style="display: none;">
                        <div class="border-top pt-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-hashtag me-2"></i>Decimal Result
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="decimalOutput" readonly
                                        style="background-color: #e8f5e8; font-size: 1.2rem; font-weight: bold;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-info me-2"></i>Details
                                    </label>
                                    <div class="p-3 bg-light rounded" id="calculationDetails">
                                        <!-- Details will be populated by JavaScript -->
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <button type="button" id="copyBtn" class="btn btn-success">
                                    <i class="fas fa-copy me-2"></i>Copy Result
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="card-title text-primary">
                                <i class="fas fa-info-circle me-2"></i>How it Works
                            </h6>
                            <p class="card-text small">
                                Each binary digit represents a power of 2. The rightmost digit is 2⁰,
                                next is 2¹, then 2², and so on.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="card-title text-primary">
                                <i class="fas fa-lightbulb me-2"></i>Example
                            </h6>
                            <p class="card-text small">
                                Binary 1101 = (1×2³) + (1×2²) + (0×2¹) + (1×2⁰) = 8 + 4 + 0 + 1 = 13
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="card-title text-primary">
                                <i class="fas fa-cogs me-2"></i>Use Cases
                            </h6>
                            <ul class="small mb-0">
                                <li>Computer science education</li>
                                <li>Programming exercises</li>
                                <li>Digital systems design</li>
                                <li>Data analysis</li>
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
    const form = document.getElementById('binaryToDecimalForm');
    const binaryInput = document.getElementById('binaryInput');
    const decimalOutput = document.getElementById('decimalOutput');
    const calculationDetails = document.getElementById('calculationDetails');
    const resultSection = document.getElementById('resultSection');
    const clearBtn = document.getElementById('clearBtn');
    const copyBtn = document.getElementById('copyBtn');

    function binaryToDecimal(binaryStr) {
        const cleanBinary = binaryStr.replace(/\s/g, '');

        if (!/^[01]+$/.test(cleanBinary)) {
            throw new Error('Invalid binary format. Only 0s and 1s are allowed.');
        }

        let decimal = 0;
        let calculation = [];

        for (let i = 0; i < cleanBinary.length; i++) {
            const digit = parseInt(cleanBinary[cleanBinary.length - 1 - i]);
            const power = i;
            const value = digit * Math.pow(2, power);

            if (digit === 1) {
                calculation.push({
                    digit: digit,
                    power: power,
                    value: value,
                    position: cleanBinary.length - 1 - i
                });
            }

            decimal += value;
        }

        return { decimal, calculation, binary: cleanBinary };
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const binaryText = binaryInput.value.trim();

        if (!binaryText) {
            alert('Please enter a binary number to convert.');
            return;
        }

        try {
            const result = binaryToDecimal(binaryText);
            decimalOutput.value = result.decimal;

            // Generate calculation details
            let detailsHTML = '<div class="small">';
            if (result.calculation.length > 0) {
                detailsHTML += '<strong>Calculation:</strong><br>';
                detailsHTML += result.calculation.map(calc =>
                    `1 × 2<sup>${calc.power}</sup> = ${calc.value}`
                ).join(' + ');
                detailsHTML += ` = <strong>${result.decimal}</strong>`;
            } else {
                detailsHTML += '<strong>Result:</strong> 0';
            }
            detailsHTML += '</div>';

            calculationDetails.innerHTML = detailsHTML;
            resultSection.style.display = 'block';
        } catch (error) {
            alert('Error: ' + error.message);
        }
    });

    clearBtn.addEventListener('click', function() {
        binaryInput.value = '';
        decimalOutput.value = '';
        calculationDetails.innerHTML = '';
        resultSection.style.display = 'none';
    });

    copyBtn.addEventListener('click', function() {
        navigator.clipboard.writeText(decimalOutput.value).then(() => {
            const originalText = copyBtn.innerHTML;
            copyBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';

            setTimeout(() => {
                copyBtn.innerHTML = originalText;
            }, 2000);
        });
    });

    // Allow only 0 and 1 input
    binaryInput.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^01]/g, '');
    });
});
</script>

