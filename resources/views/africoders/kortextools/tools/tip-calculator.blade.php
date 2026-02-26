<div class="row">
    <div class="col-md-12">
        <!-- Tip Calculator Input -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label for="billAmount" class="form-label">Bill Amount</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" id="billAmount" placeholder="85.50" step="0.01" min="0">
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="tipPercentage" class="form-label">Tip Percentage</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="tipPercentage" placeholder="18" step="0.1" min="0" max="100">
                    <span class="input-group-text">%</span>
                </div>
            </div>
        </div>

        <!-- Quick Tip Percentages -->
        <div class="mb-4">
            <h6>Quick Tip Percentages:</h6>
            <div class="btn-group" role="group" aria-label="Quick Tip Percentages">
                <button type="button" class="btn btn-outline-secondary" onclick="setTipPercentage(10)">10%</button>
                <button type="button" class="btn btn-outline-secondary" onclick="setTipPercentage(15)">15%</button>
                <button type="button" class="btn btn-outline-secondary" onclick="setTipPercentage(18)">18%</button>
                <button type="button" class="btn btn-outline-secondary" onclick="setTipPercentage(20)">20%</button>
                <button type="button" class="btn btn-outline-secondary" onclick="setTipPercentage(22)">22%</button>
                <button type="button" class="btn btn-outline-secondary" onclick="setTipPercentage(25)">25%</button>
            </div>
        </div>

        <!-- Split Bill Options -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label for="numberOfPeople" class="form-label">Number of People</label>
                <input type="number" class="form-control" id="numberOfPeople" placeholder="1" min="1" value="1">
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" id="includeTipInSplit">
                    <label class="form-check-label" for="includeTipInSplit">
                        Include tip in split calculation
                    </label>
                </div>
            </div>
        </div>

        <!-- Service Quality Rating -->
        <div class="mb-4">
            <h6>Service Quality (Optional):</h6>
            <div class="btn-group" role="group" aria-label="Service Quality">
                <button type="button" class="btn btn-outline-danger" onclick="setServiceQuality('poor', 10)">Poor (10%)</button>
                <button type="button" class="btn btn-outline-warning" onclick="setServiceQuality('fair', 15)">Fair (15%)</button>
                <button type="button" class="btn btn-outline-info" onclick="setServiceQuality('good', 18)">Good (18%)</button>
                <button type="button" class="btn btn-outline-success" onclick="setServiceQuality('excellent', 20)">Great (20%)</button>
                <button type="button" class="btn btn-outline-primary" onclick="setServiceQuality('exceptional', 25)">Exceptional (25%)</button>
            </div>
        </div>

        <!-- Custom Tip Amount -->
        <div class="mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="customTipAmount">
                <label class="form-check-label" for="customTipAmount">
                    Enter custom tip amount instead of percentage
                </label>
            </div>
            <div id="customAmountSection" style="display: none;" class="mt-3">
                <div class="col-md-6">
                    <label for="customAmount" class="form-label">Custom Tip Amount</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="customAmount" placeholder="15.00" step="0.01" min="0">
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mb-4">
            <button type="button" class="btn btn-primary" onclick="calculateTip()">
                <i class="fas fa-calculator"></i> Calculate Tip
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="clearAll()">
                <i class="bi bi-x-circle"></i> Clear
            </button>
            <button type="button" class="btn btn-outline-info" onclick="showTippingGuide()">
                <i class="bi bi-question-circle"></i> Tipping Guide
            </button>
        </div>

        <!-- Results Section -->
        <div id="resultsContainer" style="display: none;">
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="text-center p-3 bg-primary text-white rounded">
                        <h5 id="tipAmount" class="mb-1">$0.00</h5>
                        <small>Tip Amount</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-success text-white rounded">
                        <h5 id="totalAmount" class="mb-1">$0.00</h5>
                        <small>Total Amount</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-info text-white rounded">
                        <h5 id="perPersonAmount" class="mb-1">$0.00</h5>
                        <small>Per Person</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-warning text-dark rounded">
                        <h5 id="tipPercentageDisplay" class="mb-1">0%</h5>
                        <small>Tip Percentage</small>
                    </div>
                </div>
            </div>

            <!-- Detailed Breakdown -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th width="40%">Original Bill</th>
                                    <td id="originalBillDisplay">$0.00</td>
                                </tr>
                                <tr>
                                    <th>Tip Percentage</th>
                                    <td id="tipPercentDisplay">0%</td>
                                </tr>
                                <tr>
                                    <th>Tip Amount</th>
                                    <td id="tipAmountDisplay">$0.00</td>
                                </tr>
                                <tr class="table-success">
                                    <th><strong>Total (Bill + Tip)</strong></th>
                                    <td><strong id="totalBillDisplay">$0.00</strong></td>
                                </tr>
                                <tr>
                                    <th>Number of People</th>
                                    <td id="numberOfPeopleDisplay">1</td>
                                </tr>
                                <tr class="table-info">
                                    <th><strong>Amount Per Person</strong></th>
                                    <td><strong id="amountPerPersonDisplay">$0.00</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="tip-visual">
                        <h6 class="text-center">Visual Breakdown</h6>
                        <div class="tip-chart">
                            <div class="bill-portion" id="billPortion"></div>
                            <div class="tip-portion" id="tipPortion"></div>
                        </div>
                        <div class="chart-legend mt-2 text-center">
                            <small><i class="bi bi-square-fill text-primary"></i> Bill: $<span id="billAmount">0.00</span></small><br>
                            <small><i class="bi bi-square-fill text-success"></i> Tip: $<span id="tipAmount">0.00</span></small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Split Bill Details -->
            <div id="splitBillDetails" style="display: none;" class="mb-4">
                <h6>Split Bill Breakdown:</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Person</th>
                                <th>Bill Share</th>
                                <th>Tip Share</th>
                                <th>Total Share</th>
                            </tr>
                        </thead>
                        <tbody id="splitBillBody">
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tip Comparison -->
            <div class="mb-4">
                <h6>Tip Amount Comparison:</h6>
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center p-2 border rounded">
                            <div><strong>15%</strong></div>
                            <div id="tip15">$0.00</div>
                            <div><small>Standard</small></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-2 border rounded">
                            <div><strong>18%</strong></div>
                            <div id="tip18">$0.00</div>
                            <div><small>Good Service</small></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-2 border rounded">
                            <div><strong>20%</strong></div>
                            <div id="tip20">$0.00</div>
                            <div><small>Great Service</small></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="button" class="btn btn-outline-primary" onclick="copyResults()">
                    <i class="bi bi-clipboard"></i> Copy Results
                </button>
                <button type="button" class="btn btn-outline-success" onclick="generateReceipt()">
                    <i class="bi bi-receipt"></i> Generate Receipt
                </button>
                <button type="button" class="btn btn-outline-warning" onclick="roundTip()">
                    <i class="bi bi-arrow-up-circle"></i> Round Up Tip
                </button>
            </div>
        </div>

        <!-- Tipping Guide -->
        <div id="tippingGuideModal" style="display: none;" class="mt-4 p-4 bg-light rounded">
            <h6>Tipping Guide by Service Type:</h6>
            <div class="row">
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th>Recommended Tip</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>Restaurant (Dine-in)</td><td>15-20%</td></tr>
                                <tr><td>Restaurant (Excellent Service)</td><td>20-25%</td></tr>
                                <tr><td>Bar/Drinks</td><td>$1-2 per drink</td></tr>
                                <tr><td>Food Delivery</td><td>15-20%</td></tr>
                                <tr><td>Taxi/Rideshare</td><td>15-20%</td></tr>
                                <tr><td>Hair Stylist</td><td>15-20%</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th>Recommended Tip</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>Hotel Housekeeping</td><td>$2-5 per day</td></tr>
                                <tr><td>Valet Parking</td><td>$2-5</td></tr>
                                <tr><td>Massage Therapist</td><td>15-20%</td></tr>
                                <tr><td>Tour Guide</td><td>10-20%</td></tr>
                                <tr><td>Coffee Shop</td><td>10-15%</td></tr>
                                <tr><td>Fast Food</td><td>Optional</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="button" class="btn btn-secondary" onclick="hideTippingGuide()">Close</button>
                <small class="text-muted ms-3">*Guidelines may vary by location and culture</small>
            </div>
        </div>

        <!-- Quick Examples -->
        <div class="mt-4">
            <h6>Quick Examples:</h6>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample(45.80, 18, 2)">
                    $45.80 bill, 18% tip, 2 people
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample(125.50, 20, 4)">
                    $125.50 bill, 20% tip, 4 people
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample(28.75, 15, 1)">
                    $28.75 bill, 15% tip, 1 person
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Information -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> About Tipping</h6>
    <p class="mb-0">
        Tipping customs vary by country, region, and type of service. In the US, 15-20% is standard for restaurant service.
        Consider the quality of service, local customs, and your budget when determining tip amounts.
        Some establishments may include gratuity automatically for large parties.
    </p>
