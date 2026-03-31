@extends('backend.master')
@section('content')
    <div class="container mt-4">
        <h3>Reports</h3>

       <div class="row mt-4">
    <div class="col-md-3">
        <div class="card p-3 bg-warning text-white">
            <h5>Total Courses</h5>
            <h3>{{ $totacourses }}</h3>
        </div>
    </div>
</div>

        <hr>
            <!-- Course Table -->
            <h4 class="mt-4">Course List</h4>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Fee</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr>
                            <td>{{ $loop->index+1}}</td>
                            <td>{{ $course->title }}</td>
                            <td>{{ $course->course_fee }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
