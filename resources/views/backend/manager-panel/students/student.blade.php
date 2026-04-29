@extends('backend.manager-panel.master')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Students List </h3>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <form action="{{ route('manager.student', $status) }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by Name, Phone or ID..."
                            value="{{ request('search') }}" required>
                        <button class="btn btn-gradient-primary" type="submit">
                            <i class="mdi mdi-magnify"></i> Search
                        </button>
                        @if (request('search'))
                            <a href="{{ route('manager.student', $status) }}" class="btn btn-light">Clear</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">All Enrolled Students</h4>
                        <p class="card-description"> Manage your students and their status </p>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th> ID </th>
                                        <th> Photo </th>
                                        <th> Name </th>
                                        <th> Course </th>
                                        <th>Points</th>
                                        <th> Status </th>
                                        <th> Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr>
                                            <td> #ST-{{ $student->id }} </td>
                                            <td class="py-1">
                                                <img src="{{ asset('backend/images/students/' . $student->image) }}"
                                                    alt="image" style="width: 40px; height: 40px; border-radius: 8px;" />
                                            </td>
                                            <td>
                                                <span class="font-weight-bold">{{ $student->name }}</span><br>
                                                <small class="text-muted">{{ $student->phone }}</small>
                                            </td>
                                            <td> {{ $student->course->title ?? 'N/A' }} </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span
                                                        class="badge badge-gradient-info me-2">{{ $student->points }}</span>
                                                    <button type="button" class="btn btn-inverse-primary btn-icon btn-sm"
                                                        onclick="givePoint({{ $student->id }}, '{{ $student->name }}', {{ $student->points }})">
                                                        <i class="mdi mdi-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($student->status == '1')
                                                    <span class="text-success"><i class="mdi mdi-record"></i> Active</span>
                                                @else
                                                    <span class="text-danger"><i class="mdi mdi-record"></i> Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-info"
                                                    title="View Profile" onclick="viewStudent({{ $student->id }})">
                                                    <i class="mdi mdi-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-warning"
                                                    onclick="openStudentResetModal({{ $student->id }}, '{{ $student->name }}')">
                                                    <i class="mdi mdi-lock-reset"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="pointModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Give Points to <span id="studentName"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('students.updatePoints') }}" method="POST">
                    @csrf
                    <input type="hidden" name="student_id" id="modal_student_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Current Points: <b id="currentPoints"></b></label>
                            <input type="number" name="points" class="form-control"
                                placeholder="Enter points (e.g. 10 or -5)" required>
                            <small class="text-muted">পয়েন্ট যোগ করতে পজিটিভ (১০) আর কমাতে নেগেটিভ (-৫) নাম্বার দিন।</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-gradient-primary">Update Points</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Student Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="student_details">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="studentResetModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title">রিসেট পাসওয়ার্ড: <span id="resetStudentName" class="text-primary"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('manager.student.resetPassword') }}" method="POST">
                    @csrf
                    <input type="hidden" name="student_id" id="reset_student_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="text" name="new_password" class="form-control"
                                placeholder="নতুন পাসওয়ার্ড দিন (যেমন: student123)" required>
                                <small>পাসওয়ার্ড পরিবর্তন করে স্টুডেন্টকে জানিয়ে দিন</small>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="submit" class="btn btn-gradient-warning text-white w-100">Update Password
                            Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        // পয়েন্ট দেওয়ার ফাংশন
        function givePoint(id, name, points) {
            document.getElementById('modal_student_id').value = id;
            document.getElementById('studentName').innerText = name;
            document.getElementById('currentPoints').innerText = points;
            var myModal = new bootstrap.Modal(document.getElementById('pointModal'));
            myModal.show();
        }

        // স্টুডেন্ট ভিউ করার ফাংশন
        function viewStudent(id) {
            // স্পিনার দেখানো
            $('#student_details').html(
                '<div class="text-center"><div class="spinner-border text-primary" role="status"></div></div>');

            var myModal = new bootstrap.Modal(document.getElementById('viewModal'));
            myModal.show();

            // Ajax কল
            $.ajax({
                // এখানে Route এর নাম ব্যবহার করলে URL ভুল হওয়ার সুযোগ নেই
                // আপনার Route ফাইলে এই নামের রাউট থাকতে হবে: ->name('manager.students.view')
                url: "{{ url('panel/manager/students/view') }}/" + id,
                type: "GET",
                dataType: "html",
                success: function(data) {
                    $('#student_details').html(data);
                },
                error: function(xhr) {
                    console.log(xhr.responseText); // এরর কি আসে সেটা কনসোলে দেখতে পারবেন
                    $('#student_details').html(
                        '<p class="text-danger text-center">কিছু একটা ভুল হয়েছে! আবার চেষ্টা করুন।</p>');
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $("#mySearchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        function openStudentResetModal(id, name) {
            document.getElementById('reset_student_id').value = id;
            document.getElementById('resetStudentName').innerText = name;
            var myModal = new bootstrap.Modal(document.getElementById('studentResetModal'));
            myModal.show();
        }
    </script>
@endpush
