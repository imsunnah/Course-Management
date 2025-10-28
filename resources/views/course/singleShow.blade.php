@extends('master')
@section('content')
<div class="container py-5">

    <!-- Back Button -->
    <a href="{{ route('courses.index') }}" class="btn btn-outline-primary mb-3">← Back to Courses</a>

    <!-- Course Header -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-secondary text-white fw-semibold">
            {{ $course->title }}
        </div>
        <div class="card-body">
            @if($course->feature_video)
                <video width="100%" height="250" controls class="mb-3 rounded shadow-sm">
                    <source src="{{ asset('storage/' . $course->feature_video) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @endif

            <p><strong>Level:</strong> {{ $course->level ?? '-' }}</p>
            <p><strong>Category:</strong> {{ $course->category->name ?? '-' }}</p>
            <p><strong>Price:</strong> {{ $course->course_price ? '৳'.$course->course_price : '-' }}</p>
            <p class="mt-3"><strong>Summary:</strong></p>
            <div class="p-3 border rounded shadow-sm">        {!! $course->summary !!}
</div>
        </div>
    </div>

    <!-- Modules -->
    @if($course->modules->count())
        <h4 class="mb-3">Modules</h4>
        @foreach($course->modules as $modIndex => $module)
            <div class="card mb-3 shadow-sm">
                <div class="card-header fw-semibold text-white" style="background-color:#87CEEB;">
                    Module {{ $modIndex + 1 }}: {{ $module->title }}
                </div>
                <div class="card-body">
                    <p>
    {!! $module->description !!}</p>
                    @if($module->contents->count())
                        <div class="accordion" id="moduleAccordion{{ $module->id }}">
                            @foreach($module->contents as $contIndex => $content)
                                <div class="accordion-item mb-2">
                                    <h2 class="accordion-header" id="heading{{ $content->id }}">
                                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $content->id }}" aria-expanded="false" aria-controls="collapse{{ $content->id }}" style="background-color:#000080;">
                                            Content {{ $contIndex + 1 }}: {{ $content->title }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $content->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $content->id }}" data-bs-parent="#moduleAccordion{{ $module->id }}">
                                        <div class="accordion-body">
                                            <p><strong>Video Type:</strong>
                                                 {{ $content->video_type == 0 ? 'File' : 'Link' }}</p>
                                            @if($content->video_path)
                                                <video width="100%" height="180" controls class="mb-2 rounded shadow-sm">
                                                    <source src="{{ asset('storage/' . $content->video_path) }}" type="video/mp4">
                                                </video>
                                            @endif
                                            <p><strong>Length:</strong> {{ $content->length ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No contents in this module.</p>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-info">No modules added to this course yet.</div>
    @endif

</div>
@endsection
