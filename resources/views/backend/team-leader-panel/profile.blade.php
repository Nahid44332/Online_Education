@extends('backend.team-leader-panel.tl-master')

@section('content')
<style>
    .profile-card {
        border-radius: 20px !important;
        overflow: hidden;
        transition: transform 0.3s;
    }
    .profile-img-container {
        position: relative;
        display: inline-block;
    }
    .profile-img-container img {
        border: 5px solid #fff;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .info-list p {
        padding: 8px 0;
        border-bottom: 1px solid #f1f1f1;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        font-size: 14px;
    }
    .info-list i {
        width: 30px;
        font-size: 18px;
    }
    .card-title-premium {
        font-weight: 700;
        letter-spacing: 0.5px;
        position: relative;
        padding-bottom: 10px;
    }
    .card-title-premium::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 3px;
        background: linear-gradient(to right, #b66dff, #ff8d72);
    }
    .btn-gradient-custom {
        background: linear-gradient(to right, #da8cff, #9a55ff);
        border: none;
        color: white;
        font-weight: bold;
        padding: 12px;
        border-radius: 10px;
        transition: 0.3s;
    }
    .btn-gradient-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(182, 109, 255, 0.4);
        color: white;
    }
</style>

<div class="container-fluid mt-4">
    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 10px;">
            <i class="mdi mdi-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        {{-- টিম লিডার ইনফো কার্ড --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-4 profile-card bg-white">
                <div class="card-body">
                    <div class="profile-img-container">
                        <img src="{{ asset('backend/images/team-leader/' . ($tl_data->profile_image ?? 'default.png')) }}" 
                             style="width: 130px; height: 130px; border-radius: 50%; object-fit: cover;" class="mb-3">
                    </div>
                    
                    <h4 class="fw-bold text-dark mb-1">{{ $tl_data->name }}</h4>
                    <p class="text-muted mb-3">{{ $tl_data->designation ?? 'Team Head' }}</p>
                    
                    <span class="badge bg-soft-primary text-primary px-3 py-2 mb-3" style="background: #f3f0ff; border-radius: 10px;">
                        <i class="mdi mdi-star text-warning"></i> Rank: Platinum
                    </span>

                    <button class="btn btn-sm btn-outline-primary d-block mx-auto rounded-pill px-4 mt-2" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="mdi mdi-account-edit"></i> Edit Profile
                    </button>
                    
                    <hr class="my-4" style="opacity: 0.1;">
                    
                    <div class="text-start info-list">
                        <p><i class="mdi mdi-email text-primary"></i> <strong>Email:</strong> <span class="ms-auto text-muted">{{ $user->email }}</span></p>
                        <p><i class="mdi mdi-phone text-success"></i> <strong>Phone:</strong> <span class="ms-auto text-muted">{{ $tl_data->phone }}</span></p>
                        <p><i class="mdi mdi-calendar text-info"></i> <strong>DOB:</strong> <span class="ms-auto text-muted">{{ $tl_data->dob ?? 'Not Set' }}</span></p>
                        <p><i class="mdi mdi-water text-danger"></i> <strong>Blood:</strong> <span class="ms-auto text-muted">{{ $tl_data->blood }}</span></p>
                        <p><i class="mdi mdi-star-circle text-warning"></i> <strong>Points:</strong> <span class="ms-auto fw-bold text-dark">{{ number_format($tl_data->points, 0) }}</span></p>
                        <p><i class="mdi mdi-facebook text-facebook" style="color: #3b5998;"></i> <strong>FB:</strong> <a href="{{ $tl_data->facebook_link }}" class="ms-auto text-decoration-none" target="_blank">View Profile</a></p>
                    </div>
                </div>
            </div>
        </div>

        {{-- পাসওয়ার্ড আপডেট সেকশন --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm profile-card bg-white">
                <div class="card-body p-4">
                    <h4 class="card-title-premium text-primary mb-4">
                        <i class="mdi mdi-security"></i> Security Settings
                    </h4>
                    
                    <form action="{{ route('team_leader.password.update') }}" method="POST">
                        @csrf
                        <div class="row mt-4">
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold small text-uppercase">Current Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="mdi mdi-lock-open-outline"></i></span>
                                    <input type="password" name="old_password" class="form-control bg-light border-0" style="height: 50px;" placeholder="********" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold small text-uppercase">New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="mdi mdi-lock-outline"></i></span>
                                    <input type="password" name="new_password" class="form-control bg-light border-0" style="height: 50px;" placeholder="Min 8 characters" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold small text-uppercase">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="mdi mdi-check-decagram"></i></span>
                                    <input type="password" name="new_password_confirmation" class="form-control bg-light border-0" style="height: 50px;" placeholder="Repeat password" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-gradient-custom w-100 shadow-sm mt-2">
                            <i class="mdi mdi-content-save-settings"></i> Update Security Credentials
                        </button>
                    </form>
                </div>
            </div>
            
            {{-- একটা এক্সট্রা টিপস কার্ড দিয়ে দিচ্ছি লুকে প্রিমিয়াম ভাব আনার জন্য --}}
            <div class="card border-0 shadow-sm mt-4 bg-gradient-info text-white profile-card" style="background: linear-gradient(45deg, #19d2fe, #05539e);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <i class="mdi mdi-shield-check-outline display-4 me-3"></i>
                        <div>
                            <h5 class="fw-bold">সতর্কতা</h5>
                            <p class="mb-0 opacity-7">পাসওয়ার্ডে বড় হাত-ছোট হাতের অক্ষর এবং স্পেশাল ক্যারেক্টার ব্যবহার করুন আপনার অ্যাকাউন্ট নিরাপদ রাখতে।</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Edit Profile Modal --}}
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Update Profile Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('team_leader.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Full Name</label>
                        <input type="text" name="name" class="form-control rounded-3" value="{{ $tl_data->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Phone Number</label>
                        <input type="text" name="phone" class="form-control rounded-3" value="{{ $tl_data->phone }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Date of Birth</label>
                            <input type="date" name="dob" class="form-control rounded-3" value="{{ $tl_data->dob }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Blood Group</label>
                            <select name="blood" class="form-control rounded-3">
                                <option value="A+" {{ $tl_data->blood == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ $tl_data->blood == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ $tl_data->blood == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ $tl_data->blood == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="O+" {{ $tl_data->blood == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ $tl_data->blood == 'O-' ? 'selected' : '' }}>O-</option>
                                <option value="AB+" {{ $tl_data->blood == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ $tl_data->blood == 'AB-' ? 'selected' : '' }}>AB-</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Profile Image</label>
                        <input type="file" name="profile_image" class="form-control rounded-3">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Update Now</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection