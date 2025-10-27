<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
                <img src="assets/img/logo.png" alt="navbar brand" class="navbar-brand" height="100" width="100" />
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
                <!-- Dashboard Section -->
                <li class="nav-item active">
                    <a data-bs-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
                        <i class="fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>

                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#travel-packages">
                        <i class="fas fa-suitcase"></i>
                        <p>Course Setup</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="travel-packages">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item"><a class="nav-link"
                                    href="{{ route('courses.index') }}">Courese</a></li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>
