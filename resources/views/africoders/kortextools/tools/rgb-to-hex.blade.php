<div class="card">
    <div class="card-header">
        <h5>RGB to HEX Converter</h5>
        <p class="text-muted small mb-0">Convert between RGB and HEX color formats</p>
    </div>
    <div class="card-body">
        <form id="colorForm" class="tool-form">
            @csrf

            <ul class="nav nav-tabs mb-3" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="rgbTab" data-bs-toggle="tab" data-bs-target="#rgbPanel" type="button">RGB to HEX</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="hexTab" data-bs-toggle="tab" data-bs-target="#hexPanel" type="button">HEX to RGB</button>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="rgbPanel" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Red (0-255)</label>
                            <input type="number" class="form-control rgb-input" name="r" min="0" max="255" value="255">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Green (0-255)</label>
                            <input type="number" class="form-control rgb-input" name="g" min="0" max="255" value="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Blue (0-255)</label>
                            <input type="number" class="form-control rgb-input" name="b" min="0" max="255" value="0">
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="hexPanel" role="tabpanel">
                    <div class="mb-3">
                        <label class="form-label">HEX Color</label>
                        <input type="text" class="form-control" name="hex" placeholder="#FF0000">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary" onclick="setOperation('rgb_to_hex')">
                    <i class="fas fa-exchange-alt"></i> Convert
                </button>
            </div>

            <!-- Results -->
            <div id="resultsContainer" style="display: none;">
                <div class="mt-4">
                    <h6>Result:</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded">
                                <small class="text-muted">RGB</small>
                                <p id="resultRgb" class="h5 mb-0">rgb(255, 0, 0)</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="colorPreview" class="p-3 rounded" style="background-color: #FF0000; height: 60px;"></div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">HEX</small>
                        <p id="resultHex" class="h5 mb-0">#FF0000</p>
                    </div>
                    <div class="mt-3">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="copyHex()">
                            <i class="fas fa-copy"></i> Copy HEX
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="copyRGB()">
                            <i class="fas fa-copy"></i> Copy RGB
                        </button>
                    </div>
                </div>
            </div>

            <!-- Error message -->
            <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
        </form>
    </div>
</div>

<script>
let currentOperation = 'rgb_to_hex';

function setOperation(op) {
    currentOperation = op;
}

document.getElementById('colorForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const resultsContainer = document.getElementById('resultsContainer');
    const errorMessage = document.getElementById('errorMessage');

    let formData = { operation: currentOperation };

    if (currentOperation === 'rgb_to_hex') {
        const r = parseInt(document.querySelector('input[name="r"]').value);
        const g = parseInt(document.querySelector('input[name="g"]').value);
        const b = parseInt(document.querySelector('input[name="b"]').value);

        if (isNaN(r) || isNaN(g) || isNaN(b)) {
            errorMessage.textContent = 'Please enter valid RGB values';
            errorMessage.style.display = 'block';
            return;
        }

        formData = { operation: currentOperation, r, g, b };
    } else {
        const hex = document.querySelector('input[name="hex"]').value;
        if (!hex.trim()) {
            errorMessage.textContent = 'Please enter a HEX value';
            errorMessage.style.display = 'block';
            return;
        }
        formData = { operation: currentOperation, hex };
    }

    errorMessage.style.display = 'none';

    fetch('{{ route("tools.kortex.tool.submit", "rgb-to-hex") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('resultRgb').textContent = data.data.rgb;
            document.getElementById('resultHex').textContent = data.data.hex;
            document.getElementById('colorPreview').style.backgroundColor = data.data.hex;
            resultsContainer.style.display = 'block';
        } else {
            errorMessage.textContent = data.message || 'An error occurred';
            errorMessage.style.display = 'block';
        }
    })
    .catch(error => {
        errorMessage.textContent = 'Error: ' + error.message;
        errorMessage.style.display = 'block';
    });
});

function copyHex() {
    const text = document.getElementById('resultHex').textContent;
    navigator.clipboard.writeText(text).then(() => alert('HEX copied!'));
}

function copyRGB() {
    const text = document.getElementById('resultRgb').textContent;
    navigator.clipboard.writeText(text).then(() => alert('RGB copied!'));
}
</script>