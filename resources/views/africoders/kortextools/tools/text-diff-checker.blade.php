{{-- Text Diff Checker --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Text Diff Checker tool to compare two texts and highlight differences.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-balance-scale me-3"></i>Text Diff Checker
                </h1>
                <p class="lead text-muted">
                    Compare two texts and identify differences between them
                </p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-code-branch me-2"></i>Text Comparison Tool</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="text1Input" class="form-label fw-semibold">
                                <i class="fas fa-file-alt me-2"></i>Original Text
                            </label>
                            <textarea class="form-control" id="text1Input" rows="8"
                                placeholder="Paste or type the original text here..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="text2Input" class="form-label fw-semibold">
                                <i class="fas fa-file-alt me-2"></i>Modified Text
                            </label>
                            <textarea class="form-control" id="text2Input" rows="8"
                                placeholder="Paste or type the modified text here..."></textarea>
                        </div>
                    </div>

                    <div class="text-center mb-4">
                        <button type="button" id="compareBtn" class="btn btn-primary btn-lg">
                            <i class="fas fa-search me-2"></i>Compare Texts
                        </button>
                        <button type="button" id="clearBtn" class="btn btn-outline-secondary btn-lg ms-3">
                            <i class="fas fa-trash-alt me-2"></i>Clear All
                        </button>
                    </div>

                    <div id="resultSection" style="display: none;">
                        <div class="border-top pt-4">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <div class="badge bg-info fs-6 p-2">
                                            <i class="fas fa-equals me-2"></i>
                                            <span id="commonLines">0</span> Common Lines
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <div class="badge bg-danger fs-6 p-2">
                                            <i class="fas fa-minus me-2"></i>
                                            <span id="deletedLines">0</span> Deleted Lines
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <div class="badge bg-success fs-6 p-2">
                                            <i class="fas fa-plus me-2"></i>
                                            <span id="addedLines">0</span> Added Lines
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-list me-2"></i>Differences
                                    </label>
                                    <div id="diffResult" class="border p-3" style="max-height: 400px; overflow-y: auto; font-family: monospace; background-color: #f8f9fa;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const text1Input = document.getElementById('text1Input');
    const text2Input = document.getElementById('text2Input');
    const compareBtn = document.getElementById('compareBtn');
    const clearBtn = document.getElementById('clearBtn');
    const resultSection = document.getElementById('resultSection');
    const diffResult = document.getElementById('diffResult');
    const commonLines = document.getElementById('commonLines');
    const deletedLines = document.getElementById('deletedLines');
    const addedLines = document.getElementById('addedLines');

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function compareTexts() {
        const text1 = text1Input.value;
        const text2 = text2Input.value;

        if (!text1.trim() && !text2.trim()) {
            alert('Please enter some text to compare.');
            return;
        }

        const lines1 = text1.split('\n');
        const lines2 = text2.split('\n');

        let html = '';
        let common = 0, deleted = 0, added = 0;

        const maxLines = Math.max(lines1.length, lines2.length);

        for (let i = 0; i < maxLines; i++) {
            const line1 = lines1[i] || '';
            const line2 = lines2[i] || '';

            if (line1 === line2) {
                if (line1 !== '') {
                    html += `<div style="background-color: #e3f2fd; padding: 4px; margin: 1px 0;">= ${escapeHtml(line1)}</div>`;
                    common++;
                }
            } else {
                if (line1 !== '') {
                    html += `<div style="background-color: #ffebee; padding: 4px; margin: 1px 0;">- ${escapeHtml(line1)}</div>`;
                    deleted++;
                }
                if (line2 !== '') {
                    html += `<div style="background-color: #e8f5e8; padding: 4px; margin: 1px 0;">+ ${escapeHtml(line2)}</div>`;
                    added++;
                }
            }
        }

        if (html === '') {
            html = '<div class="text-muted">No differences found or both texts are empty.</div>';
        }

        diffResult.innerHTML = html;
        commonLines.textContent = common;
        deletedLines.textContent = deleted;
        addedLines.textContent = added;

        resultSection.style.display = 'block';
    }

    function clearAll() {
        text1Input.value = '';
        text2Input.value = '';
        resultSection.style.display = 'none';
    }

    compareBtn.addEventListener('click', compareTexts);
    clearBtn.addEventListener('click', clearAll);

    // Auto-compare when both fields have content
    function autoCompare() {
        if (text1Input.value || text2Input.value) {
            compareTexts();
        } else {
            resultSection.style.display = 'none';
        }
    }

    text1Input.addEventListener('input', autoCompare);
    text2Input.addEventListener('input', autoCompare);
});
</script>
