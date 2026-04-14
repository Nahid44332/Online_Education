@extends('backend.master')

@section('content')
<div class="container-fluid mt-4 pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark"><i class="fa-solid fa-chart-line me-2"></i>Analytics Reports</h3>
        <button class="btn btn-outline-primary btn-sm" onclick="window.print()">
            <i class="fa-solid fa-print me-1"></i> Print Report
        </button>
    </div>

    <div class="row g-3">
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm bg-primary text-white h-100">
                <div class="card-body text-center p-3">
                    <i class="fa-solid fa-user-graduate mb-2 opacity-50" style="font-size: 1.5rem;"></i>
                    <h6 class="text-uppercase small fw-bold mb-1">Total Students</h6>
                    <h3 class="mb-0 fw-bold">{{ $totalstudents }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm bg-success text-white h-100">
                <div class="card-body text-center p-3">
                    <i class="fa-solid fa-chalkboard-user mb-2 opacity-50" style="font-size: 1.5rem;"></i>
                    <h6 class="text-uppercase small fw-bold mb-1">Total Teachers</h6>
                    <h3 class="mb-0 fw-bold">{{ $totateachers }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm bg-warning text-dark h-100">
                <div class="card-body text-center p-3">
                    <i class="fa-solid fa-book mb-2 opacity-50" style="font-size: 1.5rem;"></i>
                    <h6 class="text-uppercase small fw-bold mb-1">Total Courses</h6>
                    <h3 class="mb-0 fw-bold">{{ $totacourses }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm bg-info text-white h-100">
                <div class="card-body text-center p-3">
                    <i class="fa-solid fa-money-bill-wave mb-2 opacity-50" style="font-size: 1.5rem;"></i>
                    <h6 class="text-uppercase small fw-bold mb-1">Total Payments</h6>
                    <h3 class="mb-0 fw-bold">{{ $totapayments }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm bg-dark text-white h-100">
                <div class="card-body text-center p-3">
                    <i class="fa-solid fa-certificate mb-2 opacity-50" style="font-size: 1.5rem;"></i>
                    <h6 class="text-uppercase small fw-bold mb-1">Certificates</h6>
                    <h3 class="mb-0 fw-bold">{{ $totacertificates }}</h3>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-5 opacity-25">

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary"><i class="fa-solid fa-users me-2"></i>Student List</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="text-center">
                                    <th>SL</th>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Contact Info</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td><span class="badge bg-light text-dark border">#{{ $student->id }}</span></td>
                                        <td class="fw-bold">{{ $student->name }}</td>
                                        <td>
                                            <small class="d-block"><i class="fa-solid fa-phone me-1 text-muted"></i>{{ $student->phone }}</small>
                                            <small class="d-block"><i class="fa-solid fa-envelope me-1 text-muted"></i>{{ $student->email }}</small>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 text-success">
                    <h5 class="mb-0 fw-bold"><i class="fa-solid fa-graduation-cap me-2"></i>Teacher & Assigned Courses</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="text-center">
                                    <th>SL</th>
                                    <th>Teacher Name</th>
                                    <th>Courses</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($teachers as $teacher)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-bold">{{ $teacher->name }}</td>
                                        <td>
                                            @forelse($teacher->courses as $course)
                                                <span class="badge bg-success-subtle text-success border border-success mb-1 small">{{ $course->title }}</span>
                                            @empty
                                                <span class="text-muted small">No Course Assign</span>
                                            @endforelse
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 text-warning">
                    <h5 class="mb-0 fw-bold"><i class="fa-solid fa-book-open me-2"></i>Course & Fees</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="text-center">
                                    <th>SL</th>
                                    <th>Course Title</th>
                                    <th>Fee (৳)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($courses as $course)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-bold">{{ $course->title }}</td>
                                        <td class="text-primary fw-bold">৳{{ number_format($course->course_fee, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 text-info">
                    <h5 class="mb-0 fw-bold"><i class="fa-solid fa-receipt me-2"></i>Recent Payments</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th>Student</th>
                                    <th>Course</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->student->name ?? 'N/A' }}</td>
                                        <td class="small">{{ $payment->course->title ?? 'N/A' }}</td>
                                        <td class="fw-bold text-success">৳{{ number_format($payment->amount, 0) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 text-dark">
                    <h5 class="mb-0 fw-bold"><i class="fa-solid fa-award me-2"></i>Certificate Logs</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th>Student</th>
                                    <th>Certificate No</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($certificates as $certificate)
                                    <tr>
                                        <td>{{ $certificate->student->name ?? 'N/A' }}</td>
                                        <td><code class="fw-bold text-dark">{{ $certificate->certificate_no }}</code></td>
                                        <td class="small text-muted">{{ $certificate->issue_date }}</td>
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

<style>
    .card { transition: transform 0.2s ease; border-radius: 12px; }
    .card:hover { transform: translateY(-3px); }
    .table-responsive { max-height: 400px; overflow-y: auto; }
    .bg-success-subtle { background-color: #e1f7ec; }
    .text-nowrap { white-space: nowrap; }
    @media print {
        .btn, .breadcrumb, hr { display: none !important; }
        .card { box-shadow: none !important; border: 1px solid #ddd !important; }
        .table-responsive { overflow: visible !important; max-height: none !important; }
    }
</style>
@endsection