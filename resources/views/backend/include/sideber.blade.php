<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="{{ url('/admin/profile') }}" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{ asset('backend/images/admin/' . $admin->image) }}" alt="profile" />
                    <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{ $admin->name }}</span>
                    <span class="text-secondary text-small">Web Developer</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>

        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/dashboard') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>

        <!-- Students -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/student/list') }}">
                <span class="menu-title">Students</span>
                <i class="mdi mdi-account menu-icon"></i>
            </a>
        </li>

        <!-- Teachers -->
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#teacher-menu" aria-expanded="false"
                aria-controls="teacher-menu">
                <span class="menu-title">Teachers</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-account-tie menu-icon"></i>
            </a>
            <div class="collapse" id="teacher-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/teacher/list') }}">Teachers List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/teacher/add') }}">Add Teacher</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/teacher/cendidate') }}">Teacher Cendidate</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/teacher/featured') }}">Featured Teachers</a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Course -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/course') }}">
                <span class="menu-title">Course</span>
                <i class="mdi mdi-book menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#subadmin-panel" aria-expanded="false" aria-controls="subadmin-panel">
        <span class="menu-title">Subadmin Panel</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-account-group menu-icon"></i>
    </a>
    <div class="collapse" id="subadmin-panel">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item">
                <a class="nav-link" href="{{url('/admin/trainer')}}"> Trainer</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/admin/team-leader')}}"> Team Leader </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"> Senior Team Leader </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"> Counsellor </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"> Help-line </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"> Manager </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"> Managing Director </a>
            </li>
        </ul>
    </div>
</li>
        <!-- Payment -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/payment/list') }}">
                <span class="menu-title">Payment</span>
                <i class="mdi mdi-cash menu-icon"></i>
            </a>
        </li>

        <!-- Admit Card -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/withdraw/list') }}">
                <span class="menu-title">Withdraw</span>
                <i class="mdi mdi-cash menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#sub-admin-withdraw" aria-expanded="false"
                aria-controls="sub-admin-withdraw">
                <span class="menu-title">Sub-Admin Withdraw</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-cash-multiple menu-icon"></i>
            </a>
            <div class="collapse" id="sub-admin-withdraw">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Trainer Withdraw</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.team_leader.withdraw.requests')}}">Team Leader Withdraw</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.withdraw.requests') }}">Teacher Withdraw</a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Admit Card -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/admit-card') }}">
                <span class="menu-title">Admit Card</span>
                <i class="mdi mdi-card-account-details-outline menu-icon"></i>
            </a>
        </li>

        <!-- Exam -->
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#exam-menu" aria-expanded="false"
                aria-controls="exam-menu">
                <span class="menu-title">Exam Management</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-book-open-page-variant menu-icon"></i>
            </a>
            <div class="collapse" id="exam-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.exam.list') }}"> All Exam List </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Student Result -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/student/result') }}">
                <span class="menu-title">Result</span>
                <i class="mdi mdi-file-find menu-icon"></i>
            </a>
        </li>

        <!-- Student Certificate -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/student/certificate') }}">
                <span class="menu-title">Certificate</span>
                <i class="mdi mdi-certificate menu-icon"></i>
            </a>
        </li>

        <!-- Reports -->
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#report-menu" aria-expanded="false"
                aria-controls="report-menu">
                <span class="menu-title">Reports</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-chart-bar menu-icon"></i>
            </a>
            <div class="collapse" id="report-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/reports') }}">All Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/reports/students') }}">Students Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/reports/teachers') }}">Teacers Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/reports/courses') }}">Course Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/reports/payments') }}">Payment Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/reports/certificates') }}">Certificate Reports</a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Notice -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/notice') }}">
                <span class="menu-title">Notice</span>
                <i class="mdi mdi-bulletin-board menu-icon"></i>
            </a>
        </li>

        <!-- Lock -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/lock') }}">
                <span class="menu-title">Lock</span>
                <i class="mdi mdi-lock menu-icon"></i>
            </a>
        </li>

        <!-- Contact -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/contact-us') }}">
                <span class="menu-title">Contact Message</span>
                <i class="mdi mdi-account-box menu-icon"></i>
            </a>
        </li>

        <!-- Testimonial -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/testimonial') }}">
                <span class="menu-title">Testimonial</span>
                <i class="mdi mdi-comment menu-icon"></i>
            </a>
        </li>

        <!-- News -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/news') }}">
                <span class="menu-title">News</span>
                <i class="mdi mdi-newspaper menu-icon"></i>
            </a>
        </li>

        <!-- Settings Dropdown -->
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#settings" aria-expanded="false"
                aria-controls="settings">
                <span class="menu-title">Settings</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-cog menu-icon"></i>
            </a>
            <div class="collapse" id="settings">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/about-us') }}">
                            <span class="menu-title">About Us</span>
                            <i class="mdi mdi-information-outline menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/site-seeting') }}">
                            <span class="menu-title">Site Setting</span>
                            <i class="mdi mdi-cogs menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/policy-seeting') }}">
                            <span class="menu-title">Policy Setting</span>
                            <i class="mdi mdi-cogs menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/banner-settings') }}">
                            <span class="menu-title">Banner Setting</span>
                            <i class="mdi mdi-cogs menu-icon"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
