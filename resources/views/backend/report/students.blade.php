@extends('backend.master')
@section('content')
    <div class="container mt-4">
        <h3>Reports</h3>

       <div class="row mt-4">
    <div class="col-md-3">
        <div class="card p-3 bg-primary text-white">
            <h5>Total Students</h5>
            <h3>{{ $totalstudents }}</h3>
        </div>
    </div>
</div>

        <hr>

        <!-- Students Table -->
        <h4 class="mt-4">Student List</h4>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $loop->index+1}}</td>
                        <td>{{ $student->id}}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->phone }}</td>
                        <td>{{ $student->email }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endsection
