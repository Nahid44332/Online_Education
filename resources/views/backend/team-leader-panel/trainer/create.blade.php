@extends('backend.team-leader-panel.tl-master')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Create New Trainer (Full Profile) </h3>
    </div>

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form class="forms-sample" action="{{ route('team_leader.trainers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            {{-- Basic Info --}}
                            <div class="col-md-6 form-group">
                                <label>Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="Name" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>

                            {{-- Password & Phone --}}
                            <div class="col-md-6 form-group">
                                <label>Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Phone Number</label>
                                <input type="text" name="phone" class="form-control" placeholder="Phone">
                            </div>

                            {{-- Designation & DOB --}}
                            <div class="col-md-6 form-group">
                                <label>Designation</label>
                                <input type="text" name="designation" class="form-control" placeholder="e.g. Senior Trainer">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Date of Birth</label>
                                <input type="date" name="dob" class="form-control">
                            </div>

                            {{-- Blood Group & Facebook --}}
                            <div class="col-md-6 form-group">
                                <label>Blood Group</label>
                                <select name="blood" class="form-control text-dark">
                                    <option value="">Select Blood Group</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Facebook Link</label>
                                <input type="url" name="facebook_link" class="form-control" placeholder="https://facebook.com/username">
                            </div>

                            {{-- Profile Image --}}
                            <div class="col-md-12 form-group">
                                <label>Profile Image</label>
                                <input type="file" name="profile_image" class="form-control">
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-gradient-primary me-2">Create Account</button>
                            <a href="{{ route('team_leader.trainers.list') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection