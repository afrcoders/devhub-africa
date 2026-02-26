<div class="row">
    <div class="col-md-12">
        <!-- Tax Calculator Type Selection -->
        <div class="mb-4">
            <h6>Calculator Type:</h6>
            <div class="btn-group" role="group" aria-label="Calculator Type">
                <input type="radio" class="btn-check" name="taxType" id="incomeTax" value="income" checked>
                <label class="btn btn-outline-primary" for="incomeTax">Income Tax</label>

                <input type="radio" class="btn-check" name="taxType" id="propertyTax" value="property">
                <label class="btn btn-outline-primary" for="propertyTax">Property Tax</label>

                <input type="radio" class="btn-check" name="taxType" id="capitalGains" value="capital">
                <label class="btn btn-outline-primary" for="capitalGains">Capital Gains</label>
            </div>
        </div>

        <!-- Income Tax Calculator -->
        <div id="incomeTaxSection" class="tax-calculator-section">
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="annualIncome" class="form-label">Annual Income</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="annualIncome" placeholder="75000" step="0.01" min="0">
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="filingStatus" class="form-label">Filing Status</label>
                    <select class="form-select" id="filingStatus">
                        <option value="single" selected>Single</option>
                        <option value="marriedJoint">Married Filing Jointly</option>
                        <option value="marriedSeparate">Married Filing Separately</option>
                        <option value="headOfHousehold">Head of Household</option>
                    </select>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="deductionType" class="form-label">Deduction Type</label>
                    <select class="form-select" id="deductionType">
                        <option value="standard" selected>Standard Deduction</option>
                        <option value="itemized">Itemized Deduction</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="itemizedAmount" class="form-label">Itemized Deduction Amount</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="itemizedAmount" placeholder="0" step="0.01" min="0" disabled>
                    </div>
                </div>
            </div>
        </div>

        <!-- Property Tax Calculator -->
        <div id="propertyTaxSection" class="tax-calculator-section" style="display: none;">
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="homeValue" class="form-label">Home Value</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="homeValue" placeholder="350000" step="0.01" min="0">
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="taxRate" class="form-label">Tax Rate</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="taxRate" placeholder="1.2" step="0.01" min="0">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="assessedValue" class="form-label">Assessed Value (% of Market Value)</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="assessedValue" placeholder="80" step="0.1" min="0" max="100">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="exemptions" class="form-label">Exemptions</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="exemptions" placeholder="50000" step="0.01" min="0">
                    </div>
                </div>
            </div>
        </div>

        <!-- Capital Gains Tax Calculator -->
        <div id="capitalGainsSection" class="tax-calculator-section" style="display: none;">
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="purchasePrice" class="form-label">Purchase Price</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="purchasePrice" placeholder="100000" step="0.01" min="0">
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="salePrice" class="form-label">Sale Price</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="salePrice" placeholder="150000" step="0.01" min="0">
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="holdingPeriod" class="form-label">Holding Period</label>
                    <select class="form-select" id="holdingPeriod">
                        <option value="short">Short-term (≤ 1 year)</option>
                        <option value="long" selected>Long-term (> 1 year)</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="improvementCosts" class="form-label">Improvement Costs</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="improvementCosts" placeholder="0" step="0.01" min="0">
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mb-4">
            <button type="button" class="btn btn-primary" onclick="calculateTax()">
                <i class="fas fa-calculator"></i> Calculate Tax
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="clearAll()">
                <i class="bi bi-x-circle"></i> Clear
            </button>
            <button type="button" class="btn btn-outline-info" onclick="showTaxBrackets()">
                <i class="bi bi-table"></i> Tax Brackets
            </button>
        </div>

        <!-- Results Section -->
        <div id="resultsContainer" style="display: none;">
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="text-center p-3 bg-primary text-white rounded">
                        <h5 id="taxableAmount" class="mb-1">$0.00</h5>
                        <small>Taxable Amount</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-danger text-white rounded">
                        <h5 id="taxOwed" class="mb-1">$0.00</h5>
                        <small>Tax Owed</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-success text-white rounded">
                        <h5 id="afterTaxAmount" class="mb-1">$0.00</h5>
                        <small>After-Tax Amount</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-warning text-dark rounded">
                        <h5 id="effectiveTaxRate" class="mb-1">0%</h5>
                        <small>Effective Tax Rate</small>
                    </div>
                </div>
            </div>

            <!-- Tax Breakdown -->
            <div class="table-responsive mb-4">
                <table class="table table-striped">
                    <tbody id="taxBreakdownBody">
                        <!-- Will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>

            <!-- Tax Brackets Breakdown (for income tax) -->
            <div id="bracketsBreakdown" style="display: none;" class="mb-4">
                <h6>Tax Brackets Breakdown:</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Tax Bracket</th>
                                <th>Rate</th>
                                <th>Income in Bracket</th>
                                <th>Tax on Bracket</th>
                            </tr>
                        </thead>
                        <tbody id="bracketsBreakdownBody">
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">
                <button type="button" class="btn btn-outline-primary" onclick="copyResults()">
                    <i class="bi bi-clipboard"></i> Copy Results
                </button>
                <button type="button" class="btn btn-outline-success" onclick="generateReport()">
                    <i class="bi bi-file-text"></i> Generate Report
                </button>
                <button type="button" class="btn btn-outline-warning" onclick="showTaxStrategies()">
                    <i class="bi bi-lightbulb"></i> Tax Strategies
                </button>
            </div>
        </div>

        <!-- Tax Brackets Reference -->
        <div id="taxBracketsModal" style="display: none;" class="mt-4 p-4 bg-light rounded">
            <h6>2024 Federal Tax Brackets (Single Filers):</h6>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Tax Rate</th>
                            <th>Income Range</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>10%</td><td>$0 - $11,000</td></tr>
                        <tr><td>12%</td><td>$11,001 - $44,725</td></tr>
                        <tr><td>22%</td><td>$44,726 - $95,375</td></tr>
                        <tr><td>24%</td><td>$95,376 - $182,050</td></tr>
                        <tr><td>32%</td><td>$182,051 - $231,250</td></tr>
                        <tr><td>35%</td><td>$231,251 - $578,125</td></tr>
                        <tr><td>37%</td><td>$578,126+</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <button type="button" class="btn btn-secondary" onclick="hideTaxBrackets()">Close</button>
                <small class="text-muted ms-3">*2024 tax year brackets for reference</small>
            </div>
        </div>

        <!-- Quick Examples -->
        <div class="mt-4">
            <h6>Quick Examples:</h6>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useIncomeExample(75000, 'single')">
                    $75K Single Filer
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="usePropertyExample(350000, 1.2)">
                    $350K Home @ 1.2%
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useCapitalExample(100000, 150000, 'long')">
                    $50K Long-term Gain
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Information -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> About Tax Calculations</h6>
    <p class="mb-0">
        This calculator provides estimates for educational purposes. Tax laws are complex and change frequently.
        Results may not account for all deductions, credits, or specific circumstances.
        Please consult a tax professional for accurate tax planning and preparation.
    </p>
