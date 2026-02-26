<div class="row">
    <div class="col-md-12">
        <!-- AdSense Calculator Selection -->
        <div class="mb-4">
            <h6>Select Calculation Type:</h6>
            <div class="btn-group w-100" role="group" aria-label="Calculation Type">
                <button type="button" class="btn btn-primary active" id="btnEarningsCalculator" onclick="showCalculator('earnings')">
                    Earnings Calculator
                </button>
                <button type="button" class="btn btn-outline-primary" id="btnCTROptimizer" onclick="showCalculator('ctr')">
                    CTR Optimizer
                </button>
                <button type="button" class="btn btn-outline-primary" id="btnRPMCalculator" onclick="showCalculator('rpm')">
                    RPM Calculator
                </button>
                <button type="button" class="btn btn-outline-primary" id="btnTrafficPlanner" onclick="showCalculator('traffic')">
                    Traffic Planner
                </button>
            </div>
        </div>

        <!-- Earnings Calculator -->
        <div id="earningsCalculator" class="calculator-section">
            <h5><i class="fab fa-google"></i> AdSense Earnings Calculator</h5>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="dailyPageViews" class="form-label">Daily Page Views</label>
                    <input type="number" class="form-control" id="dailyPageViews" placeholder="1000" min="1" step="1">
                    <small class="form-text text-muted">Number of page views per day</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="clickThroughRate" class="form-label">Click Through Rate (CTR)</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="clickThroughRate" placeholder="1.5" step="0.01" min="0" max="100">
                        <span class="input-group-text">%</span>
                    </div>
                    <small class="form-text text-muted">Average CTR (typically 0.5-3%)</small>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="costPerClick" class="form-label">Cost Per Click (CPC)</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="costPerClick" placeholder="0.50" step="0.01" min="0">
                    </div>
                    <small class="form-text text-muted">Average CPC in your niche</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="adDensity" class="form-label">Ad Density</label>
                    <select class="form-select" id="adDensity">
                        <option value="0.7">Low (70%)</option>
                        <option value="0.85" selected>Medium (85%)</option>
                        <option value="0.95">High (95%)</option>
                    </select>
                    <small class="form-text text-muted">Percentage of pages with ads</small>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="adsPerPage" class="form-label">Ads Per Page</label>
                    <input type="number" class="form-control" id="adsPerPage" placeholder="3" min="1" max="10" value="3">
                    <small class="form-text text-muted">Average number of ad units per page</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="geography" class="form-label">Primary Geography</label>
                    <select class="form-select" id="geography">
                        <option value="1.0" selected>Tier 1 (US, UK, CA, AU)</option>
                        <option value="0.6">Tier 2 (Europe, Japan)</option>
                        <option value="0.3">Tier 3 (Developing countries)</option>
                    </select>
                    <small class="form-text text-muted">Geographic tier affects CPC</small>
                </div>
            </div>

            <!-- Quick Presets -->
            <div class="mb-4">
                <h6>Quick Presets:</h6>
                <div class="row">
                    <div class="col-md-4">
                        <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="useEarningsPreset('blog')">
                            Personal Blog
                        </button>
                        <small class="text-muted">Low traffic, high engagement</small>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="useEarningsPreset('news')">
                            News Site
                        </button>
                        <small class="text-muted">High traffic, medium CTR</small>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="useEarningsPreset('tech')">
                            Tech Site
                        </button>
                        <small class="text-muted">Medium traffic, high CPC</small>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-primary" onclick="calculateEarnings()">
                <i class="fas fa-calculator"></i> Calculate Earnings
            </button>
        </div>

        <!-- CTR Optimizer -->
        <div id="ctrCalculator" class="calculator-section" style="display: none;">
            <h5><i class="bi bi-graph-up"></i> CTR Optimizer</h5>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="adImpressions" class="form-label">Ad Impressions</label>
                    <input type="number" class="form-control" id="adImpressions" placeholder="10000" min="1">
                    <small class="form-text text-muted">Total ad impressions</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="adClicks" class="form-label">Ad Clicks</label>
                    <input type="number" class="form-control" id="adClicks" placeholder="150" min="0">
                    <small class="form-text text-muted">Total ad clicks received</small>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="targetCTR" class="form-label">Target CTR</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="targetCTR" placeholder="2.0" step="0.1" min="0" max="10">
                        <span class="input-group-text">%</span>
                    </div>
                    <small class="form-text text-muted">Your target CTR goal</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="improvementTimeframe" class="form-label">Improvement Timeframe</label>
                    <select class="form-select" id="improvementTimeframe">
                        <option value="30">30 days</option>
                        <option value="60" selected>60 days</option>
                        <option value="90">90 days</option>
                        <option value="180">6 months</option>
                    </select>
                </div>
            </div>

            <button type="button" class="btn btn-primary" onclick="calculateCTR()">
                <i class="fas fa-chart-line"></i> Analyze CTR
            </button>
        </div>

        <!-- RPM Calculator -->
        <div id="rpmCalculator" class="calculator-section" style="display: none;">
            <h5><i class="bi bi-cash-stack"></i> RPM Calculator</h5>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="totalEarnings" class="form-label">Total Earnings</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="totalEarnings" placeholder="125.50" step="0.01" min="0">
                    </div>
                    <small class="form-text text-muted">Total AdSense earnings for the period</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="totalPageViews" class="form-label">Total Page Views</label>
                    <input type="number" class="form-control" id="totalPageViews" placeholder="50000" min="1">
                    <small class="form-text text-muted">Total page views for the period</small>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="timePeriod" class="form-label">Time Period</label>
                    <select class="form-select" id="timePeriod">
                        <option value="1">1 day</option>
                        <option value="7">1 week</option>
                        <option value="30" selected>1 month</option>
                        <option value="90">3 months</option>
                        <option value="365">1 year</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="benchmarkRPM" class="form-label">Benchmark RPM (Optional)</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="benchmarkRPM" placeholder="2.50" step="0.01" min="0">
                    </div>
                    <small class="form-text text-muted">Industry benchmark for comparison</small>
                </div>
            </div>

            <button type="button" class="btn btn-primary" onclick="calculateRPM()">
                <i class="fas fa-chart-bar"></i> Calculate RPM
            </button>
        </div>

        <!-- Traffic Planner -->
        <div id="trafficCalculator" class="calculator-section" style="display: none;">
            <h5><i class="bi bi-people"></i> Traffic Planner</h5>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="targetEarnings" class="form-label">Target Monthly Earnings</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="targetEarnings" placeholder="1000" step="1" min="1">
                    </div>
                    <small class="form-text text-muted">Your monthly earnings goal</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="estimatedRPM" class="form-label">Estimated RPM</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="estimatedRPM" placeholder="2.50" step="0.01" min="0.01">
                    </div>
                    <small class="form-text text-muted">Your current or estimated RPM</small>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="currentTraffic" class="form-label">Current Monthly Traffic</label>
                    <input type="number" class="form-control" id="currentTraffic" placeholder="25000" min="0">
                    <small class="form-text text-muted">Current monthly page views</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="growthRate" class="form-label">Monthly Growth Rate</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="growthRate" placeholder="5" step="0.1" min="0">
                        <span class="input-group-text">%</span>
                    </div>
                    <small class="form-text text-muted">Expected monthly traffic growth</small>
                </div>
            </div>

            <button type="button" class="btn btn-primary" onclick="calculateTrafficGoals()">
                <i class="fas fa-bullseye"></i> Calculate Traffic Goals
            </button>
        </div>

        <!-- Results Container -->
        <div id="resultsContainer" style="display: none;" class="mt-4">
            <div class="card">
                <div class="card-header">
                    <h5 id="resultsTitle" class="mb-0">Calculation Results</h5>
                </div>
                <div class="card-body" id="resultsContent">
                    <!-- Dynamic results content will be inserted here -->
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-outline-primary" onclick="copyResults()">
                        <i class="bi bi-clipboard"></i> Copy Results
                    </button>
                    <button type="button" class="btn btn-outline-success" onclick="exportResults()">
                        <i class="bi bi-download"></i> Export Report
                    </button>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-4">
            <button type="button" class="btn btn-outline-secondary" onclick="clearAll()">
                <i class="bi bi-x-circle"></i> Clear All
            </button>
            <button type="button" class="btn btn-outline-info" onclick="showAdSenseGuide()">
                <i class="bi bi-question-circle"></i> Optimization Guide
            </button>
        </div>

        <!-- AdSense Guide -->
        <div id="adsenseGuide" style="display: none;" class="mt-4 p-4 bg-light rounded">
            <h6><i class="fab fa-google"></i> AdSense Optimization Guide</h6>
            <div class="row">
                <div class="col-md-6">
                    <h6>Improving CTR:</h6>
                    <ul class="small">
                        <li>Place ads above the fold</li>
                        <li>Use responsive ad units</li>
                        <li>Blend ads with content naturally</li>
                        <li>Test different ad sizes</li>
                        <li>Optimize ad placement heat maps</li>
                    </ul>

                    <h6>Increasing CPC:</h6>
                    <ul class="small">
                        <li>Target high-value keywords</li>
                        <li>Create quality content</li>
                        <li>Focus on Tier 1 countries</li>
                        <li>Avoid click-baiting</li>
                        <li>Use relevant ad categories</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6>Boosting RPM:</h6>
                    <ul class="small">
                        <li>Optimize page load speed</li>
                        <li>Improve user engagement</li>
                        <li>Use Auto ads strategically</li>
                        <li>A/B test ad layouts</li>
                        <li>Monitor performance regularly</li>
                    </ul>

                    <h6>Traffic Quality Tips:</h6>
                    <ul class="small">
                        <li>Focus on organic search traffic</li>
                        <li>Target commercial intent keywords</li>
                        <li>Build engaged audience</li>
                        <li>Reduce bounce rate</li>
                        <li>Increase session duration</li>
                    </ul>
                </div>
            </div>

            <div class="mt-3">
                <button type="button" class="btn btn-secondary" onclick="hideAdSenseGuide()">Close</button>
                <small class="text-muted ms-3">*Results are estimates based on industry averages</small>
            </div>
        </div>

        <!-- Industry Benchmarks -->
        <div class="mt-4">
            <div class="row">
                <div class="col-md-3">
                    <div class="text-center p-3 border rounded">
                        <div class="h5 text-primary">0.5-3%</div>
                        <div class="small">Average CTR</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 border rounded">
                        <div class="h5 text-success">$0.20-$5</div>
                        <div class="small">Typical CPC</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 border rounded">
                        <div class="h5 text-info">$1-$5</div>
                        <div class="small">Good RPM</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 border rounded">
                        <div class="h5 text-warning">85%+</div>
                        <div class="small">Ad Fill Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Information Alert -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> About AdSense Calculations</h6>
    <p class="mb-0">
        These calculations provide estimates based on industry averages and your input parameters.
        Actual AdSense earnings vary based on content quality, audience location, niche competition,
        seasonal factors, and Google's algorithm changes. Use these tools for planning and optimization guidance.
    </p>
