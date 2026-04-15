<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    {{-- প্রোফাইল পিকচার লোড করা --}}
                    <img src="{{ (!empty(Auth::guard('subadmin')->user()->helpline->image)) ? url(Auth::guard('subadmin')->user()->helpline->image) : url('upload/no_image.jpg') }}" alt="profile">
                    <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{ Auth::guard('subadmin')->user()->name }}</span>
                    <span class="text-secondary text-small">Helpline</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('helpline.dashboard') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{route('helpline.meeting')}}">
                <span class="menu-title">Meeting Desk</span>
                <i class="mdi mdi-video-box menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{route('helpline.earn.money')}}">
                <span class="menu-title">Earn Money</span>
                <i class="mdi mdi-wallet menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{route('helpline.withdraw')}}">
                <span class="menu-title">Withdraw</span>
                <i class="mdi mdi-cash-multiple menu-icon"></i>
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