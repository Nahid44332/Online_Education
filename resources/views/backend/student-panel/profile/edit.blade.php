@extends('backend.student-panel.st-master')
@section('content')
    <div class="content-wrapper">

        <div class="row">

            <!-- Profile Edit -->
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-4">Edit Profile</h4>

                        <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" name="name" value="{{ $student->name }}"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" value="{{ $student->email }}"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" name="phone" value="{{ $student->phone }}"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date of Birth</label>
                                        <input type="date" name="dob" value="{{ $student->dob }}"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select name="gender" class="form-control">
                                            <option value="male" {{ $student->gender == 'male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="female" {{ $student->gender == 'female' ? 'selected' : '' }}>
                                                Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Blood Group</label>
                                        <input type="text" name="blood" value="{{ $student->blood }}"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Father Name</label>
                                        <input type="text" name="father_name" value="{{ $student->father_name }}"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Mother Name</label>
                                        <input type="text" name="mother_name" value="{{ $student->mother_name }}"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Present Address</label>
                                        <textarea name="present_address" class="form-control">{{ $student->present_address }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Permanent Address</label>
                                        <textarea name="permanent_address" class="form-control">{{ $student->permanent_address }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Upload Image</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6 text-center">
                                    <label>Current Image</label><br>
                                    <img src="{{ asset('backend/images/students/' . $student->image) }}" width="90"
                                        class="rounded-circle">
                                </div>

                            </div>

                            <br>

                            <button class="btn btn-gradient-primary">Update Profile</button>

                        </form>

                    </div>
                </div>
            </div>


            <!-- Password Change -->
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-4">Change Password</h4>

                        <form action="{{ route('student.password.update') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label>Current Password</label>
                                <input type="password" name="current_password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" name="new_password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control">
                            </div>

                            <button class="btn btn-gradient-danger btn-block">
                                Update Password
                            </button>

                        </form>

                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
