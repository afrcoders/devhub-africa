{{-- English Converter Tool --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-language me-2"></i>
    Convert text to different English formats and styles.
</div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-exchange-alt me-2"></i>
                        {{ $tool->name }}
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">{{ $tool->description }}</p>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="inputText" class="form-label">Input Text</label>
                                <textarea class="form-control" id="inputText" rows="4"
                                    placeholder="Enter text to convert..."></textarea>
                                <div class="form-text">Enter text in any format to convert to proper English</div>
                            </div>

                            <div class="mb-3">
                                <label for="conversionType" class="form-label">Conversion Type</label>
                                <select class="form-select" id="conversionType">
                                    <option value="proper">Proper Case</option>
                                    <option value="sentence">Sentence Case</option>
                                    <option value="title">Title Case</option>
                                    <option value="camel">camelCase</option>
                                    <option value="snake">snake_case</option>
                                    <option value="kebab">kebab-case</option>
                                    <option value="upper">UPPER CASE</option>
                                    <option value="lower">lower case</option>
                                    <option value="random">RaNdOm CaSe</option>
                                </select>
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button type="button" class="btn btn-primary" id="convertBtn">
                                    <i class="fas fa-exchange-alt me-2"></i>Convert Text
                                </button>
                            </div>

                            <div class="mb-3">
                                <label for="outputText" class="form-label">Converted Text</label>
                                <textarea class="form-control" id="outputText" rows="4" readonly
                                    placeholder="Converted text will appear here..."></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-secondary w-100" id="copyBtn">
                                        <i class="fas fa-copy me-2"></i>Copy to Clipboard
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-success w-100" id="downloadBtn">
                                        <i class="fas fa-download me-2"></i>Download as TXT
                                    </button>
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
const inputText = document.getElementById('inputText');
const outputText = document.getElementById('outputText');
const conversionType = document.getElementById('conversionType');
const convertBtn = document.getElementById('convertBtn');
const copyBtn = document.getElementById('copyBtn');
const downloadBtn = document.getElementById('downloadBtn');

// Convert text based on selected type
function convertText(text, type) {
    switch(type) {
        case 'proper':
            return text.split(' ').map(word =>
                word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
            ).join(' ');

        case 'sentence':
            return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();

        case 'title':
            return text.split(' ').map(word => {
                // Don't capitalize small words unless they're the first or last word
                const smallWords = ['a', 'an', 'and', 'as', 'at', 'but', 'by', 'for', 'if', 'in', 'nor', 'of', 'on', 'or', 'so', 'the', 'to', 'up', 'yet'];
                return smallWords.includes(word.toLowerCase()) ? word.toLowerCase() :
                       word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
            }).join(' ');

        case 'camel':
            return text.replace(/(?:^\w|[A-Z]|\b\w)/g, (word, index) => {
                return index === 0 ? word.toLowerCase() : word.toUpperCase();
            }).replace(/\s+/g, '');

        case 'snake':
            return text.toLowerCase().replace(/\s+/g, '_');

        case 'kebab':
            return text.toLowerCase().replace(/\s+/g, '-');

        case 'upper':
            return text.toUpperCase();

        case 'lower':
            return text.toLowerCase();

        case 'random':
            return text.split('').map(char =>
                Math.random() > 0.5 ? char.toUpperCase() : char.toLowerCase()
            ).join('');

        default:
            return text;
    }
}

// Convert button click
convertBtn.addEventListener('click', function() {
    const text = inputText.value.trim();
    const type = conversionType.value;

    if (!text) {
        alert('Please enter some text to convert.');
        return;
    }

    const converted = convertText(text, type);
    outputText.value = converted;
});

// Auto-convert on input change
inputText.addEventListener('input', function() {
    if (this.value.trim()) {
        convertBtn.click();
    }
});

conversionType.addEventListener('change', function() {
    if (inputText.value.trim()) {
        convertBtn.click();
    }
});

// Copy to clipboard
copyBtn.addEventListener('click', function() {
    if (!outputText.value) {
        alert('Nothing to copy. Please convert some text first.');
        return;
    }

    outputText.select();
    navigator.clipboard.writeText(outputText.value).then(function() {
        const originalText = copyBtn.innerHTML;
        copyBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
        setTimeout(function() {
            copyBtn.innerHTML = originalText;
        }, 2000);
    });
});

// Download as text file
downloadBtn.addEventListener('click', function() {
    if (!outputText.value) {
        alert('Nothing to download. Please convert some text first.');
        return;
    }

    const blob = new Blob([outputText.value], { type: 'text/plain' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'english-converted-text.txt';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
});
</script>
