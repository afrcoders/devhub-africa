<div class="row">
    <div class="col-md-12">
        <!-- Number Base Converter Input -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label for="inputNumber" class="form-label">Input Number</label>
                <textarea class="form-control" id="inputNumber" rows="3" placeholder="Enter number to convert..."></textarea>
                <small class="form-text text-muted">Enter the number you want to convert</small>
            </div>
            <div class="col-md-3 mb-3">
                <label for="fromBase" class="form-label">From Base</label>
                <select class="form-select" id="fromBase">
                    <option value="2">Binary (Base 2)</option>
                    <option value="8">Octal (Base 8)</option>
                    <option value="10" selected>Decimal (Base 10)</option>
                    <option value="16">Hexadecimal (Base 16)</option>
                    <option value="custom">Custom Base</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="toBase" class="form-label">To Base</label>
                <select class="form-select" id="toBase">
                    <option value="2">Binary (Base 2)</option>
                    <option value="8">Octal (Base 8)</option>
                    <option value="10">Decimal (Base 10)</option>
                    <option value="16" selected>Hexadecimal (Base 16)</option>
                    <option value="custom">Custom Base</option>
                </select>
            </div>
        </div>

        <!-- Custom Base Inputs -->
        <div class="row mb-4" id="customBaseSection" style="display: none;">
            <div class="col-md-6 mb-3">
                <label for="customFromBase" class="form-label">Custom From Base (2-36)</label>
                <input type="number" class="form-control" id="customFromBase" min="2" max="36" placeholder="Enter base number">
            </div>
            <div class="col-md-6 mb-3">
                <label for="customToBase" class="form-label">Custom To Base (2-36)</label>
                <input type="number" class="form-control" id="customToBase" min="2" max="36" placeholder="Enter base number">
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mb-4">
            <h6>Quick Conversions:</h6>
            <div class="row">
                <div class="col-md-3 mb-2">
                    <button type="button" class="btn btn-outline-primary btn-sm w-100" onclick="setQuickConversion(10, 2)">
                        Decimal → Binary
                    </button>
                </div>
                <div class="col-md-3 mb-2">
                    <button type="button" class="btn btn-outline-success btn-sm w-100" onclick="setQuickConversion(10, 16)">
                        Decimal → Hex
                    </button>
                </div>
                <div class="col-md-3 mb-2">
                    <button type="button" class="btn btn-outline-info btn-sm w-100" onclick="setQuickConversion(2, 10)">
                        Binary → Decimal
                    </button>
                </div>
                <div class="col-md-3 mb-2">
                    <button type="button" class="btn btn-outline-warning btn-sm w-100" onclick="setQuickConversion(16, 10)">
                        Hex → Decimal
                    </button>
                </div>
            </div>
        </div>

        <!-- Example Numbers -->
        <div class="mb-4">
            <h6>Try These Examples:</h6>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('255', 10)">
                    255 (Decimal)
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('11111111', 2)">
                    11111111 (Binary)
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('FF', 16)">
                    FF (Hex)
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('377', 8)">
                    377 (Octal)
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('1024', 10)">
                    1024 (Decimal)
                </button>
            </div>
        </div>

        <!-- Convert Button -->
        <div class="mb-4">
            <button type="button" class="btn btn-primary" onclick="convertNumber()">
                <i class="fas fa-exchange-alt"></i> Convert Number
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="swapBases()">
                <i class="bi bi-arrow-left-right"></i> Swap Bases
            </button>
            <button type="button" class="btn btn-outline-danger" onclick="clearAll()">
                <i class="bi bi-x-circle"></i> Clear
            </button>
        </div>

        <!-- All Bases Display -->
        <div class="mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="showAllBases">
                <label class="form-check-label" for="showAllBases">
                    Show conversion to all common bases simultaneously
                </label>
            </div>
        </div>

        <!-- Results Container -->
        <div id="resultsContainer" style="display: none;" class="mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Number Base Conversion Results</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="text-center p-3 bg-primary text-white rounded">
                                <div class="h6">Input</div>
                                <div id="inputDisplay" class="h4 mb-1" style="word-break: break-all;">--</div>
                                <small id="inputBaseDisplay">Base --</small>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="text-center p-3 bg-success text-white rounded">
                                <div class="h6">Output</div>
                                <div id="outputDisplay" class="h4 mb-1" style="word-break: break-all;">--</div>
                                <small id="outputBaseDisplay">Base --</small>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-striped">
                            <tbody id="conversionDetails">
                                <!-- Details will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-outline-primary" onclick="copyResults()">
                        <i class="bi bi-clipboard"></i> Copy Results
                    </button>
                    <button type="button" class="btn btn-outline-success" onclick="copyOutputOnly()">
                        <i class="bi bi-clipboard-check"></i> Copy Output Only
                    </button>
                </div>
            </div>
        </div>

        <!-- All Bases Display -->
        <div id="allBasesContainer" style="display: none;" class="mb-4">
            <h6>Conversion to All Common Bases:</h6>
            <div class="row" id="allBasesGrid">
                <!-- All base conversions will be populated by JavaScript -->
            </div>
        </div>

        <!-- Number System Information -->
        <div class="mt-4 p-3 bg-light rounded">
            <h6><i class="bi bi-info-circle"></i> Number System Guide</h6>
            <div class="row">
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Base</th>
                                    <th>Name</th>
                                    <th>Digits Used</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>2</td><td>Binary</td><td>0, 1</td></tr>
                                <tr><td>8</td><td>Octal</td><td>0-7</td></tr>
                                <tr><td>10</td><td>Decimal</td><td>0-9</td></tr>
                                <tr><td>16</td><td>Hexadecimal</td><td>0-9, A-F</td></tr>
                                <tr><td>36</td><td>Base-36</td><td>0-9, A-Z</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6>Common Uses:</h6>
                    <ul class="small">
                        <li><strong>Binary (Base 2):</strong> Computer systems, digital electronics</li>
                        <li><strong>Octal (Base 8):</strong> Unix file permissions, some programming</li>
                        <li><strong>Decimal (Base 10):</strong> Everyday mathematics, human counting</li>
                        <li><strong>Hexadecimal (Base 16):</strong> Colors, memory addresses, checksums</li>
                        <li><strong>Base-36:</strong> Compact identifiers, URL shortening</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Calculation Steps -->
        <div id="calculationSteps" style="display: none;" class="mt-4 p-3 bg-info bg-opacity-10 rounded">
            <h6><i class="bi bi-calculator"></i> Calculation Steps</h6>
            <div id="stepsContent">
                <!-- Calculation steps will be shown here -->
            </div>
        </div>
    </div>
