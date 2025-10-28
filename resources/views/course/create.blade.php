@extends('master')

@section('content')
    <div class="container py-5">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-primary mb-0">🎓 Create a New Course</h2>
                <p class="text-muted small mb-0">Add course information, modules, and contents easily.</p>
            </div>
            <a href="{{ route('courses.index') }}" class="btn btn-outline-primary btn-sm">
                ← Back to Course List
            </a>
        </div>

        <!-- Course Form -->
        <form id="courseForm" action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Course Info -->
            <div class="card border-0 shadow-sm mb-5">
                <div class="card-header bg-secondary text-white py-3 fw-semibold">
                    Course Information
                </div>
                <div class="card-body row g-4">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Course Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control shadow-sm" placeholder="Enter course title"
                            required>
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Feature Video</label>
                        <input type="file" name="feature_video" class="form-control shadow-sm">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Level</label>
                        <select name="level" class="form-select shadow-sm">
                            <option value="">Select Level</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Category</label>
                        <select name="category_id" class="form-select shadow-sm">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Course Price (৳)</label>
                        <input type="number" name="course_price" class="form-control shadow-sm"
                            placeholder="Enter course price">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Course Summary</label>
                        <textarea name="summary" id="summary" class="form-control shadow-sm" rows="6"
                            placeholder="Write an overview of this course..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Modules Section -->
            <div class="card border-0 shadow-sm mb-5">
                <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                    <span class="fw-semibold"> Modules</span>
                    <button type="button" id="addModuleBtn" class="btn btn-light btn-sm shadow-sm">+ Add Module</button>
                </div>
                <div class="card-body" id="modulesContainer">
                    <p class="text-muted text-center mb-0">No modules added yet. Click “+ Add Module” to begin.</p>
                </div>
            </div>

            <!-- Buttons -->
            <div class="text-end">
                <button type="submit" class="btn btn-success px-4 py-2 shadow-sm">
                    Save Course
                </button>
                <button type="button" class="btn btn-outline-secondary px-4 py-2 shadow-sm"
                    onclick="window.history.back()">Cancel</button>
            </div>
        </form>
    </div>

    <!-- CKEditor CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>

    <script>
        let moduleCount = 0;
        let editors = {};

        // Initialize CKEditor
        function initCKEditor(textarea) {
            ClassicEditor.create(textarea, {
                    toolbar: ['bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote']
                })
                .then(editor => {
                    editors[textarea.name] = editor;
                })
                .catch(error => console.error(error));
        }

        // Initialize for summary
        document.addEventListener('DOMContentLoaded', () => {
            initCKEditor(document.querySelector('#summary'));
        });

        // Add Module
        document.getElementById('addModuleBtn').addEventListener('click', function() {
            moduleCount++;
            const moduleDiv = document.createElement('div');
            moduleDiv.classList.add('card', 'border', 'p-3', 'mb-4', 'shadow-sm', 'module-item');
            moduleDiv.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-3 rounded-top px-3 py-2" style="background-color:#87CEEB; color:white;">
            <h5 class="fw-semibold mb-0">Module ${moduleCount}</h5>
                <button type="button" class="btn btn-danger btn-sm remove-module">X</button>
        </div>

        <div class="p-3 border rounded-bottom module-body">
            <div class="mb-3">
                <label class="form-label">Module Title</label>
                <input type="text" name="modules[${moduleCount}][title]" class="form-control shadow-sm" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Module Description</label>
                <textarea name="modules[${moduleCount}][description]" class="form-control module-description shadow-sm" rows="3"></textarea>
            </div>

            <div class="contents-container"></div>
            <button type="button" class="btn btn-outline-primary btn-sm add-content-btn mt-2 shadow-sm">+ Add Content</button>
        </div>
    `;

            const container = document.getElementById('modulesContainer');
            container.appendChild(moduleDiv);
            container.querySelector('.text-muted')?.remove();

            const moduleDesc = moduleDiv.querySelector('.module-description');
            initCKEditor(moduleDesc);

            // Remove module
            moduleDiv.querySelector('.remove-module').addEventListener('click', () => {
                if (editors[moduleDesc.name]) {
                    editors[moduleDesc.name].destroy();
                    delete editors[moduleDesc.name];
                }
                moduleDiv.remove();
            });

            // Add content button
            moduleDiv.querySelector('.add-content-btn').addEventListener('click', function() {
                addContent(moduleDiv.querySelector('.contents-container'), moduleCount);
            });
        });

        // Add Content
        function addContent(container, moduleIndex) {
            const contentCount = container.querySelectorAll('.content-item').length + 1;
            const contentDiv = document.createElement('div');
            contentDiv.classList.add('content-item', 'border', 'rounded', 'p-3', 'mt-3', 'shadow-sm');

            contentDiv.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-2 px-2 py-1 rounded-top" style="background-color:#065794; color:white;">
            <h6 class="fw-semibold mb-0">Content ${contentCount}</h6>
            <button type="button" class="btn btn-outline-danger btn-sm remove-content">X</button>
        </div>

        <div class="p-3 border rounded-bottom content-body">
            <div class="mb-2">
                <label class="form-label">Content Title</label>
                <input type="text" name="modules[${moduleIndex}][contents][${contentCount}][title]" class="form-control shadow-sm" required>
            </div>

            <div class="mb-2">
                <label class="form-label">Video Type</label>
                <select name="modules[${moduleIndex}][contents][${contentCount}][video_type]" class="form-select shadow-sm video-type-select">
                    <option value="0">Video File</option>
                    <option value="1">Video Link</option>
                </select>
            </div>

            <div class="mb-2 video-file-group">
                <label class="form-label">Upload File</label>
                <input type="file" name="modules[${moduleIndex}][contents][${contentCount}][file]" class="form-control shadow-sm">
            </div>

            <div class="mb-2 video-link-group" style="display:none;">
                <label class="form-label">Video Link</label>
                <input type="url" name="modules[${moduleIndex}][contents][${contentCount}][link]" class="form-control shadow-sm" placeholder="https://example.com/video">
            </div>

            <div class="mb-2">
                <label class="form-label">Content Length (HH:MM:SS)</label>
                <input type="text" name="modules[${moduleIndex}][contents][${contentCount}][length]" class="form-control shadow-sm" placeholder="00:00:00">
            </div>
        </div>
    `;

            container.appendChild(contentDiv);

            // Remove content
            contentDiv.querySelector('.remove-content').addEventListener('click', () => contentDiv.remove());

            // Toggle file/link input based on video type
            const typeSelect = contentDiv.querySelector('.video-type-select');
            const fileGroup = contentDiv.querySelector('.video-file-group');
            const linkGroup = contentDiv.querySelector('.video-link-group');

            typeSelect.addEventListener('change', () => {
                if (typeSelect.value === "0") {
                    fileGroup.style.display = 'block';
                    linkGroup.style.display = 'none';
                } else {
                    fileGroup.style.display = 'none';
                    linkGroup.style.display = 'block';
                }
            });
        }
    </script>
@endsection
