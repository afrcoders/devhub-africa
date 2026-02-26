<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-envelope"></i> Fake Email Generator</h4>
                </div>
                <div class="card-body">
                    <form id="toolForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="count" class="form-label">Number of emails:</label>
                                <select class="form-select" id="count" name="count">
                                    <option value="1" selected>1 email</option>
                                    <option value="5">5 emails</option>
                                    <option value="10">10 emails</option>
                                    <option value="25">25 emails</option>
                                    <option value="50">50 emails</option>
                                    <option value="100">100 emails</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="domain" class="form-label">Email Domain:</label>
                                <select class="form-select" id="domain" name="domain">
                                    <option value="gmail.com" selected>gmail.com</option>
                                    <option value="yahoo.com">yahoo.com</option>
                                    <option value="outlook.com">outlook.com</option>
                                    <option value="hotmail.com">hotmail.com</option>
                                    <option value="example.com">example.com</option>
                                    <option value="test.com">test.com</option>
                                    <option value="custom">Custom domain...</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3" id="customDomainContainer" style="display: none;">
                            <label for="customDomain" class="form-label">Custom Domain:</label>
                            <input type="text" class="form-control" id="customDomain" name="customDomain" placeholder="example.com">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="format" class="form-label">Name Format:</label>
                                <select class="form-select" id="format" name="format">
                                    <option value="firstname.lastname" selected>firstname.lastname</option>
                                    <option value="firstnamelastname">firstnamelastname</option>
                                    <option value="firstname_lastname">firstname_lastname</option>
                                    <option value="firstinitiallastname">f.lastname</option>
                                    <option value="random">Random characters</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="includeNumbers" class="form-label">Include Numbers:</label>
                                <select class="form-select" id="includeNumbers" name="includeNumbers">
                                    <option value="no" selected>No numbers</option>
                                    <option value="sometimes">Sometimes</option>
                                    <option value="always">Always</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-magic"></i> Generate Fake Emails
                            </button>
                        </div>
                    </form>

                    <!-- Results -->
                    <div id="result" style="display: none;" class="mt-4">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="fas fa-list"></i> Generated Email Addresses</h5>
                                <div>
                                    <button type="button" id="copyAllBtn" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-copy"></i> Copy All
                                    </button>
                                    <button type="button" id="downloadBtn" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-download"></i> Download
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="emailList" class="mb-3">
                                    <!-- Generated emails will be displayed here -->
                                </div>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Note:</strong> These are fake emails for testing only. Don't use for real communication.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Error message -->
                    <div id="error" style="display: none;" class="alert alert-danger mt-3" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> <span id="errorMessage"></span>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card mt-3">
                <div class="card-body">
                    <h6><i class="fas fa-lightbulb text-warning"></i> Use Cases:</h6>
                    <ul class="small mb-0">
                        <li>Software testing and QA</li>
                        <li>Database seeding and mock data</li>
                        <li>Form validation testing</li>
                        <li>Email system development</li>
                        <li>Privacy protection in demos</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Show/hide custom domain input
document.getElementById('domain').addEventListener('change', function() {
    const customContainer = document.getElementById('customDomainContainer');
    if (this.value === 'custom') {
        customContainer.style.display = 'block';
        document.getElementById('customDomain').required = true;
    } else {
        customContainer.style.display = 'none';
        document.getElementById('customDomain').required = false;
    }
});

document.getElementById('toolForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const count = parseInt(formData.get('count'));
    const domain = formData.get('domain') === 'custom' ? formData.get('customDomain') : formData.get('domain');
    const format = formData.get('format');
    const includeNumbers = formData.get('includeNumbers');

    if (!domain || (formData.get('domain') === 'custom' && !formData.get('customDomain'))) {
        document.getElementById('error').style.display = 'block';
        document.getElementById('errorMessage').textContent = 'Please specify an email domain.';
        return;
    }

    try {
        const emails = generateFakeEmails(count, domain, format, includeNumbers);

        // Display emails
        const emailList = document.getElementById('emailList');
        let html = '<div class="row">';

        emails.forEach((email, index) => {
            html += `
                <div class="col-md-6 col-12 mb-2">
                    <div class="d-flex align-items-center bg-light p-2 rounded">
                        <span class="flex-grow-1 font-monospace">${email}</span>
                        <button type="button" class="btn btn-sm btn-outline-primary ms-2" onclick="copyEmail('${email}', this)">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
            `;
        });

        html += '</div>';
        emailList.innerHTML = html;

        // Set up copy all button
        document.getElementById('copyAllBtn').onclick = function() {
            const emailText = emails.join('\\n');
            navigator.clipboard.writeText(emailText).then(() => {
                const btn = this;
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check"></i> Copied!';
                setTimeout(() => btn.innerHTML = originalText, 2000);
            });
        };

        // Set up download button
        document.getElementById('downloadBtn').onclick = function() {
            const emailText = emails.join('\\n');
            const blob = new Blob([emailText], { type: 'text/plain' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `fake_emails_${Date.now()}.txt`;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
        };

        document.getElementById('result').style.display = 'block';
        document.getElementById('error').style.display = 'none';

    } catch (err) {
        document.getElementById('error').style.display = 'block';
        document.getElementById('errorMessage').textContent = 'Error generating emails: ' + err.message;
        document.getElementById('result').style.display = 'none';
    }
});

function generateFakeEmails(count, domain, format, includeNumbers) {
    const firstNames = ['john', 'jane', 'mike', 'sarah', 'david', 'emma', 'james', 'lisa', 'robert', 'mary', 'william', 'jennifer', 'michael', 'linda', 'richard', 'elizabeth', 'charles', 'barbara', 'joseph', 'susan', 'thomas', 'jessica', 'daniel', 'karen', 'matthew', 'nancy', 'anthony', 'betty', 'mark', 'helen', 'donald', 'sandra', 'steven', 'donna', 'paul', 'carol', 'andrew', 'ruth', 'joshua', 'sharon', 'kenneth', 'michelle', 'kevin', 'laura', 'brian', 'sarah', 'george', 'kimberly', 'edward', 'deborah'];
    const lastNames = ['smith', 'johnson', 'williams', 'brown', 'jones', 'garcia', 'miller', 'davis', 'rodriguez', 'martinez', 'hernandez', 'lopez', 'gonzalez', 'wilson', 'anderson', 'thomas', 'taylor', 'moore', 'jackson', 'martin', 'lee', 'perez', 'thompson', 'white', 'harris', 'sanchez', 'clark', 'ramirez', 'lewis', 'robinson', 'walker', 'young', 'allen', 'king', 'wright', 'scott', 'torres', 'nguyen', 'hill', 'flores', 'green', 'adams', 'nelson', 'baker', 'hall', 'rivera', 'campbell', 'mitchell', 'carter', 'roberts'];

    const emails = new Set(); // Use Set to avoid duplicates

    while (emails.size < count) {
        let email = '';

        if (format === 'random') {
            const randomStr = Math.random().toString(36).substring(2, 8);
            email = randomStr + '@' + domain;
        } else {
            const firstName = firstNames[Math.floor(Math.random() * firstNames.length)];
            const lastName = lastNames[Math.floor(Math.random() * lastNames.length)];

            switch (format) {
                case 'firstname.lastname':
                    email = firstName + '.' + lastName;
                    break;
                case 'firstnamelastname':
                    email = firstName + lastName;
                    break;
                case 'firstname_lastname':
                    email = firstName + '_' + lastName;
                    break;
                case 'firstinitiallastname':
                    email = firstName.charAt(0) + '.' + lastName;
                    break;
            }

            // Add numbers if requested
            if (includeNumbers === 'always' || (includeNumbers === 'sometimes' && Math.random() > 0.5)) {
                email += Math.floor(Math.random() * 100);
            }

            email += '@' + domain;
        }

        emails.add(email);
    }

    return Array.from(emails);
}

function copyEmail(email, button) {
    navigator.clipboard.writeText(email).then(() => {
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check"></i>';
        button.classList.remove('btn-outline-primary');
        button.classList.add('btn-success');
        setTimeout(() => {
            button.innerHTML = originalText;
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-primary');
        }, 1500);
    });
}
</script>