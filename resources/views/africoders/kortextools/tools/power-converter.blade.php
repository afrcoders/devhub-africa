<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white"><h5 class="mb-0">⚙️ Power Converter</h5></div>
                <div class="card-body">
                    <form id="powerForm">@csrf
                        <input type="number" class="form-control mb-3" name="value" placeholder="Enter value" step="0.01" required>
                        <select class="form-select mb-3" name="conversion_type" required>
                            <option value="watt-to-kw">Watt (W) → Kilowatt (kW)</option>
                            <option value="kw-to-watt">Kilowatt (kW) → Watt (W)</option>
                            <option value="watt-to-hp">Watt (W) → Horsepower (hp)</option>
                            <option value="hp-to-watt">Horsepower (hp) → Watt (W)</option>
                            <option value="kw-to-hp">Kilowatt (kW) → Horsepower (hp)</option>
                            <option value="hp-to-kw">Horsepower (hp) → Kilowatt (kW)</option>
                            <option value="btu-to-watt">BTU/h → Watt (W)</option>
                            <option value="watt-to-btu">Watt (W) → BTU/h</option>
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
document.getElementById('powerForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(this));
    const response = await fetch('{{ route("tools.kortex.tool.submit", "power-converter") }}', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('[name="_token"]').value}, body:JSON.stringify({tool:'power-converter',...data})});
    const result = await response.json();
    if(result.success) {document.getElementById('resultValue').innerHTML = `<strong>${data.value} ${result.unit_from} = ${result.result} ${result.unit_to}</strong>`; document.getElementById('result').style.display='block';}
});
</script>