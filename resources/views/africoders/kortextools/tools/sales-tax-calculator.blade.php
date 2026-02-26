<div class="row">
    <div class="col-md-12">
        <!-- Sales Tax Calculator Input -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label for="itemPrice" class="form-label">Item Price (Before Tax)</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" id="itemPrice" placeholder="100.00" step="0.01" min="0">
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="taxRate" class="form-label">Sales Tax Rate</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="taxRate" placeholder="8.25" step="0.01" min="0" max="100">
                    <span class="input-group-text">%</span>
                </div>
            </div>
        </div>

        <!-- Calculation Mode -->
        <div class="mb-4">
            <h6>Calculation Mode:</h6>
            <div class="btn-group" role="group" aria-label="Calculation Mode">
                <input type="radio" class="btn-check" name="calcMode" id="addTax" value="add" checked>
                <label class="btn btn-outline-primary" for="addTax">Add Tax to Price</label>

                <input type="radio" class="btn-check" name="calcMode" id="includeTax" value="include">
                <label class="btn btn-outline-primary" for="includeTax">Price Includes Tax</label>

                <input type="radio" class="btn-check" name="calcMode" id="reverseTax" value="reverse">
                <label class="btn btn-outline-primary" for="reverseTax">Find Tax Rate</label>
            </div>
        </div>

        <!-- Reverse Calculation (Find Tax Rate) -->
        <div id="reverseSection" style="display: none;" class="row mb-4">
            <div class="col-md-6 mb-3">
                <label for="totalPrice" class="form-label">Total Price (With Tax)</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" id="totalPrice" placeholder="108.25" step="0.01" min="0">
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="basePrice" class="form-label">Base Price (Before Tax)</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" id="basePrice" placeholder="100.00" step="0.01" min="0">
                </div>
            </div>
        </div>

        <!-- Multiple Items -->
        <div class="mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="multipleItems">
                <label class="form-check-label" for="multipleItems">
                    Calculate for multiple items
                </label>
            </div>
        </div>

        <div id="multipleItemsSection" style="display: none;" class="mb-4">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="quantity" placeholder="1" min="1" value="1">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="discount" class="form-label">Discount</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="discount" placeholder="0" min="0" max="100">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="shipping" class="form-label">Shipping Cost</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="shipping" placeholder="0.00" step="0.01" min="0">
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mb-4">
            <button type="button" class="btn btn-primary" onclick="calculateSalesTax()">
                <i class="fas fa-calculator"></i> Calculate Sales Tax
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="clearAll()">
                <i class="bi bi-x-circle"></i> Clear
            </button>
            <button type="button" class="btn btn-outline-info" onclick="showUSStates()">
                <i class="bi bi-map"></i> US State Rates
            </button>
        </div>

        <!-- Results Section -->
        <div id="resultsContainer" style="display: none;">
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="text-center p-3 bg-primary text-white rounded">
                        <h5 id="baseAmount" class="mb-1">$0.00</h5>
                        <small>Base Price</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-success text-white rounded">
                        <h5 id="taxAmount" class="mb-1">$0.00</h5>
                        <small>Tax Amount</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-info text-white rounded">
                        <h5 id="totalAmount" class="mb-1">$0.00</h5>
                        <small>Total Price</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-warning text-dark rounded">
                        <h5 id="effectiveRate" class="mb-1">0%</h5>
                        <small>Effective Rate</small>
                    </div>
                </div>
            </div>

            <!-- Detailed Breakdown -->
            <div class="table-responsive mb-4">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th width="40%">Item Price (Before Tax)</th>
                            <td id="itemPriceDisplay">$0.00</td>
                        </tr>
                        <tr>
                            <th>Sales Tax Rate</th>
                            <td id="taxRateDisplay">0%</td>
                        </tr>
                        <tr>
                            <th>Sales Tax Amount</th>
                            <td id="taxAmountDisplay">$0.00</td>
                        </tr>
                        <tr class="table-primary">
                            <th><strong>Total Price (Including Tax)</strong></th>
                            <td><strong id="totalPriceDisplay">$0.00</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Multiple Items Breakdown -->
            <div id="multipleItemsBreakdown" style="display: none;" class="mb-4">
                <h6>Multiple Items Breakdown:</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <td>Price per Item</td>
                                <td class="text-end" id="pricePerItem">$0.00</td>
                            </tr>
                            <tr>
                                <td>Quantity</td>
                                <td class="text-end" id="quantityDisplay">1</td>
                            </tr>
                            <tr>
                                <td>Subtotal</td>
                                <td class="text-end" id="subtotalDisplay">$0.00</td>
                            </tr>
                            <tr>
                                <td>Discount</td>
                                <td class="text-end" id="discountDisplay">-$0.00</td>
                            </tr>
                            <tr>
                                <td>After Discount</td>
                                <td class="text-end" id="afterDiscountDisplay">$0.00</td>
                            </tr>
                            <tr>
                                <td>Sales Tax</td>
                                <td class="text-end" id="salesTaxDisplay">$0.00</td>
                            </tr>
                            <tr>
                                <td>Shipping</td>
                                <td class="text-end" id="shippingDisplay">$0.00</td>
                            </tr>
                            <tr class="fw-bold">
                                <td><strong>Grand Total</strong></td>
                                <td class="text-end" id="grandTotalDisplay"><strong>$0.00</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">
                <button type="button" class="btn btn-outline-primary" onclick="copyResults()">
                    <i class="bi bi-clipboard"></i> Copy Results
                </button>
                <button type="button" class="btn btn-outline-success" onclick="generateReceipt()">
                    <i class="bi bi-receipt"></i> Generate Receipt
                </button>
                <button type="button" class="btn btn-outline-warning" onclick="showTaxTips()">
                    <i class="bi bi-lightbulb"></i> Tax Tips
                </button>
            </div>
        </div>

        <!-- US State Tax Rates -->
        <div id="stateRatesModal" style="display: none;" class="mt-4 p-4 bg-light rounded">
            <h6>Common US State Sales Tax Rates:</h6>
            <div class="row">
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>State</th>
                                    <th>Rate</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>California</td>
                                    <td>7.25%</td>
                                    <td><button class="btn btn-sm btn-outline-primary" onclick="useTaxRate(7.25)">Use</button></td>
                                </tr>
                                <tr>
                                    <td>Texas</td>
                                    <td>6.25%</td>
                                    <td><button class="btn btn-sm btn-outline-primary" onclick="useTaxRate(6.25)">Use</button></td>
                                </tr>
                                <tr>
                                    <td>New York</td>
                                    <td>8.00%</td>
                                    <td><button class="btn btn-sm btn-outline-primary" onclick="useTaxRate(8.00)">Use</button></td>
                                </tr>
                                <tr>
                                    <td>Florida</td>
                                    <td>6.00%</td>
                                    <td><button class="btn btn-sm btn-outline-primary" onclick="useTaxRate(6.00)">Use</button></td>
                                </tr>
                                <tr>
                                    <td>Illinois</td>
                                    <td>6.25%</td>
                                    <td><button class="btn btn-sm btn-outline-primary" onclick="useTaxRate(6.25)">Use</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>State</th>
                                    <th>Rate</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Washington</td>
                                    <td>6.50%</td>
                                    <td><button class="btn btn-sm btn-outline-primary" onclick="useTaxRate(6.50)">Use</button></td>
                                </tr>
                                <tr>
                                    <td>Ohio</td>
                                    <td>5.75%</td>
                                    <td><button class="btn btn-sm btn-outline-primary" onclick="useTaxRate(5.75)">Use</button></td>
                                </tr>
                                <tr>
                                    <td>Pennsylvania</td>
                                    <td>6.00%</td>
                                    <td><button class="btn btn-sm btn-outline-primary" onclick="useTaxRate(6.00)">Use</button></td>
                                </tr>
                                <tr>
                                    <td>Georgia</td>
                                    <td>4.00%</td>
                                    <td><button class="btn btn-sm btn-outline-primary" onclick="useTaxRate(4.00)">Use</button></td>
                                </tr>
                                <tr>
                                    <td>Virginia</td>
                                    <td>5.30%</td>
                                    <td><button class="btn btn-sm btn-outline-primary" onclick="useTaxRate(5.30)">Use</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="button" class="btn btn-secondary" onclick="hideUSStates()">Close</button>
                <small class="text-muted ms-3">*State rates may not include local taxes</small>
            </div>
        </div>

        <!-- Quick Examples -->
        <div class="mt-4">
            <h6>Quick Examples:</h6>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample(100, 8.25)">
                    $100 @ 8.25% tax
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample(49.99, 6.00)">
                    $49.99 @ 6% tax
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample(250, 7.75)">
                    $250 @ 7.75% tax
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Information -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> About Sales Tax</h6>
    <p class="mb-0">
        Sales tax rates vary by location and can include state, county, and city taxes. This calculator provides estimates for planning purposes.
        Always verify current tax rates with local authorities for official calculations. Some items may be exempt from sales tax.
    </p>
