{{-- Slugify Tool --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-link me-2"></i>
    Convert text to URL-friendly slugs with customizable options.
</div>>
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-link fa-3x text-primary"></i>
                </div>
                <h1 class="h2 mb-3">URL Slug Generator</h1>
                <p class="lead text-muted">
                    Convert any text into clean, SEO-friendly URL slugs for your web projects
                </p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="slugify-form">
                        @csrf
                        <div class="mb-4">
                            <label for="text" class="form-label">
                                <i class="fas fa-font me-2"></i>Text to Slugify
                            </label>
                            <textarea
                                class="form-control form-control-lg"
                                id="text"
                                name="text"
                                rows="4"
                                placeholder="Enter your text here..."
                                required
                            ></textarea>
                            <small class="form-text text-muted">
                                Enter any text and we'll convert it to a clean URL slug
                            </small>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="separator" class="form-label">Separator</label>
                                <select class="form-select" id="separator" name="separator">
                                    <option value="-">Hyphen (-)</option>
                                    <option value="_">Underscore (_)</option>
                                    <option value=".">Dot (.)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="case" class="form-label">Case</label>
                                <select class="form-select" id="case" name="case">
                                    <option value="lower">Lowercase</option>
                                    <option value="upper">Uppercase</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-magic me-2"></i>Generate Slug
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Loading State -->
            <div id="loading" class="text-center mt-4" style="display: none;">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <div class="spinner-border text-primary me-3" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span class="text-muted">Generating slug...</span>
                    </div>
                </div>
            </div>

            <!-- Results -->
            <div id="results" class="mt-4" style="display: none;">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-check-circle me-2"></i>Generated Slug
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="results-content"></div>
                    </div>
                </div>
            </div>

            <!-- Info Section -->
            <div class="alert alert-info mt-4">
                <h6 class="alert-heading">
                    <i class="fas fa-info-circle me-2"></i>About URL Slugs
                </h6>
                <p class="mb-2">
                    URL slugs are clean, readable text used in URLs:
                </p>
                <ul class="mb-2">
                    <li><strong>SEO-friendly</strong> - Improves search engine rankings</li>
                    <li><strong>User-friendly</strong> - Easy to read and remember</li>
                    <li><strong>Safe characters</strong> - Uses only URL-safe characters</li>
                    <li><strong>No spaces</strong> - Spaces replaced with separators</li>
                    <li><strong>Lowercase</strong> - Typically converted to lowercase</li>
                </ul>
                <p class="mb-0">
                    <small><strong>Best for:</strong> Blog posts, product pages, file names, and any URL that needs to be readable.</small>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('slugify-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const text = document.getElementById('text').value.trim();
    const separator = document.getElementById('separator').value;
    const textCase = document.getElementById('case').value;

    if (!text) {
        alert('Please enter some text');
        return;
    }

    // Show loading
    document.getElementById('loading').style.display = 'block';
    document.getElementById('results').style.display = 'none';

    const formData = new FormData();
    formData.append('text', text);
    formData.append('separator', separator);
    formData.append('case', textCase);
    formData.append('_token', document.querySelector('[name="_token"]').value);

    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "slugify") }}', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        // Hide loading
        document.getElementById('loading').style.display = 'none';

        if (result.success) {
            displayResults(result);
        } else {
            displayError(result.error || 'An error occurred');
        }
    } catch (error) {
        document.getElementById('loading').style.display = 'none';
        displayError('Network error: ' + error.message);
    }
});

function displayResults(result) {
    const originalText = result.original_text;
    const slug = result.slug;

    const html = `
        <div class="mb-4">
            <label class="form-label fw-bold">Original Text:</label>
            <div class="p-3 bg-light rounded border">
                <span class="text-muted">${originalText}</span>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-bold">Generated Slug:</label>
            <div class="input-group">
                <input type="text" class="form-control form-control-lg" value="${slug}" id="slug-result" readonly>
                <button class="btn btn-outline-primary" type="button" onclick="copyToClipboard('${slug}')">
                    <i class="fas fa-copy me-2"></i>Copy
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="alert alert-success">
                    <h6><i class="fas fa-lightbulb me-2"></i>Usage Examples</h6>
                    <ul class="mb-0">
                        <li><strong>Blog URL:</strong> /blog/${slug}</li>
                        <li><strong>Product URL:</strong> /products/${slug}</li>
                        <li><strong>File name:</strong> ${slug}.html</li>
                    </ul>
                </div>
            </div>
        </div>
    `;

    document.getElementById('results-content').innerHTML = html;
    document.getElementById('results').style.display = 'block';
}

function displayError(error) {
    const html = `
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Error:</strong> ${error}
        </div>
    `;

    document.getElementById('results-content').innerHTML = html;
    document.getElementById('results').style.display = 'block';
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show temporary success message
        const btn = event.target.closest('button');
        const originalContent = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
        btn.classList.remove('btn-outline-primary');
        btn.classList.add('btn-success');

        setTimeout(function() {
            btn.innerHTML = originalContent;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-primary');
        }, 2000);
    });
}
</script>
