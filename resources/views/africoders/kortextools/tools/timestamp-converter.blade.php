<form id="timestamp-converter-form" method="POST" action="/tool/timestamp-converter" class="needs-validation">
    @csrf

    <!-- Conversion Tabs -->
    <ul class="nav nav-tabs mb-3" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="to-timestamp-tab" data-bs-toggle="tab" data-bs-target="#to-timestamp-panel" type="button" role="tab">
                <i class="bi bi-calendar-event me-2"></i>Date to Timestamp
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="from-timestamp-tab" data-bs-toggle="tab" data-bs-target="#from-timestamp-panel" type="button" role="tab">
                <i class="bi bi-calendar2 me-2"></i>Timestamp to Date
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Date to Timestamp Tab -->
        <div class="tab-pane fade show active" id="to-timestamp-panel" role="tabpanel">
            <div class="mb-3">
                <label for="datetime-input" class="form-label">Select Date & Time</label>
                <input
                    type="datetime-local"
                    class="form-control"
                    id="datetime-input"
                >
                <small class="form-text text-muted d-block mt-2">Or enter any date format</small>
            </div>
            <div class="mb-3">
                <label for="datetime-text" class="form-label">Date/Time (Text Format)</label>
                <input
                    type="text"
                    class="form-control"
                    id="datetime-text"
                    placeholder="e.g., 2024-12-30 15:30:00 or December 30, 2024"
                >
            </div>
            <button type="button" class="btn btn-primary" onclick="convertToTimestamp()">
                <i class="bi bi-arrow-right me-2"></i>Convert to Timestamp
            </button>
        </div>

        <!-- Timestamp to Date Tab -->
        <div class="tab-pane fade" id="from-timestamp-panel" role="tabpanel">
            <div class="mb-3">
                <label for="timestamp-input" class="form-label">Unix Timestamp</label>
                <input
                    type="number"
                    class="form-control"
                    id="timestamp-input"
                    placeholder="e.g., 1704067800"
                >
                <small class="form-text text-muted d-block mt-2">Enter seconds since January 1, 1970</small>
            </div>
            <div class="mb-3">
                <label for="timezone-select" class="form-label">Timezone</label>
                <select class="form-select" id="timezone-select">
                    <option value="UTC" selected>UTC</option>
                    <option value="America/New_York">America/New_York</option>
                    <option value="America/Los_Angeles">America/Los_Angeles</option>
                    <option value="Europe/London">Europe/London</option>
                    <option value="Europe/Paris">Europe/Paris</option>
                    <option value="Asia/Tokyo">Asia/Tokyo</option>
                    <option value="Australia/Sydney">Australia/Sydney</option>
                </select>
            </div>
            <button type="button" class="btn btn-primary" onclick="convertFromTimestamp()">
                <i class="bi bi-arrow-right me-2"></i>Convert from Timestamp
            </button>
        </div>
    </div>

    <!-- Output Section -->
    <div id="timestamp-output-section" class="mt-4" style="display: none;">
        <label class="form-label">Result</label>
        <div class="output-box">
            <div id="timestamp-results"></div>
            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="copyTimestampResult()">
                <i class="bi bi-clipboard me-2"></i>Copy
            </button>
        </div>
    </div>
</form>

<script>
function convertToTimestamp() {
    let dateString = document.getElementById('datetime-text').value ||
                     document.getElementById('datetime-input').value;

    if (!dateString.trim()) {
        alert('Please enter a date/time');
        return;
    }

    fetch('/tool/timestamp-converter', {
        method: 'POST',
        body: new URLSearchParams({
            operation: 'to_timestamp',
            datetime: dateString,
            '_token': document.querySelector('meta[name="csrf-token"]').content
        }),
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            displayTimestampResult(data.data);
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
}

function convertFromTimestamp() {
    const timestamp = document.getElementById('timestamp-input').value;
    const timezone = document.getElementById('timezone-select').value;

    if (!timestamp) {
        alert('Please enter a timestamp');
        return;
    }

    fetch('/tool/timestamp-converter', {
        method: 'POST',
        body: new URLSearchParams({
            operation: 'from_timestamp',
            timestamp: timestamp,
            timezone: timezone,
            '_token': document.querySelector('meta[name="csrf-token"]').content
        }),
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            displayTimestampResult(data.data);
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
}

function displayTimestampResult(data) {
    let html = '<div class="list-group">';

    Object.keys(data).forEach(key => {
        const value = data[key];
        const label = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
        html += `
            <div class="list-group-item">
                <small class="text-muted">${label}</small>
                <div class="font-monospace">${value}</div>
            </div>
        `;
    });

    html += '</div>';
    document.getElementById('timestamp-results').innerHTML = html;
    document.getElementById('timestamp-output-section').style.display = 'block';
}

function copyTimestampResult() {
    const text = document.getElementById('timestamp-results').innerText;
    navigator.clipboard.writeText(text);
    alert('Result copied to clipboard!');
}

// Set current date/time as default
window.addEventListener('load', function() {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');

    document.getElementById('datetime-input').value = `${year}-${month}-${day}T${hours}:${minutes}`;
});
</script>

<style>
.output-box {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 1rem;
}

.output-box .list-group-item {
    border-left: 3px solid #0d6efd;
    margin-bottom: 0.5rem;
}

.font-monospace {
    font-family: 'Courier New', monospace;
    font-size: 0.95rem;
    word-break: break-all;
    margin-top: 0.25rem;
}
</style>
