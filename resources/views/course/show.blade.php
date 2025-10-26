@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white rounded-xl shadow-md">
    <h1 class="text-2xl font-bold mb-6">Create Course with Modules & Contents</h1>

    <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Course Info -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Course Title</label>
            <input type="text" name="title" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-6">
            <label class="block font-semibold mb-1">Course Description</label>
            <textarea name="description" class="w-full border p-2 rounded"></textarea>
        </div>

        <!-- Modules -->
        <div x-data="{ modules: [{contents:[{}]}] }">
            <template x-for="(module, moduleIndex) in modules" :key="moduleIndex">
                <div class="mb-4 border p-4 rounded bg-gray-50">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="font-semibold text-lg">Module <span x-text="moduleIndex+1"></span></h3>
                        <button type="button" @click="modules.splice(moduleIndex,1)" class="text-red-500">Remove Module</button>
                    </div>

                    <input type="text" :name="`modules[${moduleIndex}][title]`" placeholder="Module Title" class="w-full border p-2 mb-2 rounded" required>
                    <textarea :name="`modules[${moduleIndex}][description]`" placeholder="Module Description" class="w-full border p-2 mb-2 rounded"></textarea>

                    <!-- Contents -->
                    <div x-data="{ contents: [{}] }">
                        <template x-for="(content, contentIndex) in module.contents" :key="contentIndex">
                            <div class="mb-2 p-2 border rounded bg-white">
                                <div class="flex justify-between items-center mb-1">
                                    <h4 class="font-semibold">Content <span x-text="contentIndex+1"></span></h4>
                                    <button type="button" @click="module.contents.splice(contentIndex,1)" class="text-red-500">Remove Content</button>
                                </div>
                                <input type="text" :name="`modules[${moduleIndex}][contents][${contentIndex}][title]`" placeholder="Content Title" class="w-full border p-2 mb-1 rounded" required>

                                <select :name="`modules[${moduleIndex}][contents][${contentIndex}][content_type]`" class="w-full border p-2 mb-1 rounded">
                                    <option value="video">Video</option>
                                    <option value="pdf">PDF</option>
                                    <option value="text">Text</option>
                                </select>

                                <input type="file" :name="`modules[${moduleIndex}][contents][${contentIndex}][file_path]`" class="w-full mb-1">
                                <textarea :name="`modules[${moduleIndex}][contents][${contentIndex}][description]`" placeholder="Description" class="w-full border p-2 rounded"></textarea>
                            </div>
                        </template>
                        <button type="button" @click="module.contents.push({})" class="mt-2 px-3 py-1 bg-blue-500 text-white rounded">Add Content</button>
                    </div>
                </div>
            </template>

            <button type="button" @click="modules.push({contents:[{}]})" class="mt-2 px-4 py-2 bg-green-500 text-white rounded">Add Module</button>
        </div>

        <button type="submit" class="mt-6 px-6 py-2 bg-blue-600 text-white rounded">Save Course</button>
    </form>
</div>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