</div>

<script>
let currentCalculation = null;

// Handle calculation mode changes
document.querySelectorAll('input[name="calcMode"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const reverseSection = document.getElementById('reverseSection');
        if (this.value === 'reverse') {
            reverseSection.style.display = 'block';
        } else {
            reverseSection.style.display = 'none';
        }
    });
});

// Handle multiple items checkbox
document.getElementById('multipleItems').addEventListener('change', function() {
    const section = document.getElementById('multipleItemsSection');
    section.style.display = this.checked ? 'block' : 'none';
});

function calculateSalesTax() {
    const mode = document.querySelector('input[name="calcMode"]:checked').value;

    switch(mode) {
        case 'add':
            calculateAddTax();
            break;
        case 'include':
            calculateIncludeTax();
            break;
        case 'reverse':
            calculateReverseTax();
            break;
    }
}

function calculateAddTax() {
    const itemPrice = parseFloat(document.getElementById('itemPrice').value);
    const taxRate = parseFloat(document.getElementById('taxRate').value) / 100;

    if (!itemPrice || !taxRate) {
        alert('Please enter item price and tax rate.');
        return;
    }

    let baseAmount = itemPrice;
    let taxAmount = baseAmount * taxRate;
    let totalAmount = baseAmount + taxAmount;

    // Handle multiple items if enabled
    if (document.getElementById('multipleItems').checked) {
        const result = calculateMultipleItems(baseAmount, taxAmount, totalAmount);
        baseAmount = result.baseAmount;
        taxAmount = result.taxAmount;
        totalAmount = result.totalAmount;
    }

    currentCalculation = {
        mode: 'add',
        baseAmount,
        taxAmount,
        totalAmount,
        taxRate: taxRate * 100,
        itemPrice
    };

    displayResults(currentCalculation);
}

