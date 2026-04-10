@extends('backend.teacher-panel.TS-master')
@section('content')

<div class="container mt-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary fw-bold">
                <i class="mdi mdi-clipboard-text-outline me-2"></i> Questions Assigned to Me
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>SL</th>
                            <th>Exam Title</th>
                            <th>Course Name</th>
                            <th>Exam Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($exams as $exam)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="fw-medium">{{ $exam->title }}</span>
                            </td>
                            <td>
                                <span class="badge bg-info-subtle text-info">{{ $exam->course->title ?? 'N/A' }}</span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($exam->exam_date)->format('d M, Y') }}</td>
                            <td class="text-center">
                                <a href="{{ asset('backend/files/exams/'.$exam->exam_file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="mdi mdi-eye"></i> View
                                </a>
                                <a href="{{ asset('backend/files/exams/'.$exam->exam_file) }}" download class="btn btn-sm btn-primary">
                                    <i class="mdi mdi-download"></i> Download
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No questions found for you.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection