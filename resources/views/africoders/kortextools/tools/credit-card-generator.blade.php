{{-- Credit Card Generator --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-credit-card me-2"></i>
    Generate valid test credit card numbers for development and testing purposes.
</div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-credit-card me-2"></i>
                        {{ $tool->name }}
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">{{ $tool->description }}</p>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="cardType" class="form-label">Card Type</label>
                                        <select class="form-select" id="cardType">
                                            <option value="visa">Visa</option>
                                            <option value="mastercard">MasterCard</option>
                                            <option value="amex">American Express</option>
                                            <option value="discover">Discover</option>
                                            <option value="diners">Diners Club</option>
                                            <option value="jcb">JCB</option>
                                            <option value="random">Random Type</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Number of Cards</label>
                                        <select class="form-select" id="quantity">
                                            <option value="1">1 Card</option>
                                            <option value="5">5 Cards</option>
                                            <option value="10">10 Cards</option>
                                            <option value="25">25 Cards</option>
                                            <option value="50">50 Cards</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeCVV">
                                    <label class="form-check-label" for="includeCVV">
                                        Include CVV Code
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeExpiry" checked>
                                    <label class="form-check-label" for="includeExpiry">
                                        Include Expiry Date
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeHolderName">
                                    <label class="form-check-label" for="includeHolderName">
                                        Include Cardholder Name
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button type="button" class="btn btn-primary" id="generateBtn">
                                    <i class="fas fa-magic me-2"></i>Generate Credit Cards
                                </button>
                            </div>

                            <div class="mb-3" style="display: none;" id="warningSection">
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Disclaimer:</strong> These are randomly generated test credit card numbers for development and testing purposes only.
                                    They are not real credit cards and cannot be used for actual transactions.
                                </div>
                            </div>

                            <div class="mb-3" style="display: none;" id="resultSection">
                                <label class="form-label">Generated Credit Cards</label>
                                <div id="cardResults" class="border rounded p-3" style="max-height: 400px; overflow-y: auto;"></div>
                            </div>

                            <div class="row" style="display: none;" id="actionSection">
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-secondary w-100" id="copyBtn">
                                        <i class="fas fa-copy me-2"></i>Copy All
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-success w-100" id="downloadBtn">
                                        <i class="fas fa-download me-2"></i>Download
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-warning w-100" id="clearBtn">
                                        <i class="fas fa-trash me-2"></i>Clear
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const cardType = document.getElementById('cardType');
const quantity = document.getElementById('quantity');
const includeCVV = document.getElementById('includeCVV');
const includeExpiry = document.getElementById('includeExpiry');
const includeHolderName = document.getElementById('includeHolderName');
const generateBtn = document.getElementById('generateBtn');
const warningSection = document.getElementById('warningSection');
const resultSection = document.getElementById('resultSection');
const cardResults = document.getElementById('cardResults');
const actionSection = document.getElementById('actionSection');
const copyBtn = document.getElementById('copyBtn');
const downloadBtn = document.getElementById('downloadBtn');
const clearBtn = document.getElementById('clearBtn');

let generatedCards = [];

// Card type configurations
const cardTypes = {
    visa: {
        name: 'Visa',
        prefixes: ['4'],
        lengths: [16],
        cvvLength: 3
    },
    mastercard: {
        name: 'MasterCard',
        prefixes: ['5'],
        lengths: [16],
        cvvLength: 3
    },
    amex: {
        name: 'American Express',
        prefixes: ['34', '37'],
        lengths: [15],
        cvvLength: 4
    },
    discover: {
        name: 'Discover',
        prefixes: ['6'],
        lengths: [16],
        cvvLength: 3
    },
    diners: {
        name: 'Diners Club',
        prefixes: ['30'],
        lengths: [14],
        cvvLength: 3
    },
    jcb: {
        name: 'JCB',
        prefixes: ['35'],
        lengths: [16],
        cvvLength: 3
    }
};

// Random name generator
const firstNames = ['John', 'Jane', 'Michael', 'Sarah', 'David', 'Emily', 'Robert', 'Lisa', 'William', 'Jennifer'];
const lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez'];

// Generate random number
function randomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

// Luhn algorithm for card number validation
function luhnChecksum(num) {
    const digits = num.toString().split('').map(Number);
    let sum = 0;
    let isEven = false;

    for (let i = digits.length - 1; i >= 0; i--) {
        let digit = digits[i];

        if (isEven) {
            digit *= 2;
            if (digit > 9) {
                digit -= 9;
            }
        }

        sum += digit;
        isEven = !isEven;
    }

    return sum % 10;
}

// Generate valid card number using Luhn algorithm
function generateCardNumber(type) {
    const config = cardTypes[type];
    const prefix = config.prefixes[Math.floor(Math.random() * config.prefixes.length)];
    const length = config.lengths[0];

    // Start with prefix
    let cardNumber = prefix;

    // Fill remaining digits (except check digit)
    while (cardNumber.length < length - 1) {
        cardNumber += randomInt(0, 9);
    }

    // Calculate check digit
    const checkDigit = (10 - luhnChecksum(cardNumber + '0')) % 10;
    cardNumber += checkDigit;

    return cardNumber;
}

// Generate CVV
function generateCVV(type) {
    const length = cardTypes[type].cvvLength;
    let cvv = '';
    for (let i = 0; i < length; i++) {
        cvv += randomInt(0, 9);
    }
    return cvv;
}

// Generate expiry date (future date)
function generateExpiry() {
    const currentYear = new Date().getFullYear();
    const year = randomInt(currentYear + 1, currentYear + 6);
    const month = randomInt(1, 12).toString().padStart(2, '0');
    const yearShort = year.toString().substr(-2);
    return `${month}/${yearShort}`;
}

// Generate cardholder name
function generateHolderName() {
    const firstName = firstNames[Math.floor(Math.random() * firstNames.length)];
    const lastName = lastNames[Math.floor(Math.random() * lastNames.length)];
    return `${firstName} ${lastName}`.toUpperCase();
}

// Format card number with spaces
function formatCardNumber(number) {
    return number.replace(/(.{4})/g, '$1 ').trim();
}

// Generate button click
generateBtn.addEventListener('click', function() {
    const selectedType = cardType.value;
    const count = parseInt(quantity.value);

    generatedCards = [];
    cardResults.innerHTML = '';

    // Get random types if "random" is selected
    const types = selectedType === 'random' ? Object.keys(cardTypes) : [selectedType];

    for (let i = 0; i < count; i++) {
        const randomType = types[Math.floor(Math.random() * types.length)];
        const card = {
            number: generateCardNumber(randomType),
            type: cardTypes[randomType].name,
            cvv: includeCVV.checked ? generateCVV(randomType) : null,
            expiry: includeExpiry.checked ? generateExpiry() : null,
            holder: includeHolderName.checked ? generateHolderName() : null
        };

        generatedCards.push(card);
    }

    displayCards();
    warningSection.style.display = 'block';
    resultSection.style.display = 'block';
    actionSection.style.display = 'block';
});

// Display generated cards
function displayCards() {
    cardResults.innerHTML = '';

    generatedCards.forEach((card, index) => {
        const cardDiv = document.createElement('div');
        cardDiv.className = 'card mb-2';

        let cardInfo = `
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h6 class="card-title mb-1">${card.type}</h6>
                        <div class="font-monospace fw-bold text-primary">${formatCardNumber(card.number)}</div>
                        ${card.expiry ? `<small class="text-muted">Expiry: ${card.expiry}</small>` : ''}
                        ${card.cvv ? `<span class="text-muted ms-3">CVV: ${card.cvv}</span>` : ''}
                        ${card.holder ? `<div class="text-muted mt-1">${card.holder}</div>` : ''}
                    </div>
                    <div class="col-md-4 text-end">
                        <button class="btn btn-sm btn-outline-primary" onclick="copyCard(${index})">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                    </div>
                </div>
            </div>
        `;

        cardDiv.innerHTML = cardInfo;
        cardResults.appendChild(cardDiv);
    });
}

// Copy individual card
function copyCard(index) {
    const card = generatedCards[index];
    let text = `${card.number}`;
    if (card.expiry) text += `\nExpiry: ${card.expiry}`;
    if (card.cvv) text += `\nCVV: ${card.cvv}`;
    if (card.holder) text += `\nCardholder: ${card.holder}`;

    navigator.clipboard.writeText(text);
}

// Copy all cards
copyBtn.addEventListener('click', function() {
    let allCards = '';
    generatedCards.forEach((card, index) => {
        allCards += `Card ${index + 1}: ${card.type}\n`;
        allCards += `Number: ${card.number}\n`;
        if (card.expiry) allCards += `Expiry: ${card.expiry}\n`;
        if (card.cvv) allCards += `CVV: ${card.cvv}\n`;
        if (card.holder) allCards += `Cardholder: ${card.holder}\n`;
        allCards += '\n';
    });

    navigator.clipboard.writeText(allCards);

    const originalText = copyBtn.innerHTML;
    copyBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
    setTimeout(() => {
        copyBtn.innerHTML = originalText;
    }, 2000);
});

// Download as text file
downloadBtn.addEventListener('click', function() {
    let content = 'Generated Test Credit Cards\n';
    content += '============================\n\n';
    content += 'DISCLAIMER: These are test credit card numbers for development purposes only.\n';
    content += 'They are not real and cannot be used for actual transactions.\n\n';

    generatedCards.forEach((card, index) => {
        content += `Card ${index + 1}: ${card.type}\n`;
        content += `Number: ${card.number}\n`;
        if (card.expiry) content += `Expiry: ${card.expiry}\n`;
        if (card.cvv) content += `CVV: ${card.cvv}\n`;
        if (card.holder) content += `Cardholder: ${card.holder}\n`;
        content += '\n';
    });

    const blob = new Blob([content], { type: 'text/plain' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'test-credit-cards.txt';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
});

// Clear results
clearBtn.addEventListener('click', function() {
    generatedCards = [];
    cardResults.innerHTML = '';
    warningSection.style.display = 'none';
    resultSection.style.display = 'none';
    actionSection.style.display = 'none';
});
</script>
