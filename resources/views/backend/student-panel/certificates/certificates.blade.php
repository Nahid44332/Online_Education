@extends('backend.student-panel.st-master')
@section('content')

<div class="container mt-4">
    <div class="row">
        <div class="col-12 mb-4">
            <h4 class="fw-bold"><i class="mdi mdi-certificate me-2 text-warning"></i> My Certificates</h4>
            <p class="text-muted small">Congratulations! Here are your earned certificates.</p>
        </div>

        @forelse ($certificates as $certificate)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(145deg, #ffffff, #f0f4f8);">
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <i class="mdi mdi-seal text-warning" style="font-size: 60px;"></i>
                        </div>
                        <h6 class="fw-bold text-dark">{{ $certificate->course->title ?? 'Course Name' }}</h6>
                        <p class="text-muted small mb-2">ID: {{ $certificate->certificate_no }}</p>
                        <hr>
                        <p class="text-secondary small mb-3">
                            <i class="mdi mdi-calendar-check me-1"></i> Issued: {{ \Carbon\Carbon::parse($certificate->issue_date)->format('d M, Y') }}
                        </p>
                        
                        <div class="d-grid">
                            <a href="{{ url('/student/certificate/download/' . $certificate->id) }}" download class="btn btn-success btn-sm rounded-pill px-4">
                                <i class="mdi mdi-download me-1"></i> Download Certificate
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="alert alert-light shadow-sm">
                    <i class="mdi mdi-emoticon-sad-outline me-2"></i> You haven't earned any certificates yet. Keep learning!
                </div>
            </div>
        @endforelse
    </div>
</div>

@endsection