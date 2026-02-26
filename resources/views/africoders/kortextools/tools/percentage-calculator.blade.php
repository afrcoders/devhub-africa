<div class="row">
    <div class="col-md-12">
        <!-- Operation Selection -->
        <div class="mb-4">
            <label for="operation" class="form-label">Calculation Type</label>
            <select class="form-select" id="operation" name="operation" onchange="updateLabels()">
                <option value="percentage">What percentage is X of Y?</option>
                <option value="percentage_of">What is X% of Y?</option>
                <option value="percentage_increase">Percentage increase from X to Y</option>
                <option value="percentage_decrease">Percentage decrease from X to Y</option>
                <option value="find_original">Find original value (Y is X% more/less)</option>
                <option value="percentage_change">Percentage change from X to Y</option>
            </select>
        </div>

        <!-- Input Values -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label for="value1" class="form-label" id="value1-label">Value 1 (X)</label>
                <input type="number" class="form-control" id="value1" name="value1" placeholder="Enter first value" step="0.01">
            </div>
            <div class="col-md-6 mb-3">
                <label for="value2" class="form-label" id="value2-label">Value 2 (Y)</label>
                <input type="number" class="form-control" id="value2" name="value2" placeholder="Enter second value" step="0.01">
            </div>
        </div>

        <!-- Calculate Button -->
        <div class="mb-4">
            <button type="button" class="btn btn-primary" onclick="calculatePercentage()">
                <i class="fas fa-percent"></i> Calculate
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="clearAll()">
                <i class="bi bi-x-circle"></i> Clear
            </button>
        </div>

        <!-- Results Section -->
        <div id="resultsContainer" style="display: none;">
            <div class="alert alert-success">
                <h5 id="resultValue" class="mb-2">0%</h5>
                <p id="resultExplanation" class="mb-0 small"></p>
            </div>

            <!-- Detailed Results -->
            <div id="detailedResults" class="mt-3" style="display: none;">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <th width="40%">Formula Used</th>
                                <td id="formula">-</td>
                            </tr>
                            <tr>
                                <th>Calculation</th>
                                <td id="calculation">-</td>
                            </tr>
                            <tr>
                                <th>Result</th>
                                <td id="finalResult">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="copyResult()">
                    <i class="bi bi-clipboard"></i> Copy Result
                </button>
                <button type="button" class="btn btn-sm btn-outline-info" onclick="toggleDetails()">
                    <i class="bi bi-info-circle"></i> <span id="details-toggle">Show Details</span>
                </button>
            </div>
        </div>

        <!-- Quick Examples -->
        <div class="mt-4">
            <h6>Quick Examples:</h6>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('percentage', 25, 100)">
                    25 of 100
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('percentage_of', 15, 200)">
                    15% of 200
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('percentage_increase', 100, 150)">
                    100 to 150 increase
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('percentage_decrease', 200, 150)">
                    200 to 150 decrease
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Information -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> About Percentage Calculations</h6>
    <p class="mb-0">
        Percentage calculations help you understand proportional relationships between numbers.
        Choose the appropriate calculation type and enter your values to get precise results with
        detailed explanations and formulas used.
    </p>
</div>

<script>
function updateLabels() {
    const operation = document.getElementById('operation').value;
    const value1Label = document.getElementById('value1-label');
    const value2Label = document.getElementById('value2-label');

    switch(operation) {
        case 'percentage':
            value1Label.textContent = 'Part Value (X)';
            value2Label.textContent = 'Total Value (Y)';
            break;
        case 'percentage_of':
            value1Label.textContent = 'Percentage (X%)';
            value2Label.textContent = 'Total Value (Y)';
            break;
        case 'percentage_increase':
            value1Label.textContent = 'Original Value (X)';
            value2Label.textContent = 'New Value (Y)';
            break;
        case 'percentage_decrease':
            value1Label.textContent = 'Original Value (X)';
            value2Label.textContent = 'New Value (Y)';
            break;
        case 'find_original':
            value1Label.textContent = 'Percentage (X%)';
            value2Label.textContent = 'Final Value (Y)';
            break;
        case 'percentage_change':
            value1Label.textContent = 'Original Value (X)';
            value2Label.textContent = 'New Value (Y)';
            break;
    }
}

