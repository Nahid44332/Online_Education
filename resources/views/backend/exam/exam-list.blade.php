@extends('backend.master')
@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Teacher's Uploaded Exams</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>SL</th>
                                <th>Exam Title</th>
                                <th>Teacher</th>
                                <th>Course</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($exams as $exam)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $exam->title }}</td>
                                    <td>{{ $exam->teacher->name ?? 'Admin' }}</td>
                                    <td>{{ $exam->course->title ?? 'N/A' }}</td>
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
                                            <i class="mdi mdi-eye"></i> View
                                        </a>

                                        @if ($exam->status == 'pending')
                                            <a href="{{ route('admin.exam.approve', $exam->id) }}"
                                                class="btn btn-sm btn-success"
                                                onclick="return confirm('আপনি কি এই ফাইলটি অ্যাপ্রুভ করতে চান?')">
                                                <i class="mdi mdi-check"></i> Approve
                                            </a>
                                        @endif

                                        <a href="{{ route('admin.exam.delete', $exam->id) }}" class="btn btn-sm btn-danger"
                                            onclick="return confirm('আপনি কি নিশ্চিত যে এই ফাইলটি ডিলিট করতে চান? এটি আর ফিরে পাওয়া যাবে না।')">
                                            <i class="mdi mdi-delete"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
