<div class="card">
    <div class="card-header">
        <h5>Password Strength Checker</h5>
        <p class="text-muted small mb-0">Check how strong your password is</p>
    </div>
    <div class="card-body">
        <form id="passwordForm" class="tool-form">
            @csrf

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                <small class="text-muted">Your password is not stored or sent to any server</small>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-shield-alt"></i> Check Strength
                </button>
            </div>

            <!-- Results -->
            <div id="resultsContainer" style="display: none;">
                <div class="mt-4">
                    <h6>Password Analysis:</h6>

                    <div class="mt-3">
                        <div class="strength-meter">
                            <div id="strengthBar" class="progress" style="height: 25px;">
                                <div id="strengthFill" class="progress-bar" style="width: 0%;">
                                    <span id="strengthText" class="text-white fw-bold"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <small class="fw-bold">Character Requirements:</small>
                        <ul class="list-unstyled small">
                            <li><span id="checkLower" class="badge bg-secondary me-2">✗</span> Lowercase letters</li>
                            <li><span id="checkUpper" class="badge bg-secondary me-2">✗</span> Uppercase letters</li>
                            <li><span id="checkNumber" class="badge bg-secondary me-2">✗</span> Numbers</li>
                            <li><span id="checkSpecial" class="badge bg-secondary me-2">✗</span> Special characters</li>
                        </ul>
                    </div>

                    <div class="mt-3">
                        <small class="fw-bold">Suggestions:</small>
                        <ul id="feedbackList" class="list-unstyled small mt-2">
                        </ul>
                    </div>

                    <div class="mt-3">
                        <small class="text-muted">Length: <span id="passLength">0</span> characters</small>
                    </div>
                </div>
            </div>

            <!-- Error message -->
            <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
        </form>
    </div>
</div>

<script>
const strengthColors = {
    1: 'bg-danger',
    2: 'bg-warning',
    3: 'bg-info',
    4: 'bg-success',
    5: 'bg-success'
};

const strengthTexts = {
    1: 'Very Weak',
    2: 'Weak',
    3: 'Fair',
    4: 'Good',
    5: 'Strong'
};

document.getElementById('passwordForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const password = document.getElementById('password').value;
    const resultsContainer = document.getElementById('resultsContainer');
    const errorMessage = document.getElementById('errorMessage');

    if (!password) {
        errorMessage.textContent = 'Please enter a password';
        errorMessage.style.display = 'block';
        return;
    }

    errorMessage.style.display = 'none';

    fetch('{{ route("tools.kortex.tool.submit", "password-strength-checker") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
        },
        body: JSON.stringify({ password: password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const strength = data.data.strength;
            document.getElementById('strengthFill').className = 'progress-bar ' + strengthColors[strength];
            document.getElementById('strengthFill').style.width = (strength * 20) + '%';
            document.getElementById('strengthText').textContent = strengthTexts[strength];
            document.getElementById('passLength').textContent = data.data.password_length;

            // Update checks
            updateCheck('checkLower', data.data.has_lowercase);
            updateCheck('checkUpper', data.data.has_uppercase);
            updateCheck('checkNumber', data.data.has_numbers);
            updateCheck('checkSpecial', data.data.has_special);

            // Update feedback
            const feedbackList = document.getElementById('feedbackList');
            feedbackList.innerHTML = '';
            data.data.feedback.forEach(item => {
                const li = document.createElement('li');
                li.innerHTML = '<i class="fas fa-info-circle me-2"></i>' + item;
                feedbackList.appendChild(li);
            });

            resultsContainer.style.display = 'block';
        } else {
            errorMessage.textContent = data.message || 'An error occurred';
            errorMessage.style.display = 'block';
        }
    })
    .catch(error => {
        errorMessage.textContent = 'Error: ' + error.message;
        errorMessage.style.display = 'block';
    });
});

function updateCheck(elementId, hasValue) {
    const element = document.getElementById(elementId);
    if (hasValue) {
        element.className = 'badge bg-success me-2';
        element.textContent = '✓';
    } else {
        element.className = 'badge bg-secondary me-2';
        element.textContent = '✗';
    }
}
</script>