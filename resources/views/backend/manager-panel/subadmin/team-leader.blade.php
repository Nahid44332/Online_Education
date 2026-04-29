@extends('backend.manager-panel.master')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> All Team Leaders List </h3>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-gradient-primary text-white">
                        <i class="mdi mdi-magnify"></i>
                    </span>
                    <input type="text" id="leaderSearch" class="form-control"
                        placeholder="Search Leader by Name, Phone or ID...">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Team Leader Management</h4>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle" id="leaderTable">
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
                                    @foreach ($teamLeaders as $leader)
                                        <tr>
                                            <td> #TL-{{ $leader->id }} </td>
                                            <td class="py-1">
                                                <img src="{{ asset('backend/images/team-leader/' . $leader->profile_image) }}"
                                                    alt="image" style="width: 40px; height: 40px; border-radius: 8px;" />
                                            </td>
                                            <td>
                                                <span class="font-weight-bold">{{ $leader->name }}</span><br>
                                                <small class="text-muted">{{ $leader->phone }}</small><br>
                                                <small class="text-muted">{{ $leader->subadmin->email ?? 'N/A' }}</small>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span
                                                        class="badge badge-gradient-info me-2">{{ $leader->points }}</span>
                                                    <button type="button" class="btn btn-inverse-primary btn-icon btn-sm"
                                                        onclick="giveLeaderPoint({{ $leader->id }}, '{{ $leader->name }}', {{ $leader->points }})">
                                                        <i class="mdi mdi-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-success"><i class="mdi mdi-record"></i> Active</span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-info"
                                                    title="View Profile" onclick="viewLeader({{ $leader->id }})">
                                                    <i class="mdi mdi-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-warning"
                                                    onclick="openLeaderResetModal({{ $leader->id }}, '{{ $leader->name }}')">
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

    <div class="modal fade" id="viewLeaderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Team Leader Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="leader_details">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="leaderPointModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Give Points to <span id="leaderNameText"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('manager.leader.updatePoints') }}" method="POST">
                    @csrf
                    <input type="hidden" name="leader_id" id="modal_leader_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Current Points: <b id="currentLeaderPoints"></b></label>
                            <input type="number" name="points" class="form-control" placeholder="e.g. 100 or -50"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-gradient-primary">Update Points</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="resetLeaderPasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title">টিম লিডারের পাসওয়ার্ড রিসেট: <span id="resetLeaderName"
                            class="text-primary"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('manager.leader.resetPassword') }}" method="POST">
                    @csrf
                    <input type="hidden" name="leader_id" id="reset_leader_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="text" name="new_password" class="form-control" placeholder="যেমন: abc@123"
                                required>
                            <small class="text-muted">পাসওয়ার্ডটি পরিবর্তন করার পর অবশ্যই টিম লিডারকে জানিয়ে দেবেন।</small>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="submit" class="btn btn-gradient-warning text-white w-100">Update Leader
                            Password</button>
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
            $("#leaderSearch").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#leaderTable tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        // View Details Ajax
        function viewLeader(id) {
            $('#leader_details').html(
                '<div class="text-center"><div class="spinner-border text-primary" role="status"></div></div>');
            var myModal = new bootstrap.Modal(document.getElementById('viewLeaderModal'));
            myModal.show();

            $.ajax({
                url: "{{ url('panel/manager/leader/view') }}/" + id,
                type: "GET",
                dataType: "html",
                success: function(data) {
                    $('#leader_details').html(data);
                },
                error: function() {
                    $('#leader_details').html('<p class="text-danger text-center">কিছু একটা ভুল হয়েছে!</p>');
                }
            });
        }

        // Point Modal Trigger
        function giveLeaderPoint(id, name, points) {
            document.getElementById('modal_leader_id').value = id;
            document.getElementById('leaderNameText').innerText = name;
            document.getElementById('currentLeaderPoints').innerText = points;
            var myModal = new bootstrap.Modal(document.getElementById('leaderPointModal'));
            myModal.show();
        }

        function openLeaderResetModal(id, name) {
            document.getElementById('reset_leader_id').value = id;
            document.getElementById('resetLeaderName').innerText = name;
            var myModal = new bootstrap.Modal(document.getElementById('resetLeaderPasswordModal'));
            myModal.show();
        }
    </script>
@endpush
