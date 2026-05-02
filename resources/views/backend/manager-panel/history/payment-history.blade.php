@extends('backend.manager-panel.master')
@section('content')
    <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Payment History</h4>
        <span class="badge badge-info">Total Transactions: {{ $payments->count() }}</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="paymentTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>TrxID</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->created_at->format('d M, Y') }}</td>
                        <td>
                            <strong>{{$payment->student->id}}</strong><br>
                            <strong>{{ $payment->student->name }}</strong><br>
                            <small>{{ $payment->student->phone }}</small>
                        </td>
                        <td>{{ $payment->course->title }}</td>
                        <td class="font-weight-bold">৳{{ number_format($payment->amount, 2) }}</td>
                        <td>
                            <span class="text-uppercase text-primary font-weight-bold">
                                {{ $payment->method }}
                            </span>
                        </td>
                        <td><code>{{ $payment->transaction_id }}</code></td>
                        <td>
                            @if($payment->student->status == '0')
                                <span class="badge badge-warning text-dark">Pending</span>
                            @elseif($payment->student->status == '1')
                                <span class="badge badge-success">Success</span>
                            @else
                                <span class="badge badge-danger">Rejected</span>
                            @endif
                        </td>
                        <td>
                                <span class="text-muted"><i class="mdi mdi-check-all"></i> Verified</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection