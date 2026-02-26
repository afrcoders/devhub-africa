<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white"><h5 class="mb-0">🧪 Volume Converter</h5></div>
                <div class="card-body">
                    <form id="volumeForm">@csrf
                        <input type="number" class="form-control mb-3" name="value" placeholder="Enter value" step="0.01" required>
                        <select class="form-select mb-3" name="conversion_type" required>
                            <option value="liter-to-gallon">Liter (L) → Gallon (gal)</option>
                            <option value="gallon-to-liter">Gallon (gal) → Liter (L)</option>
                            <option value="liter-to-ml">Liter (L) → Milliliter (mL)</option>
                            <option value="ml-to-liter">Milliliter (mL) → Liter (L)</option>
                            <option value="cubicm-to-liter">Cubic Meter (m³) → Liter (L)</option>
                            <option value="liter-to-cubicm">Liter (L) → Cubic Meter (m³)</option>
                            <option value="pint-to-liter">Pint → Liter (L)</option>
                            <option value="liter-to-pint">Liter (L) → Pint</option>
                        </select>
                        <button type="submit" class="btn btn-info w-100">Convert</button>
                    </form>
                    <div id="result" class="mt-4" style="display:none;"><div class="alert alert-info"><p id="resultValue"></p></div></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('volumeForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(this));
    const response = await fetch('{{ route("tools.kortex.tool.submit", "volume-converter") }}', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('[name="_token"]').value}, body:JSON.stringify({tool:'volume-converter',...data})});
    const result = await response.json();
    if(result.success) {document.getElementById('resultValue').innerHTML = `<strong>${data.value} ${result.unit_from} = ${result.result} ${result.unit_to}</strong>`; document.getElementById('result').style.display='block';}
});
</script>