{{-- Atbash Cipher --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Atbash Cipher tool for encoding and decoding text using the ancient Hebrew cipher.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-scroll me-3"></i>Atbash Cipher
                </h1>
                <p class="lead text-muted">
                    Encode and decode text using the ancient Atbash substitution cipher
                </p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-exchange-alt me-2"></i>Atbash Encoder/Decoder</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label for="textInput" class="form-label fw-semibold">
                            <i class="fas fa-edit me-2"></i>Input Text
                        </label>
                        <textarea class="form-control" id="textInput" rows="6"
                            placeholder="Enter text to encode/decode with Atbash cipher..."></textarea>
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Atbash substitutes each letter with its mirror letter in the alphabet (A↔Z, B↔Y, C↔X, etc.)
                        </div>
                    </div>

                    <div class="text-center mb-4">
                        <button type="button" id="convertBtn" class="btn btn-primary btn-lg">
                            <i class="fas fa-exchange-alt me-2"></i>Convert
                        </button>
                        <button type="button" id="clearBtn" class="btn btn-outline-secondary btn-lg ms-3">
                            <i class="fas fa-trash-alt me-2"></i>Clear
                        </button>
                    </div>

                    <div id="resultSection" style="display: none;">
                        <div class="border-top pt-4">
                            <label for="resultOutput" class="form-label fw-semibold">
                                <i class="fas fa-check-circle me-2 text-success"></i>Result
                            </label>
                            <textarea class="form-control" id="resultOutput" rows="6" readonly></textarea>
                            <div class="mt-2">
                                <button type="button" id="copyBtn" class="btn btn-outline-primary">
                                    <i class="fas fa-copy me-2"></i>Copy Result
                                </button>
                            </div>
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
    const resultOutput = document.getElementById('resultOutput');
    const resultSection = document.getElementById('resultSection');
    const convertBtn = document.getElementById('convertBtn');
    const clearBtn = document.getElementById('clearBtn');
    const copyBtn = document.getElementById('copyBtn');

    function atbashCipher(str) {
        return str.replace(/[a-zA-Z]/g, function(c) {
            if (c >= 'a' && c <= 'z') {
                return String.fromCharCode('z'.charCodeAt(0) - (c.charCodeAt(0) - 'a'.charCodeAt(0)));
            } else if (c >= 'A' && c <= 'Z') {
                return String.fromCharCode('Z'.charCodeAt(0) - (c.charCodeAt(0) - 'A'.charCodeAt(0)));
            }
            return c;
        });
    }

    function convertText() {
        const text = textInput.value;

        if (!text.trim()) {
            alert('Please enter some text to convert.');
            return;
        }

        const result = atbashCipher(text);
        resultOutput.value = result;
        resultSection.style.display = 'block';
    }

    function clearAll() {
        textInput.value = '';
        resultOutput.value = '';
        resultSection.style.display = 'none';
    }

    function copyResult() {
        resultOutput.select();
        document.execCommand('copy');

        const originalText = copyBtn.innerHTML;
        copyBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
        copyBtn.classList.replace('btn-outline-primary', 'btn-success');

        setTimeout(() => {
            copyBtn.innerHTML = originalText;
            copyBtn.classList.replace('btn-success', 'btn-outline-primary');
        }, 2000);
    }

    convertBtn.addEventListener('click', convertText);
    clearBtn.addEventListener('click', clearAll);
    copyBtn.addEventListener('click', copyResult);

    // Real-time conversion
    textInput.addEventListener('input', function() {
        if (textInput.value.trim()) {
            convertText();
        } else {
            resultSection.style.display = 'none';
        }
    });
});
</script>
