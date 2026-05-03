@extends('backend.master')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 text-primary fw-bold">Manager Management</h4>
                        <button class="btn btn-primary rounded-pill shadow-sm" data-bs-toggle="modal"
                            data-bs-target="#addManager">
                            <i class="ri-user-star-line me-1"></i> Add Manager
                        </button>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mt-4" style="border-radius: 20px;">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-hover align-middle text-center">
                            <thead class="table-light">
                                <tr class="text-uppercase small fw-bold">
                                    <th>SL</th>
                                    <th>Photo</th>
                                    <th class="text-start">Manager Info</th>
                                    <th>Designation</th>
                                    <th>Wallet Points</th>
                                    <th>Contact</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($managers as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <img src="{{ !empty($item->profile_image) ? asset($item->profile_image) : asset('backend/images/no_image.jpg') }}"
                                                class="rounded-circle avatar-sm img-thumbnail"
                                                style="width: 45px; height: 45px; object-fit: cover;">
                                        </td>
                                        <td class="text-start">
                                            <h6 class="mb-0 fw-bold">{{ $item->name }}</h6>
                                            <small class="text-muted">{{ $item->subadmin->email ?? 'No Email' }}</small><br>
                                        </td>
                                        <td><span
                                                class="badge bg-soft-info text-info px-3">{{ $item->designation ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge px-3 text-white"
                                                style="background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%); border-radius: 50px;">
                                                ৳ {{ number_format($item->points ?? 0, 2) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="small fw-medium">{{ $item->phone ?? 'N/A' }}</div>
                                            <div class="small text-danger">
                                                {{ $item->blood ? 'Blood: ' . $item->blood : '' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-success rounded-pill px-3 me-1"
                                                    onclick="addPoints({{ $item->id }}, '{{ $item->name }}')">
                                                    <i class="ri-money-dollar-circle-line"></i> Points
                                                </button>
                                                <button class="btn btn-sm btn-outline-primary rounded-pill me-1"
                                                    onclick="editManager({{ $item->id }})">
                                                    <i class="mdi mdi-pencil"></i>
                                                </button>
                                                <a href="{{ route('admin.manager.delete', $item->id) }}"
                                                    class="btn btn-sm btn-outline-danger rounded-pill" id="delete">
                                                    <i class="mdi mdi-delete"></i>
                                                </a>
                                            </div>
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

    {{-- Add Manager Modal --}}
    <div class="modal fade" id="addManager" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-header bg-primary text-white p-4" style="border-radius: 20px 20px 0 0;">
                    <h5 class="modal-title fw-bold text-white"><i class="ri-user-add-line me-2"></i>Register New Manager
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('admin.manager.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4 bg-light-subtle">
                        <div class="row g-3">
                            <div class="col-12 mt-0">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-soft-primary text-primary rounded-pill px-3">Login Details</span>
                                    <hr class="flex-grow-1 ms-2 border-primary-subtle">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-0 shadow-sm"><i
                                            class="ri-user-line text-primary"></i></span>
                                    <input type="text" name="name" class="form-control border-0 shadow-sm"
                                        placeholder="Ex: Nahid Hossen" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email (Used for Login)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-0 shadow-sm"><i
                                            class="ri-mail-send-line text-primary"></i></span>
                                    <input type="email" name="email" class="form-control border-0 shadow-sm"
                                        placeholder="manager@gmail.com" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-0 shadow-sm"><i
                                            class="ri-lock-password-line text-primary"></i></span>
                                    <input type="password" name="password" class="form-control border-0 shadow-sm"
                                        placeholder="Min 8 characters" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Position</label>
                                <select name="position" class="form-select border-0 shadow-sm" required>
                                    <option value="manager">Manager</option>
                                    <option value="team_leader">Team Leader</option>
                                </select>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-soft-info text-info rounded-pill px-3">Personal Information</span>
                                    <hr class="flex-grow-1 ms-2 border-info-subtle">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Designation</label>
                                <input type="text" name="designation" class="form-control border-0 shadow-sm"
                                    placeholder="Web Manager">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Phone</label>
                                <input type="text" name="phone" class="form-control border-0 shadow-sm"
                                    placeholder="017xxxxxxxx">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Blood Group</label>
                                <select name="blood" class="form-select border-0 shadow-sm">
                                    <option value="">Select Group</option>
                                    <option value="A+">A+</option>
                                    <option value="B+">B+</option>
                                    <option value="O+">O+</option>
                                    <option value="AB+">AB+</option>
                                    <option value="A-">A-</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Date Of Birth</label>
                                <input type="date" name="dob" class="form-control border-0 shadow-sm"
                                    placeholder="Date of birth">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Facebook Profile Link</label>
                                <input type="url" name="facebook_link" class="form-control border-0 shadow-sm"
                                    placeholder="https://facebook.com/profile">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Profile Photo</label>
                                <input type="file" name="profile_image" class="form-control border-0 shadow-sm">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4"
                            data-bs-toggle="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-lg fw-bold">Create Manager
                            Access</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="editManagerModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="modal-title fw-bold text-info">Update Manager Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.manager.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="edit_id">
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3"><label class="fw-semibold">Full Name</label><input type="text"
                                    name="name" id="edit_name" class="form-control bg-light border-0"></div>
                            <div class="col-md-6 mb-3"><label class="fw-semibold">Email</label><input type="email"
                                    name="email" id="edit_email" class="form-control bg-light border-0"></div>
                            <div class="col-md-6 mb-3"><label class="fw-semibold">Designation</label><input
                                    type="text" name="designation" id="edit_designation"
                                    class="form-control bg-light border-0"></div>
                            <div class="col-md-6 mb-3"><label class="fw-semibold">Photo</label><input type="file"
                                    name="image" class="form-control bg-light border-0"></div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="submit" class="btn btn-info rounded-pill px-5 text-white shadow">Update
                            Info</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Add Points Modal --}}
    <div class="modal fade" id="addPointsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-header bg-success text-white p-4" style="border-radius: 20px 20px 0 0;">
                    <h5 class="modal-title fw-bold text-white">Add Points to <span id="manager_name_display"></span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.manager.add-points') }}" method="POST">
                    @csrf
                    <input type="hidden" name="subadmin_id" id="point_manager_id">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="fw-bold mb-2">Enter Amount (৳)</label>
                           <div class="input-group">
    <span class="input-group-text bg-light border-0">৳</span>
    <input type="number" name="amount" class="form-control bg-light border-0 shadow-none" placeholder="পয়েন্ট যোগ করতে 500, কাটতে -500 লিখুন" required>
</div>
                            <small class="text-muted">এই অ্যামাউন্টটি ম্যানেজারের বর্তমান ওয়ালেটে যোগ হবে।</small>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="submit" class="btn btn-success rounded-pill px-5 shadow-lg fw-bold w-100">Confirm &
                            Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function editManager(id) {
            $.get("/admin/manager/edit/" + id, function(data) {
                $('#edit_id').val(data.id);
                $('#edit_name').val(data.name);
                $('#edit_email').val(data.email); // এখন ইমেইল আসবেই!
                $('#edit_designation').val(data.designation);
                $('#edit_phone').val(data.phone);
                $('#edit_dob').val(data.dob);
                $('#edit_blood').val(data.blood);
                $('#editManagerModal').modal('show');
            });
        }

        function addPoints(id, name) {
            $('#point_manager_id').val(id);
            $('#manager_name_display').text(name);
            $('#addPointsModal').modal('show');
        }
    </script>
@endpush
