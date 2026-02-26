<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark"><h5 class="mb-0">✓ JSON Validator</h5></div>
                <div class="card-body">
                    <form id="jsonForm">@csrf
                        <textarea class="form-control mb-3" name="json" placeholder="Paste JSON here" rows="6" required></textarea>
                        <button type="submit" class="btn btn-warning w-100">Validate</button>
                    </form>
                    <div id="result" class="mt-4" style="display:none;">
                        <div id="validAlert" class="alert alert-success" style="display:none;"><h6>✓ Valid JSON</h6><p id="resultFormatted"></p><button class="btn btn-sm btn-outline-success" onclick="copyToClipboard('resultFormatted')">Copy</button></div>
                        <div id="invalidAlert" class="alert alert-danger" style="display:none;"><h6>✗ Invalid JSON</h6><p id="resultError"></p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function copyToClipboard(id) { const el = document.getElementById(id); navigator.clipboard.writeText(el.textContent); }
document.getElementById('jsonForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(this));
    const response = await fetch('{{ route("tools.kortex.tool.submit", "json-validator") }}', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('[name="_token"]').value}, body:JSON.stringify({tool:'json-validator',...data})});
    const result = await response.json();
    document.getElementById('result').style.display='block';
    if(result.success) {
        document.getElementById('validAlert').style.display='block';
        document.getElementById('invalidAlert').style.display='none';
        document.getElementById('resultFormatted').textContent = result.formatted;
    } else {
        document.getElementById('validAlert').style.display='none';
        document.getElementById('invalidAlert').style.display='block';
        document.getElementById('resultError').textContent = result.error;
    }
});
</script>