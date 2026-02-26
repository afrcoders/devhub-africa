<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white"><h5 class="mb-0">📐 Area Converter</h5></div>
                <div class="card-body">
                    <form id="areaForm">@csrf
                        <input type="number" class="form-control mb-3" name="value" placeholder="Enter value" step="0.01" required>
                        <select class="form-select mb-3" name="conversion_type" required>
                            <option value="sqm-to-sqft">Square Meter (m²) → Square Feet (ft²)</option>
                            <option value="sqft-to-sqm">Square Feet (ft²) → Square Meter (m²)</option>
                            <option value="sqm-to-hectare">Square Meter (m²) → Hectare</option>
                            <option value="hectare-to-sqm">Hectare → Square Meter (m²)</option>
                            <option value="sqkm-to-sqmile">Square Kilometer (km²) → Square Mile (mi²)</option>
                            <option value="sqmile-to-sqkm">Square Mile (mi²) → Square Kilometer (km²)</option>
                            <option value="acre-to-sqm">Acre → Square Meter (m²)</option>
                            <option value="sqm-to-acre">Square Meter (m²) → Acre</option>
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
document.getElementById('areaForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(this));
    const response = await fetch('{{ route("tools.kortex.tool.submit", "area-converter") }}', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('[name="_token"]').value}, body:JSON.stringify({tool:'area-converter',...data})});
    const result = await response.json();
    if(result.success) {document.getElementById('resultValue').innerHTML = `<strong>${data.value} ${result.unit_from} = ${result.result} ${result.unit_to}</strong>`; document.getElementById('result').style.display='block';}
});
</script>