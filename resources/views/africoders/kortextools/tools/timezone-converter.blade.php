<div class="row">
    <div class="col-md-12">
        <!-- Timezone Converter Input -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <label for="inputTime" class="form-label">Date & Time</label>
                <input type="datetime-local" class="form-control" id="inputTime">
                <small class="form-text text-muted">Select date and time to convert</small>
            </div>
            <div class="col-md-4 mb-3">
                <label for="fromTimezone" class="form-label">From Timezone</label>
                <select class="form-select" id="fromTimezone">
                    <option value="">Select source timezone</option>
                    <!-- Options will be populated by JavaScript -->
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="toTimezone" class="form-label">To Timezone</label>
                <select class="form-select" id="toTimezone">
                    <option value="">Select target timezone</option>
                    <!-- Options will be populated by JavaScript -->
                </select>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <h6>Quick Actions:</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setCurrentTime()">
                            <i class="bi bi-clock"></i> Current Time
                        </button>
                        <button type="button" class="btn btn-outline-info btn-sm" onclick="detectUserTimezone()">
                            <i class="bi bi-geo-alt"></i> Detect My Timezone
                        </button>
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="swapTimezones()">
                            <i class="bi bi-arrow-left-right"></i> Swap Timezones
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6>Popular Conversions:</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="setPopularConversion('UTC', 'America/New_York')">
                            UTC → EST
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="setPopularConversion('America/New_York', 'Europe/London')">
                            EST → GMT
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="setPopularConversion('America/Los_Angeles', 'Asia/Tokyo')">
                            PST → JST
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Multiple Timezone Display -->
        <div class="mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="showMultipleTimezones">
                <label class="form-check-label" for="showMultipleTimezones">
                    Show time in multiple timezones simultaneously
                </label>
            </div>
        </div>

        <!-- Calculate Button -->
        <div class="mb-4">
            <button type="button" class="btn btn-primary" onclick="convertTimezone()">
                <i class="fas fa-exchange-alt"></i> Convert Timezone
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="clearAll()">
                <i class="bi bi-x-circle"></i> Clear
            </button>
        </div>

        <!-- Results Container -->
        <div id="resultsContainer" style="display: none;" class="mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Timezone Conversion Results</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="text-center p-3 bg-primary text-white rounded">
                                <h5 id="sourceTime" class="mb-1">--</h5>
                                <small id="sourceTimezone">Source Timezone</small>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="text-center p-3 bg-success text-white rounded">
                                <h5 id="targetTime" class="mb-1">--</h5>
                                <small id="targetTimezone">Target Timezone</small>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-striped">
                            <tbody id="conversionDetails">
                                <!-- Details will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-outline-primary" onclick="copyResults()">
                        <i class="bi bi-clipboard"></i> Copy Results
                    </button>
                    <button type="button" class="btn btn-outline-success" onclick="addToSchedule()">
                        <i class="bi bi-calendar-plus"></i> Add to Schedule
                    </button>
                </div>
            </div>
        </div>

        <!-- Multiple Timezones Display -->
        <div id="multipleTimezonesContainer" style="display: none;" class="mb-4">
            <h6>Current Time in Multiple Timezones:</h6>
            <div class="row" id="multipleTimezonesGrid">
                <!-- Timezone cards will be populated by JavaScript -->
            </div>
        </div>

        <!-- Live Clock -->
        <div class="mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="showLiveClock">
                <label class="form-check-label" for="showLiveClock">
                    Show live clock updates
                </label>
            </div>
            <div id="liveClockContainer" style="display: none;" class="mt-3">
                <div class="row" id="liveClockGrid">
                    <!-- Live clocks will be populated by JavaScript -->
                </div>
            </div>
        </div>

        <!-- Timezone Information -->
        <div id="timezoneInfo" style="display: none;" class="mt-4 p-3 bg-light rounded">
            <h6><i class="bi bi-info-circle"></i> Timezone Information</h6>
            <div class="row">
                <div class="col-md-6">
                    <div id="fromTimezoneInfo">
                        <h6>Source Timezone Details:</h6>
                        <ul class="small" id="fromTimezoneDetails">
                            <!-- Details will be populated -->
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="toTimezoneInfo">
                        <h6>Target Timezone Details:</h6>
                        <ul class="small" id="toTimezoneDetails">
                            <!-- Details will be populated -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- World Clock -->
        <div class="mt-4">
            <h6>World Clock - Major Cities:</h6>
            <div class="row" id="worldClockContainer">
                <!-- World clock will be populated by JavaScript -->
            </div>
        </div>
    </div>
