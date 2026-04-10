@extends('backend.student-panel.st-master')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="mdi mdi-attachment"></i> My Academic Results</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>SL</th>
                                    <th>Course Name</th>
                                    <th>Total Marks</th>
                                    <th>Obtained Marks</th>
                                    <th>Grade</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($results as $result)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $result->student->course->title ?? 'N/A' }}</td>
                                        <td>{{ $result->total_marks }}</td>
                                        <td>{{ $result->marks_obtained }}</td>
                                        <td>
                                            <span class="badge {{ $result->grade == 'F' ? 'bg-danger' : 'bg-primary' }}">
                                                {{ $result->grade ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($result->status == 'Pass')
                                                <span class="badge bg-success">Passed</span>
                                            @else
                                                <span class="badge bg-danger">Failed</span>
                                            @endif
                                        </td>
                                        <td>{{ $result->created_at->format('d M, Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">আপনার কোনো রেজাল্ট এখনও পাবলিশ করা হয়নি।</td>
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