@extends('backend.master')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold text-dark">Certificate List</h3>
                </div>
                <div class="col-sm-6 text-sm-end mt-2 mt-sm-0">
                    <a href="{{ url('/admin/student/certificate/create') }}" class="btn btn-primary btn-sm shadow-sm">
                        <i class="fa-solid fa-plus-circle me-1"></i> Generate Certificate
                    </a>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Certificate List</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ url('/admin/student/certificate') }}" method="GET" class="mb-4">
                <div class="row g-2 shadow-sm p-3 bg-light rounded-3 align-items-center">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0"
                                placeholder="Search by Student Name, ID, Certificate No, or Course..." 
                                value="{{ request('search') }}" required>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button class="btn btn-success flex-grow-1" type="submit">Search</button>
                        <a href="{{ url('/admin/student/certificate') }}" class="btn btn-secondary px-3">Reset</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive mt-3">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-center">
                        <tr>
                            <th class="text-nowrap ps-3">SL</th>
                            <th class="text-nowrap">Student Name</th>
                            <th class="text-nowrap">ID</th>
                            <th class="text-nowrap">Course</th>
                            <th class="text-nowrap">Grade</th>
                            <th class="text-nowrap">Certificate No</th>
                            <th class="text-nowrap">Issue Date</th>
                            <th class="text-nowrap pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($certificates as $key => $certificate)
                            <tr>
                                <td class="ps-3">{{ $key + 1 }}</td>
                                <td class="text-start">
                                    <span class="fw-bold d-block text-dark">{{ $certificate->student->name ?? 'Deleted Student' }}</span>
                                </td>
                                <td><span class="badge bg-light text-dark border">#{{ $certificate->student->id ?? 'N/A' }}</span></td>
                                <td>{{ $certificate->course->title ?? 'N/A' }}</td>
                                <td>
                                    <span class="fw-bold text-success">{{ $certificate->result->grade ?? 'N/A' }}</span>
                                </td>
                                <td><code class="text-dark fw-bold">{{ $certificate->certificate_no }}</code></td>
                                <td class="text-nowrap">{{ \Carbon\Carbon::parse($certificate->issue_date)->format('d M Y') }}</td>
                                <td class="pe-3">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ url('/admin/student/certificate/' . $certificate->id) }}"
                                           class="btn btn-outline-info" title="View">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ url('/admin/student/certificate/download/' . $certificate->id) }}"
                                           class="btn btn-outline-primary" title="Download">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                        <a href="{{ url('/admin/student/certificate/delete/' . $certificate->id) }}"
                                           class="btn btn-outline-danger"
                                           onclick="return confirm('Are you sure you want to delete this Certificate?')" 
                                           title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-certificate d-block mb-2" style="font-size: 2rem; opacity: 0.3;"></i>
                                    No Certificates Found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light py-2">
            <p class="text-center mb-0 small text-muted">Certificate Distribution Management Panel</p>
        </div>
    </div>
</div>

<style>
    .table-responsive { border-radius: 0 0 12px 12px; }
    .text-nowrap { white-space: nowrap; }
    .btn-group-sm > .btn { padding: 0.4rem 0.6rem; }
    .input-group-text { border-radius: 8px 0 0 8px; }
    .form-control { border-radius: 0 8px 8px 0; }
    .form-control:focus { border-color: #dee2e6; box-shadow: none; }
</style>
@endsection