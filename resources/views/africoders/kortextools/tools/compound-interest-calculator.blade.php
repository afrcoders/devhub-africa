<div class="row">
    <div class="col-md-12">
        <!-- Input Fields -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label for="principal" class="form-label">Principal Amount</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" id="principal" placeholder="10000" step="0.01" min="0">
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="rate" class="form-label">Annual Interest Rate</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="rate" placeholder="5" step="0.01" min="0">
                    <span class="input-group-text">%</span>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label for="time" class="form-label">Time Period</label>
                <input type="number" class="form-control" id="time" placeholder="5" step="0.1" min="0">
            </div>
            <div class="col-md-6 mb-3">
                <label for="timeUnit" class="form-label">Time Unit</label>
                <select class="form-select" id="timeUnit">
                    <option value="years">Years</option>
                    <option value="months">Months</option>
                </select>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label for="compound" class="form-label">Compounding Frequency</label>
                <select class="form-select" id="compound">
                    <option value="1">Annually</option>
                    <option value="2">Semi-annually</option>
                    <option value="4">Quarterly</option>
                    <option value="12" selected>Monthly</option>
                    <option value="52">Weekly</option>
                    <option value="365">Daily</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="additionalContribution" class="form-label">Additional Monthly Contribution (Optional)</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" id="additionalContribution" placeholder="0" step="0.01" min="0">
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mb-4">
            <button type="button" class="btn btn-primary" onclick="calculateCompoundInterest()">
                <i class="fas fa-calculator"></i> Calculate Compound Interest
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="clearAll()">
                <i class="bi bi-x-circle"></i> Clear
            </button>
            <button type="button" class="btn btn-outline-info" onclick="compareWithSimple()">
                <i class="bi bi-bar-chart"></i> Compare with Simple Interest
            </button>
        </div>

        <!-- Results Section -->
        <div id="resultsContainer" style="display: none;">
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="text-center p-3 bg-primary text-white rounded">
                        <h5 id="finalAmount" class="mb-1">$0.00</h5>
                        <small>Final Amount</small>
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
                        <h5 id="effectiveRate" class="mb-1">0%</h5>
                        <small>Effective Annual Rate</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-warning text-dark rounded">
                        <h5 id="totalContributions" class="mb-1">$0.00</h5>
                        <small>Total Contributions</small>
                    </div>
                </div>
            </div>

            <!-- Detailed Breakdown -->
            <div class="table-responsive mb-4">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th width="40%">Principal Amount</th>
                            <td id="principalDisplay">$0.00</td>
                        </tr>
                        <tr>
                            <th>Annual Interest Rate</th>
                            <td id="rateDisplay">0%</td>
                        </tr>
                        <tr>
                            <th>Time Period</th>
                            <td id="timeDisplay">0 years</td>
                        </tr>
                        <tr>
                            <th>Compounding Frequency</th>
                            <td id="compoundDisplay">Monthly</td>
                        </tr>
                        <tr>
                            <th>Additional Contributions</th>
                            <td id="contributionsDisplay">$0.00/month</td>
                        </tr>
                        <tr class="table-success">
                            <th><strong>Interest Earned</strong></th>
                            <td><strong id="interestEarnedDisplay">$0.00</strong></td>
                        </tr>
                        <tr class="table-primary">
                            <th><strong>Final Amount</strong></th>
                            <td><strong id="finalAmountDisplay">$0.00</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Formula Display -->
            <div class="alert alert-light mb-4">
                <h6><i class="bi bi-calculator"></i> Formula Used:</h6>
                <p class="mb-2"><strong>A = P(1 + r/n)^(nt) + PMT × [((1 + r/n)^(nt) - 1) / (r/n)]</strong></p>
                <div class="small">
                    <div><strong>A</strong> = Final amount</div>
                    <div><strong>P</strong> = Principal ($<span id="formulaPrincipal">0</span>)</div>
                    <div><strong>r</strong> = Annual interest rate (<span id="formulaRate">0</span>%)</div>
                    <div><strong>n</strong> = Compounding frequency (<span id="formulaCompound">0</span> times per year)</div>
                    <div><strong>t</strong> = Time in years (<span id="formulaTime">0</span>)</div>
                    <div><strong>PMT</strong> = Additional periodic payment ($<span id="formulaPmt">0</span>/month)</div>
                </div>
            </div>

            <!-- Simple vs Compound Comparison -->
            <div id="comparisonSection" style="display: none;" class="mb-4">
                <h6>Simple vs Compound Interest Comparison:</h6>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Simple Interest</th>
                                <th>Compound Interest</th>
                                <th>Difference</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Interest Earned</th>
                                <td id="simpleInterestAmount">$0.00</td>
                                <td id="compoundInterestAmount">$0.00</td>
                                <td id="interestDifference" class="text-success">$0.00</td>
                            </tr>
                            <tr>
                                <th>Final Amount</th>
                                <td id="simpleFinalAmount">$0.00</td>
                                <td id="compoundFinalAmount">$0.00</td>
                                <td id="amountDifference" class="text-success">$0.00</td>
                            </tr>
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
            </div>
        </div>

        <!-- Quick Examples -->
        <div class="mt-4">
            <h6>Quick Examples:</h6>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample(10000, 5, 10, 12, 0)">
                    $10K @ 5% for 10 years
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample(5000, 7, 15, 12, 100)">
                    $5K @ 7% for 15 years + $100/month
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample(25000, 4, 20, 4, 0)">
                    $25K @ 4% for 20 years (Quarterly)
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Information -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> About Compound Interest</h6>
    <p class="mb-0">
        Compound interest is the addition of interest to the principal sum of a loan or deposit. It's "interest on interest"
        and will make a sum grow faster than simple interest, which is calculated only on the principal amount.
        The frequency of compounding significantly affects the final amount.
    </p>
</div>

<script>
let currentCalculation = null;

function calculateCompoundInterest() {
    const principal = parseFloat(document.getElementById('principal').value);
    const rate = parseFloat(document.getElementById('rate').value) / 100;
    const time = parseFloat(document.getElementById('time').value);
    const timeUnit = document.getElementById('timeUnit').value;
    const compound = parseFloat(document.getElementById('compound').value);
    const additionalContribution = parseFloat(document.getElementById('additionalContribution').value) || 0;

    if (!principal || !rate || !time) {
        alert('Please fill in Principal, Interest Rate, and Time Period.');
        return;
    }

    // Convert time to years if needed
    const timeInYears = timeUnit === 'months' ? time / 12 : time;

    // Calculate compound interest
    const compoundAmount = principal * Math.pow(1 + rate / compound, compound * timeInYears);

    // Calculate additional contributions (annuity)
    let contributionAmount = 0;
    if (additionalContribution > 0) {
        const monthlyRate = rate / 12;
        const totalMonths = timeInYears * 12;
        contributionAmount = additionalContribution * (Math.pow(1 + monthlyRate, totalMonths) - 1) / monthlyRate;
    }

    const finalAmount = compoundAmount + contributionAmount;
    const totalContributions = principal + (additionalContribution * timeInYears * 12);
    const totalInterest = finalAmount - totalContributions;
    const effectiveAnnualRate = Math.pow(1 + rate / compound, compound) - 1;

    // Store calculation for comparison
    currentCalculation = {
        principal,
        rate,
        timeInYears,
        compound,
        additionalContribution,
        finalAmount,
        totalInterest,
        totalContributions,
        effectiveAnnualRate
    };

    displayResults(currentCalculation);
}

function displayResults(calc) {
    const compoundFrequencies = {
        1: 'Annually',
        2: 'Semi-annually',
        4: 'Quarterly',
        12: 'Monthly',
        52: 'Weekly',
        365: 'Daily'
    };

    // Update main cards
    document.getElementById('finalAmount').textContent = '$' + calc.finalAmount.toFixed(2);
    document.getElementById('totalInterest').textContent = '$' + calc.totalInterest.toFixed(2);
    document.getElementById('effectiveRate').textContent = (calc.effectiveAnnualRate * 100).toFixed(2) + '%';
    document.getElementById('totalContributions').textContent = '$' + calc.totalContributions.toFixed(2);

    // Update detailed table
    document.getElementById('principalDisplay').textContent = '$' + calc.principal.toFixed(2);
    document.getElementById('rateDisplay').textContent = (calc.rate * 100).toFixed(2) + '%';
    document.getElementById('timeDisplay').textContent = calc.timeInYears + ' years';
    document.getElementById('compoundDisplay').textContent = compoundFrequencies[calc.compound];
    document.getElementById('contributionsDisplay').textContent = '$' + calc.additionalContribution.toFixed(2) + '/month';
    document.getElementById('interestEarnedDisplay').textContent = '$' + calc.totalInterest.toFixed(2);
    document.getElementById('finalAmountDisplay').textContent = '$' + calc.finalAmount.toFixed(2);

    // Update formula
    document.getElementById('formulaPrincipal').textContent = calc.principal.toFixed(2);
    document.getElementById('formulaRate').textContent = (calc.rate * 100).toFixed(2);
    document.getElementById('formulaCompound').textContent = calc.compound;
    document.getElementById('formulaTime').textContent = calc.timeInYears.toFixed(1);
    document.getElementById('formulaPmt').textContent = calc.additionalContribution.toFixed(2);

    document.getElementById('resultsContainer').style.display = 'block';
}

function compareWithSimple() {
    if (!currentCalculation) {
        alert('Please calculate compound interest first.');
        return;
    }

    const calc = currentCalculation;

    // Calculate simple interest
    const simpleInterest = calc.principal * calc.rate * calc.timeInYears;
    const simpleFinalAmount = calc.principal + simpleInterest + (calc.additionalContribution * calc.timeInYears * 12);

    // Show comparison
    document.getElementById('simpleInterestAmount').textContent = '$' + simpleInterest.toFixed(2);
    document.getElementById('compoundInterestAmount').textContent = '$' + calc.totalInterest.toFixed(2);
    document.getElementById('interestDifference').textContent = '$' + (calc.totalInterest - simpleInterest).toFixed(2);

    document.getElementById('simpleFinalAmount').textContent = '$' + simpleFinalAmount.toFixed(2);
    document.getElementById('compoundFinalAmount').textContent = '$' + calc.finalAmount.toFixed(2);
    document.getElementById('amountDifference').textContent = '$' + (calc.finalAmount - simpleFinalAmount).toFixed(2);

    document.getElementById('comparisonSection').style.display = 'block';
}

function useExample(principal, rate, time, compound, contribution) {
    document.getElementById('principal').value = principal;
    document.getElementById('rate').value = rate;
    document.getElementById('time').value = time;
    document.getElementById('timeUnit').value = 'years';
    document.getElementById('compound').value = compound;
    document.getElementById('additionalContribution').value = contribution;
    calculateCompoundInterest();
}

function clearAll() {
    document.getElementById('principal').value = '';
    document.getElementById('rate').value = '';
    document.getElementById('time').value = '';
    document.getElementById('timeUnit').value = 'years';
    document.getElementById('compound').value = '12';
    document.getElementById('additionalContribution').value = '';

    document.getElementById('resultsContainer').style.display = 'none';
    document.getElementById('comparisonSection').style.display = 'none';

    currentCalculation = null;
}

function copyResults() {
    if (!currentCalculation) return;

    const calc = currentCalculation;
    const textToCopy = `Compound Interest Calculation Results:
Principal: $${calc.principal.toFixed(2)}
Interest Rate: ${(calc.rate * 100).toFixed(2)}%
Time: ${calc.timeInYears} years
Final Amount: $${calc.finalAmount.toFixed(2)}
Total Interest: $${calc.totalInterest.toFixed(2)}
Effective Annual Rate: ${(calc.effectiveAnnualRate * 100).toFixed(2)}%`;

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
    if (!currentCalculation) return;

    const calc = currentCalculation;
    const reportContent = `COMPOUND INTEREST CALCULATION REPORT
Generated on: ${new Date().toLocaleDateString()}

INVESTMENT DETAILS:
Principal Amount: $${calc.principal.toFixed(2)}
Annual Interest Rate: ${(calc.rate * 100).toFixed(2)}%
Investment Period: ${calc.timeInYears} years
Compounding Frequency: ${calc.compound} times per year
Additional Monthly Contribution: $${calc.additionalContribution.toFixed(2)}

RESULTS:
Final Amount: $${calc.finalAmount.toFixed(2)}
Total Interest Earned: $${calc.totalInterest.toFixed(2)}
Total Contributions: $${calc.totalContributions.toFixed(2)}
Effective Annual Rate: ${(calc.effectiveAnnualRate * 100).toFixed(2)}%

GROWTH BREAKDOWN:
Principal Growth: $${(calc.principal * Math.pow(1 + calc.rate / calc.compound, calc.compound * calc.timeInYears) - calc.principal).toFixed(2)}
Contribution Growth: $${(calc.finalAmount - calc.principal * Math.pow(1 + calc.rate / calc.compound, calc.compound * calc.timeInYears)).toFixed(2)}

This report was generated using the Compound Interest Calculator tool.`;

    const blob = new Blob([reportContent], { type: 'text/plain' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'compound-interest-report.txt';
    a.click();
    URL.revokeObjectURL(url);
}

// Auto-calculate when values change (with debounce)
let calculateTimeout;
function debounceCalculate() {
    clearTimeout(calculateTimeout);
    calculateTimeout = setTimeout(() => {
        const principal = document.getElementById('principal').value;
        const rate = document.getElementById('rate').value;
        const time = document.getElementById('time').value;

        if (principal && rate && time) {
            calculateCompoundInterest();
        }
    }, 500);
}

// Add event listeners
document.getElementById('principal').addEventListener('input', debounceCalculate);
document.getElementById('rate').addEventListener('input', debounceCalculate);
document.getElementById('time').addEventListener('input', debounceCalculate);
</script>
