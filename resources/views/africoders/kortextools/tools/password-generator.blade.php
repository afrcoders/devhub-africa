<form id="password-generator-form" class="needs-validation">
    <!-- Password Length -->
    <div class="mb-3">
        <label for="password-length" class="form-label">Password Length</label>
        <div class="d-flex align-items-center gap-3">
            <input
                type="range"
                class="form-range"
                id="password-length"
                name="length"
                min="4"
                max="128"
                value="16"
            >
            <input
                type="number"
                class="form-control"
                id="length-display"
                value="16"
                min="4"
                max="128"
                style="width: 80px;"
            >
        </div>
        <small class="form-text text-muted d-block mt-2">Between 4 and 128 characters</small>
    </div>

    <!-- Character Options -->
    <div class="mb-3">
        <h6 class="form-label">Include Characters</h6>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="include-uppercase" checked>
            <label class="form-check-label" for="include-uppercase">
                Uppercase Letters (A-Z)
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="include-lowercase" checked>
            <label class="form-check-label" for="include-lowercase">
                Lowercase Letters (a-z)
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="include-numbers" checked>
            <label class="form-check-label" for="include-numbers">
                Numbers (0-9)
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="include-symbols" checked>
            <label class="form-check-label" for="include-symbols">
                Special Characters (!@#$%^&*)
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="exclude-ambiguous">
            <label class="form-check-label" for="exclude-ambiguous">
                Exclude Ambiguous Characters (l, 1, O, 0)
            </label>
        </div>
    </div>

    <!-- Strength Indicator -->
    <div class="mb-3">
        <label class="form-label">Password Strength</label>
        <div class="progress" style="height: 25px;">
            <div id="strength-bar" class="progress-bar" role="progressbar" style="width: 0%">
                <span id="strength-text" class="d-flex align-items-center h-100 px-2" style="font-size: 0.875rem;">
                    Strength
                </span>
            </div>
        </div>
    </div>

    <!-- Generated Password Section -->
    <div id="password-output-section" class="mt-4" style="display: none;">
        <label class="form-label">Generated Password</label>
        <div class="output-box">
            <div class="input-group">
                <input
                    type="text"
                    class="form-control"
                    id="generated-password"
                    readonly
                    style="font-family: 'Courier New', monospace; font-size: 1.25rem; letter-spacing: 2px;"
                >
                <button type="button" class="btn btn-outline-secondary" onclick="copyPasswordToClipboard()">
                    <i class="bi bi-clipboard me-2"></i>Copy
                </button>
                <button type="button" class="btn btn-outline-primary" onclick="generatePassword()">
                    <i class="bi bi-arrow-repeat me-2"></i>Regenerate
                </button>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
        <button
            type="button"
            class="btn btn-secondary"
            onclick="resetGenerator()"
        >
            <i class="bi bi-arrow-clockwise me-2"></i>Reset
        </button>
        <button type="button" class="btn btn-primary" onclick="generatePassword()">
            <i class="bi bi-lightning-charge me-2"></i>Generate Password
        </button>
    </div>
</form>

<script>
const lengthSlider = document.getElementById('password-length');
const lengthDisplay = document.getElementById('length-display');
const strengthBar = document.getElementById('strength-bar');
const strengthText = document.getElementById('strength-text');

// Sync length input and slider
lengthSlider.addEventListener('input', function() {
    lengthDisplay.value = this.value;
});

lengthDisplay.addEventListener('change', function() {
    lengthSlider.value = this.value;
});

function generatePassword() {
    const length = parseInt(document.getElementById('password-length').value);
    const includeUppercase = document.getElementById('include-uppercase').checked;
    const includeLowercase = document.getElementById('include-lowercase').checked;
    const includeNumbers = document.getElementById('include-numbers').checked;
    const includeSymbols = document.getElementById('include-symbols').checked;
    const excludeAmbiguous = document.getElementById('exclude-ambiguous').checked;

    if (!includeUppercase && !includeLowercase && !includeNumbers && !includeSymbols) {
        alert('Please select at least one character type');
        return;
    }

    let chars = '';
    let uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    let lowercase = 'abcdefghijklmnopqrstuvwxyz';
    let numbers = '0123456789';
    let symbols = '!@#$%^&*()_+-=[]{}|;:,.<>?';

    if (excludeAmbiguous) {
        uppercase = uppercase.replace(/[LO]/g, '');
        lowercase = lowercase.replace(/l/g, '');
        numbers = numbers.replace(/[01]/g, '');
    }

    if (includeUppercase) chars += uppercase;
    if (includeLowercase) chars += lowercase;
    if (includeNumbers) chars += numbers;
    if (includeSymbols) chars += symbols;

    let password = '';
    for (let i = 0; i < length; i++) {
        password += chars.charAt(Math.floor(Math.random() * chars.length));
    }

    document.getElementById('generated-password').value = password;
    document.getElementById('password-output-section').style.display = 'block';

    updateStrength(password);
}

function updateStrength(password) {
    let strength = 0;

    if (password.length >= 8) strength += 20;
    if (password.length >= 12) strength += 20;
    if (/[a-z]/.test(password)) strength += 20;
    if (/[A-Z]/.test(password)) strength += 20;
    if (/[0-9]/.test(password)) strength += 10;
    if (/[!@#$%^&*()_+\-=\[\]{}|;:,.<>?]/.test(password)) strength += 10;

    strengthBar.style.width = strength + '%';

    if (strength < 30) {
        strengthBar.className = 'progress-bar bg-danger';
        strengthText.textContent = 'Weak';
    } else if (strength < 60) {
        strengthBar.className = 'progress-bar bg-warning';
        strengthText.textContent = 'Fair';
    } else if (strength < 80) {
        strengthBar.className = 'progress-bar bg-info';
        strengthText.textContent = 'Good';
    } else {
        strengthBar.className = 'progress-bar bg-success';
        strengthText.textContent = 'Strong';
    }
}

function copyPasswordToClipboard() {
    const password = document.getElementById('generated-password');
    password.select();
    document.execCommand('copy');
    alert('Password copied to clipboard!');
}

function resetGenerator() {
    document.getElementById('password-length').value = 16;
    document.getElementById('length-display').value = 16;
    document.getElementById('password-output-section').style.display = 'none';
}

// Generate initial password
generatePassword();
</script>

<style>
.output-box {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 1rem;
}

.input-group .btn {
    border-color: #dee2e6;
}
</style>
