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
                            <table class="table table-hover border-0 align-middle">
                                <thead class="bg-light text-center">
                                    <tr>
                                        <th>SL</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th style="width: 180px;">Wallet Points</th>
                                        <th>Phone</th>
                                        <th>Designation</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($team_leaders as $tl)
                                        <tr class="text-center">
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                <img src="{{ asset('backend/images/team-leader/' . $tl->profile_image) }}"
                                                    style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover;"
                                                    alt="profile"
                                                    onerror="this.src='{{ asset('backend/images/faces/face1.jpg') }}'">
                                            </td>
                                            <td class="text-start">
                                                <span class="fw-bold text-dark">{{ $tl->name }}</span><br>
                                                <small class="text-muted">{{ $tl->subadmin->email ?? 'N/A' }}</small>
                                            </td>
                                            
                                            {{-- স্যালারি/পয়েন্ট অ্যাড করার সেকশন --}}
                                            <td>
                                                <div class="mb-1">
                                                    <span class="badge bg-gradient-primary px-3 text-white" style="background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);">
                                                        ৳ {{ number_format($tl->points ?? 0, 2) }}
                                                    </span>
                                                </div>
                                                <form action="{{ route('admin.add.tl.points') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="tl_id" value="{{ $tl->id }}">
                                                    <div class="input-group input-group-sm mt-1">
                                                        <input type="number" name="points" class="form-control" placeholder="Amount" required>
                                                        <button class="btn btn-success text-white" type="submit">
                                                            <i class="mdi mdi-plus"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>

                                            <td>{{ $tl->phone }}</td>
                                            <td><label class="badge badge-outline-info">{{ $tl->designation }}</label></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                                        data-bs-toggle="modal" data-bs-target="#editModal{{ $tl->id }}">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </button>
                                                    <a href="{{ route('admin.team_leader.delete', $tl->id) }}"
                                                        class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Are you sure?')">
                                                        <i class="mdi mdi-delete"></i>
                                                    </a>
                                                    <a href="{{ url('/admin/team-leader/assign-student/' . $tl->id) }}"
                                                        class="btn btn-sm btn-info text-white shadow-sm" style="font-size: 11px;">
                                                        Assign Student
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- Edit Team Leader Modal --}}
                                        <div class="modal fade" id="editModal{{ $tl->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content" style="border-radius: 15px;">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title"><i class="mdi mdi-pencil me-2"></i> Edit Team Leader: {{ $tl->name }}</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body p-4 text-start">
                                                        <form action="{{ route('admin.team_leader.update', $tl->id) }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="fw-bold small">Full Name <span class="text-danger">*</span></label>
                                                                    <input type="text" name="name" class="form-control" value="{{ $tl->name }}" required>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="fw-bold small">Designation</label>
                                                                    <input type="text" name="designation" class="form-control" value="{{ $tl->designation }}">
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="fw-bold small">Phone</label>
                                                                    <input type="text" name="phone" class="form-control" value="{{ $tl->phone }}">
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="fw-bold small">Blood Group</label>
                                                                    <select name="blood" class="form-control">
                                                                        <option value="A+" {{ $tl->blood == 'A+' ? 'selected' : '' }}>A+</option>
                                                                        <option value="B+" {{ $tl->blood == 'B+' ? 'selected' : '' }}>B+</option>
                                                                        <option value="O+" {{ $tl->blood == 'O+' ? 'selected' : '' }}>O+</option>
                                                                        <option value="AB+" {{ $tl->blood == 'AB+' ? 'selected' : '' }}>AB+</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-12 text-end mt-3">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-primary px-4">Update Changes</button>
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

    {{-- Add Team Leader Modal --}}
   <div class="modal fade" id="addTeamLeaderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><i class="mdi mdi-account-plus me-2 text-white"></i> Create New Team Leader</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('admin.team_leader.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold small">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Full Name" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold small">Designation</label>
                            <input type="text" name="designation" class="form-control" placeholder="Ex: Lead Executive">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold small">Phone Number</label>
                            <input type="text" name="phone" class="form-control" placeholder="017XXXXXXXX">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="fw-bold small">Date of Birth (DOB)</label>
                            <input type="date" name="dob" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="fw-bold small">Blood Group</label>
                            <select name="blood" class="form-control">
                                <option value="">Select Blood Group</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="fw-bold small">Initial Points</label>
                            <input type="number" name="points" class="form-control" value="0">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold small">Facebook Link</label>
                            <input type="url" name="facebook_link" class="form-control" placeholder="https://facebook.com/username">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold small">Profile Image</label>
                            <input type="file" name="profile_image" class="form-control" accept="image/*">
                        </div>

                        <div class="col-md-12 mt-3 text-end border-top pt-3">
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