@extends('backend.teacher-panel.TS-master')
@section('content')

<div class="container-fluid px-4 mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold"><i class="fas fa-money-check-alt me-2"></i>Withdraw Points</h5>
                    <span class="badge bg-light text-primary px-3 py-2">
                        <i class="fas fa-coins me-1"></i> Available Balance: {{ number_format($teacher->points) }}
                    </span>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('teacher.withdraw.store') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Withdraw Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-hand-holding-usd text-primary"></i></span>
                                    <input type="number" name="amount" class="form-control" 
                                           max="{{ $teacher->points }}" min="1" required 
                                           placeholder="কত পয়েন্ট তুলবেন?">
                                </div>
                                <div class="form-text text-muted small">সর্বোচ্চ {{ $teacher->points }} পয়েন্ট তুলতে পারবেন।</div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Payment Method</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-university text-primary"></i></span>
                                    <select name="method" class="form-select" required>
                                        <option value="" selected disabled>সিলেক্ট করুন</option>
                                        <option value="Bkash">Bkash</option>
                                        <option value="Nagad">Nagad</option>
                                        <option value="Rocket">Rocket</option>
                                        <option value="Bank">Bank Transfer</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Account Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-phone-alt text-primary"></i></span>
                                    <input type="text" name="account_details" class="form-control" 
                                           required placeholder="নাম্বার বা একাউন্ট তথ্য দিন">
                                </div>
                                <div class="form-text text-muted small">বিকাশ/নগদ হলে পার্সোনাল নাম্বার দিন।</div>
                            </div>
                        </div>

                        <hr class="my-4 opacity-25">

                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-light me-2 px-4">Reset</button>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                <i class="fas fa-paper-plane me-2"></i>Send Withdraw Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="mt-3 text-muted small">
                <i class="fas fa-info-circle me-1"></i> আপনার রিকোয়েস্ট পাঠানোর পর অ্যাডমিন যাচাই করে পেমেন্ট সম্পন্ন করবেন। সাধারণত ২৪-৪৮ ঘণ্টার মধ্যে পেমেন্ট পাওয়া যায়।
            </div>
        </div>

        <div class="row justify-content-center mt-5">
    <div class="col-lg-10">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 fw-bold text-dark"><i class="fas fa-history me-2"></i>Withdrawal History</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Date</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Account</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($withdrawals as $history)
                            <tr>
                                <td class="ps-4">{{ $history->created_at->format('d M, Y') }}</td>
                                <td class="fw-bold">{{ number_format($history->amount) }} Pt</td>
                                <td>{{ $history->method }}</td>
                                <td>{{ $history->account_details }}</td>
                                <td class="text-center">
                                    @if($history->status == 'pending')
                                        <span class="badge bg-warning text-dark px-3">Pending</span>
                                    @elseif($history->status == 'approved')
                                        <span class="badge bg-success px-3">Approved</span>
                                    @else
                                        <span class="badge bg-danger px-3">Rejected</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">কোনো উইথড্র রেকর্ড পাওয়া যায়নি।</td>
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
</div>

@endsection