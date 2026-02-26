<div class="row">
    <div class="col-md-12">
        <div class="mb-4">
            <label for="inputText" class="form-label">Enter text to generate MD5 hash:</label>
            <textarea class="form-control" id="inputText" rows="5" placeholder="Type or paste your text here..."></textarea>
        </div>

        <div class="mb-3">
            <button type="button" class="btn btn-primary" onclick="generateMD5()">
                <i class="bi bi-hash"></i> Generate MD5
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="clearFields()">
                <i class="bi bi-x-circle"></i> Clear
            </button>
        </div>

        <div class="mb-4">
            <label for="md5Output" class="form-label">MD5 Hash:</label>
            <div class="input-group">
                <input type="text" class="form-control" id="md5Output" readonly placeholder="MD5 hash will appear here...">
                <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('md5Output')">
                    <i class="bi bi-clipboard"></i> Copy
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Information -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> About MD5 Hash</h6>
    <p class="mb-0">
        MD5 (Message Digest Algorithm 5) is a widely used cryptographic hash function that produces a 128-bit hash value.
        <strong>Note:</strong> MD5 is not suitable for security-critical applications due to vulnerabilities.
        For security purposes, consider using SHA-256 or other stronger algorithms.
    </p>
</div>

<style>
.tool-icon {
    font-size: 2rem;
    color: #6c757d;
}
.category-badge {
    background-color: #e9ecef;
    color: #495057;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    font-weight: 500;
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
<script>
function generateMD5() {
    const inputText = document.getElementById('inputText').value;

    if (inputText.trim() === '') {
        alert('Please enter some text to generate MD5 hash.');
        return;
    }

    const md5Hash = CryptoJS.MD5(inputText).toString();
    document.getElementById('md5Output').value = md5Hash;
}

function clearFields() {
    document.getElementById('inputText').value = '';
    document.getElementById('md5Output').value = '';
}

function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    if (element.value) {
        navigator.clipboard.writeText(element.value).then(function() {
            // Show success feedback
            const button = element.nextElementSibling;
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="bi bi-check"></i> Copied!';
            button.classList.remove('btn-outline-secondary');
            button.classList.add('btn-success');

            setTimeout(function() {
                button.innerHTML = originalText;
                button.classList.remove('btn-success');
                button.classList.add('btn-outline-secondary');
            }, 2000);
        });
    }
}

// Handle Enter key
document.getElementById('inputText').addEventListener('keypress', function(e) {
    if (e.key === 'Enter' && e.ctrlKey) {
        generateMD5();
    }
});
</script>