</div>

<!-- Information Alert -->
<div class="alert alert-info mt-4">
    <h6><i class="bi bi-info-circle"></i> About Timezone Conversion</h6>
    <p class="mb-0">
        This tool converts times between different timezones accounting for daylight saving time (DST) changes.
        Timezone data is updated regularly to reflect current DST rules and political timezone changes.
        Always verify critical timing with official sources for important events or meetings.
    </p>
</div>

<script>
// Comprehensive timezone data
const timezoneData = {
    // Major world timezones with common names and cities
    'UTC': { name: 'Coordinated Universal Time', offset: 0, cities: ['Greenwich'] },
    'America/New_York': { name: 'Eastern Time', offset: -5, cities: ['New York', 'Boston', 'Washington DC'] },
    'America/Chicago': { name: 'Central Time', offset: -6, cities: ['Chicago', 'Dallas', 'Houston'] },
    'America/Denver': { name: 'Mountain Time', offset: -7, cities: ['Denver', 'Phoenix', 'Salt Lake City'] },
    'America/Los_Angeles': { name: 'Pacific Time', offset: -8, cities: ['Los Angeles', 'San Francisco', 'Seattle'] },
    'America/Anchorage': { name: 'Alaska Time', offset: -9, cities: ['Anchorage', 'Fairbanks'] },
    'Pacific/Honolulu': { name: 'Hawaii Time', offset: -10, cities: ['Honolulu', 'Hilo'] },
    'Europe/London': { name: 'Greenwich Mean Time / British Summer Time', offset: 0, cities: ['London', 'Edinburgh'] },
    'Europe/Paris': { name: 'Central European Time', offset: 1, cities: ['Paris', 'Berlin', 'Rome'] },
    'Europe/Moscow': { name: 'Moscow Time', offset: 3, cities: ['Moscow', 'St. Petersburg'] },
    'Asia/Dubai': { name: 'Gulf Standard Time', offset: 4, cities: ['Dubai', 'Abu Dhabi'] },
    'Asia/Karachi': { name: 'Pakistan Standard Time', offset: 5, cities: ['Karachi', 'Lahore'] },
    'Asia/Kolkata': { name: 'India Standard Time', offset: 5.5, cities: ['Mumbai', 'Delhi', 'Bangalore'] },
    'Asia/Dhaka': { name: 'Bangladesh Standard Time', offset: 6, cities: ['Dhaka', 'Chittagong'] },
    'Asia/Bangkok': { name: 'Indochina Time', offset: 7, cities: ['Bangkok', 'Ho Chi Minh City'] },
    'Asia/Shanghai': { name: 'China Standard Time', offset: 8, cities: ['Beijing', 'Shanghai', 'Hong Kong'] },
    'Asia/Tokyo': { name: 'Japan Standard Time', offset: 9, cities: ['Tokyo', 'Osaka'] },
    'Australia/Sydney': { name: 'Australian Eastern Time', offset: 10, cities: ['Sydney', 'Melbourne'] },
    'Pacific/Auckland': { name: 'New Zealand Time', offset: 12, cities: ['Auckland', 'Wellington'] },
    'Africa/Cairo': { name: 'Eastern European Time', offset: 2, cities: ['Cairo', 'Alexandria'] },
    'Africa/Johannesburg': { name: 'South Africa Standard Time', offset: 2, cities: ['Johannesburg', 'Cape Town'] },
    'Africa/Lagos': { name: 'West Africa Time', offset: 1, cities: ['Lagos', 'Abuja'] },
    'America/Sao_Paulo': { name: 'Brasilia Time', offset: -3, cities: ['São Paulo', 'Rio de Janeiro'] },
    'America/Mexico_City': { name: 'Central Standard Time (Mexico)', offset: -6, cities: ['Mexico City', 'Guadalajara'] },
    'America/Toronto': { name: 'Eastern Time (Canada)', offset: -5, cities: ['Toronto', 'Montreal'] },
    'America/Vancouver': { name: 'Pacific Time (Canada)', offset: -8, cities: ['Vancouver', 'Victoria'] }
};

let liveClockInterval;
let currentConversionResult;

