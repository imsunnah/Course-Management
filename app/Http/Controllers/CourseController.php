<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Module;
use App\Models\Content;

class CourseController extends Controller
{    // List all courses
    public function index()
    {
        $courses = Course::all(); // fetch all courses
        return view('course.index', compact('courses'));
    }

    // Show single course
    public function show($id)
    {
        $course = Course::with('modules.contents')->findOrFail($id);
        return view('course.show', compact('course'));
    }

    public function create()
    {
        return view('course.show');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'modules.*.title' => 'required|string|max:255',
            'modules.*.contents.*.title' => 'required|string|max:255',
            'modules.*.contents.*.file_path' => 'nullable|file',
        ]);

        // Create Course
        $course = Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'slug' => \Str::slug($request->title),
        ]);

        // Loop Modules
        foreach ($request->modules as $moduleData) {
            $module = $course->modules()->create([
                'title' => $moduleData['title'],
                'description' => $moduleData['description'] ?? null,
            ]);

            // Loop Contents
            foreach ($moduleData['contents'] as $contentData) {
                $filePath = null;
                if (isset($contentData['file_path'])) {
                    $filePath = $contentData['file_path']->store('contents', 'public');
                }

                $module->contents()->create([
                    'title' => $contentData['title'],
                    'content_type' => $contentData['content_type'] ?? 'video',
                    'description' => $contentData['description'] ?? null,
                    'file_path' => $filePath,
                ]);
            }
        }

        return redirect()->route('courses.index')->with('success', 'Course created successfully!');
    }
}
