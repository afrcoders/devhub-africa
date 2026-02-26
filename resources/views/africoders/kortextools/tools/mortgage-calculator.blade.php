<div class="row">
    <div class="col-md-12">
        <!-- Mortgage Input Fields -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label for="homePrice" class="form-label">Home Price</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" id="homePrice" placeholder="400000" step="0.01" min="0">
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="downPayment" class="form-label">Down Payment</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" id="downPayment" placeholder="80000" step="0.01" min="0">
                </div>
                <div class="form-text">
                    <span id="downPaymentPercent">20%</span> of home price
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label for="interestRate" class="form-label">Interest Rate</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="interestRate" placeholder="6.5" step="0.01" min="0">
                    <span class="input-group-text">%</span>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="loanTerm" class="form-label">Loan Term</label>
                <select class="form-select" id="loanTerm">
                    <option value="30" selected>30 Years</option>
                    <option value="15">15 Years</option>
                    <option value="20">20 Years</option>
                    <option value="25">25 Years</option>
                </select>
            </div>
        </div>

        <!-- Additional Costs -->
        <h6 class="mb-3">Additional Monthly Costs (Optional)</h6>
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label for="propertyTax" class="form-label">Property Tax (Annual)</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" id="propertyTax" placeholder="6000" step="0.01" min="0">
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="homeInsurance" class="form-label">Home Insurance (Annual)</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" id="homeInsurance" placeholder="1200" step="0.01" min="0">
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label for="pmi" class="form-label">PMI (Monthly)</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" id="pmi" placeholder="200" step="0.01" min="0">
                </div>
                <div class="form-text">
                    Typically required if down payment < 20%
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="hoaFees" class="form-label">HOA Fees (Monthly)</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" id="hoaFees" placeholder="0" step="0.01" min="0">
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mb-4">
            <button type="button" class="btn btn-primary" onclick="calculateMortgage()">
                <i class="fas fa-home"></i> Calculate Mortgage
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="clearAll()">
                <i class="bi bi-x-circle"></i> Clear
            </button>
            <button type="button" class="btn btn-outline-info" onclick="toggleAffordabilityCalculator()">
                <i class="bi bi-calculator"></i> Affordability Calculator
            </button>
        </div>

        <!-- Results Section -->
        <div id="resultsContainer" style="display: none;">
            <!-- Main Payment Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="text-center p-3 bg-primary text-white rounded">
                        <h5 id="principalInterest" class="mb-1">$0.00</h5>
                        <small>Principal & Interest</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-success text-white rounded">
                        <h5 id="totalMonthlyPayment" class="mb-1">$0.00</h5>
                        <small>Total Monthly Payment</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-info text-white rounded">
                        <h5 id="totalInterest" class="mb-1">$0.00</h5>
                        <small>Total Interest</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-warning text-dark rounded">
                        <h5 id="totalCost" class="mb-1">$0.00</h5>
                        <small>Total Cost</small>
                    </div>
                </div>
            </div>

            <!-- Detailed Breakdown -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Monthly Payment Breakdown</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <td>Principal & Interest</td>
                                        <td class="text-end" id="piDisplay">$0.00</td>
                                    </tr>
                                    <tr>
                                        <td>Property Tax</td>
                                        <td class="text-end" id="taxDisplay">$0.00</td>
                                    </tr>
                                    <tr>
                                        <td>Home Insurance</td>
                                        <td class="text-end" id="insuranceDisplay">$0.00</td>
                                    </tr>
                                    <tr>
                                        <td>PMI</td>
                                        <td class="text-end" id="pmiDisplay">$0.00</td>
                                    </tr>
                                    <tr>
                                        <td>HOA Fees</td>
                                        <td class="text-end" id="hoaDisplay">$0.00</td>
                                    </tr>
                                    <tr class="table-primary fw-bold">
                                        <td><strong>Total Monthly Payment</strong></td>
                                        <td class="text-end" id="totalDisplay"><strong>$0.00</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Loan Summary</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <small class="text-muted">Home Price</small><br>
                                <strong id="homePriceDisplay">$0.00</strong>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">Down Payment</small><br>
                                <strong id="downPaymentDisplay">$0.00</strong>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">Loan Amount</small><br>
                                <strong id="loanAmountDisplay">$0.00</strong>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">Interest Rate</small><br>
                                <strong id="interestRateDisplay">0%</strong>
                            </div>
                            <div>
                                <small class="text-muted">Loan Term</small><br>
                                <strong id="loanTermDisplay">30 years</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Progress Chart -->
            <div class="mb-4">
                <h6>Payment Breakdown Over Time:</h6>
                <div class="payment-chart">
                    <div class="chart-bar">
                        <div class="principal-portion" id="principalPortion"></div>
                        <div class="interest-portion" id="interestPortion"></div>
                    </div>
                    <div class="chart-legend mt-2">
                        <span><i class="bi bi-square-fill text-success"></i> Principal: $<span id="principalAmount">0.00</span></span>
                        <span class="ms-3"><i class="bi bi-square-fill text-danger"></i> Interest: $<span id="interestAmount">0.00</span></span>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="button" class="btn btn-outline-primary" onclick="copyResults()">
                    <i class="bi bi-clipboard"></i> Copy Results
                </button>
                <button type="button" class="btn btn-outline-success" onclick="showAmortization()">
                    <i class="bi bi-table"></i> Show Amortization
                </button>
                <button type="button" class="btn btn-outline-warning" onclick="compareRates()">
                    <i class="bi bi-bar-chart"></i> Compare Rates
                </button>
            </div>
        </div>

        <!-- Affordability Calculator -->
        <div id="affordabilityCalculator" style="display: none;" class="mt-4 p-4 bg-light rounded">
            <h6>What Can I Afford?</h6>
            <div class="row">
                <div class="col-md-4">
                    <label for="monthlyIncome" class="form-label">Monthly Gross Income</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="monthlyIncome" placeholder="8000">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="monthlyDebts" class="form-label">Monthly Debts</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="monthlyDebts" placeholder="500">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="downPaymentPercent" class="form-label">Down Payment %</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="downPaymentPercent" placeholder="20" min="0" max="100">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="button" class="btn btn-info" onclick="calculateAffordability()">
                    Calculate Affordability
                </button>
            </div>
            <div id="affordabilityResults" style="display: none;" class="mt-3">
                <div class="alert alert-info">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Max Home Price:</strong><br>
                            <h5 id="maxHomePrice" class="text-primary">$0.00</h5>
                        </div>
                        <div class="col-md-4">
                            <strong>Max Monthly Payment:</strong><br>
                            <h6 id="maxPayment">$0.00</h6>
                        </div>
                        <div class="col-md-4">
                            <strong>Debt-to-Income Ratio:</strong><br>
                            <h6 id="dtiRatio">0%</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Amortization Schedule -->
        <div id="amortizationTable" style="display: none;" class="mb-4">
            <h6>First Year Amortization Schedule:</h6>
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>Payment #</th>
                            <th>Payment Amount</th>
                            <th>Principal</th>
                            <th>Interest</th>
                            <th>Remaining Balance</th>
                        </tr>
                    </thead>
                    <tbody id="amortizationBody">
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Examples -->
        <div class="mt-4">
            <h6>Quick Examples:</h6>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample(400000, 80000, 6.5, 30)">
                    $400K home, 20% down, 6.5%
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample(300000, 15000, 7.0, 30)">
                    $300K home, 5% down, 7.0%
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample(500000, 100000, 5.8, 15)">
                    $500K home, 20% down, 15-year
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Information -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> About Mortgage Calculations</h6>
    <p class="mb-0">
        This calculator provides estimates for mortgage payments including principal, interest, taxes, insurance, and PMI.
        PMI is typically required when down payment is less than 20%. All calculations are estimates and actual rates and terms may vary.
        Consult with a mortgage professional for precise figures.
    </p>
</div>

<style>
.payment-chart {
    margin: 20px 0;
}

.chart-bar {
    height: 30px;
    background: #f8f9fa;
    border-radius: 15px;
    overflow: hidden;
    display: flex;
}

.principal-portion {
    background: #28a745;
    height: 100%;
    transition: width 0.5s ease;
}

.interest-portion {
    background: #dc3545;
    height: 100%;
    transition: width 0.5s ease;
}

.chart-legend {
    display: flex;
    justify-content: center;
}
</style>

<script>
let currentMortgageCalculation = null;

function calculateMortgage() {
    const homePrice = parseFloat(document.getElementById('homePrice').value);
    const downPayment = parseFloat(document.getElementById('downPayment').value) || 0;
    const interestRate = parseFloat(document.getElementById('interestRate').value) / 100;
    const loanTerm = parseFloat(document.getElementById('loanTerm').value);

    const propertyTax = parseFloat(document.getElementById('propertyTax').value) || 0;
    const homeInsurance = parseFloat(document.getElementById('homeInsurance').value) || 0;
    const pmi = parseFloat(document.getElementById('pmi').value) || 0;
    const hoaFees = parseFloat(document.getElementById('hoaFees').value) || 0;

    if (!homePrice || !interestRate || !loanTerm) {
        alert('Please fill in Home Price, Interest Rate, and Loan Term.');
        return;
    }

    // Calculate loan amount
    const loanAmount = homePrice - downPayment;

    // Calculate monthly payment (P&I)
    const monthlyRate = interestRate / 12;
    const numPayments = loanTerm * 12;
    const monthlyPI = loanAmount * (monthlyRate * Math.pow(1 + monthlyRate, numPayments)) /
                     (Math.pow(1 + monthlyRate, numPayments) - 1);

    // Calculate other monthly costs
    const monthlyTax = propertyTax / 12;
    const monthlyInsurance = homeInsurance / 12;

    // Total monthly payment
    const totalMonthly = monthlyPI + monthlyTax + monthlyInsurance + pmi + hoaFees;

    // Calculate totals
    const totalInterest = (monthlyPI * numPayments) - loanAmount;
    const totalCost = homePrice + totalInterest + (propertyTax * loanTerm) + (homeInsurance * loanTerm) + (pmi * numPayments) + (hoaFees * numPayments);

    // Store calculation
    currentMortgageCalculation = {
        homePrice,
        downPayment,
        loanAmount,
        interestRate,
        loanTerm,
        monthlyPI,
        monthlyTax,
        monthlyInsurance,
        pmi,
        hoaFees,
        totalMonthly,
        totalInterest,
        totalCost,
        numPayments
    };

    displayMortgageResults(currentMortgageCalculation);
    updateDownPaymentPercent();
}