// Initialize timezone selects
function initializeTimezoneSelects() {
    const fromSelect = document.getElementById('fromTimezone');
    const toSelect = document.getElementById('toTimezone');

    // Clear existing options (except first)
    fromSelect.innerHTML = '<option value="">Select source timezone</option>';
    toSelect.innerHTML = '<option value="">Select target timezone</option>';

    // Populate with timezone data
    Object.keys(timezoneData).sort().forEach(timezone => {
        const data = timezoneData[timezone];
        const offset = data.offset >= 0 ? `+${data.offset}` : data.offset;
        const cities = data.cities.join(', ');
        const optionText = `${data.name} (UTC${offset}) - ${cities}`;

        const fromOption = new Option(optionText, timezone);
        const toOption = new Option(optionText, timezone);

        fromSelect.appendChild(fromOption);
        toSelect.appendChild(toOption.cloneNode(true));
    });

    // Set default timezones if possible
    detectUserTimezone();
}

function detectUserTimezone() {
    try {
        const userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        const fromSelect = document.getElementById('fromTimezone');

        // Try to find the user's timezone in our list
        for (let i = 0; i < fromSelect.options.length; i++) {
            if (fromSelect.options[i].value === userTimezone) {
                fromSelect.value = userTimezone;
                break;
            }
        }

        // If not found, use a similar one or default to UTC
        if (!fromSelect.value) {
            fromSelect.value = 'UTC';
        }

        // Set a common target timezone
        document.getElementById('toTimezone').value = 'America/New_York';

    } catch (error) {
        console.log('Could not detect timezone, using defaults');
        document.getElementById('fromTimezone').value = 'UTC';
        document.getElementById('toTimezone').value = 'America/New_York';
    }
}

function setCurrentTime() {
    const now = new Date();
    const offset = now.getTimezoneOffset();
    const localTime = new Date(now.getTime() - (offset * 60000));

    document.getElementById('inputTime').value = localTime.toISOString().slice(0, 16);
}

function swapTimezones() {
    const fromSelect = document.getElementById('fromTimezone');
    const toSelect = document.getElementById('toTimezone');

    const tempValue = fromSelect.value;
    fromSelect.value = toSelect.value;
    toSelect.value = tempValue;

    // If there's already a conversion result, update it
    if (currentConversionResult) {
        convertTimezone();
    }
}

function setPopularConversion(fromTz, toTz) {
    document.getElementById('fromTimezone').value = fromTz;
    document.getElementById('toTimezone').value = toTz;

    // Set current time if no time is selected
    if (!document.getElementById('inputTime').value) {
        setCurrentTime();
    }

    convertTimezone();
}

function convertTimezone() {
    const inputTime = document.getElementById('inputTime').value;
    const fromTz = document.getElementById('fromTimezone').value;
    const toTz = document.getElementById('toTimezone').value;

    if (!inputTime || !fromTz || !toTz) {
        alert('Please select date/time and both timezones.');
        return;
    }

    try {
        // Parse the input time
        const inputDate = new Date(inputTime);

        // Get timezone information
        const fromTzData = timezoneData[fromTz];
        const toTzData = timezoneData[toTz];

        // Convert using Intl.DateTimeFormat for accurate DST handling
        const sourceFormatter = new Intl.DateTimeFormat('en-US', {
            timeZone: fromTz,
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true,
            timeZoneName: 'short'
        });

        const targetFormatter = new Intl.DateTimeFormat('en-US', {
            timeZone: toTz,
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true,
            timeZoneName: 'short'
        });

        const sourceTime = sourceFormatter.format(inputDate);
        const targetTime = targetFormatter.format(inputDate);

        // Calculate time difference
        const sourceOffset = getTimezoneOffset(inputDate, fromTz);
        const targetOffset = getTimezoneOffset(inputDate, toTz);
        const timeDifference = targetOffset - sourceOffset;

        currentConversionResult = {
            inputTime: inputTime,
            fromTz: fromTz,
            toTz: toTz,
            sourceTime: sourceTime,
            targetTime: targetTime,
            timeDifference: timeDifference,
            fromTzData: fromTzData,
            toTzData: toTzData
        };

        displayConversionResults(currentConversionResult);

    } catch (error) {
        alert('Error converting timezone: ' + error.message);
        console.error('Timezone conversion error:', error);
    }
}

function getTimezoneOffset(date, timezone) {
    const utc1 = new Date(date.toLocaleString('en-US', { timeZone: 'UTC' }));
    const utc2 = new Date(date.toLocaleString('en-US', { timeZone: timezone }));
    return (utc2.getTime() - utc1.getTime()) / (1000 * 60 * 60);
}

