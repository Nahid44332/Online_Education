@extends('backend.master')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold text-dark">Course List</h3>
                </div>
                <div class="col-sm-6 text-sm-end mt-2 mt-sm-0">
                    <a href="{{url('/admin/course/create')}}" class="btn btn-primary btn-sm shadow-sm">
                        <i class="fa-solid fa-plus-circle me-1"></i> Add Course
                    </a>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Course List</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-nowrap ps-3">SL</th>
                            <th class="text-nowrap">Thumbnail</th>
                            <th class="text-nowrap">Course Name</th>
                            <th class="text-nowrap">Instructor</th>
                            <th class="text-nowrap">Course Fee</th>
                            <th class="text-nowrap text-center pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $course)
                            <tr>
                                <td class="ps-3">{{$loop->index+1}}</td>
                                <td>
                                    <img src="{{ asset('backend/images/courses/'.$course->thumbnail)}}" 
                                         class="rounded shadow-sm"
                                         style="width: 80px; height: 50px; object-fit: cover;"
                                         alt="Course Image">
                                </td>
                                <td class="fw-bold text-dark">{{$course->title}}</td>
                                <td>
                                    <span class="badge badge-outline-info text-dark">
                                        {{$course->teacher->name ?? 'N/A'}}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-success fw-bold">৳{{ number_format($course->course_fee, 2) }}</span>
                                </td>
                                <td class="text-center pe-3">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{url('/admin/course/edit/'.$course->id)}}" 
                                           class="btn btn-outline-primary" title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <a href="{{url('/admin/course/delete/'.$course->id)}}" 
                                           class="btn btn-outline-danger" 
                                           onclick="return confirm('Are you sure you want to delete this course?')" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light py-2">
            <p class="text-center mb-0 small text-muted">Course Management Panel for Students</p>
        </div>
    </div>
</div>

<style>
    .table-responsive {
        border-radius: 0 0 12px 12px;
    }
    .text-nowrap {
        white-space: nowrap;
    }
    .badge-outline-info {
        border: 1px solid #17a2b8;
        background: transparent;
        padding: 5px 10px;
    }
    /* মোবাইল ভিউতে ইমেজ সাইজ ঠিক রাখা */
    @media (max-width: 576px) {
        .btn-group-sm > .btn {
            padding: 0.3rem 0.4rem;
        }
    }
</style>
@endsection