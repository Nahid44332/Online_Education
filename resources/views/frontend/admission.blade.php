@extends('frontend.master')
@section('content')
    <div class="container mt-4">
        <h3 class="text-center mb-4">🎓 Student Admission Form</h3>

        <div class="card shadow-lg p-4 rounded-3">
            <form action="{{ url('/admission/store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <!-- Full Name -->
                    <div class="form-group col-md-6 mb-3">
                        <label>Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
                    </div>

                    <!-- Father Name -->
                    <div class="form-group col-md-6 mb-3">
                        <label>Father's Name <span class="text-danger">*</span></label>
                        <input type="text" name="father_name" class="form-control" placeholder="Enter father's name"
                            required>
                    </div>

                    <!-- Mother Name -->
                    <div class="form-group col-md-6 mb-3">
                        <label>Mother's Name <span class="text-danger">*</span></label>
                        <input type="text" name="mother_name" class="form-control" placeholder="Enter mother's name"
                            required>
                    </div>

                    <!-- Date of Birth -->
                    <div class="form-group col-md-6 mb-3">
                        <label>Date of Birth <span class="text-danger">*</span></label>
                        <input type="date" name="dob" class="form-control" required>
                    </div>

                    <!-- Gender -->
                    <div class="form-group col-md-6 mb-3">
                        <label>Gender <span class="text-danger">*</span></label>
                        <select name="gender" class="form-control" required>
                            <option selected disabled>Choose...</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <!-- Email -->
                    <div class="form-group col-md-6 mb-3">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email">
                    </div>


                    <!-- Phone -->
                    <div class="form-group col-md-6 mb-3">
                        <label>Phone Number <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control" placeholder="Enter phone number" required>
                    </div>
                    {{-- Blood --}}
                    <div class="form-group col-md-6 mb-3">
                        <label>Blood Group</label>
                        <select name="blood" class="form-control">
                            <option selected disabled>Choose...</option>
                            <option>A+</option>
                            <option>A-</option>
                            <option>B+</option>
                            <option>B-</option>
                            <option>O+</option>
                            <option>O-</option>
                        </select>
                    </div>
                    <!-- Address -->
                    <div class="form-group col-md-12 mb-3">
                        <label>Present Address <span class="text-danger">*</span></label>
                        <textarea name="address" rows="2" class="form-control" placeholder="Enter present address" required></textarea>
                    </div>

                    <!-- Permanent Address -->
                    <div class="form-group col-md-12 mb-3">
                        <label>Permanent Address</label>
                        <textarea name="permanent_address" rows="2" class="form-control" placeholder="Enter permanent address"></textarea>
                    </div>

                    <!-- Nationality -->
                    <div class="form-group col-md-6 mb-3">
                        <label>Nationality <span class="text-danger">*</span></label>
                        <input type="text" name="nationality" class="form-control" value="Bangladeshi" required>
                    </div>

                    <!-- Religion -->
                    <div class="form-group col-md-6 mb-3">
                        <label>Religion <span class="text-danger">*</span></label>
                        <select name="religion" class="form-control" required>
                            <option selected disabled>Choose...</option>
                            <option>Islam</option>
                            <option>Hindu</option>
                            <option>Christian</option>
                            <option>Buddhist</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <!-- Class Applied For -->
                    <div class="form-group col-md-6 mb-3">
                        <label>Applying For Course</label>
                        <select name="course_id" class="form-control">
                            <option selected disabled>Select Course</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Photo -->
                    <div class="form-group col-md-6 mb-3">
                        <label>Upload Photo <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control" required>
                    </div>

                     <!-- Password -->
                    <div class="form-group col-md-6 mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter Password">
                    </div>
                    <!-- Submit -->
                    <div class="form-group col-md-12 text-center">
                        <button type="submit" class="btn btn-primary px-5 mt-3">Submit Application</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
