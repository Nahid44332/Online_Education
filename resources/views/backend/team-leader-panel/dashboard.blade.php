@extends('backend.team-leader-panel.tl-master')

@section('content')
<div class="container-fluid mt-4">
    {{-- ওয়েলকাম ব্যানার --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h3 class="fw-bold">Welcome Back, {{ $tl_data->name }}! 👋</h3>
                    <p class="mb-0">সরাসরি আপনার টিমের পারফরম্যান্স এবং স্টুডেন্ট আপডেট এখান থেকে মনিটর করুন।</p>
                </div>
            </div>
        </div>
    </div>

    {{-- স্ট্যাটাস কার্ডস (৪টি কার্ড এক লাইনে) --}}
    <div class="row">
        {{-- আজকের রেজিস্ট্রেশন (নতুন ফর্ম ফিলাপ) --}}
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm text-center h-100" style="border-radius: 12px;">
                <div class="card-body">
                    <div class="icon-box mb-2 mx-auto" style="width: 45px; height: 45px; line-height: 45px; border-radius: 50%; background-color: #fff4e5;">
                        <i class="mdi mdi-account-plus text-warning fs-4"></i>
                    </div>
                    <h6 class="text-muted small text-uppercase fw-bold">Today's Reg</h6>
                    <h2 class="fw-bold mb-0 text-dark">{{ $todayReg }}</h2>
                </div>
            </div>
        </div>

        {{-- আজকের এক্টিভেশন --}}
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm text-center h-100" style="border-radius: 12px;">
                <div class="card-body">
                    <div class="icon-box mb-2 mx-auto" style="width: 45px; height: 45px; line-height: 45px; border-radius: 50%; background-color: #e8f9f0;">
                        <i class="mdi mdi-account-check text-success fs-4"></i>
                    </div>
                    <h6 class="text-muted small text-uppercase fw-bold">Today's Active</h6>
                    <h2 class="fw-bold mb-0 text-dark">{{ $todayActive }}</h2>
                </div>
            </div>
        </div>

        {{-- মোট স্টুডেন্ট --}}
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm text-center h-100" style="border-radius: 12px;">
                <div class="card-body">
                    <div class="icon-box mb-2 mx-auto" style="width: 45px; height: 45px; line-height: 45px; border-radius: 50%; background-color: #f0f7ff;">
                        <i class="mdi mdi-account-multiple text-primary fs-4"></i>
                    </div>
                    <h6 class="text-muted small text-uppercase fw-bold">My Students</h6>
                    <h2 class="fw-bold mb-0 text-dark">{{ $studentCount }}</h2>
                </div>
            </div>
        </div>

        {{-- মোট ইনকাম --}}
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm text-center h-100" style="border-radius: 12px;">
                <div class="card-body">
                    <div class="icon-box mb-2 mx-auto" style="width: 45px; height: 45px; line-height: 45px; border-radius: 50%; background-color: #feeef0;">
                        <i class="mdi mdi-cash text-danger fs-4"></i>
                    </div>
                    <h6 class="text-muted small text-uppercase fw-bold">Total Earnings</h6>
                    <h2 class="fw-bold mb-0 text-dark">৳ {{ number_format($totalEarnings ?? 0, 0) }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- কুইক অ্যাকশন --}}
    <div class="row mt-2">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title text-dark mb-0">Quick Actions</h4>
                        <span class="badge badge-outline-primary">{{ $tl_data->designation ?? 'Team Leader' }}</span>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{route('team_leader.students')}}" class="btn btn-gradient-info btn-sm">View My Team</a>
                        <a href="{{route('team_leader.withdraw.history')}}" class="btn btn-gradient-success btn-sm">Withdraw History</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-light-primary { background-color: #f0f7ff !important; }
    .bg-light-success { background-color: #e8f9f0 !important; }
    .bg-light-info { background-color: #e7f6f8 !important; }
    .gap-2 { gap: 0.5rem !important; }
    .btn-sm { padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 500; }
</style>
@endsection