</div>

<script>
let currentCalculationType = 'earnings';
let currentResults = null;

function showCalculator(type) {
    // Hide all calculators
    document.querySelectorAll('.calculator-section').forEach(section => {
        section.style.display = 'none';
    });

    // Update button states
    document.querySelectorAll('.btn-group button').forEach(btn => {
        btn.classList.remove('btn-primary', 'active');
        btn.classList.add('btn-outline-primary');
    });

    // Show selected calculator
    currentCalculationType = type;

    switch(type) {
        case 'earnings':
            document.getElementById('earningsCalculator').style.display = 'block';
            document.getElementById('btnEarningsCalculator').classList.remove('btn-outline-primary');
            document.getElementById('btnEarningsCalculator').classList.add('btn-primary', 'active');
            break;
        case 'ctr':
            document.getElementById('ctrCalculator').style.display = 'block';
            document.getElementById('btnCTROptimizer').classList.remove('btn-outline-primary');
            document.getElementById('btnCTROptimizer').classList.add('btn-primary', 'active');
            break;
        case 'rpm':
            document.getElementById('rpmCalculator').style.display = 'block';
            document.getElementById('btnRPMCalculator').classList.remove('btn-outline-primary');
            document.getElementById('btnRPMCalculator').classList.add('btn-primary', 'active');
            break;
        case 'traffic':
            document.getElementById('trafficCalculator').style.display = 'block';
            document.getElementById('btnTrafficPlanner').classList.remove('btn-outline-primary');
            document.getElementById('btnTrafficPlanner').classList.add('btn-primary', 'active');
            break;
    }

    // Hide previous results
    document.getElementById('resultsContainer').style.display = 'none';
}

