@extends('backend.master')
@section('content')

<div class="container mt-4">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold text-primary">Exam Paper List</h3>
                    <p class="text-muted mb-0">Manage all uploaded exam questions from here.</p>
                </div>
                <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
                    <a href="{{url('/admin/exam/create')}}" class="btn btn-primary shadow-sm">
                        <i class="mdi mdi-plus-circle me-1"></i> Upload Exam File
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3">SL</th>
                            <th class="py-3">Exam Title</th>
                            <th class="py-3">Teacher & Course</th>
                            <th class="py-3">Exam Date</th>
                            <th class="py-3">Status</th>
                            <th class="py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($exams as $exam)
                        <tr>
                            <td><span class="fw-bold">{{ $loop->iteration }}</span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3">
                                        <span class="avatar-title bg-soft-primary text-primary rounded">
                                            <i class="mdi mdi-file-document-outline fs-4"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-dark">{{ $exam->title }}</h6>
                                        <small class="text-muted">Uploaded: {{ $exam->created_at->format('d M, Y') }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="mb-0 fw-medium text-dark"><i class="mdi mdi-account-tie me-1"></i> {{ $exam->teacher->name ?? 'N/A' }}</p>
                                <span class="badge bg-soft-info text-info fs-xs">{{ $exam->course->title ?? 'General' }}</span>
                            </td>
                            <td>
                                <span class="text-dark fw-medium"><i class="mdi mdi-calendar-range me-1"></i> {{ \Carbon\Carbon::parse($exam->exam_date)->format('d/m/Y') }}</span>
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-success-subtle text-success">Active</span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{asset('backend/files/exams/'.$exam->exam_file)}}" target="_blank" class="btn btn-soft-primary btn-sm" title="View File">
                                        <i class="mdi mdi-eye fs-5"></i>
                                    </a>
                                    <a href="{{asset('backend/files/exams/'.$exam->exam_file)}}" download class="btn btn-soft-success btn-sm" title="Download">
                                        <i class="mdi mdi-download fs-5"></i>
                                    </a>
                                    <a href="{{url('/admin/exam/delete/'.$exam->id)}}" onclick="return confirm('Are you sure you want to delete this file?')" class="btn btn-soft-danger btn-sm" title="Delete">
                                        <i class="mdi mdi-delete fs-5"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($exams->isEmpty())
                <div class="text-center py-5">
                    <img src="{{ asset('backend/images/no-data.png') }}" alt="" style="width: 150px; opacity: 0.5;">
                    <p class="mt-3 text-muted">No exam files found in the database.</p>
                </div>
            @endif

            <div class="mt-4 border-top pt-3">
                <p class="text-center text-muted small">Lina Digital E-Learning Platform - Exam Management System</p>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Styling for Soft Badges and Buttons */
    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.1) !important; padding: 10px; }
    .bg-soft-info { background-color: rgba(13, 202, 240, 0.1) !important; color: #0dcaf0 !important; }
    .btn-soft-primary { color: #0d6efd; background-color: rgba(13, 110, 253, 0.1); border: none; }
    .btn-soft-primary:hover { background-color: #0d6efd; color: white; }
    .btn-soft-success { color: #198754; background-color: rgba(25, 135, 84, 0.1); border: none; }
    .btn-soft-success:hover { background-color: #198754; color: white; }
    .btn-soft-danger { color: #dc3545; background-color: rgba(220, 53, 69, 0.1); border: none; }
    .btn-soft-danger:hover { background-color: #dc3545; color: white; }
    .fs-xs { font-size: 11px; }
</style>

@endsection