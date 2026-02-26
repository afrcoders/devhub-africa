@extends('layouts.kortex-tools')

@section('title', 'Color Picker - KortexTools')
@section('description', 'Advanced color picker tool with support for HEX, RGB, HSL, and HSV color formats. Perfect for designers and developers.')
@section('keywords', 'color picker, hex color, rgb color, hsl color, hsv color, color palette')

@section('tool-content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-palette me-2"></i>Color Picker</h4>
                    <small>Pick and convert colors between different formats</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Color Picker</label>
                                <div class="color-picker-container">
                                    <input type="color" id="colorPicker" class="form-control form-control-color w-100" style="height: 200px;" value="#3b82f6">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="hexInput" class="form-label">HEX Color</label>
                                <div class="input-group">
                                    <span class="input-group-text">#</span>
                                    <input type="text" class="form-control" id="hexInput" placeholder="3b82f6" maxlength="6">
                                    <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('hexInput')">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="rgbInput" class="form-label">RGB Color</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="rgbInput" placeholder="rgb(59, 130, 246)" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('rgbInput')">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="hslInput" class="form-label">HSL Color</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="hslInput" placeholder="hsl(217, 91%, 60%)" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('hslInput')">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="hsvInput" class="form-label">HSV Color</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="hsvInput" placeholder="hsv(217, 76%, 96%)" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('hsvInput')">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Color Preview</label>
                                <div id="colorPreview" class="border rounded" style="height: 100px; background-color: #3b82f6;"></div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <h5>Color Palette Generator</h5>
                            <div class="mb-3">
                                <button class="btn btn-outline-primary me-2" onclick="generatePalette('analogous')">Analogous</button>
                                <button class="btn btn-outline-primary me-2" onclick="generatePalette('complementary')">Complementary</button>
                                <button class="btn btn-outline-primary me-2" onclick="generatePalette('triadic')">Triadic</button>
                                <button class="btn btn-outline-primary me-2" onclick="generatePalette('tetradic')">Tetradic</button>
                                <button class="btn btn-outline-primary" onclick="generatePalette('monochromatic')">Monochromatic</button>
                            </div>
                            <div id="colorPalette" class="row"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const colorPicker = document.getElementById('colorPicker');
    const hexInput = document.getElementById('hexInput');

    colorPicker.addEventListener('change', updateColors);
    hexInput.addEventListener('input', function() {
        const hex = this.value;
        if (hex.match(/^[0-9A-F]{6}$/i)) {
            colorPicker.value = '#' + hex;
            updateColors();
        }
    });

    updateColors(); // Initialize with default color
});

function updateColors() {
    const hex = document.getElementById('colorPicker').value;
    const rgb = hexToRgb(hex);
    const hsl = rgbToHsl(rgb.r, rgb.g, rgb.b);
    const hsv = rgbToHsv(rgb.r, rgb.g, rgb.b);

    document.getElementById('hexInput').value = hex.substring(1);
    document.getElementById('rgbInput').value = `rgb(${rgb.r}, ${rgb.g}, ${rgb.b})`;
    document.getElementById('hslInput').value = `hsl(${Math.round(hsl.h)}, ${Math.round(hsl.s)}%, ${Math.round(hsl.l)}%)`;
    document.getElementById('hsvInput').value = `hsv(${Math.round(hsv.h)}, ${Math.round(hsv.s)}%, ${Math.round(hsv.v)}%)`;
    document.getElementById('colorPreview').style.backgroundColor = hex;
}

function hexToRgb(hex) {
    const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}

function rgbToHsl(r, g, b) {
    r /= 255; g /= 255; b /= 255;
    const max = Math.max(r, g, b), min = Math.min(r, g, b);
    let h, s, l = (max + min) / 2;

    if (max === min) {
        h = s = 0;
    } else {
        const d = max - min;
        s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
        switch (max) {
            case r: h = (g - b) / d + (g < b ? 6 : 0); break;
            case g: h = (b - r) / d + 2; break;
            case b: h = (r - g) / d + 4; break;
        }
        h /= 6;
    }
    return { h: h * 360, s: s * 100, l: l * 100 };
}

