<div class="card">
    <div class="card-header">
        <h5>Email Validator</h5>
        <p class="text-muted small mb-0">Validate email addresses and get detailed feedback</p>
    </div>
    <div class="card-body">
        <form id="emailForm" class="tool-form">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="example@domain.com">
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Validate</button>

            <div id="result" style="display: none;" class="mt-4">
                <h6>Validation Result:</h6>
                <div class="alert" id="resultBadge"></div>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th>Local Part</th>
                            <td id="localPart">-</td>
                        </tr>
                        <tr>
                            <th>Domain</th>
                            <td id="domain">-</td>
                        </tr>
                    </table>
                </div>
                <div class="mt-3">
                    <small><strong>Feedback:</strong></small>
                    <ul id="feedback" class="list-unstyled mt-2 small"></ul>
                </div>
            </div>
            <div id="error" class="alert alert-danger" style="display: none;"></div>
        </form>
    </div>
</div>

<script>
document.getElementById('emailForm').addEventListener('submit', function(e) {
    e.preventDefault();
    fetch('{{ route("tools.kortex.tool.submit", "email-validator") }}', {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value},
        body: JSON.stringify({ email: document.getElementById('email').value })
    }).then(r => r.json()).then(d => {
        if (d.success) {
            const badge = document.getElementById('resultBadge');
            if (d.data.is_valid) {
                badge.className = 'alert alert-success';
                badge.innerHTML = '<strong>Valid Email ✓</strong>';
            } else {
                badge.className = 'alert alert-danger';
                badge.innerHTML = '<strong>Invalid Email ✗</strong>';
            }
            document.getElementById('localPart').textContent = d.data.local_part;
            document.getElementById('domain').textContent = d.data.domain;
            const ul = document.getElementById('feedback');
            ul.innerHTML = '';
            d.data.feedback.forEach(f => {
                const li = document.createElement('li');
                li.innerHTML = '<i class="fas fa-info-circle me-2"></i>' + f;
                ul.appendChild(li);
            });
            document.getElementById('result').style.display = 'block';
            document.getElementById('error').style.display = 'none';
        } else {
            document.getElementById('error').textContent = d.message;
            document.getElementById('error').style.display = 'block';
        }
    });
});
</script>