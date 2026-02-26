<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-danger text-white"><h5 class="mb-0">💳 Fake Credit Card Generator</h5></div>
                <div class="card-body">
                    <div class="alert alert-warning"><small>⚠️ For development & testing only. Not for real transactions.</small></div>
                    <form id="ccForm">@csrf
                        <div class="form-group mb-3">
                            <label for="cardType" class="form-label">Card Type</label>
                            <select class="form-select" id="cardType" name="card_type">
                                <option value="visa">Visa</option>
                                <option value="mastercard">Mastercard</option>
                                <option value="amex">American Express</option>
                                <option value="discover">Discover</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="count" class="form-label">Generate Cards</label>
                            <input type="number" class="form-control" id="count" name="count" value="1" min="1" max="20">
                        </div>
                        <button type="submit" class="btn btn-danger w-100">Generate</button>
                    </form>
                    <div id="result" class="mt-4" style="display:none;"><div class="alert alert-danger" id="resultCards"></div></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('ccForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(this));
    const response = await fetch('{{ route("tools.kortex.tool.submit", "fake-credit-card-generator") }}', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('[name="_token"]').value}, body:JSON.stringify({tool:'fake-credit-card-generator',...data})});
    const result = await response.json();
    if(result.success) {
        let html = '<p><strong>Generated Cards:</strong></p>';
        result.cards.forEach(card => {
            html += `<div class="card mb-2"><div class="card-body"><small><strong>${card.type}</strong> | ${card.number}<br>Cardholder: ${card.cardholder}<br>Expires: ${card.expiry} | CVV: ${card.cvv}</small></div></div>`;
        });
        document.getElementById('resultCards').innerHTML = html;
        document.getElementById('result').style.display='block';
    }
});
</script>