<div class="row">
    <div class="col-md-12">
        <div class="mb-4">
            <label for="qr-text" class="form-label">Text or URL to encode:</label>
            <textarea
                class="form-control"
                id="qr-text"
                rows="4"
                placeholder="Enter text, URL, or any data to generate QR code..."
            ></textarea>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="qr-size" class="form-label">QR Code Size:</label>
                <select class="form-select" id="qr-size">
                    <option value="200">200x200px (Small)</option>
                    <option value="300" selected>300x300px (Medium)</option>
                    <option value="400">400x400px (Large)</option>
                    <option value="500">500x500px (Extra Large)</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="qr-format" class="form-label">Output Format:</label>
                <select class="form-select" id="qr-format">
                    <option value="png" selected>PNG</option>
                    <option value="jpg">JPG</option>
                    <option value="svg">SVG</option>
                </select>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <label for="qr-error-correction" class="form-label">Error Correction:</label>
                <select class="form-select" id="qr-error-correction">
                    <option value="L">Low (~7%)</option>
                    <option value="M" selected>Medium (~15%)</option>
                    <option value="Q">Quartile (~25%)</option>
                    <option value="H">High (~30%)</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="qr-margin" class="form-label">Margin:</label>
                <select class="form-select" id="qr-margin">
                    <option value="0">No margin</option>
                    <option value="1">Small margin</option>
                    <option value="2" selected>Medium margin</option>
                    <option value="4">Large margin</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <button type="button" class="btn btn-primary" onclick="generateQRCode()">
                <i class="bi bi-qr-code"></i> Generate QR Code
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="clearQRCode()">
                <i class="bi bi-x-circle"></i> Clear
            </button>
        </div>

        <!-- QR Code Output -->
        <div id="qr-output" class="text-center" style="display: none;">
            <div class="mb-3">
                <canvas id="qr-canvas" style="border: 1px solid #ddd; border-radius: 8px;"></canvas>
            </div>
            <div class="d-flex justify-content-center gap-2">
                <button type="button" class="btn btn-success" onclick="downloadQRCode()">
                    <i class="bi bi-download"></i> Download
                </button>
                <button type="button" class="btn btn-outline-primary" onclick="copyQRCodeToClipboard()">
                    <i class="bi bi-clipboard"></i> Copy to Clipboard
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Information -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> About QR Codes</h6>
    <p class="mb-0">
        QR codes can store various types of data including URLs, plain text, phone numbers, email addresses, and more.
        Higher error correction levels make the QR code more readable even when partially damaged but increase the size.
    </p>
</div>

<!-- Include QR Code library -->
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>

<script>
function generateQRCode() {
    const text = document.getElementById('qr-text').value.trim();
    const size = parseInt(document.getElementById('qr-size').value);
    const format = document.getElementById('qr-format').value;
    const errorCorrectionLevel = document.getElementById('qr-error-correction').value;
    const margin = parseInt(document.getElementById('qr-margin').value);

    if (!text) {
        alert('Please enter text or URL to generate QR code.');
        return;
    }

    const canvas = document.getElementById('qr-canvas');
    const options = {
        errorCorrectionLevel: errorCorrectionLevel,
        type: 'image/png',
        quality: 0.92,
        margin: margin,
        width: size,
        color: {
            dark: '#000000FF',
            light: '#FFFFFFFF'
        }
    };

    QRCode.toCanvas(canvas, text, options, function (error) {
        if (error) {
            console.error(error);
            alert('Error generating QR code: ' + error.message);
        } else {
            document.getElementById('qr-output').style.display = 'block';
        }
    });
}

function clearQRCode() {
    document.getElementById('qr-text').value = '';
    document.getElementById('qr-output').style.display = 'none';
    const canvas = document.getElementById('qr-canvas');
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
}

function downloadQRCode() {
    const canvas = document.getElementById('qr-canvas');
    const format = document.getElementById('qr-format').value;
    const link = document.createElement('a');

    if (format === 'svg') {
        // For SVG, we'll need to generate it separately
        const text = document.getElementById('qr-text').value.trim();
        QRCode.toString(text, {type: 'svg'}, function (err, string) {
            if (err) throw err;
            const blob = new Blob([string], {type: 'image/svg+xml'});
            const url = URL.createObjectURL(blob);
            link.download = 'qrcode.svg';
            link.href = url;
            link.click();
            URL.revokeObjectURL(url);
        });
    } else {
        const mimeType = format === 'jpg' ? 'image/jpeg' : 'image/png';
        link.download = 'qrcode.' + format;
        link.href = canvas.toDataURL(mimeType);
        link.click();
    }
}