</div>

<style>
.tip-visual {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
}

.tip-chart {
    height: 120px;
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    border: 1px solid #dee2e6;
}

.bill-portion, .tip-portion {
    transition: height 0.5s ease;
}

.bill-portion {
    background: #007bff;
}

.tip-portion {
    background: #28a745;
}
</style>

<script>
let currentTipCalculation = null;

// Handle custom tip amount checkbox
document.getElementById('customTipAmount').addEventListener('change', function() {
    const section = document.getElementById('customAmountSection');
    section.style.display = this.checked ? 'block' : 'none';

    // Disable percentage input when custom amount is selected
    document.getElementById('tipPercentage').disabled = this.checked;

    if (this.checked) {
        document.getElementById('tipPercentage').value = '';
    }
});

function calculateTip() {
    const billAmount = parseFloat(document.getElementById('billAmount').value);
    const numberOfPeople = parseInt(document.getElementById('numberOfPeople').value) || 1;
    const includeTipInSplit = document.getElementById('includeTipInSplit').checked;
    const useCustomAmount = document.getElementById('customTipAmount').checked;

    if (!billAmount) {
        alert('Please enter the bill amount.');
        return;
    }

    let tipAmount;
    let tipPercentage;

    if (useCustomAmount) {
        tipAmount = parseFloat(document.getElementById('customAmount').value) || 0;
        tipPercentage = billAmount > 0 ? (tipAmount / billAmount) * 100 : 0;
    } else {
        tipPercentage = parseFloat(document.getElementById('tipPercentage').value) || 0;
        tipAmount = billAmount * (tipPercentage / 100);
    }

    const totalAmount = billAmount + tipAmount;
    const perPersonAmount = totalAmount / numberOfPeople;
    const billPerPerson = billAmount / numberOfPeople;
    const tipPerPerson = tipAmount / numberOfPeople;

    currentTipCalculation = {
        billAmount,
        tipAmount,
        totalAmount,
        tipPercentage,
        numberOfPeople,
        perPersonAmount,
        billPerPerson,
        tipPerPerson,
        includeTipInSplit
    };

    displayTipResults(currentTipCalculation);
}

