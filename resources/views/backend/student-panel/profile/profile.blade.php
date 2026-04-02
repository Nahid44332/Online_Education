@extends('backend.student-panel.st-master')
@section('content')
    <div class="content-wrapper">

        <div class="row">

            <!-- Profile Card -->
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body text-center">

                        <img src="{{ asset('backend/images/students/' . $student->image) }}" class="rounded-circle mb-3"
                            width="140" height="140">

                        <h4 class="card-title">{{ $student->name }}</h4>
                        <p class="text-muted">{{ $student->email }}</p>

                        <hr>

                        <p><strong>Student ID:</strong> {{ $student->id }}</p>
                        <p><strong>Phone:</strong> {{ $student->phone }}</p>
                        <p><strong>Total Balance:</strong> {{ $student->points }}</p>

                        @if ($student->status == 1)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif

                        <br><br>

                        <a href="{{ route('student.profile.edit') }}" class="btn btn-gradient-primary">
                            Edit Profile
                        </a>

                    </div>
                </div>
            </div>


            <!-- Profile Details -->
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-4">Student Information</h4>

                        <table class="table table-bordered">

                            <tr>
                                <th width="35%">Full Name</th>
                                <td>{{ $student->name }}</td>
                            </tr>

                            <tr>
                                <th>Father Name</th>
                                <td>{{ $student->father_name }}</td>
                            </tr>

                            <tr>
                                <th>Mother Name</th>
                                <td>{{ $student->mother_name }}</td>
                            </tr>

                            <tr>
                                <th>Date of Birth</th>
                                <td>{{ $student->dob }}</td>
                            </tr>

                            <tr>
                                <th>Gender</th>
                                <td>{{ ucfirst($student->gender) }}</td>
                            </tr>

                            <tr>
                                <th>Blood Group</th>
                                <td>{{ $student->blood }}</td>
                            </tr>

                            <tr>
                                <th>Nationality</th>
                                <td>{{ $student->nationality }}</td>
                            </tr>

                            <tr>
                                <th>Religion</th>
                                <td>{{ $student->religion }}</td>
                            </tr>

                            <tr>
                                <th>Email</th>
                                <td>{{ $student->email }}</td>
                            </tr>

                            <tr>
                                <th>Phone</th>
                                <td>{{ $student->phone }}</td>
                            </tr>

                            <tr>
                                <th>Present Address</th>
                                <td>{{ $student->present_address }}</td>
                            </tr>

                            <tr>
                                <th>Permanent Address</th>
                                <td>{{ $student->permanent_address }}</td>
                            </tr>

                        </table>

                    </div>
                </div>
            </div>

            {{-- <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Referral Program</h4>

                        <p>Your Referral Code:</p>

                        <h5 class="text-primary">{{ $student->referral_code }}</h5>

                        <p>Share this link to earn money:</p>

                        <input type="text" class="form-control"
                            value="{{ url('/admission?ref=' . $student->referral_code) }}" readonly>
                        <button class="btn btn-primary" onclick="copyLink()">Copy</button>

                    </div>
                </div>
            </div> --}}

        </div>

    </div>
@endsection
{{-- @push('script')
    <script>
        function copyLink() {
            var copyText = document.getElementById("refLink");
            copyText.select();
            document.execCommand("copy");
            alert("Referral Link Copied!");
        }
    </script>
@endpush --}}
