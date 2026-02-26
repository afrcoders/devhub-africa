<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white"><h5 class="mb-0">⏱️ Time Converter</h5></div>
                <div class="card-body">
                    <form id="timeForm">@csrf
                        <input type="number" class="form-control mb-3" name="value" placeholder="Enter value" step="0.01" required>
                        <select class="form-select mb-3" name="conversion_type" required>
                            <option value="second-to-minute">Seconds → Minutes</option>
                            <option value="minute-to-second">Minutes → Seconds</option>
                            <option value="minute-to-hour">Minutes → Hours</option>
                            <option value="hour-to-minute">Hours → Minutes</option>
                            <option value="hour-to-day">Hours → Days</option>
                            <option value="day-to-hour">Days → Hours</option>
                            <option value="day-to-week">Days → Weeks</option>
                            <option value="week-to-day">Weeks → Days</option>
                            <option value="second-to-hour">Seconds → Hours</option>
                            <option value="millisecond-to-second">Milliseconds → Seconds</option>
                        </select>
                        <button type="submit" class="btn btn-info w-100">Convert</button>
                    </form>
                    <div id="result" class="mt-4" style="display:none;"><div class="alert alert-info"><p id="resultValue"></p></div></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('timeForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(this));
    const response = await fetch('{{ route("tools.kortex.tool.submit", "time-converter") }}', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('[name="_token"]').value}, body:JSON.stringify({tool:'time-converter',...data})});
    const result = await response.json();
    if(result.success) {document.getElementById('resultValue').innerHTML = `<strong>${data.value} ${result.unit_from} = ${result.result} ${result.unit_to}</strong>`; document.getElementById('result').style.display='block';}
});
</script>