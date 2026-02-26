{{-- ROT13 Converter --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    ROT13 Converter tool for encoding and decoding text using the ROT13 cipher.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-lock me-3"></i>ROT13 Converter
                </h1>
                <p class="lead text-muted">
                    Encode and decode text using the ROT13 cipher algorithm
                </p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-exchange-alt me-2"></i>ROT13 Encoder/Decoder</h5>
                </div>
                <div class="card-body">
                    <form id="rot13Form">
                        <div class="mb-4">
                            <label for="textInput" class="form-label fw-semibold">
                                <i class="fas fa-edit me-2"></i>Input Text
                            </label>
                            <textarea class="form-control" id="textInput" rows="6"
                                placeholder="Enter text to encode/decode with ROT13..."></textarea>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                ROT13 is a simple letter substitution cipher that replaces each letter with the letter 13 positions after it in the alphabet.
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
                    </form>

                    <div id="resultSection" style="display: none;">
                        <div class="border-top pt-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-4">
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

            {{-- How it works section --}}
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>How ROT13 Works</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>What is ROT13?</h6>
                            <p class="small">ROT13 (rotate by 13 places) is a simple letter substitution cipher that replaces each letter with the letter 13 positions after it in the alphabet. Numbers and special characters remain unchanged.</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Key Features</h6>
                            <ul class="small">
                                <li>Symmetric encryption (encoding = decoding)</li>
                                <li>Preserves letter case</li>
                                <li>Only affects letters A-Z</li>
                                <li>Commonly used in forums and newsgroups</li>
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
    const resultOutput = document.getElementById('resultOutput');
    const resultSection = document.getElementById('resultSection');
    const convertBtn = document.getElementById('convertBtn');
    const clearBtn = document.getElementById('clearBtn');
    const copyBtn = document.getElementById('copyBtn');

    function rot13(str) {
        return str.replace(/[a-zA-Z]/g, function(c) {
            return String.fromCharCode(
                c <= 'Z' ? ((c.charCodeAt(0) - 65 + 13) % 26) + 65
                         : ((c.charCodeAt(0) - 97 + 13) % 26) + 97
            );
        });
    }

    function convertText() {
        const text = textInput.value.trim();

        if (!text) {
            alert('Please enter some text to convert.');
            return;
        }

        const result = rot13(text);
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

    // Event listeners
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
