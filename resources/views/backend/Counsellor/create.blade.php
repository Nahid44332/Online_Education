@extends('backend.master')
@section('content')
    <div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-gradient-primary text-white p-3" style="border-radius: 15px 15px 0 0;">
                    <h4 class="mb-0"><i class="mdi mdi-account-plus me-2"></i>Create New Counsellor Account</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{route('counsellor.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <h5 class="text-primary mb-3"><i class="mdi mdi-lock me-1"></i> Login Credentials</h5>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Email Address (Login ID)</label>
                                <input type="email" name="email" class="form-control" placeholder="example@gmail.com" required>
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Login Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Minimum 6 characters" required>
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="text-primary mb-3"><i class="mdi mdi-account-card-details me-1"></i> Profile Information</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Full Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Designation</label>
                                <input type="text" name="designation" class="form-control" placeholder="e.g. Senior Counsellor">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Phone Number</label>
                                <input type="text" name="phone" class="form-control" placeholder="017XXXXXXXX">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Gender</label>
                                <select name="gender" class="form-select">
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Date of Birth</label>
                                <input type="date" name="dob" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Blood Group</label>
                                <select name="blood" class="form-select">
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
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Address</label>
                                <textarea name="address" class="form-control" rows="2" placeholder="Full Address"></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Facebook Profile Link</label>
                                <input type="url" name="facebook_link" class="form-control" placeholder="https://facebook.com/username">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Profile Image</label>
                                <input type="file" name="profile_image" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <select name="status" class="form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="reset" class="btn btn-light px-4">Reset</button>
                            <button type="submit" class="btn btn-gradient-primary px-5">Create Counsellor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(45deg, #4e73df 0%, #224abe 100%);
    }
    .btn-gradient-primary {
        background: linear-gradient(45deg, #4e73df 0%, #224abe 100%);
        border: none;
        color: white;
    }
    .btn-gradient-primary:hover {
        opacity: 0.9;
        color: white;
    }
    .form-control:focus, .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
</style>
@endsection