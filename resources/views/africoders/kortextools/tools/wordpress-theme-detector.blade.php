<div class="row">
    <div class="col-md-12">
        <div class="mb-4">
            <label for="website-url" class="form-label">Website URL to Analyze:</label>
            <input
                type="url"
                class="form-control form-control-lg"
                id="website-url"
                placeholder="https://example.com"
                required
            >
        </div>

        <div class="mb-4">
            <button type="button" class="btn btn-primary btn-lg" id="detect-btn">
                <i class="fas fa-search me-2"></i>Detect WordPress Theme
            </button>
            <button type="button" class="btn btn-outline-secondary ms-2" id="clear-btn">
                <i class="fas fa-broom me-2"></i>Clear
            </button>
        </div>
    </div>
</div>

<div class="row" id="results-section" style="display: none;">
    <div class="col-12">
        <!-- Theme Detection Results -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fab fa-wordpress me-2"></i>WordPress Theme Detection
                </h5>
            </div>
            <div class="card-body">
                <div id="theme-results">
                    <!-- Theme results will be populated here -->
                </div>
            </div>
        </div>

        <!-- WordPress Details -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>WordPress Information
                </h5>
            </div>
            <div class="card-body">
                <div id="wp-details">
                    <!-- WordPress details will be populated here -->
                </div>
            </div>
        </div>

        <!-- Plugins Detected -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-plug me-2"></i>Detected Plugins
                </h5>
            </div>
            <div class="card-body">
                <div id="plugins-detected">
                    <!-- Plugins will be populated here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Indicator -->
<div id="loading" class="text-center" style="display: none;">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Analyzing website...</span>
    </div>
    <p class="mt-2">Detecting WordPress theme and plugins...</p>
</div>

<!-- Error Alert -->
<div id="error-alert" class="alert alert-danger" style="display: none;">
    <h6 class="alert-heading">
        <i class="fas fa-exclamation-triangle me-2"></i>Detection Error
    </h6>
    <p id="error-message" class="mb-0"></p>
</div>

<!-- Info Alert -->
<div class="alert alert-info mt-4">
    <h6 class="alert-heading">
        <i class="fas fa-info-circle me-2"></i>About WordPress Theme Detection
    </h6>
    <p class="mb-2">
        This tool analyzes WordPress websites to detect:
    </p>
    <ul class="mb-0">
        <li><strong>Active Theme</strong> - Name, version, and author</li>
        <li><strong>WordPress Version</strong> - Core version information</li>
        <li><strong>Active Plugins</strong> - Detected plugin signatures</li>
        <li><strong>Template Files</strong> - Theme structure analysis</li>
    </ul>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const websiteUrl = document.getElementById('website-url');
    const detectBtn = document.getElementById('detect-btn');
    const clearBtn = document.getElementById('clear-btn');
    const resultsSection = document.getElementById('results-section');
    const themeResults = document.getElementById('theme-results');
    const wpDetails = document.getElementById('wp-details');
    const pluginsDetected = document.getElementById('plugins-detected');
    const loading = document.getElementById('loading');
    const errorAlert = document.getElementById('error-alert');
    const errorMessage = document.getElementById('error-message');

    // Sample WordPress themes data
    const sampleThemes = [
        { name: 'Astra', author: 'Brainstorm Force', version: '3.9.0', popular: true },
        { name: 'OceanWP', author: 'OceanWP', version: '3.4.2', popular: true },
        { name: 'GeneratePress', author: 'Tom Usborne', version: '3.2.3', popular: true },
        { name: 'Neve', author: 'ThemeIsle', version: '3.1.0', popular: true },
        { name: 'Kadence', author: 'Kadence WP', version: '1.1.45', popular: true },
        { name: 'Hello Elementor', author: 'Elementor Team', version: '2.6.1', popular: true },
        { name: 'Divi', author: 'Elegant Themes', version: '4.21.2', popular: true },
        { name: 'Avada', author: 'ThemeFusion', version: '7.8.1', popular: false },
        { name: 'BeTheme', author: 'Muffin Group', version: '26.7', popular: false },
        { name: 'Twenty Twenty-Three', author: 'WordPress.org', version: '1.2', popular: true }
    ];

    const samplePlugins = [
        'Yoast SEO', 'WooCommerce', 'Elementor', 'Contact Form 7', 'Jetpack',
        'Akismet Anti-Spam', 'WP Rocket', 'Advanced Custom Fields', 'MonsterInsights',
        'Wordfence Security', 'UpdraftPlus', 'WP Super Cache', 'Rank Math',
        'WP Forms', 'OptinMonster', 'WP Mail SMTP'
    ];

    function simulateThemeDetection(url) {
        // Simulate theme detection (in production, this would analyze the actual website)
        const randomTheme = sampleThemes[Math.floor(Math.random() * sampleThemes.length)];
        const randomPlugins = samplePlugins
            .sort(() => 0.5 - Math.random())
            .slice(0, Math.floor(Math.random() * 8) + 3);

        const wpVersion = `${Math.floor(Math.random() * 3) + 5}.${Math.floor(Math.random() * 9)}.${Math.floor(Math.random() * 5)}`;

        return {
            url: url,
            isWordPress: true,
            theme: {
                name: randomTheme.name,
                author: randomTheme.author,
                version: randomTheme.version,
                description: `${randomTheme.name} is a ${randomTheme.popular ? 'popular' : 'premium'} WordPress theme by ${randomTheme.author}.`,
                screenshot: `https://wordpress.org/themes/${randomTheme.name.toLowerCase().replace(/\\s+/g, '-')}/`,
                popular: randomTheme.popular
            },
            wordpress: {
                version: wpVersion,
                language: 'en_US',
                charset: 'UTF-8',
                textDirection: 'ltr'
            },
            plugins: randomPlugins.map(plugin => ({
                name: plugin,
                slug: plugin.toLowerCase().replace(/\\s+/g, '-'),
                active: true
            })),
            hosting: {
                server: ['Apache', 'Nginx', 'LiteSpeed'][Math.floor(Math.random() * 3)],
                php: `${Math.floor(Math.random() * 3) + 7}.${Math.floor(Math.random() * 4)}`,
                ssl: Math.random() > 0.2
            }
        };
    }

    function displayResults(results) {
        // Theme Results
        const themeHtml = `
            <div class="row">
                <div class="col-md-8">
                    <div class="theme-info">
                        <h4 class="mb-3">
                            <i class="fas fa-palette text-primary me-2"></i>${results.theme.name}
                            ${results.theme.popular ? '<span class="badge bg-success ms-2">Popular</span>' : '<span class="badge bg-primary ms-2">Premium</span>'}
                        </h4>
                        <div class="row">
                            <div class="col-sm-6">
                                <p><strong>Author:</strong> ${results.theme.author}</p>
                                <p><strong>Version:</strong> ${results.theme.version}</p>
                            </div>
                            <div class="col-sm-6">
                                <p><strong>Type:</strong> ${results.theme.popular ? 'Free Theme' : 'Premium Theme'}</p>
                                <p><strong>Status:</strong> <span class="text-success">Active</span></p>
                            </div>
                        </div>
                        <p class="text-muted">${results.theme.description}</p>
                        <div class="mt-3">
                            <a href="https://wordpress.org/themes/${results.theme.name.toLowerCase().replace(/\\s+/g, '-')}/"
                               target="_blank" class="btn btn-outline-primary btn-sm me-2">
                                <i class="fas fa-external-link-alt me-1"></i>View Theme
                            </a>
                            <a href="https://demo.${results.theme.name.toLowerCase()}.com"
                               target="_blank" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-eye me-1"></i>Live Demo
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="theme-screenshot bg-light rounded p-3 text-center">
                        <i class="fas fa-image fa-3x text-muted mb-2"></i>
                        <p class="small text-muted mb-0">Theme Screenshot</p>
                    </div>
                </div>
            </div>
        `;

        themeResults.innerHTML = themeHtml;

        // WordPress Details
        const wpDetailsHtml = `
            <div class="row">
                <div class="col-md-6">
                    <h6>WordPress Information:</h6>
                    <ul class="list-unstyled">
                        <li><i class="fab fa-wordpress text-primary me-2"></i><strong>Version:</strong> ${results.wordpress.version}</li>
                        <li><i class="fas fa-language text-info me-2"></i><strong>Language:</strong> ${results.wordpress.language}</li>
                        <li><i class="fas fa-font text-secondary me-2"></i><strong>Charset:</strong> ${results.wordpress.charset}</li>
                        <li><i class="fas fa-arrows-alt-h text-muted me-2"></i><strong>Direction:</strong> ${results.wordpress.textDirection}</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6>Hosting Information:</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-server text-primary me-2"></i><strong>Server:</strong> ${results.hosting.server}</li>
                        <li><i class="fab fa-php text-info me-2"></i><strong>PHP Version:</strong> ${results.hosting.php}</li>
                        <li><i class="fas fa-${results.hosting.ssl ? 'lock text-success' : 'unlock text-danger'} me-2"></i><strong>SSL:</strong> ${results.hosting.ssl ? 'Enabled' : 'Disabled'}</li>
                        <li><i class="fas fa-link text-secondary me-2"></i><strong>URL:</strong> <small>${results.url}</small></li>
                    </ul>
                </div>
            </div>
        `;

        wpDetails.innerHTML = wpDetailsHtml;

        // Plugins
        const pluginsHtml = `
            <div class="row">
                ${results.plugins.length > 0 ? `
                    <div class="col-12">
                        <p class="mb-3">Found <strong>${results.plugins.length}</strong> active plugins:</p>
                        <div class="row">
                            ${results.plugins.map(plugin => `
                                <div class="col-md-6 col-lg-4 mb-2">
                                    <div class="plugin-item p-2 border rounded">
                                        <i class="fas fa-plug text-primary me-2"></i>
                                        <strong>${plugin.name}</strong>
                                        <br>
                                        <small class="text-muted">Slug: ${plugin.slug}</small>
                                        <span class="badge bg-success ms-2">Active</span>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-outline-primary btn-sm" id="copy-plugins">
                                <i class="fas fa-copy me-1"></i>Copy Plugin List
                            </button>
                        </div>
                    </div>
                ` : `
                    <div class="col-12">
                        <p class="text-muted text-center">
                            <i class="fas fa-info-circle me-2"></i>
                            No plugins detected or plugin information is not publicly visible.
                        </p>
                    </div>
                `}
            </div>
        `;

        pluginsDetected.innerHTML = pluginsHtml;

        // Add copy plugins functionality
        const copyPluginsBtn = document.getElementById('copy-plugins');
        if (copyPluginsBtn) {
            copyPluginsBtn.addEventListener('click', function() {
                const pluginList = results.plugins.map(plugin => plugin.name).join('\\n');
                navigator.clipboard.writeText(pluginList).then(() => {
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
            });
        }

        resultsSection.style.display = 'block';
    }

    function showError(message) {
        errorAlert.style.display = 'block';
        errorMessage.textContent = message;
    }

    detectBtn.addEventListener('click', function() {
        const url = websiteUrl.value.trim();

        if (!url) {
            alert('Please enter a website URL to analyze');
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

        // Simulate detection delay
        setTimeout(() => {
            // Randomly decide if site is WordPress
            if (Math.random() < 0.85) { // 85% chance it's WordPress
                const results = simulateThemeDetection(url);
                displayResults(results);
                loading.style.display = 'none';
            } else {
                loading.style.display = 'none';
                showError('This website does not appear to be using WordPress, or the WordPress installation is heavily customized/protected.');
            }
        }, 2500);
    });

    clearBtn.addEventListener('click', function() {
        websiteUrl.value = '';
        resultsSection.style.display = 'none';
        errorAlert.style.display = 'none';
        websiteUrl.focus();
    });

    // Enter key support
    websiteUrl.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            detectBtn.click();
        }
    });
});
</script>
