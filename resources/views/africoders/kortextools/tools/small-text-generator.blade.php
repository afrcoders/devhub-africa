<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white"><h5 class="mb-0">✨ Small Text Generator</h5></div>
                <div class="card-body">
                    <form id="smallForm">@csrf
                        <textarea class="form-control mb-3" name="text" placeholder="Enter your text" rows="4" required></textarea>
                        <select class="form-select mb-3" name="style_type" required>
                            <option value="superscript">Superscript (ˢᵘᵖᵉʳ)</option>
                            <option value="subscript">Subscript (ₛᵤᵦ)</option>
                            <option value="strikethrough">Strikethrough (s̶t̶r̶i̶k̶e̶)</option>
                            <option value="bold">Bold (𝐁𝐨𝐥𝐝)</option>
                            <option value="italic">Italic (𝑰𝒕𝒂𝒍𝒊𝒄)</option>
                            <option value="tiny">Tiny (ᴛɪɴʏ)</option>
                        </select>
                        <button type="submit" class="btn btn-primary w-100">Convert</button>
                    </form>
                    <div id="result" class="mt-4" style="display:none;"><div class="alert alert-primary"><p><strong>Result:</strong></p><p style="font-size: 24px;" id="resultValue"></p><button class="btn btn-sm btn-outline-primary" onclick="copyToClipboard('resultValue')">Copy</button></div></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function copyToClipboard(id) { const el = document.getElementById(id); navigator.clipboard.writeText(el.textContent); }
document.getElementById('smallForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(this));
    const response = await fetch('{{ route("tools.kortex.tool.submit", "small-text-generator") }}', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('[name="_token"]').value}, body:JSON.stringify({tool:'small-text-generator',...data})});
    const result = await response.json();
    if(result.success) {document.getElementById('resultValue').textContent = result.result; document.getElementById('result').style.display='block';}
});
</script>