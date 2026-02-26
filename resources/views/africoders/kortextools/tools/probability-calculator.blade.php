<div class="row">
    <div class="col-md-12">
        <!-- Probability Calculator Type Selection -->
        <div class="mb-4">
            <h6>Select Probability Calculation Type:</h6>
            <div class="row">
                <div class="col-md-3 mb-2">
                    <button type="button" class="btn btn-primary active w-100" id="btnBasicProb" onclick="showCalculator('basic')">
                        Basic Probability
                    </button>
                </div>
                <div class="col-md-3 mb-2">
                    <button type="button" class="btn btn-outline-primary w-100" id="btnCombinations" onclick="showCalculator('combinations')">
                        Combinations & Permutations
                    </button>
                </div>
                <div class="col-md-3 mb-2">
                    <button type="button" class="btn btn-outline-primary w-100" id="btnConditional" onclick="showCalculator('conditional')">
                        Conditional Probability
                    </button>
                </div>
                <div class="col-md-3 mb-2">
                    <button type="button" class="btn btn-outline-primary w-100" id="btnDistribution" onclick="showCalculator('distribution')">
                        Distributions
                    </button>
                </div>
            </div>
        </div>

        <!-- Basic Probability Calculator -->
        <div id="basicCalculator" class="calculator-section">
            <h5><i class="bi bi-dice-6"></i> Basic Probability Calculator</h5>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="favorableOutcomes" class="form-label">Favorable Outcomes</label>
                    <input type="number" class="form-control" id="favorableOutcomes" placeholder="3" min="0" step="1">
                    <small class="form-text text-muted">Number of successful outcomes</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="totalOutcomes" class="form-label">Total Possible Outcomes</label>
                    <input type="number" class="form-control" id="totalOutcomes" placeholder="6" min="1" step="1">
                    <small class="form-text text-muted">Total number of possible outcomes</small>
                </div>
            </div>

            <!-- Multiple Events -->
            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="multipleEvents">
                    <label class="form-check-label" for="multipleEvents">
                        Calculate probability of multiple events
                    </label>
                </div>
                <div id="multipleEventsSection" style="display: none;" class="mt-3">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="event2Favorable" class="form-label">Event 2 - Favorable</label>
                            <input type="number" class="form-control" id="event2Favorable" placeholder="2" min="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="event2Total" class="form-label">Event 2 - Total</label>
                            <input type="number" class="form-control" id="event2Total" placeholder="4" min="1">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="eventRelation" class="form-label">Events are:</label>
                            <select class="form-select" id="eventRelation">
                                <option value="independent">Independent</option>
                                <option value="mutually_exclusive">Mutually Exclusive</option>
                                <option value="dependent">Dependent</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Examples -->
            <div class="mb-4">
                <h6>Quick Examples:</h6>
                <div class="row">
                    <div class="col-md-4">
                        <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="useBasicExample('dice')">
                            Dice Roll (1-6)
                        </button>
                        <small class="text-muted">Rolling a specific number</small>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="useBasicExample('coin')">
                            Coin Flip
                        </button>
                        <small class="text-muted">Heads or tails</small>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="useBasicExample('card')">
                            Card Draw
                        </button>
                        <small class="text-muted">Drawing specific card</small>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-primary" onclick="calculateBasicProbability()">
                <i class="fas fa-calculator"></i> Calculate Probability
            </button>
        </div>

        <!-- Combinations & Permutations Calculator -->
        <div id="combinationsCalculator" class="calculator-section" style="display: none;">
            <h5><i class="bi bi-diagram-3"></i> Combinations & Permutations</h5>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="totalItems" class="form-label">Total Items (n)</label>
                    <input type="number" class="form-control" id="totalItems" placeholder="10" min="0" step="1">
                    <small class="form-text text-muted">Total number of items to choose from</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="selectedItems" class="form-label">Items Selected (r)</label>
                    <input type="number" class="form-control" id="selectedItems" placeholder="3" min="0" step="1">
                    <small class="form-text text-muted">Number of items to select</small>
                </div>
            </div>

            <div class="mb-4">
                <h6>Calculation Type:</h6>
                <div class="btn-group w-100" role="group">
                    <input type="radio" class="btn-check" name="combinationType" id="combinations" value="combinations" checked>
                    <label class="btn btn-outline-primary" for="combinations">
                        Combinations (nCr)<br>
                        <small>Order doesn't matter</small>
                    </label>

                    <input type="radio" class="btn-check" name="combinationType" id="permutations" value="permutations">
                    <label class="btn btn-outline-primary" for="permutations">
                        Permutations (nPr)<br>
                        <small>Order matters</small>
                    </label>
                </div>
            </div>

            <!-- Advanced Options -->
            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="withReplacement">
                    <label class="form-check-label" for="withReplacement">
                        With replacement (items can be selected multiple times)
                    </label>
                </div>
            </div>

            <!-- Examples -->
            <div class="mb-4">
                <h6>Common Examples:</h6>
                <div class="row">
                    <div class="col-md-4">
                        <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="useCombExample('lottery')">
                            Lottery (49 choose 6)
                        </button>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="useCombExample('committee')">
                            Committee (10 choose 3)
                        </button>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="useCombExample('password')">
                            Password (26 choose 4)
                        </button>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-primary" onclick="calculateCombinations()">
                <i class="fas fa-calculator"></i> Calculate
            </button>
        </div>

        <!-- Conditional Probability Calculator -->
        <div id="conditionalCalculator" class="calculator-section" style="display: none;">
            <h5><i class="bi bi-arrow-right-circle"></i> Conditional Probability</h5>

            <div class="alert alert-info">
                <strong>P(A|B)</strong> = Probability of event A given that event B has occurred
            </div>

            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <label for="probA" class="form-label">P(A) - Probability of Event A</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="probA" placeholder="0.3" step="0.001" min="0" max="1">
                        <span class="input-group-text">or</span>
                        <input type="number" class="form-control" id="probAPercent" placeholder="30" step="0.1" min="0" max="100">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="probB" class="form-label">P(B) - Probability of Event B</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="probB" placeholder="0.5" step="0.001" min="0" max="1">
                        <span class="input-group-text">or</span>
                        <input type="number" class="form-control" id="probBPercent" placeholder="50" step="0.1" min="0" max="100">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="probAandB" class="form-label">P(A ∩ B) - Probability of Both</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="probAandB" placeholder="0.15" step="0.001" min="0" max="1">
                        <span class="input-group-text">or</span>
                        <input type="number" class="form-control" id="probAandBPercent" placeholder="15" step="0.1" min="0" max="100">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h6>What to Calculate:</h6>
                <select class="form-select" id="conditionalType">
                    <option value="a_given_b">P(A|B) - A given B has occurred</option>
                    <option value="b_given_a">P(B|A) - B given A has occurred</option>
                    <option value="bayes">Bayes' Theorem (requires prior probabilities)</option>
                </select>
            </div>

            <!-- Bayes' Theorem Additional Fields -->
            <div id="bayesFields" style="display: none;" class="mb-4">
                <h6>Additional Information for Bayes' Theorem:</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="probBgivenA" class="form-label">P(B|A) - B given A</label>
                        <input type="number" class="form-control" id="probBgivenA" placeholder="0.8" step="0.001" min="0" max="1">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="probBgivenNotA" class="form-label">P(B|¬A) - B given NOT A</label>
                        <input type="number" class="form-control" id="probBgivenNotA" placeholder="0.1" step="0.001" min="0" max="1">
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-primary" onclick="calculateConditional()">
                <i class="fas fa-calculator"></i> Calculate Conditional Probability
            </button>
        </div>

        <!-- Distribution Calculator -->
        <div id="distributionCalculator" class="calculator-section" style="display: none;">
            <h5><i class="bi bi-graph-up"></i> Probability Distributions</h5>

            <div class="mb-4">
                <label for="distributionType" class="form-label">Select Distribution:</label>
                <select class="form-select" id="distributionType" onchange="showDistributionFields()">
                    <option value="binomial">Binomial Distribution</option>
                    <option value="normal">Normal Distribution</option>
                    <option value="poisson">Poisson Distribution</option>
                    <option value="geometric">Geometric Distribution</option>
                </select>
            </div>

            <!-- Binomial Distribution -->
            <div id="binomialFields" class="distribution-fields">
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <label for="binomialN" class="form-label">Number of Trials (n)</label>
                        <input type="number" class="form-control" id="binomialN" placeholder="10" min="1" step="1">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="binomialP" class="form-label">Probability of Success (p)</label>
                        <input type="number" class="form-control" id="binomialP" placeholder="0.5" step="0.001" min="0" max="1">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="binomialK" class="form-label">Number of Successes (k)</label>
                        <input type="number" class="form-control" id="binomialK" placeholder="5" min="0" step="1">
                    </div>
                </div>
            </div>

            <!-- Normal Distribution -->
            <div id="normalFields" class="distribution-fields" style="display: none;">
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <label for="normalMean" class="form-label">Mean (μ)</label>
                        <input type="number" class="form-control" id="normalMean" placeholder="0" step="0.1">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="normalStdDev" class="form-label">Standard Deviation (σ)</label>
                        <input type="number" class="form-control" id="normalStdDev" placeholder="1" step="0.1" min="0.001">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="normalX" class="form-label">Value (x)</label>
                        <input type="number" class="form-control" id="normalX" placeholder="1" step="0.1">
                    </div>
                </div>
            </div>

            <!-- Poisson Distribution -->
            <div id="poissonFields" class="distribution-fields" style="display: none;">
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label for="poissonLambda" class="form-label">Rate Parameter (λ)</label>
                        <input type="number" class="form-control" id="poissonLambda" placeholder="3" step="0.1" min="0.001">
                        <small class="form-text text-muted">Average number of events per interval</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="poissonK" class="form-label">Number of Events (k)</label>
                        <input type="number" class="form-control" id="poissonK" placeholder="2" min="0" step="1">
                    </div>
                </div>
            </div>

            <!-- Geometric Distribution -->
            <div id="geometricFields" class="distribution-fields" style="display: none;">
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label for="geometricP" class="form-label">Probability of Success (p)</label>
                        <input type="number" class="form-control" id="geometricP" placeholder="0.2" step="0.001" min="0" max="1">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="geometricK" class="form-label">Trial Number (k)</label>
                        <input type="number" class="form-control" id="geometricK" placeholder="5" min="1" step="1">
                        <small class="form-text text-muted">First success on trial k</small>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-primary" onclick="calculateDistribution()">
                <i class="fas fa-calculator"></i> Calculate Distribution
            </button>
        </div>

        <!-- Results Container -->
        <div id="resultsContainer" style="display: none;" class="mt-4">
            <div class="card">
                <div class="card-header">
                    <h5 id="resultsTitle" class="mb-0">Probability Results</h5>
                </div>
                <div class="card-body" id="resultsContent">
                    <!-- Dynamic results will be inserted here -->
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-outline-primary" onclick="copyResults()">
                        <i class="bi bi-clipboard"></i> Copy Results
                    </button>
                    <button type="button" class="btn btn-outline-success" onclick="generateReport()">
                        <i class="bi bi-file-text"></i> Generate Report
                    </button>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-4">
            <button type="button" class="btn btn-outline-secondary" onclick="clearAll()">
                <i class="bi bi-x-circle"></i> Clear All
            </button>
            <button type="button" class="btn btn-outline-info" onclick="showProbabilityGuide()">
                <i class="bi bi-question-circle"></i> Probability Guide
            </button>
        </div>

        <!-- Probability Guide -->
        <div id="probabilityGuide" style="display: none;" class="mt-4 p-4 bg-light rounded">
            <h6><i class="bi bi-lightbulb"></i> Probability Concepts Guide</h6>
            <div class="row">
                <div class="col-md-6">
                    <h6>Basic Concepts:</h6>
                    <ul class="small">
                        <li><strong>Probability:</strong> P(A) = Favorable outcomes / Total outcomes</li>
                        <li><strong>Range:</strong> 0 ≤ P(A) ≤ 1 (or 0% to 100%)</li>
                        <li><strong>Complement:</strong> P(A') = 1 - P(A)</li>
                        <li><strong>Independent Events:</strong> P(A and B) = P(A) × P(B)</li>
                        <li><strong>Mutually Exclusive:</strong> P(A or B) = P(A) + P(B)</li>
                    </ul>

                    <h6>Combinations vs Permutations:</h6>
                    <ul class="small">
                        <li><strong>Combinations (nCr):</strong> Order doesn't matter</li>
                        <li><strong>Permutations (nPr):</strong> Order matters</li>
                        <li><strong>Formula nCr:</strong> n! / (r!(n-r)!)</li>
                        <li><strong>Formula nPr:</strong> n! / (n-r)!</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6>Conditional Probability:</h6>
                    <ul class="small">
                        <li><strong>P(A|B):</strong> Probability of A given B occurred</li>
                        <li><strong>Formula:</strong> P(A|B) = P(A∩B) / P(B)</li>
                        <li><strong>Bayes' Theorem:</strong> P(A|B) = P(B|A)P(A) / P(B)</li>
                        <li><strong>Independence:</strong> P(A|B) = P(A) if independent</li>
                    </ul>

                    <h6>Common Distributions:</h6>
                    <ul class="small">
                        <li><strong>Binomial:</strong> Fixed trials, constant probability</li>
                        <li><strong>Normal:</strong> Bell curve, continuous data</li>
                        <li><strong>Poisson:</strong> Rare events over time/space</li>
                        <li><strong>Geometric:</strong> First success in sequence</li>
                    </ul>
                </div>
            </div>

            <div class="mt-3">
                <button type="button" class="btn btn-secondary" onclick="hideProbabilityGuide()">Close</button>
            </div>
        </div>

        <!-- Quick Reference -->
        <div class="mt-4">
            <div class="row text-center">
                <div class="col-md-3">
                    <div class="p-3 border rounded">
                        <div class="h6 text-primary">50%</div>
                        <div class="small">Fair Coin</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3 border rounded">
                        <div class="h6 text-success">16.67%</div>
                        <div class="small">Single Die</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3 border rounded">
                        <div class="h6 text-info">1.92%</div>
                        <div class="small">Card Suit</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3 border rounded">
                        <div class="h6 text-warning">0.000007%</div>
                        <div class="small">Lottery 6/49</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Information Alert -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> About Probability Calculations</h6>
    <p class="mb-0">
        These calculations provide exact mathematical probabilities based on the theoretical models.
        Real-world probabilities may vary due to external factors, measurement errors, or model assumptions.
        Use these tools for educational purposes, statistical analysis, and theoretical probability calculations.
    </p>
</div>

<script>
let currentCalculationType = 'basic';
let currentResults = null;

function showCalculator(type) {
    // Hide all calculators
    document.querySelectorAll('.calculator-section').forEach(section => {
        section.style.display = 'none';
    });

    // Update button states
    document.querySelectorAll('[id^="btn"]').forEach(btn => {
        btn.classList.remove('btn-primary', 'active');
        btn.classList.add('btn-outline-primary');
    });

    // Show selected calculator
    currentCalculationType = type;

    switch(type) {
        case 'basic':
            document.getElementById('basicCalculator').style.display = 'block';
            document.getElementById('btnBasicProb').classList.remove('btn-outline-primary');
            document.getElementById('btnBasicProb').classList.add('btn-primary', 'active');
            break;
        case 'combinations':
            document.getElementById('combinationsCalculator').style.display = 'block';
            document.getElementById('btnCombinations').classList.remove('btn-outline-primary');
            document.getElementById('btnCombinations').classList.add('btn-primary', 'active');
            break;
        case 'conditional':
            document.getElementById('conditionalCalculator').style.display = 'block';
            document.getElementById('btnConditional').classList.remove('btn-outline-primary');
            document.getElementById('btnConditional').classList.add('btn-primary', 'active');
            break;
        case 'distribution':
            document.getElementById('distributionCalculator').style.display = 'block';
            document.getElementById('btnDistribution').classList.remove('btn-outline-primary');
            document.getElementById('btnDistribution').classList.add('btn-primary', 'active');
            showDistributionFields();
            break;
    }

    // Hide previous results
    document.getElementById('resultsContainer').style.display = 'none';
}

function useBasicExample(type) {
    const examples = {
        'dice': { favorable: 1, total: 6 },
        'coin': { favorable: 1, total: 2 },
        'card': { favorable: 13, total: 52 }
    };

    const example = examples[type];
    document.getElementById('favorableOutcomes').value = example.favorable;
    document.getElementById('totalOutcomes').value = example.total;
    document.getElementById('multipleEvents').checked = false;
    document.getElementById('multipleEventsSection').style.display = 'none';
}

function useCombExample(type) {
    const examples = {
        'lottery': { n: 49, r: 6, combinations: true },
        'committee': { n: 10, r: 3, combinations: true },
        'password': { n: 26, r: 4, combinations: false }
    };

    const example = examples[type];
    document.getElementById('totalItems').value = example.n;
    document.getElementById('selectedItems').value = example.r;

    if (example.combinations) {
        document.getElementById('combinations').checked = true;
    } else {
        document.getElementById('permutations').checked = true;
    }
}

// Handle multiple events checkbox
document.getElementById('multipleEvents').addEventListener('change', function() {
    const section = document.getElementById('multipleEventsSection');
    section.style.display = this.checked ? 'block' : 'none';
});

// Handle conditional probability type change
document.getElementById('conditionalType').addEventListener('change', function() {
    const bayesFields = document.getElementById('bayesFields');
    bayesFields.style.display = this.value === 'bayes' ? 'block' : 'none';
});

// Sync probability inputs (decimal and percentage)
function setupProbabilitySync() {
    const pairs = [
        ['probA', 'probAPercent'],
        ['probB', 'probBPercent'],
        ['probAandB', 'probAandBPercent']
    ];

    pairs.forEach(([decimalId, percentId]) => {
        document.getElementById(decimalId).addEventListener('input', function() {
            if (this.value) {
                document.getElementById(percentId).value = (parseFloat(this.value) * 100).toFixed(1);
            }
        });

        document.getElementById(percentId).addEventListener('input', function() {
            if (this.value) {
                document.getElementById(decimalId).value = (parseFloat(this.value) / 100).toFixed(3);
            }
        });
    });
}

function showDistributionFields() {
    // Hide all distribution fields
    document.querySelectorAll('.distribution-fields').forEach(field => {
        field.style.display = 'none';
    });

    // Show selected distribution fields
    const type = document.getElementById('distributionType').value;
    document.getElementById(type + 'Fields').style.display = 'block';
}

function calculateBasicProbability() {
    const favorable = parseInt(document.getElementById('favorableOutcomes').value);
    const total = parseInt(document.getElementById('totalOutcomes').value);
    const multipleEvents = document.getElementById('multipleEvents').checked;

    if (favorable === undefined || !total || favorable < 0 || total < 1) {
        alert('Please enter valid values for outcomes.');
        return;
    }

    if (favorable > total) {
        alert('Favorable outcomes cannot exceed total outcomes.');
        return;
    }

    const probability = favorable / total;
    let results = {
        type: 'basic',
        favorable: favorable,
        total: total,
        probability: probability,
        percentage: probability * 100,
        odds: total - favorable > 0 ? favorable / (total - favorable) : Infinity,
        complement: 1 - probability
    };

    // Handle multiple events
    if (multipleEvents) {
        const event2Favorable = parseInt(document.getElementById('event2Favorable').value);
        const event2Total = parseInt(document.getElementById('event2Total').value);
        const relation = document.getElementById('eventRelation').value;

        if (event2Favorable !== undefined && event2Total) {
            const prob2 = event2Favorable / event2Total;
            let combinedProbability;

            switch(relation) {
                case 'independent':
                    combinedProbability = probability * prob2;
                    break;
                case 'mutually_exclusive':
                    combinedProbability = probability + prob2;
                    break;
                case 'dependent':
                    // Simplified dependent calculation
                    combinedProbability = probability * (prob2 * 0.9); // Approximation
                    break;
            }

            results.multipleEvents = {
                event2: { favorable: event2Favorable, total: event2Total, probability: prob2 },
                relation: relation,
                combinedProbability: combinedProbability,
                combinedPercentage: combinedProbability * 100
            };
        }
    }

    currentResults = results;
    displayBasicResults(results);
}

function displayBasicResults(results) {
    let content = `
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="text-center p-3 bg-primary text-white rounded">
                    <h5>${results.probability.toFixed(4)}</h5>
                    <small>Probability (decimal)</small>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="text-center p-3 bg-success text-white rounded">
                    <h5>${results.percentage.toFixed(2)}%</h5>
                    <small>Probability (percentage)</small>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="text-center p-3 bg-info text-white rounded">
                    <h5>${results.odds === Infinity ? '∞:1' : results.odds.toFixed(2) + ':1'}</h5>
                    <small>Odds in favor</small>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="text-center p-3 bg-warning text-dark rounded">
                    <h5>${(results.complement * 100).toFixed(2)}%</h5>
                    <small>Complement (NOT occurring)</small>
                </div>
            </div>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-striped">
                <tr><th width="40%">Favorable Outcomes</th><td>${results.favorable}</td></tr>
                <tr><th>Total Possible Outcomes</th><td>${results.total}</td></tr>
                <tr><th>Probability Formula</th><td>P = ${results.favorable}/${results.total} = ${results.probability.toFixed(4)}</td></tr>
                <tr><th>Odds Against</th><td>${results.odds === Infinity ? '1:∞' : (1/results.odds).toFixed(2) + ':1'}</td></tr>
            </table>
        </div>
    `;

    if (results.multipleEvents) {
        const me = results.multipleEvents;
        content += `
            <div class="mt-4">
                <h6>Multiple Events Analysis:</h6>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr><th width="30%">Event 1 Probability</th><td>${results.percentage.toFixed(2)}%</td></tr>
                        <tr><th>Event 2 Probability</th><td>${(me.event2.probability * 100).toFixed(2)}%</td></tr>
                        <tr><th>Relationship</th><td>${me.relation.replace('_', ' ')}</td></tr>
                        <tr class="table-success"><th><strong>Combined Probability</strong></th><td><strong>${me.combinedPercentage.toFixed(2)}%</strong></td></tr>
                    </table>
                </div>
            </div>
        `;
    }

    document.getElementById('resultsTitle').textContent = 'Basic Probability Results';
    document.getElementById('resultsContent').innerHTML = content;
    document.getElementById('resultsContainer').style.display = 'block';
}

function calculateCombinations() {
    const n = parseInt(document.getElementById('totalItems').value);
    const r = parseInt(document.getElementById('selectedItems').value);
    const type = document.querySelector('input[name="combinationType"]:checked').value;
    const withReplacement = document.getElementById('withReplacement').checked;

    if (!n || !r || r < 0 || n < 0) {
        alert('Please enter valid positive numbers.');
        return;
    }

    if (!withReplacement && r > n) {
        alert('Selected items cannot exceed total items (without replacement).');
        return;
    }

    let result;
    let formula;

    if (withReplacement) {
        if (type === 'combinations') {
            // Combinations with replacement: C(n+r-1, r)
            result = combination(n + r - 1, r);
            formula = `C(${n}+${r}-1, ${r}) = C(${n+r-1}, ${r})`;
        } else {
            // Permutations with replacement: n^r
            result = Math.pow(n, r);
            formula = `${n}^${r}`;
        }
    } else {
        if (type === 'combinations') {
            result = combination(n, r);
            formula = `C(${n}, ${r}) = ${n}!/(${r}!(${n}-${r})!)`;
        } else {
            result = permutation(n, r);
            formula = `P(${n}, ${r}) = ${n}!/(${n}-${r})!`;
        }
    }

    currentResults = {
        type: 'combinations',
        n: n,
        r: r,
        calculationType: type,
        withReplacement: withReplacement,
        result: result,
        formula: formula
    };

    displayCombinationResults(currentResults);
}

function combination(n, r) {
    return factorial(n) / (factorial(r) * factorial(n - r));
}

function permutation(n, r) {
    return factorial(n) / factorial(n - r);
}

function factorial(n) {
    if (n <= 1) return 1;
    let result = 1;
    for (let i = 2; i <= n; i++) {
        result *= i;
    }
    return result;
}

function displayCombinationResults(results) {
    const content = `
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="text-center p-3 bg-primary text-white rounded">
                    <h5>${results.result.toLocaleString()}</h5>
                    <small>${results.calculationType === 'combinations' ? 'Combinations' : 'Permutations'}</small>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="text-center p-3 bg-success text-white rounded">
                    <h5>${results.n}</h5>
                    <small>Total Items</small>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="text-center p-3 bg-info text-white rounded">
                    <h5>${results.r}</h5>
                    <small>Items Selected</small>
                </div>
            </div>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-striped">
                <tr><th width="40%">Calculation Type</th><td>${results.calculationType === 'combinations' ? 'Combinations (nCr)' : 'Permutations (nPr)'}</td></tr>
                <tr><th>Total Items (n)</th><td>${results.n}</td></tr>
                <tr><th>Items Selected (r)</th><td>${results.r}</td></tr>
                <tr><th>With Replacement</th><td>${results.withReplacement ? 'Yes' : 'No'}</td></tr>
                <tr><th>Formula</th><td>${results.formula}</td></tr>
                <tr class="table-success"><th><strong>Result</strong></th><td><strong>${results.result.toLocaleString()}</strong></td></tr>
            </table>
        </div>

        <div class="mt-4">
            <div class="alert alert-info">
                <strong>Interpretation:</strong><br>
                ${results.calculationType === 'combinations' ?
                    'There are ' + results.result.toLocaleString() + ' ways to choose ' + results.r + ' items from ' + results.n + ' items where order doesn\'t matter.' :
                    'There are ' + results.result.toLocaleString() + ' ways to arrange ' + results.r + ' items from ' + results.n + ' items where order matters.'
                }
                ${results.withReplacement ? ' Items can be selected multiple times.' : ' Each item can only be selected once.'}
            </div>
        </div>
    `;

    document.getElementById('resultsTitle').textContent = results.calculationType === 'combinations' ? 'Combinations Results' : 'Permutations Results';
    document.getElementById('resultsContent').innerHTML = content;
    document.getElementById('resultsContainer').style.display = 'block';
}

function calculateConditional() {
    const probA = parseFloat(document.getElementById('probA').value) || parseFloat(document.getElementById('probAPercent').value) / 100;
    const probB = parseFloat(document.getElementById('probB').value) || parseFloat(document.getElementById('probBPercent').value) / 100;
    const probAandB = parseFloat(document.getElementById('probAandB').value) || parseFloat(document.getElementById('probAandBPercent').value) / 100;
    const calcType = document.getElementById('conditionalType').value;

    if (!probA || !probB || (calcType !== 'bayes' && !probAandB)) {
        alert('Please fill in the required probability values.');
        return;
    }

    let result;
    let explanation;

    switch(calcType) {
        case 'a_given_b':
            if (probB === 0) {
                alert('P(B) cannot be zero for conditional probability.');
                return;
            }
            result = probAandB / probB;
            explanation = `P(A|B) = P(A∩B) / P(B) = ${probAandB.toFixed(3)} / ${probB.toFixed(3)} = ${result.toFixed(4)}`;
            break;

        case 'b_given_a':
            if (probA === 0) {
                alert('P(A) cannot be zero for conditional probability.');
                return;
            }
            result = probAandB / probA;
            explanation = `P(B|A) = P(A∩B) / P(A) = ${probAandB.toFixed(3)} / ${probA.toFixed(3)} = ${result.toFixed(4)}`;
            break;

        case 'bayes':
            const probBgivenA = parseFloat(document.getElementById('probBgivenA').value);
            const probBgivenNotA = parseFloat(document.getElementById('probBgivenNotA').value);

            if (!probBgivenA || probBgivenNotA === undefined) {
                alert('Please fill in the additional Bayes theorem values.');
                return;
            }

            const probNotA = 1 - probA;
            const probBTotal = probBgivenA * probA + probBgivenNotA * probNotA;

            if (probBTotal === 0) {
                alert('Total probability of B cannot be zero.');
                return;
            }

            result = (probBgivenA * probA) / probBTotal;
            explanation = `P(A|B) = [P(B|A) × P(A)] / P(B) = [${probBgivenA} × ${probA}] / ${probBTotal.toFixed(4)} = ${result.toFixed(4)}`;
            break;
    }

    currentResults = {
        type: 'conditional',
        calcType: calcType,
        probA: probA,
        probB: probB,
        probAandB: probAandB,
        result: result,
        explanation: explanation
    };

    displayConditionalResults(currentResults);
}

function displayConditionalResults(results) {
    const typeNames = {
        'a_given_b': 'P(A|B) - A given B',
        'b_given_a': 'P(B|A) - B given A',
        'bayes': 'Bayes\' Theorem - P(A|B)'
    };

    const content = `
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="text-center p-3 bg-primary text-white rounded">
                    <h5>${results.result.toFixed(4)}</h5>
                    <small>Conditional Probability</small>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="text-center p-3 bg-success text-white rounded">
                    <h5>${(results.result * 100).toFixed(2)}%</h5>
                    <small>As Percentage</small>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="text-center p-3 bg-info text-white rounded">
                    <h5>${results.result > 0 ? (results.result / (1 - results.result)).toFixed(2) + ':1' : '0:1'}</h5>
                    <small>Odds</small>
                </div>
            </div>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-striped">
                <tr><th width="40%">Calculation Type</th><td>${typeNames[results.calcType]}</td></tr>
                <tr><th>P(A)</th><td>${results.probA.toFixed(4)} (${(results.probA * 100).toFixed(2)}%)</td></tr>
                <tr><th>P(B)</th><td>${results.probB.toFixed(4)} (${(results.probB * 100).toFixed(2)}%)</td></tr>
                ${results.probAandB ? `<tr><th>P(A∩B)</th><td>${results.probAandB.toFixed(4)} (${(results.probAandB * 100).toFixed(2)}%)</td></tr>` : ''}
                <tr class="table-success"><th><strong>Result</strong></th><td><strong>${results.result.toFixed(4)} (${(results.result * 100).toFixed(2)}%)</strong></td></tr>
            </table>
        </div>

        <div class="mt-4">
            <div class="alert alert-info">
                <strong>Calculation:</strong><br>
                ${results.explanation}
            </div>
        </div>
    `;

    document.getElementById('resultsTitle').textContent = 'Conditional Probability Results';
    document.getElementById('resultsContent').innerHTML = content;
    document.getElementById('resultsContainer').style.display = 'block';
}

function calculateDistribution() {
    const type = document.getElementById('distributionType').value;
    let result, explanation;

    switch(type) {
        case 'binomial':
            const n = parseInt(document.getElementById('binomialN').value);
            const p = parseFloat(document.getElementById('binomialP').value);
            const k = parseInt(document.getElementById('binomialK').value);

            if (!n || !p || k === undefined || n < 1 || p < 0 || p > 1 || k < 0 || k > n) {
                alert('Please enter valid binomial parameters.');
                return;
            }

            result = binomialProbability(n, k, p);
            explanation = `P(X = ${k}) where X ~ Binomial(${n}, ${p})`;
            break;

        case 'normal':
            const mean = parseFloat(document.getElementById('normalMean').value) || 0;
            const stdDev = parseFloat(document.getElementById('normalStdDev').value);
            const x = parseFloat(document.getElementById('normalX').value) || 0;

            if (!stdDev || stdDev <= 0) {
                alert('Please enter a valid standard deviation (> 0).');
                return;
            }

            result = normalPDF(x, mean, stdDev);
            explanation = `f(${x}) where X ~ Normal(${mean}, ${stdDev}²)`;
            break;

        case 'poisson':
            const lambda = parseFloat(document.getElementById('poissonLambda').value);
            const poissonK = parseInt(document.getElementById('poissonK').value);

            if (!lambda || poissonK === undefined || lambda <= 0 || poissonK < 0) {
                alert('Please enter valid Poisson parameters.');
                return;
            }

            result = poissonProbability(lambda, poissonK);
            explanation = `P(X = ${poissonK}) where X ~ Poisson(${lambda})`;
            break;

        case 'geometric':
            const geomP = parseFloat(document.getElementById('geometricP').value);
            const geomK = parseInt(document.getElementById('geometricK').value);

            if (!geomP || !geomK || geomP <= 0 || geomP > 1 || geomK < 1) {
                alert('Please enter valid geometric parameters.');
                return;
            }

            result = geometricProbability(geomP, geomK);
            explanation = `P(X = ${geomK}) where X ~ Geometric(${geomP})`;
            break;
    }

    currentResults = {
        type: 'distribution',
        distributionType: type,
        result: result,
        explanation: explanation
    };

    displayDistributionResults(currentResults);
}

function binomialProbability(n, k, p) {
    return combination(n, k) * Math.pow(p, k) * Math.pow(1 - p, n - k);
}

function normalPDF(x, mean, stdDev) {
    const coefficient = 1 / (stdDev * Math.sqrt(2 * Math.PI));
    const exponent = -0.5 * Math.pow((x - mean) / stdDev, 2);
    return coefficient * Math.exp(exponent);
}

function poissonProbability(lambda, k) {
    return (Math.pow(lambda, k) * Math.exp(-lambda)) / factorial(k);
}

function geometricProbability(p, k) {
    return Math.pow(1 - p, k - 1) * p;
}

function displayDistributionResults(results) {
    const distributionNames = {
        'binomial': 'Binomial Distribution',
        'normal': 'Normal Distribution',
        'poisson': 'Poisson Distribution',
        'geometric': 'Geometric Distribution'
    };

    const content = `
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="text-center p-3 bg-primary text-white rounded">
                    <h5>${results.result.toFixed(6)}</h5>
                    <small>Probability/Density</small>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="text-center p-3 bg-success text-white rounded">
                    <h5>${(results.result * 100).toFixed(4)}%</h5>
                    <small>As Percentage</small>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="text-center p-3 bg-info text-white rounded">
                    <h5>${distributionNames[results.distributionType].split(' ')[0]}</h5>
                    <small>Distribution Type</small>
                </div>
            </div>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-striped">
                <tr><th width="40%">Distribution</th><td>${distributionNames[results.distributionType]}</td></tr>
                <tr><th>Calculation</th><td>${results.explanation}</td></tr>
                <tr class="table-success"><th><strong>Result</strong></th><td><strong>${results.result.toFixed(6)}</strong></td></tr>
            </table>
        </div>

        <div class="mt-4">
            <div class="alert alert-info">
                <strong>Note:</strong>
                ${results.distributionType === 'normal' ?
                    'This is the probability density value. For discrete probabilities, use cumulative distribution or probability mass functions.' :
                    'This is the exact probability for the specified parameters.'
                }
            </div>
        </div>
    `;

    document.getElementById('resultsTitle').textContent = distributionNames[results.distributionType] + ' Results';
    document.getElementById('resultsContent').innerHTML = content;
    document.getElementById('resultsContainer').style.display = 'block';
}

function clearAll() {
    // Clear all input fields
    document.querySelectorAll('input, select').forEach(input => {
        if (input.type === 'checkbox' || input.type === 'radio') {
            input.checked = input.hasAttribute('checked') || input.id === 'combinations';
        } else {
            input.value = '';
        }
    });

    // Reset to basic calculator
    showCalculator('basic');

    // Hide sections
    document.getElementById('multipleEventsSection').style.display = 'none';
    document.getElementById('bayesFields').style.display = 'none';
    document.getElementById('resultsContainer').style.display = 'none';
    document.getElementById('probabilityGuide').style.display = 'none';

    currentResults = null;
}

function copyResults() {
    if (!currentResults) return;

    let textToCopy = '';

    switch(currentResults.type) {
        case 'basic':
            textToCopy = `Basic Probability Results:
Favorable Outcomes: ${currentResults.favorable}
Total Outcomes: ${currentResults.total}
Probability: ${currentResults.probability.toFixed(4)} (${currentResults.percentage.toFixed(2)}%)
Complement: ${(currentResults.complement * 100).toFixed(2)}%`;
            break;
        case 'combinations':
            textToCopy = `${currentResults.calculationType === 'combinations' ? 'Combinations' : 'Permutations'} Results:
Total Items: ${currentResults.n}
Selected Items: ${currentResults.r}
Result: ${currentResults.result.toLocaleString()}
Formula: ${currentResults.formula}`;
            break;
        case 'conditional':
            textToCopy = `Conditional Probability Results:
P(A): ${currentResults.probA.toFixed(4)}
P(B): ${currentResults.probB.toFixed(4)}
Result: ${currentResults.result.toFixed(4)} (${(currentResults.result * 100).toFixed(2)}%)
${currentResults.explanation}`;
            break;
        case 'distribution':
            textToCopy = `Distribution Results:
Type: ${currentResults.distributionType}
Calculation: ${currentResults.explanation}
Result: ${currentResults.result.toFixed(6)}`;
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

function generateReport() {
    if (!currentResults) return;

    alert('Report generation would create a detailed statistical report with formulas, interpretations, and visualizations.');
}

function showProbabilityGuide() {
    document.getElementById('probabilityGuide').style.display = 'block';
}

function hideProbabilityGuide() {
    document.getElementById('probabilityGuide').style.display = 'none';
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    showCalculator('basic');
    setupProbabilitySync();
});
</script>