</div>

<style>
.tax-calculator-section {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    background-color: #f8f9fa;
}
</style>

<script>
let currentTaxCalculation = null;

// 2024 Tax Brackets (simplified)
const taxBrackets = {
    single: [
        { min: 0, max: 11000, rate: 0.10 },
        { min: 11001, max: 44725, rate: 0.12 },
        { min: 44726, max: 95375, rate: 0.22 },
        { min: 95376, max: 182050, rate: 0.24 },
        { min: 182051, max: 231250, rate: 0.32 },
        { min: 231251, max: 578125, rate: 0.35 },
        { min: 578126, max: Infinity, rate: 0.37 }
    ],
    marriedJoint: [
        { min: 0, max: 22000, rate: 0.10 },
        { min: 22001, max: 89450, rate: 0.12 },
        { min: 89451, max: 190750, rate: 0.22 },
        { min: 190751, max: 364200, rate: 0.24 },
        { min: 364201, max: 462500, rate: 0.32 },
        { min: 462501, max: 693750, rate: 0.35 },
        { min: 693751, max: Infinity, rate: 0.37 }
    ]
};

const standardDeductions = {
    single: 13850,
    marriedJoint: 27700,
    marriedSeparate: 13850,
    headOfHousehold: 20800
};

// Handle tax type changes
document.querySelectorAll('input[name="taxType"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.tax-calculator-section').forEach(section => {
            section.style.display = 'none';
        });

        switch(this.value) {
            case 'income':
                document.getElementById('incomeTaxSection').style.display = 'block';
                break;
            case 'property':
                document.getElementById('propertyTaxSection').style.display = 'block';
                break;
            case 'capital':
                document.getElementById('capitalGainsSection').style.display = 'block';
                break;
        }
    });
});

