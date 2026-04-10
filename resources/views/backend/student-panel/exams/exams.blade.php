@extends('backend.student-panel.st-master')
@section('content')

<div class="container mt-4">
    <div class="row">
        <div class="col-12 mb-4">
            <h4 class="fw-bold"><i class="mdi mdi-book-open-variant me-2 text-primary"></i> My Exam Papers</h4>
            <p class="text-muted small">Download your course-related exam questions from here.</p>
        </div>

        @forelse ($exams as $exam)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <i class="mdi mdi-file-pdf-box text-danger" style="font-size: 50px;"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1">{{ $exam->title }}</h6>
                        <p class="text-muted small mb-3">
                            <i class="mdi mdi-account-tie me-1"></i> {{ $exam->teacher->name ?? 'Admin' }} <br>
                            <i class="mdi mdi-calendar me-1"></i> Exam Date: {{ \Carbon\Carbon::parse($exam->exam_date)->format('d M, Y') }}
                        </p>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ asset('backend/files/exams/'.$exam->exam_file) }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill">
                                <i class="mdi mdi-eye me-1"></i> View Question
                            </a>
                            <a href="{{ asset('backend/files/exams/'.$exam->exam_file) }}" download class="btn btn-primary btn-sm rounded-pill">
                                <i class="mdi mdi-download me-1"></i> Download Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="alert alert-info">
                    <i class="mdi mdi-information-outline me-2"></i> No exam files available for your course yet.
                </div>
            </div>
        @endforelse
    </div>
</div>

@endsection