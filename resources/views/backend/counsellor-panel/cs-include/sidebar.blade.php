<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    @php
                        $user = Auth::guard('subadmin')->user();
                        // ধরা যাক আপনার subadmin মডেলে counsellor রিলেশন আছে অথবা সরাসরি ইমেজ ফিল্ড আছে
                        $profileImage = $user->profile_image ?? 'no-image.png'; 
                    @endphp
                    <img src="{{ asset('backend/images/counsellor/' . $profileImage) }}" alt="profile" />
                    <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{ $user->name }}</span>
                    <span class="text-secondary text-small">Academic Counsellor</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('counsellor.dashboard') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#student-menu" aria-expanded="false" aria-controls="student-menu">
                <span class="menu-title">My Students</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-account-multiple menu-icon"></i>
            </a>
            <div class="collapse" id="student-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="#">New Leads</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Follow-up List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Admitted Students</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">
                <span class="menu-title">My Earnings</span>
                <i class="mdi mdi-cash menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#withdraw-menu" aria-expanded="false" aria-controls="withdraw-menu">
                <span class="menu-title">Withdraw</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-wallet menu-icon"></i>
            </a>
            <div class="collapse" id="withdraw-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Withdraw Request</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Withdraw History</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">
                <span class="menu-title">Notice Board</span>
                <i class="mdi mdi-bell-ring menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">
                <span class="menu-title">Profile Settings</span>
                <i class="mdi mdi-cog menu-icon"></i>
            </a>
        </li>
    </ul>
</nav>