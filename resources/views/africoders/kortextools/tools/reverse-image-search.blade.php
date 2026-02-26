{{-- Reverse Image Search --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Search for images using other images.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-image me-3"></i>Reverse Image Search
                </h1>
                <p class="lead text-muted">
                    Search the web for similar images
                </p>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-upload me-2"></i>Image Input</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="imageUrl" class="form-label fw-semibold">Image URL:</label>
                                <input type="url" class="form-control" id="imageUrl" placeholder="https://example.com/image.jpg">
                            </div>

                            <div class="mb-3">
                                <label for="imageFile" class="form-label fw-semibold">Or Upload Image:</label>
                                <input type="file" class="form-control" id="imageFile" accept="image/*">
                            </div>

                            <div id="imagePreview" class="mb-3" style="display: none;">
                                <img id="preview" style="max-width: 100%; max-height: 200px; border-radius: 8px;">
                            </div>

                            <button type="button" id="searchBtn" class="btn btn-primary w-100">
                                <i class="fas fa-search me-2"></i>Search Image
                            </button>

                            <hr class="my-4">

                            <div class="alert alert-warning">
                                <strong><i class="fas fa-info-circle me-2"></i>Note:</strong>
                                This tool helps you find where images are used online or find similar images.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Search Engines</h5>
                        </div>
                        <div class="card-body" id="results" style="max-height: 600px; overflow-y: auto;">
                            <p class="text-muted text-center">Enter image URL or upload an image</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Uses for Reverse Image Search</h5>
                        </div>
                        <div class="card-body">
                            <ul class="mb-0">
                                <li><strong>Find the source:</strong> Discover where an image originated</li>
                                <li><strong>Verify authenticity:</strong> Check if an image has been edited or used elsewhere</li>
                                <li><strong>Find high-res versions:</strong> Locate better quality versions of an image</li>
                                <li><strong>Identify people/places:</strong> Find information about subjects in images</li>
                                <li><strong>Detect plagiarism:</strong> Find if your images are used without permission</li>
                                <li><strong>Find similar images:</strong> Discover related or similar photos</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageUrl = document.getElementById('imageUrl');
    const imageFile = document.getElementById('imageFile');
    const imagePreview = document.getElementById('imagePreview');
    const preview = document.getElementById('preview');
    const searchBtn = document.getElementById('searchBtn');
    const results = document.getElementById('results');

    const searchEngines = {
        'Google': 'https://www.google.com/searchbyimage?image_url=',
        'Bing': 'https://www.bing.com/images/search?view=detailv2&iss=sbiupload&q=imgurl:',
        'TinEye': 'https://www.tineye.com/search?url=',
        'Yandex': 'https://yandex.com/images/search?url=',
        'Pinterest': 'https://www.pinterest.com/search/pins/?q=',
        'Baidu': 'https://image.baidu.com/search/index?'
    };

    imageFile.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                imagePreview.style.display = 'block';
                imageUrl.value = '';
            };
            reader.readAsDataURL(file);
        }
    });

    searchBtn.addEventListener('click', function() {
        let urlToSearch = imageUrl.value.trim();

        if (!urlToSearch && imageFile.files.length === 0) {
            alert('Please enter an image URL or upload an image');
            return;
        }

        if (imageFile.files.length > 0) {
            // For uploaded files, we show the search options
            displaySearchResults(null, true);
        } else {
            try {
                new URL(urlToSearch);
                displaySearchResults(urlToSearch, false);
            } catch (e) {
                alert('Invalid URL format');
            }
        }
    });

    function displaySearchResults(url, isUpload) {
        let html = `
            <div class="mb-3">
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-search me-2"></i>${isUpload ? 'Upload an image to search' : 'Search Results'}
                </h6>
            </div>
        `;

        if (isUpload) {
            html += `
                <div class="alert alert-info mb-3">
                    <strong>For uploaded images:</strong>
                    <p class="mb-0 mt-2">Use these search engines directly by uploading your image:</p>
                </div>
            `;
        }

        for (const [engine, baseUrl] of Object.entries(searchEngines)) {
            const searchUrl = isUpload ? baseUrl : baseUrl + encodeURIComponent(url);

            let engineName = engine;
            let icon = 'search';
            if (engine === 'Google') icon = 'fab fa-google';
            else if (engine === 'Bing') icon = 'fab fa-microsoft';
            else if (engine === 'TinEye') icon = 'eye';
            else if (engine === 'Yandex') icon = 'magnifying-glass';
            else if (engine === 'Pinterest') icon = 'fab fa-pinterest';
            else if (engine === 'Baidu') icon = 'globe';

            html += `
                <div class="card card-sm mb-2">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong><i class="fas ${icon} me-2"></i>${engine}</strong>
                                <p class="mb-0 mt-1" style="font-size: 12px; color: #666;">
                                    ${isUpload ? 'Click to visit and upload your image' : 'Search with this engine'}
                                </p>
                            </div>
                            <a href="${searchUrl}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
            `;
        }

        html += `
            <div class="alert alert-info mt-3 mb-0">
                <strong><i class="fas fa-lightbulb me-2"></i>Tips:</strong>
                <ul class="mb-0 mt-2" style="font-size: 12px;">
                    <li>Google Reverse Image Search is the most popular and accurate</li>
                    <li>TinEye specializes in finding the original source of images</li>
                    <li>Different engines may return different results</li>
                    <li>Some images may not be indexed by all search engines</li>
                </ul>
            </div>
        `;

        results.innerHTML = html;
    }

    imageUrl.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            searchBtn.click();
        }
    });
});
</script>
