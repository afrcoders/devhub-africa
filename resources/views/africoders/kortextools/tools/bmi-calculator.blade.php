<div class="row">
    <div class="col-md-12">
        <!-- Unit System Selection -->
        <div class="mb-4">
            <label class="form-label">Unit System</label>
            <div class="btn-group w-100" role="group">
                <input type="radio" class="btn-check" name="unit-system" id="metric" value="metric" checked>
                <label class="btn btn-outline-primary" for="metric">
                    <i class="bi bi-globe"></i> Metric (cm, kg)
                </label>

                <input type="radio" class="btn-check" name="unit-system" id="imperial" value="imperial">
                <label class="btn btn-outline-primary" for="imperial">
                    <i class="bi bi-flag-usa"></i> Imperial (ft/in, lbs)
                </label>
            </div>
        </div>

        <!-- Metric Inputs -->
        <div id="metric-inputs">
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="height-cm" class="form-label">Height (cm)</label>
                    <input type="number" class="form-control" id="height-cm" placeholder="e.g., 175" min="50" max="300" step="0.1">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="weight-kg" class="form-label">Weight (kg)</label>
                    <input type="number" class="form-control" id="weight-kg" placeholder="e.g., 70" min="20" max="500" step="0.1">
                </div>
            </div>
        </div>

        <!-- Imperial Inputs -->
        <div id="imperial-inputs" style="display: none;">
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <label for="height-ft" class="form-label">Height (feet)</label>
                    <input type="number" class="form-control" id="height-ft" placeholder="e.g., 5" min="3" max="8" step="1">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="height-in" class="form-label">Height (inches)</label>
                    <input type="number" class="form-control" id="height-in" placeholder="e.g., 9" min="0" max="11" step="1">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="weight-lbs" class="form-label">Weight (lbs)</label>
                    <input type="number" class="form-control" id="weight-lbs" placeholder="e.g., 154" min="50" max="1000" step="0.1">
                </div>
            </div>
        </div>

        <!-- Optional: Age and Gender for more detailed results -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label for="age" class="form-label">Age (optional)</label>
                <input type="number" class="form-control" id="age" placeholder="e.g., 30" min="1" max="120">
            </div>
            <div class="col-md-6 mb-3">
                <label for="gender" class="form-label">Gender (optional)</label>
                <select class="form-select" id="gender">
                    <option value="">Select gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
        </div>

        <!-- Calculate Button -->
        <div class="mb-4">
            <button type="button" class="btn btn-primary" onclick="calculateBMI()">
                <i class="fas fa-calculator"></i> Calculate BMI
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="clearAll()">
                <i class="bi bi-x-circle"></i> Clear
            </button>
        </div>

        <!-- Results Section -->
        <div id="resultsContainer" style="display: none;">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="text-center p-4 rounded" id="bmi-card">
                        <h2 id="bmi-value" class="mb-1">0.0</h2>
                        <span>BMI</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-center p-4 bg-info text-white rounded">
                        <h5 id="bmi-category" class="mb-1">Normal</h5>
                        <span>Category</span>
                    </div>
                </div>
            </div>

            <!-- BMI Scale -->
            <div class="mb-4">
                <h6>BMI Scale</h6>
                <div class="bmi-scale">
                    <div class="scale-item underweight">
                        <div class="scale-bar"></div>
                        <span>Underweight (&lt;18.5)</span>
                    </div>
                    <div class="scale-item normal">
                        <div class="scale-bar"></div>
                        <span>Normal (18.5 - 24.9)</span>
                    </div>
                    <div class="scale-item overweight">
                        <div class="scale-bar"></div>
                        <span>Overweight (25.0 - 29.9)</span>
                    </div>
                    <div class="scale-item obese">
                        <div class="scale-bar"></div>
                        <span>Obese (≥30.0)</span>
                    </div>
                </div>
            </div>

            <!-- Detailed Information -->
            <div class="table-responsive mb-4">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th width="40%">BMI Formula</th>
                            <td>Weight (kg) / Height² (m²)</td>
                        </tr>
                        <tr>
                            <th>Your Calculation</th>
                            <td id="calculation">-</td>
                        </tr>
                        <tr>
                            <th>Health Risk Level</th>
                            <td id="health-risk">-</td>
                        </tr>
                        <tr id="ideal-weight-range" style="display: none;">
                            <th>Ideal Weight Range</th>
                            <td id="ideal-weight">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Health Recommendations -->
            <div id="recommendations" class="alert alert-info">
                <h6><i class="bi bi-info-circle"></i> Health Recommendations</h6>
                <p id="recommendation-text">Maintain a balanced diet and regular exercise routine.</p>
            </div>

            <div class="mt-3">
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="copyResults()">
                    <i class="bi bi-clipboard"></i> Copy Results
                </button>
            </div>
        </div>

        <!-- Quick Examples -->
        <div class="mt-4">
            <h6>Quick Examples:</h6>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('metric', 175, 70)">
                    175cm, 70kg
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('metric', 160, 55)">
                    160cm, 55kg
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('imperial', [5, 9], 154)">
                    5'9", 154lbs
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="useExample('imperial', [6, 0], 180)">
                    6'0", 180lbs
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Information -->
<div class="alert alert-warning mt-4">
    <h6><i class="bi bi-exclamation-triangle"></i> Medical Disclaimer</h6>
    <p class="mb-0">
        This BMI calculator is for informational purposes only and should not be used as a substitute for
        professional medical advice. BMI may not be accurate for athletes, pregnant women, elderly, or
        children. Consult with a healthcare professional for personalized health assessments.
    </p>
