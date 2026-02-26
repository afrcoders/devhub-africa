<div class="card">
    <div class="card-header">
        <h5>Reverse Text Generator</h5>
        <p class="text-muted small mb-0">Reverse any text instantly</p>
    </div>
    <div class="card-body">
        <form id="reverseForm" class="tool-form">
            @csrf

            <div class="mb-3">
                <label for="text" class="form-label">Text to Reverse</label>
                <textarea class="form-control" id="text" name="text" rows="5" placeholder="Enter text here..."></textarea>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-exchange-alt"></i> Reverse Text
                </button>
            </div>

            <!-- Results -->
            <div id="resultsContainer" style="display: none;">
                <div class="mt-4">
                    <h6>Reversed Text:</h6>
                    <div class="bg-light p-3 rounded">
                        <p id="reversedText" style="word-break: break-all;"></p>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">Length: <span id="textLength">0</span> characters</small>
                    </div>
                    <div class="mt-3">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="copyReversed()">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                    </div>
                </div>
            </div>

            <!-- Error message -->
            <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
        </form>
    </div>
</div>

<script>
document.getElementById('reverseForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const text = document.getElementById('text').value;
    const resultsContainer = document.getElementById('resultsContainer');
    const errorMessage = document.getElementById('errorMessage');

    if (!text.trim()) {
        errorMessage.textContent = 'Please enter some text';
        errorMessage.style.display = 'block';
        return;
    }

    errorMessage.style.display = 'none';

    fetch('{{ route("tools.kortex.tool.submit", "reverse-text") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
        },
        body: JSON.stringify({ text: text })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('reversedText').textContent = data.data.reversed;
            document.getElementById('textLength').textContent = data.data.length;
            resultsContainer.style.display = 'block';
        } else {
            errorMessage.textContent = data.message || 'An error occurred';
            errorMessage.style.display = 'block';
        }
    })
    .catch(error => {
        errorMessage.textContent = 'Error: ' + error.message;
        errorMessage.style.display = 'block';
    });
});

function copyReversed() {
    const text = document.getElementById('reversedText').textContent;
    navigator.clipboard.writeText(text).then(() => {
        alert('Copied to clipboard!');
    });
}
</script>