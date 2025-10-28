@extends('master')
@section('content')
    <div class="container mt-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-primary mb-0">🎓 Edit Course</h2>
                <p class="text-muted small mb-0">Edit course information, modules, and contents easily.</p>
            </div>
            <a href="{{ route('courses.index') }}" class="btn btn-outline-primary btn-sm">
                ← Back to Course List
            </a>
        </div>

        <form id="courseForm" action="{{ route('courses.update', $course) }}" method="POST" enctype="multipart/form-data"
            class="mt-4">
            @csrf
            @method('PUT')

            <!-- Course Info -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-secondary text-white py-3 fw-semibold">
                    Course Information
                </div>
                <div class="card-body row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Course Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $course->title }}" required>
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Feature Video</label>
                        <input type="file" name="feature_video" class="form-control">
                        @if ($course->feature_video)
                            <video width="100%" height="150" controls class="mt-2">
                                <source src="{{ asset('storage/' . $course->feature_video) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @endif
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Level</label>
                        <select name="level" class="form-select">
                            <option value="">Select Level</option>
                            <option value="Beginner" {{ $course->level == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="Intermediate" {{ $course->level == 'Intermediate' ? 'selected' : '' }}>Intermediate
                            </option>
                            <option value="Advanced" {{ $course->level == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $course->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Course Price (৳)</label>
                        <input type="number" name="course_price" class="form-control" value="{{ $course->course_price }}">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Course Summary</label>
                        <textarea name="summary" id="summary" class="form-control" rows="5">{{ $course->summary }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Modules Section -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">Modules</span>
                    <button type="button" id="addModuleBtn" class="btn btn-light btn-sm">+ Add Module</button>
                </div>
                <div class="card-body" id="modulesContainer">
                    @foreach ($course->modules as $key => $module)
                        <div class="card mb-3 shadow-sm module-item" data-module-id="{{ $module->id }}">
                            <div
                                class="card-header bg-info text-white d-flex justify-content-between align-items-center py-2 px-3">
                                <h5 class="mb-0">Module {{ $key + 1 }}</h5>
                                <button type="button" class="btn btn-danger btn-sm remove-module">X</button>
                            </div>

                            <input type="hidden" name="modules[{{ $module->id }}][id]" value="{{ $module->id }}">

                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Module Title</label>
                                    <input type="text" name="modules[{{ $module->id }}][title]" class="form-control"
                                        value="{{ $module->title }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Module Description</label>
                                    <textarea name="modules[{{ $module->id }}][description]" class="form-control module-description" rows="2">{{ $module->description }}</textarea>
                                </div>

                                <div class="contents-container mb-3">
                                    @foreach ($module->contents as $content)
                                        <div class="card mb-2 shadow-sm content-item">
                                            <div class="card-header text-white d-flex justify-content-between align-items-center py-1 px-2"
                                                style="background-color:#065794;">
                                                <h6 class="mb-0">Content {{ $loop->iteration }}</h6>
                                                <button type="button"
                                                    class="btn btn-outline-danger btn-sm remove-content">X</button>
                                            </div>
                                            <div class="card-body p-2">
                                                <input type="hidden"
                                                    name="modules[{{ $module->id }}][contents][{{ $content->id }}][id]"
                                                    value="{{ $content->id }}">

                                                <div class="mb-2">
                                                    <label class="form-label">Content Title</label>
                                                    <input type="text"
                                                        name="modules[{{ $module->id }}][contents][{{ $content->id }}][title]"
                                                        value="{{ $content->title }}" class="form-control" required>
                                                </div>

                                                <div class="mb-2">
                                                    <label class="form-label">Video Type</label>
                                                    <select
                                                        name="modules[{{ $module->id }}][contents][{{ $content->id }}][video_type]"
                                                        class="form-select video-type-select">
                                                        <option value="0"
                                                            {{ $content->video_type == 0 ? 'selected' : '' }}>Video File</option>
                                                        <option value="1"
                                                            {{ $content->video_type == 1 ? 'selected' : '' }}>Video Link</option>
                                                    </select>
                                                </div>

                                                <div class="mb-2 video-file-group"
                                                    style="{{ $content->video_type == 0 ? '' : 'display:none;' }}">
                                                    <label class="form-label">Upload File</label>
                                                    <input type="file"
                                                        name="modules[{{ $module->id }}][contents][{{ $content->id }}][file]"
                                                        class="form-control">
                                                    @if ($content->video_path && $content->video_type == 0)
                                                        <video width="100%" height="150" controls class="mt-2">
                                                            <source src="{{ asset('storage/' . $content->video_path) }}"
                                                                type="video/mp4">
                                                        </video>
                                                    @endif
                                                </div>

                                                <div class="mb-2 video-link-group"
                                                    style="{{ $content->video_type == 1 ? '' : 'display:none;' }}">
                                                    <label class="form-label">Video Link</label>
                                                    <input type="url"
                                                        name="modules[{{ $module->id }}][contents][{{ $content->id }}][link]"
                                                        class="form-control" value="{{ $content->video_link ?? '' }}"
                                                        placeholder="https://example.com/video">
                                                </div>

                                                <div class="mb-2">
                                                    <label class="form-label">Content Length (HH:MM:SS)</label>
                                                    <input type="text"
                                                        name="modules[{{ $module->id }}][contents][{{ $content->id }}][length]"
                                                        value="{{ $content->length }}" class="form-control"
                                                        placeholder="00:00:00">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-outline-secondary btn-sm add-content-btn">+ Add
                                    Content</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-success px-4">💾 Save Course</button>
                <button type="button" class="btn btn-outline-secondary px-4"
                    onclick="window.history.back()">Cancel</button>
            </div>
        </form>
    </div>

    <!-- CKEditor CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let moduleCount = {{ $course->modules->count() }};
            const modulesContainer = document.getElementById('modulesContainer');
            const addModuleBtn = document.getElementById('addModuleBtn');
            let editors = {};

            function initCKEditor(textarea) {
                ClassicEditor.create(textarea)
                    .then(editor => {
                        editors[textarea.name] = editor;
                    })
                    .catch(err => console.error(err));
            }

            // Initialize CKEditor for course summary
            initCKEditor(document.querySelector('#summary'));

            // Initialize CKEditor for existing module descriptions
            document.querySelectorAll('.module-description').forEach(textarea => initCKEditor(textarea));

            // Toggle file/link input for existing contents
            document.querySelectorAll('.video-type-select').forEach(select => {
                const container = select.closest('.card-body');
                const fileGroup = container.querySelector('.video-file-group');
                const linkGroup = container.querySelector('.video-link-group');

                function toggle() {
                    if (select.value === "0") {
                        fileGroup.style.display = 'block';
                        linkGroup.style.display = 'none';
                    } else {
                        fileGroup.style.display = 'none';
                        linkGroup.style.display = 'block';
                    }
                }

                toggle();
                select.addEventListener('change', toggle);
            });

            function addContent(container, moduleIndex) {
                const contentCount = container.querySelectorAll('.content-item').length + 1;
                const contentDiv = document.createElement('div');
                contentDiv.classList.add('content-item', 'card', 'mb-2', 'shadow-sm');

                contentDiv.innerHTML = `
            <div class="card-header text-white d-flex justify-content-between align-items-center py-1 px-2" style="background-color:#065794;">
                <h6 class="mb-0">Content ${contentCount}</h6>
                <button type="button" class="btn btn-outline-danger btn-sm remove-content">X</button>
            </div>
            <div class="card-body p-2">
                <div class="mb-2">
                    <label class="form-label">Content Title</label>
                    <input type="text" name="modules[${moduleIndex}][contents][new_${contentCount}][title]" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Video Type</label>
                    <select name="modules[${moduleIndex}][contents][new_${contentCount}][video_type]" class="form-select video-type-select">
                        <option value="0">Video File</option>
                        <option value="1">Video Link</option>
                    </select>
                </div>

                <div class="mb-2 video-file-group">
                    <label class="form-label">Upload File</label>
                    <input type="file" name="modules[${moduleIndex}][contents][new_${contentCount}][file]" class="form-control">
                </div>

                <div class="mb-2 video-link-group" style="display:none;">
                    <label class="form-label">Video Link</label>
                    <input type="url" name="modules[${moduleIndex}][contents][new_${contentCount}][link]" class="form-control" placeholder="https://example.com/video">
                </div>

                <div class="mb-2">
                    <label class="form-label">Content Length (HH:MM:SS)</label>
                    <input type="text" name="modules[${moduleIndex}][contents][new_${contentCount}][length]" class="form-control" placeholder="00:00:00">
                </div>
            </div>
        `;

                container.appendChild(contentDiv);

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

            function addNewModule() {
                moduleCount++;
                const newModuleIndex = `new_${moduleCount}`;
                const moduleDiv = document.createElement('div');
                moduleDiv.classList.add('card', 'mb-3', 'shadow-sm', 'module-item', 'new-module');
                moduleDiv.setAttribute('data-module-id', newModuleIndex);
                moduleDiv.innerHTML = `
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center py-2 px-3">
                <h5 class="mb-0">Module ${moduleCount} (New)</h5>
                <button type="button" class="btn btn-danger btn-sm remove-module">X</button>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Module Title</label>
                    <input type="text" name="modules[${newModuleIndex}][title]" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Module Description</label>
                    <textarea name="modules[${newModuleIndex}][description]" class="form-control module-description" rows="2"></textarea>
                </div>
                <div class="contents-container mb-3"></div>
                <button type="button" class="btn btn-outline-secondary btn-sm add-content-btn">+ Add Content</button>
            </div>
        `;
                modulesContainer.appendChild(moduleDiv);

                initCKEditor(moduleDiv.querySelector('.module-description'));

                moduleDiv.querySelector('.add-content-btn').addEventListener('click', function() {
                    addContent(moduleDiv.querySelector('.contents-container'), newModuleIndex);
                });
            }

            document.querySelectorAll('.module-item').forEach(moduleDiv => {
                const moduleIndex = moduleDiv.dataset.moduleId;
                moduleDiv.querySelector('.add-content-btn').addEventListener('click', function() {
                    addContent(moduleDiv.querySelector('.contents-container'), moduleIndex);
                });
            });

            addModuleBtn.addEventListener('click', addNewModule);

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-module')) {
                    const moduleItem = e.target.closest('.module-item');
                    moduleItem?.remove();
                }
                if (e.target.classList.contains('remove-content')) {
                    const contentItem = e.target.closest('.content-item');
                    contentItem?.remove();
                }
            });
        });
    </script>
@endsection