function useEarningsPreset(type) {
    const presets = {
        'blog': {
            dailyPageViews: 500,
            ctr: 2.5,
            cpc: 0.75,
            adsPerPage: 2
        },
        'news': {
            dailyPageViews: 5000,
            ctr: 1.2,
            cpc: 0.35,
            adsPerPage: 4
        },
        'tech': {
            dailyPageViews: 2000,
            ctr: 1.8,
            cpc: 1.25,
            adsPerPage: 3
        }
    };

    const preset = presets[type];
    document.getElementById('dailyPageViews').value = preset.dailyPageViews;
    document.getElementById('clickThroughRate').value = preset.ctr;
    document.getElementById('costPerClick').value = preset.cpc;
    document.getElementById('adsPerPage').value = preset.adsPerPage;
}

function calculateEarnings() {
    const dailyPageViews = parseInt(document.getElementById('dailyPageViews').value);
    const ctr = parseFloat(document.getElementById('clickThroughRate').value) / 100;
    const cpc = parseFloat(document.getElementById('costPerClick').value);
    const adDensity = parseFloat(document.getElementById('adDensity').value);
    const adsPerPage = parseInt(document.getElementById('adsPerPage').value);
    const geoMultiplier = parseFloat(document.getElementById('geography').value);

    if (!dailyPageViews || !ctr || !cpc) {
        alert('Please fill in the required fields: Daily Page Views, CTR, and CPC.');
        return;
    }

    // Calculate daily metrics
    const dailyAdImpressions = dailyPageViews * adsPerPage * adDensity;
    const dailyClicks = dailyAdImpressions * ctr;
    const adjustedCPC = cpc * geoMultiplier;
    const dailyEarnings = dailyClicks * adjustedCPC;

    // Calculate monthly and yearly projections
    const monthlyEarnings = dailyEarnings * 30;
    const yearlyEarnings = dailyEarnings * 365;
    const rpm = (dailyEarnings / dailyPageViews) * 1000;

    currentResults = {
        type: 'earnings',
        daily: {
            pageViews: dailyPageViews,
            impressions: Math.round(dailyAdImpressions),
            clicks: Math.round(dailyClicks * 10) / 10,
            earnings: dailyEarnings
        },
        monthly: monthlyEarnings,
        yearly: yearlyEarnings,
        rpm: rpm,
        ctr: ctr * 100,
        adjustedCPC: adjustedCPC
    };

    displayEarningsResults(currentResults);
}

