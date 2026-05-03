@extends('backend.manager-panel.master')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> My Profile </h3>
        </div>

        <div class="row">
            <!-- বাম পাশের কার্ড (ছবি ও পয়েন্ট) -->
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <div class="position-relative d-inline-block mb-3">
                            <img src="{{ asset($manager->profile_image) }}" alt="profile"
                                class="img-lg rounded-circle border border-primary p-1"
                                style="width: 140px; height: 140px; object-fit: cover;">
                        </div>
                        <h4 class="fw-bold">{{ $manager->name }}</h4>
                        <p class="text-muted">{{ $manager->designation }}</p>

                        <div class="mt-3 p-2 bg-light rounded-pill border">
                            <span class="text-primary fw-bold"><i class="mdi mdi-star"></i> Points:
                                {{ $manager->points }}</span>
                        </div>

                        <div class="mt-4">
                            @if ($manager->facebook_link)
                                <a href="{{ $manager->facebook_link }}" target="_blank"
                                    class="btn btn-facebook btn-rounded shadow-sm"
                                    style="width: 45px; height: 45px; display: inline-flex; align-items: center; justify-content: center; padding: 0; background-color: #3b5998; border: none; color: white; text-decoration: none;">
                                    <i class="mdi mdi-facebook" style="font-size: 24px;"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- ডান পাশের কার্ড (বিস্তারিত তথ্য) -->
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Account Information</h4>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold py-2" style="width: 30%;">Manager ID</td>
                                        <td class="text-secondary py-2">: #{{ $manager->id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold py-2">Phone Number</td>
                                        <td class="text-secondary py-2">: {{ $manager->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold py-2">Date of Birth</td>
                                        <td class="text-secondary py-2">: {{ $manager->dob }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold py-2">Blood Group</td>
                                        <td class="text-secondary py-2">: <span
                                                class="badge badge-danger">{{ $manager->blood }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold py-2">Joining Date</td>
                                        <td class="text-secondary py-2">:
                                            {{ \Carbon\Carbon::parse($manager->created_at)->format('d M, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold py-2">Last Updated</td>
                                        <td class="text-secondary py-2">:
                                            {{ \Carbon\Carbon::parse($manager->updated_at)->diffForHumans() }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-5">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#editProfileModal" class="btn btn-gradient-primary btn-icon-text">
                                <i class="mdi mdi-account-edit btn-icon-prepend"></i> Edit Profile
                            </a>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal" class="btn btn-light btn-icon-text ms-2">
                                <i class="mdi mdi-key-variant btn-icon-prepend"></i> Change Password
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('manager.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $manager->name }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="{{ $manager->phone }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control"
       value="{{ $manager->dob ? \Carbon\Carbon::createFromFormat('d/m/Y', $manager->dob)->format('Y-m-d') : '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Blood Group</label>
                            <select name="blood" class="form-control">
                                <option value="A+" {{ $manager->blood == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ $manager->blood == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ $manager->blood == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ $manager->blood == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="O+" {{ $manager->blood == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ $manager->blood == 'O-' ? 'selected' : '' }}>O-</option>
                                <option value="AB+" {{ $manager->blood == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ $manager->blood == 'AB-' ? 'selected' : '' }}>AB-</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Facebook Profile Link</label>
                            <input type="url" name="facebook_link" class="form-control" value="{{ $manager->facebook_link }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Profile Image (Leave blank to keep current)</label>
                            <input type="file" name="profile_image" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-gradient-primary">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gradient-danger text-white">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('manager.password.update') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gradient-danger">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
