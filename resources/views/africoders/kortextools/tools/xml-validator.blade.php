<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark"><h5 class="mb-0">✓ XML Validator</h5></div>
                <div class="card-body">
                    <form id="xmlForm">@csrf
                        <textarea class="form-control mb-3" name="xml" placeholder="Paste XML here" rows="6" required></textarea>
                        <button type="submit" class="btn btn-warning w-100">Validate</button>
                    </form>
                    <div id="result" class="mt-4" style="display:none;">
                        <div id="validAlert" class="alert alert-success" style="display:none;"><h6>✓ Valid XML</h6><p><strong>Root Element:</strong> <span id="resultRoot"></span></p></div>
                        <div id="invalidAlert" class="alert alert-danger" style="display:none;"><h6>✗ Invalid XML</h6><p id="resultError"></p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('xmlForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(this));
    const response = await fetch('{{ route("tools.kortex.tool.submit", "xml-validator") }}', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('[name="_token"]').value}, body:JSON.stringify({tool:'xml-validator',...data})});
    const result = await response.json();
    document.getElementById('result').style.display='block';
    if(result.success) {
        document.getElementById('validAlert').style.display='block';
        document.getElementById('invalidAlert').style.display='none';
        document.getElementById('resultRoot').textContent = result.root_element || 'N/A';
    } else {
        document.getElementById('validAlert').style.display='none';
        document.getElementById('invalidAlert').style.display='block';
        document.getElementById('resultError').textContent = result.error;
    }
});
</script>