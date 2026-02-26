{{-- Random Number Generator --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Random Number Generator for creating random numbers within specified ranges.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-dice me-3"></i>Random Number Generator
                </h1>
                <p class="lead text-muted">
                    Generate random numbers, sequences, and lists with various options
                </p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-random me-2"></i>Number Generation Settings</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="minInput" class="form-label fw-semibold">
                                <i class="fas fa-arrow-down me-2"></i>Minimum Value
                            </label>
                            <input type="number" class="form-control" id="minInput" value="1">
                        </div>
                        <div class="col-md-4">
                            <label for="maxInput" class="form-label fw-semibold">
                                <i class="fas fa-arrow-up me-2"></i>Maximum Value
                            </label>
                            <input type="number" class="form-control" id="maxInput" value="100">
                        </div>
                        <div class="col-md-4">
                            <label for="countInput" class="form-label fw-semibold">
                                <i class="fas fa-list-ol me-2"></i>How Many Numbers
                            </label>
                            <input type="number" class="form-control" id="countInput" value="10" min="1" max="1000">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="formatSelect" class="form-label fw-semibold">
                                <i class="fas fa-cog me-2"></i>Output Format
                            </label>
                            <select class="form-select" id="formatSelect">
                                <option value="list">List (one per line)</option>
                                <option value="comma">Comma separated</option>
                                <option value="space">Space separated</option>
                                <option value="array">Array format [1,2,3]</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-wrench me-2"></i>Options
                            </label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="allowDuplicates" checked>
                                <label class="form-check-label" for="allowDuplicates">
                                    Allow duplicate numbers
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="sortNumbers">
                                <label class="form-check-label" for="sortNumbers">
                                    Sort numbers in ascending order
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mb-4">
                        <button type="button" id="generateBtn" class="btn btn-primary btn-lg">
                            <i class="fas fa-dice me-2"></i>Generate Numbers
                        </button>
                        <button type="button" id="clearBtn" class="btn btn-outline-secondary btn-lg ms-3">
                            <i class="fas fa-trash-alt me-2"></i>Clear
                        </button>
                    </div>

                    <div id="resultSection" style="display: none;">
                        <div class="border-top pt-4">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        <span class="badge bg-info fs-6 p-2">
                                            <i class="fas fa-list-ol me-2"></i>
                                            <span id="generatedCount">0</span> Numbers
                                        </span>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <span class="badge bg-secondary fs-6 p-2">
                                            <i class="fas fa-sort-numeric-up me-2"></i>
                                            Min: <span id="actualMin">0</span>
                                        </span>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <span class="badge bg-secondary fs-6 p-2">
                                            <i class="fas fa-sort-numeric-down me-2"></i>
                                            Max: <span id="actualMax">0</span>
                                        </span>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <span class="badge bg-success fs-6 p-2">
                                            <i class="fas fa-calculator me-2"></i>
                                            Avg: <span id="average">0</span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <label for="resultOutput" class="form-label fw-semibold">
                                <i class="fas fa-check-circle me-2 text-success"></i>Generated Numbers
                            </label>
                            <textarea class="form-control" id="resultOutput" rows="8" readonly></textarea>
                            <div class="mt-2">
                                <button type="button" id="copyBtn" class="btn btn-outline-primary">
                                    <i class="fas fa-copy me-2"></i>Copy Numbers
                                </button>
                                <button type="button" id="downloadBtn" class="btn btn-outline-secondary ms-2">
                                    <i class="fas fa-download me-2"></i>Download as Text
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick presets --}}
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-magic me-2"></i>Quick Presets</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-2">
                            <button class="btn btn-outline-primary w-100" data-preset="dice">
                                <i class="fas fa-dice-one me-2"></i>Dice Roll (1-6)
                            </button>
                        </div>
                        <div class="col-md-3 mb-2">
                            <button class="btn btn-outline-primary w-100" data-preset="lottery">
                                <i class="fas fa-ticket-alt me-2"></i>Lottery (1-49)
                            </button>
                        </div>
                        <div class="col-md-3 mb-2">
                            <button class="btn btn-outline-primary w-100" data-preset="coin">
                                <i class="fas fa-coins me-2"></i>Coin Flip
                            </button>
                        </div>
                        <div class="col-md-3 mb-2">
                            <button class="btn btn-outline-primary w-100" data-preset="percent">
                                <i class="fas fa-percentage me-2"></i>Percentage (0-100)
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
    const minInput = document.getElementById('minInput');
    const maxInput = document.getElementById('maxInput');
    const countInput = document.getElementById('countInput');
    const formatSelect = document.getElementById('formatSelect');
    const allowDuplicates = document.getElementById('allowDuplicates');
    const sortNumbers = document.getElementById('sortNumbers');
    const resultOutput = document.getElementById('resultOutput');
    const resultSection = document.getElementById('resultSection');
    const generatedCount = document.getElementById('generatedCount');
    const actualMin = document.getElementById('actualMin');
    const actualMax = document.getElementById('actualMax');
    const average = document.getElementById('average');
    const generateBtn = document.getElementById('generateBtn');
    const clearBtn = document.getElementById('clearBtn');
    const copyBtn = document.getElementById('copyBtn');
    const downloadBtn = document.getElementById('downloadBtn');

    function generateNumbers() {
        const min = parseInt(minInput.value);
        const max = parseInt(maxInput.value);
        const count = parseInt(countInput.value);

        if (min >= max) {
            alert('Minimum value must be less than maximum value.');
            return;
        }

        if (count < 1 || count > 1000) {
            alert('Number count must be between 1 and 1000.');
            return;
        }

        if (!allowDuplicates.checked && (max - min + 1) < count) {
            alert('Cannot generate ' + count + ' unique numbers in the range ' + min + '-' + max + '.');
            return;
        }

        let numbers = [];

        if (allowDuplicates.checked) {
            // Generate with duplicates allowed
            for (let i = 0; i < count; i++) {
                numbers.push(Math.floor(Math.random() * (max - min + 1)) + min);
            }
        } else {
            // Generate unique numbers
            const available = [];
            for (let i = min; i <= max; i++) {
                available.push(i);
            }

            for (let i = 0; i < count && available.length > 0; i++) {
                const randomIndex = Math.floor(Math.random() * available.length);
                numbers.push(available.splice(randomIndex, 1)[0]);
            }
        }

        // Sort if requested
        if (sortNumbers.checked) {
            numbers.sort((a, b) => a - b);
        }

        // Format output
        let result = '';
        const format = formatSelect.value;

        switch (format) {
            case 'list':
                result = numbers.join('\n');
                break;
            case 'comma':
                result = numbers.join(', ');
                break;
            case 'space':
                result = numbers.join(' ');
                break;
            case 'array':
                result = '[' + numbers.join(', ') + ']';
                break;
        }

        resultOutput.value = result;

        // Update statistics
        generatedCount.textContent = numbers.length;
        actualMin.textContent = Math.min(...numbers);
        actualMax.textContent = Math.max(...numbers);
        average.textContent = (numbers.reduce((a, b) => a + b, 0) / numbers.length).toFixed(1);

        resultSection.style.display = 'block';
    }

    function clearResults() {
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
        a.download = 'random-numbers.txt';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }

    function applyPreset(preset) {
        switch (preset) {
            case 'dice':
                minInput.value = '1';
                maxInput.value = '6';
                countInput.value = '1';
                break;
            case 'lottery':
                minInput.value = '1';
                maxInput.value = '49';
                countInput.value = '6';
                allowDuplicates.checked = false;
                sortNumbers.checked = true;
                break;
            case 'coin':
                minInput.value = '0';
                maxInput.value = '1';
                countInput.value = '1';
                break;
            case 'percent':
                minInput.value = '0';
                maxInput.value = '100';
                countInput.value = '1';
                break;
        }
        generateNumbers();
    }

    generateBtn.addEventListener('click', generateNumbers);
    clearBtn.addEventListener('click', clearResults);
    copyBtn.addEventListener('click', copyResult);
    downloadBtn.addEventListener('click', downloadResult);

    // Preset buttons
    document.querySelectorAll('[data-preset]').forEach(btn => {
        btn.addEventListener('click', function() {
            applyPreset(this.getAttribute('data-preset'));
        });
    });

    // Auto-generate on input change
    [minInput, maxInput, countInput, formatSelect, allowDuplicates, sortNumbers].forEach(element => {
        element.addEventListener('change', function() {
            if (minInput.value && maxInput.value && countInput.value) {
                generateNumbers();
            }
        });
    });

    // Generate initial numbers
    generateNumbers();
});
</script>
