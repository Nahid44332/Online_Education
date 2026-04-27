<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="{{ url('/manager/profile') }}" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{ !empty(Auth::guard('subadmin')->user()->manager->profile_image) ? asset(Auth::guard('subadmin')->user()->manager->profile_image) : asset('backend/images/no_image.jpg') }}" alt="profile" />
                    <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{ Auth::guard('subadmin')->user()->name }}</span>
                    <span class="text-secondary text-small">Manager</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('manager.dashboard') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">
                <span class="menu-title">Students List</span>
                <i class="mdi mdi-account-group menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#teacher-menu" aria-expanded="false" aria-controls="teacher-menu">
                <span class="menu-title">Teachers</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-account-tie menu-icon"></i>
            </a>
            <div class="collapse" id="teacher-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="#">Teachers List</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Featured Teachers</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">
                <span class="menu-title">Courses</span>
                <i class="mdi mdi-book-open-variant menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#finance-menu" aria-expanded="false" aria-controls="finance-menu">
                <span class="menu-title">Finance</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-cash-multiple menu-icon"></i>
            </a>
            <div class="collapse" id="finance-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="#">Payment History</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Withdraw Logs</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">
                <span class="menu-title">Notice Board</span>
                <i class="mdi mdi-bulletin-board menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">
                <span class="menu-title">Contact Messages</span>
                <i class="mdi mdi-email-outline menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">
                <span class="menu-title">Reports</span>
                <i class="mdi mdi-chart-areaspline menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">
                <span class="menu-title">Lock Screen</span>
                <i class="mdi mdi-lock menu-icon"></i>
            </a>
        </li>
    </ul>
</nav>