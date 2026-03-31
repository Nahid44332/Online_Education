@extends('backend.master')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold text-dark">🔐 Student Lock Management</h4>
            <p class="text-muted mb-0">Paid but inactive students can be locked or unlocked from here.</p>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h6 class="mb-0 fw-semibold">Student Lock List</h6>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Lock Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($students as $key => $student)
                        @php
                            $lock = $student->lock;
                        @endphp
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $student->id }}</td>
                            <td>{{ $student->name }}</td>
                            <td>
                                @if($lock && $lock->is_locked)
                                    <span class="badge bg-danger">Locked</span>
                                @else
                                    <span class="badge bg-success">Unlocked</span>
                                @endif
                            </td>
                            <td>
                                @if($lock && $lock->is_locked)
                                    <a href="{{ route('student.unlock', $student->id) }}" class="btn btn-sm btn-success">
                                        🔓 Unlock
                                    </a>
                                @else
                                    <a href="{{ route('student.lock', $student->id) }}" class="btn btn-sm btn-danger">
                                        🔒 Lock
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection
