@extends('backend.counsellor-panel.cs-master')
@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark"><i class="mdi mdi-account-edit me-2"></i>Edit Profile</h5>
                    <a href="{{ route('counsellor.profile') }}" class="btn btn-secondary btn-sm">Back to View</a>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('counsellor.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 text-center mb-4">
                                <img src="{{ asset('backend/images/counsellor/' . Auth::guard('subadmin')->user()->counsellor->profile_image) }}" 
                                     class="rounded-circle border p-1" width="120" height="120" style="object-fit: cover;">
                                <div class="mt-2">
                                    <label class="form-label small">Change Profile Image</label>
                                    <input type="file" name="profile_image" class="form-control form-control-sm mx-auto" style="max-width: 250px;">
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Full Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $counsellor->name }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Phone Number</label>
                                <input type="text" name="phone" class="form-control" value="{{ $counsellor->phone }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small">Gender</label>
                                <select name="gender" class="form-select">
                                    <option value="Male" {{ $counsellor->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $counsellor->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small">Blood Group</label>
                                <input type="text" name="blood" class="form-control" value="{{ $counsellor->blood }}" placeholder="e.g. B+">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small">Date of Birth</label>
                                <input type="date" name="dob" class="form-control" value="{{ $counsellor->dob }}">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold small">Facebook Profile Link</label>
                                <input type="url" name="facebook_link" class="form-control" value="{{ $counsellor->facebook_link }}">
                            </div>

                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold small">Address</label>
                                <textarea name="address" class="form-control" rows="3">{{ $counsellor->address }}</textarea>
                            </div>
                        </div>

                        <div class="text-end border-top pt-3">
                            <button type="submit" class="btn btn-primary px-5">Update Profile Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection