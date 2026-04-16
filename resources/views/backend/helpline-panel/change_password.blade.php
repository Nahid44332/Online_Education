@extends('backend.helpline-panel.help-master')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-6 mx-auto mt-5">
            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-header bg-danger text-white py-3" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-key me-2"></i> Change Account Password</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('helpline.password.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Current Password</label>
                            <input type="password" name="old_password" class="form-control" placeholder="পুরাতন পাসওয়ার্ড দিন" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">New Password</label>
                            <input type="password" name="new_password" class="form-control" placeholder="নতুন পাসওয়ার্ড দিন (কমপক্ষে ৮ অক্ষর)" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Confirm New Password</label>
                            <input type="password" name="confirm_password" class="form-control" placeholder="নতুন পাসওয়ার্ডটি আবার দিন" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger btn-lg shadow-sm fw-bold">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection