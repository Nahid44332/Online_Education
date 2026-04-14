@extends('backend.teacher-panel.TS-master')
@section('content')
    <style>
        .teacher-card {
            border-radius: 20px;
            border: none;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .teacher-img {
            border: 5px solid #fff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
        }

        .info-box {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 10px;
        }

        .btn-premium {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(118, 75, 162, 0.3);
            color: white;
        }
    </style>

    <div class="container-fluid mt-4">
        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
        @endif

        <div class="row">
            {{-- টিচার প্রোফাইল কার্ড --}}
            <div class="col-md-4">
                <div class="card teacher-card text-center p-4">
                    <div class="card-body">
                        <img src="{{ asset('backend/images/teachers/' . Auth::guard('subadmin')->user()->teacher->profile_image) }}"
                            class="teacher-img mb-3">

                        <h4 class="fw-bold mb-1">{{ $teacher->name }}</h4>
                        <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill mb-3"
                            style="background: #eef2ff;">
                            Senior Instructor
                        </span>

                        <div class="d-flex justify-content-between mt-3 mb-4">
                            <div class="text-center w-100 border-end">
                                <h5 class="fw-bold mb-0">{{ number_format($teacher->points ?? 0) }}</h5>
                                <small class="text-muted">Points</small>
                            </div>
                            <div class="text-center w-100">
                                <h5 class="fw-bold mb-0">Active</h5>
                                <small class="text-muted">Status</small>
                            </div>
                        </div>

                        <a href="{{ route('teacher.profile.edit') }}"
                            class="btn btn-sm btn-outline-primary w-100 rounded-pill py-2" data-bs-toggle="modal"
                            data-bs-target="#editTeacherModal">
                            <i class="mdi mdi-circle-edit-outline"></i> Edit Profile
                        </a>

                        <div class="text-start mt-4">
                            <div class="info-box d-flex align-items-center">
                                <i class="mdi mdi-phone-classic text-primary me-3 fs-4"></i>
                                <div><small class="text-muted d-block">Phone</small><strong>{{ $teacher->phone }}</strong>
                                </div>
                            </div>
                            <div class="info-box d-flex align-items-center">
                                <i class="mdi mdi-water text-danger me-3 fs-4"></i>
                                <div><small class="text-muted d-block">Blood
                                        Group</small><strong>{{ $teacher->blood ?? 'N/A' }}</strong></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- সিকিউরিটি সেটআপ --}}
            <div class="col-md-8">
                <div class="card teacher-card p-4">
                    <h4 class="fw-bold text-dark mb-4 border-bottom pb-3">
                        <i class="mdi mdi-shield-check text-primary"></i> Account Security
                    </h4>

                    <form action="{{ route('teacher.password.update') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase">Current Password</label>
                            <input type="password" name="old_password"
                                class="form-control form-control-lg border-0 bg-light" placeholder="Enter current password"
                                required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label small fw-bold text-uppercase">New Password</label>
                                {{-- name="new_password" এর বদলে name="password" --}}
                                <input type="password" name="password"
                                    class="form-control form-control-lg border-0 bg-light" placeholder="New Password"
                                    required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label small fw-bold text-uppercase">Confirm New Password</label>
                                {{-- name="new_password_confirmation" এর বদলে name="password_confirmation" --}}
                                <input type="password" name="password_confirmation"
                                    class="form-control form-control-lg border-0 bg-light" placeholder="Repeat Password"
                                    required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-premium w-100 shadow-sm mt-2">
                            <i class="mdi mdi-content-save"></i> Save Security Changes
                        </button>
                    </form>
                </div>

                {{-- গ্রিটিং কার্ড --}}
                <div class="card teacher-card mt-4 border-0 text-white"
                    style="background: linear-gradient(135deg, #3a1c71, #d76d77, #ffaf7b);">
                    <div class="card-body p-4">
                        <h5 class="fw-bold">Welcome Back, Instructor!</h5>
                        <p class="mb-0 opacity-75">আপনার মেধা দিয়ে গড়ে তুলুন আগামী দিনের দক্ষ কারিগর। Lina Digital-এ আপনাকে
                            স্বাগতম।</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
