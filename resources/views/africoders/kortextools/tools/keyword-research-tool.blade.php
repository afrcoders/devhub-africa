<div class="row">
    <div class="col-md-12">
        <div class="mb-4">
            <label for="keyword-input" class="form-label">Enter Seed Keyword:</label>
            <input
                type="text"
                class="form-control form-control-lg"
                id="keyword-input"
                placeholder="e.g., digital marketing, web design, SEO..."
                maxlength="100"
            >
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <label for="country-select" class="form-label">Target Country:</label>
                <select class="form-select" id="country-select">
                    <option value="US">United States</option>
                    <option value="GB">United Kingdom</option>
                    <option value="CA">Canada</option>
                    <option value="AU">Australia</option>
                    <option value="DE">Germany</option>
                    <option value="FR">France</option>
                    <option value="ES">Spain</option>
                    <option value="IT">Italy</option>
                    <option value="BR">Brazil</option>
                    <option value="IN">India</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="language-select" class="form-label">Language:</label>
                <select class="form-select" id="language-select">
                    <option value="en">English</option>
                    <option value="es">Spanish</option>
                    <option value="fr">French</option>
                    <option value="de">German</option>
                    <option value="it">Italian</option>
                    <option value="pt">Portuguese</option>
                    <option value="nl">Dutch</option>
                    <option value="sv">Swedish</option>
                </select>
            </div>
        </div>

        <div class="mb-4">
            <button type="button" class="btn btn-primary btn-lg" id="research-btn">
                <i class="fas fa-search me-2"></i>Research Keywords
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
                    <i class="fas fa-chart-bar me-2"></i>Keyword Research Results
                </h5>
            </div>
            <div class="card-body">
                <div id="keyword-results">
                    <!-- Results will be populated here -->
                </div>

                <!-- Export Options -->
                <div class="mt-4">
                    <h6>Export Results:</h6>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary" id="export-csv">
                            <i class="fas fa-file-csv me-2"></i>CSV
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="export-txt">
                            <i class="fas fa-file-alt me-2"></i>TXT
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="copy-results">
                            <i class="fas fa-copy me-2"></i>Copy
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Indicator -->
<div id="loading" class="text-center" style="display: none;">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Researching keywords...</span>
    </div>
    <p class="mt-2">Analyzing keyword data...</p>
</div>

