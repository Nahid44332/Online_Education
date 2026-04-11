@extends('backend.master')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0" style="border-radius: 12px;">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-dark fw-bold">
                            <i class="mdi mdi-account-group me-2 text-primary"></i> Team Leaders List
                        </h4>
                        <button type="button" class="btn btn-primary btn-sm fw-bold shadow-sm" data-bs-toggle="modal"
                            data-bs-target="#addTeamLeaderModal">
                            <i class="mdi mdi-plus-circle me-1"></i> Add New Team Leader
                        </button>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover border-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>SL</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Designation</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($team_leaders as $tl)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                <img src="{{ asset('backend/images/team-leader/' . $tl->profile_image) }}"
                                                    style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;"
                                                    alt="profile"
                                                    onerror="this.src='{{ asset('backend/images/faces/face1.jpg') }}'">
                                            </td>
                                            <td><span class="fw-bold text-dark">{{ $tl->name }}</span></td>
                                            <td>{{ $tl->subadmin->email ?? 'N/A' }}</td>
                                            <td>{{ $tl->phone }}</td>
                                            <td><label class="badge badge-info">{{ $tl->designation }}</label></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="modal" data-bs-target="#editModal{{ $tl->id }}">
                                                    <i class="mdi mdi-pencil"></i>
                                                </button>
                                                <a href="{{ route('admin.team_leader.delete', $tl->id) }}"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Are you sure you want to delete this Team Leader?')">
                                                    <i class="mdi mdi-delete"></i>
                                                </a>
                                                <a href="{{ url('/admin/team-leader/assign-student/' . $tl->id) }}"
                                                    class="btn btn-sm btn-gradient-info">
                                                    Assign Student
                                                </a>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="editModal{{ $tl->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content" style="border-radius: 15px;">
                                                    <div class="modal-header bg-primary">
                                                        <h5 class="modal-title text-white"><i
                                                                class="mdi mdi-pencil me-2"></i> Edit Team Leader:
                                                            {{ $tl->name }}</h5>
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body p-4 text-start">
                                                        <form action="{{ route('admin.team_leader.update', $tl->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="fw-bold small">Full Name <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" name="name"
                                                                        class="form-control" value="{{ $tl->name }}"
                                                                        required>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="fw-bold small">Designation</label>
                                                                    <input type="text" name="designation"
                                                                        class="form-control"
                                                                        value="{{ $tl->designation }}">
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="fw-bold small">Phone</label>
                                                                    <input type="text" name="phone"
                                                                        class="form-control" value="{{ $tl->phone }}">
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="fw-bold small">Blood Group</label>
                                                                    <select name="blood" class="form-control">
                                                                        <option value="" disabled>Select</option>
                                                                        <option value="A+"
                                                                            {{ $tl->blood == 'A+' ? 'selected' : '' }}>A+
                                                                        </option>
                                                                        <option value="B+"
                                                                            {{ $tl->blood == 'B+' ? 'selected' : '' }}>B+
                                                                        </option>
                                                                        <option value="O+"
                                                                            {{ $tl->blood == 'O+' ? 'selected' : '' }}>O+
                                                                        </option>
                                                                        <option value="AB+"
                                                                            {{ $tl->blood == 'AB+' ? 'selected' : '' }}>AB+
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-12 mb-3">
                                                                    <label class="fw-bold small">Profile Image (আগে দিলে
                                                                        পরিবর্তন করার দরকার নেই)</label>
                                                                    <input type="file" name="profile_image"
                                                                        class="form-control mb-2">
                                                                    <img src="{{ asset('backend/images/team-leader/' . $tl->profile_image) }}"
                                                                        style="width: 60px; height: 60px; border-radius: 5px; object-fit: cover;"
                                                                        onerror="this.src='{{ asset('backend/images/faces/face1.jpg') }}'">
                                                                </div>
                                                                <div class="col-12 text-end">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary px-4 shadow-sm">Update Team
                                                                        Leader</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addTeamLeaderModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="exampleModalLabel text-white">
                        <i class="mdi mdi-account-plus me-2 text-white"></i> Create New Team Leader
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('admin.team_leader.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-3">
                                <h6 class="text-primary border-bottom pb-2">🔑 Login Credentials</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold small">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="tl@example.com"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold small">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Min 6 characters" required>
                            </div>

                            <div class="col-12 mt-2 mb-3">
                                <h6 class="text-primary border-bottom pb-2">👤 Personal Information</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold small">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Full Name"
                                    required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="fw-bold small">Designation</label>
                                <input type="text" name="designation" class="form-control" placeholder="Ex: Lead">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="fw-bold small">Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="017XXXXXXXX">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="fw-bold small">Date of Birth</label>
                                <input type="date" name="dob" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="fw-bold small">Blood Group</label>
                                <select name="blood" class="form-control">
                                    <option value="">Select</option>
                                    <option value="A+">A+</option>
                                    <option value="B+">B+</option>
                                    <option value="O+">O+</option>
                                    <option value="AB+">AB+</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="fw-bold small">Facebook Link</label>
                                <input type="url" name="facebook_link" class="form-control" placeholder="https://">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="fw-bold small">Profile Image</label>
                                <input type="file" name="profile_image" class="form-control">
                            </div>

                            <div class="col-12 mt-3 text-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary px-4 shadow-sm">Save Team Leader</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
