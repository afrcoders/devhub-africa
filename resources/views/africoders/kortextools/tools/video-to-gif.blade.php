<form id="videoToGifForm" enctype="multipart/form-data">@csrf
    <div class="mb-3">
        <label for="videoFile" class="form-label">Select Video File</label>
        <input type="file" class="form-control" id="videoFile" name="file" accept="video/*" required>
        <div class="form-text">Upload a video file to convert to animated GIF.</div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="startTime" class="form-label">Start Time (seconds)</label>
            <input type="number" class="form-control" id="startTime" name="start_time" value="0" min="0" step="0.1">
        </div>
        <div class="col-md-6">
            <label for="duration" class="form-label">Duration (seconds)</label>
            <input type="number" class="form-control" id="duration" name="duration" value="5" min="1" max="30" step="0.1">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="width" class="form-label">Width (pixels)</label>
            <input type="number" class="form-control" id="width" name="width" value="320" min="100" max="800">
        </div>
        <div class="col-md-6">
            <label for="fps" class="form-label">Frame Rate (FPS)</label>
            <select class="form-select" id="fps" name="fps">
                <option value="10">10 FPS</option>
                <option value="15" selected>15 FPS</option>
                <option value="24">24 FPS</option>
                <option value="30">30 FPS</option>
            </select>
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100">
        <i class="fas fa-play-circle me-1"></i>
        Convert to GIF
    </button>
</form>

<div id="result" class="mt-4" style="display:none;">
    <div class="alert alert-success">
        <h6>Conversion Complete!</h6>
        <p id="resultMessage" class="mb-2"></p>
        <a id="downloadLink" href="#" class="btn btn-success btn-sm" download>
            <i class="fas fa-download me-1"></i>
            Download GIF
        </a>
    </div>
</div>

<div id="loading" class="mt-4" style="display:none;">
    <div class="alert alert-info">
        <div class="d-flex align-items-center">
            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
            <span>Converting video to GIF...</span>
        </div>
    </div>
</div>

<script>
document.getElementById('videoToGifForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData();
    const fileInput = document.getElementById('videoFile');

    if (!fileInput.files[0]) {
        alert('Please select a video file');
        return;
    }

    formData.append('file', fileInput.files[0]);
    formData.append('start_time', document.getElementById('startTime').value);
    formData.append('duration', document.getElementById('duration').value);
    formData.append('width', document.getElementById('width').value);
    formData.append('fps', document.getElementById('fps').value);
    formData.append('tool', 'video-to-gif');

    // Show loading
    document.getElementById('loading').style.display = 'block';
    document.getElementById('result').style.display = 'none';

    try {
        const response = await fetch('{{ route("tools.kortex.tool.submit", "video-to-gif") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
            },
            body: formData
        });

        const result = await response.json();

        document.getElementById('loading').style.display = 'none';

        if (result.success) {
            document.getElementById('resultMessage').textContent = 'Video converted to GIF successfully!';
            document.getElementById('downloadLink').href = result.download_url;
            document.getElementById('result').style.display = 'block';
        } else {
            alert('Conversion failed: ' + (result.message || 'Unknown error'));
        }
    } catch (error) {
        document.getElementById('loading').style.display = 'none';
        alert('Error: ' + error.message);
    }
});
</script>