function displayMortgageResults(calc) {
    // Update main cards
    document.getElementById('principalInterest').textContent = '$' + calc.monthlyPI.toFixed(2);
    document.getElementById('totalMonthlyPayment').textContent = '$' + calc.totalMonthly.toFixed(2);
    document.getElementById('totalInterest').textContent = '$' + calc.totalInterest.toFixed(2);
    document.getElementById('totalCost').textContent = '$' + calc.totalCost.toFixed(2);

    // Update breakdown table
    document.getElementById('piDisplay').textContent = '$' + calc.monthlyPI.toFixed(2);
    document.getElementById('taxDisplay').textContent = '$' + calc.monthlyTax.toFixed(2);
    document.getElementById('insuranceDisplay').textContent = '$' + calc.monthlyInsurance.toFixed(2);
    document.getElementById('pmiDisplay').textContent = '$' + calc.pmi.toFixed(2);
    document.getElementById('hoaDisplay').textContent = '$' + calc.hoaFees.toFixed(2);
    document.getElementById('totalDisplay').textContent = '$' + calc.totalMonthly.toFixed(2);

    // Update loan summary
    document.getElementById('homePriceDisplay').textContent = '$' + calc.homePrice.toFixed(2);
    document.getElementById('downPaymentDisplay').textContent = '$' + calc.downPayment.toFixed(2);
    document.getElementById('loanAmountDisplay').textContent = '$' + calc.loanAmount.toFixed(2);
    document.getElementById('interestRateDisplay').textContent = (calc.interestRate * 100).toFixed(2) + '%';
    document.getElementById('loanTermDisplay').textContent = calc.loanTerm + ' years';

    // Update payment chart
    const principalPercent = (calc.loanAmount / (calc.loanAmount + calc.totalInterest)) * 100;
    const interestPercent = 100 - principalPercent;

    document.getElementById('principalPortion').style.width = principalPercent + '%';
    document.getElementById('interestPortion').style.width = interestPercent + '%';
    document.getElementById('principalAmount').textContent = calc.loanAmount.toFixed(2);
    document.getElementById('interestAmount').textContent = calc.totalInterest.toFixed(2);

    document.getElementById('resultsContainer').style.display = 'block';
}

function updateDownPaymentPercent() {
    const homePrice = parseFloat(document.getElementById('homePrice').value) || 0;
    const downPayment = parseFloat(document.getElementById('downPayment').value) || 0;

    if (homePrice > 0) {
        const percent = (downPayment / homePrice) * 100;
        document.getElementById('downPaymentPercent').textContent = percent.toFixed(1) + '%';

        // Auto-calculate PMI if down payment < 20%
        if (percent < 20 && downPayment > 0) {
            const estimatedPMI = (homePrice - downPayment) * 0.005 / 12; // 0.5% annually
            if (!document.getElementById('pmi').value) {
                document.getElementById('pmi').value = estimatedPMI.toFixed(0);
            }
        }
    }
}

function toggleAffordabilityCalculator() {
    const calculator = document.getElementById('affordabilityCalculator');
    calculator.style.display = calculator.style.display === 'none' ? 'block' : 'none';
}

