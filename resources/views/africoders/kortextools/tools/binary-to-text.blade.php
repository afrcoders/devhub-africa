<div class="card">
    <div class="card-header">
        <h5>Binary to Text</h5>
        <p class="text-muted small mb-0">Convert binary code to text</p>
    </div>
    <div class="card-body">
        <form id="binaryTextForm" class="tool-form">
            @csrf

            <div class="mb-3">
                <label for="binary" class="form-label">Binary Code (space separated)</label>
                <textarea class="form-control" id="binary" name="binary" rows="4" placeholder="01001000 01100101 01101100 01101100 01101111"></textarea>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-exchange-alt"></i> Convert</button>

            <div id="result" style="display: none;" class="mt-4">
                <h6>Text:</h6>
                <div class="bg-light p-3 rounded"><p id="text" style="word-break: break-all;"></p></div>
                <button type="button" class="btn btn-sm btn-outline-secondary mt-3" onclick="copyText()"><i class="fas fa-copy"></i> Copy</button>
            </div>
            <div id="error" class="alert alert-danger" style="display: none;"></div>
        </form>
    </div>
</div>

<script>
document.getElementById('binaryTextForm').addEventListener('submit', function(e) {
    e.preventDefault();
    fetch('{{ route("tools.kortex.tool.submit", "binary-to-text") }}', {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value},
        body: JSON.stringify({ binary: document.getElementById('binary').value })
    }).then(r => r.json()).then(d => {
        if (d.success) {
            document.getElementById('text').textContent = d.data.text;
            document.getElementById('result').style.display = 'block';
            document.getElementById('error').style.display = 'none';
        } else {
            document.getElementById('error').textContent = d.message;
            document.getElementById('error').style.display = 'block';
        }
    });
});

function copyText() {
    navigator.clipboard.writeText(document.getElementById('text').textContent).then(() => alert('Copied!'));
}
</script>