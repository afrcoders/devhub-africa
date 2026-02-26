<form id="text-case-form" method="POST" action="/tool/text-case" class="needs-validation">
    @csrf

    <!-- Text Input -->
    <div class="mb-3">
        <label for="text-input" class="form-label">
            <i class="bi bi-type me-2"></i>Enter Text
        </label>
        <textarea
            class="form-control @error('text') is-invalid @enderror"
            id="text-input"
            name="text"
            rows="8"
            placeholder="Enter text to convert..."
            required
        ></textarea>
        @error('text')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <!-- Case Type Selection -->
    <div class="mb-3">
        <label for="case-type" class="form-label">Convert To</label>
        <select class="form-select" id="case-type" name="case_type" required>
            <option value="lowercase">Lowercase (all small letters)</option>
            <option value="uppercase" selected>UPPERCASE (ALL CAPITAL LETTERS)</option>
            <option value="titlecase">Title Case (First Letter Of Each Word)</option>
            <option value="sentencecase">Sentence case (First letter of sentence).</option>
            <option value="togglecase">tOGGLE cASE (Reverse case of each character)</option>
            <option value="capitalize">Capitalize (ALL WORDS CAPITALIZED)</option>
        </select>
    </div>

    <!-- Output Section -->
    <div id="output-section" class="mt-4" style="display: none;">
        <label class="form-label">Converted Text</label>
        <div class="output-box">
            <textarea id="result-output" class="form-control" rows="8" readonly></textarea>
            <div class="mt-2">
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="copyTextToClipboard()">
                    <i class="bi bi-clipboard me-2"></i>Copy
                </button>
                <span id="char-info" class="ms-3 text-muted small"></span>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
        <button
            type="reset"
            class="btn btn-secondary"
            onclick="document.getElementById('output-section').style.display='none'"
        >
            <i class="bi bi-arrow-clockwise me-2"></i>Clear
        </button>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-arrow-right-square me-2"></i>Convert
        </button>
    </div>
</form>

<script>
document.getElementById('text-case-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const text = document.getElementById('text-input').value;
    const caseType = document.getElementById('case-type').value;

    if (!text.trim()) {
        alert('Please enter text to convert');
        return;
    }

    try {
        const response = await fetch('/tool/text-case', {
            method: 'POST',
            body: new FormData(this),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const data = await response.json();

        if (data.success) {
            document.getElementById('result-output').value = data.data.result;
            document.getElementById('char-info').textContent =
                `Original: ${data.data.original_length} chars | Result: ${data.data.result_length} chars`;
            document.getElementById('output-section').style.display = 'block';
        } else {
            alert('Error: ' + (data.message || 'Failed to convert'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred');
    }
});

function copyTextToClipboard() {
    const textarea = document.getElementById('result-output');
    textarea.select();
    document.execCommand('copy');
    alert('Copied to clipboard!');
}
</script>

<style>
.output-box {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 1rem;
}

.output-box .form-control {
    border: none;
    background: white;
    padding: 0.75rem;
    margin-bottom: 0;
}
</style>
