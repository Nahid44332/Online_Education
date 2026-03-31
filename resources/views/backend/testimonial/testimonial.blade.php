@extends('backend.master')

@section('content')
<div class="container">
    <!--begin::Row-->
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Testimonial</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item">
                    <a href="{{ url('/admin/dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Testimonial</li>
            </ol>
        </div>
    </div>
    <!--end::Row-->

    <div class="mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>All Testimonials</h3>
            <a href="{{url('/admin/testimonial/create')}}" class="btn btn-primary">
                <i class="mdi mdi-plus"></i> Create Testimonial
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>SL</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Message</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($testimonials as $testimonial)
                            <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>
                                <img src="{{asset('backend/images/testimonial/'.$testimonial->image)}}" alt="photo" class="rounded-circle" width="50" height="50">
                            </td>
                            <td>{{$testimonial->name}}</td>
                            <td>{{$testimonial->designation}}</td>
                            <td>{{$testimonial->message}}</td>
                            <td>
                                <a href="{{url('/admin/testimonial/edit/'.$testimonial->id)}}" class="btn btn-sm btn-info">Edit</a>
                                <a href="{{url('/admin/testimonial/delete/'.$testimonial->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this testimonial?')">Delete</a>
                            </td>
                        </tr>
                       @endforeach
                        {{-- <tr><td colspan="6" class="text-center text-muted">No testimonials found.</td></tr> --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
