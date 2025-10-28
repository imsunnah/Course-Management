<!-- Sidebar -->
<div class="sidebar" style="background-color: #ffffff">
  <!-- Logo Section -->
  <div class="sidebar-logo">
    <div class="logo-header" data-background-color="dark">
      <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center justify-content-center py-3">
        <h1 class="text-white m-0">LMS</h1>
      </a>
      <div class="nav-toggle d-flex">
        <button class="btn btn-toggle toggle-sidebar me-2">
          <i class="gg-menu-right"></i>
        </button>
        <button class="btn btn-toggle sidenav-toggler">
          <i class="gg-menu-left"></i>
        </button>
      </div>
      <button class="topbar-toggler more mt-2">
        <i class="gg-more-vertical-alt"></i>
      </button>
    </div>
  </div>

  <!-- Sidebar Content -->
  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <ul class="nav nav-secondary">

        <!-- Dashboard -->
        <li class="nav-item active">
          <a href="{{ route('dashboard') }}" class="d-flex align-items-center">
            <i class="fas fa-tachometer-alt me-2"></i>
            <p class="mb-0">Dashboard</p>
          </a>
        </li>

        <!-- Course Management Section -->
        <li class="nav-section mt-3">
          <h4 class="text-section text-muted">Course Management</h4>
        </li>

        <!-- Courses Menu -->
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#courseManagement" class="collapsed d-flex align-items-center" aria-expanded="false">
            <i class="fas fa-graduation-cap me-2"></i>
            <p class="mb-0">Courses</p>
            <span class="caret ms-auto"></span>
          </a>
          <div class="collapse" id="courseManagement">
            <ul class="nav nav-collapse ms-3">
              <li>
                <a href="{{ route('categories.index') }}">
                  <span class="sub-item">Category Setup</span>
                </a>
              </li>
              <li>
                <a href="{{ route('courses.index') }}">
                  <span class="sub-item">All Courses</span>
                </a>
              </li>
            </ul>
          </div>
        </li>

      </ul>
    </div>
  </div>
</div>
