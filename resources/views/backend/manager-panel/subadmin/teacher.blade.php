@extends('backend.manager-panel.master')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> All Teachers List </h3>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-gradient-primary text-white">
                        <i class="mdi mdi-magnify"></i>
                    </span>
                    <input type="text" id="teacherSearch" class="form-control"
                        placeholder="Search Teacher...">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Teacher Management</h4>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle" id="teacherTable">
                                <thead class="bg-light">
                                    <tr>
                                        <th> ID </th>
                                        <th> Photo </th>
                                        <th> Name </th>
                                        <th> Points </th>
                                        <th> Status </th>
                                        <th> Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($teachers as $teacher)
                                        <tr>
                                            <td> #TR-{{ $teacher->id }} </td>
                                            <td class="py-1">
                                                <img src="{{ asset('backend/images/teachers/' . $teacher->profile_image) }}"
                                                    style="width: 40px; height: 40px; border-radius: 8px;" />
                                            </td>
                                            <td>
                                                <span class="font-weight-bold">{{ $teacher->name }}</span><br>
                                                <small class="text-muted">{{ $teacher->phone }}</small><br>
                                                <small class="text-muted">{{ $teacher->subadmin->email ?? 'N/A' }}</small>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="badge badge-gradient-info me-2">{{ $teacher->points }}</span>
                                                    <button type="button" class="btn btn-inverse-primary btn-icon btn-sm"
                                                        onclick="giveTeacherPoint({{ $teacher->id }}, '{{ $teacher->name }}', {{ $teacher->points }})">
                                                        <i class="mdi mdi-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-success"><i class="mdi mdi-record"></i> Active</span>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-info" onclick="viewTeacher({{ $teacher->id }})">
                                                    <i class="mdi mdi-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-warning" onclick="openTeacherResetModal({{ $teacher->id }}, '{{ $teacher->name }}')">
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

    <div class="modal fade" id="viewTeacherModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Teacher Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="teacher_details_content">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="teacherPointModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title">Give Points to <span id="teacherNameText" class="text-primary"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('manager.teacher.updatePoints') }}" method="POST">
                    @csrf
                    <input type="hidden" name="teacher_id" id="modal_teacher_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Current Points: <b id="currentTeacherPoints"></b></label>
                            <input type="number" name="points" class="form-control" placeholder="পয়েন্ট লিখুন (যেমন: ১০)" required>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="submit" class="btn btn-gradient-primary">Update Points</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="teacherResetPasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title">রিসেট পাসওয়ার্ড: <span id="resetTeacherName" class="text-primary"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('manager.teacher.resetPassword') }}" method="POST">
                    @csrf
                    <input type="hidden" name="teacher_id" id="reset_teacher_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="text" name="new_password" class="form-control" placeholder="নতুন পাসওয়ার্ড দিন" required>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="submit" class="btn btn-gradient-warning text-white w-100">Update Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script')
<script>
    // ১. রিয়েল-টাইম সার্চ
    $(document).ready(function() {
        $("#teacherSearch").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#teacherTable tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    // ২. প্রোফাইল ভিউ (Ajax)
    function viewTeacher(id) {
        $('#teacher_details_content').html('<div class="text-center"><div class="spinner-border text-primary" role="status"></div></div>');
        var myModal = new bootstrap.Modal(document.getElementById('viewTeacherModal'));
        myModal.show();

        $.ajax({
            url: "{{ url('panel/manager/teachers/view') }}/" + id, 
            type: "GET",
            dataType: "html",
            success: function(data) {
                $('#teacher_details_content').html(data);
            },
            error: function() {
                $('#teacher_details_content').html('<p class="text-danger text-center">ডাটা লোড হতে সমস্যা হয়েছে!</p>');
            }
        });
    }

    // ৩. পয়েন্ট আপডেট
    function giveTeacherPoint(id, name, points) {
        document.getElementById('modal_teacher_id').value = id;
        document.getElementById('teacherNameText').innerText = name;
        document.getElementById('currentTeacherPoints').innerText = points;
        var myModal = new bootstrap.Modal(document.getElementById('teacherPointModal'));
        myModal.show();
    }

    // ৪. পাসওয়ার্ড রিসেট
    function openTeacherResetModal(id, name) {
        document.getElementById('reset_teacher_id').value = id;
        document.getElementById('resetTeacherName').innerText = name;
        var myModal = new bootstrap.Modal(document.getElementById('teacherResetPasswordModal'));
        myModal.show();
    }
</script>
@endpush