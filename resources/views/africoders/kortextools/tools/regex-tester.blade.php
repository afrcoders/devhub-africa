<form id="regex-tester-form" method="POST" action="/tool/regex-tester" class="needs-validation">
    @csrf

    <!-- Regex Pattern -->
    <div class="mb-3">
        <label for="regex-pattern" class="form-label">
            <i class="bi bi-search me-2"></i>Regular Expression Pattern
        </label>
        <input
            type="text"
            class="form-control @error('pattern') is-invalid @enderror"
            id="regex-pattern"
            name="pattern"
            placeholder="e.g., [a-z]+@[a-z]+\.[a-z]+"
            required
        >
        @error('pattern')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
        <small class="form-text text-muted d-block mt-2">
            Enter a regex pattern without delimiters (e.g., use [a-z]+ not /[a-z]+/)
        </small>
    </div>

    <!-- Test Text -->
    <div class="mb-3">
        <label for="regex-text" class="form-label">
            <i class="bi bi-file-text me-2"></i>Text to Test
        </label>
        <textarea
            class="form-control @error('text') is-invalid @enderror"
            id="regex-text"
            name="text"
            rows="6"
            placeholder="Enter text to test against the regex..."
            required
        ></textarea>
        @error('text')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <!-- Modifiers -->
    <div class="mb-3">
        <label for="regex-modifiers" class="form-label">Modifiers</label>
        <div class="input-group">
            <span class="input-group-text">/pattern/</span>
            <input
                type="text"
                class="form-control"
                id="regex-modifiers"
                name="modifiers"
                placeholder="e.g., gi"
                maxlength="10"
            >
        </div>
        <small class="form-text text-muted d-block mt-2">
            g = global, i = case-insensitive, m = multiline, s = dotall, x = extended
        </small>
    </div>

    <!-- Output Section -->
    <div id="regex-output-section" class="mt-4" style="display: none;">
        <label class="form-label">Results</label>
        <div class="output-box">
            <div id="regex-results"></div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
        <button
            type="reset"
            class="btn btn-secondary"
            onclick="document.getElementById('regex-output-section').style.display='none'"
        >
            <i class="bi bi-arrow-clockwise me-2"></i>Clear
        </button>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-arrow-right-square me-2"></i>Test Pattern
        </button>
    </div>
</form>

<script>
document.getElementById('regex-tester-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const pattern = document.getElementById('regex-pattern').value;
    const text = document.getElementById('regex-text').value;

    if (!pattern.trim() || !text.trim()) {
        alert('Please enter both pattern and text');
        return;
    }

    try {
        const response = await fetch('/tool/regex-tester', {
            method: 'POST',
            body: new FormData(this),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const data = await response.json();

        if (data.success) {
            displayRegexResults(data.data);
        } else {
            alert('Error: ' + (data.message || 'Failed to test regex'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred');
    }
});

function displayRegexResults(data) {
    let html = '<div class="card">';

    // Status
    const statusClass = data.match_count > 0 ? 'success' : 'warning';
    const statusIcon = data.match_count > 0 ? 'check-circle' : 'exclamation-circle';
    html += `
        <div class="card-header bg-${statusClass} text-white">
            <i class="bi bi-${statusIcon}"></i> ${data.test_result}
        </div>
        <div class="card-body">
            <div class="mb-3">
                <small class="text-muted">Pattern:</small>
                <div><code>${data.pattern}</code></div>
            </div>
            <div class="mb-3">
                <small class="text-muted">Matches Found:</small>
                <div class="h5">${data.match_count}</div>
            </div>
    `;

    if (data.matches.length > 0) {
        html += '<div class="mb-3"><small class="text-muted">Matched Text:</small><ul class="list-unstyled">';
        data.matches.forEach((match, index) => {
            html += `<li><code>${match.match}</code> <small class="text-muted">at position ${match.offset}</small></li>`;
        });
        html += '</ul></div>';
    }

    html += '</div></div>';

    document.getElementById('regex-results').innerHTML = html;
    document.getElementById('regex-output-section').style.display = 'block';
}
</script>

<style>
.output-box {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 1rem;
}

.output-box code {
    background-color: #fff;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.9rem;
}
</style>
