<div class="row">
    <div class="col-md-12">
        <div class="mb-4">
            <label for="text-input" class="form-label">Text to Paraphrase:</label>
            <textarea
                class="form-control"
                id="text-input"
                rows="6"
                placeholder="Enter the text you want to paraphrase..."
                maxlength="5000"
            ></textarea>
            <small class="form-text text-muted">Maximum 5000 characters</small>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <label for="paraphrase-mode" class="form-label">Paraphrasing Mode:</label>
                <select class="form-select" id="paraphrase-mode">
                    <option value="standard">Standard - Balanced rewriting</option>
                    <option value="fluency">Fluency - Natural flow</option>
                    <option value="formal">Formal - Professional tone</option>
                    <option value="simple">Simple - Easy to understand</option>
                    <option value="creative">Creative - More variation</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="strength-level" class="form-label">Strength Level:</label>
                <select class="form-select" id="strength-level">
                    <option value="light">Light - Minor changes</option>
                    <option value="medium" selected>Medium - Moderate changes</option>
                    <option value="strong">Strong - Significant changes</option>
                </select>
            </div>
        </div>

        <div class="mb-4">
            <button type="button" class="btn btn-primary btn-lg" id="paraphrase-btn">
                <i class="fas fa-sync-alt me-2"></i>Paraphrase Text
            </button>
            <button type="button" class="btn btn-outline-secondary ms-2" id="clear-btn">
                <i class="fas fa-broom me-2"></i>Clear
            </button>
        </div>
    </div>
</div>

<div class="row" id="results-section" style="display: none;">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-file-alt me-2"></i>Paraphrased Text
                </h5>
            </div>
            <div class="card-body">
                <div id="paraphrased-text" class="border rounded p-3 mb-3" style="min-height: 150px; background-color: #f8f9fa;">
                    <!-- Paraphrased text will appear here -->
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <small class="text-muted">
                            <span id="char-count">0</span> characters |
                            <span id="word-count">0</span> words
                        </small>
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="copy-result">
                            <i class="fas fa-copy me-1"></i>Copy Result
                        </button>
                        <button type="button" class="btn btn-outline-success btn-sm" id="paraphrase-again">
                            <i class="fas fa-redo me-1"></i>Paraphrase Again
                        </button>
                    </div>
                </div>

                <!-- Comparison -->
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted">Original Text:</h6>
                        <div id="original-preview" class="small text-muted p-2 border rounded" style="max-height: 100px; overflow-y: auto;">
                            <!-- Original text preview -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Similarity Analysis:</h6>
                        <div class="progress mb-2" style="height: 20px;">
                            <div id="similarity-bar" class="progress-bar" role="progressbar" style="width: 0%">
                                <span id="similarity-percent">0%</span>
                            </div>
                        </div>
                        <small class="text-muted">Lower similarity = better paraphrasing</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Indicator -->
<div id="loading" class="text-center" style="display: none;">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Paraphrasing text...</span>
    </div>
    <p class="mt-2">Processing your text...</p>
</div>