function displayEarningsResults(results) {
    const content = `
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="text-center p-3 bg-primary text-white rounded">
                    <h5>$${results.daily.earnings.toFixed(2)}</h5>
                    <small>Daily Earnings</small>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="text-center p-3 bg-success text-white rounded">
                    <h5>$${results.monthly.toFixed(2)}</h5>
                    <small>Monthly Earnings</small>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="text-center p-3 bg-info text-white rounded">
                    <h5>$${results.yearly.toFixed(2)}</h5>
                    <small>Yearly Projection</small>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="text-center p-3 bg-warning text-dark rounded">
                    <h5>$${results.rpm.toFixed(2)}</h5>
                    <small>RPM</small>
                </div>
            </div>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-striped">
                <tr><th width="40%">Daily Page Views</th><td>${results.daily.pageViews.toLocaleString()}</td></tr>
                <tr><th>Daily Ad Impressions</th><td>${results.daily.impressions.toLocaleString()}</td></tr>
                <tr><th>Daily Clicks</th><td>${results.daily.clicks}</td></tr>
                <tr><th>Effective CTR</th><td>${results.ctr.toFixed(2)}%</td></tr>
                <tr><th>Adjusted CPC</th><td>$${results.adjustedCPC.toFixed(2)}</td></tr>
                <tr><th>Revenue Per Mille (RPM)</th><td>$${results.rpm.toFixed(2)}</td></tr>
            </table>
        </div>

        <div class="mt-4">
            <h6>Earnings Breakdown:</h6>
            <div class="progress mb-2" style="height: 30px;">
                <div class="progress-bar bg-primary" style="width: 33.33%">
                    <small>Daily: $${results.daily.earnings.toFixed(2)}</small>
                </div>
                <div class="progress-bar bg-success" style="width: 33.33%">
                    <small>Monthly: $${results.monthly.toFixed(2)}</small>
                </div>
                <div class="progress-bar bg-info" style="width: 33.34%">
                    <small>Yearly: $${results.yearly.toFixed(2)}</small>
                </div>
            </div>
        </div>
    `;

    document.getElementById('resultsTitle').textContent = 'AdSense Earnings Projection';
    document.getElementById('resultsContent').innerHTML = content;
    document.getElementById('resultsContainer').style.display = 'block';
}

function calculateCTR() {
    const impressions = parseInt(document.getElementById('adImpressions').value);
    const clicks = parseInt(document.getElementById('adClicks').value);
    const targetCTR = parseFloat(document.getElementById('targetCTR').value) / 100;
    const timeframe = parseInt(document.getElementById('improvementTimeframe').value);

    if (!impressions || clicks === undefined) {
        alert('Please enter ad impressions and clicks.');
        return;
    }

    const currentCTR = impressions > 0 ? clicks / impressions : 0;
    const targetClicks = impressions * targetCTR;
    const clicksNeeded = Math.max(0, targetClicks - clicks);
    const improvementNeeded = (targetCTR - currentCTR) * 100;
    const dailyImprovementRate = improvementNeeded / timeframe;

    currentResults = {
        type: 'ctr',
        current: currentCTR * 100,
        target: targetCTR * 100,
        impressions: impressions,
        clicks: clicks,
        targetClicks: Math.round(targetClicks),
        clicksNeeded: Math.round(clicksNeeded),
        improvementNeeded: improvementNeeded,
        timeframe: timeframe,
        dailyRate: dailyImprovementRate
    };

    displayCTRResults(currentResults);
}

function displayCTRResults(results) {
    const status = results.current >= results.target ? 'success' : 'warning';
    const statusText = results.current >= results.target ? 'Target Achieved!' : 'Improvement Needed';

    const content = `
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="text-center p-3 bg-primary text-white rounded">
                    <h5>${results.current.toFixed(2)}%</h5>
                    <small>Current CTR</small>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="text-center p-3 bg-success text-white rounded">
                    <h5>${results.target.toFixed(2)}%</h5>
                    <small>Target CTR</small>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="text-center p-3 bg-info text-white rounded">
                    <h5>${results.clicksNeeded}</h5>
                    <small>Additional Clicks Needed</small>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="text-center p-3 bg-${status} text-${status === 'warning' ? 'dark' : 'white'} rounded">
                    <h5>${Math.abs(results.improvementNeeded).toFixed(1)}%</h5>
                    <small>Improvement ${results.improvementNeeded >= 0 ? 'Needed' : 'Achieved'}</small>
                </div>
            </div>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-striped">
                <tr><th width="40%">Total Impressions</th><td>${results.impressions.toLocaleString()}</td></tr>
                <tr><th>Current Clicks</th><td>${results.clicks.toLocaleString()}</td></tr>
                <tr><th>Target Clicks</th><td>${results.targetClicks.toLocaleString()}</td></tr>
                <tr><th>Improvement Timeframe</th><td>${results.timeframe} days</td></tr>
                <tr><th>Daily Improvement Rate</th><td>${Math.abs(results.dailyRate).toFixed(3)}% per day</td></tr>
                <tr class="table-${status}"><th><strong>Status</strong></th><td><strong>${statusText}</strong></td></tr>
            </table>
        </div>

        <div class="mt-4">
            <h6>CTR Optimization Recommendations:</h6>
            <ul class="small">
                ${results.improvementNeeded > 0 ? `
                    <li>Optimize ad placement above the fold</li>
                    <li>Test different ad sizes and formats</li>
                    <li>Improve ad-content integration</li>
                    <li>Use heat map analysis for placement</li>
                    <li>A/B test ad colors and designs</li>
                ` : `
                    <li>Great job! Your CTR meets the target</li>
                    <li>Monitor performance to maintain this level</li>
                    <li>Consider setting a higher target for growth</li>
                    <li>Focus on improving CPC and overall earnings</li>
                `}
            </ul>
        </div>
    `;

    document.getElementById('resultsTitle').textContent = 'CTR Analysis & Optimization';
    document.getElementById('resultsContent').innerHTML = content;
    document.getElementById('resultsContainer').style.display = 'block';
}

