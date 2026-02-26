{{-- Online Text Editor --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-edit me-2"></i>
    Free online text editor with rich formatting, word count, and document management features.
</div>>
            <!-- Header -->
            <div class="text-center mb-4">
                <h1 class="h2 mb-3">
                    <i class="fas fa-edit text-primary me-2"></i>
                    Online Text Editor
                </h1>
                <p class="text-muted">Professional text editor with formatting tools and document management</p>
            </div>

            <!-- Tool Interface -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-outline-secondary" id="newDocBtn">
                                    <i class="fas fa-file"></i> New
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="saveBtn">
                                    <i class="fas fa-save"></i> Save
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="loadBtn">
                                    <i class="fas fa-folder-open"></i> Load
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-outline-secondary" id="undoBtn">
                                    <i class="fas fa-undo"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="redoBtn">
                                    <i class="fas fa-redo"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Formatting Toolbar -->
                    <div class="toolbar mb-3 p-2 bg-light rounded">
                        <div class="row g-2">
                            <div class="col-auto">
                                <select class="form-select form-select-sm" id="fontFamily">
                                    <option value="Arial">Arial</option>
                                    <option value="Times New Roman">Times New Roman</option>
                                    <option value="Courier New">Courier New</option>
                                    <option value="Georgia">Georgia</option>
                                    <option value="Verdana">Verdana</option>
                                </select>
                            </div>
                            <div class="col-auto">
                                <select class="form-select form-select-sm" id="fontSize">
                                    <option value="12px">12px</option>
                                    <option value="14px" selected>14px</option>
                                    <option value="16px">16px</option>
                                    <option value="18px">18px</option>
                                    <option value="20px">20px</option>
                                    <option value="24px">24px</option>
                                </select>
                            </div>
                            <div class="col-auto">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-secondary" id="boldBtn">
                                        <i class="fas fa-bold"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" id="italicBtn">
                                        <i class="fas fa-italic"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" id="underlineBtn">
                                        <i class="fas fa-underline"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-secondary" id="alignLeftBtn">
                                        <i class="fas fa-align-left"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" id="alignCenterBtn">
                                        <i class="fas fa-align-center"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" id="alignRightBtn">
                                        <i class="fas fa-align-right"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-auto">
                                <input type="color" class="form-control form-control-sm form-control-color" id="textColor" value="#000000" title="Text Color">
                            </div>
                        </div>
                    </div>

                    <!-- Editor -->
                    <div class="editor-container">
                        <div contenteditable="true" id="textEditor" class="form-control editor-area" style="min-height: 400px; font-family: Arial; font-size: 14px; line-height: 1.6;">
                            <p>Start typing your document here...</p>
                            <p>This is a full-featured online text editor. You can format text, change fonts, adjust alignment, and more.</p>
                            <p><strong>Bold text</strong>, <em>italic text</em>, and <u>underlined text</u> are all supported.</p>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="d-flex gap-4 text-muted small">
                                <span>Words: <strong id="wordCount">0</strong></span>
                                <span>Characters: <strong id="charCount">0</strong></span>
                                <span>Characters (no spaces): <strong id="charCountNoSpaces">0</strong></span>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-secondary" id="copyAllBtn">
                                    <i class="fas fa-copy"></i> Copy All
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="clearAllBtn">
                                    <i class="fas fa-trash"></i> Clear
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- File Upload Area -->
            <input type="file" id="fileInput" accept=".txt" style="display: none;">

            <!-- Features -->
            <div class="card mt-4 bg-light border-0">
                <div class="card-body">
                    <h5 class="card-title">Text Editor Features</h5>
                    <div class="row text-muted small">
                        <div class="col-md-6">
                            <ul class="mb-0">
                                <li>Rich text formatting (bold, italic, underline)</li>
                                <li>Font family and size selection</li>
                                <li>Text alignment options</li>
                                <li>Color customization</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="mb-0">
                                <li>Real-time word and character counting</li>
                                <li>Save and load text files</li>
                                <li>Undo/redo functionality</li>
                                <li>Copy and clear operations</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editor = document.getElementById('textEditor');
    const wordCount = document.getElementById('wordCount');
    const charCount = document.getElementById('charCount');
    const charCountNoSpaces = document.getElementById('charCountNoSpaces');
    const fileInput = document.getElementById('fileInput');

    // Formatting buttons
    const boldBtn = document.getElementById('boldBtn');
    const italicBtn = document.getElementById('italicBtn');
    const underlineBtn = document.getElementById('underlineBtn');
    const alignLeftBtn = document.getElementById('alignLeftBtn');
    const alignCenterBtn = document.getElementById('alignCenterBtn');
    const alignRightBtn = document.getElementById('alignRightBtn');
    const fontFamily = document.getElementById('fontFamily');
    const fontSize = document.getElementById('fontSize');
    const textColor = document.getElementById('textColor');

    // Action buttons
    const newDocBtn = document.getElementById('newDocBtn');
    const saveBtn = document.getElementById('saveBtn');
    const loadBtn = document.getElementById('loadBtn');
    const undoBtn = document.getElementById('undoBtn');
    const redoBtn = document.getElementById('redoBtn');
    const copyAllBtn = document.getElementById('copyAllBtn');
    const clearAllBtn = document.getElementById('clearAllBtn');

    // History for undo/redo
    let history = [];
    let historyIndex = -1;

    // Update statistics
    function updateStats() {
        const text = editor.innerText || '';
        const words = text.trim() ? text.trim().split(/\s+/).length : 0;
        const chars = text.length;
        const charsNoSpaces = text.replace(/\s/g, '').length;

        wordCount.textContent = words.toLocaleString();
        charCount.textContent = chars.toLocaleString();
        charCountNoSpaces.textContent = charsNoSpaces.toLocaleString();
    }

    // Save state to history
    function saveState() {
        historyIndex++;
        history = history.slice(0, historyIndex);
        history.push(editor.innerHTML);
    }

    // Execute command
    function execCmd(command, value = null) {
        document.execCommand(command, false, value);
        editor.focus();
        updateStats();
        saveState();
    }

    // Formatting event listeners
    boldBtn.addEventListener('click', () => execCmd('bold'));
    italicBtn.addEventListener('click', () => execCmd('italic'));
    underlineBtn.addEventListener('click', () => execCmd('underline'));
    alignLeftBtn.addEventListener('click', () => execCmd('justifyLeft'));
    alignCenterBtn.addEventListener('click', () => execCmd('justifyCenter'));
    alignRightBtn.addEventListener('click', () => execCmd('justifyRight'));

    fontFamily.addEventListener('change', function() {
        execCmd('fontName', this.value);
    });

    fontSize.addEventListener('change', function() {
        execCmd('fontSize', '3');
        const selection = window.getSelection();
        if (selection.rangeCount) {
            const range = selection.getRangeAt(0);
            const span = document.createElement('span');
            span.style.fontSize = this.value;
            try {
                range.surroundContents(span);
            } catch (e) {
                // Fallback if surroundContents fails
                span.appendChild(range.extractContents());
                range.insertNode(span);
            }
        }
    });

    textColor.addEventListener('change', function() {
        execCmd('foreColor', this.value);
    });

    // Action buttons
    newDocBtn.addEventListener('click', function() {
        if (confirm('Start a new document? Unsaved changes will be lost.')) {
            editor.innerHTML = '<p>Start typing your document here...</p>';
            updateStats();
            saveState();
        }
    });

    saveBtn.addEventListener('click', function() {
        const content = editor.innerText || '';
        const blob = new Blob([content], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'document.txt';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    });

    loadBtn.addEventListener('click', function() {
        fileInput.click();
    });

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.type === 'text/plain') {
            const reader = new FileReader();
            reader.onload = function(e) {
                editor.innerHTML = '<p>' + e.target.result.replace(/\n/g, '</p><p>') + '</p>';
                updateStats();
                saveState();
            };
            reader.readAsText(file);
        } else {
            alert('Please select a text file (.txt)');
        }
    });

    undoBtn.addEventListener('click', function() {
        if (historyIndex > 0) {
            historyIndex--;
            editor.innerHTML = history[historyIndex];
            updateStats();
        }
    });

    redoBtn.addEventListener('click', function() {
        if (historyIndex < history.length - 1) {
            historyIndex++;
            editor.innerHTML = history[historyIndex];
            updateStats();
        }
    });

    copyAllBtn.addEventListener('click', function() {
        const range = document.createRange();
        range.selectNodeContents(editor);
        const selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);
        document.execCommand('copy');
        selection.removeAllRanges();

        const originalText = this.innerHTML;
        this.innerHTML = '<i class="fas fa-check"></i> Copied!';
        this.classList.replace('btn-outline-secondary', 'btn-success');

        setTimeout(() => {
            this.innerHTML = originalText;
            this.classList.replace('btn-success', 'btn-outline-secondary');
        }, 2000);
    });

    clearAllBtn.addEventListener('click', function() {
        if (confirm('Clear all content? This cannot be undone.')) {
            editor.innerHTML = '';
            updateStats();
            saveState();
        }
    });

    // Auto-save to localStorage
    function autoSave() {
        localStorage.setItem('textEditorContent', editor.innerHTML);
    }

    // Load from localStorage
    function autoLoad() {
        const saved = localStorage.getItem('textEditorContent');
        if (saved) {
            editor.innerHTML = saved;
        }
    }

    // Event listeners
    editor.addEventListener('input', function() {
        updateStats();
        autoSave();
    });

    editor.addEventListener('keydown', function(e) {
        if (e.ctrlKey || e.metaKey) {
            switch (e.key) {
                case 'b':
                    e.preventDefault();
                    execCmd('bold');
                    break;
                case 'i':
                    e.preventDefault();
                    execCmd('italic');
                    break;
                case 'u':
                    e.preventDefault();
                    execCmd('underline');
                    break;
                case 'z':
                    e.preventDefault();
                    if (e.shiftKey) {
                        redoBtn.click();
                    } else {
                        undoBtn.click();
                    }
                    break;
                case 's':
                    e.preventDefault();
                    saveBtn.click();
                    break;
            }
        }
    });

    // Initialize
    autoLoad();
    updateStats();
    saveState();
});
</script>

<style>
.editor-area {
    border: 2px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 15px;
    overflow-y: auto;
    background: white;
}

.editor-area:focus {
    outline: none;
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.toolbar {
    border: 1px solid #dee2e6;
}

.btn-group .btn {
    border-radius: 0.375rem;
}

.btn-group .btn:not(:last-child) {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.btn-group .btn:not(:first-child) {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    border-left: 0;
}

.form-control-color {
    width: 40px;
    height: 31px;
    padding: 1px 2px;
}
</style>