// Handle deduction type change
document.getElementById('deductionType').addEventListener('change', function() {
    const itemizedAmount = document.getElementById('itemizedAmount');
    itemizedAmount.disabled = this.value === 'standard';
    if (this.value === 'standard') {
        itemizedAmount.value = '';
    }
});

function calculateTax() {
    const taxType = document.querySelector('input[name="taxType"]:checked').value;

    switch(taxType) {
        case 'income':
            calculateIncomeTax();
            break;
        case 'property':
            calculatePropertyTax();
            break;
        case 'capital':
            calculateCapitalGainsTax();
            break;
    }
}

function calculateIncomeTax() {
    const annualIncome = parseFloat(document.getElementById('annualIncome').value);
    const filingStatus = document.getElementById('filingStatus').value;
    const deductionType = document.getElementById('deductionType').value;
    const itemizedAmount = parseFloat(document.getElementById('itemizedAmount').value) || 0;

    if (!annualIncome) {
        alert('Please enter your annual income.');
        return;
    }

    const standardDeduction = standardDeductions[filingStatus] || standardDeductions.single;
    const deduction = deductionType === 'standard' ? standardDeduction : Math.max(itemizedAmount, standardDeduction);
    const taxableIncome = Math.max(0, annualIncome - deduction);

    const brackets = taxBrackets[filingStatus] || taxBrackets.single;
    const taxCalculation = calculateProgressiveTax(taxableIncome, brackets);

    currentTaxCalculation = {
        type: 'income',
        grossIncome: annualIncome,
        deduction: deduction,
        taxableAmount: taxableIncome,
        taxOwed: taxCalculation.totalTax,
        afterTaxAmount: annualIncome - taxCalculation.totalTax,
        effectiveRate: (taxCalculation.totalTax / annualIncome) * 100,
        brackets: taxCalculation.brackets,
        filingStatus
    };

    displayTaxResults(currentTaxCalculation);
}

function calculatePropertyTax() {
    const homeValue = parseFloat(document.getElementById('homeValue').value);
    const taxRate = parseFloat(document.getElementById('taxRate').value) / 100;
    const assessedPercent = parseFloat(document.getElementById('assessedValue').value) / 100 || 1;
    const exemptions = parseFloat(document.getElementById('exemptions').value) || 0;

    if (!homeValue || !taxRate) {
        alert('Please enter home value and tax rate.');
        return;
    }

    const assessedValue = homeValue * assessedPercent;
    const taxableValue = Math.max(0, assessedValue - exemptions);
    const annualTax = taxableValue * taxRate;
    const monthlyTax = annualTax / 12;

    currentTaxCalculation = {
        type: 'property',
        homeValue: homeValue,
        assessedValue: assessedValue,
        exemptions: exemptions,
        taxableAmount: taxableValue,
        taxOwed: annualTax,
        monthlyTax: monthlyTax,
        effectiveRate: (annualTax / homeValue) * 100,
        taxRate: taxRate * 100
    };

    displayTaxResults(currentTaxCalculation);
}

