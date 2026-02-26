{{-- HTML Encoder/Decoder --}}
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-exchange-alt me-3"></i>HTML Encoder/Decoder
                </h1>
                <p class="lead text-muted">
                    Convert HTML special characters to entities and vice versa
                </p>
            </div>

            <!-- Mode Selection -->
            <div class="mb-4">
                <div class="btn-group w-100" role="group" aria-label="Mode selection">
                    <input type="radio" class="btn-check" name="mode" id="encode-mode" value="encode" checked>
                    <label class="btn btn-outline-primary" for="encode-mode">
                        <i class="fas fa-lock me-2"></i>Encode
                    </label>

                    <input type="radio" class="btn-check" name="mode" id="decode-mode" value="decode">
                    <label class="btn btn-outline-primary" for="decode-mode">
                        <i class="fas fa-unlock me-2"></i>Decode
                    </label>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-input-text me-2"></i><span id="inputLabel">Text to Encode</span></h5>
                        </div>
                        <div class="card-body">
                            <textarea id="htmlInput" class="form-control" rows="10" placeholder="Enter text to encode..." style="font-family: 'Courier New', monospace;"></textarea>
                            <div class="mt-3 d-grid gap-2">
                                <button type="button" id="processBtn" class="btn btn-primary">
                                    <i class="fas fa-wand-magic-sparkles me-2"></i><span id="processBtnText">Encode</span>
                                </button>
                                <button type="button" id="clearBtn" class="btn btn-secondary">
                                    <i class="fas fa-trash me-2"></i>Clear
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-check-circle me-2"></i><span id="outputLabel">Encoded Result</span></h5>
                        </div>
                        <div class="card-body">
                            <textarea id="htmlOutput" class="form-control" rows="10" readonly style="font-family: 'Courier New', monospace;"></textarea>
                            <div class="mt-3">
                                <button type="button" id="copyBtn" class="btn btn-info w-100">
                                    <i class="fas fa-copy me-2"></i>Copy to Clipboard
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
    const input = document.getElementById('htmlInput');
    const output = document.getElementById('htmlOutput');
    const processBtn = document.getElementById('processBtn');
    const clearBtn = document.getElementById('clearBtn');
    const copyBtn = document.getElementById('copyBtn');
    const encodeMode = document.getElementById('encode-mode');
    const decodeMode = document.getElementById('decode-mode');
    const inputLabel = document.getElementById('inputLabel');
    const outputLabel = document.getElementById('outputLabel');
    const processBtnText = document.getElementById('processBtnText');

    const modeRadios = document.querySelectorAll('input[name="mode"]');
    modeRadios.forEach(radio => {
        radio.addEventListener('change', updateLabels);
    });

    function updateLabels() {
        if (encodeMode.checked) {
            inputLabel.textContent = 'Text to Encode';
            outputLabel.textContent = 'Encoded Result';
            processBtnText.textContent = 'Encode';
        } else {
            inputLabel.textContent = 'HTML Entities to Decode';
            outputLabel.textContent = 'Decoded Result';
            processBtnText.textContent = 'Decode';
        }
    }

    processBtn.addEventListener('click', function() {
        const text = input.value;
        if (!text) {
            output.value = '';
            return;
        }

        if (encodeMode.checked) {
            output.value = encodeHTML(text);
        } else {
            output.value = decodeHTML(text);
        }
    });

    clearBtn.addEventListener('click', function() {
        input.value = '';
        output.value = '';
        input.focus();
    });

    copyBtn.addEventListener('click', function() {
        output.select();
        document.execCommand('copy');
        const originalText = copyBtn.innerHTML;
        copyBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
        setTimeout(() => {
            copyBtn.innerHTML = originalText;
        }, 2000);
    });

    function encodeHTML(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;',
            '/': '&#x2F;'
        };
        return text.replace(/[&<>"'\/]/g, char => map[char]);
    }

    function decodeHTML(text) {
        const map = {
            '&amp;': '&',
            '&lt;': '<',
            '&gt;': '>',
            '&quot;': '"',
            '&#39;': "'",
            '&#x2F;': '/',
            '&#47;': '/'
        };
        let result = text;
        for (const [entity, char] of Object.entries(map)) {
            result = result.replace(new RegExp(entity, 'g'), char);
        }
        // Handle numeric entities
        result = result.replace(/&#(\d+);/g, (match, dec) => String.fromCharCode(parseInt(dec, 10)));
        result = result.replace(/&#x([0-9a-f]+);/gi, (match, hex) => String.fromCharCode(parseInt(hex, 16)));
        return result;
    }
});
</script>