function displayTipResults(calc) {
    // Update main cards
    document.getElementById('tipAmount').textContent = '$' + calc.tipAmount.toFixed(2);
    document.getElementById('totalAmount').textContent = '$' + calc.totalAmount.toFixed(2);
    document.getElementById('perPersonAmount').textContent = '$' + calc.perPersonAmount.toFixed(2);
    document.getElementById('tipPercentageDisplay').textContent = calc.tipPercentage.toFixed(1) + '%';

    // Update detailed breakdown
    document.getElementById('originalBillDisplay').textContent = '$' + calc.billAmount.toFixed(2);
    document.getElementById('tipPercentDisplay').textContent = calc.tipPercentage.toFixed(1) + '%';
    document.getElementById('tipAmountDisplay').textContent = '$' + calc.tipAmount.toFixed(2);
    document.getElementById('totalBillDisplay').textContent = '$' + calc.totalAmount.toFixed(2);
    document.getElementById('numberOfPeopleDisplay').textContent = calc.numberOfPeople;
    document.getElementById('amountPerPersonDisplay').textContent = '$' + calc.perPersonAmount.toFixed(2);

    // Update visual breakdown
    const billPercent = (calc.billAmount / calc.totalAmount) * 100;
    const tipPercent = 100 - billPercent;

    document.getElementById('billPortion').style.height = billPercent + '%';
    document.getElementById('tipPortion').style.height = tipPercent + '%';

    // Update legend
    document.getElementById('billAmount').textContent = calc.billAmount.toFixed(2);
    document.getElementById('tipAmount').textContent = calc.tipAmount.toFixed(2);

    // Show split bill details if more than one person
    if (calc.numberOfPeople > 1) {
        displaySplitBillDetails(calc);
    }

    // Update tip comparison
    document.getElementById('tip15').textContent = '$' + (calc.billAmount * 0.15).toFixed(2);
    document.getElementById('tip18').textContent = '$' + (calc.billAmount * 0.18).toFixed(2);
    document.getElementById('tip20').textContent = '$' + (calc.billAmount * 0.20).toFixed(2);

    document.getElementById('resultsContainer').style.display = 'block';
}

