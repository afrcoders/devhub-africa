<form id="json-formatter-form" method="POST" action="/tool/json-formatter" class="needs-validation">
    @csrf

    <!-- JSON Input -->
    <div class="mb-3">
        <label for="json-input" class="form-label">
            <i class="bi bi-code-square me-2"></i>JSON Input
        </label>
        <textarea
            class="form-control @error('json') is-invalid @enderror"
            id="json-input"
            name="json"
            rows="8"
            placeholder='{"name": "example", "value": 123}'
            required
        ></textarea>
        <small class="form-text text-muted d-block mt-2">
            Paste your raw or minified JSON code
        </small>
        @error('json')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <!-- Format Options -->
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="indent-size" class="form-label">Indent Size</label>
            <select class="form-select" id="indent-size" name="indent_size">
                <option value="2">2 Spaces</option>
                <option value="4" selected>4 Spaces</option>
                <option value="8">8 Spaces</option>
                <option value="tab">Tab</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Options</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="validate-json" name="validate" value="1" checked>
                <label class="form-check-label" for="validate-json">
                    Validate JSON
                </label>
            </div>
        </div>
    </div>

    <!-- Output Section -->
    <div id="output-section" style="display: none;">
        <label class="form-label">Formatted Output</label>
        <div class="output-box">
            <pre id="formatted-output"></pre>
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="copyToClipboard('formatted-output')">
                <i class="bi bi-clipboard me-2"></i>Copy
            </button>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button
            type="reset"
            class="btn btn-secondary"
            onclick="document.getElementById('output-section').style.display='none'"
        >
            <i class="bi bi-arrow-clockwise me-2"></i>Clear
        </button>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-arrow-right-square me-2"></i>Format JSON
        </button>
    </div>
</form>

<script>
document.getElementById('json-formatter-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const json = document.getElementById('json-input').value;
    const indentSize = document.getElementById('indent-size').value;

    if (!json.trim()) {
        alert('Please enter JSON code');
        return;
    }

    try {
        // Try to parse and format
        const parsed = JSON.parse(json);
        const indentation = indentSize === 'tab' ? '\t' : ' '.repeat(parseInt(indentSize));
        const formatted = JSON.stringify(parsed, null, indentation);

        document.getElementById('formatted-output').textContent = formatted;
        document.getElementById('output-section').style.display = 'block';
    } catch (error) {
        alert('Invalid JSON: ' + error.message);
    }
});

function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    const text = element.textContent;
    navigator.clipboard.writeText(text).then(() => {
        alert('Copied to clipboard!');
    });
}
</script>

<style>
.output-box {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 1rem;
    position: relative;
    margin-bottom: 1rem;
}

.output-box pre {
    margin-bottom: 0;
    max-height: 400px;
    overflow-y: auto;
    font-size: 0.875rem;
}
</style>
