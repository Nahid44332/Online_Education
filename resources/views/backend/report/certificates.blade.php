@extends('backend.master')
@section('content')
    <div class="container mt-4">
        <h3>Reports</h3>

       <div class="row mt-4">
    <div class="col-md-3">
        <div class="card p-3 bg-info text-white">
            <h5>Total Certificate</h5>
            <h3>{{ $totacertificates }}</h3>
        </div>
    </div>
</div>

        <hr>
              <!-- Certificate Table -->
            <h4 class="mt-4">Certificate List</h4>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Certificate No</th>
                        <th>Issue Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($certificates as $certificate)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{ $certificate->student->name ?? 'N/A' }}</td>
                            <td>{{ $certificate->course->title ?? 'N/A' }}</td>
                            <td>{{ $certificate->certificate_no }}</td>
                            <td>{{ $certificate->issue_date}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
