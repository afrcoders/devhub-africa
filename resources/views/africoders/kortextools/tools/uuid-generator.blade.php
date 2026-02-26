<form id="uuid-generator-form" class="needs-validation">
    @csrf

    <!-- UUID Count -->
    <div class="mb-3">
        <label for="uuid-count" class="form-label">
            <i class="bi bi-list-ul me-2"></i>Number of UUIDs to Generate
        </label>
        <div class="d-flex align-items-center gap-3">
            <input
                type="range"
                class="form-range"
                id="uuid-count"
                name="count"
                min="1"
                max="100"
                value="1"
            >
            <input
                type="number"
                class="form-control"
                id="count-display"
                value="1"
                min="1"
                max="100"
                style="width: 80px;"
            >
        </div>
        <small class="form-text text-muted d-block mt-2">Between 1 and 100 UUIDs</small>
    </div>

    <!-- UUID Version -->
    <div class="mb-3">
        <label for="uuid-version" class="form-label">UUID Version</label>
        <select class="form-select" id="uuid-version" name="version">
            <option value="v4" selected>UUID v4 (Random)</option>
            <option value="v1">UUID v1 (Time-based)</option>
            <option value="v3">UUID v3 (MD5 Hash)</option>
            <option value="v5">UUID v5 (SHA1 Hash)</option>
        </select>
        <small class="form-text text-muted d-block mt-2">
            v4 (Random) is most commonly used and generated instantly
        </small>
    </div>

    <!-- Output Section -->
    <div id="uuid-output-section" class="mt-4" style="display: none;">
        <label class="form-label">Generated UUIDs</label>
        <div class="output-box">
            <textarea id="generated-uuids" class="form-control" rows="8" readonly></textarea>
            <div class="mt-2">
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="copyUuidsToClipboard()">
                    <i class="bi bi-clipboard me-2"></i>Copy All
                </button>
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="downloadUuids()">
                    <i class="bi bi-download me-2"></i>Download
                </button>
                <button type="button" class="btn btn-sm btn-outline-info" onclick="generateMore()">
                    <i class="bi bi-arrow-repeat me-2"></i>Generate More
                </button>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
        <button
            type="button"
            class="btn btn-secondary"
            onclick="resetGenerator()"
        >
            <i class="bi bi-arrow-clockwise me-2"></i>Reset
        </button>
        <button type="button" class="btn btn-primary" onclick="generateUuids()">
            <i class="bi bi-lightning-charge me-2"></i>Generate UUIDs
        </button>
    </div>
</form>

<script>
const countSlider = document.getElementById('uuid-count');
const countDisplay = document.getElementById('count-display');

// Sync count input and slider
countSlider.addEventListener('input', function() {
    countDisplay.value = this.value;
});

countDisplay.addEventListener('change', function() {
    countSlider.value = this.value;
});

function generateUuids() {
    const count = parseInt(document.getElementById('uuid-count').value);
    const version = document.getElementById('uuid-version').value;

    fetch('/tool/uuid-generator', {
        method: 'POST',
        body: new URLSearchParams({
            count: count,
            version: version,
            '_token': document.querySelector('meta[name="csrf-token"]').content
        }),
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const uuids = data.data.uuids.join('\n');
            document.getElementById('generated-uuids').value = uuids;
            document.getElementById('uuid-output-section').style.display = 'block';
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
}

function copyUuidsToClipboard() {
    const textarea = document.getElementById('generated-uuids');
    textarea.select();
    document.execCommand('copy');
    alert('UUIDs copied to clipboard!');
}

function downloadUuids() {
    const uuids = document.getElementById('generated-uuids').value;
    const blob = new Blob([uuids], { type: 'text/plain' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'uuids.txt';
    document.body.appendChild(a);
    a.click();
    window.URL.revokeObjectURL(url);
    a.remove();
}

function generateMore() {
    generateUuids();
}

function resetGenerator() {
    document.getElementById('uuid-count').value = 1;
    document.getElementById('count-display').value = 1;
    document.getElementById('uuid-version').value = 'v4';
    document.getElementById('uuid-output-section').style.display = 'none';
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
    font-family: 'Courier New', monospace;
    font-size: 0.875rem;
}
</style>
