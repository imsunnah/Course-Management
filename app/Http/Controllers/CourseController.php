<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CourseRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->paginate(10);
        return view('course.index', compact('courses'));
    }
    public function create()
    {
        $categories = Category::all();

        return view('course.create', compact('categories'));
    }

    public function store(CourseRequest $request)
    {
        DB::beginTransaction();

        try {
            $course = Course::create([
                'title' => $request->title,
                'summary' => $request->summary,
                'level' => $request->level,
                'course_price' => $request->course_price,
                'category_id' => $request->category_id,
                'feature_video' => $request->hasFile('feature_video')
                    ? $request->file('feature_video')->store('feature_videos', 'public')
                    : null,
            ]);

            // Add modules with contents
            if ($request->filled('modules')) {
                foreach ($request->modules as $moduleData) {
                    if (blank($moduleData['title'])) continue;

                    $module = $course->modules()->create([
                        'title' => $moduleData['title'],
                        'description' => $moduleData['description'] ?? null,
                    ]);

                    if (!empty($moduleData['contents'])) {
                        $contents = collect($moduleData['contents'])
                            ->filter(fn($content) => !blank($content['title']))
                            ->map(function ($content) {
                                $videoPath = null;
                                if (!empty($content['file']) && isset($content['video_type']) && $content['video_type'] == 0) {
                                    $videoPath = $content['file']->store('contents', 'public');
                                }
                                $videoLink = null;
                                if (!empty($content['link']) && isset($content['video_type']) && $content['video_type'] == 1) {
                                    $videoLink = $content['link'];
                                }

                                return [
                                    'title' => $content['title'],
                                    'video_type' => $content['video_type'] ?? null,
                                    'video_path' => $videoPath,
                                    'video_link' => $videoLink,
                                    'length' => $content['length'] ?? null,
                                    'text' => $content['text'] ?? null,
                                ];
                            })->toArray();

                        $module->contents()->createMany($contents);
                    }
                }
            }


            DB::commit();

            return redirect()->route('courses.index')
                ->with('success', 'Course created successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();

            \Log::error('Course store failed: ' . $e->getMessage());

            return redirect()->route('error.page');
        }
    }



    // Show edit form
    public function edit(Course $course)
    {
        $categories = Category::all();

        return view('course.edit', compact('course', 'categories'));
    }

    // Show  form
    public function show(Course $course)
    {
        $categories = Category::all();
        return view('course.singleShow', compact('course', 'categories'));
    }

    public function update(CourseRequest $request, Course $course)
    {
        // dd($request->all());
        DB::beginTransaction();

        try {
            // Update course info
            $course->update([
                'title' => $request->title,
                'summary' => $request->summary,
                'category_id' => $request->category_id,
                'summary' => $request->summary,
                'level' => $request->level,
                'course_price' => $request->course_price,
                'feature_video' => $request->hasFile('feature_video')
                    ? tap($request->file('feature_video')->store('feature_videos', 'public'), function () use ($course) {
                        if ($course->feature_video && Storage::disk('public')->exists($course->feature_video)) {
                            Storage::disk('public')->delete($course->feature_video);
                        }
                    })
                    : $course->feature_video,
            ]);



            // ---------------------------
            // Handle Modules
            // ---------------------------
            $existingModuleIds = $course->modules()->pluck('id')->toArray();
            $updatedModuleIds = [];

            foreach ($request->modules ?? [] as $moduleData) {
                if (blank($moduleData['title'])) continue;

                // Update or create module
                if (!empty($moduleData['id']) && in_array($moduleData['id'], $existingModuleIds)) {
                    $module = $course->modules()->find($moduleData['id']);
                    $module->update([
                        'title' => $moduleData['title'],
                        'description' => $moduleData['description'] ?? null,
                    ]);
                    $updatedModuleIds[] = $module->id;
                } else {
                    $module = $course->modules()->create([
                        'title' => $moduleData['title'],
                        'description' => $moduleData['description'] ?? null,
                    ]);
                    $updatedModuleIds[] = $module->id;
                }

                // ---------------------------
                // Handle Contents
                // ---------------------------
                $existingContentIds = $module->contents()->pluck('id')->toArray();
                $updatedContentIds = [];
                foreach ($moduleData['contents'] ?? [] as $contentData) {
                    if (blank($contentData['title'])) continue;

                    $videoPath = null;
                    $videoLink = null;

                    if (isset($contentData['video_type'])) {
                        if ($contentData['video_type'] == 0) {
                            if (!empty($contentData['file'])) {
                                $videoPath = $contentData['file']->store('contents', 'public');
                                $videoLink = null;
                            } else {
                                $videoPath = $contentData['video_path'] ?? null;
                            }
                        } elseif ($contentData['video_type'] == 1) {
                            $videoLink = $contentData['link'] ?? null;
                            $videoPath = null;
                        }
                    }

                    // Update existing content
                    if (!empty($contentData['id']) && in_array($contentData['id'], $existingContentIds)) {
                        $content = $module->contents()->find($contentData['id']);

                        if (!empty($contentData['file']) && $content->video_path && Storage::disk('public')->exists($content->video_path)) {
                            Storage::disk('public')->delete($content->video_path);
                        }

                        $content->update([
                            'title' => $contentData['title'],
                            'video_type' => $contentData['video_type'] ?? null,
                            'video_path' => $videoPath,
                            'video_link' => $videoLink,
                            'length' => $contentData['length'] ?? null,
                            'text' => $contentData['text'] ?? null,
                        ]);

                        $updatedContentIds[] = $content->id;
                    } else {
                        // Create new content
                        $newContent = $module->contents()->create([
                            'title' => $contentData['title'],
                            'video_type' => $contentData['video_type'] ?? null,
                            'video_path' => $videoPath,
                            'video_link' => $videoLink,
                            'length' => $contentData['length'] ?? null,
                            'text' => $contentData['text'] ?? null,
                        ]);

                        $updatedContentIds[] = $newContent->id;
                    }
                }
                $module->contents()
                    ->whereNotIn('id', $updatedContentIds)
                    ->get()
                    ->each(function ($content) {
                        if ($content->video_path && Storage::disk('public')->exists($content->video_path)) {
                            Storage::disk('public')->delete($content->video_path);
                        }
                        $content->delete();
                    });
            }

            $course->modules()
                ->whereNotIn('id', $updatedModuleIds)
                ->get()
                ->each(function ($module) {
                    foreach ($module->contents as $content) {
                        if ($content->video_path && Storage::disk('public')->exists($content->video_path)) {
                            Storage::disk('public')->delete($content->video_path);
                        }
                        $content->delete();
                    }
                    $module->delete();
                });

            DB::commit();
            return redirect()->route('courses.index')->with('success', 'Course updated successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Course update failed: ' . $e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }


    // Delete a course

    public function destroy(Course $course)


    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully!');
    }
}
