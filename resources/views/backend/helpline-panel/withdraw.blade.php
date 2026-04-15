@extends('backend.helpline-panel.help-master')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-5 grid-margin stretch-card">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-body">
                    <h4 class="card-title text-primary mb-4">
                        <i class="mdi mdi-cash-multiple"></i> Withdraw Money
                    </h4>
                    
                    <div class="alert alert-info text-center py-2" style="border-radius: 10px;">
                        ব্যালেন্স: <b>৳ {{ Auth::guard('subadmin')->user()->helpline->points }}</b>
                    </div>

                    <form action="{{ route('helpline.withdraw.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="fw-bold">Amount</label>
                            <input type="number" name="amount" class="form-control" placeholder="0.00" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="fw-bold">Method</label>
                            <select name="method" class="form-control text-dark">
                                <option value="Bkash">Bkash</option>
                                <option value="Nagad">Nagad</option>
                                <option value="Rocket">Rocket</option>
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label class="fw-bold">Account Details</label>
                            <input type="text" name="account_details" class="form-control" placeholder="017XXXXXXXX" required>
                        </div>

                        <button type="submit" class="btn btn-gradient-primary w-100 py-3 fw-bold">Request Withdraw</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7 grid-margin stretch-card">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-body">
                    <h4 class="card-title text-primary mb-4">
                        <i class="mdi mdi-format-list-bulleted"></i> My Withdrawals
                    </h4>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($withdrawals as $row)
                                <tr>
                                    <td>{{ date('d M, Y', strtotime($row->created_at)) }}</td>
                                    <td class="fw-bold">৳{{ $row->amount }}</td>
                                    <td>{{ $row->method }}</td>
                                    <td>
                                        @if($row->status == 'pending')
                                            <label class="badge badge-warning">Pending</label>
                                        @elseif($row->status == 'approved')
                                            <label class="badge badge-success">Approved</label>
                                        @else
                                            <label class="badge badge-danger">Rejected</label>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">কোনো রিকোয়েস্ট পাওয়া যায়নি।</td>
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