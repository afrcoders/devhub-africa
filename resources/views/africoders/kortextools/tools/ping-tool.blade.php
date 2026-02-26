{{-- Ping Tool - Test Network Connectivity --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-network-wired me-2"></i>
    Test network connectivity and response times to servers.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-wifi me-3"></i>Ping Tool
                </h1>
                <p class="lead text-muted">
                    Test server connectivity and measure response times
                </p>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-server me-2"></i>Target Server</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="host" class="form-label fw-semibold">Host/Domain/IP:</label>
                                <input type="text" class="form-control" id="host" placeholder="e.g., google.com or 8.8.8.8">
                                <small class="text-muted">Enter a domain name or IP address</small>
                            </div>

                            <div class="mb-3">
                                <label for="count" class="form-label fw-semibold">Number of Packets:</label>
                                <input type="number" class="form-control" id="count" value="4" min="1" max="20">
                                <small class="text-muted">How many ping packets to send (1-20)</small>
                            </div>

                            <div class="mb-3">
                                <label for="timeout" class="form-label fw-semibold">Timeout (seconds):</label>
                                <input type="number" class="form-control" id="timeout" value="5" min="1" max="30">
                                <small class="text-muted">Wait time for responses</small>
                            </div>

                            <button type="button" id="pingBtn" class="btn btn-primary w-100" disabled>
                                <i class="fas fa-radio-waves me-2"></i>Send Ping
                            </button>
                        </div>
                    </div>

                    <div class="card shadow-sm mt-3">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-circle-info me-2"></i>About Ping</h5>
                        </div>
                        <div class="card-body" style="font-size: 13px;">
                            <p><strong>Ping</strong> is used to test the reachability of a host and measure round-trip time.</p>
                            <ul class="mb-0">
                                <li><strong>RTT:</strong> Round-trip time in milliseconds</li>
                                <li><strong>TTL:</strong> Time-to-live (hop count)</li>
                                <li><strong>Loss:</strong> Percentage of lost packets</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Results</h5>
                        </div>
                        <div class="card-body" id="results" style="max-height: 500px; overflow-y: auto;">
                            <p class="text-muted text-center">Enter a host and click "Send Ping" to start testing</p>
                        </div>
                    </div>

                    <div class="card shadow-sm mt-3" id="summaryCard" style="display: none;">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0"><i class="fas fa-clipboard me-2"></i>Summary</h5>
                        </div>
                        <div class="card-body" id="summary"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const host = document.getElementById('host');
    const count = document.getElementById('count');
    const timeout = document.getElementById('timeout');
    const pingBtn = document.getElementById('pingBtn');
    const results = document.getElementById('results');
    const summaryCard = document.getElementById('summaryCard');
    const summary = document.getElementById('summary');

    host.addEventListener('input', function() {
        pingBtn.disabled = !this.value.trim();
    });

    pingBtn.addEventListener('click', function() {
        if (!host.value.trim()) {
            alert('Please enter a host or IP address');
            return;
        }

        pingBtn.disabled = true;
        pingBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Pinging...';
        results.innerHTML = '<p class="text-center text-muted"><i class="fas fa-spinner fa-spin me-2"></i>Sending ping packets...</p>';
        summaryCard.style.display = 'none';

        const formData = new FormData();
        formData.append('host', host.value.trim());
        formData.append('count', count.value);
        formData.append('timeout', timeout.value);

        fetch('/api/tools/ping', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayResults(data);
                displaySummary(data);
            } else {
                results.innerHTML = `
                    <div class="alert alert-warning">
                        <strong>Notice:</strong> ${data.message || 'Could not reach host'}
                    </div>
                `;
                if (data.output) {
                    results.innerHTML += `
                        <div class="card card-sm">
                            <div class="card-body" style="font-size: 12px; font-family: monospace; background-color: #f5f5f5; border-radius: 4px; padding: 10px; max-height: 250px; overflow-y: auto; white-space: pre-wrap; word-wrap: break-word;">
                                ${data.output}
                            </div>
                        </div>
                    `;
                }
                summaryCard.style.display = 'none';
            }
        })
        .catch(error => {
            results.innerHTML = `
                <div class="alert alert-danger">
                    <strong>Error:</strong> ${error.message}
                </div>
            `;
            summaryCard.style.display = 'none';
        })
        .finally(() => {
            pingBtn.disabled = false;
            pingBtn.innerHTML = '<i class="fas fa-radio-waves me-2"></i>Send Ping';
        });
    });

    function displayResults(data) {
        let html = `
            <div class="alert alert-success">
                <strong><i class="fas fa-check-circle me-2"></i>Ping Results for ${data.host}</strong>
            </div>
        `;

        if (data.packets && Array.isArray(data.packets)) {
            html += '<div class="list-group" style="border: 1px solid #dee2e6; border-radius: 4px;">';
            data.packets.forEach((packet, index) => {
                const statusClass = packet.time ? 'text-success' : 'text-danger';
                const statusIcon = packet.time ? '<i class="fas fa-check-circle me-2"></i>' : '<i class="fas fa-times-circle me-2"></i>';
                html += `
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">${statusIcon}<strong>Packet ${index + 1}</strong></h6>
                            <small class="${statusClass}">${packet.time ? packet.time + ' ms' : 'Timeout'}</small>
                        </div>
                        ${packet.ttl ? `<small class="text-muted">TTL: ${packet.ttl}</small>` : ''}
                        ${packet.bytes ? `<small class="text-muted ms-3">Bytes: ${packet.bytes}</small>` : ''}
                    </div>
                `;
            });
            html += '</div>';
        } else if (data.output) {
            html += `
                <div style="font-size: 12px; font-family: monospace; background-color: #f5f5f5; border-radius: 4px; padding: 10px; max-height: 250px; overflow-y: auto; white-space: pre-wrap; word-wrap: break-word;">
                    ${data.output}
                </div>
            `;
        }

        results.innerHTML = html;
    }

    function displaySummary(data) {
        let summaryHtml = '<div class="row">';

        if (data.min) {
            summaryHtml += `
                <div class="col-6 mb-2">
                    <small class="text-muted">Minimum RTT</small>
                    <div class="h5 text-primary">${data.min} ms</div>
                </div>
            `;
        }

        if (data.max) {
            summaryHtml += `
                <div class="col-6 mb-2">
                    <small class="text-muted">Maximum RTT</small>
                    <div class="h5 text-danger">${data.max} ms</div>
                </div>
            `;
        }

        if (data.avg) {
            summaryHtml += `
                <div class="col-6 mb-2">
                    <small class="text-muted">Average RTT</small>
                    <div class="h5 text-info">${data.avg} ms</div>
                </div>
            `;
        }

        if (data.loss !== undefined) {
            summaryHtml += `
                <div class="col-6 mb-2">
                    <small class="text-muted">Packet Loss</small>
                    <div class="h5 ${data.loss > 50 ? 'text-danger' : data.loss > 0 ? 'text-warning' : 'text-success'}">
                        ${data.loss}%
                    </div>
                </div>
            `;
        }

        summaryHtml += '</div>';
        summary.innerHTML = summaryHtml;
        summaryCard.style.display = 'block';
    }
});
</script>
