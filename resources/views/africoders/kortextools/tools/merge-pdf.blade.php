{{-- merge pdf --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    merge pdf tool for your development and productivity needs.
</div>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="text-center mb-4">
                <h1 class="h2 mb-3">
                    <i class="fas fa-file-pdf text-danger me-2"></i>
                    Merge PDF Files
                </h1>
                <p class="text-muted">Combine multiple PDF files into a single document</p>
            </div>

            <!-- Upload Area -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="upload-area text-center p-4 border-2 border-dashed rounded" id="uploadArea">
                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                        <h5 class="mb-3">Drop PDF files here or click to upload</h5>
                        <p class="text-muted mb-3">Select multiple PDF files to merge them into one</p>
                        <input type="file" id="pdfInput" accept=".pdf" multiple class="d-none">
                        <button type="button" class="btn btn-primary" id="selectFilesBtn">
                            <i class="fas fa-plus me-2"></i>Select PDF Files
                        </button>
                    </div>

                    <!-- File List -->
                    <div id="fileList" class="mt-4" style="display: none;">
                        <h6 class="fw-semibold mb-3">Selected Files:</h6>
                        <div id="fileItems" class="list-group"></div>

                        <!-- Merge Options -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Output Filename</label>
                                <input type="text" class="form-control" id="outputFilename" value="merged-document.pdf">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Merge Order</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mergeOrder" id="orderUploaded" value="uploaded" checked>
                                    <label class="form-check-label" for="orderUploaded">
                                        Order uploaded
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mergeOrder" id="orderAlphabetical" value="alphabetical">
                                    <label class="form-check-label" for="orderAlphabetical">
                                        Alphabetical order
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 mt-4">
                            <button type="button" class="btn btn-success btn-lg" id="mergeBtn" disabled>
                                <i class="fas fa-layer-group me-2"></i>Merge PDFs
                            </button>
                            <button type="button" class="btn btn-outline-secondary" id="clearAllBtn">
                                <i class="fas fa-trash me-2"></i>Clear All
                            </button>
                        </div>
                    </div>

                    <!-- Progress -->
                    <div id="progressArea" class="mt-4" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Merging PDFs...</span>
                            <span id="progressText">0%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" id="progressBar" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>

                    <!-- Result -->
                    <div id="resultArea" class="mt-4" style="display: none;">
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Success!</strong> Your PDF files have been merged successfully.
                        </div>
                        <div class="d-flex align-items-center justify-content-between bg-light p-3 rounded">
                            <div>
                                <i class="fas fa-file-pdf text-danger me-2"></i>
                                <span id="resultFileName">merged-document.pdf</span>
                                <small class="text-muted ms-2" id="resultFileSize"></small>
                            </div>
                            <button type="button" class="btn btn-primary" id="downloadBtn">
                                <i class="fas fa-download me-2"></i>Download
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features & Instructions -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <h6 class="card-title">How to Merge PDFs</h6>
                            <ol class="small text-muted mb-0">
                                <li>Click "Select PDF Files" or drag and drop PDF files</li>
                                <li>Rearrange files in your desired order</li>
                                <li>Choose merge options and output filename</li>
                                <li>Click "Merge PDFs" to combine them</li>
                                <li>Download your merged PDF file</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <h6 class="card-title">Features</h6>
                            <ul class="small text-muted mb-0">
                                <li>Merge unlimited PDF files</li>
                                <li>Drag and drop file upload</li>
                                <li>Reorder files before merging</li>
                                <li>Custom output filename</li>
                                <li>Secure - files processed locally</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Note -->
            <div class="alert alert-info mt-4">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Note:</strong> This tool processes PDF files in your browser. Your files are not uploaded to any server, ensuring complete privacy and security.
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.getElementById('uploadArea');
    const pdfInput = document.getElementById('pdfInput');
    const selectFilesBtn = document.getElementById('selectFilesBtn');
    const fileList = document.getElementById('fileList');
    const fileItems = document.getElementById('fileItems');
    const mergeBtn = document.getElementById('mergeBtn');
    const clearAllBtn = document.getElementById('clearAllBtn');
    const progressArea = document.getElementById('progressArea');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    const resultArea = document.getElementById('resultArea');
    const downloadBtn = document.getElementById('downloadBtn');
    const outputFilename = document.getElementById('outputFilename');
    const resultFileName = document.getElementById('resultFileName');
    const resultFileSize = document.getElementById('resultFileSize');

    let pdfFiles = [];
    let mergedPdfBytes = null;

    // File upload handlers
    selectFilesBtn.addEventListener('click', () => pdfInput.click());

    pdfInput.addEventListener('change', function(e) {
        handleFiles(Array.from(e.target.files));
    });

    // Drag and drop
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('border-primary');
    });

    uploadArea.addEventListener('dragleave', function() {
        uploadArea.classList.remove('border-primary');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('border-primary');

        const files = Array.from(e.dataTransfer.files).filter(file => file.type === 'application/pdf');
        if (files.length === 0) {
            alert('Please drop only PDF files.');
            return;
        }
        handleFiles(files);
    });

    // Handle file selection
    function handleFiles(files) {
        files.forEach(file => {
            if (file.type === 'application/pdf') {
                pdfFiles.push({
                    file: file,
                    id: Date.now() + Math.random(),
                    name: file.name,
                    size: file.size
                });
            }
        });

        updateFileList();
        updateMergeButton();
    }

    // Update file list display
    function updateFileList() {
        if (pdfFiles.length === 0) {
            fileList.style.display = 'none';
            return;
        }

        fileList.style.display = 'block';
        fileItems.innerHTML = '';

        pdfFiles.forEach((pdfFile, index) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'list-group-item d-flex justify-content-between align-items-center';
            fileItem.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="drag-handle me-2" style="cursor: grab;">
                        <i class="fas fa-grip-vertical text-muted"></i>
                    </div>
                    <i class="fas fa-file-pdf text-danger me-2"></i>
                    <div>
                        <div class="fw-semibold">${pdfFile.name}</div>
                        <small class="text-muted">${formatFileSize(pdfFile.size)}</small>
                    </div>
                </div>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary move-up" ${index === 0 ? 'disabled' : ''}>
                        <i class="fas fa-arrow-up"></i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary move-down" ${index === pdfFiles.length - 1 ? 'disabled' : ''}>
                        <i class="fas fa-arrow-down"></i>
                    </button>
                    <button type="button" class="btn btn-outline-danger remove-file">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;

            // Add event listeners for buttons
            fileItem.querySelector('.move-up').addEventListener('click', () => moveFile(index, -1));
            fileItem.querySelector('.move-down').addEventListener('click', () => moveFile(index, 1));
            fileItem.querySelector('.remove-file').addEventListener('click', () => removeFile(index));

            fileItems.appendChild(fileItem);
        });
    }

    // Move file in list
    function moveFile(index, direction) {
        const newIndex = index + direction;
        if (newIndex >= 0 && newIndex < pdfFiles.length) {
            [pdfFiles[index], pdfFiles[newIndex]] = [pdfFiles[newIndex], pdfFiles[index]];
            updateFileList();
        }
    }

    // Remove file from list
    function removeFile(index) {
        pdfFiles.splice(index, 1);
        updateFileList();
        updateMergeButton();
    }

    // Update merge button state
    function updateMergeButton() {
        mergeBtn.disabled = pdfFiles.length < 2;
    }

    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 B';
        const k = 1024;
        const sizes = ['B', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
    }

    // Merge PDFs
    mergeBtn.addEventListener('click', async function() {
        if (pdfFiles.length < 2) {
            alert('Please select at least 2 PDF files to merge.');
            return;
        }

        // Sort files if alphabetical order is selected
        const mergeOrder = document.querySelector('input[name="mergeOrder"]:checked').value;
        if (mergeOrder === 'alphabetical') {
            pdfFiles.sort((a, b) => a.name.localeCompare(b.name));
        }

        try {
            progressArea.style.display = 'block';
            resultArea.style.display = 'none';
            mergeBtn.disabled = true;

            // Create a new PDF document
            const mergedPdf = await PDFLib.PDFDocument.create();

            for (let i = 0; i < pdfFiles.length; i++) {
                const progress = ((i + 1) / pdfFiles.length) * 100;
                progressBar.style.width = progress + '%';
                progressText.textContent = Math.round(progress) + '%';

                // Read the PDF file
                const arrayBuffer = await pdfFiles[i].file.arrayBuffer();
                const pdf = await PDFLib.PDFDocument.load(arrayBuffer);

                // Copy all pages to the merged PDF
                const pages = await mergedPdf.copyPages(pdf, pdf.getPageIndices());
                pages.forEach((page) => mergedPdf.addPage(page));
            }

            // Save the merged PDF
            mergedPdfBytes = await mergedPdf.save();

            // Show result
            progressArea.style.display = 'none';
            resultArea.style.display = 'block';
            resultFileName.textContent = outputFilename.value || 'merged-document.pdf';
            resultFileSize.textContent = formatFileSize(mergedPdfBytes.length);

        } catch (error) {
            alert('Error merging PDFs: ' + error.message);
            progressArea.style.display = 'none';
        } finally {
            mergeBtn.disabled = false;
        }
    });

    // Download merged PDF
    downloadBtn.addEventListener('click', function() {
        if (!mergedPdfBytes) {
            alert('No merged PDF available to download.');
            return;
        }

        const blob = new Blob([mergedPdfBytes], { type: 'application/pdf' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = outputFilename.value || 'merged-document.pdf';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    });

    // Clear all files
    clearAllBtn.addEventListener('click', function() {
        if (confirm('Remove all selected files?')) {
            pdfFiles = [];
            updateFileList();
            updateMergeButton();
            progressArea.style.display = 'none';
            resultArea.style.display = 'none';
            mergedPdfBytes = null;
        }
    });
});
</script>

<style>
.upload-area {
    transition: all 0.3s ease;
    cursor: pointer;
}

.upload-area:hover {
    background-color: #f8f9fa;
}

.upload-area.border-primary {
    background-color: #e7f3ff;
}

.drag-handle:active {
    cursor: grabbing;
}

.list-group-item {
    border-left: 4px solid transparent;
}

.list-group-item:hover {
    border-left-color: #007bff;
    background-color: #f8f9fa;
}
</style>