function calculateRPM() {
    const earnings = parseFloat(document.getElementById('totalEarnings').value);
    const pageViews = parseInt(document.getElementById('totalPageViews').value);
    const days = parseInt(document.getElementById('timePeriod').value);
    const benchmark = parseFloat(document.getElementById('benchmarkRPM').value) || 0;

    if (!earnings || !pageViews) {
        alert('Please enter total earnings and page views.');
        return;
    }

    const rpm = (earnings / pageViews) * 1000;
    const dailyEarnings = earnings / days;
    const dailyPageViews = pageViews / days;
    const monthlyEarnings = dailyEarnings * 30;
    const monthlyPageViews = dailyPageViews * 30;

    currentResults = {
        type: 'rpm',
        rpm: rpm,
        earnings: earnings,
        pageViews: pageViews,
        days: days,
        dailyEarnings: dailyEarnings,
        dailyPageViews: dailyPageViews,
        monthlyEarnings: monthlyEarnings,
        monthlyPageViews: monthlyPageViews,
        benchmark: benchmark
    };

    displayRPMResults(currentResults);
}

function displayRPMResults(results) {
    const benchmarkComparison = results.benchmark > 0 ?
        (results.rpm / results.benchmark * 100) : 0;

    const content = `
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="text-center p-3 bg-primary text-white rounded">
                    <h5>$${results.rpm.toFixed(2)}</h5>
                    <small>Revenue Per Mille</small>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="text-center p-3 bg-success text-white rounded">
                    <h5>$${results.dailyEarnings.toFixed(2)}</h5>
                    <small>Daily Earnings</small>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="text-center p-3 bg-info text-white rounded">
                    <h5>$${results.monthlyEarnings.toFixed(2)}</h5>
                    <small>Monthly Projection</small>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="text-center p-3 bg-warning text-dark rounded">
                    <h5>${Math.round(results.dailyPageViews).toLocaleString()}</h5>
                    <small>Daily Page Views</small>
                </div>
            </div>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-striped">
                <tr><th width="40%">Total Earnings</th><td>$${results.earnings.toFixed(2)}</td></tr>
                <tr><th>Total Page Views</th><td>${results.pageViews.toLocaleString()}</td></tr>
                <tr><th>Time Period</th><td>${results.days} days</td></tr>
                <tr><th>Revenue Per Mille (RPM)</th><td>$${results.rpm.toFixed(2)}</td></tr>
                <tr><th>Daily Page Views</th><td>${Math.round(results.dailyPageViews).toLocaleString()}</td></tr>
                <tr><th>Monthly Page Views</th><td>${Math.round(results.monthlyPageViews).toLocaleString()}</td></tr>
                ${results.benchmark > 0 ? `
                    <tr><th>Benchmark RPM</th><td>$${results.benchmark.toFixed(2)}</td></tr>
                    <tr class="${benchmarkComparison >= 100 ? 'table-success' : 'table-warning'}">
                        <th>Performance vs Benchmark</th>
                        <td>${benchmarkComparison.toFixed(1)}%</td>
                    </tr>
                ` : ''}
            </table>
        </div>

        <div class="mt-4">
            <h6>RPM Performance Analysis:</h6>
            <div class="alert ${results.rpm >= 3 ? 'alert-success' : results.rpm >= 1.5 ? 'alert-warning' : 'alert-danger'}">
                ${results.rpm >= 3 ?
                    '<strong>Excellent!</strong> Your RPM is above average.' :
                    results.rpm >= 1.5 ?
                    '<strong>Good.</strong> Your RPM is decent but has room for improvement.' :
                    '<strong>Needs Improvement.</strong> Your RPM is below industry average.'
                }
            </div>
            <ul class="small">
                <li>Industry average RPM: $1.50 - $3.00</li>
                <li>High-performing sites: $3.00+ RPM</li>
                <li>Focus on high-value content and traffic quality</li>
                <li>Optimize ad placement and user experience</li>
            </ul>
        </div>
    `;

    document.getElementById('resultsTitle').textContent = 'RPM Analysis & Performance';
    document.getElementById('resultsContent').innerHTML = content;
    document.getElementById('resultsContainer').style.display = 'block';
}

