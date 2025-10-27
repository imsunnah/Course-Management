@extends('dashboard')

@section('content')
<div class="container mt-5">
    <h3 class="mb-3">Create a Course</h3>
    <a href="{{ route('courses.index') }}" class="text-primary small">← Back to Course Page</a>

    <form id="courseForm" action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf

        <div class="card p-4 shadow-sm mb-4">
            <div class="row g-3 mb-3">
                <div class="col-md-8">
                    <label class="form-label">Course Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter course title" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Feature Video</label>
                    <input type="file" name="feature_video" class="form-control">
                </div>
            </div>

            <div id="modulesContainer"></div>

            <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="addModuleBtn">+ Add Module</button>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">Save Course</button>
                <button type="button" class="btn btn-secondary" onclick="window.history.back()">Cancel</button>
            </div>
        </div>
    </form>
</div>

<!-- JS -->
<script>
let moduleCount = 0;

document.getElementById('addModuleBtn').addEventListener('click', function() {
    moduleCount++;
    const moduleDiv = document.createElement('div');
    moduleDiv.classList.add('card', 'p-3', 'mb-3', 'shadow-sm');
    moduleDiv.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5>Module ${moduleCount}</h5>
            <button type="button" class="btn btn-danger btn-sm remove-module">X</button>
        </div>

        <div class="mb-3">
            <label class="form-label">Module Title</label>
            <input type="text" name="modules[${moduleCount}][title]" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Module Description</label>
            <textarea name="modules[${moduleCount}][description]" class="form-control" rows="2"></textarea>
        </div>

        <div class="contents-container mb-3"></div>
        <button type="button" class="btn btn-outline-secondary btn-sm add-content-btn">+ Add Content</button>
    `;

    document.getElementById('modulesContainer').appendChild(moduleDiv);

    moduleDiv.querySelector('.remove-module').addEventListener('click', () => moduleDiv.remove());
    moduleDiv.querySelector('.add-content-btn').addEventListener('click', function() {
        addContent(moduleDiv.querySelector('.contents-container'), moduleCount);
    });
});

function addContent(container, moduleIndex) {
    const contentCount = container.querySelectorAll('.content-item').length + 1;
    const contentDiv = document.createElement('div');
    contentDiv.classList.add('content-item', 'card', 'p-3', 'mt-2', 'shadow-sm');
    contentDiv.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6>Content ${contentCount}</h6>
            <button type="button" class="btn btn-outline-danger btn-sm remove-content">X</button>
        </div>

        <div class="mb-2">
            <label class="form-label">Content Title</label>
            <input type="text" name="modules[${moduleIndex}][contents][${contentCount}][title]" class="form-control" required>
        </div>

        <div class="mb-2">
            <label class="form-label">Content Type</label>
            <select name="modules[${moduleIndex}][contents][${contentCount}][type]" class="form-select">
                <option value="video">Video</option>
                <option value="audio">Audio</option>
                <option value="pdf">PDF</option>
                <option value="text">Text</option>
            </select>
        </div>

        <div class="mb-2">
            <label class="form-label">Upload File</label>
            <input type="file" name="modules[${moduleIndex}][contents][${contentCount}][file]" class="form-control" required>
        </div>

        <div class="mb-2">
            <label class="form-label">Content Length (HH:MM:SS)</label>
            <input type="text" name="modules[${moduleIndex}][contents][${contentCount}][length]" class="form-control" placeholder="00:00:00">
        </div>
    `;

    container.appendChild(contentDiv);
    contentDiv.querySelector('.remove-content').addEventListener('click', () => contentDiv.remove());
}
</script>
@endsection