function displayConversionResults(result) {
    // Update main display
    document.getElementById('sourceTime').textContent = result.sourceTime;
    document.getElementById('sourceTimezone').textContent = result.fromTzData.name;
    document.getElementById('targetTime').textContent = result.targetTime;
    document.getElementById('targetTimezone').textContent = result.toTzData.name;

    // Update details table
    const detailsTable = document.getElementById('conversionDetails');
    const timeDiffText = result.timeDifference >= 0 ?
        `${result.timeDifference} hours ahead` :
        `${Math.abs(result.timeDifference)} hours behind`;

    detailsTable.innerHTML = `
        <tr><th width="30%">Original Time</th><td>${result.sourceTime}</td></tr>
        <tr><th>Original Timezone</th><td>${result.fromTzData.name} (${result.fromTz})</td></tr>
        <tr><th>Converted Time</th><td>${result.targetTime}</td></tr>
        <tr><th>Target Timezone</th><td>${result.toTzData.name} (${result.toTz})</td></tr>
        <tr><th>Time Difference</th><td>${timeDiffText}</td></tr>
        <tr><th>Major Cities (Source)</th><td>${result.fromTzData.cities.join(', ')}</td></tr>
        <tr><th>Major Cities (Target)</th><td>${result.toTzData.cities.join(', ')}</td></tr>
    `;

    document.getElementById('resultsContainer').style.display = 'block';
    document.getElementById('timezoneInfo').style.display = 'block';

    // Update multiple timezones if enabled
    if (document.getElementById('showMultipleTimezones').checked) {
        displayMultipleTimezones(new Date(result.inputTime));
    }
}

function displayMultipleTimezones(date) {
    const container = document.getElementById('multipleTimezonesGrid');
    const majorTimezones = [
        'UTC', 'America/New_York', 'America/Chicago', 'America/Los_Angeles',
        'Europe/London', 'Europe/Paris', 'Asia/Tokyo', 'Australia/Sydney'
    ];

    container.innerHTML = '';

    majorTimezones.forEach(timezone => {
        const tzData = timezoneData[timezone];
        const formatter = new Intl.DateTimeFormat('en-US', {
            timeZone: timezone,
            hour: '2-digit',
            minute: '2-digit',
            hour12: true,
            timeZoneName: 'short'
        });

        const timeString = formatter.format(date);

        const col = document.createElement('div');
        col.className = 'col-md-3 mb-2';
        col.innerHTML = `
            <div class="text-center p-2 border rounded">
                <div class="fw-bold">${timeString}</div>
                <small>${tzData.name.split(' ')[0]}</small>
            </div>
        `;

        container.appendChild(col);
    });

    document.getElementById('multipleTimezonesContainer').style.display = 'block';
}

function initializeWorldClock() {
    const container = document.getElementById('worldClockContainer');
    const worldCities = [
        { tz: 'UTC', city: 'UTC' },
        { tz: 'America/New_York', city: 'New York' },
        { tz: 'America/Los_Angeles', city: 'Los Angeles' },
        { tz: 'Europe/London', city: 'London' },
        { tz: 'Europe/Paris', city: 'Paris' },
        { tz: 'Asia/Tokyo', city: 'Tokyo' },
        { tz: 'Asia/Shanghai', city: 'Shanghai' },
        { tz: 'Australia/Sydney', city: 'Sydney' }
    ];

    worldCities.forEach(city => {
        const col = document.createElement('div');
        col.className = 'col-md-3 mb-3';
        col.innerHTML = `
            <div class="text-center p-3 border rounded">
                <h6>${city.city}</h6>
                <div id="clock-${city.tz.replace(/[\/\s]/g, '-')}" class="h5 text-primary">--:--</div>
                <small class="text-muted">${city.tz}</small>
            </div>
        `;
        container.appendChild(col);
    });

    updateWorldClock(worldCities);

    // Update every second
    setInterval(() => updateWorldClock(worldCities), 1000);
}

function updateWorldClock(cities) {
    const now = new Date();

    cities.forEach(city => {
        const formatter = new Intl.DateTimeFormat('en-US', {
            timeZone: city.tz,
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true
        });

        const timeString = formatter.format(now);
        const clockElement = document.getElementById(`clock-${city.tz.replace(/[\/\s]/g, '-')}`);
        if (clockElement) {
            clockElement.textContent = timeString;
        }
    });
}

// Handle live clock checkbox
document.getElementById('showLiveClock').addEventListener('change', function() {
    const container = document.getElementById('liveClockContainer');
    if (this.checked) {
        startLiveClock();
        container.style.display = 'block';
    } else {
        stopLiveClock();
        container.style.display = 'none';
    }
});

