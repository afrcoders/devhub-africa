<div class="row">
    <div class="col-md-12">
        <!-- Loan Input Fields -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label for="loanAmount" class="form-label">Loan Amount</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" id="loanAmount" placeholder="250000" step="0.01" min="0">
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="interestRate" class="form-label">Annual Interest Rate</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="interestRate" placeholder="4.5" step="0.01" min="0">
                    <span class="input-group-text">%</span>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label for="loanTerm" class="form-label">Loan Term</label>
                <input type="number" class="form-control" id="loanTerm" placeholder="30" step="1" min="0">
            </div>
            <div class="col-md-6 mb-3">
                <label for="termUnit" class="form-label">Term Unit</label>
                <select class="form-select" id="termUnit">
                    <option value="years" selected>Years</option>
                    <option value="months">Months</option>
                </select>
            </div>
        </div>

        <!-- Optional Fields -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label for="downPayment" class="form-label">Down Payment (Optional)</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" id="downPayment" placeholder="0" step="0.01" min="0">
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="extraPayment" class="form-label">Extra Monthly Payment (Optional)</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" id="extraPayment" placeholder="0" step="0.01" min="0">
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mb-4">
            <button type="button" class="btn btn-primary" onclick="calculateLoan()">
                <i class="fas fa-calculator"></i> Calculate Loan
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="clearAll()">
                <i class="bi bi-x-circle"></i> Clear
            </button>
            <button type="button" class="btn btn-outline-info" onclick="showAmortization()">
                <i class="bi bi-table"></i> Show Amortization
            </button>
        </div>

        <!-- Results Section -->
        <div id="resultsContainer" style="display: none;">
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="text-center p-3 bg-primary text-white rounded">
                        <h5 id="monthlyPayment" class="mb-1">$0.00</h5>
                        <small>Monthly Payment</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-success text-white rounded">
                        <h5 id="totalInterest" class="mb-1">$0.00</h5>
                        <small>Total Interest</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-info text-white rounded">
                        <h5 id="totalPayments" class="mb-1">$0.00</h5>
                        <small>Total Payments</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-warning text-dark rounded">
                        <h5 id="payoffTime" class="mb-1">0 years</h5>
                        <small>Payoff Time</small>
                    </div>
                </div>
            </div>

            <!-- Loan Summary -->
            <div class="table-responsive mb-4">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th width="40%">Loan Amount</th>
                            <td id="loanAmountDisplay">$0.00</td>
                        </tr>
                        <tr>
                            <th>Down Payment</th>
                            <td id="downPaymentDisplay">$0.00</td>
                        </tr>
                        <tr>
                            <th>Amount Financed</th>
                            <td id="amountFinancedDisplay">$0.00</td>
                        </tr>
                        <tr>
                            <th>Interest Rate</th>
                            <td id="interestRateDisplay">0% APR</td>
                        </tr>
                        <tr>
                            <th>Loan Term</th>
                            <td id="loanTermDisplay">0 years</td>
                        </tr>
                        <tr>
                            <th>Extra Payment</th>
                            <td id="extraPaymentDisplay">$0.00/month</td>
                        </tr>
                        <tr class="table-primary">
                            <th><strong>Monthly Payment (P&I)</strong></th>
                            <td><strong id="monthlyPaymentDisplay">$0.00</strong></td>
                        </tr>
                        <tr>
                            <th>Total of Payments</th>
                            <td id="totalPaymentsDisplay">$0.00</td>
                        </tr>
                        <tr>
                            <th>Total Interest Paid</th>
                            <td id="totalInterestDisplay">$0.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Extra Payment Benefits -->
            <div id="extraPaymentBenefits" style="display: none;" class="mb-4">
                <div class="alert alert-success">
                    <h6><i class="bi bi-piggy-bank"></i> Extra Payment Benefits:</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div><strong>Interest Savings:</strong> $<span id="interestSavings">0.00</span></div>
                            <div><strong>Time Savings:</strong> <span id="timeSavings">0 years</span></div>
                        </div>
                        <div class="col-md-6">
                            <div><strong>New Payoff Time:</strong> <span id="newPayoffTime">0 years</span></div>
                            <div><strong>Monthly Savings:</strong> $<span id="monthlySavings">0.00</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loan Breakdown Chart -->
            <div class="mb-4">
                <h6>Payment Breakdown:</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="payment-breakdown">
                            <div class="breakdown-item">
                                <div class="breakdown-bar" style="width: 100%; background: linear-gradient(to right, #28a745 0%, #28a745 50%, #dc3545 50%, #dc3545 100%);">
                                    <span class="breakdown-label">Principal vs Interest</span>
                                </div>
                                <div class="breakdown-details mt-2">
                                    <div class="d-flex justify-content-between">
                                        <span><i class="bi bi-square-fill text-success"></i> Principal: $<span id="principalTotal">0.00</span></span>
                                        <span><i class="bi bi-square-fill text-danger"></i> Interest: $<span id="interestTotal">0.00</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="costBreakdown" class="cost-breakdown">
                            <!-- Will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="button" class="btn btn-outline-primary" onclick="copyResults()">
                    <i class="bi bi-clipboard"></i> Copy Results
                </button>
                <button type="button" class="btn btn-outline-success" onclick="generateReport()">
                    <i class="bi bi-file-text"></i> Generate Report
                </button>
                <button type="button" class="btn btn-outline-warning" onclick="compareOptions()">
                    <i class="bi bi-bar-chart"></i> Compare Options
                </button>
            </div>
        </div>

        <!-- Amortization Schedule -->
        <div id="amortizationTable" style="display: none;" class="mb-4">
            <h6>Amortization Schedule:</h6>
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>Payment #</th>
                            <th>Payment Amount</th>
                            <th>Principal</th>
                            <th>Interest</th>
                            <th>Extra Payment</th>
                            <th>Remaining Balance</th>
                        </tr>
                    </thead>
                    <tbody id="amortizationBody">
                    </tbody>
                </table>
            </div>
            <div class="text-muted small mt-2">
                <em>Showing first 12 months. Full schedule available in generated report.</em>
            </div>
        </div>

        <!-- Quick Examples -->
        <div class="mt-4">
            <h6>Quick Examples:</h6>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample(250000, 4.5, 30, 0, 0)">
                    $250K @ 4.5% for 30 years
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample(350000, 3.8, 15, 70000, 0)">
                    $350K @ 3.8% for 15 years (20% down)
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample(200000, 5.2, 30, 0, 200)">
                    $200K @ 5.2% + $200 extra/month
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Information -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> About Loan Calculations</h6>
    <p class="mb-0">
        This calculator uses the standard loan formula to compute monthly payments for fixed-rate loans.
        It includes options for down payments and extra payments, showing you how these can significantly
        reduce total interest paid and loan term. All calculations assume payments are made at the end of each period.
    </p>
