<form id="character-counter-form" class="needs-validation">
    <!-- Text Input -->
    <div class="mb-3">
        <label for="text-input" class="form-label">
            <i class="bi bi-type me-2"></i>Enter Text
        </label>
        <textarea
            class="form-control"
            id="text-input"
            rows="8"
            placeholder="Enter text to count characters, words, lines, and paragraphs..."
        ></textarea>
    </div>

    <!-- Stats Grid -->
    <div class="row g-2">
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <h6 class="text-muted mb-2">Characters</h6>
                <h4 id="char-count">0</h4>
                <small class="text-muted" id="char-count-no-spaces">0 (no spaces)</small>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <h6 class="text-muted mb-2">Words</h6>
                <h4 id="word-count">0</h4>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <h6 class="text-muted mb-2">Sentences</h6>
                <h4 id="sentence-count">0</h4>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <h6 class="text-muted mb-2">Paragraphs</h6>
                <h4 id="paragraph-count">0</h4>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <h6 class="text-muted mb-2">Lines</h6>
                <h4 id="line-count">0</h4>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <h6 class="text-muted mb-2">Reading Time</h6>
                <h4 id="reading-time">0s</h4>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <h6 class="text-muted mb-2">Avg Word Length</h6>
                <h4 id="avg-word-length">0</h4>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <h6 class="text-muted mb-2">Density</h6>
                <h4 id="density">0%</h4>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
        <button
            type="reset"
            class="btn btn-secondary"
            onclick="resetStats()"
        >
            <i class="bi bi-arrow-clockwise me-2"></i>Clear
        </button>
    </div>
</form>

<script>
const textInput = document.getElementById('text-input');

textInput.addEventListener('input', updateStats);
textInput.addEventListener('change', updateStats);

function updateStats() {
    const text = textInput.value;

    // Character count
    const charCount = text.length;
    const charCountNoSpaces = text.replace(/\s/g, '').length;

    // Word count
    const words = text.trim().split(/\s+/).filter(w => w.length > 0);
    const wordCount = text.trim() === '' ? 0 : words.length;

    // Sentence count (. ! ?)
    const sentences = text.split(/[.!?]+/).filter(s => s.trim().length > 0);
    const sentenceCount = text.trim() === '' ? 0 : sentences.length;

    // Paragraph count (separated by double newlines)
    const paragraphs = text.split(/\n\n+/).filter(p => p.trim().length > 0);
    const paragraphCount = text.trim() === '' ? 0 : paragraphs.length;

    // Line count
    const lines = text.split('\n').filter(l => l.trim().length > 0);
    const lineCount = text.trim() === '' ? 0 : lines.length;

    // Average word length
    const avgWordLength = wordCount > 0
        ? (charCountNoSpaces / wordCount).toFixed(2)
        : 0;

    // Reading time (average 200 words per minute)
    const readingTime = Math.max(1, Math.ceil(wordCount / 200));

    // Unique word density (unique words / total words)
    const uniqueWords = new Set(words.map(w => w.toLowerCase())).size;
    const density = wordCount > 0
        ? Math.round((uniqueWords / wordCount) * 100)
        : 0;

    // Update UI
    document.getElementById('char-count').textContent = charCount.toLocaleString();
    document.getElementById('char-count-no-spaces').textContent =
        charCountNoSpaces.toLocaleString() + ' (no spaces)';
    document.getElementById('word-count').textContent = wordCount.toLocaleString();
    document.getElementById('sentence-count').textContent = sentenceCount;
    document.getElementById('paragraph-count').textContent = paragraphCount;
    document.getElementById('line-count').textContent = lineCount;
    document.getElementById('reading-time').textContent = readingTime + 's';
    document.getElementById('avg-word-length').textContent = avgWordLength;
    document.getElementById('density').textContent = density + '%';
}

function resetStats() {
    document.getElementById('text-input').value = '';
    updateStats();
}

// Initialize on page load
updateStats();
</script>

<style>
.stat-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.5rem;
    border-radius: 0.5rem;
    text-align: center;
    box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
    transition: transform 0.2s, box-shadow 0.2s;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.stat-card h4 {
    font-size: 1.75rem;
    font-weight: bold;
    margin: 0.5rem 0 0;
}

.stat-card h6 {
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.8);
}

.stat-card small {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.75rem;
}
</style>