</div>

<!-- Information Alert -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> About Number Base Conversion</h6>
    <p class="mb-0">
        This tool converts numbers between different number systems (bases) from 2 to 36.
        For bases above 10, letters A-Z represent digits 10-35. The conversion maintains
        mathematical accuracy and shows step-by-step calculation methods for educational purposes.
    </p>
</div>

<script>
let currentConversionResult = null;

// Handle base selection changes
document.getElementById('fromBase').addEventListener('change', function() {
    toggleCustomBase('from');
});

document.getElementById('toBase').addEventListener('change', function() {
    toggleCustomBase('to');
});

function toggleCustomBase(direction) {
    const customSection = document.getElementById('customBaseSection');
    const fromBase = document.getElementById('fromBase').value;
    const toBase = document.getElementById('toBase').value;

    if (fromBase === 'custom' || toBase === 'custom') {
        customSection.style.display = 'block';
    } else {
        customSection.style.display = 'none';
    }
}

function getEffectiveBase(direction) {
    const baseSelect = document.getElementById(direction + 'Base');
    if (baseSelect.value === 'custom') {
        const customInput = document.getElementById('custom' + direction.charAt(0).toUpperCase() + direction.slice(1) + 'Base');
        return parseInt(customInput.value) || 10;
    }
    return parseInt(baseSelect.value);
}

