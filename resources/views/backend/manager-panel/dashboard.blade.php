@extends('backend.manager-panel.master')

@section('content')
    <style>
        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .bg-light-primary {
            background: #f0f4ff;
            color: #4e73df;
        }

        .bg-light-success {
            background: #e8faf0;
            color: #1cc88a;
        }

        .bg-light-warning {
            background: #fff9e6;
            color: #f6c23e;
        }

        .bg-light-info {
            background: #e5f7fd;
            color: #36b9cc;
        }

        .progress {
            height: 8px;
            border-radius: 10px;
        }

        .table thead th {
            border-top: none;
            text-transform: uppercase;
            font-size: 12px;
            font-weight: 700;
            color: #a3a6b7;
        }
    </style>

    <div class="content-wrapper">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-gradient-primary text-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="font-weight-bold mb-1">Welcome back, {{ Auth::guard('subadmin')->user()->name }}!</h2>
                            <p class="mb-0">Here's what's happening with your education center today.</p>
                        </div>
                        <div class="d-none d-md-block">
                            <button class="btn btn-outline-light btn-sm">View Reports</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100 p-3">
                    <div class="stat-icon bg-light-primary"><i class="mdi mdi-account-group"></i></div>
                    <h6 class="text-muted font-weight-normal">Active Students</h6>
                    <div class="d-flex align-items-center">
                        <h3 class="font-weight-bold mb-0">{{$active_students}}</h3>
                        <span class="text-success ms-2 small"><i class="mdi mdi-arrow-up"></i> 6.2%</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100 p-3">
                    <div class="stat-icon bg-light-primary"><i class="mdi mdi-account-group"></i></div>
                    <h6 class="text-muted font-weight-normal">Inactive Students</h6>
                    <div class="d-flex align-items-center">
                        <h3 class="font-weight-bold mb-0">{{$inactive_students}}</h3>
                        <span class="text-success ms-2 small"><i class="mdi mdi-arrow-up"></i> 4.2%</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100 p-3">
                    <div class="stat-icon bg-light-primary"><i class="mdi mdi-account-group"></i></div>
                    <h6 class="text-muted font-weight-normal">Total Students</h6>
                    <div class="d-flex align-items-center">
                        <h3 class="font-weight-bold mb-0">{{$total_students}}</h3>
                        <span class="text-success ms-2 small"><i class="mdi mdi-arrow-up"></i> 9.2%</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100 p-3">
                    <div class="stat-icon bg-light-info"><i class="mdi mdi-account-tie"></i></div>
                    <h6 class="text-muted font-weight-normal">Total Teachers</h6>
                    <div class="d-flex align-items-center">
                        <h3 class="font-weight-bold mb-0">{{$total_teachers}}</h3>
                        {{-- <span class="text-info ms-2 small">4 New</span> --}}
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100 p-3">
                    <div class="stat-icon bg-light-info"><i class="mdi mdi-account-tie"></i></div>
                    <h6 class="text-muted font-weight-normal">Total Trainer</h6>
                    <div class="d-flex align-items-center">
                        <h3 class="font-weight-bold mb-0">{{$total_trainer}}</h3>
                        {{-- <span class="text-info ms-2 small">2 New</span> --}}
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100 p-3">
                    <div class="stat-icon bg-light-info"><i class="mdi mdi-account-tie"></i></div>
                    <h6 class="text-muted font-weight-normal">Total Team Leader</h6>
                    <div class="d-flex align-items-center">
                        <h3 class="font-weight-bold mb-0">{{$total_teamleader}}</h3>
                        {{-- <span class="text-info ms-2 small">1 New</span> --}}
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100 p-3">
                    <div class="stat-icon bg-light-info"><i class="mdi mdi-account-tie"></i></div>
                    <h6 class="text-muted font-weight-normal">Total Counsellor</h6>
                    <div class="d-flex align-items-center">
                        <h3 class="font-weight-bold mb-0">{{$total_counsellor}}</h3>
                        {{-- <span class="text-info ms-2 small">0</span> --}}
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100 p-3">
                    <div class="stat-icon bg-light-info"><i class="mdi mdi-face-agent"></i></div>
                    <h6 class="text-muted font-weight-normal">Total Helpline</h6>
                    <div class="d-flex align-items-center">
                        <h3 class="font-weight-bold mb-0">{{$total_helpline}}</h3>
                        {{-- <span class="text-info ms-2 small">0</span> --}}
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100 p-3">
                    <div class="stat-icon bg-light-success"><i class="mdi mdi-cash-multiple"></i></div>
                    <h6 class="text-muted font-weight-normal">Earnings (MTD)</h6>
                    <div class="d-flex align-items-center">
                        <h3 class="font-weight-bold mb-0">৳ {{$total_earnings}}</h3>
                        <span class="text-success ms-2 small"><i class="mdi mdi-arrow-up"></i> 12%</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100 p-3">
                    <div class="stat-icon bg-light-warning"><i class="mdi mdi-book-open-variant"></i></div>
                    <h6 class="text-muted font-weight-normal">Active Courses</h6>
                    <div class="d-flex align-items-center">
                        <h3 class="font-weight-bold mb-0">{{$total_course}}</h3>
                        <span class="text-muted ms-2 small">6 categories</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100 p-3">
                    <div class="stat-icon bg-light-primary"><i class="mdi mdi-account-group"></i></div>
                    <h6 class="text-muted font-weight-normal">Today Registation</h6>
                    <div class="d-flex align-items-center">
                        <h3 class="font-weight-bold mb-0">{{$today_reg}}</h3>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100 p-3">
                    <div class="stat-icon bg-light-primary"><i class="mdi mdi-account-group"></i></div>
                    <h6 class="text-muted font-weight-normal">Today Active</h6>
                    <div class="d-flex align-items-center">
                        <h3 class="font-weight-bold mb-0">{{$today_active}}</h3>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <h4 class="card-title">Recent Student Admission</h4>
                            <a href="#" class="text-primary small font-weight-bold">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Course</th>
                                        <th>Payment</th>
                                        <th>Activity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="py-1">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('backend/images/no_image.jpg') }}" alt="image"
                                                    class="me-2" style="border-radius: 8px;">
                                                <div>
                                                    <span class="font-weight-bold d-block">Nahid Hossen</span>
                                                    <small class="text-muted">ID: #ST-992</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Laravel Dev</td>
                                        <td><label class="badge badge-success">Paid</label></td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 75%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-1">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('backend/images/no_image.jpg') }}" alt="image"
                                                    class="me-2" style="border-radius: 8px;">
                                                <div>
                                                    <span class="font-weight-bold d-block">Jakir Hossen</span>
                                                    <small class="text-muted">ID: #ST-854</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Graphics</td>
                                        <td><label class="badge badge-warning">Partial</label></td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-warning" role="progressbar"
                                                    style="width: 45%" aria-valuenow="45" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">System Overview</h4>
                        <div class="mt-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="stat-icon bg-light-primary mb-0 me-3"
                                    style="width:40px; height:40px; font-size: 18px;"><i class="mdi mdi-database"></i>
                                </div>
                                <div class="w-100">
                                    <p class="mb-1">Server Storage <span class="float-right text-muted">85%</span></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" style="width: 85%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="stat-icon bg-light-success mb-0 me-3"
                                    style="width:40px; height:40px; font-size: 18px;"><i
                                        class="mdi mdi-clock-outline"></i></div>
                                <div class="w-100">
                                    <p class="mb-1">Teacher Attendance <span class="float-right text-muted">92%</span>
                                    </p>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" style="width: 92%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h6 class="mt-4 mb-3">Today's Quick Links</h6>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary btn-icon-text btn-sm text-start"><i
                                    class="mdi mdi-plus me-2"></i> Add New Student</button>
                            <button class="btn btn-outline-info btn-icon-text btn-sm text-start"><i
                                    class="mdi mdi-email-outline me-2"></i> Send Group Mail</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
