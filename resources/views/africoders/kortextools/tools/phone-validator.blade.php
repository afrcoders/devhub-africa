<div class="card">
    <div class="card-header">
        <h5>Phone Number Validator</h5>
        <p class="text-muted small mb-0">Validate phone numbers and format them</p>
    </div>
    <div class="card-body">
        <form id="phoneForm" class="tool-form">
            @csrf
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="+1 (555) 123-4567" required>
            </div>
            <div class="mb-3">
                <label for="country" class="form-label">Country Code</label>
                <input type="text" class="form-control" id="country" name="country" maxlength="2" value="US" placeholder="US">
                <small class="text-muted">ISO 2-letter country code</small>
            </div>
            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-phone"></i> Validate Phone</button>
            <div id="result" class="mt-4" style="display:none;">
                <div id="validAlert" class="alert" style="display:none;"></div>
                <div id="formattedResult" style="display:none;">
                    <p><strong>Formatted:</strong> <span id="formatted"></span></p>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('phoneForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = {tool: 'phone-validator', phone: document.getElementById('phone').value, country: document.getElementById('country').value.toUpperCase(), _token: document.querySelector('[name="_token"]').value};
    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "phone-validator") }}', {method: 'POST', headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value}, body: JSON.stringify(formData)});
        const data = await response.json();
        if(data.success) {
            const alert = document.getElementById('validAlert');
            alert.className = data.is_valid ? 'alert alert-success' : 'alert alert-danger';
            alert.textContent = data.message;
            alert.style.display = 'block';
            if(data.is_valid) {
                document.getElementById('formatted').textContent = data.formatted;
                document.getElementById('formattedResult').style.display = 'block';
            }
            document.getElementById('result').style.display = 'block';
        }
    } catch(e) { console.error(e); }
});
</script>