{{-- Webpage Screen Resolution Simulator --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Simulate how your website looks on different screen sizes.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-desktop me-3"></i>Screen Resolution Simulator
                </h1>
                <p class="lead text-muted">
                    Preview how your website looks on different devices
                </p>
            </div>

            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="urlInput" class="form-label fw-semibold">Website URL:</label>
                                <input type="url" class="form-control" id="urlInput" placeholder="https://example.com">
                            </div>

                            <div class="mb-3">
                                <label for="preset" class="form-label fw-semibold">Device Preset:</label>
                                <select class="form-select" id="preset">
                                    <option value="custom">Custom</option>
                                    <option value="iphone-12">iPhone 12 (390x844)</option>
                                    <option value="iphone-13">iPhone 13 Pro (390x844)</option>
                                    <option value="pixel-6">Pixel 6 (412x915)</option>
                                    <option value="ipad">iPad (768x1024)</option>
                                    <option value="ipad-pro">iPad Pro (1024x1366)</option>
                                    <option value="desktop-1080">Desktop 1080p (1920x1080)</option>
                                    <option value="desktop-1440">Desktop 1440p (2560x1440)</option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="width" class="form-label fw-semibold">Width (px):</label>
                                    <input type="number" class="form-control" id="width" value="1920" min="200">
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="height" class="form-label fw-semibold">Height (px):</label>
                                    <input type="number" class="form-control" id="height" value="1080" min="200">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="orientation" class="form-label fw-semibold">Orientation:</label>
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="orientation" id="portrait" value="portrait">
                                    <label class="btn btn-outline-secondary" for="portrait">
                                        <i class="fas fa-mobile-alt"></i> Portrait
                                    </label>
                                    <input type="radio" class="btn-check" name="orientation" id="landscape" value="landscape" checked>
                                    <label class="btn btn-outline-secondary" for="landscape">
                                        <i class="fas fa-laptop"></i> Landscape
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="zoom" class="form-label fw-semibold">Zoom Level:</label>
                                <div class="input-group">
                                    <input type="range" class="form-range" id="zoom" min="50" max="150" value="100">
                                    <span id="zoomValue" class="input-group-text">100%</span>
                                </div>
                            </div>

                            <button type="button" id="previewBtn" class="btn btn-primary w-100">
                                <i class="fas fa-eye me-2"></i>Preview
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-eye me-2"></i>Preview</h5>
                        </div>
                        <div class="card-body p-0" style="background: #e0e0e0;">
                            <div id="deviceFrame" style="
                                margin: 20px auto;
                                background: #000;
                                border-radius: 20px;
                                padding: 12px;
                                width: fit-content;
                                box-shadow: 0 10px 40px rgba(0,0,0,0.3);
                                max-width: 100%;
                            ">
                                <div id="screen" style="
                                    background: #fff;
                                    border-radius: 8px;
                                    overflow: hidden;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    font-size: 14px;
                                    color: #666;
                                ">
                                    <p class="mb-0">Enter URL and click "Preview"</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-2"></i>
                                Note: This is a simulated viewport view. For real testing, use browser DevTools.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlInput = document.getElementById('urlInput');
    const preset = document.getElementById('preset');
    const width = document.getElementById('width');
    const height = document.getElementById('height');
    const zoom = document.getElementById('zoom');
    const zoomValue = document.getElementById('zoomValue');
    const previewBtn = document.getElementById('previewBtn');
    const screen = document.getElementById('screen');
    const deviceFrame = document.getElementById('deviceFrame');

    const presets = {
        'iphone-12': { width: 390, height: 844 },
        'iphone-13': { width: 390, height: 844 },
        'pixel-6': { width: 412, height: 915 },
        'ipad': { width: 768, height: 1024 },
        'ipad-pro': { width: 1024, height: 1366 },
        'desktop-1080': { width: 1920, height: 1080 },
        'desktop-1440': { width: 2560, height: 1440 }
    };

    function updatePreview() {
        const url = urlInput.value.trim();
        if (!url) {
            alert('Please enter a URL');
            return;
        }

        try {
            new URL(url);
        } catch (e) {
            alert('Invalid URL format');
            return;
        }

        const w = parseInt(width.value);
        const h = parseInt(height.value);
        const z = parseInt(zoom.value);
        const orientation = document.querySelector('input[name="orientation"]:checked').value;

        // Apply dimensions
        screen.style.width = (w * z / 100) + 'px';
        screen.style.height = (h * z / 100) + 'px';

        // Create iframe
        screen.innerHTML = `
            <iframe
                src="${url}"
                style="
                    width: ${w}px;
                    height: ${h}px;
                    border: none;
                    transform: scale(${z / 100});
                    transform-origin: top left;
                "
            ></iframe>
        `;

        // Add info overlay
        const info = document.createElement('div');
        info.style.cssText = `
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 12px;
            z-index: 1000;
        `;
        info.innerHTML = `
            <strong>${w}x${h}px</strong><br>
            Zoom: ${z}%<br>
            ${orientation === 'portrait' ? '<i class="fas fa-mobile-alt"></i> Portrait' : '<i class="fas fa-laptop"></i> Landscape'}
        `;
    }

    preset.addEventListener('change', function() {
        if (this.value !== 'custom' && presets[this.value]) {
            const p = presets[this.value];
            width.value = p.width;
            height.value = p.height;
        }
    });

    zoom.addEventListener('input', function() {
        zoomValue.textContent = this.value + '%';
    });

    previewBtn.addEventListener('click', updatePreview);
    urlInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            updatePreview();
        }
    });
});
</script>
