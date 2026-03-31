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
            <!-- Total Students -->
            <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-primary card-img-holder text-white">
                    <div class="card-body">
                        <img src="{{ asset('backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                            alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Total Students <i
                                class="mdi mdi-account-group mdi-24px float-end"></i></h4>
                        <h2 class="mb-5">{{ $totalStudents }}</h2>
                    </div>
                </div>
            </div>

            <!-- Total Teachers -->
            <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                    <div class="card-body">
                        <img src="{{ asset('backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                            alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Total Teachers <i class="mdi mdi-teach mdi-24px float-end"></i>
                        </h4>
                        <h2 class="mb-5">{{ $totalTeachers }}</h2>
                    </div>
                </div>
            </div>

            <!-- Total Courses -->
            <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                    <div class="card-body">
                        <img src="{{ asset('backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                            alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Total Courses <i
                                class="mdi mdi-book-open-variant mdi-24px float-end"></i></h4>
                        <h2 class="mb-5">{{ $totalCourses }}</h2>
                    </div>
                </div>
            </div>

            <!-- Total Payments -->
            <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                    <div class="card-body">
                        <img src="{{ asset('backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                            alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Total Payments <i class="mdi mdi-cash mdi-24px float-end"></i>
                        </h4>
                        <h2 class="mb-5">{{ number_format($totalPayments, 2) }} BD</h2>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">System Overview</h4>
                        <canvas id="overviewChart"></canvas>
                    </div>
                </div>
            </div>


            <!-- Active vs Inactive Students -->
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Students Status</h4>
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Students -->
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Recent Students</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> Name </th>
                                        <th> Email </th>
                                        <th> Phone </th>
                                        <th> Status </th>
                                        <th> Joined </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentStudents as $student)
                                        <tr>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->email }}</td>
                                            <td>{{ $student->phone }}</td>
                                            <td>
                                                @if ($student->status == 1)
                                                    <label class="badge badge-gradient-success">Active</label>
                                                @else
                                                    <label class="badge badge-gradient-danger">Inactive</label>
                                                @endif
                                            </td>
                                            <td>{{ $student->created_at->format('d M Y') }}</td>
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
    {{-- Chart.js প্রথমে লোড করো --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Students Status Doughnut Chart --}}
    <script>
        const ctxStatus = document.getElementById('statusChart');
        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: ['Active', 'Inactive'],
                datasets: [{
                    data: [{{ $activeStudents }}, {{ $inactiveStudents }}],
                    backgroundColor: ['#28a745', '#dc3545'],
                }]
            }
        });
    </script>

    {{-- System Overview Bar Chart --}}
    <script>
        const ctxOverview = document.getElementById('overviewChart');

        new Chart(ctxOverview, {
            type: 'bar',
            data: {
                labels: ['Students', 'Teachers', 'Courses'],
                datasets: [{
                    label: 'Total Count',
                    data: [
                        {{ $chartData['students'] }},
                        {{ $chartData['teachers'] }},
                        {{ $chartData['courses'] }}
                    ],
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    </script>
@endpush

