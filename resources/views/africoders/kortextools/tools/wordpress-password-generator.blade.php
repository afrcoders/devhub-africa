{{-- WordPress Password Generator --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-key me-2"></i>
    Generate secure passwords for WordPress users and applications.
</div>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="text-center mb-4">
                <h1 class="h2 mb-3">
                    <i class="fab fa-wordpress text-primary me-2"></i>
                    WordPress Password Generator
                </h1>
                <p class="text-muted">Generate secure passwords specifically designed for WordPress sites</p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <form id="wpPasswordForm">
                        <!-- Password Length -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password Length</label>
                            <div class="row align-items-center">
                                <div class="col">
                                    <input type="range" class="form-range" id="lengthSlider" min="8" max="50" value="16">
                                </div>
                                <div class="col-auto">
                                    <span class="badge bg-primary fs-6" id="lengthValue">16</span>
                                </div>
                            </div>
                        </div>

                        <!-- Character Options -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Character Types</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="includeUppercase" checked>
                                        <label class="form-check-label" for="includeUppercase">
                                            Uppercase Letters (A-Z)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="includeLowercase" checked>
                                        <label class="form-check-label" for="includeLowercase">
                                            Lowercase Letters (a-z)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="includeNumbers" checked>
                                        <label class="form-check-label" for="includeNumbers">
                                            Numbers (0-9)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="includeSymbols" checked>
                                        <label class="form-check-label" for="includeSymbols">
                                            Special Characters (!@#$%^&*)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- WordPress Specific Options -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">WordPress Options</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="wpCompliant" checked>
                                <label class="form-check-label" for="wpCompliant">
                                    WordPress Compliant (avoid problematic characters)
                                </label>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary btn-lg w-100" id="generateBtn">
                            <i class="fas fa-key me-2"></i>Generate WordPress Password
                        </button>
                    </form>

                    <!-- Generated Password -->
                    <div id="passwordResult" class="mt-4" style="display: none;">
                        <label class="form-label fw-semibold">Generated Password</label>
                        <div class="input-group">
                            <input type="text" class="form-control font-monospace" id="generatedPassword" readonly>
                            <button class="btn btn-outline-secondary" type="button" id="copyBtn">
                                <i class="fas fa-copy"></i> Copy
                            </button>
                        </div>

                        <!-- Password Strength -->
                        <div class="mt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Password Strength:</span>
                                <span id="strengthText" class="fw-semibold"></span>
                            </div>
                            <div class="progress mt-1" style="height: 6px;">
                                <div id="strengthBar" class="progress-bar" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="d-flex gap-2 mt-3">
                        <button type="button" class="btn btn-outline-primary" onclick="generatePassword(8)">Quick 8</button>
                        <button type="button" class="btn btn-outline-primary" onclick="generatePassword(12)">Quick 12</button>
                        <button type="button" class="btn btn-outline-primary" onclick="generatePassword(16)">Quick 16</button>
                        <button type="button" class="btn btn-outline-primary" onclick="generatePassword(24)">Quick 24</button>
                    </div>
                </div>
            </div>

            <!-- Tips -->
            <div class="card mt-4 bg-light border-0">
                <div class="card-body">
                    <h5 class="card-title">WordPress Security Tips</h5>
                    <ul class="mb-0 text-muted small">
                        <li>Use a unique password for your WordPress admin account</li>
                        <li>Consider using a password manager to store complex passwords</li>
                        <li>Change default usernames like "admin" to something unique</li>
                        <li>Enable two-factor authentication for additional security</li>
                        <li>Regularly update WordPress and plugins</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const lengthSlider = document.getElementById('lengthSlider');
    const lengthValue = document.getElementById('lengthValue');
    const generateBtn = document.getElementById('generateBtn');
    const generatedPassword = document.getElementById('generatedPassword');
    const passwordResult = document.getElementById('passwordResult');
    const copyBtn = document.getElementById('copyBtn');
    const strengthText = document.getElementById('strengthText');
    const strengthBar = document.getElementById('strengthBar');

    // Update length display
    lengthSlider.addEventListener('input', function() {
        lengthValue.textContent = this.value;
    });

    // Generate password
    generateBtn.addEventListener('click', generateWordPressPassword);

    // Copy password
    copyBtn.addEventListener('click', function() {
        generatedPassword.select();
        document.execCommand('copy');

        const originalText = this.innerHTML;
        this.innerHTML = '<i class="fas fa-check"></i> Copied!';
        this.classList.replace('btn-outline-secondary', 'btn-success');

        setTimeout(() => {
            this.innerHTML = originalText;
            this.classList.replace('btn-success', 'btn-outline-secondary');
        }, 2000);
    });

    function generateWordPressPassword() {
        const length = parseInt(lengthSlider.value);
        const includeUppercase = document.getElementById('includeUppercase').checked;
        const includeLowercase = document.getElementById('includeLowercase').checked;
        const includeNumbers = document.getElementById('includeNumbers').checked;
        const includeSymbols = document.getElementById('includeSymbols').checked;
        const wpCompliant = document.getElementById('wpCompliant').checked;

        let charset = '';

        if (includeUppercase) charset += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if (includeLowercase) charset += 'abcdefghijklmnopqrstuvwxyz';
        if (includeNumbers) charset += '0123456789';

        if (includeSymbols) {
            if (wpCompliant) {
                // WordPress-friendly special characters (avoid quotes, backslashes, etc.)
                charset += '!@#$%^&*()-_=+[]{}|;:,.<>?';
            } else {
                charset += '!@#$%^&*()-_=+[]{}|;:\'",.<>?/~`\\';
            }
        }

        if (charset === '') {
            alert('Please select at least one character type.');
            return;
        }

        let password = '';
        for (let i = 0; i < length; i++) {
            password += charset.charAt(Math.floor(Math.random() * charset.length));
        }

        generatedPassword.value = password;
        passwordResult.style.display = 'block';
        calculateStrength(password);

        // Scroll to result
        passwordResult.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function calculateStrength(password) {
        let score = 0;

        // Length score
        if (password.length >= 8) score += 1;
        if (password.length >= 12) score += 1;
        if (password.length >= 16) score += 1;

        // Character variety score
        if (/[a-z]/.test(password)) score += 1;
        if (/[A-Z]/.test(password)) score += 1;
        if (/[0-9]/.test(password)) score += 1;
        if (/[^a-zA-Z0-9]/.test(password)) score += 1;

        // Determine strength
        let strength, color, width;
        if (score <= 2) {
            strength = 'Weak';
            color = 'bg-danger';
            width = 25;
        } else if (score <= 4) {
            strength = 'Medium';
            color = 'bg-warning';
            width = 50;
        } else if (score <= 6) {
            strength = 'Strong';
            color = 'bg-success';
            width = 75;
        } else {
            strength = 'Very Strong';
            color = 'bg-success';
            width = 100;
        }

        strengthText.textContent = strength;
        strengthBar.className = `progress-bar ${color}`;
        strengthBar.style.width = width + '%';
    }

    // Quick generate functions
    window.generatePassword = function(length) {
        lengthSlider.value = length;
        lengthValue.textContent = length;
        generateWordPressPassword();
    };

    // Generate initial password
    generateWordPressPassword();
});
</script>

<style>
.font-monospace {
    font-family: 'Courier New', monospace;
    font-size: 1.1em;
}

.tool-card {
    transition: all 0.3s ease;
}

.form-range::-webkit-slider-thumb {
    background-color: var(--bs-primary);
}

.form-range::-moz-range-thumb {
    background-color: var(--bs-primary);
    border: none;
}
</style>

