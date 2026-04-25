@extends('backend.master')

@section('content')
    <div class="app-content-header py-3">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold">Student List</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Student List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-body p-0">
                {{-- টেবিলকে রেসপনসিভ করার মূল অংশ --}}
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-nowrap">SL</th>
                                <th class="text-nowrap">Student ID</th>
                                <th class="text-nowrap">Student</th>
                                <th class="text-nowrap">First name</th>
                                <th class="text-nowrap">Father Name</th>
                                <th class="text-nowrap">Mother Name</th>
                                <th class="text-nowrap">Course</th>
                                <th class="text-nowrap">Admission Date</th>
                                <th class="text-nowrap">Status</th>
                                <th class="text-nowrap text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td class="fw-bold">#{{ $student->id }}</td>
                                    <td class="py-2">
                                        <img src="{{ asset('backend/images/students/' . $student->image) }}" 
                                             alt="{{ $student->name }}"
                                             class="img-thumbnail"
                                             style="height: 50px; width: 50px; object-fit: cover; border-radius: 50%;">
                                    </td>
                                    <td class="text-nowrap">{{ $student->name }}</td>
                                    <td class="text-nowrap">{{ $student->father_name }}</td>
                                    <td class="text-nowrap">{{ $student->mother_name }}</td>
                                    <td>
                                        <span class="badge bg-info text-dark">{{ $student->course->title }}</span>
                                    </td>
                                    <td class="text-nowrap">{{ $student->created_at->format('d M Y') }}</td>
                                    <td>
                                        <form action="{{ url('/admin/student/status/' . $student->id) }}" method="POST">
                                            @csrf
                                            <div class="form-check form-switch">
                                                @php
                                                    $isLocked = $student->lock && $student->lock->is_locked;
                                                @endphp
                                                <input class="form-check-input" type="checkbox"  onclick="return confirm('মামা, তার কি পেমেন্ট করা সফল হয়েছে     ?')" role="switch" 
                                                       onchange="this.form.submit()"
                                                       {{ $student->status == 1 ? 'checked' : '' }} 
                                                       {{ $isLocked ? 'disabled' : '' }}>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ url('/admin/student/edit/' . $student->id) }}" class="btn btn-primary" title="Edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <a href="{{ url('/admin/student/delete/' . $student->id) }}" class="btn btn-danger" 
                                               onclick="return confirm('Are you sure delete Student?')" title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                            <a href="{{ url('/admin/payments/create/' . $student->id) }}" class="btn btn-success text-nowrap">
                                                Add Payment
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- কিছু কাস্টম সিএসএস যাতে মোবাইল ভিউতে বাটনগুলো সুন্দর দেখায় --}}
    <style>
        .table-responsive {
            border: none;
        }
        .text-nowrap {
            white-space: nowrap;
        }
        .btn-group-sm > .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
    </style>
@endsection