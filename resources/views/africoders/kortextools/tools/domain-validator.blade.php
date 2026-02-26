<div class="card">
    <div class="card-header">
        <h5>Domain Validator</h5>
        <p class="text-muted small mb-0">Validate domain names and extract components</p>
    </div>
    <div class="card-body">
        <form id="domainForm" class="tool-form">
            @csrf
            <div class="mb-3">
                <label for="domain" class="form-label">Domain Name</label>
                <input type="text" class="form-control" id="domain" name="domain" placeholder="example.com" required>
            </div>
            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-globe"></i> Validate Domain</button>
            <div id="result" class="mt-4" style="display:none;">
                <div id="validAlert" class="alert" style="display:none;"></div>
                <div id="componentsTable" style="display:none;">
                    <table class="table table-sm">
                        <tr><th>Subdomain</th><td id="subdomain">-</td></tr>
                        <tr><th>Domain Name</th><td id="domainName">-</td></tr>
                        <tr><th>TLD</th><td id="tld">-</td></tr>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('domainForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = {tool: 'domain-validator', domain: document.getElementById('domain').value, _token: document.querySelector('[name="_token"]').value};
    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "domain-validator") }}', {method: 'POST', headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value}, body: JSON.stringify(formData)});
        const data = await response.json();
        if(data.success) {
            const alert = document.getElementById('validAlert');
            alert.className = data.is_valid ? 'alert alert-success' : 'alert alert-danger';
            alert.textContent = data.message;
            alert.style.display = 'block';
            if(data.is_valid && data.components) {
                document.getElementById('subdomain').textContent = data.components.subdomain || '-';
                document.getElementById('domainName').textContent = data.components.name || '-';
                document.getElementById('tld').textContent = data.components.tld || '-';
                document.getElementById('componentsTable').style.display = 'block';
            }
            document.getElementById('result').style.display = 'block';
        }
    } catch(e) { console.error(e); }
});
</script>