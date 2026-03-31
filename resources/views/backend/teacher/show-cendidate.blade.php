@extends('backend.master')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top">
            <h3 class="mb-0">Teacher Application Details</h3>
            <span class="badge bg-dark fs-6">{{ $application->application_id }}</span>
        </div>

        <div class="card-body">
            <div class="row">
                {{-- বাম পাশে ইনফো --}}
                <div class="col-md-8">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th width="30%">Name</th>
                                <td>{{ $application->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $application->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $application->phone }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $application->address }}</td>
                            </tr>
                            <tr>
                                <th>Qualification</th>
                                <td>{{ $application->qualification }}</td>
                            </tr>
                            <tr>
                                <th>Skills</th>
                                <td>{{ $application->skills }}</td>
                            </tr>
                            <tr>
                                <th>Experience</th>
                                <td>{{ $application->experience }}</td>
                            </tr>
                            <tr>
                                <th>Cover Letter</th>
                                <td>{{ $application->cover_letter }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- ডান পাশে ইমেজ --}}
                <div class="col-md-4 text-center">
                    @if($application->image)
                        <img src="{{ asset('backend/images/applicatecendidate/'.$application->image) }}" 
                             alt="Applicant Image" 
                             class="img-fluid rounded shadow-sm mb-3" 
                             style="max-width: 200px;">
                    @else
                        <div class="text-muted">No Image Provided</div>
                    @endif

                    @if($application->cv)
                        <a href="{{ asset('backend/file/cv/'.$application->cv) }}" target="_blank" 
                           class="btn btn-outline-primary btn-sm w-100">
                            📄 View CV
                        </a>
                    @else
                        <div class="text-muted mt-2">No CV Uploaded</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between bg-light">
            <div>
                <a href="{{ url('teacher-applications/'.$application->id.'/approve')}}" class="btn btn-success btn-sm">✅ Approve</a>
                <a href="{{ url('teacher-applications/'.$application->id.'/reject')}}" class="btn btn-danger btn-sm">❌ Reject</a>
            </div>
            <a href="{{ url('/admin/teacher/cendidate')}}" class="btn btn-secondary btn-sm">⬅ Back to List</a>
        </div>
    </div>
</div>
@endsection
