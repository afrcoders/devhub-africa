<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white"><h5 class="mb-0">⚡ Speed Converter</h5></div>
                <div class="card-body">
                    <form id="speedForm">@csrf
                        <input type="number" class="form-control mb-3" name="value" placeholder="Enter value" step="0.01" required>
                        <select class="form-select mb-3" name="conversion_type" required>
                            <option value="kmh-to-mph">Km/h → Miles/h</option>
                            <option value="mph-to-kmh">Miles/h → Km/h</option>
                            <option value="kmh-to-mps">Km/h → Meters/s</option>
                            <option value="mps-to-kmh">Meters/s → Km/h</option>
                            <option value="knots-to-kmh">Knots → Km/h</option>
                            <option value="kmh-to-knots">Km/h → Knots</option>
                            <option value="mps-to-mph">Meters/s → Miles/h</option>
                            <option value="mph-to-mps">Miles/h → Meters/s</option>
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
document.getElementById('speedForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(this));
    const response = await fetch('{{ route("tools.kortex.tool.submit", "speed-converter") }}', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('[name="_token"]').value}, body:JSON.stringify({tool:'speed-converter',...data})});
    const result = await response.json();
    if(result.success) {document.getElementById('resultValue').innerHTML = `<strong>${data.value} ${result.unit_from} = ${result.result} ${result.unit_to}</strong>`; document.getElementById('result').style.display='block';}
});
</script>