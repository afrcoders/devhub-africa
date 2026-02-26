<form id="hash-generator-form" method="POST" action="/tool/hash-generator" class="needs-validation">
    @csrf

    <!-- Text Input -->
    <div class="mb-3">
        <label for="hash-text" class="form-label">
            <i class="bi bi-input-cursor me-2"></i>Enter Text to Hash
        </label>
        <textarea
            class="form-control @error('text') is-invalid @enderror"
            id="hash-text"
            name="text"
            rows="6"
            placeholder="Enter any text..."
            required
        ></textarea>
        @error('text')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <!-- Output Section -->
    <div id="hash-output-section" class="mt-4" style="display: none;">
        <label class="form-label">Generated Hashes</label>
        <div class="output-box">
            <div id="hash-results" class="hash-results"></div>
            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="copyAllHashes()">
                <i class="bi bi-clipboard me-2"></i>Copy All
            </button>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
        <button
            type="reset"
            class="btn btn-secondary"
            onclick="document.getElementById('hash-output-section').style.display='none'"
        >
            <i class="bi bi-arrow-clockwise me-2"></i>Clear
        </button>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-key me-2"></i>Generate Hashes
        </button>
    </div>
</form>

<script>
document.getElementById('hash-generator-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const text = document.getElementById('hash-text').value;

    if (!text.trim()) {
        alert('Please enter text to hash');
        return;
    }

    try {
        const response = await fetch('/tool/hash-generator', {
            method: 'POST',
            body: new FormData(this),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const data = await response.json();

        if (data.success) {
            displayHashes(data.data);
        } else {
            alert('Error: ' + (data.message || 'Failed to generate hashes'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred');
    }
});

function displayHashes(data) {
    let html = '<div class="list-group">';

    Object.keys(data.hashes).forEach(algorithm => {
        const hash = data.hashes[algorithm];
        html += `
            <div class="list-group-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1 text-uppercase fw-bold">${algorithm}</h6>
                        <code class="text-break">${hash}</code>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="copyHash('${hash}')">
                        <i class="bi bi-clipboard"></i>
                    </button>
                </div>
            </div>
        `;
    });

    html += '</div>';
    document.getElementById('hash-results').innerHTML = html;
    document.getElementById('hash-output-section').style.display = 'block';
}

function copyHash(hash) {
    navigator.clipboard.writeText(hash);
    alert('Hash copied!');
}

function copyAllHashes() {
    const text = document.getElementById('hash-results').innerText;
    navigator.clipboard.writeText(text);
    alert('All hashes copied!');
}
</script>

<style>
.output-box {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 1rem;
}

.hash-results code {
    font-size: 0.85rem;
    background-color: #fff;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    display: block;
    margin-top: 0.5rem;
    word-break: break-all;
}
</style>