</div>

<style>
.payment-breakdown {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
}

.breakdown-bar {
    height: 30px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 0.8rem;
}

.cost-breakdown {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
}

.cost-item {
    display: flex;
    justify-content: between;
    margin-bottom: 8px;
}
</style>

<script>
let currentCalculation = null;

function calculateLoan() {
    const loanAmount = parseFloat(document.getElementById('loanAmount').value);
    const interestRate = parseFloat(document.getElementById('interestRate').value) / 100;
    const loanTerm = parseFloat(document.getElementById('loanTerm').value);
    const termUnit = document.getElementById('termUnit').value;
    const downPayment = parseFloat(document.getElementById('downPayment').value) || 0;
    const extraPayment = parseFloat(document.getElementById('extraPayment').value) || 0;

    if (!loanAmount || !interestRate || !loanTerm) {
        alert('Please fill in Loan Amount, Interest Rate, and Loan Term.');
        return;
    }

    // Convert term to months
    const termInMonths = termUnit === 'years' ? loanTerm * 12 : loanTerm;

    // Calculate amount financed
    const amountFinanced = loanAmount - downPayment;

    // Calculate monthly payment using loan formula
    const monthlyRate = interestRate / 12;
    const monthlyPayment = amountFinanced * (monthlyRate * Math.pow(1 + monthlyRate, termInMonths)) /
                          (Math.pow(1 + monthlyRate, termInMonths) - 1);

    // Calculate totals without extra payments
    const totalPayments = monthlyPayment * termInMonths;
    const totalInterest = totalPayments - amountFinanced;

    // Calculate with extra payments if provided
    let payoffTimeWithExtra = termInMonths;
    let totalInterestWithExtra = totalInterest;
    let totalPaymentsWithExtra = totalPayments;

    if (extraPayment > 0) {
        const result = calculateWithExtraPayments(amountFinanced, monthlyRate, monthlyPayment, extraPayment);
        payoffTimeWithExtra = result.months;
        totalInterestWithExtra = result.totalInterest;
        totalPaymentsWithExtra = result.totalPayments;
    }

    // Store calculation
    currentCalculation = {
        loanAmount,
        downPayment,
        amountFinanced,
        interestRate,
        loanTerm,
        termUnit,
        termInMonths,
        extraPayment,
        monthlyPayment,
        totalPayments,
        totalInterest,
        payoffTimeWithExtra,
        totalInterestWithExtra,
        totalPaymentsWithExtra
    };

    displayResults(currentCalculation);
}

