@extends('backend.teacher-panel.TS-master')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card teacher-card p-4 shadow-sm border-0" style="border-radius: 20px;">
                    <h4 class="fw-bold mb-4 text-dark"><i class="mdi mdi-account-edit text-primary me-2"></i> Update Profile
                        Information</h4>

                    <form action="{{ route('teacher.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3 text-center">
                                <img src="{{ asset('backend/images/teachers/' . ($teacher->profile_image ?? 'default.png')) }}"
                                    style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;"
                                    class="mb-2 border">
                                <label class="d-block small text-muted">Current Profile Photo</label>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Full Name</label>
                                <input type="text" name="name" class="form-control bg-light border-0 py-2"
                                    value="{{ $teacher->name }}" required style="border-radius: 10px;">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Phone Number</label>
                                <input type="text" name="phone" class="form-control bg-light border-0 py-2"
                                    value="{{ $teacher->phone }}" required style="border-radius: 10px;">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Blood Group</label>
                                <select name="blood" class="form-select bg-light border-0 py-2"
                                    style="border-radius: 10px;">
                                    @foreach (['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $group)
                                        <option value="{{ $group }}"
                                            {{ ($teacher->blood ?? '') == $group ? 'selected' : '' }}>{{ $group }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Upload New Photo</label>
                                <input type="file" name="profile_image" class="form-control bg-light border-0 py-2"
                                    style="border-radius: 10px;">
                            </div>
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-premium px-5 shadow-sm">Update Now</button>

                            <a href="{{ route('teacher.view-profile') }}"
                                class="btn btn-light rounded-pill px-4 border">Back to Profile</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