function calculateCapitalGainsTax() {
    const purchasePrice = parseFloat(document.getElementById('purchasePrice').value);
    const salePrice = parseFloat(document.getElementById('salePrice').value);
    const holdingPeriod = document.getElementById('holdingPeriod').value;
    const improvementCosts = parseFloat(document.getElementById('improvementCosts').value) || 0;

    if (!purchasePrice || !salePrice) {
        alert('Please enter purchase price and sale price.');
        return;
    }

    const adjustedBasis = purchasePrice + improvementCosts;
    const capitalGain = Math.max(0, salePrice - adjustedBasis);

    // Simplified tax rates
    const taxRate = holdingPeriod === 'short' ? 0.22 : 0.15; // Simplified rates
    const taxOwed = capitalGain * taxRate;
    const afterTaxGain = capitalGain - taxOwed;
    const totalProceeds = salePrice - taxOwed;

    currentTaxCalculation = {
        type: 'capital',
        purchasePrice: purchasePrice,
        salePrice: salePrice,
        improvementCosts: improvementCosts,
        adjustedBasis: adjustedBasis,
        taxableAmount: capitalGain,
        taxOwed: taxOwed,
        afterTaxAmount: totalProceeds,
        effectiveRate: capitalGain > 0 ? (taxOwed / capitalGain) * 100 : 0,
        holdingPeriod: holdingPeriod,
        taxRate: taxRate * 100
    };

    displayTaxResults(currentTaxCalculation);
}

function calculateProgressiveTax(income, brackets) {
    let totalTax = 0;
    let bracketsUsed = [];

    for (const bracket of brackets) {
        if (income <= bracket.min) break;

        const taxableInThisBracket = Math.min(income, bracket.max) - bracket.min + 1;
        const taxOnBracket = taxableInThisBracket * bracket.rate;

        totalTax += taxOnBracket;
        bracketsUsed.push({
            ...bracket,
            taxableIncome: taxableInThisBracket,
            tax: taxOnBracket
        });

        if (income <= bracket.max) break;
    }

    return { totalTax, brackets: bracketsUsed };
}

function displayTaxResults(calc) {
    // Update main cards
    document.getElementById('taxableAmount').textContent = '$' + calc.taxableAmount.toFixed(2);
    document.getElementById('taxOwed').textContent = '$' + calc.taxOwed.toFixed(2);
    document.getElementById('afterTaxAmount').textContent = '$' + calc.afterTaxAmount.toFixed(2);
    document.getElementById('effectiveRate').textContent = calc.effectiveRate.toFixed(2) + '%';

    // Update breakdown table
    const tableBody = document.getElementById('taxBreakdownBody');
    tableBody.innerHTML = '';

    const rows = [];

    switch(calc.type) {
        case 'income':
            rows.push(['Gross Income', '$' + calc.grossIncome.toFixed(2)]);
            rows.push(['Deduction', '-$' + calc.deduction.toFixed(2)]);
            rows.push(['Taxable Income', '$' + calc.taxableAmount.toFixed(2)]);
            rows.push(['Federal Tax Owed', '$' + calc.taxOwed.toFixed(2)]);
            rows.push(['After-Tax Income', '$' + calc.afterTaxAmount.toFixed(2)]);
            rows.push(['Effective Tax Rate', calc.effectiveRate.toFixed(2) + '%']);

            // Show brackets breakdown
            if (calc.brackets) {
                displayBracketsBreakdown(calc.brackets);
            }
            break;

        case 'property':
            rows.push(['Home Value', '$' + calc.homeValue.toFixed(2)]);
            rows.push(['Assessed Value', '$' + calc.assessedValue.toFixed(2)]);
            rows.push(['Exemptions', '-$' + calc.exemptions.toFixed(2)]);
            rows.push(['Taxable Value', '$' + calc.taxableAmount.toFixed(2)]);
            rows.push(['Tax Rate', calc.taxRate.toFixed(2) + '%']);
            rows.push(['Annual Property Tax', '$' + calc.taxOwed.toFixed(2)]);
            rows.push(['Monthly Property Tax', '$' + calc.monthlyTax.toFixed(2)]);
            break;

        case 'capital':
            rows.push(['Sale Price', '$' + calc.salePrice.toFixed(2)]);
            rows.push(['Purchase Price', '$' + calc.purchasePrice.toFixed(2)]);
            rows.push(['Improvement Costs', '$' + calc.improvementCosts.toFixed(2)]);
            rows.push(['Adjusted Basis', '$' + calc.adjustedBasis.toFixed(2)]);
            rows.push(['Capital Gain', '$' + calc.taxableAmount.toFixed(2)]);
            rows.push(['Tax Rate (' + calc.holdingPeriod + '-term)', calc.taxRate.toFixed(1) + '%']);
            rows.push(['Capital Gains Tax', '$' + calc.taxOwed.toFixed(2)]);
            rows.push(['After-Tax Proceeds', '$' + calc.afterTaxAmount.toFixed(2)]);
            break;
    }

    rows.forEach(([label, value], index) => {
        const row = document.createElement('tr');
        if (index === rows.length - 2) row.classList.add('table-warning');
        if (index === rows.length - 1) row.classList.add('table-success');

        row.innerHTML = `<th width="40%">${label}</th><td><strong>${value}</strong></td>`;
        tableBody.appendChild(row);
    });

    document.getElementById('resultsContainer').style.display = 'block';
}