function calculateIncludeTax() {
    const totalPrice = parseFloat(document.getElementById('itemPrice').value);
    const taxRate = parseFloat(document.getElementById('taxRate').value) / 100;

    if (!totalPrice || !taxRate) {
        alert('Please enter total price (including tax) and tax rate.');
        return;
    }

    let baseAmount = totalPrice / (1 + taxRate);
    let taxAmount = totalPrice - baseAmount;
    let totalAmount = totalPrice;

    // Handle multiple items if enabled
    if (document.getElementById('multipleItems').checked) {
        const result = calculateMultipleItems(baseAmount, taxAmount, totalAmount);
        baseAmount = result.baseAmount;
        taxAmount = result.taxAmount;
        totalAmount = result.totalAmount;
    }

    currentCalculation = {
        mode: 'include',
        baseAmount,
        taxAmount,
        totalAmount,
        taxRate: taxRate * 100,
        itemPrice: totalPrice
    };

    displayResults(currentCalculation);
}

function calculateReverseTax() {
    const totalPrice = parseFloat(document.getElementById('totalPrice').value);
    const basePrice = parseFloat(document.getElementById('basePrice').value);

    if (!totalPrice || !basePrice) {
        alert('Please enter both total price and base price.');
        return;
    }

    const taxAmount = totalPrice - basePrice;
    const taxRate = (taxAmount / basePrice) * 100;

    currentCalculation = {
        mode: 'reverse',
        baseAmount: basePrice,
        taxAmount,
        totalAmount: totalPrice,
        taxRate: taxRate,
        itemPrice: basePrice
    };

    displayResults(currentCalculation);
}

function calculateMultipleItems(baseAmount, taxAmount, totalAmount) {
    const quantity = parseFloat(document.getElementById('quantity').value) || 1;
    const discount = parseFloat(document.getElementById('discount').value) / 100 || 0;
    const shipping = parseFloat(document.getElementById('shipping').value) || 0;

    const subtotal = baseAmount * quantity;
    const discountAmount = subtotal * discount;
    const afterDiscount = subtotal - discountAmount;
    const salesTax = afterDiscount * (currentCalculation?.taxRate / 100 || taxAmount / baseAmount);
    const grandTotal = afterDiscount + salesTax + shipping;

    return {
        baseAmount: subtotal,
        taxAmount: salesTax,
        totalAmount: grandTotal,
        quantity,
        discount: discountAmount,
        afterDiscount,
        shipping
    };
}

