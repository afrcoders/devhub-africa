<div class="row">
    <div class="col-md-12">
        <div class="mb-4">
            <label for="input-text" class="form-label">Enter text to convert:</label>
            <textarea
                class="form-control"
                id="input-text"
                rows="6"
                placeholder="Type or paste your text here..."
            ></textarea>
        </div>

        <div class="mb-4">
            <label for="case-type" class="form-label">Select conversion type:</label>
            <select class="form-select" id="case-type">
                <option value="uppercase">UPPERCASE</option>
                <option value="lowercase">lowercase</option>
                <option value="capitalize">Capitalize First Letter</option>
                <option value="title-case">Title Case</option>
                <option value="sentence-case">Sentence case</option>
                <option value="toggle-case">tOGGLE cASE</option>
                <option value="camel-case">camelCase</option>
                <option value="pascal-case">PascalCase</option>
                <option value="snake-case">snake_case</option>
                <option value="kebab-case">kebab-case</option>
                <option value="dot-case">dot.case</option>
                <option value="path-case">path/case</option>
            </select>
        </div>

        <div class="mb-3">
            <button type="button" class="btn btn-primary" onclick="convertCase()">
                <i class="bi bi-arrow-repeat"></i> Convert Case
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
            <label for="output-text" class="form-label">Converted text:</label>
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

        <!-- Quick Actions -->
        <div id="quick-actions" class="mt-3" style="display: none;">
            <h6>Quick Actions:</h6>
            <div class="btn-group-sm" role="group">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="quickConvert('uppercase')">
                    UPPER
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="quickConvert('lowercase')">
                    lower
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="quickConvert('title-case')">
                    Title
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="quickConvert('camel-case')">
                    camelCase
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Information -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> Case Conversion Types</h6>
    <ul class="mb-0 small">
        <li><strong>UPPERCASE:</strong> Converts all letters to uppercase</li>
        <li><strong>lowercase:</strong> Converts all letters to lowercase</li>
        <li><strong>Title Case:</strong> Capitalizes the first letter of each word</li>
        <li><strong>camelCase:</strong> First word lowercase, subsequent words capitalized, no spaces</li>
        <li><strong>snake_case:</strong> Lowercase words separated by underscores</li>
        <li><strong>kebab-case:</strong> Lowercase words separated by hyphens</li>
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
.btn-group-sm .btn-sm {
    margin-right: 5px;
    margin-bottom: 5px;
}
</style>

<script>
function convertCase() {
    const inputText = document.getElementById('input-text').value;
    const caseType = document.getElementById('case-type').value;

    if (!inputText.trim()) {
        alert('Please enter some text to convert.');
        return;
    }

    let convertedText = '';

    switch (caseType) {
        case 'uppercase':
            convertedText = inputText.toUpperCase();
            break;
        case 'lowercase':
            convertedText = inputText.toLowerCase();
            break;
        case 'capitalize':
            convertedText = inputText.charAt(0).toUpperCase() + inputText.slice(1).toLowerCase();
            break;
        case 'title-case':
            convertedText = inputText.replace(/\w\S*/g, (txt) =>
                txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()
            );
            break;
        case 'sentence-case':
            convertedText = inputText.toLowerCase().replace(/(^\w|\.\s*\w)/g,
                (match) => match.toUpperCase()
            );
            break;
        case 'toggle-case':
            convertedText = inputText.replace(/\w/g, (char) =>
                char === char.toUpperCase() ? char.toLowerCase() : char.toUpperCase()
            );
            break;
        case 'camel-case':
            convertedText = inputText
                .replace(/\s+(.)/g, (match, char) => char.toUpperCase())
                .replace(/\s/g, '')
                .replace(/^(.)/, (match) => match.toLowerCase());
            break;
        case 'pascal-case':
            convertedText = inputText
                .replace(/\s+(.)/g, (match, char) => char.toUpperCase())
                .replace(/\s/g, '')
                .replace(/^(.)/, (match) => match.toUpperCase());
            break;
        case 'snake-case':
            convertedText = inputText
                .toLowerCase()
                .replace(/\s+/g, '_')
                .replace(/[^\w]/g, '');
            break;
        case 'kebab-case':
            convertedText = inputText
                .toLowerCase()
                .replace(/\s+/g, '-')
                .replace(/[^\w-]/g, '');
            break;
        case 'dot-case':
            convertedText = inputText
                .toLowerCase()
                .replace(/\s+/g, '.')
                .replace(/[^\w.]/g, '');
            break;
        case 'path-case':
            convertedText = inputText
                .toLowerCase()
                .replace(/\s+/g, '/')
                .replace(/[^\w/]/g, '');
            break;
        default:
            convertedText = inputText;
    }

    document.getElementById('output-text').value = convertedText;
    document.getElementById('output-section').style.display = 'block';
    document.getElementById('quick-actions').style.display = 'block';

    // Update stats
    updateTextStats(inputText, convertedText);
}

function quickConvert(type) {
    document.getElementById('case-type').value = type;
    convertCase();
}

function clearText() {
    document.getElementById('input-text').value = '';
    document.getElementById('output-text').value = '';
    document.getElementById('output-section').style.display = 'none';
    document.getElementById('quick-actions').style.display = 'none';
}

function swapText() {
    const inputText = document.getElementById('input-text').value;
    const outputText = document.getElementById('output-text').value;

    document.getElementById('input-text').value = outputText;
    document.getElementById('output-text').value = inputText;

    updateTextStats(outputText, inputText);
}

function updateTextStats(input, output) {
    const inputLength = input.length;
    const outputLength = output.length;
    const inputWords = input.split(/\s+/).filter(word => word.length > 0).length;
    const outputWords = output.split(/\s+/).filter(word => word.length > 0).length;

    document.getElementById('text-stats').textContent =
        `Input: ${inputLength} characters, ${inputWords} words | Output: ${outputLength} characters, ${outputWords} words`;
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
        convertCase();
    }
});
</script>
<script>
function copyToClipboard(id) { const el = document.getElementById(id); navigator.clipboard.writeText(el.textContent); }
document.getElementById('caseForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(this));
    const response = await fetch('{{ route("tools.kortex.tool.submit", "case-converter") }}', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('[name="_token"]').value}, body:JSON.stringify({tool:'case-converter',...data})});
    const result = await response.json();
    if(result.success) {document.getElementById('resultValue').textContent = result.result; document.getElementById('result').style.display='block';}
});
</script>