function calculatePercentage() {
    const operation = document.getElementById('operation').value;
    const value1 = parseFloat(document.getElementById('value1').value);
    const value2 = parseFloat(document.getElementById('value2').value);

    if (isNaN(value1) || isNaN(value2)) {
        alert('Please enter valid numbers for both values.');
        return;
    }

    let result = 0;
    let formula = '';
    let calculation = '';
    let explanation = '';

    switch(operation) {
        case 'percentage':
            if (value2 === 0) {
                alert('Cannot divide by zero.');
                return;
            }
            result = (value1 / value2) * 100;
            formula = '(X ÷ Y) × 100';
            calculation = `(${value1} ÷ ${value2}) × 100`;
            explanation = `${value1} is ${result.toFixed(2)}% of ${value2}`;
            break;

        case 'percentage_of':
            result = (value1 / 100) * value2;
            formula = '(X ÷ 100) × Y';
            calculation = `(${value1} ÷ 100) × ${value2}`;
            explanation = `${value1}% of ${value2} is ${result.toFixed(2)}`;
            break;

        case 'percentage_increase':
            if (value1 === 0) {
                alert('Original value cannot be zero for percentage increase.');
                return;
            }
            result = ((value2 - value1) / value1) * 100;
            formula = '((Y - X) ÷ X) × 100';
            calculation = `((${value2} - ${value1}) ÷ ${value1}) × 100`;
            explanation = `Increase from ${value1} to ${value2} is ${result.toFixed(2)}%`;
            break;

        case 'percentage_decrease':
            if (value1 === 0) {
                alert('Original value cannot be zero for percentage decrease.');
                return;
            }
            result = ((value1 - value2) / value1) * 100;
            formula = '((X - Y) ÷ X) × 100';
            calculation = `((${value1} - ${value2}) ÷ ${value1}) × 100`;
            explanation = `Decrease from ${value1} to ${value2} is ${result.toFixed(2)}%`;
            break;

        case 'find_original':
            if (value1 === 100) {
                alert('Percentage cannot be 100% for this calculation.');
                return;
            }
            result = value2 / (1 + (value1 / 100));
            formula = 'Y ÷ (1 + (X ÷ 100))';
            calculation = `${value2} ÷ (1 + (${value1} ÷ 100))`;
            explanation = `If ${value2} is ${value1}% more than original, original was ${result.toFixed(2)}`;
            break;

        case 'percentage_change':
            if (value1 === 0) {
                alert('Original value cannot be zero for percentage change.');
                return;
            }
            result = ((value2 - value1) / Math.abs(value1)) * 100;
            formula = '((Y - X) ÷ |X|) × 100';
            calculation = `((${value2} - ${value1}) ÷ |${value1}|) × 100`;
            explanation = `Change from ${value1} to ${value2} is ${result.toFixed(2)}% ${result >= 0 ? 'increase' : 'decrease'}`;
            break;
    }

    // Display results
    document.getElementById('resultValue').textContent = operation === 'percentage_of' || operation === 'find_original' ?
        result.toFixed(2) : result.toFixed(2) + '%';
    document.getElementById('resultExplanation').textContent = explanation;
    document.getElementById('formula').textContent = formula;
    document.getElementById('calculation').textContent = calculation;
    document.getElementById('finalResult').textContent = operation === 'percentage_of' || operation === 'find_original' ?
        result.toFixed(2) : result.toFixed(2) + '%';

    document.getElementById('resultsContainer').style.display = 'block';
}

function useExample(operation, val1, val2) {
    document.getElementById('operation').value = operation;
    document.getElementById('value1').value = val1;
    document.getElementById('value2').value = val2;
    updateLabels();
    calculatePercentage();
}

function clearAll() {
    document.getElementById('value1').value = '';
    document.getElementById('value2').value = '';
    document.getElementById('resultsContainer').style.display = 'none';
    document.getElementById('detailedResults').style.display = 'none';
}

function copyResult() {
    const resultValue = document.getElementById('resultValue').textContent;
    const explanation = document.getElementById('resultExplanation').textContent;
    const textToCopy = `${explanation}\\nResult: ${resultValue}`;

    navigator.clipboard.writeText(textToCopy).then(function() {
        // Show success feedback
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="bi bi-check"></i> Copied!';
        button.classList.remove('btn-outline-primary');
        button.classList.add('btn-success');

        setTimeout(function() {
            button.innerHTML = originalText;
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-primary');
        }, 2000);
    });
}

function toggleDetails() {
    const details = document.getElementById('detailedResults');
    const toggle = document.getElementById('details-toggle');

    if (details.style.display === 'none') {
        details.style.display = 'block';
        toggle.textContent = 'Hide Details';
    } else {
        details.style.display = 'none';
        toggle.textContent = 'Show Details';
    }
}

// Initialize labels
updateLabels();

// Auto-calculate when values change
document.getElementById('value1').addEventListener('input', function() {
    if (this.value && document.getElementById('value2').value) {
        calculatePercentage();
    }
});

document.getElementById('value2').addEventListener('input', function() {
    if (this.value && document.getElementById('value1').value) {
        calculatePercentage();
    }
});
</script>
