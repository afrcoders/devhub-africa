<div class="row">
    <div class="col-md-12">
        <!-- Birth Date Input -->
        <div class="mb-4">
            <label for="birth_date" class="form-label">Date of Birth</label>
            <input type="date" class="form-control" id="birth_date" name="birth_date" max="{{ date('Y-m-d') }}">
            <div class="form-text">
                <small class="text-muted">Select your birth date to calculate your exact age</small>
            </div>
        </div>

        <!-- Calculate Button -->
        <div class="mb-4">
            <button type="button" class="btn btn-primary" onclick="calculateAge()">
                <i class="fas fa-calculator"></i> Calculate Age
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="clearAll()">
                <i class="bi bi-x-circle"></i> Clear
            </button>
        </div>

        <!-- Results Section -->
        <div id="resultsContainer" style="display: none;">
            <h6>Your Age:</h6>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="text-center p-4 bg-primary text-white rounded">
                        <h2 id="ageYears" class="mb-1">0</h2>
                        <span>Years Old</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-center p-4 bg-info text-white rounded">
                        <h5 id="formatted" class="mb-1">0 months, 0 days</h5>
                        <span>Detailed Age</span>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th width="40%">Total Days Lived</th>
                            <td id="totalDays">0</td>
                        </tr>
                        <tr>
                            <th>Total Hours Lived</th>
                            <td id="totalHours">0</td>
                        </tr>
                        <tr>
                            <th>Total Minutes Lived</th>
                            <td id="totalMinutes">0</td>
                        </tr>
                        <tr>
                            <th>Next Birthday</th>
                            <td id="nextBirthday">-</td>
                        </tr>
                        <tr>
                            <th>Days Until Next Birthday</th>
                            <td id="daysUntilBirthday">0</td>
                        </tr>
                        <tr>
                            <th>Zodiac Sign</th>
                            <td id="zodiacSign">-</td>
                        </tr>
                        <tr>
                            <th>Birth Day of Week</th>
                            <td id="birthDayOfWeek">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Dates -->
        <div class="mt-4">
            <h6>Quick Select:</h6>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setQuickDate(25)">
                    25 years ago
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setQuickDate(30)">
                    30 years ago
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setQuickDate(35)">
                    35 years ago
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setQuickDate(40)">
                    40 years ago
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Information -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> About Age Calculation</h6>
    <p class="mb-0">
        This calculator provides precise age calculation including years, months, days, and additional statistics
        like total hours lived, days until next birthday, and your zodiac sign. All calculations are based on
        the exact date and time.
    </p>
</div>

<script>
function calculateAge() {
    const birthDate = document.getElementById('birth_date').value;

    if (!birthDate) {
        alert('Please select your birth date.');
        return;
    }

    const birth = new Date(birthDate);
    const today = new Date();

    if (birth > today) {
        alert('Birth date cannot be in the future.');
        return;
    }

    // Calculate age
    const ageData = getAgeDetails(birth, today);

    // Display results
    document.getElementById('ageYears').textContent = ageData.years;
    document.getElementById('formatted').textContent = `${ageData.months} months, ${ageData.days} days`;
    document.getElementById('totalDays').textContent = ageData.totalDays.toLocaleString();
    document.getElementById('totalHours').textContent = ageData.totalHours.toLocaleString();
    document.getElementById('totalMinutes').textContent = ageData.totalMinutes.toLocaleString();
    document.getElementById('nextBirthday').textContent = ageData.nextBirthday;
    document.getElementById('daysUntilBirthday').textContent = ageData.daysUntilBirthday;
    document.getElementById('zodiacSign').textContent = ageData.zodiacSign;
    document.getElementById('birthDayOfWeek').textContent = ageData.birthDayOfWeek;

    document.getElementById('resultsContainer').style.display = 'block';
}

function getAgeDetails(birth, today) {
    // Calculate exact age
    let years = today.getFullYear() - birth.getFullYear();
    let months = today.getMonth() - birth.getMonth();
    let days = today.getDate() - birth.getDate();

    if (days < 0) {
        months--;
        const lastMonth = new Date(today.getFullYear(), today.getMonth(), 0);
        days += lastMonth.getDate();
    }

    if (months < 0) {
        years--;
        months += 12;
    }

    // Calculate totals
    const totalDays = Math.floor((today - birth) / (1000 * 60 * 60 * 24));
    const totalHours = totalDays * 24;
    const totalMinutes = totalHours * 60;

    // Next birthday
    const nextBirthday = new Date(today.getFullYear(), birth.getMonth(), birth.getDate());
    if (nextBirthday < today) {
        nextBirthday.setFullYear(today.getFullYear() + 1);
    }
    const daysUntilBirthday = Math.ceil((nextBirthday - today) / (1000 * 60 * 60 * 24));

    // Zodiac sign
    const zodiacSign = getZodiacSign(birth.getMonth() + 1, birth.getDate());

    // Birth day of week
    const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    const birthDayOfWeek = dayNames[birth.getDay()];

    return {
        years,
        months,
        days,
        totalDays,
        totalHours,
        totalMinutes,
        nextBirthday: nextBirthday.toLocaleDateString(),
        daysUntilBirthday,
        zodiacSign,
        birthDayOfWeek
    };
}

function getZodiacSign(month, day) {
    const signs = [
        { sign: 'Capricorn', start: [12, 22], end: [1, 19] },
        { sign: 'Aquarius', start: [1, 20], end: [2, 18] },
        { sign: 'Pisces', start: [2, 19], end: [3, 20] },
        { sign: 'Aries', start: [3, 21], end: [4, 19] },
        { sign: 'Taurus', start: [4, 20], end: [5, 20] },
        { sign: 'Gemini', start: [5, 21], end: [6, 20] },
        { sign: 'Cancer', start: [6, 21], end: [7, 22] },
        { sign: 'Leo', start: [7, 23], end: [8, 22] },
        { sign: 'Virgo', start: [8, 23], end: [9, 22] },
        { sign: 'Libra', start: [9, 23], end: [10, 22] },
        { sign: 'Scorpio', start: [10, 23], end: [11, 21] },
        { sign: 'Sagittarius', start: [11, 22], end: [12, 21] }
    ];

    for (let sign of signs) {
        if ((month === sign.start[0] && day >= sign.start[1]) ||
            (month === sign.end[0] && day <= sign.end[1])) {
            return sign.sign;
        }
    }
    return 'Capricorn'; // Default for edge case
}

function setQuickDate(yearsAgo) {
    const today = new Date();
    const birthDate = new Date(today.getFullYear() - yearsAgo, today.getMonth(), today.getDate());

    document.getElementById('birth_date').value = birthDate.toISOString().split('T')[0];
    calculateAge();
}

function clearAll() {
    document.getElementById('birth_date').value = '';
    document.getElementById('resultsContainer').style.display = 'none';
}

// Auto-calculate on date change
document.getElementById('birth_date').addEventListener('change', function() {
    if (this.value) {
        calculateAge();
    }
});
</script>
