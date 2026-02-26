<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">🌡️ Temperature Converter</h5>
                </div>
                <div class="card-body">
                    <form id="temperatureForm" class="form-horizontal">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="value" class="form-label">Temperature Value</label>
                            <input type="number" class="form-control" id="value" name="value" placeholder="Enter value" step="0.01" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="conversionType" class="form-label">Convert From → To</label>
                            <select class="form-select" id="conversionType" name="conversion_type" required>
                                <option value="celsius-to-fahrenheit">Celsius (°C) → Fahrenheit (°F)</option>
                                <option value="fahrenheit-to-celsius">Fahrenheit (°F) → Celsius (°C)</option>
                                <option value="celsius-to-kelvin">Celsius (°C) → Kelvin (K)</option>
                                <option value="kelvin-to-celsius">Kelvin (K) → Celsius (°C)</option>
                                <option value="fahrenheit-to-kelvin">Fahrenheit (°F) → Kelvin (K)</option>
                                <option value="kelvin-to-fahrenheit">Kelvin (K) → Fahrenheit (°F)</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-info w-100">Convert</button>
                    </form>

                    <div id="result" class="mt-4" style="display:none;">
                        <div class="alert alert-info">
                            <h6>Result</h6>
                            <p class="mb-2"><strong id="resultValue"></strong></p>
                            <p class="mb-0 text-muted" id="resultFormula"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('temperatureForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const data = Object.fromEntries(formData);

        try {
            const response = await fetch('{{ route("tools.kortex.tool.submit", "temperature-converter") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value,
                },
                body: JSON.stringify({ tool: 'temperature-converter', ...data })
            });

            const result = await response.json();
            if (result.success) {
                document.getElementById('resultValue').textContent = `${data.value}° = ${result.result}°`;
                document.getElementById('resultFormula').textContent = `Formula: ${result.formula}`;
                document.getElementById('result').style.display = 'block';
            }
        } catch (error) {
            alert('Error: ' + error.message);
        }
    });
</script>