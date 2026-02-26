<form id="byteForm">@csrf
    <input type="number" class="form-control mb-3" name="value" placeholder="Enter value" step="0.01" required>
    <select class="form-select mb-3" name="conversion_type" required>
        <option value="byte-to-kb">Byte (B) → Kilobyte (KB)</option>
        <option value="kb-to-byte">Kilobyte (KB) → Byte (B)</option>
        <option value="kb-to-mb">Kilobyte (KB) → Megabyte (MB)</option>
        <option value="mb-to-kb">Megabyte (MB) → Kilobyte (KB)</option>
        <option value="mb-to-gb">Megabyte (MB) → Gigabyte (GB)</option>
        <option value="gb-to-mb">Gigabyte (GB) → Megabyte (MB)</option>
        <option value="gb-to-tb">Gigabyte (GB) → Terabyte (TB)</option>
        <option value="tb-to-gb">Terabyte (TB) → Gigabyte (GB)</option>
        <option value="byte-to-mb">Byte (B) → Megabyte (MB)</option>
        <option value="byte-to-gb">Byte (B) → Gigabyte (GB)</option>
    </select>
    <button type="submit" class="btn btn-info w-100">Convert</button>
</form>
<div id="result" class="mt-4" style="display:none;"><div class="alert alert-info"><p id="resultValue"></p></div></div>

<script>
document.getElementById('byteForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(this));
    const response = await fetch('{{ route("tools.kortex.tool.submit", "byte-converter") }}', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('[name="_token"]').value}, body:JSON.stringify({tool:'byte-converter',...data})});
    const result = await response.json();
    if(result.success) {document.getElementById('resultValue').innerHTML = `<strong>${data.value} ${result.unit_from} = ${result.result} ${result.unit_to}</strong>`; document.getElementById('result').style.display='block';}
});
</script>

