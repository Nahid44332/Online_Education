@extends('backend.trainer-panel.tr-master')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card text-center shadow-sm" style="border-radius: 15px;">
                    <div class="card-body">
                        <img src="{{ asset('backend/images/trainer/' . $trainer->profile_image) }}"
                            class="img-lg rounded-circle mb-3"
                            style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #b66dff;"
                            alt="profile image">
                        <h4 class="mb-1">{{ $subadmin->name }}</h4>
                        <p class="text-muted">{{ $trainer->designation ?? 'Official Trainer' }}</p>
                        <a href="{{ route('trainer.profile.edit') }}" class="btn btn-gradient-primary btn-sm mt-3">Edit
                            Profile</a>
                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <a href="{{ route('trainer.password.change') }}"
                                    class="btn btn-outline-danger btn-fw btn-sm">
                                    <i class="mdi mdi-lock-reset me-1"></i> Change Security Password
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 grid-margin stretch-card">
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body">
                        <h4 class="card-title text-primary">Personal Information</h4>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Full Name:</div>
                            <div class="col-sm-8 fw-bold">{{ $subadmin->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Email Address:</div>
                            <div class="col-sm-8 fw-bold">{{ $subadmin->email }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Phone Number:</div>
                            <div class="col-sm-8 fw-bold">{{ $trainer->phone ?? 'N/A' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Date of Birth:</div>
                            <div class="col-sm-8 fw-bold">{{ $trainer->dob ?? 'N/A' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Blood Group:</div>
                            <div class="col-sm-8 text-danger fw-bold">{{ $trainer->blood ?? 'N/A' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Facebook Profile:</div>
                            <div class="col-sm-8">
                                <a href="{{ $trainer->facebook_link }}" target="_blank" class="text-info">Visit Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
