@extends('backend.master')
@section('content')

<div class="container mt-3">
    <a href="{{ url('/admin/student/result-create') }}" class="btn btn-primary mb-3">Create Student Result</a>

    <div class="card">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Result Sheet</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>SL</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Student ID</th>
                        <th>Total Marks</th>
                        <th>Marks</th>
                        <th>Status</th>
                        <th>Grade</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $result)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td class="py-1">
                                @if($result->student->image)
                                    <img src="{{ asset('backend/images/students/' . $result->student->image) }}" alt="Student Image" width="50" class="rounded-circle"/>
                                @else
                                    <img src="{{ asset('backend/images/default.png') }}" alt="No Image" width="50" class="rounded-circle"/>
                                @endif
                            </td>
                            <td>{{ $result->student->name }}</td>
                            <td>{{ $result->student->id}}</td>
                            <td>{{ $result->total_marks }}</td>
                            <td>{{ $result->marks_obtained }}</td>
                            <td>
                                @if ($result->status == 'Pass')
                                    <span class="text-success">{{ $result->status }}</span>
                                @else
                                    <span class="text-danger">{{ $result->status }}</span>
                                @endif
                            </td>
                            <td>{{ $result->grade ?? '-' }}</td>
                            <td>
                                <a href="{{url('/admin/student/resule/edit/'.$result->id)}}" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen"></i></a>
                                <a href="{{url('/admin/student/resule/delete/'.$result->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure delete result?')"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($results->isEmpty())
                <p class="text-center mt-3">No results found.</p>
            @endif
        </div>
    </div>
</div>
@endsection