{{-- SQL Formatter --}}
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-database me-3"></i>SQL Formatter
                </h1>
                <p class="lead text-muted">
                    Format and beautify your SQL queries with proper indentation
                </p>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-input-text me-2"></i>Input SQL</h5>
                        </div>
                        <div class="card-body">
                            <textarea id="sqlInput" class="form-control" rows="10" placeholder="Paste your SQL query here..." style="font-family: 'Courier New', monospace;"></textarea>
                            <div class="mt-3 d-grid gap-2">
                                <button type="button" id="formatBtn" class="btn btn-primary">
                                    <i class="fas fa-wand-magic-sparkles me-2"></i>Format SQL
                                </button>
                                <button type="button" id="clearBtn" class="btn btn-secondary">
                                    <i class="fas fa-trash me-2"></i>Clear
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-check-circle me-2"></i>Formatted Output</h5>
                        </div>
                        <div class="card-body">
                            <textarea id="sqlOutput" class="form-control" rows="10" readonly style="font-family: 'Courier New', monospace;"></textarea>
                            <div class="mt-3">
                                <button type="button" id="copyBtn" class="btn btn-info w-100">
                                    <i class="fas fa-copy me-2"></i>Copy to Clipboard
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Options -->
            <div class="row mt-4">
                <div class="col-lg-10 mx-auto">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-sliders-h me-2"></i>Formatting Options</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="indentSize" class="form-label">Indent Size</label>
                                    <select id="indentSize" class="form-select">
                                        <option value="2">2 Spaces</option>
                                        <option value="4" selected>4 Spaces</option>
                                        <option value="8">8 Spaces</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="uppercaseKeywords" checked>
                                        <label class="form-check-label" for="uppercaseKeywords">
                                            Uppercase keywords
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="newlineAfterComma">
                                        <label class="form-check-label" for="newlineAfterComma">
                                            New line after comma
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('sqlInput');
    const output = document.getElementById('sqlOutput');
    const formatBtn = document.getElementById('formatBtn');
    const clearBtn = document.getElementById('clearBtn');
    const copyBtn = document.getElementById('copyBtn');
    const indentSize = document.getElementById('indentSize');
    const uppercaseKeywords = document.getElementById('uppercaseKeywords');
    const newlineAfterComma = document.getElementById('newlineAfterComma');

    formatBtn.addEventListener('click', function() {
        const sql = input.value.trim();
        if (!sql) {
            output.value = '';
            return;
        }
        const formatted = formatSQL(sql);
        output.value = formatted;
    });

    clearBtn.addEventListener('click', function() {
        input.value = '';
        output.value = '';
        input.focus();
    });

    copyBtn.addEventListener('click', function() {
        output.select();
        document.execCommand('copy');
        const originalText = copyBtn.innerHTML;
        copyBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
        setTimeout(() => {
            copyBtn.innerHTML = originalText;
        }, 2000);
    });

    function formatSQL(sql) {
        const indent = ' '.repeat(parseInt(indentSize.value));
        const keywords = [
            'SELECT', 'FROM', 'WHERE', 'JOIN', 'INNER', 'LEFT', 'RIGHT', 'OUTER',
            'ON', 'AND', 'OR', 'NOT', 'IN', 'EXISTS', 'BETWEEN', 'LIKE',
            'ORDER', 'BY', 'GROUP', 'HAVING', 'LIMIT', 'OFFSET',
            'INSERT', 'INTO', 'VALUES', 'UPDATE', 'SET', 'DELETE',
            'CREATE', 'TABLE', 'DROP', 'ALTER', 'ADD', 'COLUMN',
            'DISTINCT', 'AS', 'UNION', 'ALL', 'CASE', 'WHEN', 'THEN', 'ELSE', 'END',
            'WITH', 'CTE', 'CROSS', 'NATURAL', 'USING',
            'IS', 'NULL', 'TRUE', 'FALSE'
        ];

        let formatted = sql;

        // Normalize whitespace
        formatted = formatted.replace(/\s+/g, ' ');

        // Add newlines before main keywords
        keywords.forEach(keyword => {
            const regex = new RegExp('\\b' + keyword + '\\b', 'gi');
            formatted = formatted.replace(regex, '\n' + keyword);
        });

        // Handle commas
        if (newlineAfterComma.checked) {
            formatted = formatted.replace(/,/g, ',\n');
        }

        // Handle parentheses
        formatted = formatted.replace(/\(/g, '\n(');
        formatted = formatted.replace(/\)/g, '\n)');

        // Uppercase keywords if enabled
        if (uppercaseKeywords.checked) {
            keywords.forEach(keyword => {
                const regex = new RegExp('\\b' + keyword + '\\b', 'gi');
                formatted = formatted.replace(regex, keyword.toUpperCase());
            });
        } else {
            keywords.forEach(keyword => {
                const regex = new RegExp('\\b' + keyword + '\\b', 'gi');
                formatted = formatted.replace(regex, keyword.toLowerCase());
            });
        }

        // Apply indentation
        let lines = formatted.split('\n');
        let indentLevel = 0;
        let result = [];

        for (let i = 0; i < lines.length; i++) {
            let line = lines[i].trim();

            if (!line) continue;

            // Decrease indent for closing parenthesis
            if (line.startsWith(')')) {
                indentLevel = Math.max(0, indentLevel - 1);
            }

            // Add indentation
            result.push(indent.repeat(indentLevel) + line);

            // Increase indent for opening parenthesis or SELECT/FROM/WHERE
            if (line.endsWith('(')) {
                indentLevel++;
            }
            if (line.startsWith('(')) {
                indentLevel++;
            }

            // Increase indent after main keywords
            if (/^(SELECT|FROM|WHERE|JOIN|GROUP|ORDER|HAVING)/i.test(line)) {
                indentLevel++;
            }
        }

        return result.join('\n');
    }
});
</script>
