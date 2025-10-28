@extends('master')
@section('content')
<div class="container py-5">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary mb-0">📚 Courses</h2>
        <a href="{{ route('courses.create') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-lg"></i> Add New Course
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($courses->count())
        <div class="row g-4">
            @foreach($courses as $course)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0">
                    @if($course->feature_video)
                    <video class="card-img-top" height="180" controls>
                        <source src="{{ asset('storage/' . $course->feature_video) }}" type="video/mp4">
                        Your browser does not support video.
                    </video>
                    @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:180px;">
                        <i class="bi bi-film" style="font-size: 3rem; color: #6c757d;"></i>
                    </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold">{{ $course->title }}</h5>
                        <p class="card-text text-muted mb-1">
                            <i class="bi bi-tags me-1"></i> {{ $course->category->name ?? '-' }}
                        </p>
                        <p class="card-text text-muted mb-2">
                            <i class="bi bi-graph-up me-1"></i> {{ $course->level ?? '-' }}
                        </p>
                        <p class="card-text text-truncate" style="max-height: 3em;">
                            {{ Str::limit($course->summary ?? $course->description ?? '', 80) }}
                        </p>

                        <div class="mt-auto d-flex justify-content-between align-items-center pt-2 border-top">
                            <span class="fw-semibold text-success">
                                {{ $course->course_price ? '৳'.$course->course_price : 'Free' }}
                            </span>

                            <div class="btn-group" role="group">
                                <a href="{{ route('courses.show', $course->id) }}" class="btn btn-sm btn-info" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Delete this course?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-muted small d-flex justify-content-between">
                        <span><i class="bi bi-clock"></i> {{ $course->duration ?? '-' }}</span>
                        <span><i class="bi bi-calendar"></i> {{ $course->created_at->format('d M, Y') }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $courses->links() }}
        </div>
    @else
        <div class="alert alert-info text-center shadow-sm">
            No courses found. Click “+ Add New Course” to create one.
        </div>
    @endif

</div>

<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@endsection