function calculateWithExtraPayments(principal, monthlyRate, payment, extraPayment) {
    let balance = principal;
    let totalInterest = 0;
    let totalPayments = 0;
    let month = 0;

    while (balance > 0.01 && month < 600) { // Max 50 years
        month++;
        const interestPayment = balance * monthlyRate;
        let principalPayment = payment - interestPayment + extraPayment;

        if (principalPayment > balance) {
            principalPayment = balance;
        }

        balance -= principalPayment;
        totalInterest += interestPayment;
        totalPayments += principalPayment + interestPayment;
    }

    return {
        months: month,
        totalInterest: totalInterest,
        totalPayments: totalPayments
    };
}

function displayResults(calc) {
    const termDisplay = calc.termUnit === 'years' ?
        calc.loanTerm + ' year' + (calc.loanTerm !== 1 ? 's' : '') :
        calc.loanTerm + ' month' + (calc.loanTerm !== 1 ? 's' : '');

    // Update main cards
    document.getElementById('monthlyPayment').textContent = '$' + calc.monthlyPayment.toFixed(2);
    document.getElementById('totalInterest').textContent = '$' + calc.totalInterestWithExtra.toFixed(2);
    document.getElementById('totalPayments').textContent = '$' + calc.totalPaymentsWithExtra.toFixed(2);
    document.getElementById('payoffTime').textContent = (calc.payoffTimeWithExtra / 12).toFixed(1) + ' years';

    // Update detailed table
    document.getElementById('loanAmountDisplay').textContent = '$' + calc.loanAmount.toFixed(2);
    document.getElementById('downPaymentDisplay').textContent = '$' + calc.downPayment.toFixed(2);
    document.getElementById('amountFinancedDisplay').textContent = '$' + calc.amountFinanced.toFixed(2);
    document.getElementById('interestRateDisplay').textContent = (calc.interestRate * 100).toFixed(2) + '% APR';
    document.getElementById('loanTermDisplay').textContent = termDisplay;
    document.getElementById('extraPaymentDisplay').textContent = '$' + calc.extraPayment.toFixed(2) + '/month';
    document.getElementById('monthlyPaymentDisplay').textContent = '$' + calc.monthlyPayment.toFixed(2);
    document.getElementById('totalPaymentsDisplay').textContent = '$' + calc.totalPaymentsWithExtra.toFixed(2);
    document.getElementById('totalInterestDisplay').textContent = '$' + calc.totalInterestWithExtra.toFixed(2);

    // Update breakdown chart
    document.getElementById('principalTotal').textContent = calc.amountFinanced.toFixed(2);
    document.getElementById('interestTotal').textContent = calc.totalInterestWithExtra.toFixed(2);

    // Show extra payment benefits if applicable
    if (calc.extraPayment > 0) {
        const interestSavings = calc.totalInterest - calc.totalInterestWithExtra;
        const timeSavings = (calc.termInMonths - calc.payoffTimeWithExtra) / 12;

        document.getElementById('interestSavings').textContent = interestSavings.toFixed(2);
        document.getElementById('timeSavings').textContent = timeSavings.toFixed(1) + ' years';
        document.getElementById('newPayoffTime').textContent = (calc.payoffTimeWithExtra / 12).toFixed(1) + ' years';
        document.getElementById('monthlySavings').textContent = (interestSavings / calc.termInMonths).toFixed(2);

        document.getElementById('extraPaymentBenefits').style.display = 'block';
    } else {
        document.getElementById('extraPaymentBenefits').style.display = 'none';
    }

    document.getElementById('resultsContainer').style.display = 'block';
}

function showAmortization() {
    if (!currentCalculation) return;

    const calc = currentCalculation;
    const tableBody = document.getElementById('amortizationBody');
    tableBody.innerHTML = '';

    let balance = calc.amountFinanced;
    const monthlyRate = calc.interestRate / 12;

    // Show first 12 payments
    for (let month = 1; month <= Math.min(12, calc.payoffTimeWithExtra); month++) {
        const interestPayment = balance * monthlyRate;
        let principalPayment = calc.monthlyPayment - interestPayment;
        let extraThisMonth = calc.extraPayment;

        if (principalPayment + extraThisMonth > balance) {
            extraThisMonth = balance - principalPayment;
            principalPayment = balance;
        } else {
            principalPayment += extraThisMonth;
        }

        balance -= principalPayment;

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${month}</td>
            <td>$${calc.monthlyPayment.toFixed(2)}</td>
            <td>$${(principalPayment - calc.extraPayment).toFixed(2)}</td>
            <td>$${interestPayment.toFixed(2)}</td>
            <td>$${calc.extraPayment.toFixed(2)}</td>
            <td>$${balance.toFixed(2)}</td>
        `;
        tableBody.appendChild(row);
    }

    document.getElementById('amortizationTable').style.display = 'block';
}

function useExample(loanAmount, rate, term, downPayment, extraPayment) {
    document.getElementById('loanAmount').value = loanAmount;
    document.getElementById('interestRate').value = rate;
    document.getElementById('loanTerm').value = term;
    document.getElementById('termUnit').value = 'years';
    document.getElementById('downPayment').value = downPayment;
    document.getElementById('extraPayment').value = extraPayment;
    calculateLoan();
}

function clearAll() {
    document.getElementById('loanAmount').value = '';
    document.getElementById('interestRate').value = '';
    document.getElementById('loanTerm').value = '';
    document.getElementById('termUnit').value = 'years';
    document.getElementById('downPayment').value = '';
    document.getElementById('extraPayment').value = '';

    document.getElementById('resultsContainer').style.display = 'none';
    document.getElementById('amortizationTable').style.display = 'none';

    currentCalculation = null;
}

function copyResults() {
    if (!currentCalculation) return;

    const calc = currentCalculation;
    const textToCopy = `Loan Calculator Results:
Loan Amount: $${calc.loanAmount.toFixed(2)}
Down Payment: $${calc.downPayment.toFixed(2)}
Amount Financed: $${calc.amountFinanced.toFixed(2)}
Interest Rate: ${(calc.interestRate * 100).toFixed(2)}%
Loan Term: ${calc.loanTerm} ${calc.termUnit}
Monthly Payment: $${calc.monthlyPayment.toFixed(2)}
Total Interest: $${calc.totalInterestWithExtra.toFixed(2)}
Total Payments: $${calc.totalPaymentsWithExtra.toFixed(2)}`;

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
    alert('Full report generation would create a detailed PDF with complete amortization schedule.');
}

function compareOptions() {
    alert('Loan comparison tool would allow side-by-side comparison of different loan scenarios.');
}

// Auto-calculate when values change (with debounce)
let calculateTimeout;
function debounceCalculate() {
    clearTimeout(calculateTimeout);
    calculateTimeout = setTimeout(() => {
        const loanAmount = document.getElementById('loanAmount').value;
        const interestRate = document.getElementById('interestRate').value;
        const loanTerm = document.getElementById('loanTerm').value;

        if (loanAmount && interestRate && loanTerm) {
            calculateLoan();
        }
    }, 500);
}

// Add event listeners
document.getElementById('loanAmount').addEventListener('input', debounceCalculate);
document.getElementById('interestRate').addEventListener('input', debounceCalculate);
document.getElementById('loanTerm').addEventListener('input', debounceCalculate);
</script>
