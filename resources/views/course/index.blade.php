@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white rounded-xl shadow-md">
    <h1 class="text-3xl font-bold mb-6">All Courses</h1>
    <div class="grid md:grid-cols-2 gap-4">
        @foreach($courses as $course)
        <div class="p-4 border rounded-lg shadow-sm hover:shadow-md transition">
            <h2 class="text-xl font-semibold mb-2">{{ $course->title }}</h2>
            <p class="text-gray-600 mb-2">{{ Str::limit($course->description, 100) }}</p>
            <a href="{{ route('courses.show', $course->id) }}"
               class="text-blue-600 underline">View Course</a>
        </div>
        @endforeach
    </div>
</div>
@endsection
