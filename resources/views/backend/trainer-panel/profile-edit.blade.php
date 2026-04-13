@extends('backend.trainer-panel.tr-master')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card shadow-sm" style="border-radius: 15px;">
                <div class="card-body">
                    <h4 class="card-title text-primary">Edit Profile Information</h4>
                    <form action="{{ route('trainer.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Full Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $subadmin->name }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Phone Number</label>
                                <input type="text" name="phone" class="form-control" value="{{ $trainer->phone }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Date of Birth</label>
                                <input type="date" name="dob" class="form-control" value="{{ $trainer->dob }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Blood Group</label>
                                <select name="blood" class="form-control">
                                    <option value="A+" {{ $trainer->blood == 'A+' ? 'selected' : '' }}>A+</option>
                                    <option value="B+" {{ $trainer->blood == 'B+' ? 'selected' : '' }}>B+</option>
                                    <option value="O+" {{ $trainer->blood == 'O+' ? 'selected' : '' }}>O+</option>
                                    <option value="AB+" {{ $trainer->blood == 'AB+' ? 'selected' : '' }}>AB+</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Facebook Profile Link</label>
                                <input type="url" name="facebook_link" class="form-control" value="{{ $trainer->facebook_link }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Change Profile Image</label>
                                <input type="file" name="profile_image" class="form-control">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-gradient-primary me-2">Update Profile</button>
                        <a href="{{ route('trainer.profile') }}" class="btn btn-light">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection