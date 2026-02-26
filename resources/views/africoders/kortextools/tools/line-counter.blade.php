{{-- Line Counter --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Line Counter tool for counting lines, words, and characters in text.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-list-ol me-3"></i>Line Counter
                </h1>
                <p class="lead text-muted">
                    Count lines, words, and characters in your text
                </p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>Text Analysis</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label for="textInput" class="form-label fw-semibold">
                            <i class="fas fa-edit me-2"></i>Input Text
                        </label>
                        <textarea class="form-control" id="textInput" rows="10"
                            placeholder="Paste or type your text here to analyze..."></textarea>
                    </div>

                    <div class="text-center mb-4">
                        <button type="button" id="clearBtn" class="btn btn-outline-secondary">
                            <i class="fas fa-trash-alt me-2"></i>Clear
                        </button>
                    </div>

                    <div id="statsSection">
                        <div class="row text-center">
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h3 class="text-primary mb-0" id="lineCount">0</h3>
                                        <small class="text-muted">Lines</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h3 class="text-success mb-0" id="wordCount">0</h3>
                                        <small class="text-muted">Words</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h3 class="text-info mb-0" id="charCount">0</h3>
                                        <small class="text-muted">Characters</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h3 class="text-warning mb-0" id="charNoSpaceCount">0</h3>
                                        <small class="text-muted">No Spaces</small>
                                    </div>
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
    const textInput = document.getElementById('textInput');
    const clearBtn = document.getElementById('clearBtn');
    const lineCount = document.getElementById('lineCount');
    const wordCount = document.getElementById('wordCount');
    const charCount = document.getElementById('charCount');
    const charNoSpaceCount = document.getElementById('charNoSpaceCount');

    function updateCounts() {
        const text = textInput.value;

        // Count lines
        const lines = text === '' ? 0 : text.split('\n').length;

        // Count words
        const words = text.trim() === '' ? 0 : text.trim().split(/\s+/).length;

        // Count characters
        const chars = text.length;

        // Count characters without spaces
        const charsNoSpace = text.replace(/\s/g, '').length;

        lineCount.textContent = lines;
        wordCount.textContent = words;
        charCount.textContent = chars;
        charNoSpaceCount.textContent = charsNoSpace;
    }

    function clearAll() {
        textInput.value = '';
        updateCounts();
        textInput.focus();
    }

    // Real-time counting
    textInput.addEventListener('input', updateCounts);
    textInput.addEventListener('paste', function() {
        setTimeout(updateCounts, 10);
    });

    clearBtn.addEventListener('click', clearAll);

    // Initialize counts
    updateCounts();
});
</script>
