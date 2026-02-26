{{-- jwt encoder decoder --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    jwt encoder decoder tool for your development and productivity needs.
</div>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-key fa-3x text-primary"></i>
                </div>
                <h1 class="h2 mb-3">JWT Encoder/Decoder</h1>
                <p class="lead text-muted">
                    Encode, decode, and verify JSON Web Tokens (JWT). Perfect for debugging and token inspection
                </p>
            </div>

            <!-- Mode Selection -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center p-4">
                    <div class="btn-group" role="group" aria-label="JWT Mode">
                        <input type="radio" class="btn-check" name="jwt_mode" id="decode_mode" value="decode" checked>
                        <label class="btn btn-outline-primary" for="decode_mode">
                            <i class="fas fa-unlock me-2"></i>Decode JWT
                        </label>

                        <input type="radio" class="btn-check" name="jwt_mode" id="encode_mode" value="encode">
                        <label class="btn btn-outline-success" for="encode_mode">
                            <i class="fas fa-lock me-2"></i>Encode JWT
                        </label>

                        <input type="radio" class="btn-check" name="jwt_mode" id="verify_mode" value="verify">
                        <label class="btn btn-outline-warning" for="verify_mode">
                            <i class="fas fa-shield-alt me-2"></i>Verify JWT
                        </label>
                    </div>
                </div>
            </div>

            <!-- Decode Mode -->
            <div id="decode-section" class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-unlock me-2"></i>Decode JWT Token
                    </h5>
                </div>
                <div class="card-body">
                    <form id="decode-jwt-form">
                        @csrf
                        <div class="mb-4">
                            <label for="jwt_token_decode" class="form-label">
                                <i class="fas fa-key me-2"></i>JWT Token
                            </label>
                            <textarea
                                class="form-control form-control-lg font-monospace"
                                id="jwt_token_decode"
                                name="jwt_token"
                                rows="6"
                                placeholder="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c"
                                required
                            ></textarea>
                            <small class="form-text text-muted">
                                Paste your JWT token to decode and inspect its contents
                            </small>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-unlock me-2"></i>Decode Token
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Encode Mode -->
            <div id="encode-section" class="card shadow-sm" style="display: none;">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-lock me-2"></i>Encode JWT Token
                    </h5>
                </div>
                <div class="card-body">
                    <form id="encode-jwt-form">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="algorithm" class="form-label">
                                    <i class="fas fa-cog me-2"></i>Algorithm
                                </label>
                                <select class="form-select" id="algorithm" name="algorithm">
                                    <option value="HS256" selected>HS256 (HMAC SHA256)</option>
                                    <option value="HS384">HS384 (HMAC SHA384)</option>
                                    <option value="HS512">HS512 (HMAC SHA512)</option>
                                    <option value="RS256">RS256 (RSA SHA256)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="secret_key" class="form-label">
                                    <i class="fas fa-shield-alt me-2"></i>Secret Key
                                </label>
                                <input
                                    type="text"
                                    class="form-control font-monospace"
                                    id="secret_key"
                                    name="secret_key"
                                    placeholder="your-256-bit-secret"
                                    required
                                >
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="jwt_payload" class="form-label">
                                <i class="fas fa-code me-2"></i>JWT Payload (JSON)
                            </label>
                            <textarea
                                class="form-control font-monospace"
                                id="jwt_payload"
                                name="jwt_payload"
                                rows="10"
                                placeholder='{
  "sub": "1234567890",
  "name": "John Doe",
  "iat": 1516239022,
  "exp": 1516325422
}'
                                required
                            ></textarea>
                            <small class="form-text text-muted">
                                Enter valid JSON for the JWT payload
                            </small>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-lock me-2"></i>Generate Token
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Verify Mode -->
            <div id="verify-section" class="card shadow-sm" style="display: none;">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-shield-alt me-2"></i>Verify JWT Token
                    </h5>
                </div>
                <div class="card-body">
                    <form id="verify-jwt-form">
                        @csrf
                        <div class="mb-4">
                            <label for="jwt_token_verify" class="form-label">
                                <i class="fas fa-key me-2"></i>JWT Token
                            </label>
                            <textarea
                                class="form-control font-monospace"
                                id="jwt_token_verify"
                                name="jwt_token"
                                rows="6"
                                placeholder="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c"
                                required
                            ></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="verify_secret" class="form-label">
                                <i class="fas fa-shield-alt me-2"></i>Secret Key (for verification)
                            </label>
                            <input
                                type="text"
                                class="form-control font-monospace"
                                id="verify_secret"
                                name="secret_key"
                                placeholder="your-256-bit-secret"
                                required
                            >
                            <small class="form-text text-muted">
                                Enter the secret key used to sign the token
                            </small>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="fas fa-shield-alt me-2"></i>Verify Token
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Loading State -->
            <div id="loading" class="text-center mt-4" style="display: none;">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <div class="spinner-border text-primary me-3" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span class="text-muted">Processing JWT token...</span>
                    </div>
                </div>
            </div>

            <!-- Results -->
            <div id="results" class="mt-4" style="display: none;">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0" id="results-title">
                            <i class="fas fa-check-circle me-2"></i>Results
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="results-content"></div>
                    </div>
                </div>
            </div>

            <!-- Info Section -->
            <div class="alert alert-info mt-4">
                <h6 class="alert-heading">
                    <i class="fas fa-info-circle me-2"></i>About JSON Web Tokens (JWT)
                </h6>
                <p class="mb-2">
                    JWT is a compact, URL-safe means of representing claims between parties:
                </p>
                <ul class="mb-2">
                    <li><strong>Header</strong> - Contains algorithm and token type information</li>
                    <li><strong>Payload</strong> - Contains the claims (user data, expiration, etc.)</li>
                    <li><strong>Signature</strong> - Verifies token integrity and authenticity</li>
                    <li><strong>Base64 Encoded</strong> - Each part is base64url encoded</li>
                    <li><strong>Stateless</strong> - Self-contained authentication mechanism</li>
                </ul>
                <p class="mb-0">
                    <small><strong>Common uses:</strong> API authentication, SSO, information exchange, and session management.</small>
                </p>
            </div>

            <!-- Security Warning -->
            <div class="alert alert-warning mt-4">
                <h6 class="alert-heading">
                    <i class="fas fa-exclamation-triangle me-2"></i>Security Notice
                </h6>
                <ul class="mb-0">
                    <li>Never expose your secret keys in client-side applications</li>
                    <li>Always use HTTPS when transmitting JWT tokens</li>
                    <li>Set appropriate expiration times for tokens</li>
                    <li>This tool is for development and debugging purposes only</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modeInputs = document.querySelectorAll('input[name="jwt_mode"]');
    const decodeSection = document.getElementById('decode-section');
    const encodeSection = document.getElementById('encode-section');
    const verifySection = document.getElementById('verify-section');

    // Handle mode switching
    modeInputs.forEach(input => {
        input.addEventListener('change', function() {
            decodeSection.style.display = 'none';
            encodeSection.style.display = 'none';
            verifySection.style.display = 'none';

            switch(this.value) {
                case 'decode':
                    decodeSection.style.display = 'block';
                    break;
                case 'encode':
                    encodeSection.style.display = 'block';
                    break;
                case 'verify':
                    verifySection.style.display = 'block';
                    break;
            }

            // Hide results when switching modes
            document.getElementById('results').style.display = 'none';
        });
    });

    // Decode form handler
    document.getElementById('decode-jwt-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        await handleJWTOperation('decode');
    });

    // Encode form handler
    document.getElementById('encode-jwt-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        await handleJWTOperation('encode');
    });

    // Verify form handler
    document.getElementById('verify-jwt-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        await handleJWTOperation('verify');
    });

    async function handleJWTOperation(operation) {
        // Show loading
        document.getElementById('loading').style.display = 'block';
        document.getElementById('results').style.display = 'none';

        let formData = new FormData();
        formData.append('operation', operation);
        formData.append('_token', document.querySelector('[name="_token"]').value);

        switch(operation) {
            case 'decode':
                formData.append('jwt_token', document.getElementById('jwt_token_decode').value);
                break;
            case 'encode':
                formData.append('algorithm', document.getElementById('algorithm').value);
                formData.append('secret_key', document.getElementById('secret_key').value);
                formData.append('jwt_payload', document.getElementById('jwt_payload').value);
                break;
            case 'verify':
                formData.append('jwt_token', document.getElementById('jwt_token_verify').value);
                formData.append('secret_key', document.getElementById('verify_secret').value);
                break;
        }

        try {
            const response = await fetch('{{ route("tools.kortex.tool.submit", "jwt-encoder-decoder") }}', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            // Hide loading
            document.getElementById('loading').style.display = 'none';

            if (result.success) {
                displayResults(result, operation);
            } else {
                displayError(result.error || 'An error occurred');
            }
        } catch (error) {
            document.getElementById('loading').style.display = 'none';
            displayError('Network error: ' + error.message);
        }
    }

    function displayResults(result, operation) {
        let html = '';
        let title = '';

        switch(operation) {
            case 'decode':
                title = '<i class="fas fa-unlock me-2"></i>Decoded JWT Token';
                html = `
                    <div class="row">
                        <div class="col-12 mb-4">
                            <h6>Header</h6>
                            <pre class="bg-light p-3 rounded border"><code>${JSON.stringify(result.header, null, 2)}</code></pre>
                        </div>
                        <div class="col-12 mb-4">
                            <h6>Payload</h6>
                            <pre class="bg-light p-3 rounded border"><code>${JSON.stringify(result.payload, null, 2)}</code></pre>
                        </div>
                        <div class="col-12 mb-4">
                            <h6>Signature</h6>
                            <div class="input-group">
                                <input type="text" class="form-control font-monospace" value="${result.signature}" readonly>
                                <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('${result.signature}')">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    ${result.exp_info ? `
                        <div class="alert ${result.is_expired ? 'alert-danger' : 'alert-success'}">
                            <h6><i class="fas fa-clock me-2"></i>Token Expiration</h6>
                            <p class="mb-0">
                                <strong>Expires:</strong> ${result.exp_info}<br>
                                <strong>Status:</strong> ${result.is_expired ? 'Expired' : 'Valid'}
                            </p>
                        </div>
                    ` : ''}
                `;
                break;

            case 'encode':
                title = '<i class="fas fa-lock me-2"></i>Generated JWT Token';
                html = `
                    <div class="mb-4">
                        <label class="form-label fw-bold">JWT Token:</label>
                        <div class="input-group">
                            <textarea class="form-control font-monospace" rows="6" readonly>${result.jwt_token}</textarea>
                            <button class="btn btn-outline-primary" type="button" onclick="copyToClipboard(\`${result.jwt_token}\`)">
                                <i class="fas fa-copy me-2"></i>Copy
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Header</div>
                                <div class="card-body">
                                    <pre class="mb-0"><code>${JSON.stringify(result.header_info, null, 2)}</code></pre>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Algorithm</div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="fs-5 text-primary">${result.algorithm}</div>
                                        <small class="text-muted">${result.algorithm_name}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                break;

            case 'verify':
                title = '<i class="fas fa-shield-alt me-2"></i>JWT Verification Results';
                html = `
                    <div class="alert ${result.is_valid ? 'alert-success' : 'alert-danger'} mb-4">
                        <h5 class="mb-2">
                            <i class="fas fa-${result.is_valid ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                            Token ${result.is_valid ? 'Valid' : 'Invalid'}
                        </h5>
                        <p class="mb-0">${result.verification_message}</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Signature Verification</div>
                                <div class="card-body text-center">
                                    <i class="fas fa-${result.signature_valid ? 'check-circle text-success' : 'times-circle text-danger'} fa-3x mb-2"></i>
                                    <div>${result.signature_valid ? 'Valid' : 'Invalid'}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Expiration Check</div>
                                <div class="card-body text-center">
                                    <i class="fas fa-${result.not_expired ? 'check-circle text-success' : 'exclamation-triangle text-warning'} fa-3x mb-2"></i>
                                    <div>${result.not_expired ? 'Not Expired' : 'Expired'}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    ${result.token_details ? `
                        <div class="mt-4">
                            <h6>Token Details</h6>
                            <div class="row">
                                <div class="col-12">
                                    <pre class="bg-light p-3 rounded border"><code>${JSON.stringify(result.token_details, null, 2)}</code></pre>
                                </div>
                            </div>
                        </div>
                    ` : ''}
                `;
                break;
        }

        document.getElementById('results-title').innerHTML = title;
        document.getElementById('results-content').innerHTML = html;
        document.getElementById('results').style.display = 'block';
    }

    function displayError(error) {
        const html = `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>Error:</strong> ${error}
            </div>

            <div class="alert alert-info">
                <h6><i class="fas fa-lightbulb me-2"></i>Common Issues</h6>
                <ul class="mb-0">
                    <li>Check that JWT token format is correct (header.payload.signature)</li>
                    <li>Ensure JSON payload is valid for encoding</li>
                    <li>Verify the secret key is correct for verification</li>
                    <li>Make sure the algorithm matches the token's algorithm</li>
                </ul>
            </div>
        `;

        document.getElementById('results-title').innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>Error';
        document.getElementById('results-content').innerHTML = html;
        document.getElementById('results').style.display = 'block';
    }

    window.copyToClipboard = function(text) {
        navigator.clipboard.writeText(text).then(function() {
            // Show temporary success message
            const btn = event.target.closest('button');
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
            btn.classList.remove('btn-outline-secondary', 'btn-outline-primary');
            btn.classList.add('btn-success');

            setTimeout(function() {
                btn.innerHTML = originalContent;
                btn.classList.remove('btn-success');
                btn.classList.add(originalContent.includes('Copy') ? 'btn-outline-primary' : 'btn-outline-secondary');
            }, 2000);
        });
    };
});
</script>

