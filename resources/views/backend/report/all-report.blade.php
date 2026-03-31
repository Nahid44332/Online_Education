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
    <div class="col-md-3">
        <div class="card p-3 bg-success text-white">
            <h5>Total Teachers</h5>
            <h3>{{ $totateachers }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 bg-warning text-white">
            <h5>Total Courses</h5>
            <h3>{{ $totacourses }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 bg-info text-white">
            <h5>Total Payments</h5>
            <h3>{{ $totapayments }}</h3>
        </div>
    </div>
    <div class="col-md-3 mt-3">
        <div class="card p-3 bg-info text-white">
            <h5>Total Certificate</h5>
            <h3>{{ $totacertificates }}</h3>
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
                                    <span>No Course Assign</span>
                                @endforelse
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

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

            <!-- Payment Table -->
            <h4 class="mt-4">Payment List</h4>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <td>{{ $loop->index+1}}</td>
                            <td>{{ $payment->student->name ?? 'N/A' }}</td>
                            <td>{{ $payment->course->title ?? 'N/A' }}</td>
                            <td>{{ $payment->amount }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

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
