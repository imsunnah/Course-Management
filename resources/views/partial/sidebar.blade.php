<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
  <div class="sidebar-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">
      <a href="{{ route('dashboard') }}" class="logo">
        <img src="assets/img/logo.png" alt="navbar brand" class="navbar-brand" height="80" />
      </a>
      <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar">
          <i class="gg-menu-right"></i>
        </button>
        <button class="btn btn-toggle sidenav-toggler">
          <i class="gg-menu-left"></i>
        </button>
      </div>
      <button class="topbar-toggler more">
        <i class="gg-more-vertical-alt"></i>
      </button>
    </div>
  </div>

  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <ul class="nav nav-secondary">

        <!-- Dashboard -->
        <li class="nav-item active">
          <a href="{{ route('dashboard') }}">
            <i class="fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Course Management -->
        <li class="nav-section">
          <h4 class="text-section">Course Management</h4>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#courseManagement" class="collapsed" aria-expanded="false">
            <i class="fas fa-graduation-cap"></i>
            <p>Courses</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="courseManagement">
            <ul class="nav nav-collapse">
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