function displaySplitBillDetails(calc) {
    const tbody = document.getElementById('splitBillBody');
    tbody.innerHTML = '';

    for (let i = 1; i <= calc.numberOfPeople; i++) {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>Person ${i}</td>
            <td>$${calc.billPerPerson.toFixed(2)}</td>
            <td>$${calc.tipPerPerson.toFixed(2)}</td>
            <td><strong>$${calc.perPersonAmount.toFixed(2)}</strong></td>
        `;
        tbody.appendChild(row);
    }

    document.getElementById('splitBillDetails').style.display = 'block';
}

function setTipPercentage(percentage) {
    if (!document.getElementById('customTipAmount').checked) {
        document.getElementById('tipPercentage').value = percentage;
        if (document.getElementById('billAmount').value) {
            calculateTip();
        }
    }
}

function setServiceQuality(quality, percentage) {
    setTipPercentage(percentage);

    // Show feedback about service quality
    const qualityMessages = {
        'poor': 'Poor service - 10% tip',
        'fair': 'Fair service - 15% tip',
        'good': 'Good service - 18% tip',
        'excellent': 'Great service - 20% tip',
        'exceptional': 'Exceptional service - 25% tip'
    };

    // Could show a temporary message or highlight
    console.log(qualityMessages[quality]);
}

function showTippingGuide() {
    document.getElementById('tippingGuideModal').style.display = 'block';
}

function hideTippingGuide() {
    document.getElementById('tippingGuideModal').style.display = 'none';
}

function useExample(bill, tip, people) {
    document.getElementById('billAmount').value = bill;
    document.getElementById('tipPercentage').value = tip;
    document.getElementById('numberOfPeople').value = people;
    document.getElementById('customTipAmount').checked = false;
    document.getElementById('customAmountSection').style.display = 'none';
    document.getElementById('tipPercentage').disabled = false;
    calculateTip();
}

function clearAll() {
    document.getElementById('billAmount').value = '';
    document.getElementById('tipPercentage').value = '';
    document.getElementById('numberOfPeople').value = '1';
    document.getElementById('customAmount').value = '';
    document.getElementById('customTipAmount').checked = false;
    document.getElementById('includeTipInSplit').checked = false;

    document.getElementById('customAmountSection').style.display = 'none';
    document.getElementById('tipPercentage').disabled = false;
    document.getElementById('resultsContainer').style.display = 'none';
    document.getElementById('splitBillDetails').style.display = 'none';
    document.getElementById('tippingGuideModal').style.display = 'none';

    currentTipCalculation = null;
}

function copyResults() {
    if (!currentTipCalculation) return;

    const calc = currentTipCalculation;
    const textToCopy = `Tip Calculator Results:
Bill Amount: $${calc.billAmount.toFixed(2)}
Tip (${calc.tipPercentage.toFixed(1)}%): $${calc.tipAmount.toFixed(2)}
Total Amount: $${calc.totalAmount.toFixed(2)}
Per Person (${calc.numberOfPeople} people): $${calc.perPersonAmount.toFixed(2)}`;

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

function generateReceipt() {
    if (!currentTipCalculation) return;

    alert('Receipt generation would create a detailed breakdown with bill amount, tip, and per-person costs.');
}

function roundTip() {
    if (!currentTipCalculation) return;

    // Round tip to next whole dollar
    const roundedTipAmount = Math.ceil(currentTipCalculation.tipAmount);
    const newPercentage = (roundedTipAmount / currentTipCalculation.billAmount) * 100;

    document.getElementById('tipPercentage').value = newPercentage.toFixed(1);
    document.getElementById('customTipAmount').checked = false;
    document.getElementById('customAmountSection').style.display = 'none';
    document.getElementById('tipPercentage').disabled = false;

    calculateTip();
}

// Auto-calculate when values change (with debounce)
let calculateTimeout;
function debounceCalculate() {
    clearTimeout(calculateTimeout);
    calculateTimeout = setTimeout(() => {
        const billAmount = document.getElementById('billAmount').value;
        const tipPercentage = document.getElementById('tipPercentage').value;
        const customAmount = document.getElementById('customAmount').value;
        const useCustom = document.getElementById('customTipAmount').checked;

        if (billAmount && ((useCustom && customAmount) || (!useCustom && tipPercentage))) {
            calculateTip();
        }
    }, 500);
}

// Add event listeners
document.getElementById('billAmount').addEventListener('input', debounceCalculate);
document.getElementById('tipPercentage').addEventListener('input', debounceCalculate);
document.getElementById('customAmount').addEventListener('input', debounceCalculate);
document.getElementById('numberOfPeople').addEventListener('input', debounceCalculate);
</script>
