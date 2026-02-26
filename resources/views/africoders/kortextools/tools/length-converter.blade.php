<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white"><h5 class="mb-0">📏 Length Converter</h5></div>
                <div class="card-body">
                    <form id="lengthForm">@csrf
                        <input type="number" class="form-control mb-3" name="value" placeholder="Enter value" step="0.01" required>
                        <select class="form-select mb-3" name="conversion_type" required>
                            <option value="meter-to-feet">Meter (m) → Feet (ft)</option>
                            <option value="feet-to-meter">Feet (ft) → Meter (m)</option>
                            <option value="meter-to-cm">Meter (m) → Centimeter (cm)</option>
                            <option value="cm-to-meter">Centimeter (cm) → Meter (m)</option>
                            <option value="km-to-miles">Kilometer (km) → Miles</option>
                            <option value="miles-to-km">Miles → Kilometer (km)</option>
                            <option value="inch-to-cm">Inches → Centimeter (cm)</option>
                            <option value="cm-to-inch">Centimeter (cm) → Inches</option>
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
document.getElementById('lengthForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(this));
    const response = await fetch('{{ route("tools.kortex.tool.submit", "length-converter") }}', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('[name="_token"]').value}, body:JSON.stringify({tool:'length-converter',...data})});
    const result = await response.json();
    if(result.success) {document.getElementById('resultValue').innerHTML = `<strong>${data.value} ${result.unit_from} = ${result.result} ${result.unit_to}</strong>`; document.getElementById('result').style.display='block';}
});
</script>