@extends('backend.master')
@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h4 class="text-primary fw-bold">Assign Students to: <span class="text-dark">{{ $counsellor->name }}</span></h4>
            <a href="{{ route('admin.counsellor') }}" class="btn btn-secondary btn-sm">Back to List</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover text-center">
                    <thead class="bg-light">
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Applied Course</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($unassigned_students as $student)
                        <tr>
                            <td>#{{ $student->id }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->phone }}</td>
                            <td>{{ $student->course->title ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('admin.counsellor.assign.process', [$counsellor->id, $student->id]) }}" 
                                   class="btn btn-sm btn-success text-white" 
                                   onclick="return confirm('মামা, এই স্টুডেন্টকে কি কাউন্সেলরের আন্ডারে পাঠাবেন?')">
                                    <i class="mdi mdi-check-circle"></i> Assign
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-5 text-muted">মামা, এই মুহূর্তে কোনো ফ্রি স্টুডেন্ট নেই!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection