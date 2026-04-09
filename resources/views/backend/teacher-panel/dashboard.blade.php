@extends('backend.teacher-panel.TS-master')
@section('content')

<div class="container-fluid px-4 mt-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-success text-white shadow-sm border-0">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="fw-bold mb-1">Welcome Back, {{ Auth::guard('subadmin')->user()->name }}!</h2>
                        <p class="mb-0 opacity-75">আপনার আজকের ড্যাশবোর্ড ওভারভিউ চেক করুন।</p>
                    </div>
                    <div class="d-none d-md-block">
                        <i class="fas fa-user-graduate fa-3x opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-left: 5px solid #ffc107 !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase text-muted small fw-bold mb-2">Total Balance</div>
                            <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalBalance) }} <span class="small text-muted" style="font-size: 14px;">Points</span></h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning">
                            <i class="fas fa-wallet fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{route('teacher.withdraw')}}" class="text-decoration-none small text-warning fw-bold">Withdraw Points <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-left: 5px solid #0dcaf0 !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase text-muted small fw-bold mb-2">Total Students</div>
                            <h3 class="fw-bold mb-0 text-dark">{{ $totalStudents }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle text-info">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('stdent.list') }}" class="text-decoration-none small text-info fw-bold">View All Students <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-left: 5px solid #198754 !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase text-muted small fw-bold mb-2">Total Courses</div>
                            <h3 class="fw-bold mb-0 text-dark">{{ $totalCourses }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                            <i class="fas fa-book-open fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="#" class="text-decoration-none small text-success fw-bold">My Courses <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12 text-center">
            <p class="text-muted small">Lina Digital E-Learning Platform | Management Dashboard</p>
        </div>
    </div>
</div>

@endsection