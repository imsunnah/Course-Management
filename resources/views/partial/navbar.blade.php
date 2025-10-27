<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm py-2">
  <div class="container-fluid">


    <!-- Navbar Content -->
    <div class="collapse navbar-collapse" id="navbarMain">



      <!-- Right: Icons + User -->
      <ul class="navbar-nav ms-auto align-items-center">



        <!-- User Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link d-flex align-items-center" href="#" id="userDropdown" data-bs-toggle="dropdown">
            <img src="https://ui-avatars.com/api/?name=User&background=0D8ABC&color=fff" alt="User Avatar"
              class="rounded-circle me-2" width="36" height="36">
            <span class="fw-semibold text-dark d-none d-sm-inline">Hello, {{ Auth::user()->name ?? 'User' }}</span>
            <i class="fa fa-angle-down ms-1 text-muted"></i>
          </a>

          <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" aria-labelledby="userDropdown">


            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item text-danger">
                  <i class="fa fa-sign-out-alt me-2"></i> Logout
                </button>
              </form>
            </li>
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>
