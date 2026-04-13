@extends('backend.team-leader-panel.tl-master')

@section('content')
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h3 class="fw-bold">Welcome Back, {{ $tl_data->name }}! 👋</h3>
                    <p class="mb-0">Manage your students and check your performance from this panel.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body text-center">
                    <div class="icon-box bg-light-primary mb-3 mx-auto" style="width: 50px; height: 50px; line-height: 50px; border-radius: 50%;">
                        <i class="mdi mdi-account-multiple text-primary fs-4"></i>
                    </div>
                    <h5 class="text-muted small text-uppercase fw-bold">My Students</h5>
                    <h2 class="fw-bold mb-0 text-dark">{{ $studentCount }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body text-center">
                    <div class="icon-box bg-light-success mb-3 mx-auto" style="width: 50px; height: 50px; line-height: 50px; border-radius: 50%;">
                        <i class="mdi mdi-cash text-success fs-4"></i>
                    </div>
                    <h5 class="text-muted small text-uppercase fw-bold">Total Earnings</h5>
                    <h2 class="fw-bold mb-0 text-dark">৳ {{ number_format($totalEarnings ?? 0, 2) }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body text-center">
                    <div class="icon-box bg-light-info mb-3 mx-auto" style="width: 50px; height: 50px; line-height: 50px; border-radius: 50%;">
                        <i class="mdi mdi-star text-info fs-4"></i>
                    </div>
                    <h5 class="text-muted small text-uppercase fw-bold">Designation</h5>
                    <h2 class="fw-bold mb-0 text-dark" style="font-size: 1.5rem;">{{ $tl_data->designation ?? 'Team Leader' }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body">
                    <h4 class="card-title text-dark">Quick Actions</h4>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{route('team_leader.students')}}" class="btn btn-gradient-info btn-sm">View Students</a>
                        <a href="{{route('team_leader.withdraw.history')}}" class="btn btn-gradient-success btn-sm">Withdraw History</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection