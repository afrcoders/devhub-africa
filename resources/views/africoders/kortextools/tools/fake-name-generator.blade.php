{{-- fake name generator --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    fake name generator tool for your development and productivity needs.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-user-secret me-3"></i>Fake Name Generator
                </h1>
                <p class="lead text-muted">
                    Generate random fake names for testing, development, and privacy protection
                </p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Name Generation Options</h5>
                </div>
                <div class="card-body">
                    <form id="nameGeneratorForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gender" class="form-label fw-semibold">
                                        <i class="fas fa-user me-2"></i>Gender
                                    </label>
                                    <select class="form-select" id="gender">
                                        <option value="random">Random</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nameCount" class="form-label fw-semibold">
                                        <i class="fas fa-hashtag me-2"></i>Number of Names
                                    </label>
                                    <select class="form-select" id="nameCount">
                                        <option value="1">1</option>
                                        <option value="5" selected>5</option>
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nameFormat" class="form-label fw-semibold">
                                        <i class="fas fa-format-text me-2"></i>Name Format
                                    </label>
                                    <select class="form-select" id="nameFormat">
                                        <option value="full">First + Last Name</option>
                                        <option value="first">First Name Only</option>
                                        <option value="last">Last Name Only</option>
                                        <option value="middle">First + Middle + Last</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nationality" class="form-label fw-semibold">
                                        <i class="fas fa-globe me-2"></i>Nationality/Origin
                                    </label>
                                    <select class="form-select" id="nationality">
                                        <option value="mixed">Mixed/International</option>
                                        <option value="american">American</option>
                                        <option value="british">British</option>
                                        <option value="spanish">Spanish</option>
                                        <option value="french">French</option>
                                        <option value="german">German</option>
                                        <option value="italian">Italian</option>
                                        <option value="japanese">Japanese</option>
                                        <option value="chinese">Chinese</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="includeInitials">
                                <label class="form-check-label" for="includeInitials">
                                    Include middle initials
                                </label>
                            </div>
                        </div>

                        <div class="text-center mb-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-magic me-2"></i>Generate Names
                            </button>
                            <button type="button" id="clearBtn" class="btn btn-outline-secondary btn-lg ms-3">
                                <i class="fas fa-trash-alt me-2"></i>Clear
                            </button>
                        </div>
                    </form>

                    <div id="resultSection" style="display: none;">
                        <div class="border-top pt-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h6 class="fw-semibold mb-0">
                                    <i class="fas fa-list me-2"></i>Generated Names (<span id="nameCounter">0</span>)
                                </h6>
                                <div class="btn-group" role="group">
                                    <button type="button" id="copyBtn" class="btn btn-success btn-sm">
                                        <i class="fas fa-copy me-1"></i>Copy All
                                    </button>
                                    <button type="button" id="downloadBtn" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-download me-1"></i>Download
                                    </button>
                                </div>
                            </div>

                            <div class="bg-light p-4 rounded" style="max-height: 400px; overflow-y: auto;">
                                <div id="namesList" style="font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;">
                                    <!-- Generated names will appear here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="card-title text-primary">
                                <i class="fas fa-shield-alt me-2"></i>Privacy Safe
                            </h6>
                            <p class="card-text small">
                                All names are randomly generated and not associated
                                with real individuals. Safe for testing and development.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="card-title text-primary">
                                <i class="fas fa-lightbulb me-2"></i>Use Cases
                            </h6>
                            <ul class="small mb-0">
                                <li>Software testing</li>
                                <li>Database population</li>
                                <li>Privacy protection</li>
                                <li>Demo applications</li>
                                <li>Form testing</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="card-title text-primary">
                                <i class="fas fa-cogs me-2"></i>Features
                            </h6>
                            <ul class="small mb-0">
                                <li>Multiple name formats</li>
                                <li>Gender-specific names</li>
                                <li>International origins</li>
                                <li>Bulk generation</li>
                                <li>Export options</li>
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
    const form = document.getElementById('nameGeneratorForm');
    const resultSection = document.getElementById('resultSection');
    const namesList = document.getElementById('namesList');
    const nameCounter = document.getElementById('nameCounter');
    const clearBtn = document.getElementById('clearBtn');
    const copyBtn = document.getElementById('copyBtn');
    const downloadBtn = document.getElementById('downloadBtn');

    // Name databases
    const names = {
        male: {
            first: ['James', 'Robert', 'John', 'Michael', 'David', 'William', 'Richard', 'Joseph', 'Thomas', 'Christopher', 'Charles', 'Daniel', 'Matthew', 'Anthony', 'Mark', 'Donald', 'Steven', 'Paul', 'Andrew', 'Kenneth', 'Joshua', 'Kevin', 'Brian', 'George', 'Edward', 'Ronald', 'Timothy', 'Jason', 'Jeffrey'],
            middle: ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'R', 'S', 'T', 'W']
        },
        female: {
            first: ['Mary', 'Patricia', 'Jennifer', 'Linda', 'Elizabeth', 'Barbara', 'Susan', 'Jessica', 'Sarah', 'Karen', 'Nancy', 'Lisa', 'Betty', 'Helen', 'Sandra', 'Donna', 'Carol', 'Ruth', 'Sharon', 'Michelle', 'Laura', 'Sarah', 'Kimberly', 'Deborah', 'Dorothy', 'Amy', 'Angela', 'Ashley', 'Brenda'],
            middle: ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'R', 'S', 'T', 'W']
        },
        lastNames: ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez', 'Hernandez', 'Lopez', 'Gonzalez', 'Wilson', 'Anderson', 'Thomas', 'Taylor', 'Moore', 'Jackson', 'Martin', 'Lee', 'Perez', 'Thompson', 'White', 'Harris', 'Sanchez', 'Clark', 'Ramirez', 'Lewis', 'Robinson', 'Walker', 'Young', 'Allen', 'King', 'Wright', 'Scott', 'Torres', 'Nguyen', 'Hill', 'Flores']
    };

    function getRandomElement(array) {
        return array[Math.floor(Math.random() * array.length)];
    }

    function generateName(options) {
        const gender = options.gender === 'random' ? (Math.random() > 0.5 ? 'male' : 'female') : options.gender;
        const firstName = getRandomElement(names[gender].first);
        const lastName = getRandomElement(names.lastNames);
        const middleInitial = options.includeInitials ? getRandomElement(names[gender].middle) : null;

        switch (options.format) {
            case 'first':
                return firstName;
            case 'last':
                return lastName;
            case 'middle':
                return middleInitial
                    ? `${firstName} ${middleInitial}. ${lastName}`
                    : `${firstName} ${getRandomElement(names[gender].first)} ${lastName}`;
            case 'full':
            default:
                return `${firstName} ${lastName}`;
        }
    }

    function generateNames() {
        const options = {
            gender: document.getElementById('gender').value,
            count: parseInt(document.getElementById('nameCount').value),
            format: document.getElementById('nameFormat').value,
            nationality: document.getElementById('nationality').value,
            includeInitials: document.getElementById('includeInitials').checked
        };

        const generatedNames = [];
        for (let i = 0; i < options.count; i++) {
            generatedNames.push(generateName(options));
        }

        return generatedNames;
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        try {
            const names = generateNames();

            namesList.innerHTML = names.map((name, index) =>
                `<div class="mb-1">${index + 1}. ${name}</div>`
            ).join('');

            nameCounter.textContent = names.length;
            resultSection.style.display = 'block';

            // Store names for copying/downloading
            window.generatedNames = names;
        } catch (error) {
            alert('Error generating names. Please try again.');
        }
    });

    clearBtn.addEventListener('click', function() {
        namesList.innerHTML = '';
        nameCounter.textContent = '0';
        resultSection.style.display = 'none';
        window.generatedNames = null;
    });

    copyBtn.addEventListener('click', function() {
        if (window.generatedNames) {
            const text = window.generatedNames.join('\n');
            navigator.clipboard.writeText(text).then(() => {
                const originalText = copyBtn.innerHTML;
                copyBtn.innerHTML = '<i class="fas fa-check me-1"></i>Copied!';

                setTimeout(() => {
                    copyBtn.innerHTML = originalText;
                }, 2000);
            });
        }
    });

    downloadBtn.addEventListener('click', function() {
        if (window.generatedNames) {
            const content = window.generatedNames.join('\n');
            const blob = new Blob([content], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `fake-names-${Date.now()}.txt`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }
    });
});
</script>

