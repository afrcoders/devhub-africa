{{-- Word Combiner --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Word Combiner tool for combining words and text in various creative ways.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-link me-3"></i>Word Combiner
                </h1>
                <p class="lead text-muted">
                    Combine words and phrases in different ways to create new combinations
                </p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-magic me-2"></i>Word Combination Tool</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="words1Input" class="form-label fw-semibold">
                                <i class="fas fa-list me-2"></i>First Set of Words
                            </label>
                            <textarea class="form-control" id="words1Input" rows="6"
                                placeholder="Enter first set of words (one per line)"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="words2Input" class="form-label fw-semibold">
                                <i class="fas fa-list me-2"></i>Second Set of Words
                            </label>
                            <textarea class="form-control" id="words2Input" rows="6"
                                placeholder="Enter second set of words (one per line)"></textarea>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="separatorInput" class="form-label fw-semibold">
                                <i class="fas fa-minus me-2"></i>Separator
                            </label>
                            <input type="text" class="form-control" id="separatorInput" value="" placeholder="Space, dash, etc.">
                            <div class="form-text">Leave empty for no separator</div>
                        </div>
                        <div class="col-md-6">
                            <label for="orderSelect" class="form-label fw-semibold">
                                <i class="fas fa-sort me-2"></i>Order
                            </label>
                            <select class="form-select" id="orderSelect">
                                <option value="first-second">First + Second</option>
                                <option value="second-first">Second + First</option>
                                <option value="both">Both Orders</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="capitalizeFirst">
                            <label class="form-check-label" for="capitalizeFirst">
                                Capitalize first letter of each combination
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="removeDuplicates" checked>
                            <label class="form-check-label" for="removeDuplicates">
                                Remove duplicate combinations
                            </label>
                        </div>
                    </div>

                    <div class="text-center mb-4">
                        <button type="button" id="combineBtn" class="btn btn-primary btn-lg">
                            <i class="fas fa-magic me-2"></i>Combine Words
                        </button>
                        <button type="button" id="clearBtn" class="btn btn-outline-secondary btn-lg ms-3">
                            <i class="fas fa-trash-alt me-2"></i>Clear All
                        </button>
                    </div>

                    <div id="resultSection" style="display: none;">
                        <div class="border-top pt-4">
                            <div class="mb-3">
                                <div class="text-center">
                                    <span class="badge bg-success fs-6 p-2">
                                        <i class="fas fa-list-ol me-2"></i>
                                        <span id="combinationCount">0</span> Combinations Generated
                                    </span>
                                </div>
                            </div>

                            <label for="resultOutput" class="form-label fw-semibold">
                                <i class="fas fa-check-circle me-2 text-success"></i>Combined Results
                            </label>
                            <textarea class="form-control" id="resultOutput" rows="10" readonly></textarea>
                            <div class="mt-2">
                                <button type="button" id="copyBtn" class="btn btn-outline-primary">
                                    <i class="fas fa-copy me-2"></i>Copy Results
                                </button>
                                <button type="button" id="downloadBtn" class="btn btn-outline-secondary ms-2">
                                    <i class="fas fa-download me-2"></i>Download as Text
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Examples section --}}
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Usage Examples</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h6>Business Names</h6>
                            <small>Combine "Tech, Smart, Quick" with "Solutions, Systems, Apps"</small>
                        </div>
                        <div class="col-md-4">
                            <h6>Product Names</h6>
                            <small>Combine "Super, Ultra, Pro" with "Clean, Fresh, Power"</small>
                        </div>
                        <div class="col-md-4">
                            <h6>Domain Ideas</h6>
                            <small>Combine "Blue, Green, Fast" with "Wave, Sky, Code"</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const words1Input = document.getElementById('words1Input');
    const words2Input = document.getElementById('words2Input');
    const separatorInput = document.getElementById('separatorInput');
    const orderSelect = document.getElementById('orderSelect');
    const capitalizeFirst = document.getElementById('capitalizeFirst');
    const removeDuplicates = document.getElementById('removeDuplicates');
    const resultOutput = document.getElementById('resultOutput');
    const resultSection = document.getElementById('resultSection');
    const combinationCount = document.getElementById('combinationCount');
    const combineBtn = document.getElementById('combineBtn');
    const clearBtn = document.getElementById('clearBtn');
    const copyBtn = document.getElementById('copyBtn');
    const downloadBtn = document.getElementById('downloadBtn');

    function combineWords() {
        const words1 = words1Input.value.trim().split('\n').filter(w => w.trim());
        const words2 = words2Input.value.trim().split('\n').filter(w => w.trim());

        if (words1.length === 0 || words2.length === 0) {
            alert('Please enter words in both sets.');
            return;
        }

        const separator = separatorInput.value;
        const order = orderSelect.value;
        let combinations = [];

        // Generate combinations
        if (order === 'first-second' || order === 'both') {
            words1.forEach(word1 => {
                words2.forEach(word2 => {
                    combinations.push(word1.trim() + separator + word2.trim());
                });
            });
        }

        if (order === 'second-first' || order === 'both') {
            words2.forEach(word2 => {
                words1.forEach(word1 => {
                    combinations.push(word2.trim() + separator + word1.trim());
                });
            });
        }

        // Remove duplicates if requested
        if (removeDuplicates.checked) {
            combinations = [...new Set(combinations)];
        }

        // Capitalize first letter if requested
        if (capitalizeFirst.checked) {
            combinations = combinations.map(combo =>
                combo.charAt(0).toUpperCase() + combo.slice(1)
            );
        }

        const result = combinations.join('\n');
        resultOutput.value = result;
        combinationCount.textContent = combinations.length;
        resultSection.style.display = 'block';
    }

    function clearAll() {
        words1Input.value = '';
        words2Input.value = '';
        separatorInput.value = '';
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

    function downloadResult() {
        const result = resultOutput.value;
        if (!result) return;

        const blob = new Blob([result], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'word-combinations.txt';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }

    combineBtn.addEventListener('click', combineWords);
    clearBtn.addEventListener('click', clearAll);
    copyBtn.addEventListener('click', copyResult);
    downloadBtn.addEventListener('click', downloadResult);

    // Auto-combine when inputs change
    [words1Input, words2Input, separatorInput, orderSelect].forEach(element => {
        element.addEventListener('input', function() {
            if (words1Input.value.trim() && words2Input.value.trim()) {
                combineWords();
            }
        });

        element.addEventListener('change', function() {
            if (words1Input.value.trim() && words2Input.value.trim()) {
                combineWords();
            }
        });
    });

    [capitalizeFirst, removeDuplicates].forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (words1Input.value.trim() && words2Input.value.trim()) {
                combineWords();
            }
        });
    });
});
</script>
