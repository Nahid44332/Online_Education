@extends('backend.manager-panel.master')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> All Helpline List </h3>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-gradient-primary text-white">
                        <i class="mdi mdi-magnify"></i>
                    </span>
                    <input type="text" id="helplineSearch" class="form-control" placeholder="Search Helpline...">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Helpline Management</h4>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle" id="helplineTable">
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
                                    @foreach ($helplines as $helpline)
                                        <tr>
                                            <td> #HL-{{ $helpline->id }} </td>
                                            <td class="py-1">
                                                <img src="{{ asset($helpline->image) }}"
                                                    style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;" />
                                            </td>
                                            <td>
                                                <span class="font-weight-bold">{{ $helpline->name }}</span><br>
                                                <small class="text-muted">{{ $helpline->phone }}</small><br>
                                                <small class="text-muted">{{ $helpline->subadmin->email ?? 'N/A' }}</small>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span
                                                        class="badge badge-gradient-info me-2">{{ $helpline->points }}</span>
                                                    <button type="button" class="btn btn-inverse-primary btn-icon btn-sm"
                                                        onclick="giveHelplinePoint({{ $helpline->id }}, '{{ $helpline->name }}', {{ $helpline->points }})">
                                                        <i class="mdi mdi-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-success"><i class="mdi mdi-record"></i> Active</span>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-info"
                                                    onclick="viewHelpline({{ $helpline->id }})">
                                                    <i class="mdi mdi-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-warning"
                                                    onclick="openHelplineResetModal({{ $helpline->id }}, '{{ $helpline->name }}')">
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

    <div class="modal fade" id="viewHelplineModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Helpline Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="helpline_details_content"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="helplinePointModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title">Give Points to <span id="helplineNameText" class="text-primary"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('manager.helpline.updatePoints') }}" method="POST">
                    @csrf
                    <input type="hidden" name="helpline_id" id="modal_helpline_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Current Points: <b id="currentHelplinePoints"></b></label>
                            <input type="number" name="points" class="form-control" placeholder="পয়েন্ট লিখুন" required>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="submit" class="btn btn-gradient-primary">Update Points</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="helplineResetPasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title">রিসেট পাসওয়ার্ড: <span id="resetHelplineName" class="text-primary"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('manager.helpline.resetPassword') }}" method="POST">
                    @csrf
                    <input type="hidden" name="helpline_id" id="reset_helpline_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="text" name="new_password" class="form-control"
                                placeholder="নতুন পাসওয়ার্ড দিন" required>
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
        // ১. সার্চ
        $(document).ready(function() {
            $("#helplineSearch").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#helplineTable tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        // ২. প্রোফাইল ভিউ (Ajax)
        function viewHelpline(id) {
            $('#helpline_details_content').html(
                '<div class="text-center"><div class="spinner-border text-primary" role="status"></div></div>');
            var myModal = new bootstrap.Modal(document.getElementById('viewHelplineModal'));
            myModal.show();

            $.ajax({
                // url-এর জায়গায় এভাবে লিখুন
                url: "{{ url('panel/manager/helpline/view') }}/" + id,
                type: "GET",
                dataType: "html",
                success: function(data) {
                    $('#helpline_details_content').html(data);
                },
                error: function() {
                    $('#helpline_details_content').html(
                        '<p class="text-danger text-center">ডাটা লোড হতে সমস্যা হয়েছে!</p>');
                }
            });
        }

        // ৩. পয়েন্ট আপডেট
        function giveHelplinePoint(id, name, points) {
            document.getElementById('modal_helpline_id').value = id;
            document.getElementById('helplineNameText').innerText = name;
            document.getElementById('currentHelplinePoints').innerText = points;
            var myModal = new bootstrap.Modal(document.getElementById('helplinePointModal'));
            myModal.show();
        }

        // ৪. পাসওয়ার্ড রিসেট
        function openHelplineResetModal(id, name) {
            document.getElementById('reset_helpline_id').value = id;
            document.getElementById('resetHelplineName').innerText = name;
            var myModal = new bootstrap.Modal(document.getElementById('helplineResetPasswordModal'));
            myModal.show();
        }
    </script>
@endpush
