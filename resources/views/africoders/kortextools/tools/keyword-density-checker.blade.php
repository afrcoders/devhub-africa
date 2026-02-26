<div class="row">
    <div class="col-md-12">
        <div class="mb-4">
            <label for="website-url" class="form-label">Website URL to Analyze:</label>
            <input
                type="url"
                class="form-control form-control-lg"
                id="website-url"
                placeholder="https://example.com/page-to-analyze"
                required
            >
        </div>

        <div class="mb-4">
            <label for="target-keyword" class="form-label">Target Keyword:</label>
            <input
                type="text"
                class="form-control"
                id="target-keyword"
                placeholder="Enter the keyword you want to check density for"
                maxlength="100"
            >
        </div>

        <div class="mb-4">
            <button type="button" class="btn btn-primary btn-lg" id="analyze-btn">
                <i class="fas fa-search me-2"></i>Analyze Keyword Density
            </button>
            <button type="button" class="btn btn-outline-secondary ms-2" id="clear-btn">
                <i class="fas fa-broom me-2"></i>Clear
            </button>
        </div>
    </div>
</div>

<div class="row" id="results-section" style="display: none;">
    <div class="col-12">
        <!-- Main Results -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-pie me-2"></i>Keyword Density Analysis
                </h5>
            </div>
            <div class="card-body">
                <div id="density-summary" class="row mb-4">
                    <!-- Summary will be populated here -->
                </div>

                <div id="keyword-breakdown">
                    <!-- Detailed breakdown will be populated here -->
                </div>
            </div>
        </div>

        <!-- Top Keywords -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-list-ol me-2"></i>Top Keywords Found
                </h5>
            </div>
            <div class="card-body">
                <div id="top-keywords">
                    <!-- Top keywords table will be populated here -->
                </div>

                <!-- Export Options -->
                <div class="mt-4">
                    <h6>Export Results:</h6>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary" id="export-csv">
                            <i class="fas fa-file-csv me-2"></i>CSV
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
        <span class="visually-hidden">Analyzing content...</span>
    </div>
    <p class="mt-2">Fetching and analyzing webpage content...</p>
</div>

<!-- Error Alert -->
<div id="error-alert" class="alert alert-danger" style="display: none;">
    <h6 class="alert-heading">
        <i class="fas fa-exclamation-triangle me-2"></i>Analysis Error
    </h6>
    <p id="error-message" class="mb-0"></p>
</div>

