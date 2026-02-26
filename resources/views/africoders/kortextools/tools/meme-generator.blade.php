{{-- Meme Generator --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Meme Generator for creating text-based memes and funny images.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-laugh me-3"></i>Meme Generator
                </h1>
                <p class="lead text-muted">
                    Create simple text-based memes and templates
                </p>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Meme Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="template" class="form-label fw-semibold">
                                    <i class="fas fa-image me-2"></i>Template
                                </label>
                                <select class="form-select" id="template">
                                    <option value="drake">Drake - Approval/Disapproval</option>
                                    <option value="expansi">Expanding Brain - 4 Panel</option>
                                    <option value="distracted">Distracted Boyfriend</option>
                                    <option value="woman">Woman Yelling at Cat</option>
                                    <option value="loss">Loss</option>
                                    <option value="format">Custom Text Format</option>
                                </select>
                            </div>

                            <div id="drake-inputs" class="template-inputs">
                                <div class="mb-3">
                                    <label for="drakeTop" class="form-label">Top Text (Bad):</label>
                                    <input type="text" class="form-control" id="drakeTop" placeholder="Something you don't like">
                                </div>
                                <div class="mb-3">
                                    <label for="drakeBottom" class="form-label">Bottom Text (Good):</label>
                                    <input type="text" class="form-control" id="drakeBottom" placeholder="Something you like">
                                </div>
                            </div>

                            <div id="expansion-inputs" class="template-inputs" style="display: none;">
                                <div class="mb-3">
                                    <label for="exp1" class="form-label">Panel 1:</label>
                                    <input type="text" class="form-control" id="exp1" placeholder="First idea">
                                </div>
                                <div class="mb-3">
                                    <label for="exp2" class="form-label">Panel 2:</label>
                                    <input type="text" class="form-control" id="exp2" placeholder="Better idea">
                                </div>
                                <div class="mb-3">
                                    <label for="exp3" class="form-label">Panel 3:</label>
                                    <input type="text" class="form-control" id="exp3" placeholder="Even better">
                                </div>
                                <div class="mb-3">
                                    <label for="exp4" class="form-label">Panel 4:</label>
                                    <input type="text" class="form-control" id="exp4" placeholder="Best idea">
                                </div>
                            </div>

                            <div id="simple-inputs" class="template-inputs" style="display: none;">
                                <div class="mb-3">
                                    <label for="simpleText" class="form-label">Text:</label>
                                    <textarea class="form-control" id="simpleText" rows="6" placeholder="Enter your text here"></textarea>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="textColor" class="form-label fw-semibold">
                                    <i class="fas fa-palette me-2"></i>Text Color
                                </label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" id="textColor" value="#ffffff">
                                    <select class="form-select" id="textColorPreset">
                                        <option value="#ffffff">White</option>
                                        <option value="#000000">Black</option>
                                        <option value="#ff0000">Red</option>
                                        <option value="#ffff00">Yellow</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="fontSize" class="form-label fw-semibold">
                                    <i class="fas fa-text-height me-2"></i>Font Size
                                </label>
                                <input type="range" class="form-range" id="fontSize" min="12" max="64" value="32">
                                <span id="fontSizeValue">32</span>px
                            </div>

                            <div class="text-center">
                                <button type="button" id="generateBtn" class="btn btn-primary btn-lg">
                                    <i class="fas fa-magic me-2"></i>Generate Meme
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-eye me-2"></i>Preview</h5>
                        </div>
                        <div class="card-body p-3" style="background: #f8f9fa; min-height: 500px; display: flex; align-items: center; justify-content: center;">
                            <canvas id="memeCanvas" width="400" height="400" style="max-width: 100%; border: 2px solid #ddd; border-radius: 8px;"></canvas>
                        </div>
                        <div class="card-footer">
                            <button type="button" id="downloadBtn" class="btn btn-success w-100">
                                <i class="fas fa-download me-2"></i>Download Meme
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
    const template = document.getElementById('template');
    const canvas = document.getElementById('memeCanvas');
    const ctx = canvas.getContext('2d');
    const textColor = document.getElementById('textColor');
    const fontSize = document.getElementById('fontSize');
    const fontSizeValue = document.getElementById('fontSizeValue');
    const generateBtn = document.getElementById('generateBtn');
    const downloadBtn = document.getElementById('downloadBtn');
    const textColorPreset = document.getElementById('textColorPreset');

    function drawMeme() {
        ctx.fillStyle = '#000';
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        const color = textColor.value;
        const size = parseInt(fontSize.value);
        const templateType = template.value;

        ctx.fillStyle = color;
        ctx.font = `bold ${size}px Arial`;
        ctx.textAlign = 'center';
        ctx.lineWidth = 3;
        ctx.strokeStyle = '#000';

        if (templateType === 'drake') {
            const topText = document.getElementById('drakeTop').value || 'Top';
            const bottomText = document.getElementById('drakeBottom').value || 'Bottom';

            ctx.strokeText(topText, canvas.width / 2, canvas.height / 2 - 50);
            ctx.fillText(topText, canvas.width / 2, canvas.height / 2 - 50);

            ctx.strokeText(bottomText, canvas.width / 2, canvas.height / 2 + 50);
            ctx.fillText(bottomText, canvas.width / 2, canvas.height / 2 + 50);
        } else if (templateType === 'expansi') {
            ctx.font = `bold ${size * 0.6}px Arial`;
            const texts = [
                document.getElementById('exp1').value || 'Panel 1',
                document.getElementById('exp2').value || 'Panel 2',
                document.getElementById('exp3').value || 'Panel 3',
                document.getElementById('exp4').value || 'Panel 4'
            ];

            texts.forEach((text, i) => {
                const x = (i % 2) * (canvas.width / 2) + canvas.width / 4;
                const y = Math.floor(i / 2) * (canvas.height / 2) + canvas.height / 4;
                ctx.strokeText(text, x, y);
                ctx.fillText(text, x, y);
            });
        } else {
            const text = document.getElementById('simpleText').value || 'Your Text Here';
            ctx.font = `bold ${size}px Arial`;

            const lines = text.split('\\n');
            const lineHeight = size + 10;
            const totalHeight = (lines.length - 1) * lineHeight;
            const startY = (canvas.height - totalHeight) / 2;

            lines.forEach((line, i) => {
                const y = startY + i * lineHeight;
                ctx.strokeText(line, canvas.width / 2, y);
                ctx.fillText(line, canvas.width / 2, y);
            });
        }
    }

    function switchTemplate() {
        document.querySelectorAll('.template-inputs').forEach(el => {
            el.style.display = 'none';
        });

        const templateType = template.value;
        if (templateType === 'drake') {
            document.getElementById('drake-inputs').style.display = 'block';
        } else if (templateType === 'expansi') {
            document.getElementById('expansion-inputs').style.display = 'block';
        } else {
            document.getElementById('simple-inputs').style.display = 'block';
        }

        drawMeme();
    }

    function downloadMeme() {
        const link = document.createElement('a');
        link.href = canvas.toDataURL('image/png');
        link.download = 'meme.png';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    fontSize.addEventListener('input', function() {
        fontSizeValue.textContent = this.value;
        drawMeme();
    });

    textColor.addEventListener('change', drawMeme);
    textColorPreset.addEventListener('change', function() {
        textColor.value = this.value;
        drawMeme();
    });

    template.addEventListener('change', switchTemplate);
    generateBtn.addEventListener('click', drawMeme);
    downloadBtn.addEventListener('click', downloadMeme);

    document.getElementById('drakeTop').addEventListener('input', drawMeme);
    document.getElementById('drakeBottom').addEventListener('input', drawMeme);
    document.getElementById('simpleText').addEventListener('input', drawMeme);

    for (let i = 1; i <= 4; i++) {
        const el = document.getElementById(`exp${i}`);
        if (el) el.addEventListener('input', drawMeme);
    }

    switchTemplate();
});
</script>
