@extends('backend.master')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">🔐 Add New Teacher / Subadmin</h4>
        </div>
        <div class="card-body">
            <form action="{{ url('/admin/teacher/store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-12">
                        <h5 class="text-primary border-bottom pb-2 mb-3">Account Information</h5>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="fw-bold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="teacher@example.com" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="fw-bold">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Minimum 6 characters" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="fw-bold">Role / Position <span class="text-danger">*</span></label>
                            <select name="position" class="form-control text-capitalize" required>
                                <option value="teacher" selected>Teacher</option>
                                <option value="trainer">Trainer</option>
                                <option value="team_leader">Team Leader</option>
                                <option value="manager">Manager</option>
                                <option value="counsellor">Counsellor</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <h5 class="text-primary border-bottom pb-2 mb-3">Personal & Professional Details</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="fw-bold">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter teacher name" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label class="fw-bold">Designation</label>
                            <input type="text" name="designation" class="form-control" placeholder="Ex: Senior Web Developer">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label class="fw-bold">Phone Number</label>
                            <input type="text" name="phone" class="form-control" placeholder="017xxxxxxxx">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="fw-bold">Profile Image</label>
                            <input type="file" name="profile_image" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="fw-bold">Specialist / Subject</label>
                            <input type="text" name="specialist" class="form-control" placeholder="Ex: Laravel, Python, etc.">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="fw-bold">About</label>
                            <textarea name="about" class="form-control" rows="3" placeholder="Brief biography..."></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="fw-bold">Achievements</label>
                            <textarea name="achievements" class="form-control" rows="3" placeholder="List of awards or success..."></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="fw-bold">Objective</label>
                            <textarea name="objective" class="form-control" rows="3" placeholder="objective..."></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="fw-bold">Short Description</label>
                            <textarea name="short_description" class="form-control" rows="3" placeholder="Short Description"></textarea>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <h5 class="text-primary border-bottom pb-2 mb-3">Social Media Links</h5>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><i class="fab fa-facebook text-primary"></i> Facebook</label>
                            <input type="url" name="facebook_link" class="form-control" placeholder="URL">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><i class="fab fa-twitter text-info"></i> Twitter</label>
                            <input type="url" name="twitter_link" class="form-control" placeholder="URL">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><i class="fab fa-linkedin text-primary"></i> LinkedIn</label>
                            <input type="url" name="linkedin_link" class="form-control" placeholder="URL">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><i class="fab fa-google text-danger"></i> Google+</label>
                            <input type="url" name="google_link" class="form-control" placeholder="URL">
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm">
                            🚀 Save Teacher Account
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection