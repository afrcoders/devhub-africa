<div class="card">
    <div class="card-header">
        <h5>Text to ASCII</h5>
        <p class="text-muted small mb-0">Convert text characters to ASCII codes</p>
    </div>
    <div class="card-body">
        <form id="textAsciiForm" class="tool-form">
            @csrf

            <div class="mb-3">
                <label for="text" class="form-label">Text</label>
                <textarea class="form-control" id="text" name="text" rows="4" placeholder="Enter text..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-exchange-alt"></i> Convert</button>

            <div id="result" style="display: none;" class="mt-4">
                <h6>ASCII Codes:</h6>
                <div class="bg-light p-3 rounded"><code id="ascii" style="word-break: break-all;"></code></div>
                <button type="button" class="btn btn-sm btn-outline-secondary mt-3" onclick="copyAscii()"><i class="fas fa-copy"></i> Copy</button>
            </div>
            <div id="error" class="alert alert-danger" style="display: none;"></div>
        </form>
    </div>
</div>

<script>
document.getElementById('textAsciiForm').addEventListener('submit', function(e) {
    e.preventDefault();
    fetch('{{ route("tools.kortex.tool.submit", "text-to-ascii") }}', {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value},
        body: JSON.stringify({ text: document.getElementById('text').value })
    }).then(r => r.json()).then(d => {
        if (d.success) {
            document.getElementById('ascii').textContent = d.data.ascii;
            document.getElementById('result').style.display = 'block';
            document.getElementById('error').style.display = 'none';
        } else {
            document.getElementById('error').textContent = d.message;
            document.getElementById('error').style.display = 'block';
        }
    });
});

function copyAscii() {
    navigator.clipboard.writeText(document.getElementById('ascii').textContent).then(() => alert('Copied!'));
}
</script>