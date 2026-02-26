<div class="row">
    <div class="col-md-12">
        <div class="mb-4">
            <label for="text-input" class="form-label">Enter or paste your text:</label>
            <textarea
                class="form-control"
                id="text-input"
                rows="8"
                placeholder="Type or paste your text here to get detailed statistics..."
                oninput="updateStats()"
            ></textarea>
        </div>

        <!-- Real-time Stats -->
        <div class="row mb-4">
            <div class="col-md-3 col-6">
                <div class="card bg-primary text-white text-center">
                    <div class="card-body py-3">
                        <h5 class="card-title mb-1" id="char-count">0</h5>
                        <p class="card-text small mb-0">Characters</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card bg-success text-white text-center">
                    <div class="card-body py-3">
                        <h5 class="card-title mb-1" id="char-no-spaces-count">0</h5>
                        <p class="card-text small mb-0">Characters (no spaces)</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card bg-info text-white text-center">
                    <div class="card-body py-3">
                        <h5 class="card-title mb-1" id="word-count">0</h5>
                        <p class="card-text small mb-0">Words</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card bg-warning text-white text-center">
                    <div class="card-body py-3">
                        <h5 class="card-title mb-1" id="sentence-count">0</h5>
                        <p class="card-text small mb-0">Sentences</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Stats -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="card-title">Paragraphs</h6>
                        <h4 class="text-secondary mb-0" id="paragraph-count">0</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="card-title">Lines</h6>
                        <h4 class="text-secondary mb-0" id="line-count">0</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="card-title">Average Words/Sentence</h6>
                        <h4 class="text-secondary mb-0" id="avg-words-sentence">0</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reading Time & Additional Stats -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="bi bi-clock"></i> Reading Time</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <h5 class="mb-1" id="reading-time-slow">0:00</h5>
                                    <small class="text-muted">Slow (150 WPM)</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h5 class="mb-1" id="reading-time-avg">0:00</h5>
                                <small class="text-muted">Average (250 WPM)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="bi bi-graph-up"></i> Text Analysis</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <h5 class="mb-1" id="avg-chars-word">0</h5>
                                    <small class="text-muted">Avg chars/word</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h5 class="mb-1" id="longest-word">-</h5>
                                <small class="text-muted">Longest word</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="mb-3">
            <button type="button" class="btn btn-outline-secondary" onclick="clearText()">
                <i class="bi bi-x-circle"></i> Clear
            </button>
            <button type="button" class="btn btn-outline-primary" onclick="copyStats()">
                <i class="bi bi-clipboard"></i> Copy Stats
            </button>
            <button type="button" class="btn btn-outline-info" onclick="loadSample()">
                <i class="bi bi-file-text"></i> Load Sample Text
            </button>
        </div>
    </div>
</div>

<!-- Information -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> About Text Statistics</h6>
    <p class="mb-0">
        This tool provides comprehensive text analysis including word count, character count, reading time estimates, and more.
        Reading time is calculated based on average reading speeds: slow readers (~150 WPM) and average readers (~250 WPM).
    </p>
</div>

<style>
.card .card-title {
    font-size: 1.5rem;
    font-weight: bold;
}
</style>

