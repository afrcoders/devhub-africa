<div class="row">
    <div class="col-md-12">
        <div class="row mb-4">
            <div class="col-md-6">
                <label for="lorem-type" class="form-label">Generate Type:</label>
                <select class="form-select" id="lorem-type">
                    <option value="words">Words</option>
                    <option value="sentences">Sentences</option>
                    <option value="paragraphs" selected>Paragraphs</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="lorem-count" class="form-label">How many?</label>
                <input type="number" class="form-control" id="lorem-count" value="3" min="1" max="100">
            </div>
        </div>

        <div class="mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="start-with-lorem">
                <label class="form-check-label" for="start-with-lorem">
                    Start with "Lorem ipsum dolor sit amet..."
                </label>
            </div>
        </div>

        <div class="mb-3">
            <button type="button" class="btn btn-primary" onclick="generateLoremIpsum()">
                <i class="bi bi-text-paragraph"></i> Generate Lorem Ipsum
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="clearLorem()">
                <i class="bi bi-x-circle"></i> Clear
            </button>
        </div>

        <!-- Output -->
        <div id="lorem-output" style="display: none;">
            <label for="lorem-result" class="form-label">Generated Text:</label>
            <div class="output-box">
                <textarea id="lorem-result" class="form-control" rows="12" readonly></textarea>
                <div class="d-flex justify-content-between mt-2">
                    <small class="text-muted" id="lorem-stats"></small>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="copyToClipboard('lorem-result')">
                        <i class="bi bi-clipboard"></i> Copy
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Information -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> About Lorem Ipsum</h6>
    <p class="mb-0">
        Lorem ipsum is placeholder text commonly used in the printing and typesetting industry.
        It's derived from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" by Cicero, written in 45 BC.
    </p>
</div>

<style>
.output-box {
    position: relative;
}
.output-box .form-control {
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
    line-height: 1.4;
}
</style>

<script>
const loremWords = [
    'lorem', 'ipsum', 'dolor', 'sit', 'amet', 'consectetur', 'adipiscing', 'elit',
    'sed', 'do', 'eiusmod', 'tempor', 'incididunt', 'ut', 'labore', 'et', 'dolore',
    'magna', 'aliqua', 'enim', 'ad', 'minim', 'veniam', 'quis', 'nostrud',
    'exercitation', 'ullamco', 'laboris', 'nisi', 'aliquip', 'ex', 'ea', 'commodo',
    'consequat', 'duis', 'aute', 'irure', 'in', 'reprehenderit', 'voluptate',
    'velit', 'esse', 'cillum', 'fugiat', 'nulla', 'pariatur', 'excepteur', 'sint',
    'occaecat', 'cupidatat', 'non', 'proident', 'sunt', 'culpa', 'qui', 'officia',
    'deserunt', 'mollit', 'anim', 'id', 'est', 'laborum', 'at', 'vero', 'eos',
    'accusamus', 'iusto', 'odio', 'dignissimos', 'ducimus', 'blanditiis',
    'praesentium', 'voluptatum', 'deleniti', 'atque', 'corrupti', 'quos',
    'dolores', 'quas', 'molestias', 'excepturi', 'similique', 'neque', 'porro',
    'quisquam', 'minus', 'quod', 'maxime', 'placeat', 'facere', 'possimus',
    'omnis', 'assumenda', 'repellendus', 'temporibus', 'autem', 'quibusdam',
    'officiis', 'debitis', 'rerum', 'necessitatibus', 'saepe', 'eveniet',
    'voluptates', 'repudiandae', 'recusandae', 'itaque', 'earum', 'hic',
    'tenetur', 'sapiente', 'delectus', 'impedit', 'quo', 'minus', 'id'
];

const loremStart = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';

function generateLoremIpsum() {
    const type = document.getElementById('lorem-type').value;
    const count = parseInt(document.getElementById('lorem-count').value);
    const startWithLorem = document.getElementById('start-with-lorem').checked;

    if (count < 1 || count > 100) {
        alert('Please enter a number between 1 and 100.');
        return;
    }

    let result = '';

    if (type === 'words') {
        result = generateWords(count, startWithLorem);
    } else if (type === 'sentences') {
        result = generateSentences(count, startWithLorem);
    } else if (type === 'paragraphs') {
        result = generateParagraphs(count, startWithLorem);
    }

    document.getElementById('lorem-result').value = result;
    document.getElementById('lorem-output').style.display = 'block';

    // Update stats
    updateStats(result);
}

function generateWords(count, startWithLorem) {
    let words = [];

    if (startWithLorem && count > 10) {
        words = loremStart.split(' ').slice(0, Math.min(count, 11));
        count -= words.length;
    }

    for (let i = 0; i < count; i++) {
        words.push(loremWords[Math.floor(Math.random() * loremWords.length)]);
    }

    return words.join(' ').charAt(0).toUpperCase() + words.join(' ').slice(1);
}

function generateSentences(count, startWithLorem) {
    let sentences = [];

    if (startWithLorem) {
        sentences.push(loremStart);
        count--;
    }

    for (let i = 0; i < count; i++) {
        const sentenceLength = Math.floor(Math.random() * 15) + 8; // 8-22 words
        let sentence = [];

        for (let j = 0; j < sentenceLength; j++) {
            sentence.push(loremWords[Math.floor(Math.random() * loremWords.length)]);
        }

        let sentenceText = sentence.join(' ');
        sentenceText = sentenceText.charAt(0).toUpperCase() + sentenceText.slice(1) + '.';
        sentences.push(sentenceText);
    }

    return sentences.join(' ');
}

function generateParagraphs(count, startWithLorem) {
    let paragraphs = [];

    if (startWithLorem) {
        paragraphs.push(loremStart + ' ' + generateSentences(Math.floor(Math.random() * 4) + 2, false));
        count--;
    }

    for (let i = 0; i < count; i++) {
        const sentenceCount = Math.floor(Math.random() * 6) + 3; // 3-8 sentences
        paragraphs.push(generateSentences(sentenceCount, false));
    }

    return paragraphs.join('\\n\\n');
}

function clearLorem() {
    document.getElementById('lorem-result').value = '';
    document.getElementById('lorem-output').style.display = 'none';
}

function updateStats(text) {
    const words = text.split(/\\s+/).filter(word => word.length > 0).length;
    const characters = text.length;
    const charactersNoSpaces = text.replace(/\\s/g, '').length;
    const sentences = text.split(/[.!?]+/).filter(s => s.trim().length > 0).length;
    const paragraphs = text.split('\\n\\n').filter(p => p.trim().length > 0).length;

    document.getElementById('lorem-stats').textContent =
        `${words} words, ${characters} characters (${charactersNoSpaces} without spaces), ${sentences} sentences, ${paragraphs} paragraphs`;
}

function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    if (element.value) {
        navigator.clipboard.writeText(element.value).then(function() {
            // Show success feedback
            const button = event.target;
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
</script>
<script>
function copyToClipboard(id) { const el = document.getElementById(id); navigator.clipboard.writeText(el.textContent); }
document.getElementById('loremForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(this));
    const response = await fetch('{{ route("tools.kortex.tool.submit", "lorem-ipsum-generator") }}', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('[name="_token"]').value}, body:JSON.stringify({tool:'lorem-ipsum-generator',...data})});
    const result = await response.json();
    if(result.success) {document.getElementById('resultText').textContent = result.text; document.getElementById('result').style.display='block';}
});
</script>