function copyQRCodeToClipboard() {
    const canvas = document.getElementById('qr-canvas');
    canvas.toBlob(function(blob) {
        const item = new ClipboardItem({ "image/png": blob });
        navigator.clipboard.write([item]).then(function() {
            // Show success feedback
            const button = event.target;
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="bi bi-check"></i> Copied!';
            button.classList.remove('btn-outline-primary');
            button.classList.add('btn-success');

            setTimeout(function() {
                button.innerHTML = originalText;
                button.classList.remove('btn-success');
                button.classList.add('btn-outline-primary');
            }, 2000);
        }, function(err) {
            alert('Failed to copy QR code to clipboard');
        });
    });
}

// Handle Enter key in textarea
document.getElementById('qr-text').addEventListener('keypress', function(e) {
    if (e.key === 'Enter' && e.ctrlKey) {
        generateQRCode();
    }
});
</script>
                                    <option value="M" selected>Medium (~15%)</option>
                                    <option value="Q">Quartile (~25%)</option>
                                    <option value="H">High (~30%)</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="margin" class="form-label">Margin (border):</label>
                                <select class="form-select" id="margin" name="margin">
                                    <option value="1">1px</option>
                                    <option value="2">2px</option>
                                    <option value="4" selected>4px</option>
                                    <option value="8">8px</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-magic"></i> Generate QR Code
                            </button>
                        </div>
                    </form>

                    <!-- Results -->
                    <div id="result" style="display: none;" class="mt-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-qrcode"></i> Generated QR Code</h5>
                            </div>
                            <div class="card-body text-center">
                                <div id="qrCodeContainer" class="mb-3">
                                    <!-- QR code will be displayed here -->
                                </div>
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <button type="button" id="downloadBtn" class="btn btn-success">
                                        <i class="fas fa-download"></i> Download QR Code
                                    </button>
                                    <button type="button" id="copyUrlBtn" class="btn btn-info">
                                        <i class="fas fa-copy"></i> Copy QR URL
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Error message -->
                    <div id="error" style="display: none;" class="alert alert-danger mt-3" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> <span id="errorMessage"></span>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card mt-3">
                <div class="card-body">
                    <h6><i class="fas fa-info-circle text-primary"></i> How to use QR codes:</h6>
                    <ul class="small mb-0">
                        <li>Share URLs, contact info, WiFi passwords</li>
                        <li>Add to business cards, flyers, or websites</li>
                        <li>Higher error correction = more damage tolerance</li>
                        <li>Test your QR codes before printing</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('toolForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const text = formData.get('text');
    const size = formData.get('size');
    const format = formData.get('format');
    const errorCorrection = formData.get('errorCorrection');
    const margin = formData.get('margin');

    if (!text.trim()) {
        document.getElementById('error').style.display = 'block';
        document.getElementById('errorMessage').textContent = 'Please enter text or URL to generate QR code.';
        return;
    }

    try {
        // Use QR Server API for QR code generation
        const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=${size}x${size}&data=${encodeURIComponent(text)}&format=${format}&ecc=${errorCorrection}&margin=${margin}`;

        // Create image element
        const qrContainer = document.getElementById('qrCodeContainer');
        qrContainer.innerHTML = `
            <img src="${qrUrl}" alt="Generated QR Code" class="img-fluid border rounded shadow-sm" style="max-width: 100%; height: auto;">
            <p class="small text-muted mt-2">Size: ${size}x${size}px | Format: ${format.toUpperCase()} | Error Correction: ${errorCorrection}</p>
        `;

        // Set up download button
        document.getElementById('downloadBtn').onclick = function() {
            const link = document.createElement('a');
            link.href = qrUrl;
            link.download = `qrcode_${Date.now()}.${format}`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        };

        // Set up copy URL button
        document.getElementById('copyUrlBtn').onclick = function() {
            navigator.clipboard.writeText(qrUrl).then(() => {
                const btn = this;
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check"></i> Copied!';
                btn.classList.remove('btn-info');
                btn.classList.add('btn-success');
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-info');
                }, 2000);
            });
        };

        document.getElementById('result').style.display = 'block';
        document.getElementById('error').style.display = 'none';

    } catch (err) {
        document.getElementById('error').style.display = 'block';
        document.getElementById('errorMessage').textContent = 'Error generating QR code: ' + err.message;
        document.getElementById('result').style.display = 'none';
    }
});
</script>
