<div class="row">
    <div class="col-md-12">
        <!-- Currency Selection -->
        <div class="mb-4">
            <label class="form-label">Currency</label>
            <select class="form-select" id="currency" onchange="updateCurrency()">
                <option value="USD">USD ($)</option>
                <option value="EUR">EUR (€)</option>
                <option value="GBP">GBP (£)</option>
                <option value="JPY">JPY (¥)</option>
                <option value="CNY">CNY (¥)</option>
                <option value="INR">INR (₹)</option>
                <option value="CAD">CAD (C$)</option>
                <option value="AUD">AUD (A$)</option>
            </select>
        </div>

        <!-- Price and Discount Input -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label for="original_price" class="form-label">Original Price</label>
                <div class="input-group">
                    <span class="input-group-text" id="currency-symbol">$</span>
                    <input type="number" class="form-control" id="original_price" placeholder="0.00" step="0.01" min="0">
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="discount_percent" class="form-label">Discount Percentage</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="discount_percent" placeholder="0" min="0" max="100" step="0.01">
                    <span class="input-group-text">%</span>
                </div>
            </div>
        </div>

        <!-- Alternative: Discount Amount Input -->
        <div class="mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="use-discount-amount">
                <label class="form-check-label" for="use-discount-amount">
                    Or enter discount amount directly
                </label>
            </div>
            <div id="discount-amount-input" style="display: none;" class="mt-2">
                <label for="discount_amount" class="form-label">Discount Amount</label>
                <div class="input-group">
                    <span class="input-group-text" id="currency-symbol-2">$</span>
                    <input type="number" class="form-control" id="discount_amount" placeholder="0.00" step="0.01" min="0">
                </div>
            </div>
        </div>

        <!-- Calculate Button -->
        <div class="mb-4">
            <button type="button" class="btn btn-primary" onclick="calculateDiscount()">
                <i class="fas fa-calculator"></i> Calculate Discount
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="clearAll()">
                <i class="bi bi-x-circle"></i> Clear
            </button>
        </div>

        <!-- Results Section -->
        <div id="resultsContainer" style="display: none;">
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="text-center p-3 bg-light rounded">
                        <h5 id="original-display" class="text-secondary mb-1">$0.00</h5>
                        <small>Original Price</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-3 bg-danger text-white rounded">
                        <h5 id="discount-display" class="mb-1">-$0.00</h5>
                        <small>You Save</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-3 bg-success text-white rounded">
                        <h5 id="final-display" class="mb-1">$0.00</h5>
                        <small>Final Price</small>
                    </div>
                </div>
            </div>

            <div class="table-responsive mb-4">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th width="40%">Original Price</th>
                            <td id="original-price-row">$0.00</td>
                        </tr>
                        <tr>
                            <th>Discount Percentage</th>
                            <td id="discount-percentage-row">0%</td>
                        </tr>
                        <tr>
                            <th>Discount Amount</th>
                            <td id="discount-amount-row" class="text-danger">-$0.00</td>
                        </tr>
                        <tr class="table-success">
                            <th><strong>Final Price</strong></th>
                            <td id="final-price-row"><strong>$0.00</strong></td>
                        </tr>
                        <tr>
                            <th>Amount Saved</th>
                            <td id="amount-saved-row" class="text-success">$0.00</td>
                        </tr>
                        <tr>
                            <th>Savings Percentage</th>
                            <td id="savings-percentage-row">0%</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Multiple Item Calculation -->
            <div class="mb-4">
                <h6>Calculate for Multiple Items</h6>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" value="1" min="1" max="1000" step="1" onchange="updateMultipleItems()">
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="p-3 bg-info text-white rounded">
                            <strong>Total for <span id="qty-display">1</span> items: <span id="total-multiple">$0.00</span></strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="copyResults()">
                    <i class="bi bi-clipboard"></i> Copy Results
                </button>
                <button type="button" class="btn btn-sm btn-outline-success" onclick="shareResults()">
                    <i class="bi bi-share"></i> Share
                </button>
            </div>
        </div>

        <!-- Quick Examples -->
        <div class="mt-4">
            <h6>Quick Examples:</h6>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample(100, 20)">
                    $100 - 20% off
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample(49.99, 15)">
                    $49.99 - 15% off
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample(200, 30)">
                    $200 - 30% off
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample(75, 25)">
                    $75 - 25% off
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Information -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> About Discount Calculation</h6>
    <p class="mb-0">
        This calculator helps you determine the final price after applying a discount, whether expressed as
        a percentage or a fixed amount. It also calculates total savings and can handle multiple items.
    </p>
</div>

<style>
.btn-check:checked + .btn-outline-primary {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
    color: white;
}
</style>

<script>
const currencySymbols = {
    'USD': '$',
    'EUR': '€',
    'GBP': '£',
    'JPY': '¥',
    'CNY': '¥',
    'INR': '₹',
    'CAD': 'C$',
    'AUD': 'A$'
};

// Toggle between percentage and amount input
document.getElementById('use-discount-amount').addEventListener('change', function() {
    const discountAmountInput = document.getElementById('discount-amount-input');
    const discountPercent = document.getElementById('discount_percent');

    if (this.checked) {
        discountAmountInput.style.display = 'block';
        discountPercent.disabled = true;
        discountPercent.value = '';
    } else {
        discountAmountInput.style.display = 'none';
        discountPercent.disabled = false;
        document.getElementById('discount_amount').value = '';
    }
});

