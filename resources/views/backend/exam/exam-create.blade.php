@extends('backend.master')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="fa-solid fa-file-arrow-up me-2"></i> Upload New Exam File</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.exams.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Exam Title</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-solid fa-heading"></i></span>
                                    <input type="text" name="title" class="form-control" placeholder="e.g. Mid-Term Examination 2026" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Assign Teacher</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-solid fa-user-tie"></i></span>
                                    <select name="teacher_id" class="form-select" required>
                                        <option value="" selected disabled>Choose Teacher...</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Select Course</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-solid fa-book"></i></span>
                                    <select name="course_id" class="form-select" required>
                                        <option value="" selected disabled>Choose Course...</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Exam Question File (PDF/Doc)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-solid fa-cloud-arrow-up"></i></span>
                                    <input type="file" name="exam_file" class="form-control" id="inputGroupFile01" required>
                                </div>
                                <small class="text-muted">Maximum file size: 5MB</small>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm">
                                    <i class="fa-solid fa-paper-plane me-2"></i> Upload Now
                                </button>
                                <button type="reset" class="btn btn-outline-secondary px-4 py-2 ms-2">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 15px;
    }
    .card-header {
        border-radius: 15px 15px 0 0 !important;
    }
    .input-group-text {
        border-right: 0;
    }
    .form-control, .form-select {
        border-left: 0;
    }
    .form-control:focus, .form-select:focus {
        box-shadow: none;
        border-color: #dee2e6;
    }
    .btn-primary {
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
    }
</style>

@endsection