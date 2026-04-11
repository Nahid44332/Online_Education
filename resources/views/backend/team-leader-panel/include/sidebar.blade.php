<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            @if(Auth::guard('subadmin')->check())
                <a href="#" class="nav-link">
                    <div class="nav-profile-image">
                        {{-- টিম লিডারের ইমেজ ডাইনামিক করা --}}
                        <img src="{{ asset('backend/images/team-leader/' . ($tl_data->profile_image ?? 'default.png')) }}" alt="profile" />
                        <span class="login-status online"></span>
                    </div>
                    <div class="nav-profile-text d-flex flex-column">
                        <span class="font-weight-bold mb-2">{{ Auth::guard('subadmin')->user()->name }}</span>
                        <span class="text-secondary text-small">{{ ucfirst(Auth::guard('subadmin')->user()->position) }}</span>
                    </div>
                </a>
            @endif
        </li>

        @if(Auth::guard('subadmin')->check() && Auth::guard('subadmin')->user()->position == 'team_leader')
            
            <li class="nav-item">
                <a class="nav-link" href="{{ route('team_leader.dashboard') }}">
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
                            <a class="nav-link" href="{{ route('team_leader.students') }}">Student List</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span class="menu-title">My Earnings</span>
                    <i class="mdi mdi-currency-bdt menu-icon"></i>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#withdraw-menu" aria-expanded="false" aria-controls="withdraw-menu">
                    <span class="menu-title">Withdraw</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-cash-multiple menu-icon"></i>
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
                    <i class="mdi mdi-bulletin-board menu-icon"></i>
                </a>
            </li>

        @endif

        {{-- এখানে আপনার আগের এডমিন মেনুগুলো থাকবে, যেগুলোকে @if(Auth::guard('admin')->check()) দিয়ে ঘিরে দিতে পারেন --}}
        
    </ul>
</nav>