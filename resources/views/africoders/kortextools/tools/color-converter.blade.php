{{-- color converter --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    color converter tool for your development and productivity needs.
</div>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-palette fa-3x text-primary"></i>
                </div>
                <h1 class="h2 mb-3">Color Converter</h1>
                <p class="lead text-muted">
                    Convert colors between HEX, RGB, and HSL formats
                </p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="color-converter-form">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-fill-drip me-2"></i>Input Color Format
                            </label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="color_type" id="hex-radio" value="hex" checked>
                                <label class="btn btn-outline-primary" for="hex-radio">HEX</label>

                                <input type="radio" class="btn-check" name="color_type" id="rgb-radio" value="rgb">
                                <label class="btn btn-outline-primary" for="rgb-radio">RGB</label>

                                <input type="radio" class="btn-check" name="color_type" id="hsl-radio" value="hsl">
                                <label class="btn btn-outline-primary" for="hsl-radio">HSL</label>
                            </div>
                        </div>

                        <!-- HEX Input -->
                        <div id="hex-input" class="color-input-section mb-4">
                            <label for="color_value" class="form-label">HEX Color Value</label>
                            <input type="text" class="form-control" name="color_value" placeholder="#FF5733">
                            <small class="form-text text-muted">Enter with or without # (e.g., #FF5733 or FF5733)</small>
                        </div>

                        <!-- RGB Input -->
                        <div id="rgb-input" class="color-input-section mb-4" style="display: none;">
                            <label class="form-label">RGB Values</label>
                            <div class="row">
                                <div class="col-4">
                                    <input type="number" class="form-control" name="r" placeholder="Red" min="0" max="255">
                                    <small class="text-muted">Red (0-255)</small>
                                </div>
                                <div class="col-4">
                                    <input type="number" class="form-control" name="g" placeholder="Green" min="0" max="255">
                                    <small class="text-muted">Green (0-255)</small>
                                </div>
                                <div class="col-4">
                                    <input type="number" class="form-control" name="b" placeholder="Blue" min="0" max="255">
                                    <small class="text-muted">Blue (0-255)</small>
                                </div>
                            </div>
                        </div>

                        <!-- HSL Input -->
                        <div id="hsl-input" class="color-input-section mb-4" style="display: none;">
                            <label class="form-label">HSL Values</label>
                            <div class="row">
                                <div class="col-4">
                                    <input type="number" class="form-control" name="h" placeholder="Hue" min="0" max="360">
                                    <small class="text-muted">Hue (0-360)</small>
                                </div>
                                <div class="col-4">
                                    <input type="number" class="form-control" name="s" placeholder="Saturation" min="0" max="100">
                                    <small class="text-muted">Saturation (%)</small>
                                </div>
                                <div class="col-4">
                                    <input type="number" class="form-control" name="l" placeholder="Lightness" min="0" max="100">
                                    <small class="text-muted">Lightness (%)</small>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-exchange-alt me-2"></i>Convert Color
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Results Section -->
            <div id="results-section" class="card shadow-sm mt-4" style="display: none;">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-check-circle text-success me-2"></i>Color Conversion Results</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center">
                            <div id="color-preview" class="mx-auto mb-3" style="width: 150px; height: 150px; border: 2px solid #ddd; border-radius: 10px;"></div>
                            <p class="fw-bold">Color Preview</p>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>HEX:</h6>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="result-hex" readonly>
                                        <button class="btn btn-outline-secondary" type="button" onclick="copyValue('result-hex')">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6>RGB:</h6>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="result-rgb" readonly>
                                        <button class="btn btn-outline-secondary" type="button" onclick="copyValue('result-rgb')">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6>HSL:</h6>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="result-hsl" readonly>
                                        <button class="btn btn-outline-secondary" type="button" onclick="copyValue('result-hsl')">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6>Individual Values:</h6>
                                    <small class="text-muted">R: <span id="r-val"></span>, G: <span id="g-val"></span>, B: <span id="b-val"></span></small><br>
                                    <small class="text-muted">H: <span id="h-val"></span>°, S: <span id="s-val"></span>%, L: <span id="l-val"></span>%</small>
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
// Toggle input sections based on color type
document.querySelectorAll('input[name="color_type"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.color-input-section').forEach(section => {
            section.style.display = 'none';
        });
        document.getElementById(this.value + '-input').style.display = 'block';
    });
});

document.getElementById('color-converter-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;

    try {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Converting...';
        submitBtn.disabled = true;

        const formData = new FormData(this);
        const response = await fetch('{{ route("tools.kortex.tool.submit", "color-converter") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const result = await response.json();

        if (result.success) {
            const data = result.data;

            document.getElementById('color-preview').style.backgroundColor = data.hex;
            document.getElementById('result-hex').value = data.hex;
            document.getElementById('result-rgb').value = data.rgb;
            document.getElementById('result-hsl').value = data.hsl;

            document.getElementById('r-val').textContent = data.r;
            document.getElementById('g-val').textContent = data.g;
            document.getElementById('b-val').textContent = data.b;
            document.getElementById('h-val').textContent = data.h;
            document.getElementById('s-val').textContent = data.s;
            document.getElementById('l-val').textContent = data.l;

            document.getElementById('results-section').style.display = 'block';
            document.getElementById('results-section').scrollIntoView({ behavior: 'smooth' });
        } else {
            alert('Error: ' + (result.message || 'Color conversion failed'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred during color conversion');
    } finally {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
});

function copyValue(inputId) {
    const input = document.getElementById(inputId);
    input.select();
    document.execCommand('copy');

    const btn = event.target.closest('button');
    const icon = btn.querySelector('i');
    icon.className = 'fas fa-check text-success';

    setTimeout(() => {
        icon.className = 'fas fa-copy';
    }, 2000);
}
</script>

