@extends('backend.master')
@section('content')

<div class="container mt-5">
    <div class="card p-4">
        <h3 class="text-center mb-4">Certificate Detail</h3>

        <table class="table table-bordered">
            <tr>
                <th>Certificate No</th>
                <td>{{ $certificate->certificate_no }}</td>
            </tr>
            <tr>
                <th>Student Name</th>
                <td>{{ $certificate->student->name }}</td>
            </tr>
            <tr>
                <th>Student ID</th>
                <td>{{ $certificate->student->id }}</td>
            </tr>
            <tr>
                <th>Course</th>
                <td>{{ $certificate->course->title }}</td>
            </tr>
            <tr>
                <th>Result</th>
                <td>{{ $certificate->result->grade }}</td>
            </tr>
            <tr>
                <th>Issue Date</th>
                <td>{{ \Carbon\Carbon::parse($certificate->issue_date)->format('d/m/Y') }}</td>
            </tr>
        </table>

        <div class="text-center mt-3">
            <a href="{{url('/admin/student/certificate/print/'.$certificate->id)}}" class="btn btn-primary">Print Certificate</a>
        </div>
    </div>
</div>

@endsection
