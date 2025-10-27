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
        $courses = Course::latest()->paginate(10);
        return view('course.index', compact('courses'));
    }
    // Show create form
    public function create()
    {
        return view('course.create');
    }

    // Store a new course
 public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'feature_video' => 'nullable|file|mimes:mp4,mov,avi|max:102400', // max 100MB
        'modules.*.title' => 'required|string|max:255',
        'modules.*.contents.*.title' => 'required|string|max:255',
        'modules.*.contents.*.file' => 'nullable|file|mimes:mp4,mov,avi,mp3,pdf,jpg,png|max:51200',
    ]);

    $course = new Course();
    $course->title = $request->title;
    $course->description = $request->description;
    $course->category = $request->category;

    if ($request->hasFile('feature_video')) {
        $course->feature_video = $request->file('feature_video')->store('feature_videos', 'public');
    }

    $course->save();

    // Modules
    foreach ($request->modules ?? [] as $moduleData) {
        $module = $course->modules()->create([
            'title' => $moduleData['title'],
            'description' => $moduleData['description'] ?? null,
        ]);

        // Contents
        foreach ($moduleData['contents'] ?? [] as $contentData) {
            $filePath = null;
            if (!empty($contentData['file'])) {
                $filePath = $contentData['file']->store('contents', 'public');
            }
            $module->contents()->create([
                'title' => $contentData['title'],
                'type' => $contentData['type'],
                'file_path' => $filePath,
                'length' => $contentData['length'] ?? null,
                'text' => $contentData['text'] ?? null,
            ]);
        }
    }

    return redirect()->route('courses.index')->with('success', 'Course created successfully!');
}


    // Show edit form
    public function edit(Course $course)
    {
        return view('course.edit', compact('course'));
    }

    // Update a course
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'nullable|string|max:100',
        ]);

        $course->update($validated);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully!');
    }

    // Delete a course
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully!');
    }
}
