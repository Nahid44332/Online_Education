@extends('backend.master')
@section('content')
<div class="container">
    <a href="{{url('/admin/course/create')}}" class="btn btn-primary">Add Course</a>
</div>
<div class="container mt-4">
     <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Course List</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Course List</li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    <table class="table table-bordered table-striped">
        <thead class="table-success">
            <tr>
                <th>Course ID</th>
                <th>Image</th>
                <th>Course Name</th>
                <th>Teacher</th>
                <th>Course Fee</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
           @foreach ($courses as $course)
                <tr>
                <td>{{$loop->index+1}}</td>
                <td>
                    <img src="{{ asset('backend/images/courses/'.$course->thumbnail)}}" height="400" width="400" 
                        style="border-radius: 0;">
                </td>

                <td>{{$course->title}}</td>
                <td>{{$course->teacher->name}}</td>
                <td>{{$course->course_fee}}</td>
                <td>
                    <a href="{{url('/admin/course/edit/'.$course->id)}}" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen"></i></a>
                    <a href="{{url('/admin/course/delete/'.$course->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure delete teacher?')"><i class="fa-solid fa-trash"></i></a>                
                </td>
            </tr>
           @endforeach
        </tbody>
    </table>
    <div class="">
        <center>Course for Students</center>
    </div>
</div>
@endsection