@extends('backend.teacher-panel.TS-master')
@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="mdi mdi-cloud-upload me-2"></i>Upload New Exam Question</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('exam.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Exam Title</label>
                            <input type="text" name="title" class="form-control" required
                                placeholder="Ex: Final Term 2026">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Select Course</label>
                            <select name="course_id" class="form-select" required>
                                <option value="">Choose...</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Exam Date</label>
                            <input type="date" name="exam_date" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Upload File (PDF/Doc)</label>
                            <input type="file" name="exam_file" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary px-4">Submit to Admin</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="mdi mdi-format-list-bulleted me-2"></i>My Uploaded Exams</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>SL</th>
                                <th>Title</th>
                                <th>Course</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($exams as $exam)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $exam->title }}</td>
                                    <td>{{ $exam->course->title ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($exam->exam_date)->format('d M, Y') }}</td>
                                    <td>
                                        @if ($exam->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @else
                                            <span class="badge bg-success">Approved</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ asset('backend/files/exams/' . $exam->exam_file) }}" target="_blank"
                                            class="btn btn-sm btn-info text-white">
                                            <i class="mdi mdi-eye"></i>
                                        </a>

                                        <a href="{{ route('exam.delete', $exam->id) }}" class="btn btn-sm btn-danger"
                                            onclick="return confirm('আপনি কি নিশ্চিত যে এটি ডিলিট করতে চান?')">
                                            <i class="mdi mdi-delete"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No exams uploaded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
