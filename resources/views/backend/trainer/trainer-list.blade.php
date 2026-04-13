@extends('backend.master')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0" style="border-radius: 12px;">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-dark fw-bold">
                            <i class="mdi mdi-school me-2 text-primary"></i> Trainers List
                        </h4>
                        {{-- ট্রেইনার অ্যাড করার বাটন --}}
                        <button type="button" class="btn btn-primary btn-sm fw-bold shadow-sm" data-bs-toggle="modal"
                            data-bs-target="#addTrainerModal">
                            <i class="mdi mdi-plus-circle me-1"></i> Add New Trainer
                        </button>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                    @foreach ($trainers as $tr)
                                        <tr class="text-center">
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                <img src="{{ asset('backend/images/trainer/' . $tr->profile_image) }}"
                                                    style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover;"
                                                    alt="profile"
                                                    onerror="this.src='{{ asset('backend/images/faces/face1.jpg') }}'">
                                            </td>
                                            <td class="text-start">
                                                <span class="fw-bold text-dark">{{ $tr->name }}</span><br>
                                                <small class="text-muted">{{ $tr->subadmin->email ?? 'N/A' }}</small>
                                            </td>
                                            
                                            {{-- সেলারি/পয়েন্ট অ্যাড করার সেকশন (trainer_id সহ) --}}
                                            <td>
                                                <div class="mb-1">
                                                    <span class="badge bg-gradient-primary px-3 text-white" style="background: linear-gradient(90deg, #11998e 0%, #38ef7d 100%); border:none;">
                                                        ৳ {{ number_format($tr->points ?? 0, 2) }}
                                                    </span>
                                                </div>
                                                <form action="{{ route('admin.add.trainer.points') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="trainer_id" value="{{ $tr->id }}">
                                                    <div class="input-group input-group-sm mt-1">
                                                        <input type="number" name="amount" class="form-control" placeholder="Amount" required>
                                                        <button class="btn btn-success text-white" type="submit">
                                                            <i class="mdi mdi-plus"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>

                                            <td>{{ $tr->phone }}</td>
                                            <td><label class="badge badge-outline-info">{{ $tr->designation ?? 'Trainer' }}</label></td>
                                            <td>
                                                <div class="btn-group">
                                                    {{-- এডিট বাটন --}}
                                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                                        data-bs-toggle="modal" data-bs-target="#editModal{{ $tr->id }}">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </button>
                                                    {{-- ডিলিট বাটন --}}
                                                    <a href="#"
                                                        class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Are you sure?')">
                                                        <i class="mdi mdi-delete"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- Edit Trainer Modal (টিএল এর মতোই ডিজাইন) --}}
                                        <div class="modal fade" id="editModal{{ $tr->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content" style="border-radius: 15px;">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title"><i class="mdi mdi-pencil me-2"></i> Edit Trainer: {{ $tr->name }}</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body p-4 text-start">
                                                        <form action="#" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="fw-bold small">Full Name <span class="text-danger">*</span></label>
                                                                    <input type="text" name="name" class="form-control" value="{{ $tr->name }}" required>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="fw-bold small">Designation</label>
                                                                    <input type="text" name="designation" class="form-control" value="{{ $tr->designation }}">
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="fw-bold small">Phone</label>
                                                                    <input type="text" name="phone" class="form-control" value="{{ $tr->phone }}">
                                                                </div>
                                                                <div class="col-md-12 text-end mt-3">
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

    {{-- Add Trainer Modal --}}
    <div class="modal fade" id="addTrainerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title"><i class="mdi mdi-account-plus me-2 text-white"></i> Create New Trainer</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold small">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="trainer@example.com" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold small">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" placeholder="Min 6 characters" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold small">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Full Name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold small">Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="017XXXXXXXX">
                            </div>
                            <div class="col-md-12 mb-3 text-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary px-4 shadow-sm">Save Trainer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection