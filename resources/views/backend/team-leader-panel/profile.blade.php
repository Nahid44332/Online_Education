@extends('backend.team-leader-panel.tl-master')
@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        {{-- টিম লিডার ইনফো কার্ড --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-4" style="border-radius: 15px; background: linear-gradient(145deg, #ffffff, #f0f0f0);">
                <div class="card-body">
                    <img src="{{ asset('backend/images/team-leader/' . ($tl_data->profile_image ?? 'default.png')) }}" 
                         style="width: 120px; height: 120px; border-radius: 50%; border: 4px solid #b66dff; object-fit: cover;" class="mb-3">
                    <h4 class="fw-bold text-dark">{{ $tl_data->name }}</h4>
                    <label class="badge badge-gradient-danger">{{ $tl_data->designation ?? 'Team Leader' }}</label>
                    <hr>
                    <div class="text-start mt-3">
                        <p><i class="mdi mdi-phone text-primary"></i> <strong>Phone:</strong> {{ $tl_data->phone }}</p>
                        <p><i class="mdi mdi-water text-danger"></i> <strong>Blood:</strong> {{ $tl_data->blood }}</p>
                        <p><i class="mdi mdi-star text-warning"></i> <strong>My Points:</strong> {{ number_format($tl_data->points, 0) }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- পাসওয়ার্ড আপডেট সেকশন --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h4 class="card-title fw-bold text-primary mb-4">
                        <i class="mdi mdi-security"></i> Security Settings
                    </h4>
                    <form action="{{ route('team_leader.password.update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password" name="old_password" class="form-control form-control-lg" placeholder="Enter current password" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" name="new_password" class="form-control form-control-lg" placeholder="New password" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="new_password_confirmation" class="form-control form-control-lg" placeholder="Confirm new password" required>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-gradient-primary btn-lg w-100 shadow-sm">
                                <i class="mdi mdi-content-save"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection