@extends('backend.manager-panel.master')
@section('content')
    <div class="card">
    <div class="card-header">
        <h4 class="card-title">Withdrawal Requests & Status</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Student Info</th>
                        <th>Amount</th>
                        <th>Method & Account</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($withdrawals as $withdraw)
                    <tr>
                        <td>{{ $withdraw->created_at->format('d M, Y') }}</td>
                        <td>
                            <strong>{{ $withdraw->student->id }}</strong><br>
                            <strong>{{ $withdraw->student->name }}</strong><br>
                            <small>{{ $withdraw->student->email }}</small>
                        </td>
                        <td class="text-danger font-weight-bold">
                            ৳{{ number_format($withdraw->points, 2) }}
                        </td>
                        <td>
                            <span class="badge badge-outline-dark">{{ strtoupper($withdraw->method) }}</span><br>
                            <code>{{ $withdraw->account_number }}</code>
                        </td>
                        <td>
                            @if($withdraw->status == 'pending')
                                <label class="badge badge-warning">Pending</label>
                            @elseif($withdraw->status == 'approved')
                                <label class="badge badge-success">Paid / Approved</label>
                            @else
                                <label class="badge badge-danger">Rejected</label>
                            @endif
                        </td>
                        <td>
                            <!-- ম্যানেজার যেহেতু কিছু করবে না, সে শুধু হিস্টোরি দেখবে -->
                            <button class="btn btn-sm btn-outline-info" title="View Transaction Log">
                                <i class="mdi mdi-information"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection