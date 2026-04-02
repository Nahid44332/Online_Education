@extends('backend.master')

@section('content')

<div class="container mt-4">

    <h3>Withdraw Requests</h3>

    <!-- Responsive Table Wrapper -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Student</th>
                    <th>Points</th>
                    <th>Method</th>
                    <th>Account Number</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($withdraws as $withdraw)
                <tr>
                    <td>{{ $withdraw->id }}</td>
                    <td>{{ $withdraw->student->name }} (ID: {{ $withdraw->student->id }})</td>
                    <td>{{ $withdraw->points }}</td>
                    <td>{{ $withdraw->method }}</td>
                    <td>{{ $withdraw->account_number }}</td>
                    <td>
                        @if($withdraw->status=='pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($withdraw->status=='approved')
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>
                    <td>
                        @if($withdraw->status=='pending')
                            <a href="{{ url('/admin/withdraw/approve/'.$withdraw->id) }}" class="btn btn-success btn-sm">Approve</a>
                            <a href="{{ url('/admin/withdraw/reject/'.$withdraw->id) }}" class="btn btn-danger btn-sm">Reject</a>
                        @else
                            <span class="text-muted">No Action</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection