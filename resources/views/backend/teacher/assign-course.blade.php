@extends('backend.master')
@section('content')
    <div class="container mt-4">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Assign Course</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Assign Course</li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
        <table class="table table-bordered table-striped">
            <thead class="table-success">
                <tr>
                    <th>SL</th>
                    <th>Image</th>
                    <th>Course Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>
                           <img src="{{ asset('backend/images/courses/'.$course->thumbnail)}}" height="400" width="400" 
                        style="border-radius: 0;">
                        </td>
                        <td>{{ $course->title }}</td>
                        <td>
                            <form action="{{url('/admin/teacher/assign-course/store')}}" method="POST">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                                <!-- টিচার আইডি আগেই আছে -->
                                <button type="submit" class="btn btn-success btn-sm">Add</button>
                            </form>
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
