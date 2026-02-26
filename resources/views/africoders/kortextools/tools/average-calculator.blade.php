<div class="card">
    <div class="card-header">
        <h5>Average Calculator</h5>
        <p class="text-muted small mb-0">Calculate average, median, and more from numbers</p>
    </div>
    <div class="card-body">
        <form id="averageForm" class="tool-form">
            @csrf

            <div class="mb-3">
                <label for="numbers" class="form-label">Numbers (comma separated)</label>
                <textarea class="form-control" id="numbers" name="numbers" rows="4" placeholder="e.g., 10, 20, 30, 40, 50"></textarea>
                <small class="text-muted">Enter numbers separated by commas or spaces</small>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-calculator"></i> Calculate
                </button>
            </div>

            <!-- Results -->
            <div id="resultsContainer" style="display: none;">
                <div class="mt-4">
                    <h6>Statistics:</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tbody>
                                <tr>
                                    <th width="40%">Count</th>
                                    <td id="resultCount">0</td>
                                </tr>
                                <tr>
                                    <th>Sum</th>
                                    <td id="resultSum">0</td>
                                </tr>
                                <tr>
                                    <th>Average (Mean)</th>
                                    <td><strong id="resultAverage">0</strong></td>
                                </tr>
                                <tr>
                                    <th>Median</th>
                                    <td id="resultMedian">0</td>
                                </tr>
                                <tr>
                                    <th>Mode</th>
                                    <td id="resultMode">-</td>
                                </tr>
                                <tr>
                                    <th>Minimum</th>
                                    <td id="resultMin">0</td>
                                </tr>
                                <tr>
                                    <th>Maximum</th>
                                    <td id="resultMax">0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Error message -->
            <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
        </form>
    </div>
</div>

<script>
document.getElementById('averageForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const numbers = document.getElementById('numbers').value;
    const resultsContainer = document.getElementById('resultsContainer');
    const errorMessage = document.getElementById('errorMessage');

    if (!numbers.trim()) {
        errorMessage.textContent = 'Please enter some numbers';
        errorMessage.style.display = 'block';
        return;
    }

    errorMessage.style.display = 'none';

    fetch('{{ route("tools.kortex.tool.submit", "average-calculator") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
        },
        body: JSON.stringify({ numbers: numbers })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('resultCount').textContent = data.data.count;
            document.getElementById('resultSum').textContent = data.data.sum.toLocaleString();
            document.getElementById('resultAverage').textContent = data.data.average;
            document.getElementById('resultMedian').textContent = data.data.median;
            document.getElementById('resultMode').textContent = data.data.mode;
            document.getElementById('resultMin').textContent = data.data.min;
            document.getElementById('resultMax').textContent = data.data.max;
            resultsContainer.style.display = 'block';
        } else {
            errorMessage.textContent = data.message || 'An error occurred';
            errorMessage.style.display = 'block';
        }
    })
    .catch(error => {
        errorMessage.textContent = 'Error: ' + error.message;
        errorMessage.style.display = 'block';
    });
});
</script>