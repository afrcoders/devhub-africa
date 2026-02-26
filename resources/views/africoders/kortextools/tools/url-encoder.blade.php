{{-- URL Encoder/Decoder --}}
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-link me-3"></i>URL Encoder/Decoder
                </h1>
                <p class="lead text-muted">
                    Encode URLs and decode URL-encoded strings
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
                            <h5 class="mb-0"><i class="fas fa-input-text me-2"></i><span id="inputLabel">URL/Text to Encode</span></h5>
                        </div>
                        <div class="card-body">
                            <textarea id="urlInput" class="form-control" rows="10" placeholder="Enter text or URL to encode..." style="font-family: 'Courier New', monospace;"></textarea>
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
                            <textarea id="urlOutput" class="form-control" rows="10" readonly style="font-family: 'Courier New', monospace;"></textarea>
                            <div class="mt-3">
                                <button type="button" id="copyBtn" class="btn btn-info w-100">
                                    <i class="fas fa-copy me-2"></i>Copy to Clipboard
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Options -->
            <div class="row mt-4">
                <div class="col-lg-10 mx-auto">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-sliders-h me-2"></i>Encoding Options</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="spacesAsPlus" checked>
                                        <label class="form-check-label" for="spacesAsPlus">
                                            Encode spaces as + (form-urlencoded)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="encodeSlashes">
                                        <label class="form-check-label" for="encodeSlashes">
                                            Encode forward slashes (/)
                                        </label>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('urlInput');
    const output = document.getElementById('urlOutput');
    const processBtn = document.getElementById('processBtn');
    const clearBtn = document.getElementById('clearBtn');
    const copyBtn = document.getElementById('copyBtn');
    const encodeMode = document.getElementById('encode-mode');
    const decodeMode = document.getElementById('decode-mode');
    const inputLabel = document.getElementById('inputLabel');
    const outputLabel = document.getElementById('outputLabel');
    const processBtnText = document.getElementById('processBtnText');
    const spacesAsPlus = document.getElementById('spacesAsPlus');
    const encodeSlashes = document.getElementById('encodeSlashes');

    const modeRadios = document.querySelectorAll('input[name="mode"]');
    modeRadios.forEach(radio => {
        radio.addEventListener('change', updateLabels);
    });

    function updateLabels() {
        if (encodeMode.checked) {
            inputLabel.textContent = 'URL/Text to Encode';
            outputLabel.textContent = 'Encoded Result';
            processBtnText.textContent = 'Encode';
        } else {
            inputLabel.textContent = 'URL-Encoded Text to Decode';
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
            output.value = encodeURL(text);
        } else {
            output.value = decodeURL(text);
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

    function encodeURL(text) {
        let encoded = text;

        if (spacesAsPlus.checked) {
            encoded = encoded.replace(/ /g, '+');
            encoded = encoded.replace(/%20/g, '+');
        } else {
            encoded = encoded.replace(/ /g, '%20');
        }

        // Encode special characters
        encoded = encoded.replace(/[!*'();:@&=+$,\/?#[\]]/g, function(char) {
            if (char === '/' && !encodeSlashes.checked) {
                return char;
            }
            return '%' + char.charCodeAt(0).toString(16).toUpperCase().padStart(2, '0');
        });

        return encoded;
    }

    function decodeURL(text) {
        let decoded = text;
        decoded = decoded.replace(/\+/g, ' ');
        decoded = decodeURIComponent(decoded);
        return decoded;
    }
});
</script>