function calculateAffordability() {
    const monthlyIncome = parseFloat(document.getElementById('monthlyIncome').value);
    const monthlyDebts = parseFloat(document.getElementById('monthlyDebts').value) || 0;
    const downPaymentPercent = parseFloat(document.getElementById('downPaymentPercent').value) || 20;

    if (!monthlyIncome) {
        alert('Please enter your monthly income.');
        return;
    }

    // Use 28% rule for housing and 36% rule for total debt
    const maxHousingPayment = monthlyIncome * 0.28;
    const maxTotalDebtPayment = monthlyIncome * 0.36;
    const maxPaymentBasedOnDebt = maxTotalDebtPayment - monthlyDebts;

    // Use the lower of the two
    const maxPayment = Math.min(maxHousingPayment, maxPaymentBasedOnDebt);

    // Estimate max home price (assuming 6.5% interest, 30 years, including taxes/insurance)
    const estimatedRate = 0.065 / 12; // 6.5% monthly
    const numPayments = 30 * 12;
    const piPayment = maxPayment * 0.8; // Assume 80% of payment is P&I

    const maxLoanAmount = piPayment * (Math.pow(1 + estimatedRate, numPayments) - 1) /
                         (estimatedRate * Math.pow(1 + estimatedRate, numPayments));

    const maxHomePrice = maxLoanAmount / (1 - (downPaymentPercent / 100));

    const dtiRatio = ((maxPayment + monthlyDebts) / monthlyIncome) * 100;

    // Display results
    document.getElementById('maxHomePrice').textContent = '$' + maxHomePrice.toFixed(0);
    document.getElementById('maxPayment').textContent = '$' + maxPayment.toFixed(0);
    document.getElementById('dtiRatio').textContent = dtiRatio.toFixed(1) + '%';

    document.getElementById('affordabilityResults').style.display = 'block';
}

function showAmortization() {
    if (!currentMortgageCalculation) return;

    const calc = currentMortgageCalculation;
    const tableBody = document.getElementById('amortizationBody');
    tableBody.innerHTML = '';

    let balance = calc.loanAmount;
    const monthlyRate = calc.interestRate / 12;

    // Show first 12 payments
    for (let month = 1; month <= 12; month++) {
        const interestPayment = balance * monthlyRate;
        const principalPayment = calc.monthlyPI - interestPayment;
        balance -= principalPayment;

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${month}</td>
            <td>$${calc.monthlyPI.toFixed(2)}</td>
            <td>$${principalPayment.toFixed(2)}</td>
            <td>$${interestPayment.toFixed(2)}</td>
            <td>$${balance.toFixed(2)}</td>
        `;
        tableBody.appendChild(row);
    }

    document.getElementById('amortizationTable').style.display = 'block';
}

function useExample(homePrice, downPayment, rate, term) {
    document.getElementById('homePrice').value = homePrice;
    document.getElementById('downPayment').value = downPayment;
    document.getElementById('interestRate').value = rate;
    document.getElementById('loanTerm').value = term;
    calculateMortgage();
}

function clearAll() {
    document.getElementById('homePrice').value = '';
    document.getElementById('downPayment').value = '';
    document.getElementById('interestRate').value = '';
    document.getElementById('loanTerm').value = '30';
    document.getElementById('propertyTax').value = '';
    document.getElementById('homeInsurance').value = '';
    document.getElementById('pmi').value = '';
    document.getElementById('hoaFees').value = '';

    document.getElementById('resultsContainer').style.display = 'none';
    document.getElementById('amortizationTable').style.display = 'none';
    document.getElementById('affordabilityCalculator').style.display = 'none';

    currentMortgageCalculation = null;
}

function copyResults() {
    if (!currentMortgageCalculation) return;

    const calc = currentMortgageCalculation;
    const textToCopy = `Mortgage Calculator Results:
Home Price: $${calc.homePrice.toFixed(2)}
Down Payment: $${calc.downPayment.toFixed(2)}
Loan Amount: $${calc.loanAmount.toFixed(2)}
Interest Rate: ${(calc.interestRate * 100).toFixed(2)}%
Monthly Payment (P&I): $${calc.monthlyPI.toFixed(2)}
Total Monthly Payment: $${calc.totalMonthly.toFixed(2)}
Total Interest: $${calc.totalInterest.toFixed(2)}`;

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

function compareRates() {
    alert('Rate comparison tool would show payments at different interest rates.');
}

// Auto-update down payment percentage
document.getElementById('homePrice').addEventListener('input', updateDownPaymentPercent);
document.getElementById('downPayment').addEventListener('input', updateDownPaymentPercent);

// Auto-calculate when values change (with debounce)
let calculateTimeout;
function debounceCalculate() {
    clearTimeout(calculateTimeout);
    calculateTimeout = setTimeout(() => {
        const homePrice = document.getElementById('homePrice').value;
        const interestRate = document.getElementById('interestRate').value;
        const loanTerm = document.getElementById('loanTerm').value;

        if (homePrice && interestRate && loanTerm) {
            calculateMortgage();
        }
    }, 500);
}

// Add event listeners
document.getElementById('homePrice').addEventListener('input', debounceCalculate);
document.getElementById('interestRate').addEventListener('input', debounceCalculate);
document.getElementById('loanTerm').addEventListener('change', debounceCalculate);
</script>
