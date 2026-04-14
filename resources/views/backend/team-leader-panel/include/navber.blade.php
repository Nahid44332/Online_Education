<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        {{-- লোগো রিডাইরেকশন লজিক --}}
        @php
            $dashboardUrl = url('/admin/dashboard');
            if (Auth::guard('subadmin')->check()) {
                if (Auth::guard('subadmin')->user()->position == 'team_leader') {
                    $dashboardUrl = route('team_leader.dashboard');
                } elseif (Auth::guard('subadmin')->user()->position == 'teacher') {
                    $dashboardUrl = route('teacher.dashboard');
                }
            }
        @endphp

        <a class="navbar-brand brand-logo" href="{{ $dashboardUrl }}">
            <img src="{{ asset('backend/images/seetings/' . $sitesettings->logo) }}" alt="logo" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="{{ $dashboardUrl }}">
            <img src="{{ asset('backend/assets/images/logo-mini.svg') }}" alt="logo" />
        </a>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <div class="search-field d-none d-md-block"></div>

        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <div class="nav-profile-img">
                        @php
                            $user = Auth::guard('subadmin')->user();
                            $profileImage = 'default.png'; // ডিফল্ট ইমেজ

                            if ($user->position == 'team_leader') {
                                // team_leaders টেবিল থেকে ঐ ইউজারের প্রোফাইল ইমেজ খুঁজে বের করা
                                $tlDetails = DB::table('team_leaders')->where('subadmin_id', $user->id)->first();
                                if ($tlDetails && $tlDetails->profile_image) {
                                    $profileImage = $tlDetails->profile_image;
                                }
                                $imagePath = asset('backend/images/team-leader/' . $profileImage);
                            } else {
                                // এডমিন বা টিচারের জন্য আপনার আগের লজিক
                                $imagePath = asset('backend/images/admin/' . ($user->image ?? 'default.png'));
                            }
                        @endphp
                        @if (Auth::guard('subadmin')->check())
                            {{-- টিম লিডার বা টিচারের ইমেজ --}}
                            <img src="{{ $imagePath }}" alt="profile">
                        @else
                            {{-- এডমিনের ইমেজ --}}
                            <img src="{{ asset('backend/images/admin/' . $admin->image) }}" alt="image">
                        @endif
                        <span class="availability-status online"></span>
                    </div>
                    <div class="nav-profile-text">
                        <p class="mb-1 text-black">
                            {{ Auth::guard('subadmin')->check() ? Auth::guard('subadmin')->user()->name : $admin->name }}
                        </p>
                    </div>
                </a>

                <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item"
                        href="{{route('team_leader.profile')}}">
                        <i class="mdi mdi-account me-2 text-success"></i> Profile
                    </a>
                    <div class="dropdown-divider"></div>

                    {{-- লগআউট লজিক --}}
                    @if (Auth::guard('subadmin')->check())
                        <a class="dropdown-item" href="{{ url('/subadmin/logout') }}"> {{-- আপনার সাব-এডমিন লগআউট রাউট --}}
                            <i class="mdi mdi-logout me-2 text-primary"></i> Signout
                        </a>
                    @else
                        <a class="dropdown-item" href="{{ url('/admin/logout') }}">
                            <i class="mdi mdi-logout me-2 text-primary"></i> Signout
                        </a>
                    @endif
                </div>
            </li>

            <li class="nav-item d-none d-lg-block full-screen-link">
                <a class="nav-link">
                    <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                </a>
            </li>

            <li class="nav-item nav-logout d-none d-lg-block">
                <a class="nav-link"
                    href="{{ Auth::guard('subadmin')->check() ? url('/subadmin/logout') : url('/admin/logout') }}">
                    <i class="mdi mdi-power"></i>
                </a>
            </li>
        </ul>

        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>
