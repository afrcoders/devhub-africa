{{-- UTF-8 Encoder --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    UTF-8 Encoder tool for encoding and decoding text to/from UTF-8 format.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-code me-3"></i>UTF-8 Encoder
                </h1>
                <p class="lead text-muted">
                    Encode and decode text to/from UTF-8 byte representation
                </p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-exchange-alt me-2"></i>UTF-8 Encoder/Decoder</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label for="textInput" class="form-label fw-semibold">
                            <i class="fas fa-edit me-2"></i>Input Text
                        </label>
                        <textarea class="form-control" id="textInput" rows="4"
                            placeholder="Enter text to encode or UTF-8 bytes to decode..."></textarea>
                    </div>

                    <div class="text-center mb-4">
                        <button type="button" id="encodeBtn" class="btn btn-primary">
                            <i class="fas fa-arrow-down me-2"></i>Encode to UTF-8
                        </button>
                        <button type="button" id="decodeBtn" class="btn btn-warning ms-2">
                            <i class="fas fa-arrow-up me-2"></i>Decode from UTF-8
                        </button>
                        <button type="button" id="clearBtn" class="btn btn-outline-secondary ms-3">
                            <i class="fas fa-trash-alt me-2"></i>Clear
                        </button>
                    </div>

                    <div id="resultSection" style="display: none;">
                        <div class="border-top pt-4">
                            <label for="resultOutput" class="form-label fw-semibold">
                                <i class="fas fa-check-circle me-2 text-success"></i>Result
                            </label>
                            <textarea class="form-control" id="resultOutput" rows="4" readonly></textarea>
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
    const encodeBtn = document.getElementById('encodeBtn');
    const decodeBtn = document.getElementById('decodeBtn');
    const clearBtn = document.getElementById('clearBtn');
    const copyBtn = document.getElementById('copyBtn');

    function encodeUtf8() {
        const text = textInput.value;

        if (!text.trim()) {
            alert('Please enter some text to encode.');
            return;
        }

        try {
            const bytes = new TextEncoder().encode(text);
            const result = Array.from(bytes).map(b => b.toString()).join(' ');
            resultOutput.value = result;
            resultSection.style.display = 'block';
        } catch (error) {
            alert('Error encoding text: ' + error.message);
        }
    }

    function decodeUtf8() {
        const text = textInput.value.trim();

        if (!text) {
            alert('Please enter UTF-8 bytes to decode.');
            return;
        }

        try {
            const bytes = text.split(/\s+/).map(b => parseInt(b, 10));
            const result = new TextDecoder().decode(new Uint8Array(bytes));
            resultOutput.value = result;
            resultSection.style.display = 'block';
        } catch (error) {
            alert('Error decoding UTF-8 bytes: ' + error.message);
        }
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

    encodeBtn.addEventListener('click', encodeUtf8);
    decodeBtn.addEventListener('click', decodeUtf8);
    clearBtn.addEventListener('click', clearAll);
    copyBtn.addEventListener('click', copyResult);
});
</script>
