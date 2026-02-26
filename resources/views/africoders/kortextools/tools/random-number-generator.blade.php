<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white"><h5 class="mb-0">🎲 Random Number Generator</h5></div>
                <div class="card-body">
                    <form id="randomForm">@csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="min" class="form-label">Minimum Value</label>
                                <input type="number" class="form-control" id="min" name="min" value="1">
                            </div>
                            <div class="col-md-6">
                                <label for="max" class="form-label">Maximum Value</label>
                                <input type="number" class="form-control" id="max" name="max" value="100">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="count" class="form-label">How many numbers?</label>
                            <input type="number" class="form-control" id="count" name="count" value="1" min="1" max="100">
                        </div>
                        <button type="submit" class="btn btn-success w-100">Generate</button>
                    </form>
                    <div id="result" class="mt-4" style="display:none;"><div class="alert alert-success"><p><strong>Generated Numbers:</strong></p><p id="resultNumbers"></p><p class="mb-0"><strong>Average:</strong> <span id="resultAverage"></span></p></div></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('randomForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(this));
    const response = await fetch('{{ route("tools.kortex.tool.submit", "random-number-generator") }}', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('[name="_token"]').value}, body:JSON.stringify({tool:'random-number-generator',...data})});
    const result = await response.json();
    if(result.success) {document.getElementById('resultNumbers').textContent = result.numbers.join(', '); document.getElementById('resultAverage').textContent = result.average; document.getElementById('result').style.display='block';}
});
</script>