<div class="card">
    <div class="card-header">
        <h5>IBAN Validator</h5>
        <p class="text-muted small mb-0">Validate International Bank Account Numbers</p>
    </div>
    <div class="card-body">
        <form id="ibanForm" class="tool-form">
            @csrf
            <div class="mb-3">
                <label for="iban" class="form-label">IBAN</label>
                <input type="text" class="form-control" id="iban" name="iban" placeholder="DE89370400440532013000" required>
                <small class="text-muted">Enter complete IBAN with country code</small>
            </div>
            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-landmark"></i> Validate IBAN</button>
            <div id="result" class="mt-4" style="display:none;">
                <div id="validAlert" class="alert" style="display:none;"></div>
                <div id="ibanInfo" style="display:none;">
                    <table class="table table-sm">
                        <tbody id="infoBody"></tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('ibanForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = {tool: 'iban-validator', iban: document.getElementById('iban').value.toUpperCase(), _token: document.querySelector('[name="_token"]').value};
    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "iban-validator") }}', {method: 'POST', headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value}, body: JSON.stringify(formData)});
        const data = await response.json();
        if(data.success) {
            const alert = document.getElementById('validAlert');
            alert.className = data.is_valid ? 'alert alert-success' : 'alert alert-danger';
            alert.textContent = data.message;
            alert.style.display = 'block';
            if(data.is_valid && data.info) {
                const tbody = document.getElementById('infoBody');
                tbody.innerHTML = '';
                Object.entries(data.info).forEach(([key, value]) => {
                    const row = `<tr><th>${key.replace(/_/g, ' ')}</th><td>${value}</td></tr>`;
                    tbody.innerHTML += row;
                });
                document.getElementById('ibanInfo').style.display = 'block';
            }
            document.getElementById('result').style.display = 'block';
        }
    } catch(e) { console.error(e); }
});
</script>