<div class="row">
    <div class="col-md-12">
        <div class="mb-4">
            <label for="input-text" class="form-label">Enter text to reverse:</label>
            <textarea
                class="form-control"
                id="input-text"
                rows="6"
                placeholder="Type or paste your text here..."
            ></textarea>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <label for="reverse-type" class="form-label">Reverse Type:</label>
                <select class="form-select" id="reverse-type">
                    <option value="characters">Reverse Characters</option>
                    <option value="words">Reverse Word Order</option>
                    <option value="lines">Reverse Line Order</option>
                    <option value="sentences">Reverse Sentence Order</option>
                </select>
            </div>
            <div class="col-md-6">
                <div class="mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="preserve-case">
                        <label class="form-check-label" for="preserve-case">
                            Preserve original case
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="preserve-spaces" checked>
                        <label class="form-check-label" for="preserve-spaces">
                            Preserve spacing
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <button type="button" class="btn btn-primary" onclick="reverseText()">
                <i class="bi bi-arrow-left-right"></i> Reverse Text
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="clearText()">
                <i class="bi bi-x-circle"></i> Clear
            </button>
            <button type="button" class="btn btn-outline-info" onclick="swapText()">
                <i class="bi bi-arrow-up-down"></i> Swap Input/Output
            </button>
        </div>

        <!-- Output -->
        <div id="output-section" style="display: none;">
            <label for="output-text" class="form-label">Reversed text:</label>
            <div class="output-box">
                <textarea id="output-text" class="form-control" rows="6" readonly></textarea>
                <div class="d-flex justify-content-between mt-2">
                    <small class="text-muted" id="text-stats"></small>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="copyToClipboard('output-text')">
                        <i class="bi bi-clipboard"></i> Copy
                    </button>
                </div>
            </div>
        </div>

        <!-- Quick Examples -->
        <div id="examples" class="mt-4">
            <h6>Try these examples:</h6>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('Hello World!')">
                    "Hello World!"
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('The quick brown fox jumps over the lazy dog')">
                    Sample sentence
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('Line 1\\nLine 2\\nLine 3')">
                    Multi-line text
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Information -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> Reverse Text Types</h6>
    <ul class="mb-0 small">
        <li><strong>Reverse Characters:</strong> Reverses the entire text character by character</li>
        <li><strong>Reverse Word Order:</strong> Reverses the order of words while keeping each word intact</li>
        <li><strong>Reverse Line Order:</strong> Reverses the order of lines in multi-line text</li>
        <li><strong>Reverse Sentence Order:</strong> Reverses the order of sentences</li>
    </ul>
</div>

<style>
.output-box {
    position: relative;
}
.output-box .form-control {
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
}
</style>

<script>
function reverseText() {
    const inputText = document.getElementById('input-text').value;
    const reverseType = document.getElementById('reverse-type').value;
    const preserveCase = document.getElementById('preserve-case').checked;
    const preserveSpaces = document.getElementById('preserve-spaces').checked;

    if (!inputText.trim()) {
        alert('Please enter some text to reverse.');
        return;
    }

    let reversedText = '';

    switch (reverseType) {
        case 'characters':
            reversedText = inputText.split('').reverse().join('');
            break;

        case 'words':
            const words = inputText.split(/(\s+)/);
            const wordOnly = words.filter((_, index) => index % 2 === 0);
            const spaces = words.filter((_, index) => index % 2 === 1);

            if (preserveSpaces && spaces.length > 0) {
                const reversedWords = wordOnly.reverse();
                reversedText = '';
                for (let i = 0; i < Math.max(reversedWords.length, spaces.length); i++) {
                    if (i < reversedWords.length) reversedText += reversedWords[i];
                    if (i < spaces.length) reversedText += spaces[i];
                }
            } else {
                reversedText = inputText.split(/\s+/).reverse().join(' ');
            }
            break;

        case 'lines':
            reversedText = inputText.split('\n').reverse().join('\n');
            break;

        case 'sentences':
            // Split by sentence endings, preserve punctuation
            const sentences = inputText.split(/([.!?]+\s*)/);
            const sentenceText = sentences.filter((_, index) => index % 2 === 0);
            const punctuation = sentences.filter((_, index) => index % 2 === 1);

            if (preserveSpaces && punctuation.length > 0) {
                const reversedSentences = sentenceText.reverse();
                reversedText = '';
                for (let i = 0; i < Math.max(reversedSentences.length, punctuation.length); i++) {
                    if (i < reversedSentences.length) reversedText += reversedSentences[i];
                    if (i < punctuation.length) reversedText += punctuation[punctuation.length - 1 - i];
                }
            } else {
                reversedText = inputText.split(/[.!?]+/).reverse().join('. ').replace(/\s+/g, ' ');
            }
            break;

        default:
            reversedText = inputText.split('').reverse().join('');
    }

    // Apply case preservation if needed
    if (!preserveCase && reverseType === 'characters') {
        // For character reversal, we might want to maintain some logic
        // but this is generally not applicable for other reverse types
    }

    document.getElementById('output-text').value = reversedText;
    document.getElementById('output-section').style.display = 'block';

    // Update stats
    updateTextStats(inputText, reversedText);
}

function clearText() {
    document.getElementById('input-text').value = '';
    document.getElementById('output-text').value = '';
    document.getElementById('output-section').style.display = 'none';
}

function swapText() {
    const inputText = document.getElementById('input-text').value;
    const outputText = document.getElementById('output-text').value;

    document.getElementById('input-text').value = outputText;
    document.getElementById('output-text').value = inputText;

    if (outputText) {
        updateTextStats(outputText, inputText);
    }
}

function useExample(example) {
    // Replace \\n with actual newlines for examples
    const text = example.replace(/\\n/g, '\n');
    document.getElementById('input-text').value = text;
    reverseText();
}

function updateTextStats(input, output) {
    const inputLength = input.length;
    const outputLength = output.length;
    const inputWords = input.split(/\s+/).filter(word => word.length > 0).length;
    const outputWords = output.split(/\s+/).filter(word => word.length > 0).length;
    const inputLines = input.split('\n').length;
    const outputLines = output.split('\n').length;

    document.getElementById('text-stats').textContent =
        `Input: ${inputLength} chars, ${inputWords} words, ${inputLines} lines | Output: ${outputLength} chars, ${outputWords} words, ${outputLines} lines`;
}

function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    if (element.value) {
        navigator.clipboard.writeText(element.value).then(function() {
            // Show success feedback
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="bi bi-check"></i> Copied!';
            button.classList.remove('btn-outline-primary');
            button.classList.add('btn-success');

            setTimeout(function() {
                button.innerHTML = originalText;
                button.classList.remove('btn-success');
                button.classList.add('btn-outline-primary');
            }, 2000);
        });
    }
}

// Handle Enter key
document.getElementById('input-text').addEventListener('keypress', function(e) {
    if (e.key === 'Enter' && e.ctrlKey) {
        reverseText();
    }
});
</script>
