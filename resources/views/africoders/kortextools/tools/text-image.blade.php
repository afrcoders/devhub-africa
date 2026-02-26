{{-- Text Image Generator --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Convert text into images with custom styling.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-image me-3"></i>Text Image Generator
                </h1>
                <p class="lead text-muted">
                    Convert text into images with custom styling
                </p>
            </div>

            <div class="row">
                <div class="col-lg-5 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Text Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="textContent" class="form-label fw-semibold">Text:</label>
                                <textarea class="form-control" id="textContent" rows="6" placeholder="Enter your text here">Your Text Here</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="fontSize" class="form-label fw-semibold">Font Size:</label>
                                <div class="input-group">
                                    <input type="range" class="form-range" id="fontSize" min="10" max="100" value="48">
                                    <span id="fontSizeValue" style="min-width: 40px;" class="text-end">48</span><span>px</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="fontFamily" class="form-label fw-semibold">Font:</label>
                                <select class="form-select" id="fontFamily">
                                    <option value="Arial">Arial</option>
                                    <option value="Times New Roman">Times New Roman</option>
                                    <option value="Courier New">Courier New</option>
                                    <option value="Georgia">Georgia</option>
                                    <option value="Trebuchet MS">Trebuchet MS</option>
                                    <option value="Comic Sans MS">Comic Sans MS</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="fontColor" class="form-label fw-semibold">Text Color:</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" id="fontColor" value="#ffffff">
                                    <span id="fontColorValue" class="input-group-text">#ffffff</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="bgColor" class="form-label fw-semibold">Background Color:</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" id="bgColor" value="#000000">
                                    <span id="bgColorValue" class="input-group-text">#000000</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="fontWeight" class="form-label fw-semibold">Font Weight:</label>
                                <select class="form-select" id="fontWeight">
                                    <option value="normal">Normal</option>
                                    <option value="bold" selected>Bold</option>
                                    <option value="900">Extra Bold</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="textAlign" class="form-label fw-semibold">Text Alignment:</label>
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="align" id="left" value="left">
                                    <label class="btn btn-outline-secondary" for="left">
                                        <i class="fas fa-align-left"></i> Left
                                    </label>
                                    <input type="radio" class="btn-check" name="align" id="center" value="center" checked>
                                    <label class="btn btn-outline-secondary" for="center">
                                        <i class="fas fa-align-center"></i> Center
                                    </label>
                                    <input type="radio" class="btn-check" name="align" id="right" value="right">
                                    <label class="btn btn-outline-secondary" for="right">
                                        <i class="fas fa-align-right"></i> Right
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="padding" class="form-label fw-semibold">Padding:</label>
                                <input type="number" class="form-control" id="padding" min="0" max="100" value="20">
                            </div>

                            <button type="button" id="generateBtn" class="btn btn-primary w-100">
                                <i class="fas fa-wand-magic-sparkles me-2"></i>Generate Image
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-eye me-2"></i>Preview</h5>
                        </div>
                        <div class="card-body p-3" style="background: #f8f9fa; display: flex; align-items: center; justify-content: center; min-height: 500px;">
                            <canvas id="textCanvas" width="600" height="400" style="max-width: 100%; border: 2px solid #ddd; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);"></canvas>
                        </div>
                        <div class="card-footer d-grid gap-2">
                            <button type="button" id="downloadBtn" class="btn btn-success">
                                <i class="fas fa-download me-2"></i>Download Image
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const textContent = document.getElementById('textContent');
    const fontSize = document.getElementById('fontSize');
    const fontSizeValue = document.getElementById('fontSizeValue');
    const fontFamily = document.getElementById('fontFamily');
    const fontColor = document.getElementById('fontColor');
    const fontColorValue = document.getElementById('fontColorValue');
    const bgColor = document.getElementById('bgColor');
    const bgColorValue = document.getElementById('bgColorValue');
    const fontWeight = document.getElementById('fontWeight');
    const padding = document.getElementById('padding');
    const generateBtn = document.getElementById('generateBtn');
    const downloadBtn = document.getElementById('downloadBtn');
    const canvas = document.getElementById('textCanvas');
    const ctx = canvas.getContext('2d');

    function getAlignment() {
        return document.querySelector('input[name="align"]:checked').value;
    }

    function drawText() {
        const size = parseInt(fontSize.value);
        const family = fontFamily.value;
        const color = fontColor.value;
        const bg = bgColor.value;
        const weight = fontWeight.value;
        const pad = parseInt(padding.value);
        const align = getAlignment();
        const text = textContent.value || 'Your Text Here';

        // Clear canvas
        ctx.fillStyle = bg;
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        // Set text properties
        ctx.fillStyle = color;
        ctx.font = `${weight} ${size}px ${family}`;
        ctx.textAlign = align;
        ctx.textBaseline = 'middle';

        // Split text into lines
        const lines = text.split('\\n');
        const lineHeight = size + 10;
        const totalHeight = (lines.length - 1) * lineHeight;
        const startY = (canvas.height - totalHeight) / 2;

        let x;
        if (align === 'left') {
            x = pad;
        } else if (align === 'right') {
            x = canvas.width - pad;
        } else {
            x = canvas.width / 2;
        }

        lines.forEach((line, i) => {
            const y = startY + i * lineHeight;
            ctx.fillText(line, x, y);
        });
    }

    fontSize.addEventListener('input', function() {
        fontSizeValue.textContent = this.value;
        drawText();
    });

    fontColor.addEventListener('input', function() {
        fontColorValue.textContent = this.value;
        drawText();
    });

    bgColor.addEventListener('input', function() {
        bgColorValue.textContent = this.value;
        drawText();
    });

    textContent.addEventListener('input', drawText);
    fontFamily.addEventListener('change', drawText);
    fontWeight.addEventListener('change', drawText);
    padding.addEventListener('input', drawText);

    document.querySelectorAll('input[name="align"]').forEach(radio => {
        radio.addEventListener('change', drawText);
    });

    generateBtn.addEventListener('click', drawText);

    downloadBtn.addEventListener('click', function() {
        const link = document.createElement('a');
        link.href = canvas.toDataURL('image/png');
        link.download = 'text-image.png';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });

    drawText();
});
</script>
