@extends('backend.master')
@section('content')
    <div class="container">
        <a href="{{ url('/admin/student/certificate/create') }}" class="btn btn-primary">Generate Certificate</a>
    </div>
    <div class="container mt-4">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Certificate List</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Certificate List</li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
        <form action="{{ url('/admin/student/certificate') }}" method="GET" class="mb-3">
            <div class="mb-3">
                <input type="text" name="search" class="form-control"
                    placeholder="Search by Student Name, ID, Certificate No, Course" value="{{ request('search') }}" required>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-success" type="submit">Search</button>
                <a href="{{ url('/admin/student/certificate') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
        <table class="table table-bordered table-striped">
            <thead class="table-success">
                <tr>
                    <th>SL</th>
                    <th>Student Name</th>
                    <th>Student ID</th>
                    <th>Course</th>
                    <th>Grade</th>
                    <th>Certificate No</th>
                    <th>Issue Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($certificates as $key => $certificate)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $certificate->student->name ?? 'N/A' }}</td>
                        <td>{{ $certificate->student->id ?? 'N/A' }}</td>
                        <td>{{ $certificate->course->title ?? 'N/A' }}</td>
                        <td style="color: green">{{ $certificate->result->grade ?? 'N/A' }}</td>
                        <td><strong>{{ $certificate->certificate_no }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($certificate->issue_date)->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ url('/admin/student/certificate/' . $certificate->id) }}"
                                class="btn btn-success btn-sm"><span class="mdi mdi-eye"></span></a>
                            <a href="{{ url('/admin/student/certificate/print/' . $certificate->id) }}"
                                class="btn btn-info btn-sm"><span class="mdi mdi-printer"></span></a>
                            <a href="{{ url('/admin/student/certificate/delete/' . $certificate->id) }}"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure delete Certificate?')"><span
                                    class="mdi mdi-delete"></span></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No Certificates Found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="text-center mt-4">
            <strong>Certificate for Students</strong>
        </div>
    </div>
@endsection
