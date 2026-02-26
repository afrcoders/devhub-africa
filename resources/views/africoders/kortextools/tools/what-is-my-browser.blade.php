{{-- What Is My Browser --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    What Is My Browser shows details about your browser and system.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-desktop me-3"></i>What Is My Browser?
                </h1>
                <p class="lead text-muted">
                    Detect your browser, OS, and system information
                </p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Browser Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">
                                        <i class="fas fa-globe me-2"></i>Browser
                                    </h6>
                                    <p class="card-text">
                                        <strong>Name:</strong> <span id="browserName">Detecting...</span><br>
                                        <strong>Version:</strong> <span id="browserVersion">Detecting...</span><br>
                                        <strong>Engine:</strong> <span id="browserEngine">Detecting...</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">
                                        <i class="fas fa-laptop me-2"></i>Operating System
                                    </h6>
                                    <p class="card-text">
                                        <strong>OS Name:</strong> <span id="osName">Detecting...</span><br>
                                        <strong>OS Version:</strong> <span id="osVersion">Detecting...</span><br>
                                        <strong>Architecture:</strong> <span id="osArch">Detecting...</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">
                                        <i class="fas fa-mobile-alt me-2"></i>Device
                                    </h6>
                                    <p class="card-text">
                                        <strong>Device Type:</strong> <span id="deviceType">Detecting...</span><br>
                                        <strong>Screen Resolution:</strong> <span id="screenResolution">Detecting...</span><br>
                                        <strong>Viewport:</strong> <span id="viewport">Detecting...</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">
                                        <i class="fas fa-cogs me-2"></i>Technical Details
                                    </h6>
                                    <p class="card-text">
                                        <strong>User Agent:</strong> <span id="userAgent" class="text-break">Detecting...</span><br>
                                        <strong>JavaScript:</strong> <span id="jsEnabled">Enabled</span><br>
                                        <strong>Cookies:</strong> <span id="cookiesEnabled">Detecting...</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">
                                        <i class="fas fa-memory me-2"></i>Memory & Storage
                                    </h6>
                                    <p class="card-text">
                                        <strong>RAM:</strong> <span id="ramInfo">Detecting...</span><br>
                                        <strong>Local Storage:</strong> <span id="localStorage">Available</span><br>
                                        <strong>Session Storage:</strong> <span id="sessionStorage">Available</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">
                                        <i class="fas fa-network-wired me-2"></i>Network
                                    </h6>
                                    <p class="card-text">
                                        <strong>Connection:</strong> <span id="connectionType">Detecting...</span><br>
                                        <strong>Do Not Track:</strong> <span id="dnt">Detecting...</span><br>
                                        <strong>Online Status:</strong> <span id="onlineStatus">Detecting...</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="button" id="copyBtn" class="btn btn-primary">
                            <i class="fas fa-copy me-2"></i>Copy All Info
                        </button>
                        <button type="button" id="refreshBtn" class="btn btn-outline-secondary ms-2">
                            <i class="fas fa-sync me-2"></i>Refresh
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const copyBtn = document.getElementById('copyBtn');
    const refreshBtn = document.getElementById('refreshBtn');

    function detectBrowser() {
        const ua = navigator.userAgent;
        let browserName = 'Unknown';
        let browserVersion = 'Unknown';
        let browserEngine = 'Unknown';

        // Browser detection
        if (ua.indexOf('Firefox') > -1) {
            browserName = 'Firefox';
            browserVersion = ua.substring(ua.indexOf('Firefox') + 8);
            browserEngine = 'Gecko';
        } else if (ua.indexOf('Chrome') > -1) {
            browserName = 'Chrome';
            browserVersion = ua.substring(ua.indexOf('Chrome') + 7).split('/')[0];
            browserEngine = 'Blink';
        } else if (ua.indexOf('Safari') > -1 && ua.indexOf('Chrome') === -1) {
            browserName = 'Safari';
            browserVersion = ua.substring(ua.indexOf('Version') + 8).split(' ')[0];
            browserEngine = 'WebKit';
        } else if (ua.indexOf('Trident') > -1) {
            browserName = 'Internet Explorer';
            browserVersion = ua.substring(ua.indexOf('rv:') + 3).split(')')[0];
            browserEngine = 'Trident';
        } else if (ua.indexOf('Edge') > -1) {
            browserName = 'Edge';
            browserVersion = ua.substring(ua.indexOf('Edge') + 5).split('/')[0];
            browserEngine = 'EdgeHTML';
        } else if (ua.indexOf('Edg') > -1) {
            browserName = 'Edge (Chromium)';
            browserVersion = ua.substring(ua.indexOf('Edg') + 4).split('/')[0];
            browserEngine = 'Blink';
        }

        document.getElementById('browserName').textContent = browserName;
        document.getElementById('browserVersion').textContent = browserVersion;
        document.getElementById('browserEngine').textContent = browserEngine;
    }

    function detectOS() {
        const ua = navigator.userAgent;
        let osName = 'Unknown';
        let osVersion = 'Unknown';
        let osArch = navigator.platform;

        if (ua.indexOf('Win') > -1) {
            osName = 'Windows';
            if (ua.indexOf('Windows NT 10.0') > -1) osVersion = '10 or 11';
            else if (ua.indexOf('Windows NT 6.3') > -1) osVersion = '8.1';
            else if (ua.indexOf('Windows NT 6.2') > -1) osVersion = '8';
            else if (ua.indexOf('Windows NT 6.1') > -1) osVersion = '7';
        } else if (ua.indexOf('Mac') > -1) {
            osName = 'macOS';
            const match = ua.match(/OS X (\d+[\._]\d+)/);
            if (match) osVersion = match[1].replace('_', '.');
        } else if (ua.indexOf('X11') > -1 || ua.indexOf('Linux') > -1) {
            osName = 'Linux';
        } else if (ua.indexOf('Android') > -1) {
            osName = 'Android';
            const match = ua.match(/Android ([\d\.]+)/);
            if (match) osVersion = match[1];
        } else if (ua.indexOf('iPhone') > -1 || ua.indexOf('iPad') > -1) {
            osName = 'iOS';
            const match = ua.match(/OS (\d+[\._]\d+)/);
            if (match) osVersion = match[1].replace('_', '.');
        }

        document.getElementById('osName').textContent = osName;
        document.getElementById('osVersion').textContent = osVersion;
        document.getElementById('osArch').textContent = osArch;
    }

    function detectDevice() {
        const ua = navigator.userAgent.toLowerCase();
        let deviceType = 'Desktop';

        if (/mobile|android|iphone|ipad|phone/i.test(ua)) {
            deviceType = 'Mobile';
        } else if (/tablet|ipad/i.test(ua)) {
            deviceType = 'Tablet';
        }

        const screenRes = window.screen.width + ' x ' + window.screen.height;
        const viewport = window.innerWidth + ' x ' + window.innerHeight;

        document.getElementById('deviceType').textContent = deviceType;
        document.getElementById('screenResolution').textContent = screenRes + ' px';
        document.getElementById('viewport').textContent = viewport + ' px';
    }

    function detectTechnical() {
        document.getElementById('userAgent').textContent = navigator.userAgent;
        document.getElementById('jsEnabled').textContent = 'Enabled';
        document.getElementById('cookiesEnabled').textContent = navigator.cookieEnabled ? 'Enabled' : 'Disabled';
    }

    function detectMemory() {
        if (navigator.deviceMemory) {
            document.getElementById('ramInfo').textContent = navigator.deviceMemory + ' GB';
        } else {
            document.getElementById('ramInfo').textContent = 'Not available';
        }

        document.getElementById('localStorage').textContent = typeof(Storage) !== "undefined" ? 'Available' : 'Not available';
        document.getElementById('sessionStorage').textContent = typeof(sessionStorage) !== "undefined" ? 'Available' : 'Not available';
    }

    function detectNetwork() {
        if (navigator.connection) {
            document.getElementById('connectionType').textContent = navigator.connection.effectiveType;
        } else {
            document.getElementById('connectionType').textContent = 'Not available';
        }

        document.getElementById('dnt').textContent = navigator.doNotTrack ? 'Yes' : 'No';
        document.getElementById('onlineStatus').textContent = navigator.onLine ? 'Online' : 'Offline';
    }

    function refreshInfo() {
        detectBrowser();
        detectOS();
        detectDevice();
        detectTechnical();
        detectMemory();
        detectNetwork();
    }

    function copyAllInfo() {
        const info = {
            'Browser Name': document.getElementById('browserName').textContent,
            'Browser Version': document.getElementById('browserVersion').textContent,
            'Browser Engine': document.getElementById('browserEngine').textContent,
            'OS Name': document.getElementById('osName').textContent,
            'OS Version': document.getElementById('osVersion').textContent,
            'Device Type': document.getElementById('deviceType').textContent,
            'Screen Resolution': document.getElementById('screenResolution').textContent,
            'Viewport': document.getElementById('viewport').textContent,
            'User Agent': document.getElementById('userAgent').textContent,
            'Cookies Enabled': document.getElementById('cookiesEnabled').textContent,
            'RAM': document.getElementById('ramInfo').textContent,
            'Connection Type': document.getElementById('connectionType').textContent,
            'Online Status': document.getElementById('onlineStatus').textContent
        };

        const text = Object.entries(info)
            .map(([key, value]) => `${key}: ${value}`)
            .join('\n');

        navigator.clipboard.writeText(text).then(() => {
            const originalText = copyBtn.innerHTML;
            copyBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
            copyBtn.classList.replace('btn-primary', 'btn-success');

            setTimeout(() => {
                copyBtn.innerHTML = originalText;
                copyBtn.classList.replace('btn-success', 'btn-primary');
            }, 2000);
        });
    }

    copyBtn.addEventListener('click', copyAllInfo);
    refreshBtn.addEventListener('click', refreshInfo);

    // Initial detection
    refreshInfo();
});
</script>
