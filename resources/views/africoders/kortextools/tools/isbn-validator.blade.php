<div class="card">
    <div class="card-header">
        <h5>ISBN Validator</h5>
        <p class="text-muted small mb-0">Validate ISBN-10 and ISBN-13 numbers</p>
    </div>
    <div class="card-body">
        <form id="isbnForm" class="tool-form">
            @csrf
            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn" placeholder="978-0-306-40615-2" required>
                <small class="text-muted">Enter 10 or 13 digit ISBN</small>
            </div>
            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-book"></i> Validate ISBN</button>
            <div id="result" class="mt-4" style="display:none;">
                <div id="validAlert" class="alert" style="display:none;"></div>
                <div id="typeResult" style="display:none;">
                    <p><strong>Type:</strong> <span id="isbnType" class="badge"></span></p>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('isbnForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = {tool: 'isbn-validator', isbn: document.getElementById('isbn').value, _token: document.querySelector('[name="_token"]').value};
    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "isbn-validator") }}', {method: 'POST', headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value}, body: JSON.stringify(formData)});
        const data = await response.json();
        if(data.success) {
            const alert = document.getElementById('validAlert');
            alert.className = data.is_valid ? 'alert alert-success' : 'alert alert-danger';
            alert.textContent = data.message;
            alert.style.display = 'block';
            if(data.is_valid && data.type) {
                document.getElementById('isbnType').textContent = data.type;
                document.getElementById('isbnType').className = 'badge bg-success';
                document.getElementById('typeResult').style.display = 'block';
            }
            document.getElementById('result').style.display = 'block';
        }
    } catch(e) { console.error(e); }
});
</script>