function setQuickConversion(fromBase, toBase) {
    document.getElementById('fromBase').value = fromBase.toString();
    document.getElementById('toBase').value = toBase.toString();
    toggleCustomBase('from');
    toggleCustomBase('to');
}

function useExample(number, base) {
    document.getElementById('inputNumber').value = number;
    document.getElementById('fromBase').value = base.toString();
    toggleCustomBase('from');
    convertNumber();
}

function swapBases() {
    const fromBase = document.getElementById('fromBase').value;
    const toBase = document.getElementById('toBase').value;
    const customFromBase = document.getElementById('customFromBase').value;
    const customToBase = document.getElementById('customToBase').value;

    // Swap base selects
    document.getElementById('fromBase').value = toBase;
    document.getElementById('toBase').value = fromBase;

    // Swap custom bases
    document.getElementById('customFromBase').value = customToBase;
    document.getElementById('customToBase').value = customFromBase;

    // Update custom base visibility
    toggleCustomBase('from');
    toggleCustomBase('to');

    // If we have a previous result, put the output back as input
    if (currentConversionResult) {
        document.getElementById('inputNumber').value = currentConversionResult.output;
        convertNumber();
    }
}

function convertNumber() {
    const inputNumber = document.getElementById('inputNumber').value.trim();
    const fromBase = getEffectiveBase('from');
    const toBase = getEffectiveBase('to');

    if (!inputNumber) {
        alert('Please enter a number to convert.');
        return;
    }

    if (fromBase < 2 || fromBase > 36 || toBase < 2 || toBase > 36) {
        alert('Base must be between 2 and 36.');
        return;
    }

    try {
        // Validate input number for the given base
        if (!isValidNumberForBase(inputNumber, fromBase)) {
            alert(`Invalid number for base ${fromBase}. Check that all digits are valid for this base.`);
            return;
        }

        // Convert to decimal first, then to target base
        const decimalValue = parseInt(inputNumber, fromBase);

        if (isNaN(decimalValue)) {
            throw new Error('Invalid number format');
        }

        const outputNumber = decimalValue.toString(toBase).toUpperCase();

        currentConversionResult = {
            input: inputNumber,
            output: outputNumber,
            fromBase: fromBase,
            toBase: toBase,
            decimalValue: decimalValue,
            steps: generateCalculationSteps(inputNumber, fromBase, toBase, decimalValue)
        };

        displayConversionResults(currentConversionResult);

        // Show all bases if enabled
        if (document.getElementById('showAllBases').checked) {
            displayAllBasesConversion(decimalValue);
        }

    } catch (error) {
        alert('Error converting number: ' + error.message);
        console.error('Number conversion error:', error);
    }
}

function isValidNumberForBase(number, base) {
    const validChars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const allowedChars = validChars.substring(0, base);

    for (let char of number.toUpperCase()) {
        if (!allowedChars.includes(char)) {
            return false;
        }
    }
    return true;
}

function generateCalculationSteps(input, fromBase, toBase, decimalValue) {
    const steps = [];

    // Step 1: Convert from source base to decimal (if not already decimal)
    if (fromBase !== 10) {
        let step1 = `Converting ${input} (base ${fromBase}) to decimal:\n`;
        let calculation = '';

        for (let i = 0; i < input.length; i++) {
            const digit = input[input.length - 1 - i];
            const digitValue = parseInt(digit, fromBase);
            const power = i;
            const placeValue = Math.pow(fromBase, power);

            if (i > 0) calculation += ' + ';
            calculation += `${digit}×${fromBase}^${power}`;
            if (power > 0) calculation += ` = ${digitValue}×${placeValue} = ${digitValue * placeValue}`;
        }

        step1 += calculation + ` = ${decimalValue}`;
        steps.push(step1);
    }

    // Step 2: Convert from decimal to target base (if not decimal)
    if (toBase !== 10) {
        let step2 = `Converting ${decimalValue} (decimal) to base ${toBase}:\n`;
        let divisions = [];
        let num = decimalValue;

        while (num > 0) {
            const remainder = num % toBase;
            const quotient = Math.floor(num / toBase);
            divisions.push(`${num} ÷ ${toBase} = ${quotient} remainder ${remainder}`);
            num = quotient;
        }

        step2 += divisions.join('\n');
        step2 += `\nReading remainders from bottom to top: ${currentConversionResult.output}`;
        steps.push(step2);
    }

    return steps;
}

