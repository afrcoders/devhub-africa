{{-- Palindrome Checker --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Palindrome Checker tool to verify if text reads the same forwards and backwards.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-search me-3"></i>Palindrome Checker
                </h1>
                <p class="lead text-muted">
                    Check if a word, phrase, or number is a palindrome
                </p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-check-circle me-2"></i>Palindrome Verification</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label for="textInput" class="form-label fw-semibold">
                            <i class="fas fa-edit me-2"></i>Text to Check
                        </label>
                        <input type="text" class="form-control form-control-lg" id="textInput"
                            placeholder="Enter text to check if it's a palindrome..."
                            style="font-size: 1.1rem;">
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Spaces, punctuation, and capitalization will be ignored.
                        </div>
                    </div>

                    <div class="text-center mb-4">
                        <button type="button" id="checkBtn" class="btn btn-primary btn-lg">
                            <i class="fas fa-search me-2"></i>Check Palindrome
                        </button>
                        <button type="button" id="clearBtn" class="btn btn-outline-secondary btn-lg ms-3">
                            <i class="fas fa-trash-alt me-2"></i>Clear
                        </button>
                    </div>

                    <div id="resultSection" style="display: none;">
                        <div class="border-top pt-4">
                            <div class="text-center">
                                <div id="resultBadge"></div>
                                <div class="mt-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h6 class="card-title">Original</h6>
                                                    <p class="card-text" id="originalText"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h6 class="card-title">Cleaned & Reversed</h6>
                                                    <p class="card-text" id="reversedText"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Examples section --}}
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Palindrome Examples</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Words</h6>
                            <ul class="small">
                                <li>racecar</li>
                                <li>level</li>
                                <li>noon</li>
                                <li>madam</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Phrases</h6>
                            <ul class="small">
                                <li>A man a plan a canal Panama</li>
                                <li>Was it a car or a cat I saw?</li>
                                <li>Madam, I'm Adam</li>
                                <li>Never odd or even</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const textInput = document.getElementById('textInput');
    const checkBtn = document.getElementById('checkBtn');
    const clearBtn = document.getElementById('clearBtn');
    const resultSection = document.getElementById('resultSection');
    const resultBadge = document.getElementById('resultBadge');
    const originalText = document.getElementById('originalText');
    const reversedText = document.getElementById('reversedText');

    function isPalindrome(str) {
        // Remove non-alphanumeric characters and convert to lowercase
        const cleaned = str.replace(/[^a-zA-Z0-9]/g, '').toLowerCase();
        const reversed = cleaned.split('').reverse().join('');
        return { cleaned, reversed, isPalindrome: cleaned === reversed };
    }

    function checkPalindrome() {
        const text = textInput.value.trim();

        if (!text) {
            alert('Please enter some text to check.');
            return;
        }

        const result = isPalindrome(text);

        originalText.textContent = result.cleaned;
        reversedText.textContent = result.reversed;

        if (result.isPalindrome) {
            resultBadge.innerHTML = '<span class="badge bg-success fs-5 p-3"><i class="fas fa-check-circle me-2"></i>Yes, it\'s a palindrome!</span>';
        } else {
            resultBadge.innerHTML = '<span class="badge bg-danger fs-5 p-3"><i class="fas fa-times-circle me-2"></i>No, it\'s not a palindrome</span>';
        }

        resultSection.style.display = 'block';
    }

    function clearAll() {
        textInput.value = '';
        resultSection.style.display = 'none';
        textInput.focus();
    }

    checkBtn.addEventListener('click', checkPalindrome);
    clearBtn.addEventListener('click', clearAll);

    // Check on Enter key
    textInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            checkPalindrome();
        }
    });

    // Real-time checking
    textInput.addEventListener('input', function() {
        if (textInput.value.trim()) {
            checkPalindrome();
        } else {
            resultSection.style.display = 'none';
        }
    });
});
</script>
