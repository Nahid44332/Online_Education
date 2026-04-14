@extends('backend.master')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark"><i class="fa-solid fa-book-open me-2"></i>Course Analytics</h3>
        <button class="btn btn-outline-warning btn-sm text-dark" onclick="window.print()">
            <i class="fa-solid fa-print me-1"></i> Print Course List
        </button>
    </div>

    {{-- কোর্স স্ট্যাটাস কার্ড --}}
    <div class="row g-3">
        <div class="col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm bg-warning text-dark h-100" style="border-radius: 12px;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase small fw-bold opacity-75">Total Courses</h6>
                            <h2 class="mb-0 fw-bold">{{ $totacourses }}</h2>
                        </div>
                        <i class="fa-solid fa-layer-group fs-1 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4 opacity-25">

    {{-- কোর্স টেবিল সেকশন --}}
    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-table-list me-2"></i>Course Fee Structure</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3" style="width: 80px;">SL</th>
                            <th class="text-start">Course Title</th>
                            <th class="text-end pe-5">Fee Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($courses as $course)
                            <tr>
                                <td class="ps-3">{{ $loop->iteration }}</td>
                                <td class="text-start fw-bold text-primary">{{ $course->title }}</td>
                                <td class="text-end pe-5">
                                    <span class="fw-bold text-dark">৳ {{ number_format($course->course_fee, 2) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-folder-open d-block mb-2 fs-2 opacity-25"></i>
                                    No courses found in the system.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light py-2">
            <p class="text-center mb-0 small text-muted">Lina Digital E-Learning Platform - All Rights Reserved</p>
        </div>
    </div>
</div>

<style>
    /* কার্ড এবং হোভার ইফেক্ট */
    .card { transition: transform 0.2s; }
    .card:hover { transform: translateY(-3px); }
    .table-responsive { border-radius: 0 0 12px 12px; }
    
    /* প্রিন্ট সেটিংস */
    @media print {
        .btn, hr { display: none !important; }
        .card { box-shadow: none !important; border: 1px solid #ddd !important; }
        body { background-color: #fff !important; }
        .text-primary { color: #000 !important; }
    }
</style>
@endsection