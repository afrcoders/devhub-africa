<form id="slug-generator-form" class="needs-validation">
    <!-- Text Input -->
    <div class="mb-3">
        <label for="slug-text-input" class="form-label">
            <i class="bi bi-input-cursor me-2"></i>Enter Text
        </label>
        <input
            type="text"
            class="form-control"
            id="slug-text-input"
            placeholder="Enter text to convert to slug..."
            autocomplete="off"
        >
        <small class="form-text text-muted d-block mt-2">
            Convert any text to URL-friendly slug format
        </small>
    </div>

    <!-- Options -->
    <div class="mb-3">
        <h6 class="form-label">Options</h6>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="lowercase-check" checked>
            <label class="form-check-label" for="lowercase-check">
                Lowercase
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="trim-check" checked>
            <label class="form-check-label" for="trim-check">
                Trim spaces
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="remove-special-check" checked>
            <label class="form-check-label" for="remove-special-check">
                Remove special characters
            </label>
        </div>
    </div>

    <!-- Separator -->
    <div class="mb-3">
        <label for="slug-separator" class="form-label">Word Separator</label>
        <select class="form-select" id="slug-separator">
            <option value="-" selected>Hyphen (-)</option>
            <option value="_">Underscore (_)</option>
            <option value="">None</option>
        </select>
    </div>

    <!-- Output Section -->
    <div id="slug-output-section" class="mt-4" style="display: none;">
        <label class="form-label">Generated Slug</label>
        <div class="output-box">
            <input
                type="text"
                class="form-control"
                id="generated-slug"
                readonly
            >
            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="copySlugToClipboard()">
                <i class="bi bi-clipboard me-2"></i>Copy
            </button>
        </div>
    </div>
</form>

<script>
const textInput = document.getElementById('slug-text-input');
const lowercaseCheck = document.getElementById('lowercase-check');
const trimCheck = document.getElementById('trim-check');
const removeSpecialCheck = document.getElementById('remove-special-check');
const separatorSelect = document.getElementById('slug-separator');

// Add event listeners
textInput.addEventListener('input', generateSlug);
lowercaseCheck.addEventListener('change', generateSlug);
trimCheck.addEventListener('change', generateSlug);
removeSpecialCheck.addEventListener('change', generateSlug);
separatorSelect.addEventListener('change', generateSlug);

function generateSlug() {
    const text = textInput.value;

    if (!text.trim()) {
        document.getElementById('slug-output-section').style.display = 'none';
        return;
    }

    let slug = text;

    // Lowercase
    if (lowercaseCheck.checked) {
        slug = slug.toLowerCase();
    }

    // Remove special characters if checked
    if (removeSpecialCheck.checked) {
        slug = slug.replace(/[^a-z0-9\s\-_]/gi, '');
    }

    // Trim spaces if checked
    if (trimCheck.checked) {
        slug = slug.trim();
    }

    // Replace spaces with separator
    const separator = separatorSelect.value;
    slug = slug.replace(/\s+/g, separator);

    // Remove consecutive separators
    if (separator) {
        slug = slug.replace(new RegExp(separator + '+', 'g'), separator);
    }

    // Display result
    document.getElementById('generated-slug').value = slug;
    document.getElementById('slug-output-section').style.display = 'block';
}

function copySlugToClipboard() {
    const slug = document.getElementById('generated-slug');
    slug.select();
    document.execCommand('copy');
    alert('Slug copied to clipboard!');
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
    font-family: 'Courier New', monospace;
    padding: 0.75rem;
    margin-bottom: 0;
}
</style>