function displayConversionResults(result) {
    // Update main display
    document.getElementById('inputDisplay').textContent = result.input;
    document.getElementById('inputBaseDisplay').textContent = `Base ${result.fromBase}`;
    document.getElementById('outputDisplay').textContent = result.output;
    document.getElementById('outputBaseDisplay').textContent = `Base ${result.toBase}`;

    // Update details table
    const detailsTable = document.getElementById('conversionDetails');
    const basenames = {
        2: 'Binary',
        8: 'Octal',
        10: 'Decimal',
        16: 'Hexadecimal'
    };

    const fromBaseName = basenames[result.fromBase] || `Base ${result.fromBase}`;
    const toBaseName = basenames[result.toBase] || `Base ${result.toBase}`;

    detailsTable.innerHTML = `
        <tr><th width="30%">Input Number</th><td>${result.input}</td></tr>
        <tr><th>Source Base</th><td>${result.fromBase} (${fromBaseName})</td></tr>
        <tr><th>Target Base</th><td>${result.toBase} (${toBaseName})</td></tr>
        <tr><th>Decimal Equivalent</th><td>${result.decimalValue.toLocaleString()}</td></tr>
        <tr class="table-success"><th><strong>Converted Result</strong></th><td><strong>${result.output}</strong></td></tr>
        <tr><th>Number of Digits</th><td>Input: ${result.input.length}, Output: ${result.output.length}</td></tr>
    `;

    document.getElementById('resultsContainer').style.display = 'block';

    // Show calculation steps
    if (result.steps.length > 0) {
        const stepsContent = document.getElementById('stepsContent');
        stepsContent.innerHTML = result.steps.map(step =>
            `<div class="mb-3"><pre class="mb-0" style="white-space: pre-wrap; font-size: 0.9rem;">${step}</pre></div>`
        ).join('');
        document.getElementById('calculationSteps').style.display = 'block';
    }
}

function displayAllBasesConversion(decimalValue) {
    const container = document.getElementById('allBasesGrid');
    const commonBases = [
        { base: 2, name: 'Binary', color: 'primary' },
        { base: 8, name: 'Octal', color: 'success' },
        { base: 10, name: 'Decimal', color: 'info' },
        { base: 16, name: 'Hexadecimal', color: 'warning' },
        { base: 32, name: 'Base-32', color: 'secondary' },
        { base: 36, name: 'Base-36', color: 'dark' }
    ];

    container.innerHTML = '';

    commonBases.forEach(baseInfo => {
        const converted = decimalValue.toString(baseInfo.base).toUpperCase();

        const col = document.createElement('div');
        col.className = 'col-md-4 mb-3';
        col.innerHTML = `
            <div class="text-center p-3 border border-${baseInfo.color} rounded">
                <div class="fw-bold text-${baseInfo.color}">${baseInfo.name}</div>
                <div class="h6 mt-2" style="word-break: break-all; font-family: monospace;">${converted}</div>
                <small class="text-muted">Base ${baseInfo.base}</small>
                <br>
                <button class="btn btn-outline-${baseInfo.color} btn-sm mt-2" onclick="copyToClipboard('${converted}')">
                    <i class="bi bi-clipboard"></i> Copy
                </button>
            </div>
        `;

        container.appendChild(col);
    });

    document.getElementById('allBasesContainer').style.display = 'block';
}

