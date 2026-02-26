<div class="card">
    <div class="card-header">
        <h5>IP Address Validator</h5>
        <p class="text-muted small mb-0">Validate IPv4 and IPv6 addresses</p>
    </div>
    <div class="card-body">
        <form id="ipForm" class="tool-form">
            @csrf
            <div class="mb-3">
                <label for="ip" class="form-label">IP Address</label>
                <input type="text" class="form-control" id="ip" name="ip" placeholder="192.168.1.1 or 2001:db8::1" required>
            </div>
            <div class="mb-3">
                <label for="version" class="form-label">IP Version</label>
                <select class="form-select" id="version" name="version">
                    <option value="both">Both IPv4 & IPv6</option>
                    <option value="ipv4">IPv4 Only</option>
                    <option value="ipv6">IPv6 Only</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-network-wired"></i> Validate IP</button>
            <div id="result" class="mt-4" style="display:none;">
                <div id="validAlert" class="alert" style="display:none;"></div>
                <div id="infoTable" style="display:none;">
                    <table class="table table-sm">
                        <tbody id="infoBody"></tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('ipForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = {tool: 'ip-validator', ip: document.getElementById('ip').value, version: document.getElementById('version').value, _token: document.querySelector('[name="_token"]').value};
    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "ip-validator") }}', {method: 'POST', headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value}, body: JSON.stringify(formData)});
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
                document.getElementById('infoTable').style.display = 'block';
            }
            document.getElementById('result').style.display = 'block';
        }
    } catch(e) { console.error(e); }
});
</script>