function rgbToHsv(r, g, b) {
    r /= 255; g /= 255; b /= 255;
    const max = Math.max(r, g, b), min = Math.min(r, g, b);
    let h, s, v = max;

    const d = max - min;
    s = max === 0 ? 0 : d / max;

    if (max === min) {
        h = 0;
    } else {
        switch (max) {
            case r: h = (g - b) / d + (g < b ? 6 : 0); break;
            case g: h = (b - r) / d + 2; break;
            case b: h = (r - g) / d + 4; break;
        }
        h /= 6;
    }
    return { h: h * 360, s: s * 100, v: v * 100 };
}

function hslToHex(h, s, l) {
    l /= 100;
    const a = s * Math.min(l, 1 - l) / 100;
    const f = n => {
        const k = (n + h / 30) % 12;
        const color = l - a * Math.max(Math.min(k - 3, 9 - k, 1), -1);
        return Math.round(255 * color).toString(16).padStart(2, '0');
    };
    return `#${f(0)}${f(8)}${f(4)}`;
}

function generatePalette(type) {
    const currentColor = document.getElementById('colorPicker').value;
    const rgb = hexToRgb(currentColor);
    const hsl = rgbToHsl(rgb.r, rgb.g, rgb.b);
    let colors = [];

    switch (type) {
        case 'analogous':
            colors = [
                hslToHex((hsl.h - 30 + 360) % 360, hsl.s, hsl.l),
                currentColor,
                hslToHex((hsl.h + 30) % 360, hsl.s, hsl.l)
            ];
            break;
        case 'complementary':
            colors = [
                currentColor,
                hslToHex((hsl.h + 180) % 360, hsl.s, hsl.l)
            ];
            break;
        case 'triadic':
            colors = [
                currentColor,
                hslToHex((hsl.h + 120) % 360, hsl.s, hsl.l),
                hslToHex((hsl.h + 240) % 360, hsl.s, hsl.l)
            ];
            break;
        case 'tetradic':
            colors = [
                currentColor,
                hslToHex((hsl.h + 90) % 360, hsl.s, hsl.l),
                hslToHex((hsl.h + 180) % 360, hsl.s, hsl.l),
                hslToHex((hsl.h + 270) % 360, hsl.s, hsl.l)
            ];
            break;
        case 'monochromatic':
            colors = [
                hslToHex(hsl.h, hsl.s, Math.max(hsl.l - 40, 0)),
                hslToHex(hsl.h, hsl.s, Math.max(hsl.l - 20, 0)),
                currentColor,
                hslToHex(hsl.h, hsl.s, Math.min(hsl.l + 20, 100)),
                hslToHex(hsl.h, hsl.s, Math.min(hsl.l + 40, 100))
            ];
            break;
    }

    displayPalette(colors);
}

function displayPalette(colors) {
    const paletteContainer = document.getElementById('colorPalette');
    paletteContainer.innerHTML = '';

    colors.forEach(color => {
        const col = document.createElement('div');
        col.className = 'col-md-2 col-4 mb-3';
        col.innerHTML = `
            <div class="text-center">
                <div class="color-swatch border rounded mb-2" style="height: 80px; background-color: ${color}; cursor: pointer;"
                     onclick="selectColor('${color}')" title="Click to select"></div>
                <small class="text-muted">${color}</small>
            </div>
        `;
        paletteContainer.appendChild(col);
    });
}

function selectColor(color) {
    document.getElementById('colorPicker').value = color;
    updateColors();
}

function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    element.select();
    document.execCommand('copy');

    // Show success feedback
    const btn = event.target;
    const originalHtml = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-check"></i>';
    btn.classList.add('btn-success');
    btn.classList.remove('btn-outline-secondary');

    setTimeout(() => {
        btn.innerHTML = originalHtml;
        btn.classList.remove('btn-success');
        btn.classList.add('btn-outline-secondary');
    }, 1500);
}
</script>
@endsection
