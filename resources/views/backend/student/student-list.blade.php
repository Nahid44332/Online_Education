@extends('backend.master')
@section('content')
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Student List</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Student List</li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>SL</th>
                <th>Student ID</th>
                <th> Student</th>
                <th> First name</th>
                <th> Father Name</th>
                <th> Mother Name</th>
                <th> Course</th>
                <th> Admission Date</th>
                <th> Status</th>
                <th> Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $student->id }}</td>
                    <td class="py-1">
                        <img src="{{ asset('backend/images/students/' . $student->image) }}" alt="{{ $student->name }}"
                            height="80" width="80" />
                    </td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->father_name }}</td>
                    <td>{{ $student->mother_name }}</td>
                    <td>{{ $student->course->title }}</td>
                    <td>{{ $student->created_at->format('d M Y') }}</td>
                    <td>
                        <form action="{{ url('/admin/student/status/' . $student->id) }}" method="POST">
                            @csrf
                            <div class="form-check form-switch">
                                @php
                                    $isLocked = $student->lock && $student->lock->is_locked;
                                @endphp

                                <input class="form-check-input" type="checkbox" name="status" onchange="this.form.submit()"
                                    {{ $student->status == 1 ? 'checked' : '' }} {{ $isLocked ? 'disabled' : '' }}>

                                <label class="form-check-label" for="studentStatus{{ $student->id }}"></label>
                            </div>
                        </form>
                    </td>
                    <td>
                        <a href="{{ url('/admin/student/edit/' . $student->id) }}" class="btn btn-primary"><i
                                class="fa-solid fa-pen"></i></a>
                        <a href="{{ url('/admin/student/delete/' . $student->id) }}" class="btn btn-danger"
                            onclick="return confirm('Are you sure delete Student?')"><i class="fa-solid fa-trash"></i></a>
                        <a href="{{ url('/admin/payments/create/' . $student->id) }}" class="btn btn-success">Add Payment</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
