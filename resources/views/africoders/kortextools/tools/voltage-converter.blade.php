{{-- Voltage Converter --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Voltage Converter for converting between different voltage units and standards.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-bolt me-3"></i>Voltage Converter
                </h1>
                <p class="lead text-muted">
                    Convert between different voltage units and electrical standards
                </p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-exchange-alt me-2"></i>Voltage Converter</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="inputValue" class="form-label fw-semibold">
                                <i class="fas fa-arrow-down me-2"></i>Input Value
                            </label>
                            <input type="number" class="form-control" id="inputValue" value="100" step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label for="inputUnit" class="form-label fw-semibold">
                                <i class="fas fa-cogs me-2"></i>From Unit
                            </label>
                            <select class="form-select" id="inputUnit">
                                <option value="v">Volt (V)</option>
                                <option value="mv">Millivolt (mV)</option>
                                <option value="kv">Kilovolt (kV)</option>
                                <option value="microv">Microvolt (μV)</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="outputUnit" class="form-label fw-semibold">
                                <i class="fas fa-cogs me-2"></i>To Unit
                            </label>
                            <select class="form-select" id="outputUnit">
                                <option value="v" selected>Volt (V)</option>
                                <option value="mv">Millivolt (mV)</option>
                                <option value="kv">Kilovolt (kV)</option>
                                <option value="microv">Microvolt (μV)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="outputValue" class="form-label fw-semibold">
                                <i class="fas fa-arrow-up me-2"></i>Output Value
                            </label>
                            <input type="text" class="form-control" id="outputValue" readonly>
                        </div>
                    </div>

                    <div class="text-center mb-4">
                        <button type="button" id="swapBtn" class="btn btn-secondary">
                            <i class="fas fa-exchange-alt me-2"></i>Swap Units
                        </button>
                        <button type="button" id="copyBtn" class="btn btn-outline-primary ms-2">
                            <i class="fas fa-copy me-2"></i>Copy Result
                        </button>
                    </div>
                </div>
            </div>

            {{-- Quick conversions --}}
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-table me-2"></i>Quick Conversion Table</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Volt (V)</th>
                                    <th>Millivolt (mV)</th>
                                    <th>Kilovolt (kV)</th>
                                    <th>Microvolt (μV)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>1,000</td>
                                    <td>0.001</td>
                                    <td>1,000,000</td>
                                </tr>
                                <tr>
                                    <td>100</td>
                                    <td>100,000</td>
                                    <td>0.1</td>
                                    <td>100,000,000</td>
                                </tr>
                                <tr>
                                    <td>1,000</td>
                                    <td>1,000,000</td>
                                    <td>1</td>
                                    <td>1,000,000,000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Reference --}}
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Common Voltage Standards</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Household Standards</h6>
                            <ul class="text-muted small">
                                <li><strong>USA/Canada:</strong> 120V AC, 60 Hz</li>
                                <li><strong>Europe/UK:</strong> 230V AC, 50 Hz</li>
                                <li><strong>Battery:</strong> 1.5V, 3.7V, 12V DC</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Industrial Standards</h6>
                            <ul class="text-muted small">
                                <li><strong>Low Voltage:</strong> 1-50V</li>
                                <li><strong>Medium Voltage:</strong> 1-35 kV</li>
                                <li><strong>High Voltage:</strong> 35-230 kV</li>
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
    const inputValue = document.getElementById('inputValue');
    const inputUnit = document.getElementById('inputUnit');
    const outputUnit = document.getElementById('outputUnit');
    const outputValue = document.getElementById('outputValue');
    const swapBtn = document.getElementById('swapBtn');
    const copyBtn = document.getElementById('copyBtn');

    const conversionFactors = {
        'v': 1,
        'mv': 0.001,
        'kv': 1000,
        'microv': 0.000001
    };

    function convert() {
        const input = parseFloat(inputValue.value);
        if (isNaN(input)) {
            outputValue.value = '';
            return;
        }

        const fromFactor = conversionFactors[inputUnit.value];
        const toFactor = conversionFactors[outputUnit.value];

        const voltValue = input / fromFactor;
        const result = voltValue * toFactor;

        outputValue.value = result.toLocaleString('en-US', { maximumFractionDigits: 10 });
    }

    function swapUnits() {
        const temp = inputUnit.value;
        inputUnit.value = outputUnit.value;
        outputUnit.value = temp;
        convert();
    }

    function copyResult() {
        if (!outputValue.value) return;

        navigator.clipboard.writeText(outputValue.value).then(() => {
            const originalText = copyBtn.innerHTML;
            copyBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
            copyBtn.classList.replace('btn-outline-primary', 'btn-success');

            setTimeout(() => {
                copyBtn.innerHTML = originalText;
                copyBtn.classList.replace('btn-success', 'btn-outline-primary');
            }, 2000);
        });
    }

    inputValue.addEventListener('input', convert);
    inputValue.addEventListener('change', convert);
    inputUnit.addEventListener('change', convert);
    outputUnit.addEventListener('change', convert);
    swapBtn.addEventListener('click', swapUnits);
    copyBtn.addEventListener('click', copyResult);

    convert();
});
</script>
