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
                    <option value="days">Days</option>
                </select>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mb-4">
            <button type="button" class="btn btn-primary" onclick="calculateSimpleInterest()">
                <i class="fas fa-calculator"></i> Calculate Simple Interest
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="clearAll()">
                <i class="bi bi-x-circle"></i> Clear
            </button>
            <button type="button" class="btn btn-outline-info" onclick="showFormula()">
                <i class="bi bi-book"></i> Show Formula
            </button>
        </div>

        <!-- Results Section -->
        <div id="resultsContainer" style="display: none;">
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="text-center p-4 bg-primary text-white rounded">
                        <h4 id="totalAmount" class="mb-1">$0.00</h4>
                        <small>Total Amount</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-4 bg-success text-white rounded">
                        <h4 id="interestEarned" class="mb-1">$0.00</h4>
                        <small>Interest Earned</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-4 bg-info text-white rounded">
                        <h4 id="returnRate" class="mb-1">0%</h4>
                        <small>Total Return</small>
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
                            <th>Interest Rate</th>
                            <td id="rateDisplay">0% per year</td>
                        </tr>
                        <tr>
                            <th>Time Period</th>
                            <td id="timeDisplay">0 years</td>
                        </tr>
                        <tr>
                            <th>Interest Calculation</th>
                            <td id="calculationDisplay">$0 × 0% × 0 years</td>
                        </tr>
                        <tr class="table-success">
                            <th><strong>Interest Earned</strong></th>
                            <td><strong id="interestDisplay">$0.00</strong></td>
                        </tr>
                        <tr class="table-primary">
                            <th><strong>Final Amount</strong></th>
                            <td><strong id="finalDisplay">$0.00</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Time Breakdown -->
            <div class="mb-4">
                <h6>Interest Breakdown:</h6>
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center p-3 bg-light rounded">
                            <h6 id="yearlyInterest" class="mb-1">$0.00</h6>
                            <small>Per Year</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 bg-light rounded">
                            <h6 id="monthlyInterest" class="mb-1">$0.00</h6>
                            <small>Per Month</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 bg-light rounded">
                            <h6 id="weeklyInterest" class="mb-1">$0.00</h6>
                            <small>Per Week</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 bg-light rounded">
                            <h6 id="dailyInterest" class="mb-1">$0.00</h6>
                            <small>Per Day</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="button" class="btn btn-outline-primary" onclick="copyResults()">
                    <i class="bi bi-clipboard"></i> Copy Results
                </button>
                <button type="button" class="btn btn-outline-success" onclick="generateSchedule()">
                    <i class="bi bi-table"></i> Generate Payment Schedule
                </button>
            </div>
        </div>

        <!-- Formula Section -->
        <div id="formulaSection" style="display: none;" class="mb-4">
            <div class="alert alert-light">
                <h6><i class="bi bi-calculator"></i> Simple Interest Formula:</h6>
                <div class="mb-3">
                    <h5 class="text-center"><strong>I = P × r × t</strong></h5>
                    <h5 class="text-center"><strong>A = P + I</strong></h5>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div><strong>I</strong> = Interest earned</div>
                        <div><strong>A</strong> = Total amount</div>
                        <div><strong>P</strong> = Principal amount</div>
                    </div>
                    <div class="col-md-6">
                        <div><strong>r</strong> = Annual interest rate (as decimal)</div>
                        <div><strong>t</strong> = Time period in years</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Schedule -->
        <div id="paymentSchedule" style="display: none;" class="mb-4">
            <h6>Yearly Interest Breakdown:</h6>
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Beginning Balance</th>
                            <th>Interest Earned</th>
                            <th>Ending Balance</th>
                        </tr>
                    </thead>
                    <tbody id="scheduleTableBody">
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Examples -->
        <div class="mt-4">
            <h6>Quick Examples:</h6>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample(10000, 5, 2, 'years')">
                    $10K @ 5% for 2 years
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample(5000, 8, 18, 'months')">
                    $5K @ 8% for 18 months
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample(25000, 3.5, 5, 'years')">
                    $25K @ 3.5% for 5 years
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample(1000, 12, 90, 'days')">
                    $1K @ 12% for 90 days
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Information -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> About Simple Interest</h6>
    <p class="mb-0">
        Simple interest is calculated only on the principal amount, not on accumulated interest.
        It's commonly used for short-term loans, car loans, and some types of mortgages. The formula
        I = P × r × t makes it easy to calculate the exact interest amount for any time period.
    </p>
</div>

<script>
let currentCalculation = null;

function calculateSimpleInterest() {
    const principal = parseFloat(document.getElementById('principal').value);
    const rate = parseFloat(document.getElementById('rate').value) / 100;
    const time = parseFloat(document.getElementById('time').value);
    const timeUnit = document.getElementById('timeUnit').value;

    if (!principal || !rate || !time) {
        alert('Please fill in Principal, Interest Rate, and Time Period.');
        return;
    }

    // Convert time to years for calculation
    let timeInYears = time;
    switch (timeUnit) {
        case 'months':
            timeInYears = time / 12;
            break;
        case 'days':
            timeInYears = time / 365;
            break;
    }

    // Calculate simple interest
    const interest = principal * rate * timeInYears;
    const totalAmount = principal + interest;
    const returnRate = (interest / principal) * 100;

    // Store calculation
    currentCalculation = {
        principal,
        rate,
        time,
        timeUnit,
        timeInYears,
        interest,
        totalAmount,
        returnRate
    };

    displayResults(currentCalculation);
}

function displayResults(calc) {
    const timeUnits = {
        'years': calc.time + ' year' + (calc.time !== 1 ? 's' : ''),
        'months': calc.time + ' month' + (calc.time !== 1 ? 's' : ''),
        'days': calc.time + ' day' + (calc.time !== 1 ? 's' : '')
    };

    // Update main cards
    document.getElementById('totalAmount').textContent = '$' + calc.totalAmount.toFixed(2);
    document.getElementById('interestEarned').textContent = '$' + calc.interest.toFixed(2);
    document.getElementById('returnRate').textContent = calc.returnRate.toFixed(2) + '%';

    // Update detailed table
    document.getElementById('principalDisplay').textContent = '$' + calc.principal.toFixed(2);
    document.getElementById('rateDisplay').textContent = (calc.rate * 100).toFixed(2) + '% per year';
    document.getElementById('timeDisplay').textContent = timeUnits[calc.timeUnit];
    document.getElementById('calculationDisplay').textContent =
        '$' + calc.principal.toFixed(2) + ' × ' + (calc.rate * 100).toFixed(2) + '% × ' + calc.timeInYears.toFixed(2) + ' years';
    document.getElementById('interestDisplay').textContent = '$' + calc.interest.toFixed(2);
    document.getElementById('finalDisplay').textContent = '$' + calc.totalAmount.toFixed(2);

    // Update time breakdown
    const yearlyInt = calc.principal * calc.rate;
    const monthlyInt = yearlyInt / 12;
    const weeklyInt = yearlyInt / 52;
    const dailyInt = yearlyInt / 365;

    document.getElementById('yearlyInterest').textContent = '$' + yearlyInt.toFixed(2);
    document.getElementById('monthlyInterest').textContent = '$' + monthlyInt.toFixed(2);
    document.getElementById('weeklyInterest').textContent = '$' + weeklyInt.toFixed(2);
    document.getElementById('dailyInterest').textContent = '$' + dailyInt.toFixed(2);

    document.getElementById('resultsContainer').style.display = 'block';
}

function showFormula() {
    const formula = document.getElementById('formulaSection');
    formula.style.display = formula.style.display === 'none' ? 'block' : 'none';
}

function generateSchedule() {
    if (!currentCalculation) return;

    const calc = currentCalculation;
    const tableBody = document.getElementById('scheduleTableBody');
    tableBody.innerHTML = '';

    // Generate yearly breakdown
    const years = Math.ceil(calc.timeInYears);
    const yearlyInterest = calc.principal * calc.rate;

    for (let year = 1; year <= years; year++) {
        const row = document.createElement('tr');
        const beginningBalance = calc.principal;
        const isLastYear = year === years && calc.timeInYears % 1 !== 0;
        const yearFraction = isLastYear ? calc.timeInYears % 1 : 1;
        const interestThisYear = yearlyInterest * yearFraction;
        const cumulativeInterest = year === 1 ? interestThisYear :
            (year - 1) * yearlyInterest + interestThisYear;
        const endingBalance = beginningBalance + cumulativeInterest;

        row.innerHTML = `
            <td>Year ${year}${isLastYear ? ` (${(yearFraction * 12).toFixed(1)} months)` : ''}</td>
            <td>$${beginningBalance.toFixed(2)}</td>
            <td>$${interestThisYear.toFixed(2)}</td>
            <td>$${endingBalance.toFixed(2)}</td>
        `;

        if (year === years) {
            row.classList.add('table-success');
        }

        tableBody.appendChild(row);

        if (year >= calc.timeInYears) break;
    }

    document.getElementById('paymentSchedule').style.display = 'block';
}

function useExample(principal, rate, time, unit) {
    document.getElementById('principal').value = principal;
    document.getElementById('rate').value = rate;
    document.getElementById('time').value = time;
    document.getElementById('timeUnit').value = unit;
    calculateSimpleInterest();
}

function clearAll() {
    document.getElementById('principal').value = '';
    document.getElementById('rate').value = '';
    document.getElementById('time').value = '';
    document.getElementById('timeUnit').value = 'years';

    document.getElementById('resultsContainer').style.display = 'none';
    document.getElementById('formulaSection').style.display = 'none';
    document.getElementById('paymentSchedule').style.display = 'none';

    currentCalculation = null;
}

function copyResults() {
    if (!currentCalculation) return;

    const calc = currentCalculation;
    const textToCopy = `Simple Interest Calculation Results:
Principal: $${calc.principal.toFixed(2)}
Interest Rate: ${(calc.rate * 100).toFixed(2)}% per year
Time: ${calc.time} ${calc.timeUnit}
Interest Earned: $${calc.interest.toFixed(2)}
Total Amount: $${calc.totalAmount.toFixed(2)}
Total Return: ${calc.returnRate.toFixed(2)}%`;

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

// Auto-calculate when values change (with debounce)
let calculateTimeout;
function debounceCalculate() {
    clearTimeout(calculateTimeout);
    calculateTimeout = setTimeout(() => {
        const principal = document.getElementById('principal').value;
        const rate = document.getElementById('rate').value;
        const time = document.getElementById('time').value;

        if (principal && rate && time) {
            calculateSimpleInterest();
        }
    }, 500);
}

// Add event listeners
document.getElementById('principal').addEventListener('input', debounceCalculate);
document.getElementById('rate').addEventListener('input', debounceCalculate);
document.getElementById('time').addEventListener('input', debounceCalculate);
</script>
