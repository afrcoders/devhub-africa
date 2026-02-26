<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white"><h5 class="mb-0">💨 Pressure Converter</h5></div>
                <div class="card-body">
                    <form id="pressureForm">@csrf
                        <input type="number" class="form-control mb-3" name="value" placeholder="Enter value" step="0.01" required>
                        <select class="form-select mb-3" name="conversion_type" required>
                            <option value="pa-to-atm">Pascal (Pa) → Atmosphere (atm)</option>
                            <option value="atm-to-pa">Atmosphere (atm) → Pascal (Pa)</option>
                            <option value="bar-to-pa">Bar → Pascal (Pa)</option>
                            <option value="pa-to-bar">Pascal (Pa) → Bar</option>
                            <option value="psi-to-pa">PSI → Pascal (Pa)</option>
                            <option value="pa-to-psi">Pascal (Pa) → PSI</option>
                            <option value="mmhg-to-pa">mmHg → Pascal (Pa)</option>
                            <option value="pa-to-mmhg">Pascal (Pa) → mmHg</option>
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
document.getElementById('pressureForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(this));
    const response = await fetch('{{ route("tools.kortex.tool.submit", "pressure-converter") }}', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('[name="_token"]').value}, body:JSON.stringify({tool:'pressure-converter',...data})});
    const result = await response.json();
    if(result.success) {document.getElementById('resultValue').innerHTML = `<strong>${data.value} ${result.unit_from} = ${result.result} ${result.unit_to}</strong>`; document.getElementById('result').style.display='block';}
});
</script>