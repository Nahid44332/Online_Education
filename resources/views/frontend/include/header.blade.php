<style>
    /* মোবাইলের জন্য কাস্টম অ্যাডজাস্টমেন্ট */
    @media (max-width: 767px) {
        .support-button {
            display: flex !important;
            flex-direction: column;
            align-items: center;
            float: none !important;
            margin-top: 15px;
        }
        .support-button .support {
            margin-bottom: 10px;
            margin-right: 0 !important;
        }
        .header-logo-support {
            padding-bottom: 20px !important;
        }
        .main-btn {
            padding: 0 15px !important;
            height: 35px !important;
            line-height: 35px !important;
            font-size: 12px !important;
        }
    }
</style>

<header id="header-part">
    {{-- কম্পিউটার স্ক্রিনে আগের মতো d-none d-lg-block থাকবে --}}
    <div class="header-top d-none d-lg-block">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="header-contact text-lg-left text-center">
                        <ul>
                            <li><img src="{{ asset('frontend/images/all-icon/map.png') }}" alt="icon"><span>{{$sitesettings->address}}</span></li>
                            <li><img src="{{ asset('frontend/images/all-icon/email.png') }}" alt="icon"><span>{{$sitesettings->email}}</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="header-opening-time text-lg-right text-center">
                        <p>Opening Hours : {{$sitesettings->opening}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="header-logo-support pt-30 pb-30">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 col-md-4 col-12 text-center text-md-left">
                    <div class="logo">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('backend/images/seetings/'.$sitesettings->logo) }}" alt="Logo" height="80" width="150">
                        </a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-12">
                    {{-- এখানে d-none d-md-block সরিয়ে দিয়ে CSS দিয়ে কন্ট্রোল করা হয়েছে --}}
                    <div class="support-button float-right">
                        <div class="support float-left mr-3">
                            <div class="icon float-left">
                                <img src="{{ asset('frontend/images/all-icon/support.png') }}" alt="icon">
                            </div>
                            <div class="cont float-left ml-2 text-left">
                                <p>Need Help? call us free</p>
                                <span>{{$sitesettings->helpline}}</span>
                            </div>
                        </div>
                        <div class="button-group float-left d-flex">
                            <div class="button mr-2">
                                <a href="{{ url('/subadmin/login') }}" class="main-btn">Subadmin Login</a>
                            </div>
                            <div class="button">
                                <a href="{{ url('/admin/login') }}" class="main-btn">Admin Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="navigation">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-9 col-8">
                    <nav class="navbar navbar-expand-lg">
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item"><a class="active" style="font-size: 13px" href="{{ url('/') }}">Home</a></li>
                                <li class="nav-item"><a href="{{ url('/about-us') }}" style="font-size: 12px">About us</a></li>
                                <li class="nav-item"><a href="{{ url('/courses') }}" style="font-size: 12px">Courses</a></li>
                                <li class="nav-item"><a href="{{ url('/teachers') }}" style="font-size: 12px">Our teachers</a></li>
                                <li class="nav-item"><a href="{{ url('/student-result') }}" style="font-size: 12px">Student Result</a></li>
                                <li class="nav-item"><a href="{{ url('/certificate/check') }}" style="font-size: 12px">Check Certificate</a></li>
                                <li class="nav-item">
                                    <a href="{{ url('/notice') }}" style="font-size: 12px">
                                        Notice
                                        @if (isset($noticeCount) && $noticeCount > 0)
                                            <span class="badge badge-danger">{{ $noticeCount }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-item"><a href="{{ url('/contact-us') }}" style="font-size: 12px">Contact Us</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-3 col-4">
                    <div class="right-icon text-right">
                        <ul>
                            <li><a href="#" id="search"><i class="fa fa-search"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="search-box">
        <div class="serach-form">
            <div class="closebtn"><span></span><span></span></div>
            <form action="#">
                <input type="text" placeholder="Search by keyword">
                <button><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>
</header>