// Handle show all bases checkbox
document.getElementById('showAllBases').addEventListener('change', function() {
    if (this.checked && currentConversionResult) {
        displayAllBasesConversion(currentConversionResult.decimalValue);
    } else {
        document.getElementById('allBasesContainer').style.display = 'none';
    }
});

function copyResults() {
    if (!currentConversionResult) return;

    const result = currentConversionResult;
    const basenames = {
        2: 'Binary',
        8: 'Octal',
        10: 'Decimal',
        16: 'Hexadecimal'
    };

    const fromBaseName = basenames[result.fromBase] || `Base ${result.fromBase}`;
    const toBaseName = basenames[result.toBase] || `Base ${result.toBase}`;

    const textToCopy = `Number Base Conversion:
Input: ${result.input} (${fromBaseName})
Output: ${result.output} (${toBaseName})
Decimal Equivalent: ${result.decimalValue.toLocaleString()}`;

    copyToClipboard(textToCopy);
}

function copyOutputOnly() {
    if (!currentConversionResult) return;

    copyToClipboard(currentConversionResult.output);
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success feedback
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="bi bi-check"></i> Copied!';

        const originalClasses = button.className;
        button.className = button.className.replace(/btn-outline-\w+/, 'btn-success');

        setTimeout(function() {
            button.innerHTML = originalText;
            button.className = originalClasses;
        }, 2000);
    });
}

function clearAll() {
    document.getElementById('inputNumber').value = '';
    document.getElementById('fromBase').value = '10';
    document.getElementById('toBase').value = '16';
    document.getElementById('customFromBase').value = '';
    document.getElementById('customToBase').value = '';
    document.getElementById('showAllBases').checked = false;

    document.getElementById('customBaseSection').style.display = 'none';
    document.getElementById('resultsContainer').style.display = 'none';
    document.getElementById('allBasesContainer').style.display = 'none';
    document.getElementById('calculationSteps').style.display = 'none';

    currentConversionResult = null;
}

// Auto-convert when values change (with debounce)
let convertTimeout;
function debounceConvert() {
    clearTimeout(convertTimeout);
    convertTimeout = setTimeout(() => {
        const inputNumber = document.getElementById('inputNumber').value.trim();

        if (inputNumber) {
            convertNumber();
        }
    }, 800);
}

// Add event listeners for auto-conversion
document.getElementById('inputNumber').addEventListener('input', debounceConvert);
document.getElementById('fromBase').addEventListener('change', debounceConvert);
document.getElementById('toBase').addEventListener('change', debounceConvert);
document.getElementById('customFromBase').addEventListener('input', debounceConvert);
document.getElementById('customToBase').addEventListener('input', debounceConvert);

// Input validation for custom bases
document.getElementById('customFromBase').addEventListener('input', function() {
    const value = parseInt(this.value);
    if (value && (value < 2 || value > 36)) {
        this.setCustomValidity('Base must be between 2 and 36');
    } else {
        this.setCustomValidity('');
    }
});

document.getElementById('customToBase').addEventListener('input', function() {
    const value = parseInt(this.value);
    if (value && (value < 2 || value > 36)) {
        this.setCustomValidity('Base must be between 2 and 36');
    } else {
        this.setCustomValidity('');
    }
});

// Format large numbers for display
function formatLargeNumber(num) {
    if (num > 1000000000) {
        return (num / 1000000000).toFixed(2) + 'B';
    } else if (num > 1000000) {
        return (num / 1000000).toFixed(2) + 'M';
    } else if (num > 1000) {
        return (num / 1000).toFixed(2) + 'K';
    }
    return num.toLocaleString();
}
</script>

<style>
.table th {
    background-color: #f8f9fa;
}

pre {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.375rem;
    border: 1px solid #dee2e6;
}

#allBasesGrid .border:hover {
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

@media (max-width: 768px) {
    .btn-sm {
        font-size: 0.8rem;
        padding: 0.25rem 0.5rem;
        margin-bottom: 0.5rem;
    }

    .h4 {
        font-size: 1.2rem;
    }
}
</style>
