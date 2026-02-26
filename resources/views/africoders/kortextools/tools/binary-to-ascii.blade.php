{{-- binary to ascii --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    binary to ascii tool for your development and productivity needs.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-exchange-alt me-3"></i>Binary to ASCII Converter
                </h1>
                <p class="lead text-muted">
                    Convert binary code to readable ASCII text instantly
                </p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-code me-2"></i>Binary to ASCII Conversion</h5>
                </div>
                <div class="card-body">
                    <form id="binaryToAsciiForm">
                        <div class="mb-4">
                            <label for="binaryInput" class="form-label fw-semibold">
                                <i class="fas fa-binary me-2"></i>Binary Code
                            </label>
                            <textarea class="form-control" id="binaryInput" rows="5"
                                placeholder="Enter binary code (8-bit per character, space or no space separated)..."
                                style="font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;"></textarea>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Enter binary code. Example: 01001000 01100101 01101100 01101100 01101111 (Hello)
                            </div>
                        </div>

                        <div class="text-center mb-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-exchange-alt me-2"></i>Convert to ASCII
                            </button>
                            <button type="button" id="clearBtn" class="btn btn-outline-secondary btn-lg ms-3">
                                <i class="fas fa-trash-alt me-2"></i>Clear
                            </button>
                        </div>
                    </form>

                    <div id="resultSection" style="display: none;">
                        <div class="border-top pt-4">
                            <label for="asciiOutput" class="form-label fw-semibold">
                                <i class="fas fa-font me-2"></i>ASCII Text Output
                            </label>
                            <textarea class="form-control mb-3" id="asciiOutput" rows="4" readonly
                                style="background-color: #f8f9fa;"></textarea>

                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" id="copyBtn" class="btn btn-success">
                                    <i class="fas fa-copy me-2"></i>Copy Result
                                </button>
                                <button type="button" id="downloadBtn" class="btn btn-outline-primary">
                                    <i class="fas fa-download me-2"></i>Download as TXT
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="card-title text-primary">
                                <i class="fas fa-info-circle me-2"></i>How it Works
                            </h6>
                            <p class="card-text small">
                                Each 8-bit binary sequence is converted back to its ASCII character.
                                For example, 01001000 (binary 72) becomes 'H'.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="card-title text-primary">
                                <i class="fas fa-lightbulb me-2"></i>Use Cases
                            </h6>
                            <ul class="small mb-0">
                                <li>Decode binary data to readable text</li>
                                <li>Data recovery and analysis</li>
                                <li>Understanding binary encoding</li>
                                <li>Reverse engineering binary files</li>
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
    const form = document.getElementById('binaryToAsciiForm');
    const binaryInput = document.getElementById('binaryInput');
    const asciiOutput = document.getElementById('asciiOutput');
    const resultSection = document.getElementById('resultSection');
    const clearBtn = document.getElementById('clearBtn');
    const copyBtn = document.getElementById('copyBtn');
    const downloadBtn = document.getElementById('downloadBtn');

    function binaryToAscii(binaryStr) {
        // Remove extra spaces and split by space or group by 8 characters
        const cleanBinary = binaryStr.replace(/\s+/g, '');

        if (cleanBinary.length % 8 !== 0) {
            throw new Error('Binary string length must be a multiple of 8');
        }

        let result = '';
        for (let i = 0; i < cleanBinary.length; i += 8) {
            const byte = cleanBinary.substr(i, 8);
            if (!/^[01]{8}$/.test(byte)) {
                throw new Error('Invalid binary format. Only 0s and 1s are allowed.');
            }
            const charCode = parseInt(byte, 2);
            result += String.fromCharCode(charCode);
        }
        return result;
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const binaryText = binaryInput.value.trim();

        if (!binaryText) {
            alert('Please enter some binary code to convert.');
            return;
        }

        try {
            const asciiResult = binaryToAscii(binaryText);
            asciiOutput.value = asciiResult;
            resultSection.style.display = 'block';
        } catch (error) {
            alert('Error: ' + error.message);
        }
    });

    clearBtn.addEventListener('click', function() {
        binaryInput.value = '';
        asciiOutput.value = '';
        resultSection.style.display = 'none';
    });

    copyBtn.addEventListener('click', function() {
        navigator.clipboard.writeText(asciiOutput.value).then(() => {
            const originalText = copyBtn.innerHTML;
            copyBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
            copyBtn.className = 'btn btn-success';

            setTimeout(() => {
                copyBtn.innerHTML = originalText;
                copyBtn.className = 'btn btn-success';
            }, 2000);
        });
    });

    downloadBtn.addEventListener('click', function() {
        const content = asciiOutput.value;
        const blob = new Blob([content], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'binary-to-ascii-result.txt';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    });
});
</script>

