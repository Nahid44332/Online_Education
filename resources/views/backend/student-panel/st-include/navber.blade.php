@php
    // বাংলাদেশের টাইমজোন সেট করা
    date_default_timezone_set('Asia/Dhaka');
    
    $time = date('H'); 
    $formatTime = date('h:i A'); 
    
    $wish = "";
    $icon = "";

    if ($time >= 5 && $time < 12) {
        $wish = "শুভ সকাল";
        $icon = "mdi-white-balance-sunny text-warning";
    } elseif ($time >= 12 && $time < 16) {
        $wish = "শুভ দুপুর";
        $icon = "mdi-brightness-7 text-danger";
    } elseif ($time >= 16 && $time < 18) {
        $wish = "শুভ বিকাল";
        $icon = "mdi-weather-sunset-up text-warning";
    } elseif ($time >= 18 && $time < 20) {
        $wish = "শুভ সন্ধ্যা";
        $icon = "mdi-weather-sunset text-danger";
    } else {
        $wish = "শুভ রাত্রি";
        $icon = "mdi-weather-night text-primary";
    }
@endphp

<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <a class="navbar-brand brand-logo" href="{{ url('/student/dashboard') }}"><img src="{{ asset('backend/assets/images/logo.svg') }}" alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="{{ url('/student/dashboard') }}"><img src="{{ asset('backend/assets/images/logo-mini.svg') }}" alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <div class="search-field d-none d-md-block">
            <form class="d-flex align-items-center h-100" action="#">
                <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                        <i class="input-group-text border-0 mdi mdi-magnify"></i>
                    </div>
                    <input type="text" class="form-control bg-transparent border-0" placeholder="Search projects">
                </div>
            </form>
        </div>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="nav-profile-img">
                        <img src="{{ asset('backend/images/students/' . $student->image) }}" alt="image">
                        <span class="availability-status online"></span>
                    </div>
                    {{-- মামা, এখানে আপনার ইউনিক উইশ সেকশন --}}
                    <div class="nav-profile-text d-flex flex-column">
                        <span class="text-muted mb-1" style="font-size: 10px; font-weight: 600;">
                           <i class="mdi {{ $icon }}"></i> {{ $wish }}
                        </span>
                        <p class="mb-1 text-black fw-bold">{{ $student->name }}</p>
                    </div>
                </a>
                <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="{{ url('/student/profile') }}">
                        <i class="mdi mdi-account-circle me-2 text-success"></i> Profile </a>
                    <div class="dropdown-divider"></div>
                    <form action="{{ route('student.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="mdi mdi-logout me-2 text-primary"></i> Signout </button>
                    </form>
                </div>
            </li>
            
            {{-- বর্তমান সময় দেখানোর জন্য একটি এক্সট্রা আইটেম (ইচ্ছাধীন) --}}
            <li class="nav-item d-none d-md-block">
                <span class="nav-link text-muted" style="font-size: 13px;">
                    <i class="mdi mdi-clock-outline me-1"></i> {{ $formatTime }}
                </span>
            </li>

            <li class="nav-item d-none d-lg-block full-screen-link">
                <a class="nav-link">
                    <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                </a>
            </li>
            
            {{-- বাকি নোটিফিকেশন ও মেসেজ আইকনগুলো আপনার আগের মতোই থাকবে --}}
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-email-outline"></i>
                    <span class="count-symbol bg-warning"></span>
                </a>
            </li>
            
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                    <i class="mdi mdi-bell-outline"></i>
                    <span class="count-symbol bg-danger"></span>
                </a>
                {{-- ... (Notifications Dropdown Content) ... --}}
            </li>

            <li class="nav-item nav-logout d-none d-lg-block">
                <form action="{{ route('student.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link border-0 bg-transparent">
                        <i class="mdi mdi-power"></i>
                    </button>
                </form>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>