<!-- Info Alert -->
<div class="alert alert-info mt-4">
    <h6 class="alert-heading">
        <i class="fas fa-info-circle me-2"></i>About Keyword Research
    </h6>
    <p class="mb-0">
        This tool generates keyword suggestions and ideas based on your seed keyword.
        It provides valuable insights for SEO, content marketing, and PPC campaigns.
    </p>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const keywordInput = document.getElementById('keyword-input');
    const researchBtn = document.getElementById('research-btn');
    const clearBtn = document.getElementById('clear-btn');
    const resultsSection = document.getElementById('results-section');
    const keywordResults = document.getElementById('keyword-results');
    const loading = document.getElementById('loading');

    let currentResults = [];

    // Sample keyword suggestions (in production, this would connect to a keyword API)
    const keywordSuggestions = {
        'digital marketing': [
            { keyword: 'digital marketing strategy', volume: 12100, difficulty: 'Medium', cpc: '$2.15' },
            { keyword: 'digital marketing course', volume: 8100, difficulty: 'High', cpc: '$3.45' },
            { keyword: 'digital marketing agency', volume: 6600, difficulty: 'High', cpc: '$4.20' },
            { keyword: 'digital marketing tools', volume: 5400, difficulty: 'Medium', cpc: '$2.80' },
            { keyword: 'digital marketing jobs', volume: 4400, difficulty: 'Low', cpc: '$1.95' },
            { keyword: 'social media marketing', volume: 18100, difficulty: 'High', cpc: '$2.65' },
            { keyword: 'email marketing', volume: 14800, difficulty: 'Medium', cpc: '$2.10' },
            { keyword: 'content marketing', volume: 12100, difficulty: 'Medium', cpc: '$1.85' },
            { keyword: 'digital advertising', volume: 3600, difficulty: 'Medium', cpc: '$3.15' },
            { keyword: 'online marketing', volume: 9900, difficulty: 'Medium', cpc: '$2.35' }
        ],
        'web design': [
            { keyword: 'responsive web design', volume: 8100, difficulty: 'Medium', cpc: '$2.45' },
            { keyword: 'web design company', volume: 6600, difficulty: 'High', cpc: '$4.85' },
            { keyword: 'web design templates', volume: 5400, difficulty: 'Low', cpc: '$1.25' },
            { keyword: 'web design trends', volume: 2900, difficulty: 'Medium', cpc: '$1.95' },
            { keyword: 'web design portfolio', volume: 2400, difficulty: 'Low', cpc: '$1.15' },
            { keyword: 'ui ux design', volume: 12100, difficulty: 'Medium', cpc: '$2.85' },
            { keyword: 'website design', volume: 22200, difficulty: 'High', cpc: '$3.15' },
            { keyword: 'web development', volume: 27100, difficulty: 'High', cpc: '$2.95' },
            { keyword: 'graphic design', volume: 18100, difficulty: 'Medium', cpc: '$1.75' },
            { keyword: 'logo design', volume: 14800, difficulty: 'Medium', cpc: '$2.25' }
        ],
        'seo': [
            { keyword: 'seo optimization', volume: 14800, difficulty: 'High', cpc: '$3.25' },
            { keyword: 'seo tools', volume: 12100, difficulty: 'Medium', cpc: '$4.15' },
            { keyword: 'seo services', volume: 9900, difficulty: 'High', cpc: '$5.85' },
            { keyword: 'local seo', volume: 8100, difficulty: 'Medium', cpc: '$4.45' },
            { keyword: 'seo audit', volume: 6600, difficulty: 'Medium', cpc: '$3.95' },
            { keyword: 'on page seo', volume: 5400, difficulty: 'Medium', cpc: '$2.85' },
            { keyword: 'seo strategy', volume: 4400, difficulty: 'Medium', cpc: '$3.15' },
            { keyword: 'technical seo', volume: 3600, difficulty: 'Medium', cpc: '$2.95' },
            { keyword: 'seo copywriting', volume: 2900, difficulty: 'Low', cpc: '$2.15' },
            { keyword: 'keyword research', volume: 18100, difficulty: 'Medium', cpc: '$2.65' }
        ]
    };

    function generateKeywords(seedKeyword) {
        // Get suggestions or generate generic ones
        let suggestions = keywordSuggestions[seedKeyword.toLowerCase()];

        if (!suggestions) {
            // Generate generic suggestions
            const variations = [
                seedKeyword + ' tools',
                seedKeyword + ' tips',
                seedKeyword + ' guide',
                seedKeyword + ' tutorial',
                seedKeyword + ' course',
                'best ' + seedKeyword,
                seedKeyword + ' software',
                seedKeyword + ' services',
                seedKeyword + ' strategy',
                seedKeyword + ' examples'
            ];

            suggestions = variations.map((keyword, index) => ({
                keyword: keyword,
                volume: Math.floor(Math.random() * 10000) + 1000,
                difficulty: ['Low', 'Medium', 'High'][Math.floor(Math.random() * 3)],
                cpc: '$' + (Math.random() * 5 + 0.5).toFixed(2)
            }));
        }

        return suggestions;
    }

    function displayResults(keywords, seedKeyword) {
        const html = `
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Keyword</th>
                            <th>Search Volume</th>
                            <th>Difficulty</th>
                            <th>Est. CPC</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${keywords.map(item => `
                            <tr>
                                <td><strong>${item.keyword}</strong></td>
                                <td>${item.volume.toLocaleString()}/month</td>
                                <td>
                                    <span class="badge bg-${item.difficulty === 'Low' ? 'success' : item.difficulty === 'Medium' ? 'warning' : 'danger'}">
                                        ${item.difficulty}
                                    </span>
                                </td>
                                <td>${item.cpc}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Found ${keywords.length} keyword suggestions for "${seedKeyword}"
                </small>
            </div>
        `;

        keywordResults.innerHTML = html;
        resultsSection.style.display = 'block';
        currentResults = keywords;
    }

    function exportData(format) {
        if (currentResults.length === 0) {
            alert('No data to export');
            return;
        }

        let content = '';
        let filename = 'keyword-research';
        let mimeType = '';

        if (format === 'csv') {
            content = 'Keyword,Search Volume,Difficulty,CPC\\n';
            content += currentResults.map(item =>
                `"${item.keyword}","${item.volume}","${item.difficulty}","${item.cpc}"`
            ).join('\\n');
            filename += '.csv';
            mimeType = 'text/csv';
        } else if (format === 'txt') {
            content = 'Keyword Research Results\\n';
            content += '=' .repeat(30) + '\\n\\n';
            content += currentResults.map(item =>
                `Keyword: ${item.keyword}\\nVolume: ${item.volume}\\nDifficulty: ${item.difficulty}\\nCPC: ${item.cpc}\\n`
            ).join('\\n');
            filename += '.txt';
            mimeType = 'text/plain';
        }

        const blob = new Blob([content], { type: mimeType });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.style.display = 'none';
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
    }

    researchBtn.addEventListener('click', function() {
        const keyword = keywordInput.value.trim();
        if (!keyword) {
            alert('Please enter a keyword to research');
            return;
        }

        loading.style.display = 'block';
        resultsSection.style.display = 'none';

        // Simulate API delay
        setTimeout(() => {
            const keywords = generateKeywords(keyword);
            displayResults(keywords, keyword);
            loading.style.display = 'none';
        }, 1500);
    });

    clearBtn.addEventListener('click', function() {
        keywordInput.value = '';
        resultsSection.style.display = 'none';
        currentResults = [];
        keywordInput.focus();
    });

    document.getElementById('export-csv').addEventListener('click', () => exportData('csv'));
    document.getElementById('export-txt').addEventListener('click', () => exportData('txt'));

    document.getElementById('copy-results').addEventListener('click', function() {
        if (currentResults.length === 0) {
            alert('No data to copy');
            return;
        }

        const text = currentResults.map(item =>
            `${item.keyword} (${item.volume} searches, ${item.difficulty} difficulty, ${item.cpc} CPC)`
        ).join('\\n');

        navigator.clipboard.writeText(text).then(() => {
            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
            btn.classList.remove('btn-outline-primary');
            btn.classList.add('btn-success');
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.classList.remove('btn-success');
                btn.classList.add('btn-outline-primary');
            }, 2000);
        });
    });

    // Enter key support
    keywordInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            researchBtn.click();
        }
    });
});
</script>
