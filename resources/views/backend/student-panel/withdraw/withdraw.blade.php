@extends('backend.student-panel.st-master')

@section('content')
<div class="container mt-4">

    <h3>Withdraw</h3>

    <div class="card p-3 mb-3">
        <h5>Your Points : {{ $student->points }}</h5>
    </div>

    <form action="{{ route('student.withdraw') }}" method="POST">
        @csrf

        <div class="mb-2">
            <label>Points</label>
            <input type="number" name="points" class="form-control">
        </div>

        <div class="mb-2">
            <label>Method</label>
            <select name="method" class="form-control">
                <option value="bkash">Bkash</option>
                <option value="nagad">Nagad</option>
            </select>
        </div>

        <div class="mb-2">
            <label>Account Number</label>
            <input type="text" name="account_number" class="form-control">
        </div>

        <button class="btn btn-success mt-2">Withdraw Request</button>
    </form>

    <hr>

    <h4>Withdraw History</h4>

    <!-- Responsive Table Wrapper -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Points</th>
                    <th>Method</th>
                    <th>Account</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($withdraws as $withdraw)
                <tr>
                    <td>{{ $withdraw->id }}</td>
                    <td>{{ $withdraw->points }}</td>
                    <td>{{ $withdraw->method }}</td>
                    <td>{{ $withdraw->account_number }}</td>
                    <td>
                        @if ($withdraw->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($withdraw->status == 'approved')
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection