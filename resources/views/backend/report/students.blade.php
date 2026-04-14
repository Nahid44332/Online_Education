@extends('backend.master')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark"><i class="fa-solid fa-chart-pie me-2"></i>Reports & Analytics</h3>
        <button class="btn btn-outline-primary btn-sm" onclick="window.print()">
            <i class="fa-solid fa-print me-1"></i> Print Report
        </button>
    </div>

    {{-- স্ট্যাটাস কার্ড সেকশন --}}
    <div class="row g-3 mt-2">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-primary text-white h-100" style="border-radius: 12px;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-uppercase small fw-bold opacity-75">Total Students</h6>
                            <h2 class="mb-0 fw-bold">{{ $totalstudents }}</h2>
                        </div>
                        <i class="fa-solid fa-user-graduate fs-1 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        {{-- এখানে আপনি চাইলে আগের মতো বাকি কার্ডগুলো (Teacher, Course, etc.) যোগ করতে পারেন --}}
    </div>

    <hr class="my-4 opacity-25">

    {{-- স্টুডেন্ট টেবিল সেকশন --}}
    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-primary"><i class="fa-solid fa-list me-2"></i>Student List</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-center">
                            <th class="ps-3">SL</th>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th class="pe-3">Email</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($students as $student)
                            <tr>
                                <td class="ps-3">{{ $loop->iteration }}</td>
                                <td><span class="badge bg-light text-dark border">#{{ $student->id }}</span></td>
                                <td class="fw-bold text-start">{{ $student->name }}</td>
                                <td>{{ $student->phone }}</td>
                                <td class="pe-3">{{ $student->email }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No students found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light py-2">
            <p class="text-center mb-0 small text-muted">Generated on: {{ date('d M Y, h:i A') }}</p>
        </div>
    </div>
</div>

<style>
    .card { transition: transform 0.2s; }
    .card:hover { transform: translateY(-3px); }
    .table-responsive { border-radius: 0 0 12px 12px; }
    @media print {
        .btn, hr { display: none !important; }
        .card { border: 1px solid #ddd !important; box-shadow: none !important; }
    }
</style>
@endsection