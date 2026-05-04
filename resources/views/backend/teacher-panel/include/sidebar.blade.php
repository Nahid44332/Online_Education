<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="{{route('teacher.view-profile')}}" class="nav-link">
                <div class="nav-profile-image">
                    @if (Auth::guard('subadmin')->user()->teacher)
                        <img src="{{ asset('backend/images/teachers/' . Auth::guard('subadmin')->user()->teacher->profile_image) }}"
                            alt="profile" />
                    @else
                        <img src="{{ asset('backend/images/admin/default.png') }}" alt="profile" />
                    @endif
                    <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{ Auth::guard('subadmin')->user()->name }}</span>
                    <span class="text-secondary text-small">{{ Auth::guard('subadmin')->user()->position }} ID:
                        {{ Auth::guard('subadmin')->user()->teacher->id ?? 'N/A' }}</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('teacher.dashboard') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('teacher.live-class') }}">
                <span class="menu-title">Class Link</span>
                <i class="mdi mdi-book-open-variant menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('stdent.list') }}">
                <span class="menu-title">My Students</span>
                <i class="mdi mdi-account-group menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('exam.list') }}">
                <span class="menu-title">Exam Management</span>
                <i class="mdi mdi-file-document-edit menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{route('teacher.student.results')}}">
                <span class="menu-title">Student Results</span>
                <i class="mdi mdi-poll menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('teacher.withdraw') }}">
                <span class="menu-title">Withdraw</span>
                <i class="mdi mdi-cash-multiple menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('teacher.transactions') }}">
                <span class="menu-title">Transaction History</span>
                <i class="mdi mdi-history menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{route('teacher.view-profile')}}">
                <span class="menu-title">My Profile</span>
                <i class="mdi mdi-account-cog menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('subadmin.logout') }}">
                <span class="menu-title">Logout</span>
                <i class="mdi mdi-logout menu-icon"></i>
            </a>
        </li>
    </ul>
</nav>
<script src="{{ asset('path-to-your-js/bootstrap.bundle.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('[data-bs-toggle="collapse"]').click(function() {
            var target = $(this).attr('href');
            $(target).collapse('toggle');
        });
    });
</script>
