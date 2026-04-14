@extends('backend.master')

@section('content')
<div class="container-fluid mt-4 pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark"><i class="fa-solid fa-award me-2"></i>Certification Reports</h3>
        <button class="btn btn-outline-dark btn-sm shadow-sm" onclick="window.print()">
            <i class="fa-solid fa-print me-1"></i> Print Records
        </button>
    </div>

    {{-- সার্টিফিকেট স্ট্যাটাস কার্ড --}}
    <div class="row g-3">
        <div class="col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm bg-dark text-white h-100" style="border-radius: 12px;">
                <div class="card-body p-4 text-center">
                    <i class="fa-solid fa-file-certificate mb-2 opacity-50" style="font-size: 2rem;"></i>
                    <h6 class="text-uppercase small fw-bold mb-1" style="letter-spacing: 1px;">Issued Certificates</h6>
                    <h2 class="mb-0 fw-bold">{{ $totacertificates }}</h2>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4 opacity-25">

    {{-- সার্টিফিকেট টেবিল সেকশন --}}
    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-list-ul me-2"></i>Official Certificate Log</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3" style="width: 80px;">SL</th>
                            <th class="text-start">Student Name</th>
                            <th class="text-start">Course Title</th>
                            <th>Certificate No</th>
                            <th class="pe-3">Issue Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($certificates as $certificate)
                            <tr>
                                <td class="ps-3">{{ $loop->iteration }}</td>
                                <td class="text-start fw-bold text-dark">{{ $certificate->student->name ?? 'N/A' }}</td>
                                <td class="text-start">
                                    <span class="text-muted small"><i class="fa-solid fa-graduation-cap me-1"></i>{{ $certificate->course->title ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <code class="fw-bold text-primary px-2 py-1 bg-light rounded" style="font-size: 0.95rem;">
                                        {{ $certificate->certificate_no }}
                                    </code>
                                </td>
                                <td class="pe-3">
                                    <span class="badge bg-light text-dark border fw-normal">
                                        {{ \Carbon\Carbon::parse($certificate->issue_date)->format('d M, Y') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-medal d-block mb-2 fs-1 opacity-25"></i>
                                    No certificates have been issued yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light py-2 text-center">
            <small class="text-muted">Lina Digital E-Learning Platform - Verification System Enabled</small>
        </div>
    </div>
</div>

<style>
    /* ড্যাশবোর্ড স্টাইলিং */
    .card { transition: transform 0.2s ease; }
    .card:hover { transform: translateY(-3px); }
    .table-responsive { border-radius: 0 0 12px 12px; }
    code { letter-spacing: 0.5px; }

    /* প্রিন্ট সেটিংস */
    @media print {
        .btn, hr, .card-footer { display: none !important; }
        .card { box-shadow: none !important; border: 1px solid #ddd !important; }
        body { background-color: #fff !important; }
    }
</style>
@endsection