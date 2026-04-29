@extends('backend.manager-panel.master')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                All Trainers List
            </h3>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-gradient-primary text-white">
                        <i class="mdi mdi-magnify"></i>
                    </span>
                    <input type="text" id="trainerSearch" class="form-control"
                        placeholder="Search Trainer by Name, Phone or ID...">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Trainer Management</h4>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle" id="trainerTable">
                                <thead class="bg-light">
                                    <tr>
                                        <th> ID </th>
                                        <th> Photo </th>
                                        <th> Name </th>
                                        <th>Points</th>
                                        <th> Status </th>
                                        <th> Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($trainers as $trainer)
                                        <tr>
                                            <td> #TR-{{ $trainer->id }} </td>
                                            <td class="py-1">
                                                <img src="{{ asset('backend/images/trainer/' . $trainer->profile_image) }}"
                                                    alt="image" style="width: 40px; height: 40px; border-radius: 8px;" />
                                            </td>
                                            <td>
                                                <span class="font-weight-bold">{{ $trainer->name }}</span><br>
                                                <small class="text-muted">{{ $trainer->phone }}</small><br>
                                                <small class="text-muted">{{ $trainer->subadmin->email }}</small>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span
                                                        class="badge badge-gradient-info me-2">{{ $trainer->points }}</span>
                                                    <button type="button" class="btn btn-inverse-primary btn-icon btn-sm"
                                                        onclick="giveTrainerPoint({{ $trainer->id }}, '{{ $trainer->name }}', {{ $trainer->points }})">
                                                        <i class="mdi mdi-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-success"><i class="mdi mdi-record"></i> Active</span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-info"
                                                    title="View Profile" onclick="viewTrainer({{ $trainer->id }})">
                                                    <i class="mdi mdi-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-warning"
                                                    title="Reset Password"
                                                    onclick="openResetModal({{ $trainer->id }}, '{{ $trainer->name }}')">
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

    <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Trainer Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="trainer_details">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="trainerPointModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Give Points to <span id="trainerNameText"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('manager.trainer.updatePoints') }}" method="POST">
                    @csrf
                    <input type="hidden" name="trainer_id" id="modal_trainer_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Current Points: <b id="currentTrainerPoints"></b></label>
                            <input type="number" name="points" class="form-control" placeholder="e.g. 50 or -20" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-gradient-primary">Update Points</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title">Reset Password for <span id="resetTrainerName" class="text-primary"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('manager.trainer.resetPassword') }}" method="POST">
                    @csrf
                    <input type="hidden" name="trainer_id" id="reset_trainer_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>New Password</label>
                            <div class="input-group">
                                <input type="text" name="new_password" class="form-control"
                                    placeholder="মিনিমাম ৬ ডিজিট লিখুন" required>
                            </div>
                            <small class="text-muted">এই পাসওয়ার্ডটি ট্রেইনারকে জানিয়ে দিন।</small>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-gradient-warning text-white">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Real-time Search Filter
        $(document).ready(function() {
            $("#trainerSearch").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#trainerTable tbody tr").filter(function() {
                    // টেবিলের প্রতিটি রো চেক করবে আপনার টাইপ করা টেক্সট আছে কি না
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        // আপনার আগের viewTrainer ফাংশন
        function viewTrainer(id) {
            $('#trainer_details').html(
                '<div class="text-center"><div class="spinner-border text-primary" role="status"></div></div>');
            var myModal = new bootstrap.Modal(document.getElementById('viewModal'));
            myModal.show();

            $.ajax({
                url: "{{ url('panel/manager/trainer/view') }}/" + id,
                type: "GET",
                dataType: "html",
                success: function(data) {
                    $('#trainer_details').html(data);
                },
                error: function() {
                    $('#trainer_details').html('<p class="text-danger text-center">কিছু একটা ভুল হয়েছে!</p>');
                }
            });
        }

        function giveTrainerPoint(id, name, points) {
            document.getElementById('modal_trainer_id').value = id;
            document.getElementById('trainerNameText').innerText = name;
            document.getElementById('currentTrainerPoints').innerText = points;
            var myModal = new bootstrap.Modal(document.getElementById('trainerPointModal'));
            myModal.show();
        }

        function openResetModal(id, name) {
            document.getElementById('reset_trainer_id').value = id;
            document.getElementById('resetTrainerName').innerText = name;
            var myModal = new bootstrap.Modal(document.getElementById('resetPasswordModal'));
            myModal.show();
        }
    </script>
@endpush
