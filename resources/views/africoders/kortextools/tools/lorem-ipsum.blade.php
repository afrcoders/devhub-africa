<div class="card">
    <div class="card-header">
        <h5>Lorem Ipsum Generator</h5>
        <p class="text-muted small mb-0">Generate placeholder Lorem Ipsum text</p>
    </div>
    <div class="card-body">
        <form id="loremForm" class="tool-form">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-select" id="type" name="type">
                        <option value="words">Words</option>
                        <option value="sentences">Sentences</option>
                        <option value="paragraphs" selected>Paragraphs</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="count" class="form-label">Count</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="count" name="count" value="3" min="1" max="100">
                        <span class="input-group-text">
                            <small id="countLabel">paragraphs</small>
                        </span>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-magic"></i> Generate
                </button>
            </div>

            <!-- Results -->
            <div id="resultsContainer" style="display: none;">
                <div class="mt-4">
                    <h6>Generated Lorem Ipsum:</h6>
                    <div class="bg-light p-3 rounded">
                        <p id="loremOutput" style="white-space: pre-wrap; word-wrap: break-word; line-height: 1.6;"></p>
                    </div>

                    <div class="mt-3">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="copyLorem()">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="downloadLorem()">
                            <i class="fas fa-download"></i> Download
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="clearLorem()">
                            <i class="fas fa-trash"></i> Clear
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
// Update label when type changes
document.getElementById('type').addEventListener('change', function() {
    const label = this.value.replace('_', ' ');
    const singular = label.slice(0, -1); // Remove 's' for singular
    document.getElementById('countLabel').textContent = singular;
});

document.getElementById('loremForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const type = document.getElementById('type').value;
    const count = parseInt(document.getElementById('count').value);
    const resultsContainer = document.getElementById('resultsContainer');
    const errorMessage = document.getElementById('errorMessage');

    if (count < 1 || count > 100) {
        errorMessage.textContent = 'Count must be between 1 and 100';
        errorMessage.style.display = 'block';
        return;
    }

    errorMessage.style.display = 'none';

    fetch('{{ route("tools.kortex.tool.submit", "lorem-ipsum") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
        },
        body: JSON.stringify({ type: type, count: count })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('loremOutput').textContent = data.data.text;
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

function copyLorem() {
    const text = document.getElementById('loremOutput').textContent;
    navigator.clipboard.writeText(text).then(() => {
        alert('Copied to clipboard!');
    });
}

function downloadLorem() {
    const text = document.getElementById('loremOutput').textContent;
    const element = document.createElement('a');
    element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
    element.setAttribute('download', 'lorem-ipsum.txt');
    element.style.display = 'none';
    document.body.appendChild(element);
    element.click();
    document.body.removeChild(element);
}

function clearLorem() {
    document.getElementById('loremOutput').textContent = '';
    document.getElementById('resultsContainer').style.display = 'none';
}
</script>