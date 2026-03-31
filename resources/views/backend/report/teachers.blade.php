@extends('backend.master')
@section('content')
    <div class="container mt-4">
        <h3>Reports</h3>

       <div class="row mt-4">
    <div class="col-md-3">
        <div class="card p-3 bg-success text-white">
            <h5>Total Teachers</h5>
            <h3>{{ $totateachers }}</h3>
        </div>
    </div>
</div>

        <hr>

        <!-- Teacher Table -->
        <h4 class="mt-4">Teacher List</h4>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Courses</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teachers as $teacher)
                    <tr>
                        <td>{{ $loop->index+1}}</td>
                        <td>{{ $teacher->name }}</td>
                        <td>
                            @forelse($teacher->courses as $course)
                                <span>{{ $course->title }}@if (!$loop->last)
                                        ,
                                    @endif
                                </span>
                                @empty
                                    <span>No Assign Course</span>
                                @endforelse
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    @endsection