function calculateTrafficGoals() {
    const targetEarnings = parseFloat(document.getElementById('targetEarnings').value);
    const estimatedRPM = parseFloat(document.getElementById('estimatedRPM').value);
    const currentTraffic = parseInt(document.getElementById('currentTraffic').value) || 0;
    const growthRate = parseFloat(document.getElementById('growthRate').value) / 100 || 0;

    if (!targetEarnings || !estimatedRPM) {
        alert('Please enter target earnings and estimated RPM.');
        return;
    }

    const requiredPageViews = (targetEarnings / estimatedRPM) * 1000;
    const trafficIncrease = Math.max(0, requiredPageViews - currentTraffic);
    const monthsToGoal = growthRate > 0 ?
        Math.log(requiredPageViews / Math.max(currentTraffic, 1000)) / Math.log(1 + growthRate) : 0;

    const dailyRequired = requiredPageViews / 30;
    const currentDaily = currentTraffic / 30;

    currentResults = {
        type: 'traffic',
        targetEarnings: targetEarnings,
        estimatedRPM: estimatedRPM,
        requiredPageViews: requiredPageViews,
        currentTraffic: currentTraffic,
        trafficIncrease: trafficIncrease,
        monthsToGoal: monthsToGoal,
        growthRate: growthRate * 100,
        dailyRequired: dailyRequired,
        currentDaily: currentDaily
    };

    displayTrafficResults(currentResults);
}

function displayTrafficResults(results) {
    const content = `
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="text-center p-3 bg-primary text-white rounded">
                    <h5>${Math.round(results.requiredPageViews).toLocaleString()}</h5>
                    <small>Monthly Views Needed</small>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="text-center p-3 bg-success text-white rounded">
                    <h5>${Math.round(results.trafficIncrease).toLocaleString()}</h5>
                    <small>Traffic Increase Required</small>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="text-center p-3 bg-info text-white rounded">
                    <h5>${Math.round(results.dailyRequired).toLocaleString()}</h5>
                    <small>Daily Views Needed</small>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="text-center p-3 bg-warning text-dark rounded">
                    <h5>${results.monthsToGoal > 0 ? Math.ceil(results.monthsToGoal) : '∞'}</h5>
                    <small>Months to Goal</small>
                </div>
            </div>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-striped">
                <tr><th width="40%">Target Monthly Earnings</th><td>$${results.targetEarnings.toFixed(2)}</td></tr>
                <tr><th>Estimated RPM</th><td>$${results.estimatedRPM.toFixed(2)}</td></tr>
                <tr><th>Required Monthly Page Views</th><td>${Math.round(results.requiredPageViews).toLocaleString()}</td></tr>
                <tr><th>Current Monthly Traffic</th><td>${results.currentTraffic.toLocaleString()}</td></tr>
                <tr><th>Traffic Increase Needed</th><td>${Math.round(results.trafficIncrease).toLocaleString()}</td></tr>
                <tr><th>Current Daily Average</th><td>${Math.round(results.currentDaily).toLocaleString()}</td></tr>
                <tr><th>Required Daily Average</th><td>${Math.round(results.dailyRequired).toLocaleString()}</td></tr>
                <tr><th>Monthly Growth Rate</th><td>${results.growthRate.toFixed(1)}%</td></tr>
            </table>
        </div>

        <div class="mt-4">
            <h6>Traffic Growth Strategy:</h6>
            <div class="row">
                <div class="col-md-6">
                    <div class="alert ${results.trafficIncrease > results.currentTraffic * 3 ? 'alert-warning' : 'alert-info'}">
                        <strong>Growth Assessment:</strong><br>
                        ${results.trafficIncrease > results.currentTraffic * 3 ?
                            'Aggressive growth plan needed. Consider multiple traffic sources.' :
                            'Achievable with consistent content strategy and SEO.'
                        }
                    </div>
                </div>
                <div class="col-md-6">
                    <ul class="small">
                        <li>Focus on SEO and organic growth</li>
                        <li>Create high-quality, searchable content</li>
                        <li>Build social media presence</li>
                        <li>Consider email marketing</li>
                        <li>Analyze competitor strategies</li>
                    </ul>
                </div>
            </div>
        </div>
    `;

    document.getElementById('resultsTitle').textContent = 'Traffic Goals & Growth Planning';
    document.getElementById('resultsContent').innerHTML = content;
    document.getElementById('resultsContainer').style.display = 'block';
}

