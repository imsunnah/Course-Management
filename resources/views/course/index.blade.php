@extends('master')
@section('content')
    <div class="container py-5">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary mb-0"> Courses</h2>
            <a href="{{ route('courses.create') }}" class="btn btn-secondary shadow-sm d-flex align-items-center gap-1">
                <i class="bi bi-plus-lg"></i> Add New Course
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($courses->count())
            <div class="row g-4">
                @foreach ($courses as $course)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm course-card overflow-hidden">
                            <!-- Video / Placeholder -->
                            @if ($course->feature_video)
                                <video class="card-img-top" height="180" controls>
                                    <source src="{{ asset('storage/' . $course->feature_video) }}" type="video/mp4">
                                    Your browser does not support video.
                                </video>
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                    style="height:180px;">
                                    <i class="bi bi-film" style="font-size: 3rem; color: #6c757d;"></i>
                                </div>
                            @endif

                            <!-- Card Body -->
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold mb-2">{{ $course->title }}</h5>

                                <!-- Category & Level -->
                                <div class="mb-2">
                                    <span class="badge bg-primary me-1">
                                        <i class="bi bi-tags me-1"></i> {{ $course->category->name ?? 'Uncategorized' }}
                                    </span>
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-graph-up me-1"></i> {{ $course->level ?? 'Beginner' }}
                                    </span>
                                </div>

                                <!-- Summary -->
                                <p class="card-text text-muted mb-3" style="line-height: 1.4;">
                                    {!! Str::limit(strip_tags($course->summary ?? ($course->description ?? '')), 100) !!}
                                </p>


                                <!-- Price & Actions -->
                                <div class="mt-auto d-flex justify-content-between align-items-center pt-2 border-top">
                                    <span class="fw-semibold text-success fs-6">
                                        {{ $course->course_price ? '৳' . $course->course_price : 'Free' }}
                                    </span>

                                    <div class="btn-group" role="group">
                                        <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-info"
                                            title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-warning"
                                            title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('courses.destroy', $course) }}" method="POST"
                                            onsubmit="return confirm('Delete this course?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="card-footer text-muted small d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-clock me-1"></i> {{ $course->duration ?? '-' }}</span>
                                <span><i class="bi bi-calendar me-1"></i>
                                    {{ $course->created_at->format('d M, Y') }}</span>
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

    <!-- Custom Styles -->
    <style>
        .course-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .card-text.truncate {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
