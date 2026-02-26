<div class="card">
    <div class="card-header">
        <h5>IP Information</h5>
        <p class="text-muted small mb-0">Detect and display your client IP address</p>
    </div>
    <div class="card-body">
        <form id="ipInfoForm" class="tool-form">
            @csrf

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Detect My IP
                </button>
            </div>

            <!-- Results -->
            <div id="resultsContainer" style="display: none;">
                <div class="mt-4">
                    <h6>Results:</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tbody>
                                <tr>
                                    <th width="30%">IP Address</th>
                                    <td><code id="resultIp">-</code></td>
                                </tr>
                                <tr>
                                    <th>IP Version</th>
                                    <td><span id="resultVersion" class="badge bg-info">-</span></td>
                                </tr>
                                <tr>
                                    <th>Type</th>
                                    <td><span id="resultType" class="badge bg-success">-</span></td>
                                </tr>
                                <tr>
                                    <th>Is Private</th>
                                    <td><span id="resultPrivate" class="badge">-</span></td>
                                </tr>
                                <tr>
                                    <th>Is Reserved</th>
                                    <td><span id="resultReserved" class="badge">-</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="copyToClipboard(document.getElementById('resultIp').textContent)">
                            <i class="fas fa-copy"></i> Copy IP
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
document.getElementById('ipInfoForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const spinner = document.getElementById('loadingSpinner');
    const resultsContainer = document.getElementById('resultsContainer');
    const errorMessage = document.getElementById('errorMessage');

    spinner.style.display = 'block';
    resultsContainer.style.display = 'none';
    errorMessage.style.display = 'none';

    fetch('{{ route("tools.kortex.tool.submit", "ip-info") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        spinner.style.display = 'none';

        if (data.success) {
            document.getElementById('resultIp').textContent = data.data.ip;
            document.getElementById('resultVersion').textContent = data.data.version;
            document.getElementById('resultType').textContent = data.data.is_private ? 'Private' : 'Public';
            document.getElementById('resultPrivate').innerHTML = data.data.is_private ? '<span class="badge bg-warning">Yes</span>' : '<span class="badge bg-secondary">No</span>';
            document.getElementById('resultReserved').innerHTML = data.data.is_reserved ? '<span class="badge bg-warning">Yes</span>' : '<span class="badge bg-secondary">No</span>';

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

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Copied to clipboard!');
    });
}
</script>