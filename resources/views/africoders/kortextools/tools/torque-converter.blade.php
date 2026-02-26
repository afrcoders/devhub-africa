<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white"><h5 class="mb-0">🔧 Torque Converter</h5></div>
                <div class="card-body">
                    <form id="torqueForm">@csrf
                        <input type="number" class="form-control mb-3" name="value" placeholder="Enter value" step="0.01" required>
                        <select class="form-select mb-3" name="conversion_type" required>
                            <option value="nm-to-ftlb">Newton-meter (N·m) → Foot-pound (ft·lb)</option>
                            <option value="ftlb-to-nm">Foot-pound (ft·lb) → Newton-meter (N·m)</option>
                            <option value="nm-to-inlb">Newton-meter (N·m) → Inch-pound (in·lb)</option>
                            <option value="inlb-to-nm">Inch-pound (in·lb) → Newton-meter (N·m)</option>
                            <option value="kgfm-to-nm">Kilogram-force-meter → Newton-meter (N·m)</option>
                            <option value="nm-to-kgfm">Newton-meter (N·m) → Kilogram-force-meter</option>
                            <option value="ftlb-to-inlb">Foot-pound (ft·lb) → Inch-pound (in·lb)</option>
                            <option value="inlb-to-ftlb">Inch-pound (in·lb) → Foot-pound (ft·lb)</option>
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
document.getElementById('torqueForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(this));
    const response = await fetch('{{ route("tools.kortex.tool.submit", "torque-converter") }}', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('[name="_token"]').value}, body:JSON.stringify({tool:'torque-converter',...data})});
    const result = await response.json();
    if(result.success) {document.getElementById('resultValue').innerHTML = `<strong>${data.value} ${result.unit_from} = ${result.result} ${result.unit_to}</strong>`; document.getElementById('result').style.display='block';}
});
</script>