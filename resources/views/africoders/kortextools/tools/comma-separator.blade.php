{{-- Comma Separator --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Comma Separator tool for adding or removing commas from lists and converting between formats.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-list me-3"></i>Comma Separator
                </h1>
                <p class="lead text-muted">
                    Add commas to lists, remove commas, or convert between different formats
                </p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-exchange-alt me-2"></i>List Formatter</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label for="textInput" class="form-label fw-semibold">
                            <i class="fas fa-edit me-2"></i>Input List
                        </label>
                        <textarea class="form-control" id="textInput" rows="8"
                            placeholder="Enter your list here... (one item per line or comma-separated)"></textarea>
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Enter items one per line or separated by commas, spaces, semicolons, etc.
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="separatorSelect" class="form-label fw-semibold">
                                <i class="fas fa-cog me-2"></i>Output Separator
                            </label>
                            <select class="form-select" id="separatorSelect">
                                <option value=",">Comma (,)</option>
                                <option value=", ">Comma + Space (, )</option>
                                <option value=";">Semicolon (;)</option>
                                <option value="; ">Semicolon + Space (; )</option>
                                <option value="|">Pipe (|)</option>
                                <option value=" | ">Pipe + Spaces ( | )</option>
                                <option value="\n">New Line</option>
                                <option value=" ">Space</option>
                                <option value="\t">Tab</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-wrench me-2"></i>Options
                            </label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="trimSpaces" checked>
                                <label class="form-check-label" for="trimSpaces">
                                    Trim extra spaces
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="removeDuplicates">
                                <label class="form-check-label" for="removeDuplicates">
                                    Remove duplicates
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="removeEmpty" checked>
                                <label class="form-check-label" for="removeEmpty">
                                    Remove empty items
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mb-4">
                        <button type="button" id="formatBtn" class="btn btn-primary btn-lg">
                            <i class="fas fa-magic me-2"></i>Format List
                        </button>
                        <button type="button" id="clearBtn" class="btn btn-outline-secondary btn-lg ms-3">
                            <i class="fas fa-trash-alt me-2"></i>Clear
                        </button>
                    </div>

                    <div id="resultSection" style="display: none;">
                        <div class="border-top pt-4">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <span class="badge bg-info fs-6 p-2">
                                                <i class="fas fa-list-ol me-2"></i>
                                                <span id="itemCount">0</span> Items
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <span class="badge bg-secondary fs-6 p-2">
                                                <i class="fas fa-font me-2"></i>
                                                <span id="charCount">0</span> Characters
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <span class="badge bg-success fs-6 p-2">
                                                <i class="fas fa-check-circle me-2"></i>
                                                Formatted
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <label for="resultOutput" class="form-label fw-semibold">
                                <i class="fas fa-check-circle me-2 text-success"></i>Formatted Result
                            </label>
                            <textarea class="form-control" id="resultOutput" rows="8" readonly></textarea>
                            <div class="mt-2">
                                <button type="button" id="copyBtn" class="btn btn-outline-primary">
                                    <i class="fas fa-copy me-2"></i>Copy Result
                                </button>
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
    const textInput = document.getElementById('textInput');
    const separatorSelect = document.getElementById('separatorSelect');
    const trimSpaces = document.getElementById('trimSpaces');
    const removeDuplicates = document.getElementById('removeDuplicates');
    const removeEmpty = document.getElementById('removeEmpty');
    const resultOutput = document.getElementById('resultOutput');
    const resultSection = document.getElementById('resultSection');
    const itemCount = document.getElementById('itemCount');
    const charCount = document.getElementById('charCount');
    const formatBtn = document.getElementById('formatBtn');
    const clearBtn = document.getElementById('clearBtn');
    const copyBtn = document.getElementById('copyBtn');

    function formatList() {
        const text = textInput.value;

        if (!text.trim()) {
            alert('Please enter some text to format.');
            return;
        }

        // Split the text by common separators
        let items = text.split(/[,;|\n\t]+/);

        // Process options
        if (trimSpaces.checked) {
            items = items.map(item => item.trim());
        }

        if (removeEmpty.checked) {
            items = items.filter(item => item !== '');
        }

        if (removeDuplicates.checked) {
            items = [...new Set(items)];
        }

        // Get the separator
        let separator = separatorSelect.value;
        if (separator === '\\n') separator = '\n';
        if (separator === '\\t') separator = '\t';

        // Join with the selected separator
        const result = items.join(separator);

        resultOutput.value = result;
        itemCount.textContent = items.length;
        charCount.textContent = result.length;
        resultSection.style.display = 'block';
    }

    function clearAll() {
        textInput.value = '';
        resultOutput.value = '';
        resultSection.style.display = 'none';
    }

    function copyResult() {
        resultOutput.select();
        document.execCommand('copy');

        const originalText = copyBtn.innerHTML;
        copyBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
        copyBtn.classList.replace('btn-outline-primary', 'btn-success');

        setTimeout(() => {
            copyBtn.innerHTML = originalText;
            copyBtn.classList.replace('btn-success', 'btn-outline-primary');
        }, 2000);
    }

    formatBtn.addEventListener('click', formatList);
    clearBtn.addEventListener('click', clearAll);
    copyBtn.addEventListener('click', copyResult);

    // Auto-format when input changes
    textInput.addEventListener('input', function() {
        if (textInput.value.trim()) {
            formatList();
        } else {
            resultSection.style.display = 'none';
        }
    });

    separatorSelect.addEventListener('change', function() {
        if (textInput.value.trim()) {
            formatList();
        }
    });

    [trimSpaces, removeDuplicates, removeEmpty].forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (textInput.value.trim()) {
                formatList();
            }
        });
    });
});
</script>