function displayBracketsBreakdown(brackets) {
    const bracketsBody = document.getElementById('bracketsBreakdownBody');
    bracketsBody.innerHTML = '';

    brackets.forEach(bracket => {
        const row = document.createElement('tr');
        const maxDisplay = bracket.max === Infinity ? '+' : bracket.max.toLocaleString();
        row.innerHTML = `
            <td>$${bracket.min.toLocaleString()} - $${maxDisplay}</td>
            <td>${(bracket.rate * 100).toFixed(0)}%</td>
            <td>$${bracket.taxableIncome.toFixed(2)}</td>
            <td>$${bracket.tax.toFixed(2)}</td>
        `;
        bracketsBody.appendChild(row);
    });

    document.getElementById('bracketsBreakdown').style.display = 'block';
}

function showTaxBrackets() {
    document.getElementById('taxBracketsModal').style.display = 'block';
}

function hideTaxBrackets() {
    document.getElementById('taxBracketsModal').style.display = 'none';
}

function useIncomeExample(income, status) {
    document.getElementById('incomeTax').checked = true;
    document.querySelector('input[value="income"]').dispatchEvent(new Event('change'));
    document.getElementById('annualIncome').value = income;
    document.getElementById('filingStatus').value = status;
    document.getElementById('deductionType').value = 'standard';
    calculateTax();
}

function usePropertyExample(value, rate) {
    document.getElementById('propertyTax').checked = true;
    document.querySelector('input[value="property"]').dispatchEvent(new Event('change'));
    document.getElementById('homeValue').value = value;
    document.getElementById('taxRate').value = rate;
    document.getElementById('assessedValue').value = 80;
    calculateTax();
}

function useCapitalExample(purchase, sale, period) {
    document.getElementById('capitalGains').checked = true;
    document.querySelector('input[value="capital"]').dispatchEvent(new Event('change'));
    document.getElementById('purchasePrice').value = purchase;
    document.getElementById('salePrice').value = sale;
    document.getElementById('holdingPeriod').value = period;
    calculateTax();
}

function clearAll() {
    // Clear all inputs
    document.querySelectorAll('input[type="number"]').forEach(input => input.value = '');
    document.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

    // Reset to income tax
    document.getElementById('incomeTax').checked = true;
    document.querySelectorAll('.tax-calculator-section').forEach(section => {
        section.style.display = 'none';
    });
    document.getElementById('incomeTaxSection').style.display = 'block';

    // Hide results
    document.getElementById('resultsContainer').style.display = 'none';
    document.getElementById('bracketsBreakdown').style.display = 'none';
    document.getElementById('taxBracketsModal').style.display = 'none';

    // Enable/disable itemized deduction
    document.getElementById('itemizedAmount').disabled = true;

    currentTaxCalculation = null;
}

function copyResults() {
    if (!currentTaxCalculation) return;

    const calc = currentTaxCalculation;
    const textToCopy = `Tax Calculation Results:
Type: ${calc.type.charAt(0).toUpperCase() + calc.type.slice(1)} Tax
Taxable Amount: $${calc.taxableAmount.toFixed(2)}
Tax Owed: $${calc.taxOwed.toFixed(2)}
After-Tax Amount: $${calc.afterTaxAmount.toFixed(2)}
Effective Tax Rate: ${calc.effectiveRate.toFixed(2)}%`;

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

function generateReport() {
    alert('Tax report generation would create a detailed PDF with calculations and strategies.');
}

function showTaxStrategies() {
    alert('Tax strategies: Maximize deductions, contribute to retirement accounts, consider timing of capital gains, keep detailed records.');
}
</script>
