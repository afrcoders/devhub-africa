{{-- Tag Generator --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Tag Generator for creating SEO-friendly tags, hashtags, and keywords.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-tags me-3"></i>Tag Generator
                </h1>
                <p class="lead text-muted">
                    Generate relevant tags and keywords for your content
                </p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-magic me-2"></i>Content Tag Generator</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label for="contentInput" class="form-label fw-semibold">
                            <i class="fas fa-file-text me-2"></i>Your Content
                        </label>
                        <textarea class="form-control" id="contentInput" rows="6"
                            placeholder="Enter your article, blog post, or content here..."></textarea>
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Paste your content and we'll analyze it to suggest relevant tags
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="categorySelect" class="form-label fw-semibold">
                                <i class="fas fa-folder me-2"></i>Content Category
                            </label>
                            <select class="form-select" id="categorySelect">
                                <option value="general">General</option>
                                <option value="technology">Technology</option>
                                <option value="business">Business</option>
                                <option value="health">Health & Wellness</option>
                                <option value="education">Education</option>
                                <option value="entertainment">Entertainment</option>
                                <option value="travel">Travel</option>
                                <option value="food">Food & Cooking</option>
                                <option value="fashion">Fashion & Style</option>
                                <option value="sports">Sports</option>
                                <option value="finance">Finance</option>
                                <option value="diy">DIY & Crafts</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tagCount" class="form-label fw-semibold">
                                <i class="fas fa-list-ol me-2"></i>Number of Tags
                            </label>
                            <input type="number" class="form-control" id="tagCount" value="10" min="5" max="50">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-cogs me-2"></i>Tag Types
                        </label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeKeywords" checked>
                                    <label class="form-check-label" for="includeKeywords">
                                        Keywords
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeHashtags" checked>
                                    <label class="form-check-label" for="includeHashtags">
                                        Hashtags (#)
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeLongTail">
                                    <label class="form-check-label" for="includeLongTail">
                                        Long-tail keywords
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeRelated">
                                    <label class="form-check-label" for="includeRelated">
                                        Related terms
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="removeDuplicates" checked>
                                    <label class="form-check-label" for="removeDuplicates">
                                        Remove duplicates
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="sortAlphabetically">
                                    <label class="form-check-label" for="sortAlphabetically">
                                        Sort alphabetically
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mb-4">
                        <button type="button" id="generateBtn" class="btn btn-primary btn-lg">
                            <i class="fas fa-magic me-2"></i>Generate Tags
                        </button>
                        <button type="button" id="clearBtn" class="btn btn-outline-secondary btn-lg ms-3">
                            <i class="fas fa-trash-alt me-2"></i>Clear All
                        </button>
                    </div>

                    <div id="resultSection" style="display: none;">
                        <div class="border-top pt-4">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <span class="badge bg-primary fs-6 p-2">
                                            <i class="fas fa-tags me-2"></i>
                                            <span id="tagCountResult">0</span> Tags Generated
                                        </span>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <span class="badge bg-info fs-6 p-2">
                                            <i class="fas fa-eye me-2"></i>
                                            <span id="readabilityScore">-</span> Readability
                                        </span>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <span class="badge bg-success fs-6 p-2">
                                            <i class="fas fa-chart-line me-2"></i>
                                            SEO Ready
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="tagsOutput" class="form-label fw-semibold">
                                        <i class="fas fa-tags me-2 text-success"></i>Generated Tags
                                    </label>
                                    <textarea class="form-control" id="tagsOutput" rows="8" readonly></textarea>
                                    <div class="mt-2">
                                        <button type="button" id="copyTagsBtn" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-copy me-2"></i>Copy Tags
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="hashtagsOutput" class="form-label fw-semibold">
                                        <i class="fas fa-hashtag me-2 text-info"></i>Generated Hashtags
                                    </label>
                                    <textarea class="form-control" id="hashtagsOutput" rows="8" readonly></textarea>
                                    <div class="mt-2">
                                        <button type="button" id="copyHashtagsBtn" class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-copy me-2"></i>Copy Hashtags
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <button type="button" id="downloadBtn" class="btn btn-outline-secondary">
                                    <i class="fas fa-download me-2"></i>Download All Tags
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Category tags suggestions --}}
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Popular Tags by Category</h5>
                </div>
                <div class="card-body">
                    <div id="categoryTags" class="row">
                        <div class="col-12">
                            <p class="text-muted">Select a category above to see popular tags for that topic.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contentInput = document.getElementById('contentInput');
    const categorySelect = document.getElementById('categorySelect');
    const tagCount = document.getElementById('tagCount');
    const includeKeywords = document.getElementById('includeKeywords');
    const includeHashtags = document.getElementById('includeHashtags');
    const includeLongTail = document.getElementById('includeLongTail');
    const includeRelated = document.getElementById('includeRelated');
    const removeDuplicates = document.getElementById('removeDuplicates');
    const sortAlphabetically = document.getElementById('sortAlphabetically');
    const resultSection = document.getElementById('resultSection');
    const tagsOutput = document.getElementById('tagsOutput');
    const hashtagsOutput = document.getElementById('hashtagsOutput');
    const tagCountResult = document.getElementById('tagCountResult');
    const readabilityScore = document.getElementById('readabilityScore');
    const categoryTags = document.getElementById('categoryTags');
    const generateBtn = document.getElementById('generateBtn');
    const clearBtn = document.getElementById('clearBtn');
    const copyTagsBtn = document.getElementById('copyTagsBtn');
    const copyHashtagsBtn = document.getElementById('copyHashtagsBtn');
    const downloadBtn = document.getElementById('downloadBtn');

    const categoryTagsData = {
        technology: ['tech', 'innovation', 'digital', 'software', 'programming', 'AI', 'machine learning', 'cloud computing', 'cybersecurity', 'mobile app'],
        business: ['entrepreneur', 'startup', 'marketing', 'strategy', 'leadership', 'productivity', 'growth', 'success', 'management', 'networking'],
        health: ['wellness', 'fitness', 'nutrition', 'mental health', 'exercise', 'healthy living', 'diet', 'healthcare', 'meditation', 'self care'],
        education: ['learning', 'online courses', 'skill development', 'training', 'knowledge', 'study tips', 'education technology', 'career', 'academic', 'teaching'],
        entertainment: ['movies', 'music', 'gaming', 'celebrity', 'pop culture', 'streaming', 'TV shows', 'entertainment news', 'comedy', 'viral'],
        travel: ['adventure', 'vacation', 'destination', 'travel tips', 'backpacking', 'culture', 'explore', 'wanderlust', 'tourism', 'journey'],
        food: ['recipe', 'cooking', 'foodie', 'restaurant', 'cuisine', 'healthy eating', 'baking', 'chef', 'ingredients', 'delicious'],
        fashion: ['style', 'fashion trends', 'outfit', 'designer', 'beauty', 'accessories', 'streetwear', 'luxury', 'seasonal fashion', 'wardrobe'],
        sports: ['fitness', 'athlete', 'competition', 'training', 'team', 'championship', 'exercise', 'sports news', 'performance', 'motivation'],
        finance: ['investment', 'saving', 'budget', 'money management', 'financial planning', 'cryptocurrency', 'stock market', 'personal finance', 'wealth', 'economics'],
        diy: ['crafts', 'handmade', 'DIY projects', 'creative', 'upcycling', 'home improvement', 'tutorial', 'maker', 'artisan', 'craft supplies']
    };

    const commonWords = ['the', 'and', 'for', 'are', 'but', 'not', 'you', 'all', 'can', 'had', 'her', 'was', 'one', 'our', 'out', 'day', 'get', 'has', 'him', 'his', 'how', 'man', 'new', 'now', 'old', 'see', 'two', 'way', 'who', 'boy', 'did', 'its', 'let', 'put', 'say', 'she', 'too', 'use'];

    function extractKeywords(text, count) {
        // Simple keyword extraction
        const words = text.toLowerCase()
            .replace(/[^a-zA-Z0-9\s]/g, '')
            .split(/\s+/)
            .filter(word => word.length > 3 && !commonWords.includes(word));

        // Count word frequency
        const frequency = {};
        words.forEach(word => {
            frequency[word] = (frequency[word] || 0) + 1;
        });

        // Sort by frequency and return top words
        return Object.entries(frequency)
            .sort(([,a], [,b]) => b - a)
            .slice(0, count)
            .map(([word]) => word);
    }

    function generateLongTailKeywords(keywords) {
        const combinations = [];
        const category = categorySelect.value;
        const categoryWords = categoryTagsData[category] || ['how to', 'best', 'guide', 'tips'];

        keywords.slice(0, 5).forEach(keyword => {
            combinations.push(`how to ${keyword}`);
            combinations.push(`best ${keyword}`);
            combinations.push(`${keyword} guide`);
            combinations.push(`${keyword} tips`);
            if (categoryWords.length > 0) {
                combinations.push(`${keyword} ${categoryWords[0]}`);
            }
        });

        return combinations.slice(0, 8);
    }

    function generateRelatedTerms(keywords) {
        const related = [];
        const category = categorySelect.value;
        const categoryWords = categoryTagsData[category] || [];

        // Add category-specific terms
        related.push(...categoryWords.slice(0, 6));

        // Add some generic related terms
        keywords.slice(0, 3).forEach(keyword => {
            related.push(`${keyword} trends`);
            related.push(`${keyword} news`);
        });

        return related;
    }

    function calculateReadability(text) {
        const sentences = text.split(/[.!?]+/).filter(s => s.trim().length > 0).length;
        const words = text.split(/\s+/).filter(w => w.trim().length > 0).length;
        const avgWordsPerSentence = words / sentences;

        if (avgWordsPerSentence < 15) return 'Easy';
        if (avgWordsPerSentence < 20) return 'Medium';
        return 'Hard';
    }

    function generateTags() {
        const content = contentInput.value.trim();
        if (!content) {
            alert('Please enter some content to analyze.');
            return;
        }

        const count = parseInt(tagCount.value) || 10;
        let allTags = [];

        // Extract keywords from content
        if (includeKeywords.checked) {
            const keywords = extractKeywords(content, Math.floor(count * 0.4));
            allTags.push(...keywords);
        }

        // Add long-tail keywords
        if (includeLongTail.checked) {
            const keywords = extractKeywords(content, 5);
            const longTail = generateLongTailKeywords(keywords);
            allTags.push(...longTail.slice(0, Math.floor(count * 0.3)));
        }

        // Add related terms
        if (includeRelated.checked) {
            const keywords = extractKeywords(content, 3);
            const related = generateRelatedTerms(keywords);
            allTags.push(...related.slice(0, Math.floor(count * 0.3)));
        }

        // Add category-specific tags
        const category = categorySelect.value;
        if (category !== 'general' && categoryTagsData[category]) {
            allTags.push(...categoryTagsData[category].slice(0, 5));
        }

        // Remove duplicates if requested
        if (removeDuplicates.checked) {
            allTags = [...new Set(allTags)];
        }

        // Limit to requested count
        allTags = allTags.slice(0, count);

        // Sort if requested
        if (sortAlphabetically.checked) {
            allTags.sort();
        }

        // Generate output
        const tags = allTags;
        const hashtags = allTags.map(tag => `#${tag.replace(/\s+/g, '')}`);

        tagsOutput.value = tags.join(', ');
        hashtagsOutput.value = includeHashtags.checked ? hashtags.join(' ') : 'Enable hashtags option to generate hashtags';
        tagCountResult.textContent = tags.length;
        readabilityScore.textContent = calculateReadability(content);

        resultSection.style.display = 'block';
    }

    function updateCategoryTags() {
        const category = categorySelect.value;
        if (category === 'general' || !categoryTagsData[category]) {
            categoryTags.innerHTML = '<div class="col-12"><p class="text-muted">Select a specific category to see popular tags.</p></div>';
            return;
        }

        const tags = categoryTagsData[category];
        const tagButtons = tags.map(tag =>
            `<span class="badge bg-light text-dark me-2 mb-2 p-2 tag-suggestion" style="cursor: pointer;">${tag}</span>`
        ).join('');

        categoryTags.innerHTML = `
            <div class="col-12">
                <p class="text-muted mb-2">Click on any tag to add it to your content:</p>
                ${tagButtons}
            </div>
        `;

        // Add click handlers for tag suggestions
        document.querySelectorAll('.tag-suggestion').forEach(span => {
            span.addEventListener('click', function() {
                const tag = this.textContent;
                const currentContent = contentInput.value;
                contentInput.value = currentContent + (currentContent ? ' ' : '') + tag;
            });
        });
    }

    function clearAll() {
        contentInput.value = '';
        tagsOutput.value = '';
        hashtagsOutput.value = '';
        resultSection.style.display = 'none';
    }

    function copyText(text, button) {
        navigator.clipboard.writeText(text).then(() => {
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
            button.classList.add('btn-success');
            button.classList.remove('btn-outline-primary', 'btn-outline-info');

            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('btn-success');
                button.classList.add(button.id.includes('Hashtags') ? 'btn-outline-info' : 'btn-outline-primary');
            }, 2000);
        });
    }

    function downloadTags() {
        const tags = tagsOutput.value;
        const hashtags = hashtagsOutput.value;

        if (!tags) {
            alert('No tags generated to download.');
            return;
        }

        const content = `Generated Tags\n=============\n\n${tags}\n\nGenerated Hashtags\n=================\n\n${hashtags}`;

        const blob = new Blob([content], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'generated-tags.txt';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }

    // Event listeners
    generateBtn.addEventListener('click', generateTags);
    clearBtn.addEventListener('click', clearAll);
    categorySelect.addEventListener('change', updateCategoryTags);
    copyTagsBtn.addEventListener('click', () => copyText(tagsOutput.value, copyTagsBtn));
    copyHashtagsBtn.addEventListener('click', () => copyText(hashtagsOutput.value, copyHashtagsBtn));
    downloadBtn.addEventListener('click', downloadTags);

    // Auto-generate when content changes
    contentInput.addEventListener('input', function() {
        if (contentInput.value.trim().length > 50) {
            generateTags();
        }
    });

    // Re-generate when options change
    [tagCount, includeKeywords, includeHashtags, includeLongTail, includeRelated, removeDuplicates, sortAlphabetically].forEach(element => {
        element.addEventListener('change', function() {
            if (contentInput.value.trim()) {
                generateTags();
            }
        });
    });

    // Initialize
    updateCategoryTags();
});
</script>