<script>
function updateStats() {
    const text = document.getElementById('text-input').value;

    // Basic counts
    const charCount = text.length;
    const charNoSpacesCount = text.replace(/\s/g, '').length;
    const words = text.trim() === '' ? [] : text.trim().split(/\s+/);
    const wordCount = words.length === 1 && words[0] === '' ? 0 : words.length;

    // Sentences (split by .!? followed by space or end of string)
    const sentences = text.trim() === '' ? [] : text.split(/[.!?]+/).filter(s => s.trim().length > 0);
    const sentenceCount = sentences.length;

    // Paragraphs (split by double newlines or more)
    const paragraphs = text.trim() === '' ? [] : text.split(/\n\s*\n/).filter(p => p.trim().length > 0);
    const paragraphCount = paragraphs.length === 1 && paragraphs[0].trim() === '' ? 0 : paragraphs.length;

    // Lines
    const lines = text.split('\n');
    const lineCount = text === '' ? 0 : lines.length;

    // Average words per sentence
    const avgWordsPerSentence = sentenceCount > 0 ? Math.round(wordCount / sentenceCount * 10) / 10 : 0;

    // Average characters per word
    const avgCharsPerWord = wordCount > 0 ? Math.round(charNoSpacesCount / wordCount * 10) / 10 : 0;

    // Longest word
    const longestWord = words.length > 0 ? words.reduce((a, b) => a.length > b.length ? a : b) : '-';

    // Reading time (WPM = Words Per Minute)
    const readingTimeSlowMinutes = wordCount / 150;
    const readingTimeAvgMinutes = wordCount / 250;

    // Update display
    document.getElementById('char-count').textContent = charCount.toLocaleString();
    document.getElementById('char-no-spaces-count').textContent = charNoSpacesCount.toLocaleString();
    document.getElementById('word-count').textContent = wordCount.toLocaleString();
    document.getElementById('sentence-count').textContent = sentenceCount.toLocaleString();
    document.getElementById('paragraph-count').textContent = paragraphCount.toLocaleString();
    document.getElementById('line-count').textContent = lineCount.toLocaleString();
    document.getElementById('avg-words-sentence').textContent = avgWordsPerSentence;
    document.getElementById('avg-chars-word').textContent = avgCharsPerWord;
    document.getElementById('longest-word').textContent = longestWord.length > 15 ? longestWord.substring(0, 15) + '...' : longestWord;

    // Format reading time
    document.getElementById('reading-time-slow').textContent = formatTime(readingTimeSlowMinutes);
    document.getElementById('reading-time-avg').textContent = formatTime(readingTimeAvgMinutes);
}

function formatTime(minutes) {
    if (minutes < 1) {
        return Math.round(minutes * 60) + 's';
    }
    const mins = Math.floor(minutes);
    const secs = Math.round((minutes - mins) * 60);
    return mins + ':' + (secs < 10 ? '0' : '') + secs;
}

function clearText() {
    document.getElementById('text-input').value = '';
    updateStats();
}

function copyStats() {
    const text = document.getElementById('text-input').value;
    const charCount = text.length;
    const charNoSpacesCount = text.replace(/\s/g, '').length;
    const words = text.trim() === '' ? [] : text.trim().split(/\s+/);
    const wordCount = words.length === 1 && words[0] === '' ? 0 : words.length;
    const sentences = text.trim() === '' ? [] : text.split(/[.!?]+/).filter(s => s.trim().length > 0);
    const sentenceCount = sentences.length;

    const statsText = `Text Statistics:
Characters: ${charCount.toLocaleString()}
Characters (no spaces): ${charNoSpacesCount.toLocaleString()}
Words: ${wordCount.toLocaleString()}
Sentences: ${sentenceCount.toLocaleString()}
Reading time (avg): ${document.getElementById('reading-time-avg').textContent}`;

    navigator.clipboard.writeText(statsText).then(function() {
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

function loadSample() {
    const sampleText = `Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.

Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.`;

    document.getElementById('text-input').value = sampleText;
    updateStats();
}

// Initialize with empty stats
updateStats();
</script>
                <h6>Statistics:</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded mb-3 text-center">
                            <strong id="wordCount">0</strong><br><small class="text-muted">Words</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded mb-3 text-center">
                            <strong id="charCount">0</strong><br><small class="text-muted">Characters</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded mb-3 text-center">
                            <strong id="sentenceCount">0</strong><br><small class="text-muted">Sentences</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded mb-3 text-center">
                            <strong id="paragraphCount">0</strong><br><small class="text-muted">Paragraphs</small>
                        </div>
                    </div>
                </div>
            </div>
            <div id="error" class="alert alert-danger" style="display: none;"></div>
        </form>
    </div>
</div>

<script>
document.getElementById('counterForm').addEventListener('submit', function(e) {
    e.preventDefault();
    fetch('{{ route("tools.kortex.tool.submit", "word-counter") }}', {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value},
        body: JSON.stringify({ text: document.getElementById('text').value })
    }).then(r => r.json()).then(d => {
        if (d.success) {
            document.getElementById('wordCount').textContent = d.data.words;
            document.getElementById('charCount').textContent = d.data.characters;
            document.getElementById('sentenceCount').textContent = d.data.sentences;
            document.getElementById('paragraphCount').textContent = d.data.paragraphs;
            document.getElementById('result').style.display = 'block';
            document.getElementById('error').style.display = 'none';
        } else {
            document.getElementById('error').textContent = d.message;
            document.getElementById('error').style.display = 'block';
        }
    });
});
</script>

