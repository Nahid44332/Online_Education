@extends('backend.master')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark"><i class="fa-solid fa-chalkboard-user me-2"></i>Teacher Reports</h3>
        <button class="btn btn-outline-success btn-sm" onclick="window.print()">
            <i class="fa-solid fa-print me-1"></i> Print Teacher List
        </button>
    </div>

    {{-- টিচার স্ট্যাটাস কার্ড --}}
    <div class="row g-3">
        <div class="col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm bg-success text-white h-100" style="border-radius: 12px;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase small fw-bold opacity-75">Total Teachers</h6>
                            <h2 class="mb-0 fw-bold">{{ $totateachers }}</h2>
                        </div>
                        <i class="fa-solid fa-graduation-cap fs-1 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4 opacity-25">

    {{-- টিচার টেবিল সেকশন --}}
    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-success"><i class="fa-solid fa-list-check me-2"></i>Teacher Assignment Details</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-center">
                        <tr>
                            <th class="ps-3" style="width: 80px;">SL</th>
                            <th class="text-start">Teacher Name</th>
                            <th class="text-start">Assigned Courses</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($teachers as $teacher)
                            <tr>
                                <td class="ps-3">{{ $loop->iteration }}</td>
                                <td class="text-start fw-bold text-dark">{{ $teacher->name }}</td>
                                <td class="text-start">
                                    @forelse($teacher->courses as $course)
                                        <span class="badge bg-success-subtle text-success border border-success mb-1 me-1">
                                            <i class="fa-solid fa-book-bookmark me-1 small"></i>{{ $course->title }}
                                        </span>
                                    @empty
                                        <span class="text-muted italic small">No Course Assigned</span>
                                    @endforelse
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-user-slash d-block mb-2 fs-2 opacity-25"></i>
                                    No teachers found in records.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light py-2 text-center">
            <small class="text-muted italic">Lina Digital E-Learning Platform - Teacher Management</small>
        </div>
    </div>
</div>

<style>
    /* কার্ড এবং ব্যাজ স্টাইল */
    .card { transition: transform 0.2s; }
    .card:hover { transform: translateY(-3px); }
    .bg-success-subtle { background-color: #e1f7ec !important; color: #198754 !important; }
    .table-responsive { border-radius: 0 0 12px 12px; }
    
    /* প্রিন্ট সেটিংস */
    @media print {
        .btn, .breadcrumb, hr { display: none !important; }
        .card { box-shadow: none !important; border: 1px solid #ddd !important; }
        body { background-color: #fff !important; }
    }
</style>
@endsection