function clearAll() {
    // Clear all input fields
    document.querySelectorAll('input, select').forEach(input => {
        if (input.type === 'checkbox') {
            input.checked = false;
        } else {
            input.value = input.hasAttribute('value') ? input.getAttribute('value') : '';
        }
    });

    // Reset to earnings calculator
    showCalculator('earnings');

    // Hide results and guides
    document.getElementById('resultsContainer').style.display = 'none';
    document.getElementById('adsenseGuide').style.display = 'none';

    currentResults = null;
}

function copyResults() {
    if (!currentResults) return;

    let textToCopy = '';

    switch(currentResults.type) {
        case 'earnings':
            textToCopy = `AdSense Earnings Calculator Results:
Daily Earnings: $${currentResults.daily.earnings.toFixed(2)}
Monthly Earnings: $${currentResults.monthly.toFixed(2)}
Yearly Projection: $${currentResults.yearly.toFixed(2)}
RPM: $${currentResults.rpm.toFixed(2)}
Daily Page Views: ${currentResults.daily.pageViews.toLocaleString()}
Daily Ad Impressions: ${currentResults.daily.impressions.toLocaleString()}
Effective CTR: ${currentResults.ctr.toFixed(2)}%`;
            break;
        case 'ctr':
            textToCopy = `CTR Analysis Results:
Current CTR: ${currentResults.current.toFixed(2)}%
Target CTR: ${currentResults.target.toFixed(2)}%
Additional Clicks Needed: ${currentResults.clicksNeeded}
Improvement Required: ${Math.abs(currentResults.improvementNeeded).toFixed(1)}%`;
            break;
        case 'rpm':
            textToCopy = `RPM Analysis Results:
Revenue Per Mille: $${currentResults.rpm.toFixed(2)}
Daily Earnings: $${currentResults.dailyEarnings.toFixed(2)}
Monthly Projection: $${currentResults.monthlyEarnings.toFixed(2)}
Daily Page Views: ${Math.round(currentResults.dailyPageViews).toLocaleString()}`;
            break;
        case 'traffic':
            textToCopy = `Traffic Planning Results:
Target Monthly Earnings: $${currentResults.targetEarnings.toFixed(2)}
Required Monthly Views: ${Math.round(currentResults.requiredPageViews).toLocaleString()}
Traffic Increase Needed: ${Math.round(currentResults.trafficIncrease).toLocaleString()}
Months to Goal: ${currentResults.monthsToGoal > 0 ? Math.ceil(currentResults.monthsToGoal) : 'N/A'}`;
            break;
    }

    navigator.clipboard.writeText(textToCopy).then(function() {
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

function exportResults() {
    if (!currentResults) return;

    alert('Export functionality would generate a detailed PDF report with charts and recommendations.');
}

function showAdSenseGuide() {
    document.getElementById('adsenseGuide').style.display = 'block';
}

function hideAdSenseGuide() {
    document.getElementById('adsenseGuide').style.display = 'none';
}

// Initialize with earnings calculator
document.addEventListener('DOMContentLoaded', function() {
    showCalculator('earnings');
});
</script>
