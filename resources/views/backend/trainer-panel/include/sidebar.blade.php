<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="{{route('trainer.profile')}}" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{ asset('backend/images/trainer/' . Auth::guard('subadmin')->user()->trainer->profile_image) }}"
                        alt="profile" />
                    <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-1">{{ Auth::guard('subadmin')->user()->name }}</span>

                    {{-- রিয়েল আইডি প্রিমিয়াম ব্যাজ --}}
                    <div>
                        <span class="badge badge-gradient-primary"
                            style="font-size: 10px; padding: 2px 10px; border-radius: 4px; border: 1px solid rgba(0, 253, 84, 0.623); font-family: monospace;">
                            Trainer ID: {{ Auth::guard('subadmin')->user()->trainer->id }}
                        </span>
                    </div>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('trainer.dashboard') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{route('trainer.stdent.list')}}">
                <span class="menu-title">My Students</span>
                <i class="mdi mdi-account-multiple menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{route('trainer.withdraw')}}">
                <span class="menu-title">Withdraw</span>
                <i class="mdi mdi-cash menu-icon"></i>
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
