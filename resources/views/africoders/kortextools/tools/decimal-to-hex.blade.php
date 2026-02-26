<div class="card">
    <div class="card-header">
        <h5>Decimal to HEX Converter</h5>
        <p class="text-muted small mb-0">Convert between decimal and hexadecimal numbers</p>
    </div>
    <div class="card-body">
        <form id="conversionForm" class="tool-form">
            @csrf

            <ul class="nav nav-tabs mb-3">
                <li class="nav-item"><button class="nav-link active" type="button" data-bs-toggle="tab" data-bs-target="#decTab">Decimal to HEX</button></li>
                <li class="nav-item"><button class="nav-link" type="button" data-bs-toggle="tab" data-bs-target="#hexTab">HEX to Decimal</button></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="decTab">
                    <div class="mb-3">
                        <label class="form-label">Decimal Number</label>
                        <input type="number" class="form-control" name="decimal" placeholder="Enter decimal number" min="0">
                    </div>
                </div>
                <div class="tab-pane fade" id="hexTab">
                    <div class="mb-3">
                        <label class="form-label">Hexadecimal Number</label>
                        <input type="text" class="form-control" name="hex" placeholder="Enter hex number">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" onclick="setOp('decimal_to_hex')"><i class="fas fa-exchange-alt"></i> Convert</button>

            <div id="result" style="display: none;" class="mt-4">
                <h6>Result:</h6>
                <div class="bg-light p-3 rounded">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">Decimal</small><br><strong id="decResult">-</strong>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Hexadecimal</small><br><strong id="hexResult">-</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div id="error" class="alert alert-danger" style="display: none;"></div>
        </form>
    </div>
</div>

<script>
let op = 'decimal_to_hex';
function setOp(o) { op = o; }

document.getElementById('conversionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const decInput = document.querySelector('input[name="decimal"]').value;
    const hexInput = document.querySelector('input[name="hex"]').value;

    if ((op === 'decimal_to_hex' && !decInput) || (op === 'hex_to_decimal' && !hexInput)) {
        document.getElementById('error').textContent = 'Please enter a value';
        document.getElementById('error').style.display = 'block';
        return;
    }

    const data = { operation: op };
    if (op === 'decimal_to_hex') data.decimal = decInput;
    else data.hex = hexInput;

    fetch('{{ route("tools.kortex.tool.submit", "decimal-to-hex") }}', {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value},
        body: JSON.stringify(data)
    }).then(r => r.json()).then(d => {
        if (d.success) {
            document.getElementById('decResult').textContent = d.data.decimal;
            document.getElementById('hexResult').textContent = d.data.hex;
            document.getElementById('result').style.display = 'block';
            document.getElementById('error').style.display = 'none';
        } else {
            document.getElementById('error').textContent = d.message;
            document.getElementById('error').style.display = 'block';
        }
    });
});
</script>