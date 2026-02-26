<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark"><h5 class="mb-0">✓ URL Validator</h5></div>
                <div class="card-body">
                    <form id="urlForm">@csrf
                        <input type="text" class="form-control mb-3" name="url" placeholder="Enter URL (e.g. https://example.com)" required>
                        <button type="submit" class="btn btn-warning w-100">Validate</button>
                    </form>
                    <div id="result" class="mt-4" style="display:none;">
                        <div id="validAlert" class="alert alert-success" style="display:none;">
                            <h6>✓ Valid URL</h6>
                            <table class="table table-sm mb-0">
                                <tr><td><strong>Protocol:</strong></td><td id="resultScheme"></td></tr>
                                <tr><td><strong>Host:</strong></td><td id="resultHost"></td></tr>
                                <tr><td><strong>Path:</strong></td><td id="resultPath"></td></tr>
                                <tr><td><strong>Port:</strong></td><td id="resultPort"></td></tr>
                            </table>
                        </div>
                        <div id="invalidAlert" class="alert alert-danger" style="display:none;"><h6>✗ Invalid URL</h6><p id="resultError"></p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('urlForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(this));
    const response = await fetch('{{ route("tools.kortex.tool.submit", "url-validator") }}', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('[name="_token"]').value}, body:JSON.stringify({tool:'url-validator',...data})});
    const result = await response.json();
    document.getElementById('result').style.display='block';
    if(result.success) {
        document.getElementById('validAlert').style.display='block';
        document.getElementById('invalidAlert').style.display='none';
        document.getElementById('resultScheme').textContent = result.scheme || '-';
        document.getElementById('resultHost').textContent = result.host || '-';
        document.getElementById('resultPath').textContent = result.path || '/';
        document.getElementById('resultPort').textContent = result.port || 'Default';
    } else {
        document.getElementById('validAlert').style.display='none';
        document.getElementById('invalidAlert').style.display='block';
        document.getElementById('resultError').textContent = result.error;
    }
});
</script>