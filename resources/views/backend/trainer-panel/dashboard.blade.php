@extends('backend.trainer-panel.tr-master')
@section('content')
<div class="content-wrapper">
    <div class="container-fluid mt-4">
        {{-- ওয়েলকাম ব্যানার --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-gradient-primary text-white shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <h3 class="fw-bold">Welcome Back, {{ $trainer->name }}! 👋</h3>
                        <p class="mb-0">Monitor student progress and manage your training sessions effectively.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- স্ট্যাটাস কার্ডস --}}
        <div class="row">
            {{-- মোট স্টুডেন্ট --}}
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body text-center">
                        <div class="icon-box bg-light-primary mb-3 mx-auto" style="width: 50px; height: 50px; line-height: 50px; border-radius: 50%; background-color: #f0f7ff;">
                            <i class="mdi mdi-account-multiple text-primary fs-4"></i>
                        </div>
                        <h5 class="text-muted small text-uppercase fw-bold">My Students</h5>
                        <h2 class="fw-bold mb-0 text-dark">{{$totalStudents}}</h2>
                    </div>
                </div>
            </div>

            {{-- মোট ইনকাম --}}
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body text-center">
                        <div class="icon-box bg-light-success mb-3 mx-auto" style="width: 50px; height: 50px; line-height: 50px; border-radius: 50%; background-color: #e8f9f0;">
                            <i class="mdi mdi-cash text-success fs-4"></i>
                        </div>
                        <h5 class="text-muted small text-uppercase fw-bold">Total Earnings</h5>
                        <h2 class="fw-bold mb-0 text-dark">৳ {{$totalEarnings}}</h2>
                    </div>
                </div>
            </div>

            {{-- পদবী/ডেজিগনেশন --}}
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body text-center">
                        <div class="icon-box bg-light-info mb-3 mx-auto" style="width: 50px; height: 50px; line-height: 50px; border-radius: 50%; background-color: #e7f6f8;">
                            <i class="mdi mdi-star text-info fs-4"></i>
                        </div>
                        <h5 class="text-muted small text-uppercase fw-bold">Designation</h5>
                        <h2 class="fw-bold mb-0 text-dark" style="font-size: 1.5rem;">Official Trainer</h2>
                    </div>
                </div>
            </div>
        </div>

        {{-- কুইক অ্যাকশন --}}
        <div class="row mt-2">
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body">
                        <h4 class="card-title text-dark">Quick Actions</h4>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('trainer.stdent.list') }}" class="btn btn-gradient-info btn-sm">View My Students</a>
                            <a href="{{ route('trainer.withdraw') }}" class="btn btn-gradient-success btn-sm">Withdraw Request</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* যদি তোমার CSS ফাইলে এগুলো না থাকে তবেই এটা ব্যবহার করো */
    .bg-light-primary { background-color: #e8f2ff !important; }
    .bg-light-success { background-color: #e8f9f0 !important; }
    .bg-light-info { background-color: #e7f6f8 !important; }
    .gap-2 { gap: 0.5rem !important; }
    .btn-sm { padding: 0.5rem 1rem; }
</style>
@endsection