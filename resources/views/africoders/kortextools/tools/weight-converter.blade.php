<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">⚖️ Weight Converter</h5>
                </div>
                <div class="card-body">
                    <form id="weightForm">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="value" class="form-label">Weight Value</label>
                            <input type="number" class="form-control" id="value" name="value" placeholder="Enter value" step="0.01" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="conversionType" class="form-label">Convert From → To</label>
                            <select class="form-select" id="conversionType" name="conversion_type" required>
                                <option value="kg-to-lbs">Kilogram (kg) → Pound (lbs)</option>
                                <option value="lbs-to-kg">Pound (lbs) → Kilogram (kg)</option>
                                <option value="kg-to-g">Kilogram (kg) → Gram (g)</option>
                                <option value="g-to-kg">Gram (g) → Kilogram (kg)</option>
                                <option value="oz-to-g">Ounce (oz) → Gram (g)</option>
                                <option value="g-to-oz">Gram (g) → Ounce (oz)</option>
                                <option value="ton-to-kg">Metric Ton → Kilogram (kg)</option>
                                <option value="kg-to-ton">Kilogram (kg) → Metric Ton</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info w-100">Convert</button>
                    </form>
                    <div id="result" class="mt-4" style="display:none;">
                        <div class="alert alert-info">
                            <p><strong id="resultValue"></strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('weightForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(this));
    const response = await fetch('{{ route("tools.kortex.tool.submit", "weight-converter") }}', {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value},
        body: JSON.stringify({tool: 'weight-converter', ...data})
    });
    const result = await response.json();
    if (result.success) {
        document.getElementById('resultValue').textContent = `${data.value} ${result.unit_from} = ${result.result} ${result.unit_to}`;
        document.getElementById('result').style.display = 'block';
    }
});
</script>