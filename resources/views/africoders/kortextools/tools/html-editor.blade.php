{{-- HTML Editor --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    HTML Editor for writing and previewing HTML code in real-time.
</div>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-code me-3"></i>HTML Editor
                </h1>
                <p class="lead text-muted">
                    Edit HTML and see the live preview instantly
                </p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>HTML Code</h5>
                        <div>
                            <button type="button" id="clearBtn" class="btn btn-sm btn-outline-light">
                                <i class="fas fa-trash-alt me-1"></i>Clear
                            </button>
                            <button type="button" id="copyBtn" class="btn btn-sm btn-outline-light ms-1">
                                <i class="fas fa-copy me-1"></i>Copy
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0" style="height: 600px;">
                    <textarea class="form-control border-0 font-monospace h-100" id="htmlInput"
                        placeholder="Enter your HTML code here..."
                        style="resize: none; outline: none; font-size: 14px; line-height: 1.5;"></textarea>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-eye me-2"></i>Live Preview</h5>
                        <button type="button" id="refreshBtn" class="btn btn-sm btn-outline-light">
                            <i class="fas fa-sync me-1"></i>Refresh
                        </button>
                    </div>
                </div>
                <div class="card-body p-0" style="height: 600px; overflow: hidden;">
                    <iframe id="htmlPreview" class="w-100 h-100 border-0"></iframe>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Editor Options</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="autoRefresh" checked>
                                <label class="form-check-label" for="autoRefresh">
                                    Auto-refresh preview
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="button" id="templateBtn" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-file-code me-2"></i>Load Template
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" id="downloadBtn" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-download me-2"></i>Download HTML
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const htmlInput = document.getElementById('htmlInput');
    const htmlPreview = document.getElementById('htmlPreview');
    const autoRefresh = document.getElementById('autoRefresh');
    const clearBtn = document.getElementById('clearBtn');
    const copyBtn = document.getElementById('copyBtn');
    const refreshBtn = document.getElementById('refreshBtn');
    const templateBtn = document.getElementById('templateBtn');
    const downloadBtn = document.getElementById('downloadBtn');

    let refreshTimeout;

    function updatePreview() {
        const htmlCode = htmlInput.value;
        htmlPreview.srcdoc = htmlCode || '<p class="text-center text-muted mt-5">Your HTML preview will appear here...</p>';
    }

    function scheduleRefresh() {
        if (!autoRefresh.checked) return;
        clearTimeout(refreshTimeout);
        refreshTimeout = setTimeout(updatePreview, 500);
    }

    function clearEditor() {
        htmlInput.value = '';
        updatePreview();
    }

    function copyCode() {
        htmlInput.select();
        document.execCommand('copy');

        const originalText = copyBtn.innerHTML;
        copyBtn.innerHTML = '<i class="fas fa-check me-1"></i>Copied!';
        copyBtn.classList.replace('btn-outline-light', 'btn-success');
        setTimeout(() => {
            copyBtn.innerHTML = originalText;
            copyBtn.classList.replace('btn-success', 'btn-outline-light');
        }, 2000);
    }

    function loadTemplate() {
        const template = `<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Web Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        p {
            line-height: 1.6;
            color: #666;
        }
        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to My Web Page</h1>
        <p>This is a sample HTML template to get you started.</p>
        <button onclick="alert('Hello World!')">Click Me!</button>
    </div>
</body>
</html>`;

        htmlInput.value = template;
        updatePreview();
    }

    function downloadHTML() {
        const blob = new Blob([htmlInput.value], { type: 'text/html' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'index.html';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }

    htmlInput.addEventListener('input', scheduleRefresh);
    clearBtn.addEventListener('click', clearEditor);
    copyBtn.addEventListener('click', copyCode);
    refreshBtn.addEventListener('click', updatePreview);
    templateBtn.addEventListener('click', loadTemplate);
    downloadBtn.addEventListener('click', downloadHTML);

    updatePreview();
});
</script>
