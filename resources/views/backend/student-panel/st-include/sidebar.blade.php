<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{ asset('backend/images/students/' . $student->image) }}" alt="profile" />
                    <span class="login-status online"></span>
                    <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{ $student->name }}</span>
                    <span class="text-secondary text-medium">Student Id:{{ $student->id }}</span>
                </div>
                @if (Auth::guard('student')->user()->status == 1)
                    <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                @else
                    <i class="mdi mdi-bookmark-check text-danger nav-profile-badge"></i>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/student/dashboard') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/student/profile') }}">
                <span class="menu-title">Profile</span>
                <i class="mdi mdi-account-circle menu-icon"></i>
            </a>
        </li>
        @if (Auth::guard('student')->user()->status == 1)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('student.course') }}">
                    <span class="menu-title">Course</span>
                    <i class="mdi mdi-google-classroom menu-icon"></i>
                </a>
            </li>
        @endif
        @if (Auth::guard('student')->user()->status == 1)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('student.referral') }}">
                    <span class="menu-title">Referral</span>
                    <i class="mdi mdi-account-multiple menu-icon"></i>
                </a>
            </li>
        @endif
        @if (Auth::guard('student')->user()->status == 1)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('student.referral-histroy') }}">
                    <span class="menu-title">Referral History</span>
                    <i class="mdi mdi-book-multiple menu-icon"></i>
                </a>
            </li>
        @endif
        @if (Auth::guard('student')->user()->status == 1)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('student.withdraw.page') }}">
                    <span class="menu-title">Withdraw</span>
                    <i class="mdi mdi-cash menu-icon"></i>
                </a>
            </li>
        @endif
        @if (Auth::guard('student')->user()->status == 1)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('student.admit-card') }}">
                    <span class="menu-title">Admit Card</span>
                    <i class="mdi mdi-card-account-details-outline menu-icon"></i>
                </a>
            </li>
        @endif
        @if (Auth::guard('student')->user()->status == 1)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('student.exams') }}">
                    <span class="menu-title">Exam</span>
                    <i class="mdi mdi-ab-testing menu-icon"></i>
                </a>
            </li>
        @endif
        @if (Auth::guard('student')->user()->status == 1)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('student.result') }}">
                    <span class="menu-title">Result</span>
                    <i class="mdi mdi-file-find-outline menu-icon"></i>
                </a>
            </li>
        @endif
        @if (Auth::guard('student')->user()->status == 1)
        <li class="nav-item">
            <a class="nav-link" href="{{ route('student.certificates') }}">
                <span class="menu-title">My Certificates</span>
                <i class="mdi mdi-certificate menu-icon text-warning"></i>
            </a>
        </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
                aria-controls="ui-basic">
                <span class="menu-title">Basic UI Elements</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/ui-features/dropdowns.html">Dropdowns</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/ui-features/typography.html">Typography</a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