</div>

<style>
.btn-check:checked + .btn-outline-primary {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
    color: white;
}

.bmi-scale {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 20px;
}

.scale-item {
    display: flex;
    align-items: center;
    gap: 10px;
}

.scale-bar {
    width: 100px;
    height: 20px;
    border-radius: 4px;
}

.underweight .scale-bar {
    background-color: #17a2b8;
}

.normal .scale-bar {
    background-color: #28a745;
}

.overweight .scale-bar {
    background-color: #ffc107;
}

.obese .scale-bar {
    background-color: #dc3545;
}

.scale-item.active .scale-bar {
    box-shadow: 0 0 0 3px rgba(0,123,255,0.25);
    border: 2px solid #007bff;
}
</style>

<script>
// Unit system change handler
document.querySelectorAll('input[name="unit-system"]').forEach(radio => {
    radio.addEventListener('change', toggleUnitSystem);
});

function toggleUnitSystem() {
    const isMetric = document.getElementById('metric').checked;

    document.getElementById('metric-inputs').style.display = isMetric ? 'block' : 'none';
    document.getElementById('imperial-inputs').style.display = isMetric ? 'none' : 'block';

    // Clear results when switching units
    document.getElementById('resultsContainer').style.display = 'none';
}

function calculateBMI() {
    const isMetric = document.getElementById('metric').checked;
    let height, weight;

    if (isMetric) {
        height = parseFloat(document.getElementById('height-cm').value);
        weight = parseFloat(document.getElementById('weight-kg').value);

        if (!height || !weight) {
            alert('Please enter both height and weight.');
            return;
        }

        // Convert cm to meters
        height = height / 100;
    } else {
        const feet = parseFloat(document.getElementById('height-ft').value);
        const inches = parseFloat(document.getElementById('height-in').value) || 0;
        const lbs = parseFloat(document.getElementById('weight-lbs').value);

        if (!feet || !lbs) {
            alert('Please enter both height and weight.');
            return;
        }

        // Convert to metric
        height = ((feet * 12) + inches) * 0.0254; // Convert to meters
        weight = lbs * 0.453592; // Convert to kg
    }

    // Calculate BMI
    const bmi = weight / (height * height);
    const category = getBMICategory(bmi);
    const age = parseInt(document.getElementById('age').value);
    const gender = document.getElementById('gender').value;

    // Display results
    displayResults(bmi, category, height, weight, age, gender, isMetric);
}

function getBMICategory(bmi) {
    if (bmi < 18.5) return 'underweight';
    if (bmi < 25) return 'normal';
    if (bmi < 30) return 'overweight';
    return 'obese';
}

