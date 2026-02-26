<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white"><h5 class="mb-0">🔐 Base64 Encoder/Decoder</h5></div>
                <div class="card-body">
                    <form id="base64Form">@csrf
                        <textarea class="form-control mb-3" name="text" placeholder="Enter text or Base64 string" rows="4" required></textarea>
                        <div class="btn-group w-100 mb-3" role="group">
                            <input type="radio" class="btn-check" name="operation" id="encode" value="encode" checked>
                            <label class="btn btn-outline-primary" for="encode">Encode</label>
                            <input type="radio" class="btn-check" name="operation" id="decode" value="decode">
                            <label class="btn btn-outline-primary" for="decode">Decode</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Convert</button>
                    </form>
                    <div id="result" class="mt-4" style="display:none;"><div class="alert alert-primary"><p><strong>Result:</strong></p><p id="resultValue"></p><button class="btn btn-sm btn-outline-primary" onclick="copyToClipboard('resultValue')">Copy</button></div></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function copyToClipboard(id) { const el = document.getElementById(id); navigator.clipboard.writeText(el.textContent); }
document.getElementById('base64Form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(this));
    const response = await fetch('{{ route("tools.kortex.tool.submit", "base64-encoder-decoder") }}', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('[name="_token"]').value}, body:JSON.stringify({tool:'base64-encoder-decoder',...data})});
    const result = await response.json();
    if(result.success) {document.getElementById('resultValue').textContent = result.result; document.getElementById('result').style.display='block';}
    else {alert('Error: ' + result.error);}
});
</script>