function displayResults(calc) {
    // Update main cards
    document.getElementById('baseAmount').textContent = '$' + calc.baseAmount.toFixed(2);
    document.getElementById('taxAmount').textContent = '$' + calc.taxAmount.toFixed(2);
    document.getElementById('totalAmount').textContent = '$' + calc.totalAmount.toFixed(2);
    document.getElementById('effectiveRate').textContent = calc.taxRate.toFixed(2) + '%';

    // Update detailed table
    document.getElementById('itemPriceDisplay').textContent = '$' + calc.baseAmount.toFixed(2);
    document.getElementById('taxRateDisplay').textContent = calc.taxRate.toFixed(2) + '%';
    document.getElementById('taxAmountDisplay').textContent = '$' + calc.taxAmount.toFixed(2);
    document.getElementById('totalPriceDisplay').textContent = '$' + calc.totalAmount.toFixed(2);

    // Show multiple items breakdown if applicable
    if (document.getElementById('multipleItems').checked) {
        const quantity = parseFloat(document.getElementById('quantity').value) || 1;
        const discount = parseFloat(document.getElementById('discount').value) / 100 || 0;
        const shipping = parseFloat(document.getElementById('shipping').value) || 0;

        document.getElementById('pricePerItem').textContent = '$' + calc.itemPrice.toFixed(2);
        document.getElementById('quantityDisplay').textContent = quantity;
        document.getElementById('subtotalDisplay').textContent = '$' + (calc.itemPrice * quantity).toFixed(2);
        document.getElementById('discountDisplay').textContent = '-$' + (calc.itemPrice * quantity * discount).toFixed(2);
        document.getElementById('afterDiscountDisplay').textContent = '$' + calc.baseAmount.toFixed(2);
        document.getElementById('salesTaxDisplay').textContent = '$' + calc.taxAmount.toFixed(2);
        document.getElementById('shippingDisplay').textContent = '$' + shipping.toFixed(2);
        document.getElementById('grandTotalDisplay').textContent = '$' + calc.totalAmount.toFixed(2);

        document.getElementById('multipleItemsBreakdown').style.display = 'block';
    } else {
        document.getElementById('multipleItemsBreakdown').style.display = 'none';
    }

    document.getElementById('resultsContainer').style.display = 'block';
}

function showUSStates() {
    document.getElementById('stateRatesModal').style.display = 'block';
}

function hideUSStates() {
    document.getElementById('stateRatesModal').style.display = 'none';
}

function useTaxRate(rate) {
    document.getElementById('taxRate').value = rate;
    hideUSStates();
    if (document.getElementById('itemPrice').value) {
        calculateSalesTax();
    }
}

function useExample(price, rate) {
    document.getElementById('itemPrice').value = price;
    document.getElementById('taxRate').value = rate;
    document.getElementById('addTax').checked = true;
    document.getElementById('multipleItems').checked = false;
    document.getElementById('multipleItemsSection').style.display = 'none';
    calculateSalesTax();
}

function clearAll() {
    document.getElementById('itemPrice').value = '';
    document.getElementById('taxRate').value = '';
    document.getElementById('totalPrice').value = '';
    document.getElementById('basePrice').value = '';
    document.getElementById('quantity').value = '1';
    document.getElementById('discount').value = '';
    document.getElementById('shipping').value = '';

    document.getElementById('addTax').checked = true;
    document.getElementById('multipleItems').checked = false;
    document.getElementById('multipleItemsSection').style.display = 'none';
    document.getElementById('reverseSection').style.display = 'none';
    document.getElementById('resultsContainer').style.display = 'none';
    document.getElementById('stateRatesModal').style.display = 'none';

    currentCalculation = null;
}

function copyResults() {
    if (!currentCalculation) return;

    const calc = currentCalculation;
    const textToCopy = `Sales Tax Calculation Results:
Base Price: $${calc.baseAmount.toFixed(2)}
Tax Rate: ${calc.taxRate.toFixed(2)}%
Tax Amount: $${calc.taxAmount.toFixed(2)}
Total Price: $${calc.totalAmount.toFixed(2)}`;

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
    alert('Receipt generation would create a printable receipt with tax breakdown.');
}

function showTaxTips() {
    alert('Tax tips: Keep receipts for business expenses, check if items are tax-exempt, verify local tax rates may apply.');
}

// Auto-calculate when values change (with debounce)
let calculateTimeout;
function debounceCalculate() {
    clearTimeout(calculateTimeout);
    calculateTimeout = setTimeout(() => {
        const itemPrice = document.getElementById('itemPrice').value;
        const taxRate = document.getElementById('taxRate').value;

        if (itemPrice && taxRate) {
            calculateSalesTax();
        }
    }, 500);
}

// Add event listeners
document.getElementById('itemPrice').addEventListener('input', debounceCalculate);
document.getElementById('taxRate').addEventListener('input', debounceCalculate);
</script>
