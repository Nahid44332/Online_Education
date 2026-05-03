@extends('backend.manager-panel.master')

@section('content')
<div class="content-wrapper">
    <!-- পেজ হেডার এবং সার্চ বক্স -->
    <div class="page-header flex-wrap">
        <div class="header-left">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-lock-open-variant"></i>
                </span> Student Lock Management
            </h3>
        </div>
        
        <div class="header-right d-flex align-items-center mt-2 mt-md-0">
            <form action="{{ route('manager.lock.student') }}" method="GET" class="d-flex align-items-center">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="ID or Name..." value="{{ request('search') }}" style="height: 40px; min-width: 200px;">
                    <button class="btn btn-gradient-primary btn-sm px-3" type="submit" style="height: 40px;">
                        <i class="mdi mdi-magnify"></i> Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('manager.lock.student') }}" class="btn btn-light btn-sm d-flex align-items-center px-3" style="height: 40px; border: 1px solid #ddd;">
                            <i class="mdi mdi-close"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- ব্রেডক্রাম্ব -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="border: none; background: transparent; padding-left: 0;">
            <li class="breadcrumb-item active" aria-current="page">
                <i class="mdi mdi-alert-circle-outline text-primary"></i> Action Control 
            </li>
        </ol>
    </nav>

    <!-- টেবিল কার্ড -->
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-1">Student Access List</h4>
                            <p class="text-muted small">Manage student access by locking or unlocking accounts.</p>
                        </div>
                        <span class="badge badge-outline-dark small">{{ count($students) }} Records Found</span>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th class="fw-bold py-3">#</th>
                                    <th class="fw-bold py-3">Student ID</th>
                                    <th class="fw-bold py-3">Name</th>
                                    <th class="fw-bold py-3">Current Status</th>
                                    <th class="fw-bold py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $key => $student)
                                    @php
                                        $lock = $student->lock;
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td class="fw-bold text-primary">#{{ $student->id }}</td>
                                        <td class="text-start">
                                            <div class="d-flex align-items-center">
                                                <i class="mdi mdi-account-circle mdi-24px text-muted me-2"></i>
                                                <span>{{ $student->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($lock && $lock->is_locked)
                                                <label class="badge badge-danger">
                                                    <i class="mdi mdi-lock me-1"></i> Locked
                                                </label>
                                            @else
                                                <label class="badge badge-success">
                                                    <i class="mdi mdi-check-circle me-1"></i> Active
                                                </label>
                                            @endif
                                        </td>
                                        <td>
                                            @if($lock && $lock->is_locked)
                                                <a href="{{ route('manager.student.unlock', $student->id) }}" 
                                                   class="btn btn-sm btn-inverse-success btn-fw">
                                                    <i class="mdi mdi-lock-open-variant me-1"></i> Unlock
                                                </a>
                                            @else
                                                <a href="{{ route('manager.student.lock', $student->id) }}" 
                                                   class="btn btn-sm btn-inverse-danger btn-fw">
                                                    <i class="mdi mdi-lock me-1"></i> Lock Student
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-5">
                                            <i class="mdi mdi-account-off mdi-36px text-muted"></i>
                                            <p class="text-muted mt-2">No students found matching your search.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection