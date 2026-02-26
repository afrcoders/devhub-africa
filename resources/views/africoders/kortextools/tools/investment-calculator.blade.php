<div class="row">
    <div class="col-md-12">
        <!-- Investment Type Selection -->
        <div class="mb-4">
            <h6>Investment Type:</h6>
            <div class="btn-group" role="group" aria-label="Investment Type">
                <input type="radio" class="btn-check" name="investmentType" id="lumpSum" value="lumpSum" checked>
                <label class="btn btn-outline-primary" for="lumpSum">Lump Sum</label>

                <input type="radio" class="btn-check" name="investmentType" id="recurring" value="recurring">
                <label class="btn btn-outline-primary" for="recurring">Recurring Investment</label>

                <input type="radio" class="btn-check" name="investmentType" id="goalBased" value="goalBased">
                <label class="btn btn-outline-primary" for="goalBased">Goal-Based</label>
            </div>
        </div>

        <!-- Lump Sum Investment -->
        <div id="lumpSumSection" class="investment-section">
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="initialAmount" class="form-label">Initial Investment</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="initialAmount" placeholder="10000" step="0.01" min="0">
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="annualReturn" class="form-label">Expected Annual Return</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="annualReturn" placeholder="7" step="0.01" min="0">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="timeHorizon" class="form-label">Time Horizon</label>
                    <input type="number" class="form-control" id="timeHorizon" placeholder="10" step="1" min="0">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="timeUnit" class="form-label">Time Unit</label>
                    <select class="form-select" id="timeUnit">
                        <option value="years" selected>Years</option>
                        <option value="months">Months</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Recurring Investment -->
        <div id="recurringSection" class="investment-section" style="display: none;">
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="monthlyContribution" class="form-label">Monthly Contribution</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="monthlyContribution" placeholder="500" step="0.01" min="0">
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="recurringReturn" class="form-label">Expected Annual Return</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="recurringReturn" placeholder="7" step="0.01" min="0">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="recurringTime" class="form-label">Investment Period (Years)</label>
                    <input type="number" class="form-control" id="recurringTime" placeholder="30" step="1" min="0">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="recurringInitial" class="form-label">Initial Amount (Optional)</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="recurringInitial" placeholder="0" step="0.01" min="0">
                    </div>
                </div>
            </div>
        </div>

        <!-- Goal-Based Investment -->
        <div id="goalSection" class="investment-section" style="display: none;">
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="goalAmount" class="form-label">Target Amount</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="goalAmount" placeholder="100000" step="0.01" min="0">
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="goalReturn" class="form-label">Expected Annual Return</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="goalReturn" placeholder="7" step="0.01" min="0">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="goalTime" class="form-label">Time to Goal (Years)</label>
                    <input type="number" class="form-control" id="goalTime" placeholder="20" step="1" min="0">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="goalInitial" class="form-label">Initial Amount (Optional)</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="goalInitial" placeholder="0" step="0.01" min="0">
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Options -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label for="inflationRate" class="form-label">Inflation Rate (Optional)</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="inflationRate" placeholder="3" step="0.01" min="0">
                    <span class="input-group-text">%</span>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="taxRate" class="form-label">Tax Rate (Optional)</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="taxRate" placeholder="20" step="0.01" min="0" max="100">
                    <span class="input-group-text">%</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mb-4">
            <button type="button" class="btn btn-primary" onclick="calculateInvestment()">
                <i class="fas fa-chart-line"></i> Calculate Investment
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="clearAll()">
                <i class="bi bi-x-circle"></i> Clear
            </button>
            <button type="button" class="btn btn-outline-info" onclick="showScenarios()">
                <i class="bi bi-graph-up"></i> Compare Scenarios
            </button>
        </div>

        <!-- Results Section -->
        <div id="resultsContainer" style="display: none;">
            <!-- Main Results Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="text-center p-3 bg-success text-white rounded">
                        <h5 id="futureValue" class="mb-1">$0.00</h5>
                        <small>Future Value</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-primary text-white rounded">
                        <h5 id="totalContributions" class="mb-1">$0.00</h5>
                        <small>Total Contributions</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-info text-white rounded">
                        <h5 id="totalEarnings" class="mb-1">$0.00</h5>
                        <small>Total Earnings</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-warning text-dark rounded">
                        <h5 id="effectiveReturn" class="mb-1">0%</h5>
                        <small>Effective Annual Return</small>
                    </div>
                </div>
            </div>

            <!-- Detailed Results -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Investment Summary</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <td>Investment Type</td>
                                        <td class="text-end" id="investmentTypeDisplay">-</td>
                                    </tr>
                                    <tr>
                                        <td>Time Horizon</td>
                                        <td class="text-end" id="timeHorizonDisplay">-</td>
                                    </tr>
                                    <tr>
                                        <td>Annual Return Rate</td>
                                        <td class="text-end" id="returnRateDisplay">-</td>
                                    </tr>
                                    <tr>
                                        <td>Monthly Contribution</td>
                                        <td class="text-end" id="monthlyContribDisplay">-</td>
                                    </tr>
                                    <tr class="table-success">
                                        <td><strong>Future Value</strong></td>
                                        <td class="text-end"><strong id="futureValueDisplay">$0.00</strong></td>
                                    </tr>
                                    <tr>
                                        <td>After Inflation</td>
                                        <td class="text-end" id="realValueDisplay">$0.00</td>
                                    </tr>
                                    <tr>
                                        <td>After Taxes</td>
                                        <td class="text-end" id="afterTaxDisplay">$0.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="investment-breakdown">
                        <h6 class="text-center">Growth Breakdown</h6>
                        <div class="breakdown-chart">
                            <div class="contributions-bar" id="contributionsBar"></div>
                            <div class="earnings-bar" id="earningsBar"></div>
                        </div>
                        <div class="breakdown-legend mt-2 text-center">
                            <small><i class="bi bi-square-fill text-primary"></i> Contributions: $<span id="contribAmount">0.00</span></small><br>
                            <small><i class="bi bi-square-fill text-success"></i> Earnings: $<span id="earnAmount">0.00</span></small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Goal-Based Results -->
            <div id="goalResults" style="display: none;" class="mb-4">
                <div class="alert alert-info">
                    <h6><i class="bi bi-target"></i> Goal Achievement Analysis:</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div><strong>Required Monthly Investment:</strong> $<span id="requiredMonthly">0.00</span></div>
                            <div><strong>Total Investment Needed:</strong> $<span id="totalRequired">0.00</span></div>
                        </div>
                        <div class="col-md-6">
                            <div><strong>Goal Progress:</strong> <span id="goalProgress">0%</span></div>
                            <div><strong>Surplus/Shortfall:</strong> $<span id="surplus">0.00</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Yearly Breakdown -->
            <div id="yearlyBreakdown" class="mb-4">
                <h6>Yearly Growth Projection (First 10 Years):</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>Year</th>
                                <th>Beginning Balance</th>
                                <th>Contributions</th>
                                <th>Investment Earnings</th>
                                <th>Ending Balance</th>
                            </tr>
                        </thead>
                        <tbody id="yearlyBreakdownBody">
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
                <button type="button" class="btn btn-outline-warning" onclick="exportData()">
                    <i class="bi bi-download"></i> Export Data
                </button>
            </div>
        </div>

        <!-- Scenario Comparison -->
        <div id="scenarioComparison" style="display: none;" class="mb-4">
            <h6>Investment Scenarios Comparison:</h6>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h6 class="card-title">Conservative (5%)</h6>
                            <h5 id="conservative" class="text-muted">$0.00</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h6 class="card-title">Moderate (7%)</h6>
                            <h5 id="moderate" class="text-success">$0.00</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h6 class="card-title">Aggressive (10%)</h6>
                            <h5 id="aggressive" class="text-primary">$0.00</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Examples -->
        <div class="mt-4">
            <h6>Quick Examples:</h6>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('lumpSum', 10000, 7, 20)">
                    $10K lump sum @ 7% for 20 years
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('recurring', 500, 8, 30)">
                    $500/month @ 8% for 30 years
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('goalBased', 1000000, 7, 25)">
                    $1M goal @ 7% in 25 years
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Information -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> About Investment Calculations</h6>
    <p class="mb-0">
        This calculator provides estimates based on compound interest and regular contributions.
        Past performance does not guarantee future results. Consider consulting with a financial advisor
        for personalized investment advice. All calculations assume reinvestment of returns.
    </p>
</div>

<style>
.investment-section {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    background-color: #f8f9fa;
}

.investment-breakdown {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
}

.breakdown-chart {
    height: 120px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.contributions-bar, .earnings-bar {
    height: 30px;
    border-radius: 15px;
    transition: width 0.5s ease;
}

.contributions-bar {
    background: #007bff;
}

.earnings-bar {
    background: #28a745;
}
</style>

<script>
let currentInvestmentCalculation = null;

// Handle investment type changes
document.querySelectorAll('input[name="investmentType"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.investment-section').forEach(section => {
            section.style.display = 'none';
        });

        switch(this.value) {
            case 'lumpSum':
                document.getElementById('lumpSumSection').style.display = 'block';
                break;
            case 'recurring':
                document.getElementById('recurringSection').style.display = 'block';
                break;
            case 'goalBased':
                document.getElementById('goalSection').style.display = 'block';
                break;
        }
    });
});

function calculateInvestment() {
    const investmentType = document.querySelector('input[name="investmentType"]:checked').value;
    const inflationRate = parseFloat(document.getElementById('inflationRate').value) / 100 || 0;
    const taxRate = parseFloat(document.getElementById('taxRate').value) / 100 || 0;

    let result;

    switch(investmentType) {
        case 'lumpSum':
            result = calculateLumpSum();
            break;
        case 'recurring':
            result = calculateRecurring();
            break;
        case 'goalBased':
            result = calculateGoalBased();
            break;
    }

    if (result) {
        result.inflationRate = inflationRate;
        result.taxRate = taxRate;
        result.investmentType = investmentType;

        // Calculate inflation-adjusted and after-tax values
        result.realValue = result.futureValue / Math.pow(1 + inflationRate, result.years);
        result.afterTaxValue = result.futureValue - ((result.futureValue - result.totalContributions) * taxRate);

        currentInvestmentCalculation = result;
        displayInvestmentResults(result);
    }
}

function calculateLumpSum() {
    const initialAmount = parseFloat(document.getElementById('initialAmount').value);
    const annualReturn = parseFloat(document.getElementById('annualReturn').value) / 100;
    const timeHorizon = parseFloat(document.getElementById('timeHorizon').value);
    const timeUnit = document.getElementById('timeUnit').value;

    if (!initialAmount || !annualReturn || !timeHorizon) {
        alert('Please fill in Initial Investment, Annual Return, and Time Horizon.');
        return null;
    }

    const years = timeUnit === 'years' ? timeHorizon : timeHorizon / 12;
    const futureValue = initialAmount * Math.pow(1 + annualReturn, years);

    return {
        futureValue: futureValue,
        totalContributions: initialAmount,
        totalEarnings: futureValue - initialAmount,
        years: years,
        annualReturn: annualReturn,
        monthlyContribution: 0
    };
}

function calculateRecurring() {
    const monthlyContribution = parseFloat(document.getElementById('monthlyContribution').value);
    const annualReturn = parseFloat(document.getElementById('recurringReturn').value) / 100;
    const years = parseFloat(document.getElementById('recurringTime').value);
    const initialAmount = parseFloat(document.getElementById('recurringInitial').value) || 0;

    if (!monthlyContribution || !annualReturn || !years) {
        alert('Please fill in Monthly Contribution, Annual Return, and Investment Period.');
        return null;
    }

    const monthlyRate = annualReturn / 12;
    const months = years * 12;

    // Future value of annuity + future value of lump sum
    const annuityFV = monthlyContribution * (((Math.pow(1 + monthlyRate, months) - 1) / monthlyRate));
    const lumpSumFV = initialAmount * Math.pow(1 + annualReturn, years);

    const futureValue = annuityFV + lumpSumFV;
    const totalContributions = (monthlyContribution * months) + initialAmount;

    return {
        futureValue: futureValue,
        totalContributions: totalContributions,
        totalEarnings: futureValue - totalContributions,
        years: years,
        annualReturn: annualReturn,
        monthlyContribution: monthlyContribution
    };
}

function calculateGoalBased() {
    const goalAmount = parseFloat(document.getElementById('goalAmount').value);
    const annualReturn = parseFloat(document.getElementById('goalReturn').value) / 100;
    const years = parseFloat(document.getElementById('goalTime').value);
    const initialAmount = parseFloat(document.getElementById('goalInitial').value) || 0;

    if (!goalAmount || !annualReturn || !years) {
        alert('Please fill in Target Amount, Annual Return, and Time to Goal.');
        return null;
    }

    const monthlyRate = annualReturn / 12;
    const months = years * 12;

    // Calculate required monthly payment to reach goal
    const lumpSumFV = initialAmount * Math.pow(1 + annualReturn, years);
    const remainingAmount = goalAmount - lumpSumFV;

    let requiredMonthly = 0;
    if (remainingAmount > 0) {
        requiredMonthly = remainingAmount / (((Math.pow(1 + monthlyRate, months) - 1) / monthlyRate));
    }

    const totalContributions = (requiredMonthly * months) + initialAmount;

    return {
        futureValue: goalAmount,
        totalContributions: totalContributions,
        totalEarnings: goalAmount - totalContributions,
        years: years,
        annualReturn: annualReturn,
        monthlyContribution: requiredMonthly,
        requiredMonthly: requiredMonthly,
        isGoalBased: true
    };
}

function displayInvestmentResults(result) {
    // Update main cards
    document.getElementById('futureValue').textContent = '$' + result.futureValue.toFixed(2);
    document.getElementById('totalContributions').textContent = '$' + result.totalContributions.toFixed(2);
    document.getElementById('totalEarnings').textContent = '$' + result.totalEarnings.toFixed(2);
    document.getElementById('effectiveReturn').textContent = (result.annualReturn * 100).toFixed(1) + '%';

    // Update detailed table
    const typeDisplayMap = {
        'lumpSum': 'Lump Sum Investment',
        'recurring': 'Recurring Investment',
        'goalBased': 'Goal-Based Planning'
    };

    document.getElementById('investmentTypeDisplay').textContent = typeDisplayMap[result.investmentType];
    document.getElementById('timeHorizonDisplay').textContent = result.years.toFixed(1) + ' years';
    document.getElementById('returnRateDisplay').textContent = (result.annualReturn * 100).toFixed(1) + '%';
    document.getElementById('monthlyContribDisplay').textContent = '$' + result.monthlyContribution.toFixed(2);
    document.getElementById('futureValueDisplay').textContent = '$' + result.futureValue.toFixed(2);
    document.getElementById('realValueDisplay').textContent = '$' + result.realValue.toFixed(2);
    document.getElementById('afterTaxDisplay').textContent = '$' + result.afterTaxValue.toFixed(2);

    // Update breakdown chart
    const totalValue = result.futureValue;
    const contributionPercent = (result.totalContributions / totalValue) * 100;
    const earningsPercent = 100 - contributionPercent;

    document.getElementById('contributionsBar').style.width = contributionPercent + '%';
    document.getElementById('earningsBar').style.width = earningsPercent + '%';
    document.getElementById('contribAmount').textContent = result.totalContributions.toFixed(2);
    document.getElementById('earnAmount').textContent = result.totalEarnings.toFixed(2);

    // Show goal-based results if applicable
    if (result.isGoalBased) {
        document.getElementById('requiredMonthly').textContent = result.requiredMonthly.toFixed(2);
        document.getElementById('totalRequired').textContent = result.totalContributions.toFixed(2);
        document.getElementById('goalProgress').textContent = '100%';
        document.getElementById('surplus').textContent = '0.00';
        document.getElementById('goalResults').style.display = 'block';
    } else {
        document.getElementById('goalResults').style.display = 'none';
    }

    // Generate yearly breakdown
    generateYearlyBreakdown(result);

    document.getElementById('resultsContainer').style.display = 'block';
}

function generateYearlyBreakdown(result) {
    const tableBody = document.getElementById('yearlyBreakdownBody');
    tableBody.innerHTML = '';

    let balance = 0;
    const yearsToShow = Math.min(10, result.years);

    for (let year = 1; year <= yearsToShow; year++) {
        const beginningBalance = balance;
        const yearlyContribution = result.monthlyContribution * 12;
        const earnings = (beginningBalance + yearlyContribution / 2) * result.annualReturn; // Approximate mid-year contribution
        balance = beginningBalance + yearlyContribution + earnings;

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${year}</td>
            <td>$${beginningBalance.toFixed(2)}</td>
            <td>$${yearlyContribution.toFixed(2)}</td>
            <td>$${earnings.toFixed(2)}</td>
            <td>$${balance.toFixed(2)}</td>
        `;
        tableBody.appendChild(row);
    }
}

function showScenarios() {
    if (!currentInvestmentCalculation) {
        alert('Please calculate an investment first.');
        return;
    }

    const result = currentInvestmentCalculation;

    // Calculate scenarios with different returns
    const scenarios = [
        { rate: 0.05, id: 'conservative' },
        { rate: 0.07, id: 'moderate' },
        { rate: 0.10, id: 'aggressive' }
    ];

    scenarios.forEach(scenario => {
        let scenarioValue;

        if (result.investmentType === 'lumpSum') {
            scenarioValue = result.totalContributions * Math.pow(1 + scenario.rate, result.years);
        } else {
            const monthlyRate = scenario.rate / 12;
            const months = result.years * 12;
            const annuityFV = result.monthlyContribution * (((Math.pow(1 + monthlyRate, months) - 1) / monthlyRate));
            scenarioValue = annuityFV;
        }

        document.getElementById(scenario.id).textContent = '$' + scenarioValue.toFixed(2);
    });

    document.getElementById('scenarioComparison').style.display = 'block';
}

function useExample(type, amount, rate, time) {
    // Reset investment type
    document.getElementById(type).checked = true;
    document.querySelector(`input[value="${type}"]`).dispatchEvent(new Event('change'));

    switch(type) {
        case 'lumpSum':
            document.getElementById('initialAmount').value = amount;
            document.getElementById('annualReturn').value = rate;
            document.getElementById('timeHorizon').value = time;
            break;
        case 'recurring':
            document.getElementById('monthlyContribution').value = amount;
            document.getElementById('recurringReturn').value = rate;
            document.getElementById('recurringTime').value = time;
            break;
        case 'goalBased':
            document.getElementById('goalAmount').value = amount;
            document.getElementById('goalReturn').value = rate;
            document.getElementById('goalTime').value = time;
            break;
    }

    calculateInvestment();
}

function clearAll() {
    // Reset all inputs
    document.querySelectorAll('input[type="number"]').forEach(input => input.value = '');
    document.getElementById('lumpSum').checked = true;
    document.getElementById('timeUnit').value = 'years';

    // Hide results
    document.getElementById('resultsContainer').style.display = 'none';
    document.getElementById('scenarioComparison').style.display = 'none';

    // Show lump sum section
    document.querySelectorAll('.investment-section').forEach(section => {
        section.style.display = 'none';
    });
    document.getElementById('lumpSumSection').style.display = 'block';

    currentInvestmentCalculation = null;
}

function copyResults() {
    if (!currentInvestmentCalculation) return;

    const result = currentInvestmentCalculation;
    const textToCopy = `Investment Calculator Results:
Investment Type: ${document.getElementById('investmentTypeDisplay').textContent}
Time Horizon: ${result.years} years
Annual Return: ${(result.annualReturn * 100).toFixed(1)}%
Monthly Contribution: $${result.monthlyContribution.toFixed(2)}
Future Value: $${result.futureValue.toFixed(2)}
Total Contributions: $${result.totalContributions.toFixed(2)}
Total Earnings: $${result.totalEarnings.toFixed(2)}`;

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
    alert('Full investment report generation would create a detailed analysis with charts and projections.');
}

function exportData() {
    alert('Data export would generate CSV file with yearly breakdown and scenarios.');
}
</script>
