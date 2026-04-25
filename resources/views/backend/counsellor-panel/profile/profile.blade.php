@extends('backend.counsellor-panel.cs-master')
@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 text-center p-4">
                    <div class="card-body">
                        <img src="{{ asset('backend/images/counsellor/' . Auth::guard('subadmin')->user()->counsellor->profile_image) }}"
                            class="rounded-circle mb-3 border p-1" width="150" height="150" style="object-fit: cover;">

                        <h4 class="fw-bold mb-1">{{ $counsellor->name }}</h4>
                        <p class="text-primary mb-3">{{ $counsellor->designation }}</p>
                        <div class="mb-3">
                            <span class="badge bg-light text-success border border-success px-3 py-2"
                                style="border-radius: 50px; font-weight: 600;">
                                <i class="mdi mdi-id-card me-1"></i> ID: #{{ $counsellor->id }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('counsellor.profile.edit') }}" class="btn btn-primary btn-sm flex-grow-1">
                                <i class="mdi mdi-account-edit me-1"></i> Edit Profile
                            </a>
                            <a href="{{route('counsellor.security')}}" class="btn btn-info btn-sm text-white flex-grow-1">
                                <i class="mdi mdi-shield-lock me-1"></i> Security
                            </a>
                        </div>
                        <hr>
                        <div class="text-start mt-3">
                            <p class="mb-2"><strong>Status:</strong>
                                <span class="badge {{ $counsellor->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $counsellor->status == 1 ? 'Active' : 'Inactive' }}
                                </span>
                            </p>
                            <p class="mb-2"><strong>Points:</strong> <span class="text-success fw-bold">৳
                                    {{ number_format($counsellor->points) }}</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold text-dark"><i class="mdi mdi-information-outline me-2"></i>Detailed
                            Information</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table mb-0 table-striped">
                            <tbody>
                                <tr>
                                    <th class="ps-4 py-3" style="width: 30%;">Phone</th>
                                    <td class="py-3 text-muted">{{ $counsellor->phone }}</td>
                                </tr>
                                <tr>
                                    <th class="ps-4 py-3">Gender</th>
                                    <td class="py-3 text-muted">{{ $counsellor->gender }}</td>
                                </tr>
                                <tr>
                                    <th class="ps-4 py-3">Blood Group</th>
                                    <td class="py-3 text-muted">{{ $counsellor->blood ?? 'Not Specified' }}</td>
                                </tr>
                                <tr>
                                    <th class="ps-4 py-3">Date of Birth</th>
                                    <td class="py-3 text-muted">{{ date('d M, Y', strtotime($counsellor->dob)) }}</td>
                                </tr>
                                <tr>
                                    <th class="ps-4 py-3">Address</th>
                                    <td class="py-3 text-muted">{{ $counsellor->address }}</td>
                                </tr>
                                <tr>
                                    <th class="ps-4 py-3">Facebook Profile</th>
                                    <td class="py-3">
                                        <a href="{{ $counsellor->facebook_link }}" target="_blank"
                                            class="text-primary text-decoration-none">
                                            Visit Profile <i class="mdi mdi-open-in-new small"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="ps-4 py-3">Member Since</th>
                                    <td class="py-3 text-muted">{{ date('d M, Y', strtotime($counsellor->created_at)) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
