@extends('backend.master')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Dashboard
        </h3>
    </div>

    <div class="row">
        <div class="col-md-2 col-sm-6 stretch-card grid-margin">
            <div class="card bg-gradient-warning card-img-holder text-white shadow-sm border-0">
                <div class="card-body p-3 text-center">
                    <img src="{{ asset('backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <i class="mdi mdi-account-plus mdi-24px"></i>
                    <h6 class="font-weight-normal mt-2 mb-1" style="font-size: 12px;">Today's Reg.</h6>
                    <h3 class="mb-0">{{ $todayReg }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-sm-6 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white shadow-sm border-0">
                <div class="card-body p-3 text-center">
                    <img src="{{ asset('backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <i class="mdi mdi-check-decagram mdi-24px"></i>
                    <h6 class="font-weight-normal mt-2 mb-1" style="font-size: 12px;">Today's Active</h6>
                    <h3 class="mb-0">{{ $todayActivated }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-sm-6 stretch-card grid-margin">
            <div class="card bg-gradient-primary card-img-holder text-white shadow-sm border-0">
                <div class="card-body p-3 text-center">
                    <img src="{{ asset('backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <i class="mdi mdi-account-group mdi-24px"></i>
                    <h6 class="font-weight-normal mt-2 mb-1" style="font-size: 12px;">Total Students</h6>
                    <h3 class="mb-0">{{ $totalStudents }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-sm-6 stretch-card grid-margin">
            <div class="card bg-gradient-dark card-img-holder text-white shadow-sm border-0">
                <div class="card-body p-3 text-center">
                    <img src="{{ asset('backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <i class="mdi mdi-teach mdi-24px"></i>
                    <h6 class="font-weight-normal mt-2 mb-1" style="font-size: 12px;">Total Teachers</h6>
                    <h3 class="mb-0">{{ $totalTeachers }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-sm-6 stretch-card grid-margin">
            <div class="card bg-gradient-success card-img-holder text-white shadow-sm border-0">
                <div class="card-body p-3 text-center">
                    <img src="{{ asset('backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <i class="mdi mdi-book-open-variant mdi-24px"></i>
                    <h6 class="font-weight-normal mt-2 mb-1" style="font-size: 12px;">Total Courses</h6>
                    <h3 class="mb-0">{{ $totalCourses }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-sm-6 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white shadow-sm border-0">
                <div class="card-body p-3 text-center">
                    <img src="{{ asset('backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <i class="mdi mdi-cash mdi-24px"></i>
                    <h6 class="font-weight-normal mt-2 mb-1" style="font-size: 12px;">Earnings</h6>
                    <h3 class="mb-0" style="font-size: 16px;">{{ number_format($totalPayments, 0) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7 grid-margin stretch-card">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title">System Overview</h4>
                    <canvas id="overviewChart" style="height:250px"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-5 grid-margin stretch-card">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title">Students Status</h4>
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">Recent Registered Students</h4>
                        <a href="{{url('/admin/student/list')}}" class="btn btn-sm btn-gradient-primary">View All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th> Name </th>
                                    <th> Contact Info </th>
                                    <th class="text-center"> Status </th>
                                    <th> Joined </th>
                                    <th class="text-center"> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentStudents as $student)
                                    <tr>
                                        <td><span class="fw-bold">{{ $student->name }}</span></td>
                                        <td>
                                            <small><i class="mdi mdi-email text-primary"></i> {{ $student->email }}</small><br>
                                            <small><i class="mdi mdi-phone text-primary"></i> {{ $student->phone }}</small>
                                        </td>
                                        <td class="text-center">
                                            @if ($student->status == 1)
                                                <label class="badge badge-gradient-success">Active</label>
                                            @else
                                                <label class="badge badge-gradient-danger">Pending</label>
                                            @endif
                                        </td>
                                        <td>{{ $student->created_at->diffForHumans() }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-light"><i class="mdi mdi-eye text-primary"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Students Status Doughnut Chart
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Active', 'Inactive'],
                datasets: [{
                    data: [{{ $activeStudents }}, {{ $inactiveStudents }}],
                    backgroundColor: ['#1bcfb4', '#fe7c96'],
                    borderWidth: 0
                }]
            },
            options: { cutout: '70%', responsive: true }
        });

        // System Overview Bar Chart
        new Chart(document.getElementById('overviewChart'), {
            type: 'bar',
            data: {
                labels: ['Students', 'Teachers', 'Courses'],
                datasets: [{
                    label: 'Total Count',
                    data: [{{ $chartData['students'] }}, {{ $chartData['teachers'] }}, {{ $chartData['courses'] }}],
                    backgroundColor: ['#b66dff', '#047edf', '#1be3a0'],
                    borderRadius: 5
                }]
            },
            options: {
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });
    </script>
@endpush