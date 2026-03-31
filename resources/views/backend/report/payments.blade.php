@extends('backend.master')
@section('content')
    <div class="container mt-4">
        <h3>Reports</h3>

       <div class="row mt-4">
    <div class="col-md-3">
        <div class="card p-3 bg-info text-white">
            <h5>Total Payments</h5>
            <h3>{{ $totapayments }}</h3>
        </div>
    </div>
</div>

        <hr>

            <!-- Payment Table -->
            <h4 class="mt-4">Payment List</h4>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <td>{{ $loop->index+1}}</td>
                            <td>{{ $payment->student->name ?? 'N/A' }}</td>
                            <td>{{ $payment->course->title ?? 'N/A' }}</td>
                            <td>{{ $payment->amount }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
