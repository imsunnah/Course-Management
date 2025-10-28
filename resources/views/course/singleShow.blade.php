@extends('master')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <a href="{{ route('courses.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Back to All Courses
        </a>
    </nav>

    <div class="card shadow-lg mb-5 border-0">
        <div class="card-body p-4 p-md-5">
            <h1 class="card-title text-primary fw-bolder mb-3">{{ $course->title }}</h1>
            <hr class="mb-4">

            <div class="row g-4">
                <div class="col-lg-7">
                    @if($course->feature_video)
                        <div class="ratio ratio-16x9 rounded-3 shadow-lg overflow-hidden">
                            @if(Str::startsWith($course->feature_video, ['http', 'www']))
                                <iframe src="{{ $course->feature_video }}" title="{{ $course->title }} Feature Video" allowfullscreen></iframe>
                            @else
                                <video controls poster="{{ asset('assets/img/video-placeholder.jpg') }}">
                                    <source src="{{ asset('storage/' . $course->feature_video) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        </div>
                    @else
                        <div class="p-5 bg-light rounded-3 text-center text-muted border">
                            <i class="fas fa-video fa-3x mb-3"></i>
                            <p class="mb-0 fw-semibold">No Feature Video Available</p>
                        </div>
                    @endif
                </div>

                <div class="col-lg-5">
                    <h5 class="text-secondary fw-bold mb-3">Course Details</h5>
                    <ul class="list-group list-group-flush border rounded-3 mb-4 shadow-sm">
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                            <span class="fw-semibold text-dark"><i class="fas fa-layer-group me-2 text-info"></i> Level:</span>
                            <span><span class="badge bg-secondary">{{ $course->level ?? 'N/A' }}</span></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="fw-semibold text-dark"><i class="fas fa-tag me-2 text-info"></i> Category:</span>
                            <span>{{ $course->category->name ?? 'Uncategorized' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-secondary bg-opacity-10">
                            <span class="fw-bolder text-success"><i class="fas fa-dollar-sign me-2"></i> Price:</span>
                            <span class="h5 mb-0 text-success">{{ $course->course_price ? '৳'.$course->course_price : 'Free' }}</span>
                        </li>
                    </ul>

                    <h5 class="text-secondary fw-bold mb-2">Summary</h5>
                    <div class="p-3 border rounded-3 bg-light shadow-sm overflow-auto" style="max-height: 250px;">
                        {!! $course->summary !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- --- Course Curriculum/Modules Section (MODIFIED FOR SIZE) --- --}}
    <h2 class="mb-5 text-secondary fw-bolder display-6">Course Curriculum 📚</h2>

    @if($course->modules->count())
        <div class="accordion" id="courseModulesAccordion">
            @foreach($course->modules as $modIndex => $module)

                <div class="accordion-item shadow-lg mb-4 border border-info rounded-3">
                    <h3 class="accordion-header" id="moduleHeading{{ $module->id }}">
                        {{-- INCREASED FONT SIZE (fs-4) AND PADDING (p-4) --}}
                        <button class="accordion-button **fs-4** fw-bold bg-info text-white **p-4** collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#moduleCollapse{{ $module->id }}" aria-expanded="{{ $modIndex == 0 ? 'true' : 'false' }}" aria-controls="moduleCollapse{{ $module->id }}">
                            Module {{ $modIndex + 1 }}: {{ $module->title }}
                        </button>
                    </h3>

                    <div id="moduleCollapse{{ $module->id }}" class="accordion-collapse collapse {{ $modIndex == 0 ? 'show' : '' }}" aria-labelledby="moduleHeading{{ $module->id }}" data-bs-parent="#courseModulesAccordion">
                        <div class="accordion-body **p-5**"> {{-- INCREASED PADDING --}}
                            <p class="text-muted **fs-6** mb-5">{!! $module->description !!}</p> {{-- BOLDER DESCRIPTION TEXT --}}

                            @if($module->contents->count())
                                <ul class="list-group list-group-flush border rounded overflow-hidden">
                                    @foreach($module->contents as $contIndex => $content)
                                        <li class="list-group-item list-group-item-action **py-4 px-md-5**"> {{-- INCREASED VERTICAL PADDING --}}
                                            <a class="text-decoration-none text-dark d-block" data-bs-toggle="collapse" href="#contentCollapse{{ $content->id }}" role="button" aria-expanded="false" aria-controls="contentCollapse{{ $content->id }}">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    {{-- INCREASED FONT SIZE (fs-5) --}}
                                                    <span class="fw-semibold **fs-5**">
                                                        <i class="fas fa-play-circle me-3 text-primary"></i> {{-- LARGER ICON MARGIN --}}
                                                        Content {{ $contIndex + 1 }}: {{ $content->title }}
                                                    </span>

                                                </div>
                                            </a>

                                            <div class="collapse mt-4 **p-4** bg-light rounded-3 shadow-sm" id="contentCollapse{{ $content->id }}"> {{-- INCREASED PADDING and MARGIN --}}
                                                <p class="mb-3 small">
                                                    <strong>Source:</strong>
                                                    <span class="badge bg-{{ $content->video_type == 0 ? 'primary' : 'danger' }}">{{ $content->video_type == 0 ? 'File Upload' : 'External Link' }}</span>
                                                </p>

                                                @if($content->video_path)
                                                    <div class="ratio ratio-16x9 rounded-3 overflow-hidden">
                                                        @if($content->video_type == 1 && Str::contains($content->video_path, 'youtube.com'))
                                                            <iframe src="{{ $content->video_path }}" title="{{ $content->title }}" allowfullscreen></iframe>
                                                        @elseif($content->video_type == 0)
                                                            <video controls>
                                                                <source src="{{ asset('storage/' . $content->video_path) }}" type="video/mp4">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        @else
                                                            <div class="alert alert-warning small py-2">Cannot display video link. Ensure URL is correct.</div>
                                                        @endif
                                                    </div>
                                                @else
                                                     <div class="alert alert-warning small py-2">Video content is missing for this lesson.</div>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="alert alert-secondary text-center p-4 rounded-3">
                                    <i class="fas fa-exclamation-circle me-2"></i> This module is currently empty.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info shadow-sm py-5 text-center rounded-3">
            <i class="fas fa-info-circle fa-3x mb-3"></i>
            <p class="mb-0 fw-semibold fs-5">No modules have been added to this course yet. Please check back later!</p>
        </div>
    @endif

</div>
@endsection