<!-- Info Alert -->
<div class="alert alert-info mt-4">
    <h6 class="alert-heading">
        <i class="fas fa-info-circle me-2"></i>About Keyword Density
    </h6>
    <p class="mb-2">
        Keyword density is the percentage of times a target keyword appears in your content compared to the total word count.
        Ideal keyword density is typically:
    </p>
    <ul class="mb-0">
        <li><strong>1-3%</strong> - Optimal range for SEO</li>
        <li><strong>0.5-1%</strong> - Safe minimum</li>
        <li><strong>Above 4%</strong> - May be considered keyword stuffing</li>
    </ul>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const websiteUrl = document.getElementById('website-url');
    const targetKeyword = document.getElementById('target-keyword');
    const analyzeBtn = document.getElementById('analyze-btn');
    const clearBtn = document.getElementById('clear-btn');
    const resultsSection = document.getElementById('results-section');
    const densitySummary = document.getElementById('density-summary');
    const keywordBreakdown = document.getElementById('keyword-breakdown');
    const topKeywords = document.getElementById('top-keywords');
    const loading = document.getElementById('loading');
    const errorAlert = document.getElementById('error-alert');
    const errorMessage = document.getElementById('error-message');

    let currentResults = null;

    function simulateWebsiteAnalysis(url, keyword) {
        // Simulate content analysis (in production, this would use a proxy/API to fetch content)
        const sampleContent = `
            Lorem ipsum dolor sit amet, consectetur ${keyword} elit. ${keyword} is important for SEO.
            Digital marketing and ${keyword} strategies help businesses grow. The ${keyword} analysis shows
            promising results. Understanding ${keyword} trends is crucial. ${keyword} optimization requires
            careful planning. Content marketing and ${keyword} implementation work together. ${keyword} research
            provides valuable insights. Modern ${keyword} techniques are evolving rapidly. ${keyword} best
            practices should be followed consistently. The future of ${keyword} looks bright.
        `;

        const words = sampleContent.toLowerCase().split(/\\s+/);
        const totalWords = words.length;

        // Count keyword occurrences
        const keywordLower = keyword.toLowerCase();
        const keywordCount = words.filter(word =>
            word.replace(/[^a-z0-9]/g, '') === keywordLower.replace(/[^a-z0-9]/g, '')
        ).length;

        // Calculate density
        const density = ((keywordCount / totalWords) * 100).toFixed(2);

        // Generate top keywords
        const wordCounts = {};
        const stopWords = ['the', 'is', 'at', 'which', 'on', 'and', 'or', 'but', 'in', 'with', 'a', 'an', 'as', 'are', 'was', 'were', 'been', 'be', 'for', 'of', 'to', 'from'];

        words.forEach(word => {
            const cleanWord = word.replace(/[^a-z0-9]/g, '');
            if (cleanWord.length > 2 && !stopWords.includes(cleanWord)) {
                wordCounts[cleanWord] = (wordCounts[cleanWord] || 0) + 1;
            }
        });

        const topKeywordsList = Object.entries(wordCounts)
            .sort(([,a], [,b]) => b - a)
            .slice(0, 15)
            .map(([word, count]) => ({
                keyword: word,
                count: count,
                density: ((count / totalWords) * 100).toFixed(2)
            }));

        return {
            url: url,
            targetKeyword: keyword,
            keywordCount: keywordCount,
            totalWords: totalWords,
            density: parseFloat(density),
            topKeywords: topKeywordsList
        };
    }

    function displayResults(results) {
        // Summary Cards
        const summaryHtml = `
            <div class="col-md-3">
                <div class="text-center p-3 bg-primary text-white rounded">
                    <h3 class="mb-1">${results.density}%</h3>
                    <small>Keyword Density</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center p-3 bg-info text-white rounded">
                    <h3 class="mb-1">${results.keywordCount}</h3>
                    <small>Keyword Count</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center p-3 bg-success text-white rounded">
                    <h3 class="mb-1">${results.totalWords}</h3>
                    <small>Total Words</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center p-3 ${getDensityClass(results.density)} text-white rounded">
                    <h3 class="mb-1">${getDensityStatus(results.density)}</h3>
                    <small>SEO Status</small>
                </div>
            </div>
        `;

        densitySummary.innerHTML = summaryHtml;

        // Keyword Breakdown
        const breakdownHtml = `
            <h6>Target Keyword Analysis:</h6>
            <div class="progress mb-3" style="height: 30px;">
                <div class="progress-bar" role="progressbar"
                     style="width: ${Math.min(results.density * 10, 100)}%"
                     aria-valuenow="${results.density}" aria-valuemin="0" aria-valuemax="10">
                    ${results.targetKeyword}: ${results.density}%
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <strong>Recommendations:</strong>
                    <ul class="list-unstyled mt-2">
                        ${getDensityRecommendations(results.density).map(rec => `<li><i class="fas fa-${rec.icon} text-${rec.color} me-2"></i>${rec.text}</li>`).join('')}
                    </ul>
                </div>
                <div class="col-md-6">
                    <strong>Analysis Details:</strong>
                    <ul class="list-unstyled mt-2">
                        <li><i class="fas fa-link text-primary me-2"></i>URL: <small>${results.url}</small></li>
                        <li><i class="fas fa-key text-info me-2"></i>Target: "${results.targetKeyword}"</li>
                        <li><i class="fas fa-hashtag text-success me-2"></i>Occurrences: ${results.keywordCount}</li>
                    </ul>
                </div>
            </div>
        `;

        keywordBreakdown.innerHTML = breakdownHtml;

        // Top Keywords Table
        const topKeywordsHtml = `
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Keyword</th>
                            <th>Count</th>
                            <th>Density %</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${results.topKeywords.map((item, index) => `
                            <tr>
                                <td><strong>${index + 1}</strong></td>
                                <td>${item.keyword}</td>
                                <td>${item.count}</td>
                                <td>
                                    <span class="badge bg-${parseFloat(item.density) > 3 ? 'warning' : 'primary'}">
                                        ${item.density}%
                                    </span>
                                </td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
        `;

        topKeywords.innerHTML = topKeywordsHtml;
        resultsSection.style.display = 'block';
        currentResults = results;
    }

    function getDensityClass(density) {
        if (density < 0.5) return 'bg-secondary';
        if (density <= 3) return 'bg-success';
        if (density <= 4) return 'bg-warning';
        return 'bg-danger';
    }

    function getDensityStatus(density) {
        if (density < 0.5) return 'Too Low';
        if (density <= 3) return 'Optimal';
        if (density <= 4) return 'High';
        return 'Too High';
    }

    function getDensityRecommendations(density) {
        if (density < 0.5) {
            return [
                { icon: 'plus-circle', color: 'success', text: 'Increase keyword usage naturally' },
                { icon: 'edit', color: 'info', text: 'Add keyword to headings and meta descriptions' }
            ];
        } else if (density <= 3) {
            return [
                { icon: 'check-circle', color: 'success', text: 'Keyword density is optimal' },
                { icon: 'thumbs-up', color: 'success', text: 'Good balance for SEO' }
            ];
        } else if (density <= 4) {
            return [
                { icon: 'exclamation-triangle', color: 'warning', text: 'Consider reducing keyword usage' },
                { icon: 'balance-scale', color: 'warning', text: 'Focus on natural content flow' }
            ];
        } else {
            return [
                { icon: 'times-circle', color: 'danger', text: 'Reduce keyword usage immediately' },
                { icon: 'shield-alt', color: 'danger', text: 'Risk of keyword stuffing penalty' }
            ];
        }
    }

    function exportData(format) {
        if (!currentResults) {
            alert('No data to export');
            return;
        }

        let content = '';
        let filename = 'keyword-density-analysis';

        if (format === 'csv') {
            content = 'Analysis Summary\\n';
            content += `URL,${currentResults.url}\\n`;
            content += `Target Keyword,${currentResults.targetKeyword}\\n`;
            content += `Keyword Count,${currentResults.keywordCount}\\n`;
            content += `Total Words,${currentResults.totalWords}\\n`;
            content += `Density %,${currentResults.density}\\n\\n`;
            content += 'Top Keywords\\n';
            content += 'Rank,Keyword,Count,Density %\\n';
            content += currentResults.topKeywords.map((item, index) =>
                `${index + 1},"${item.keyword}","${item.count}","${item.density}%"`
            ).join('\\n');
            filename += '.csv';
        }

        const blob = new Blob([content], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    }

    analyzeBtn.addEventListener('click', function() {
        const url = websiteUrl.value.trim();
        const keyword = targetKeyword.value.trim();

        if (!url) {
            alert('Please enter a website URL to analyze');
            return;
        }

        if (!keyword) {
            alert('Please enter a target keyword');
            return;
        }

        // Basic URL validation
        try {
            new URL(url);
        } catch (e) {
            alert('Please enter a valid URL');
            return;
        }

        loading.style.display = 'block';
        resultsSection.style.display = 'none';
        errorAlert.style.display = 'none';

        // Simulate API delay
        setTimeout(() => {
            try {
                const results = simulateWebsiteAnalysis(url, keyword);
                displayResults(results);
                loading.style.display = 'none';
            } catch (error) {
                loading.style.display = 'none';
                errorAlert.style.display = 'block';
                errorMessage.textContent = 'Unable to analyze the website. Please check the URL and try again.';
            }
        }, 2000);
    });

    clearBtn.addEventListener('click', function() {
        websiteUrl.value = '';
        targetKeyword.value = '';
        resultsSection.style.display = 'none';
        errorAlert.style.display = 'none';
        currentResults = null;
        websiteUrl.focus();
    });

    document.getElementById('export-csv').addEventListener('click', () => exportData('csv'));

    document.getElementById('copy-results').addEventListener('click', function() {
        if (!currentResults) {
            alert('No data to copy');
            return;
        }

        const text = `Keyword Density Analysis\\n` +
                    `URL: ${currentResults.url}\\n` +
                    `Target Keyword: ${currentResults.targetKeyword}\\n` +
                    `Density: ${currentResults.density}%\\n` +
                    `Count: ${currentResults.keywordCount}\\n` +
                    `Total Words: ${currentResults.totalWords}`;

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
    websiteUrl.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            targetKeyword.focus();
        }
    });

    targetKeyword.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            analyzeBtn.click();
        }
    });
});
</script>
