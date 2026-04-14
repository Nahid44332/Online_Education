@extends('backend.master')

@section('content')
<div class="container-fluid mt-4">
    {{-- হেডার ও ব্রেডক্রাম্ব --}}
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h3 class="fw-bold text-dark"><i class="fa-solid fa-quote-left me-2 text-primary"></i>Student Testimonials</h3>
            <p class="text-muted small mb-0">Manage feedback and success stories from your students.</p>
        </div>
        <div class="col-md-6 text-end">
            <nav aria-label="breadcrumb" class="d-inline-block">
                <ol class="breadcrumb mb-0 bg-transparent">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active">Testimonial</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">Displaying All Feedback</h5>
        <a href="{{url('/admin/testimonial/create')}}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
            <i class="fa-solid fa-plus-circle me-1"></i> Add New Testimonial
        </a>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="bg-light text-secondary small text-uppercase">
                        <tr>
                            <th class="py-3">SL</th>
                            <th>Client Photo</th>
                            <th class="text-start">Name & Position</th>
                            <th class="text-start">Message</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($testimonials as $testimonial)
                            <tr>
                                <td class="text-muted small">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="avatar-container d-inline-block p-1 border border-primary rounded-circle">
                                        <img src="{{ asset('backend/images/testimonial/'.$testimonial->image) }}" 
                                             alt="user" class="rounded-circle" width="50" height="50" style="object-fit: cover;">
                                    </div>
                                </td>
                                <td class="text-start">
                                    <div class="fw-bold text-dark mb-0">{{ $testimonial->name }}</div>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-normal" style="font-size: 11px;">
                                        {{ $testimonial->designation }}
                                    </span>
                                </td>
                                <td class="text-start">
                                    <div class="text-muted small" style="max-width: 300px;">
                                        <i class="fa-solid fa-quote-left text-primary opacity-25 me-1 small"></i>
                                        {{ Str::limit($testimonial->message, 80) }}
                                        <i class="fa-solid fa-quote-right text-primary opacity-25 ms-1 small"></i>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{url('/admin/testimonial/edit/'.$testimonial->id)}}" class="btn btn-sm btn-outline-info rounded-circle p-0" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" title="Edit">
                                            <i class="fa-solid fa-pen-to-square" style="font-size: 12px;"></i>
                                        </a>
                                        <a href="{{url('/admin/testimonial/delete/'.$testimonial->id)}}" class="btn btn-sm btn-outline-danger rounded-circle p-0" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" onclick="return confirm('Delete this record?')" title="Delete">
                                            <i class="fa-solid fa-trash-can" style="font-size: 12px;"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-5 text-muted">No feedback found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
             <small class="text-muted"><i class="fa-solid fa-circle-info me-1"></i> Note: Testimonials will be displayed in the "What Students Say" section of the main website.</small>
        </div>
    </div>
</div>

<style>
    .bg-primary-subtle { background-color: #eef2ff !important; }
    .table thead th { font-weight: 600; letter-spacing: 0.5px; }
    .avatar-container { line-height: 0; }
    .btn-outline-info:hover { background-color: #0dcaf0; color: #fff; }
    .btn-outline-danger:hover { background-color: #dc3545; color: #fff; }
</style>
@endsection