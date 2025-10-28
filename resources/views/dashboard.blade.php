@extends('master')
@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="fw-bolder text-dark mb-0 d-flex align-items-center">
            <i class="bi bi-speedometer2 me-3 text-primary-accent"></i>
            Admin Dashboard
        </h1>
        <span class="text-muted small">Welcome back, Admin</span>
    </div>

    <hr class="mb-5">

    <div class="row g-4 mb-5">
        @php
            // Define custom background/icon colors for a visually richer look
            $stat_themes = [
                'courses' => ['icon' => 'bi-journal-text', 'color' => 'bg-info-light text-info'],
                'categories' => ['icon' => 'bi-folder2', 'color' => 'bg-success-light text-success'],
                'users' => ['icon' => 'bi-people', 'color' => 'bg-warning-light text-warning'],
                'revenue' => ['icon' => 'bi-currency-dollar', 'color' => 'bg-danger-light text-danger'],
            ];
        @endphp

        {{-- Courses Stat Card --}}
        <div class="col-md-3">
            <div class="card card-stat border-0 shadow-lg h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <h5 class="text-muted mb-1 fw-semibold">Total Courses</h5>
                            <h2 class="fw-bolder text-dark">{{ $coursesCount ?? 12 }}</h2>
                        </div>
                        <div class="icon-circle {{ $stat_themes['courses']['color'] }}">
                            <i class="bi {{ $stat_themes['courses']['icon'] }} fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Categories Stat Card --}}
        <div class="col-md-3">
            <div class="card card-stat border-0 shadow-lg h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <h5 class="text-muted mb-1 fw-semibold">Categories</h5>
                            <h2 class="fw-bolder text-dark">{{ $categoriesCount ?? 8 }}</h2>
                        </div>
                        <div class="icon-circle {{ $stat_themes['categories']['color'] }}">
                            <i class="bi {{ $stat_themes['categories']['icon'] }} fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Users Stat Card --}}
        <div class="col-md-3">
            <div class="card card-stat border-0 shadow-lg h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <h5 class="text-muted mb-1 fw-semibold">Total Users</h5>
                            <h2 class="fw-bolder text-dark">{{ $usersCount ?? 45 }}</h2>
                        </div>
                        <div class="icon-circle {{ $stat_themes['users']['color'] }}">
                            <i class="bi {{ $stat_themes['users']['icon'] }} fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Revenue Stat Card --}}
        <div class="col-md-3">
            <div class="card card-stat border-0 shadow-lg h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <h5 class="text-muted mb-1 fw-semibold">Revenue</h5>
                            <h2 class="fw-bolder text-dark">৳{{ number_format($revenue ?? 12000) }}</h2>
                        </div>
                        <div class="icon-circle {{ $stat_themes['revenue']['color'] }}">
                            <i class="bi {{ $stat_themes['revenue']['icon'] }} fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-lg mb-5">
        <div class="card-header bg-primary-accent text-white fw-bolder py-3 d-flex justify-content-between align-items-center">
            <span class="fs-5"><i class="bi bi-list-ul me-2"></i> Recent Courses Activity</span>
            <a href="#" class="btn btn-sm btn-outline-light d-none d-sm-inline-block">View All</a>
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-3">#</th>
                        <th class="py-3">Title</th>
                        <th class="py-3">Category</th>
                        <th class="py-3">Level</th>
                        <th class="py-3 text-end">Price</th>
                        <th class="py-3">Created Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentCourses ?? collect(range(1, 5))->map(fn($i) => (object)['title' => "Sample Course $i", 'category' => (object)['name' => 'Web Dev'], 'level' => $i%3 == 0 ? 'Advanced' : 'Beginner', 'course_price' => $i*100, 'created_at' => now()->subDays($i)] ) as $index => $course)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ Str::limit($course->title, 40) }}</td>
                            <td><span class="badge bg-secondary-light text-secondary">{{ $course->category->name ?? 'N/A' }}</span></td>
                            <td>{{ $course->level ?? '-' }}</td>
                            <td class="text-end fw-bold text-success">{{ $course->course_price ? '৳'.number_format($course->course_price) : 'Free' }}</td>
                            <td>{{ optional($course->created_at)->format('d M, Y') }}</td>
                        </tr>
                    @endforeach
                    @if(empty($recentCourses) || count($recentCourses) === 0)
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No recent courses found in the database.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <h3 class="fw-bold mb-3 text-dark">Quick Actions</h3>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card card-action border-0 shadow-lg h-100">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="fw-bolder text-dark mb-1 d-flex align-items-center"><i class="bi bi-plus-square-fill me-2 text-primary-accent"></i> Add New Course</h5>
                        <p class="text-muted small mb-0">Start creating a new course material.</p>
                    </div>
                    <a href="{{ route('courses.create') }}" class="btn btn-primary-accent btn-sm ms-3 mt-1">Go <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-action border-0 shadow-lg h-100">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="fw-bolder text-dark mb-1 d-flex align-items-center"><i class="bi bi-tags-fill me-2 text-primary-accent"></i> Manage Categories</h5>
                        <p class="text-muted small mb-0">Add, edit, or delete course categories.</p>
                    </div>
                    <a href="{{ route('categories.index') }}" class="btn btn-primary-accent btn-sm ms-3 mt-1">Go <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-action border-0 shadow-lg h-100">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="fw-bolder text-dark mb-1 d-flex align-items-center"><i class="bi bi-person-lines-fill me-2 text-primary-accent"></i> View All Users</h5>
                        <p class="text-muted small mb-0">See list and manage user accounts.</p>
                    </div>
                    {{-- Assuming 'users.index' route exists --}}
                    <a href="#" class="btn btn-primary-accent btn-sm ms-3 mt-1">Go <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>

</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
/* Define a custom primary accent color */
.text-primary-accent { color: #007bff !important; } /* A vibrant blue */
.bg-primary-accent { background-color: #007bff !important; }
.btn-primary-accent {
    background-color: #007bff !important;
    border-color: #007bff !important;
    color: white !important;
}
.btn-primary-accent:hover {
    background-color: #0056b3 !important;
    border-color: #0056b3 !important;
}

/* Light Backgrounds for Stats */
.bg-info-light { background-color: #cce5ff !important; }    /* Light Blue */
.bg-success-light { background-color: #d4edda !important; } /* Light Green */
.bg-warning-light { background-color: #fff3cd !important; } /* Light Yellow */
.bg-danger-light { background-color: #f8d7da !important; }  /* Light Red */
.bg-secondary-light { background-color: #e2e6ea !important; } /* Light Gray */


/* General Card Styles */
.card {
    border-radius: 12px; /* Smoother corners */
    transition: transform 0.2s;
}
.card-stat {
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08) !important; /* Better default shadow */
}
.card-stat:hover {
    transform: translateY(-3px); /* Subtle hover effect */
}
.card-action {
    border-left: 5px solid #007bff; /* Left border for emphasis */
}

/* Icon Circle for Stats */
.icon-circle {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.9;
}

/* Table Enhancements */
.table {
    border-collapse: separate;
}
.table-striped > tbody > tr:nth-of-type(odd) {
    background-color: #f7f7f7; /* Very light subtle stripe */
}
.table-hover tbody tr:hover {
    background-color: #e9ecef !important;
    cursor: pointer;
}
th {
    font-weight: 600 !important;
    text-transform: uppercase;
    font-size: 0.85rem;
    color: #495057;
    letter-spacing: 0.5px;
}
</style>
@endsection