<!-- Info Alert -->
<div class="alert alert-info mt-4">
    <h6 class="alert-heading">
        <i class="fas fa-info-circle me-2"></i>About Text Paraphrasing
    </h6>
    <p class="mb-2">
        Paraphrasing helps you:
    </p>
    <ul class="mb-0">
        <li><strong>Avoid Plagiarism</strong> - Rewrite content while maintaining meaning</li>
        <li><strong>Improve Clarity</strong> - Make complex text easier to understand</li>
        <li><strong>Change Tone</strong> - Adjust formality and style</li>
        <li><strong>Content Creation</strong> - Generate alternative versions</li>
    </ul>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const textInput = document.getElementById('text-input');
    const paraphraseMode = document.getElementById('paraphrase-mode');
    const strengthLevel = document.getElementById('strength-level');
    const paraphraseBtn = document.getElementById('paraphrase-btn');
    const clearBtn = document.getElementById('clear-btn');
    const resultsSection = document.getElementById('results-section');
    const paraphrasedText = document.getElementById('paraphrased-text');
    const originalPreview = document.getElementById('original-preview');
    const charCount = document.getElementById('char-count');
    const wordCount = document.getElementById('word-count');
    const similarityBar = document.getElementById('similarity-bar');
    const similarityPercent = document.getElementById('similarity-percent');
    const loading = document.getElementById('loading');
    const copyResultBtn = document.getElementById('copy-result');
    const paraphraseAgainBtn = document.getElementById('paraphrase-again');

    let currentOriginalText = '';

    // Paraphrasing templates and variations
    const paraphraseTemplates = {
        standard: {
            synonyms: {
                'important': ['significant', 'crucial', 'vital', 'essential'],
                'good': ['excellent', 'great', 'beneficial', 'positive'],
                'bad': ['poor', 'negative', 'unfavorable', 'detrimental'],
                'big': ['large', 'substantial', 'considerable', 'massive'],
                'small': ['tiny', 'minimal', 'compact', 'minor'],
                'fast': ['quick', 'rapid', 'swift', 'speedy'],
                'slow': ['gradual', 'leisurely', 'unhurried', 'deliberate'],
                'help': ['assist', 'support', 'aid', 'facilitate'],
                'show': ['demonstrate', 'illustrate', 'display', 'reveal'],
                'make': ['create', 'produce', 'generate', 'develop'],
                'use': ['utilize', 'employ', 'apply', 'implement'],
                'get': ['obtain', 'acquire', 'receive', 'gain'],
                'find': ['discover', 'locate', 'identify', 'determine']
            },
            structures: [
                'Additionally,', 'Furthermore,', 'Moreover,', 'In addition,',
                'However,', 'Nevertheless,', 'On the other hand,', 'Conversely,',
                'Therefore,', 'Thus,', 'Consequently,', 'As a result,'
            ]
        }
    };

    function updateCharacterCount() {
        const text = textInput.value;
        charCount.textContent = text.length;
        wordCount.textContent = text.trim() ? text.trim().split(/\\s+/).length : 0;
    }

    function paraphraseText(text, mode, strength) {
        const words = text.split(/\\s+/);
        const synonyms = paraphraseTemplates.standard.synonyms;
        let paraphrasedWords = [...words];

        // Apply synonym replacement based on strength
        const replacementRate = {
            'light': 0.2,
            'medium': 0.4,
            'strong': 0.6
        }[strength];

        paraphrasedWords = paraphrasedWords.map(word => {
            const cleanWord = word.toLowerCase().replace(/[^a-z]/g, '');
            if (synonyms[cleanWord] && Math.random() < replacementRate) {
                const replacements = synonyms[cleanWord];
                const replacement = replacements[Math.floor(Math.random() * replacements.length)];
                // Preserve original capitalization and punctuation
                return word.replace(new RegExp(cleanWord, 'i'), replacement);
            }
            return word;
        });

        // Apply structural changes for medium and strong levels
        if (strength !== 'light') {
            // Occasionally rearrange sentence structure
            paraphrasedWords = rearrangeSentences(paraphrasedWords.join(' ')).split(/\\s+/);
        }

        return paraphrasedWords.join(' ');
    }

    function rearrangeSentences(text) {
        const sentences = text.split(/[.!?]+/).filter(s => s.trim());

        return sentences.map(sentence => {
            sentence = sentence.trim();
            if (Math.random() < 0.3) { // 30% chance to rearrange
                // Simple rearrangements
                if (sentence.includes(',')) {
                    const parts = sentence.split(',').map(p => p.trim());
                    if (parts.length === 2 && Math.random() < 0.5) {
                        return parts.reverse().join(', ');
                    }
                }

                // Add transitional phrases
                if (Math.random() < 0.3) {
                    const transitions = ['Additionally', 'Furthermore', 'Moreover', 'In fact'];
                    const transition = transitions[Math.floor(Math.random() * transitions.length)];
                    return transition + ', ' + sentence.toLowerCase();
                }
            }
            return sentence;
        }).join('. ') + '.';
    }

    function calculateSimilarity(original, paraphrased) {
        const originalWords = new Set(original.toLowerCase().match(/\\b\\w+\\b/g) || []);
        const paraphrasedWords = new Set(paraphrased.toLowerCase().match(/\\b\\w+\\b/g) || []);

        const intersection = new Set([...originalWords].filter(x => paraphrasedWords.has(x)));
        const union = new Set([...originalWords, ...paraphrasedWords]);

        return Math.round((intersection.size / union.size) * 100);
    }

    function displayResults(original, paraphrased) {
        paraphrasedText.textContent = paraphrased;
        originalPreview.textContent = original.length > 200 ? original.substring(0, 200) + '...' : original;

        // Update character and word counts
        charCount.textContent = paraphrased.length;
        wordCount.textContent = paraphrased.trim().split(/\\s+/).length;

        // Calculate and display similarity
        const similarity = calculateSimilarity(original, paraphrased);
        similarityBar.style.width = similarity + '%';
        similarityPercent.textContent = similarity + '%';

        // Color code the similarity bar
        if (similarity < 30) {
            similarityBar.className = 'progress-bar bg-success';
        } else if (similarity < 60) {
            similarityBar.className = 'progress-bar bg-warning';
        } else {
            similarityBar.className = 'progress-bar bg-danger';
        }

        resultsSection.style.display = 'block';
    }

    paraphraseBtn.addEventListener('click', function() {
        const text = textInput.value.trim();

        if (!text) {
            alert('Please enter some text to paraphrase');
            return;
        }

        if (text.length < 10) {
            alert('Please enter at least 10 characters');
            return;
        }

        currentOriginalText = text;
        loading.style.display = 'block';
        resultsSection.style.display = 'none';

        // Simulate processing delay
        setTimeout(() => {
            const mode = paraphraseMode.value;
            const strength = strengthLevel.value;
            const paraphrased = paraphraseText(text, mode, strength);

            displayResults(text, paraphrased);
            loading.style.display = 'none';
        }, 1500);
    });

    paraphraseAgainBtn.addEventListener('click', function() {
        if (currentOriginalText) {
            loading.style.display = 'block';
            resultsSection.style.display = 'none';

            setTimeout(() => {
                const mode = paraphraseMode.value;
                const strength = strengthLevel.value;
                const paraphrased = paraphraseText(currentOriginalText, mode, strength);

                displayResults(currentOriginalText, paraphrased);
                loading.style.display = 'none';
            }, 1000);
        }
    });

    copyResultBtn.addEventListener('click', function() {
        const result = paraphrasedText.textContent;
        if (result) {
            navigator.clipboard.writeText(result).then(() => {
                const btn = this;
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check me-1"></i>Copied!';
                btn.classList.remove('btn-outline-primary');
                btn.classList.add('btn-success');
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-outline-primary');
                }, 2000);
            });
        }
    });

    clearBtn.addEventListener('click', function() {
        textInput.value = '';
        resultsSection.style.display = 'none';
        currentOriginalText = '';
        updateCharacterCount();
        textInput.focus();
    });

    // Real-time character count
    textInput.addEventListener('input', updateCharacterCount);

    // Initialize character count
    updateCharacterCount();
});
</script>
