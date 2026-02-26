{{-- Caesar Cipher --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Caesar Cipher tool for encoding and decoding text using customizable shift values.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-shield-alt me-3"></i>Caesar Cipher
                </h1>
                <p class="lead text-muted">
                    Encode and decode text using the Caesar cipher with custom shift values
                </p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-key me-2"></i>Caesar Cipher Tool</h5>
                </div>
                <div class="card-body">
                    <form id="caesarForm">
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="textInput" class="form-label fw-semibold">
                                    <i class="fas fa-edit me-2"></i>Input Text
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label for="shiftInput" class="form-label fw-semibold">
                                    <i class="fas fa-arrow-right me-2"></i>Shift Value
                                </label>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-8">
                                <textarea class="form-control" id="textInput" rows="6"
                                    placeholder="Enter text to encode/decode..."></textarea>
                            </div>
                            <div class="col-md-4">
                                <input type="number" class="form-control" id="shiftInput" value="3" min="-25" max="25">
                                <div class="form-text">
                                    <small>Range: -25 to 25</small>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mb-4">
                            <button type="button" id="encodeBtn" class="btn btn-primary">
                                <i class="fas fa-lock me-2"></i>Encode
                            </button>
                            <button type="button" id="decodeBtn" class="btn btn-warning ms-2">
                                <i class="fas fa-unlock me-2"></i>Decode
                            </button>
                            <button type="button" id="clearBtn" class="btn btn-outline-secondary ms-3">
                                <i class="fas fa-trash-alt me-2"></i>Clear
                            </button>
                        </div>
                    </form>

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
    const shiftInput = document.getElementById('shiftInput');
    const resultOutput = document.getElementById('resultOutput');
    const resultSection = document.getElementById('resultSection');
    const encodeBtn = document.getElementById('encodeBtn');
    const decodeBtn = document.getElementById('decodeBtn');
    const clearBtn = document.getElementById('clearBtn');
    const copyBtn = document.getElementById('copyBtn');

    function caesarCipher(str, shift) {
        return str.replace(/[a-zA-Z]/g, function(c) {
            const start = c <= 'Z' ? 65 : 97;
            return String.fromCharCode(((c.charCodeAt(0) - start + shift + 26) % 26) + start);
        });
    }

    function encode() {
        const text = textInput.value;
        const shift = parseInt(shiftInput.value) || 0;

        if (!text.trim()) {
            alert('Please enter some text to encode.');
            return;
        }

        const result = caesarCipher(text, shift);
        resultOutput.value = result;
        resultSection.style.display = 'block';
    }

    function decode() {
        const text = textInput.value;
        const shift = -(parseInt(shiftInput.value) || 0);

        if (!text.trim()) {
            alert('Please enter some text to decode.');
            return;
        }

        const result = caesarCipher(text, shift);
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

    encodeBtn.addEventListener('click', encode);
    decodeBtn.addEventListener('click', decode);
    clearBtn.addEventListener('click', clearAll);
    copyBtn.addEventListener('click', copyResult);
});
</script>