function displayResults(bmi, category, height, weight, age, gender, isMetric) {
    // Update BMI value and category
    document.getElementById('bmi-value').textContent = bmi.toFixed(1);

    const categoryNames = {
        'underweight': 'Underweight',
        'normal': 'Normal Weight',
        'overweight': 'Overweight',
        'obese': 'Obese'
    };

    document.getElementById('bmi-category').textContent = categoryNames[category];

    // Color-code BMI card
    const bmiCard = document.getElementById('bmi-card');
    bmiCard.className = 'text-center p-4 rounded text-white bg-' +
        (category === 'underweight' ? 'info' :
         category === 'normal' ? 'success' :
         category === 'overweight' ? 'warning' : 'danger');

    // Update scale highlighting
    document.querySelectorAll('.scale-item').forEach(item => {
        item.classList.remove('active');
    });
    document.querySelector('.scale-item.' + category).classList.add('active');

    // Update calculation display
    const heightDisplay = isMetric ? (height * 100).toFixed(1) + ' cm' :
        Math.floor(height / 0.3048) + "'" + Math.round((height % 0.3048) / 0.0254) + '"';
    const weightDisplay = isMetric ? weight.toFixed(1) + ' kg' : (weight / 0.453592).toFixed(1) + ' lbs';

    document.getElementById('calculation').textContent =
        `${weight.toFixed(1)} kg ÷ (${height.toFixed(2)} m)² = ${bmi.toFixed(1)}`;

    // Health risk assessment
    const healthRisks = {
        'underweight': 'Increased risk of malnutrition, osteoporosis, and decreased immune function',
        'normal': 'Lowest risk of weight-related health problems',
        'overweight': 'Increased risk of cardiovascular disease, diabetes, and high blood pressure',
        'obese': 'High risk of serious health conditions including heart disease, stroke, and diabetes'
    };

    document.getElementById('health-risk').textContent = healthRisks[category];

    // Calculate ideal weight range (BMI 18.5-24.9)
    const minIdealWeight = 18.5 * (height * height);
    const maxIdealWeight = 24.9 * (height * height);

    const idealWeightDisplay = isMetric ?
        `${minIdealWeight.toFixed(1)} - ${maxIdealWeight.toFixed(1)} kg` :
        `${(minIdealWeight / 0.453592).toFixed(1)} - ${(maxIdealWeight / 0.453592).toFixed(1)} lbs`;

    document.getElementById('ideal-weight').textContent = idealWeightDisplay;
    document.getElementById('ideal-weight-range').style.display = 'table-row';

    // Recommendations
    const recommendations = {
        'underweight': 'Consider consulting with a healthcare provider or nutritionist to develop a healthy weight gain plan. Focus on nutrient-dense foods and strength training.',
        'normal': 'Maintain your current healthy lifestyle with balanced nutrition and regular physical activity. Keep up the good work!',
        'overweight': 'Consider adopting a balanced diet and increasing physical activity. Small, sustainable changes can lead to healthy weight loss.',
        'obese': 'Consult with healthcare professionals for a comprehensive weight management plan. Consider medical evaluation and supervised weight loss program.'
    };

    document.getElementById('recommendation-text').textContent = recommendations[category];

    document.getElementById('resultsContainer').style.display = 'block';
}

function useExample(system, height, weight) {
    if (system === 'metric') {
        document.getElementById('metric').checked = true;
        document.getElementById('height-cm').value = height;
        document.getElementById('weight-kg').value = weight;
    } else {
        document.getElementById('imperial').checked = true;
        document.getElementById('height-ft').value = height[0];
        document.getElementById('height-in').value = height[1];
        document.getElementById('weight-lbs').value = weight;
    }

    toggleUnitSystem();
    calculateBMI();
}

function clearAll() {
    document.getElementById('height-cm').value = '';
    document.getElementById('weight-kg').value = '';
    document.getElementById('height-ft').value = '';
    document.getElementById('height-in').value = '';
    document.getElementById('weight-lbs').value = '';
    document.getElementById('age').value = '';
    document.getElementById('gender').value = '';
    document.getElementById('resultsContainer').style.display = 'none';
}

function copyResults() {
    const bmi = document.getElementById('bmi-value').textContent;
    const category = document.getElementById('bmi-category').textContent;
    const calculation = document.getElementById('calculation').textContent;
    const textToCopy = `BMI: ${bmi}\\nCategory: ${category}\\nCalculation: ${calculation}`;

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

// Auto-calculate when values change (with debounce)
let calculateTimeout;
function debounceCalculate() {
    clearTimeout(calculateTimeout);
    calculateTimeout = setTimeout(() => {
        const isMetric = document.getElementById('metric').checked;
        const hasValues = isMetric ?
            (document.getElementById('height-cm').value && document.getElementById('weight-kg').value) :
            (document.getElementById('height-ft').value && document.getElementById('weight-lbs').value);

        if (hasValues) {
            calculateBMI();
        }
    }, 500);
}

// Add event listeners for auto-calculation
document.getElementById('height-cm').addEventListener('input', debounceCalculate);
document.getElementById('weight-kg').addEventListener('input', debounceCalculate);
document.getElementById('height-ft').addEventListener('input', debounceCalculate);
document.getElementById('height-in').addEventListener('input', debounceCalculate);
document.getElementById('weight-lbs').addEventListener('input', debounceCalculate);
</script>
