@extends('backend.master')
@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Form: {{ $students->name }}</h4>
                <p class="card-description">Edit Information</p>

                <form class="forms-sample" action="{{ url('/admin/student/update/' . $students->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Name -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name"
                            value="{{ $students->name }}" placeholder="Name">
                    </div>

                    <!-- Father Name -->
                    <div class="form-group">
                        <label for="father_name">Father Name</label>
                        <input type="text" class="form-control" name="father_name" value="{{ $students->father_name }}"
                            id="father_name" placeholder="Father Name">
                    </div>

                    <!-- Mother Name -->
                    <div class="form-group">
                        <label for="mother_name">Mother Name</label>
                        <input type="text" class="form-control" name="mother_name" value="{{ $students->mother_name }}"
                            id="mother_name" placeholder="Mother Name">
                    </div>

                    <!-- DOB -->
                    <div class="form-group">
                        <label for="dob">Date Of Birth</label>
                        <input type="date" class="form-control" name="dob" value="{{ $students->dob }}"
                            id="dob" placeholder="Date of Birth">
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" name="email" value="{{ $students->email }}"
                            id="email" placeholder="Email">
                    </div>

                    <!-- Phone -->
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" class="form-control" name="phone" value="{{ $students->phone }}"
                            id="phone" placeholder="Phone">
                    </div>

                    <!-- Gender -->
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="form-select" name="gender" id="gender">
                            <option value="Male" @if ($students->gender == 'Male') selected @endif>Male</option>
                            <option value="Female" @if ($students->gender == 'Female') selected @endif>Female</option>
                        </select>
                    </div>

                    <!-- Blood -->
                    <div class="form-group">
                        <label for="blood">Blood</label>
                        <select class="form-select" name="blood" id="blood">
                            <option value="A+" @if ($students->blood == 'A+') selected @endif>A+</option>
                            <option value="A-" @if ($students->blood == 'A-') selected @endif>A-</option>
                            <option value="B+" @if ($students->blood == 'B+') selected @endif>B+</option>
                            <option value="B-" @if ($students->blood == 'B-') selected @endif>B-</option>
                            <option value="O+" @if ($students->blood == 'O+') selected @endif>O+</option>
                            <option value="O-" @if ($students->blood == 'O-') selected @endif>O-</option>
                        </select>
                    </div>

                    <!-- Nationality -->
                    <div class="form-group">
                        <label for="nationality">Nationality</label>
                        <input type="text" class="form-control" name="nationality" value="{{ $students->nationality }}"
                            placeholder="Nationality">
                    </div>

                    <!-- Religion -->
                    <div class="form-group">
                        <label for="religion">Religion</label>
                        <input type="text" class="form-control" name="religion" value="{{ $students->religion }}"
                            placeholder="Religion">
                    </div>

                    <!-- Educational Info -->
                    <h2>Educational Info</h2>
                    @foreach ($students->education as $educate)
                        <div class="form-group">
                            <label>SSC Passing Year</label>
                            <input type="text" class="form-control" name="ssc_passing_year[]"
                                value="{{ $educate->ssc_passing_year }}" placeholder="SSC Passing Year">
                        </div>
                        <div class="form-group">
                            <label>SSC Board</label>
                            <input type="text" class="form-control" name="ssc_board[]" value="{{ $educate->ssc_board }}"
                                placeholder="SSC Board">
                        </div>
                        <div class="form-group">
                            <label>SSC Result</label>
                            <input type="text" class="form-control" name="ssc_result[]"
                                value="{{ $educate->ssc_result }}" placeholder="SSC Result">
                        </div>
                        <div class="form-group">
                            <label>HSC Passing Year</label>
                            <input type="text" class="form-control" name="hsc_passing_year[]"
                                value="{{ $educate->hsc_passing_year }}" placeholder="HSC Passing Year">
                        </div>
                        <div class="form-group">
                            <label>HSC Board</label>
                            <input type="text" class="form-control" name="hsc_board[]"
                                value="{{ $educate->hsc_board }}" placeholder="HSC Board">
                        </div>
                        <div class="form-group">
                            <label>HSC Result</label>
                            <input type="text" class="form-control" name="hsc_result[]"
                                value="{{ $educate->hsc_result }}" placeholder="HSC Result">
                        </div>
                    @endforeach

                    <!-- Course -->
                    <div class="form-group mb-3">
                        <label for="course_id">Course</label>
                        <select class="form-select" name="course_id" id="course_id" required>
                            <option value="">--Select Course--</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}"
                                    {{ $students->course_id == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Address -->
                    <div class="form-group">
                        <label for="present_address">Present Address</label>
                        <textarea class="form-control" name="present_address" id="present_address" rows="4">{{ $students->present_address }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="permanent_address">Permanent Address</label>
                        <textarea class="form-control" name="permanent_address" id="permanent_address" rows="4">{{ $students->permanent_address }}</textarea>
                    </div>

                    <!-- Image Upload -->
                    <div class="form-group">
                        <label>File upload</label>
                        <input type="file" name="image" class="form-control">
                        @if ($students->image)
                            <div class="mt-2">
                                <img src="{{ asset('backend/images/students/' . $students->image) }}" alt="Student Image"
                                    height="100" width="100">
                            </div>
                        @endif
                    </div>

                    <!-- Buttons -->
                    <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                    <a href="{{ url('/admin/student/list') }}" class="btn btn-light">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
