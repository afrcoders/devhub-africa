<div class="card">
    <div class="card-header">
        <h5>WHOIS Lookup</h5>
        <p class="text-muted small mb-0">Look up domain and IP WHOIS information</p>
    </div>
    <div class="card-body">
        <form id="whoisForm" class="tool-form">
            @csrf

            <div class="mb-3">
                <label for="query" class="form-label">Domain or IP Address</label>
                <input type="text" class="form-control" id="query" name="query" placeholder="example.com or 8.8.8.8">
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Lookup WHOIS
                </button>
            </div>

            <!-- Results -->
            <div id="resultsContainer" style="display: none;">
                <div class="mt-4">
                    <h6>WHOIS Information:</h6>
                    <div class="bg-light p-3 rounded">
                        <pre id="whoisOutput" style="white-space: pre-wrap; word-wrap: break-word;"></pre>
                    </div>

                    <div class="mt-3">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="copyWhois()">
                            <i class="fas fa-copy"></i> Copy All
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="downloadWhois()">
                            <i class="fas fa-download"></i> Download
                        </button>
                    </div>
                </div>
            </div>

            <!-- Loading spinner -->
            <div id="loadingSpinner" style="display: none;" class="text-center my-4">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

            <!-- Error message -->
            <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
        </form>
    </div>
</div>

<script>
document.getElementById('whoisForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const query = document.getElementById('query').value;
    const spinner = document.getElementById('loadingSpinner');
    const resultsContainer = document.getElementById('resultsContainer');
    const errorMessage = document.getElementById('errorMessage');

    if (!query.trim()) {
        errorMessage.textContent = 'Please enter a domain or IP address';
        errorMessage.style.display = 'block';
        return;
    }

    errorMessage.style.display = 'none';
    spinner.style.display = 'block';
    resultsContainer.style.display = 'none';

    fetch('{{ route("tools.kortex.tool.submit", "whois-lookup") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
        },
        body: JSON.stringify({ query: query })
    })
    .then(response => response.json())
    .then(data => {
        spinner.style.display = 'none';

        if (data.success) {
            document.getElementById('whoisOutput').textContent = data.data.whois;
            resultsContainer.style.display = 'block';
        } else {
            errorMessage.textContent = data.message || 'An error occurred';
            errorMessage.style.display = 'block';
        }
    })
    .catch(error => {
        spinner.style.display = 'none';
        errorMessage.textContent = 'Error: ' + error.message;
        errorMessage.style.display = 'block';
    });
});

function copyWhois() {
    const text = document.getElementById('whoisOutput').textContent;
    navigator.clipboard.writeText(text).then(() => {
        alert('WHOIS data copied to clipboard!');
    });
}

function downloadWhois() {
    const text = document.getElementById('whoisOutput').textContent;
    const element = document.createElement('a');
    element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
    element.setAttribute('download', 'whois.txt');
    element.style.display = 'none';
    document.body.appendChild(element);
    element.click();
    document.body.removeChild(element);
}
</script>