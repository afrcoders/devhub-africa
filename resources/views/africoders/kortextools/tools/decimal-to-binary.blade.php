{{-- decimal to binary --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    decimal to binary tool for your development and productivity needs.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-exchange-alt me-3"></i>Decimal to Binary Converter
                </h1>
                <p class="lead text-muted">
                    Convert decimal numbers to binary format instantly
                </p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>Decimal to Binary Conversion</h5>
                </div>
                <div class="card-body">
                    <form id="decimalToBinaryForm">
                        <div class="mb-4">
                            <label for="decimalInput" class="form-label fw-semibold">
                                <i class="fas fa-hashtag me-2"></i>Decimal Number
                            </label>
                            <input type="number" class="form-control form-control-lg" id="decimalInput"
                                placeholder="Enter decimal number (e.g., 13, 255, 1024)" min="0"
                                style="font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace; letter-spacing: 1px;">
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Enter any positive decimal number.
                            </div>
                        </div>

                        <div class="text-center mb-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-exchange-alt me-2"></i>Convert to Binary
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
                                        <i class="fas fa-binary me-2"></i>Binary Result
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="binaryOutput" readonly
                                        style="background-color: #e8f5e8; font-size: 1.2rem; font-weight: bold; font-family: 'Monaco', monospace; letter-spacing: 2px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-info me-2"></i>Conversion Steps
                                    </label>
                                    <div class="p-3 bg-light rounded" id="conversionSteps">
                                        <!-- Steps will be populated by JavaScript -->
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <button type="button" id="copyBtn" class="btn btn-success">
                                    <i class="fas fa-copy me-2"></i>Copy Result
                                </button>
                                <button type="button" id="downloadBtn" class="btn btn-outline-primary ms-2">
                                    <i class="fas fa-download me-2"></i>Download
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
                                Decimal numbers are converted by repeatedly dividing by 2
                                and collecting remainders from bottom to top.
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
                                13 ÷ 2 = 6 remainder 1<br>
                                6 ÷ 2 = 3 remainder 0<br>
                                3 ÷ 2 = 1 remainder 1<br>
                                1 ÷ 2 = 0 remainder 1<br>
                                Result: 1101
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
                                <li>Computer programming</li>
                                <li>Digital electronics</li>
                                <li>Number system education</li>
                                <li>Data representation</li>
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
    const form = document.getElementById('decimalToBinaryForm');
    const decimalInput = document.getElementById('decimalInput');
    const binaryOutput = document.getElementById('binaryOutput');
    const conversionSteps = document.getElementById('conversionSteps');
    const resultSection = document.getElementById('resultSection');
    const clearBtn = document.getElementById('clearBtn');
    const copyBtn = document.getElementById('copyBtn');
    const downloadBtn = document.getElementById('downloadBtn');

    function decimalToBinary(decimal) {
        if (decimal === 0) return { binary: '0', steps: [{ dividend: 0, quotient: 0, remainder: 0 }] };

        let num = parseInt(decimal);
        let binary = '';
        let steps = [];

        while (num > 0) {
            const remainder = num % 2;
            const quotient = Math.floor(num / 2);

            steps.push({
                dividend: num,
                quotient: quotient,
                remainder: remainder
            });

            binary = remainder + binary;
            num = quotient;
        }

        return { binary, steps };
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const decimalText = decimalInput.value.trim();

        if (!decimalText || decimalText < 0) {
            alert('Please enter a valid positive decimal number.');
            return;
        }

        try {
            const result = decimalToBinary(decimalText);
            binaryOutput.value = result.binary;

            // Generate conversion steps
            let stepsHTML = '<div class="small">';
            if (result.steps.length === 1 && result.steps[0].dividend === 0) {
                stepsHTML += '<div>0 in binary is 0</div>';
            } else {
                stepsHTML += '<strong>Division Steps:</strong><br>';
                result.steps.forEach((step, index) => {
                    stepsHTML += `<div>${step.dividend} ÷ 2 = ${step.quotient} remainder ${step.remainder}</div>`;
                });
                stepsHTML += '<br><strong>Read remainders from bottom to top:</strong><br>';
                stepsHTML += `<span class="text-primary fw-bold">${result.binary}</span>`;
            }
            stepsHTML += '</div>';

            conversionSteps.innerHTML = stepsHTML;
            resultSection.style.display = 'block';
        } catch (error) {
            alert('Error converting to binary. Please check your input.');
        }
    });

    clearBtn.addEventListener('click', function() {
        decimalInput.value = '';
        binaryOutput.value = '';
        conversionSteps.innerHTML = '';
        resultSection.style.display = 'none';
    });

    copyBtn.addEventListener('click', function() {
        navigator.clipboard.writeText(binaryOutput.value).then(() => {
            const originalText = copyBtn.innerHTML;
            copyBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';

            setTimeout(() => {
                copyBtn.innerHTML = originalText;
            }, 2000);
        });
    });

    downloadBtn.addEventListener('click', function() {
        const content = `Decimal: ${decimalInput.value}\nBinary: ${binaryOutput.value}\n\nConversion Steps:\n${conversionSteps.textContent}`;
        const blob = new Blob([content], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'decimal-to-binary-result.txt';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    });
});
</script>