// Handle multiple timezones checkbox
document.getElementById('showMultipleTimezones').addEventListener('change', function() {
    if (this.checked && currentConversionResult) {
        displayMultipleTimezones(new Date(currentConversionResult.inputTime));
    } else {
        document.getElementById('multipleTimezonesContainer').style.display = 'none';
    }
});

function startLiveClock() {
    // Similar to world clock but for selected timezones
    const container = document.getElementById('liveClockGrid');
    const fromTz = document.getElementById('fromTimezone').value;
    const toTz = document.getElementById('toTimezone').value;

    if (!fromTz || !toTz) return;

    const clocks = [
        { tz: fromTz, label: 'Source' },
        { tz: toTz, label: 'Target' }
    ];

    container.innerHTML = '';

    clocks.forEach(clock => {
        const tzData = timezoneData[clock.tz];
        const col = document.createElement('div');
        col.className = 'col-md-6 mb-2';
        col.innerHTML = `
            <div class="text-center p-3 bg-light rounded">
                <h6>${clock.label} - ${tzData.name}</h6>
                <div id="live-${clock.tz.replace(/[\/\s]/g, '-')}" class="h4 text-success">--:--</div>
            </div>
        `;
        container.appendChild(col);
    });

    updateLiveClock(clocks);
    liveClockInterval = setInterval(() => updateLiveClock(clocks), 1000);
}

function stopLiveClock() {
    if (liveClockInterval) {
        clearInterval(liveClockInterval);
        liveClockInterval = null;
    }
}

function updateLiveClock(clocks) {
    const now = new Date();

    clocks.forEach(clock => {
        const formatter = new Intl.DateTimeFormat('en-US', {
            timeZone: clock.tz,
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true
        });

        const timeString = formatter.format(now);
        const clockElement = document.getElementById(`live-${clock.tz.replace(/[\/\s]/g, '-')}`);
        if (clockElement) {
            clockElement.textContent = timeString;
        }
    });
}

function copyResults() {
    if (!currentConversionResult) return;

    const result = currentConversionResult;
    const textToCopy = `Timezone Conversion Results:
Original Time: ${result.sourceTime} (${result.fromTzData.name})
Converted Time: ${result.targetTime} (${result.toTzData.name})
Time Difference: ${result.timeDifference >= 0 ? '+' : ''}${result.timeDifference} hours
Source Cities: ${result.fromTzData.cities.join(', ')}
Target Cities: ${result.toTzData.cities.join(', ')}`;

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

function addToSchedule() {
    if (!currentConversionResult) return;

    alert('Schedule integration would allow you to add this time conversion to your calendar application.');
}

function clearAll() {
    document.getElementById('inputTime').value = '';
    document.getElementById('fromTimezone').value = '';
    document.getElementById('toTimezone').value = '';
    document.getElementById('showMultipleTimezones').checked = false;
    document.getElementById('showLiveClock').checked = false;

    document.getElementById('resultsContainer').style.display = 'none';
    document.getElementById('multipleTimezonesContainer').style.display = 'none';
    document.getElementById('liveClockContainer').style.display = 'none';
    document.getElementById('timezoneInfo').style.display = 'none';

    stopLiveClock();
    currentConversionResult = null;
}

// Initialize everything when page loads
document.addEventListener('DOMContentLoaded', function() {
    initializeTimezoneSelects();
    initializeWorldClock();
    setCurrentTime();
});

// Auto-convert when values change (with debounce)
let convertTimeout;
function debounceConvert() {
    clearTimeout(convertTimeout);
    convertTimeout = setTimeout(() => {
        const inputTime = document.getElementById('inputTime').value;
        const fromTz = document.getElementById('fromTimezone').value;
        const toTz = document.getElementById('toTimezone').value;

        if (inputTime && fromTz && toTz) {
            convertTimezone();
        }
    }, 500);
}

// Add event listeners for auto-conversion
document.getElementById('inputTime').addEventListener('change', debounceConvert);
document.getElementById('fromTimezone').addEventListener('change', debounceConvert);
document.getElementById('toTimezone').addEventListener('change', debounceConvert);
</script>

<style>
#worldClockContainer .border {
    transition: all 0.3s ease;
}

#worldClockContainer .border:hover {
    border-color: #007bff !important;
    box-shadow: 0 0 10px rgba(0,123,255,0.3);
}

.live-clock-display {
    font-family: 'Courier New', monospace;
    font-weight: bold;
}

@media (max-width: 768px) {
    .btn-sm {
        font-size: 0.8rem;
        padding: 0.25rem 0.5rem;
    }

    #worldClockContainer .col-md-3 {
        margin-bottom: 1rem;
    }
}
</style>