function updateCurrency() {
    const currency = document.getElementById('currency').value;
    const symbol = currencySymbols[currency];

    document.getElementById('currency-symbol').textContent = symbol;
    document.getElementById('currency-symbol-2').textContent = symbol;

    // Update displayed results if they exist
    if (document.getElementById('resultsContainer').style.display !== 'none') {
        calculateDiscount();
    }
}

function calculateDiscount() {
    const originalPrice = parseFloat(document.getElementById('original_price').value);
    const useDiscountAmount = document.getElementById('use-discount-amount').checked;

    if (!originalPrice || originalPrice <= 0) {
        alert('Please enter a valid original price.');
        return;
    }

    let discountAmount, discountPercent;

    if (useDiscountAmount) {
        discountAmount = parseFloat(document.getElementById('discount_amount').value);
        if (!discountAmount || discountAmount < 0) {
            alert('Please enter a valid discount amount.');
            return;
        }
        if (discountAmount > originalPrice) {
            alert('Discount amount cannot be greater than original price.');
            return;
        }
        discountPercent = (discountAmount / originalPrice) * 100;
    } else {
        discountPercent = parseFloat(document.getElementById('discount_percent').value);
        if (discountPercent === undefined || discountPercent < 0 || discountPercent > 100) {
            alert('Please enter a valid discount percentage (0-100).');
            return;
        }
        discountAmount = (discountPercent / 100) * originalPrice;
    }

    const finalPrice = originalPrice - discountAmount;
    const currency = document.getElementById('currency').value;
    const symbol = currencySymbols[currency];

    // Display results
    displayResults(originalPrice, discountAmount, discountPercent, finalPrice, symbol);
}

function displayResults(originalPrice, discountAmount, discountPercent, finalPrice, symbol) {
    // Update main display cards
    document.getElementById('original-display').textContent = symbol + originalPrice.toFixed(2);
    document.getElementById('discount-display').textContent = '-' + symbol + discountAmount.toFixed(2);
    document.getElementById('final-display').textContent = symbol + finalPrice.toFixed(2);

    // Update detailed table
    document.getElementById('original-price-row').textContent = symbol + originalPrice.toFixed(2);
    document.getElementById('discount-percentage-row').textContent = discountPercent.toFixed(2) + '%';
    document.getElementById('discount-amount-row').textContent = '-' + symbol + discountAmount.toFixed(2);
    document.getElementById('final-price-row').textContent = symbol + finalPrice.toFixed(2);
    document.getElementById('amount-saved-row').textContent = symbol + discountAmount.toFixed(2);
    document.getElementById('savings-percentage-row').textContent = discountPercent.toFixed(2) + '%';

    // Update multiple items calculation
    updateMultipleItems();

    document.getElementById('resultsContainer').style.display = 'block';
}

function updateMultipleItems() {
    const quantity = parseInt(document.getElementById('quantity').value) || 1;
    const finalPriceText = document.getElementById('final-display').textContent;

    if (finalPriceText && finalPriceText !== '$0.00') {
        const currency = document.getElementById('currency').value;
        const symbol = currencySymbols[currency];
        const finalPrice = parseFloat(finalPriceText.replace(/[^0-9.-]+/g,""));
        const totalMultiple = finalPrice * quantity;

        document.getElementById('qty-display').textContent = quantity;
        document.getElementById('total-multiple').textContent = symbol + totalMultiple.toFixed(2);
    }
}

function useExample(price, discount) {
    document.getElementById('original_price').value = price;
    document.getElementById('discount_percent').value = discount;
    document.getElementById('use-discount-amount').checked = false;
    document.getElementById('discount-amount-input').style.display = 'none';
    document.getElementById('discount_percent').disabled = false;
    calculateDiscount();
}

function clearAll() {
    document.getElementById('original_price').value = '';
    document.getElementById('discount_percent').value = '';
    document.getElementById('discount_amount').value = '';
    document.getElementById('quantity').value = '1';
    document.getElementById('use-discount-amount').checked = false;
    document.getElementById('discount-amount-input').style.display = 'none';
    document.getElementById('discount_percent').disabled = false;
    document.getElementById('resultsContainer').style.display = 'none';
}

function copyResults() {
    const originalPrice = document.getElementById('original-display').textContent;
    const discount = document.getElementById('discount-display').textContent;
    const finalPrice = document.getElementById('final-display').textContent;

    const textToCopy = `Discount Calculator Results:\\nOriginal Price: ${originalPrice}\\nDiscount: ${discount}\\nFinal Price: ${finalPrice}`;

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

function shareResults() {
    const originalPrice = document.getElementById('original-display').textContent;
    const discount = document.getElementById('discount-display').textContent;
    const finalPrice = document.getElementById('final-display').textContent;

    const shareText = `Check out this discount calculation: ${originalPrice} with ${discount} discount = ${finalPrice} final price!`;

    if (navigator.share) {
        navigator.share({
            title: 'Discount Calculation',
            text: shareText
        });
    } else {
        // Fallback to copy to clipboard
        navigator.clipboard.writeText(shareText);
        alert('Results copied to clipboard!');
    }
}

// Auto-calculate when values change
document.getElementById('original_price').addEventListener('input', function() {
    if (this.value && (document.getElementById('discount_percent').value || document.getElementById('discount_amount').value)) {
        calculateDiscount();
    }
});

document.getElementById('discount_percent').addEventListener('input', function() {
    if (this.value && document.getElementById('original_price').value) {
        calculateDiscount();
    }
});

document.getElementById('discount_amount').addEventListener('input', function() {
    if (this.value && document.getElementById('original_price').value) {
        calculateDiscount();
    }
});
</script>
