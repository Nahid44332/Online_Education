@extends('backend.counsellor-panel.cs-master')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-white py-3 text-center">
                    <h4 class="mb-0 text-dark fw-bold">
                        <i class="mdi mdi-cash-withdrawal me-2 text-success"></i>Withdraw Request
                    </h4>
                    <p class="text-muted small mb-0">আপনার উপার্জিত টাকা উত্তোলন করুন</p>
                </div>
                <div class="card-body p-4">
                    
                    {{-- সাকসেস বা এরর মেসেজ --}}
                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm mb-4" role="alert">
                            <i class="mdi mdi-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger border-0 shadow-sm mb-4" role="alert">
                            <i class="mdi mdi-alert-circle me-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('counsellor.withdraw.store') }}" method="POST">
                        @csrf
                        
                        {{-- বর্তমান ব্যালেন্স দেখানোর সেকশন --}}
                        <div class="p-3 mb-4 text-center" style="background: #f0fdf4; border-radius: 10px; border: 1px dashed #22c55e;">
                            <span class="text-muted d-block small">Current Balance</span>
                            <h3 class="text-success fw-bold mb-0">৳ {{ number_format($counsellor->points ?? 0, 2) }}</h3>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold small mb-2">Amount (টাকার পরিমাণ)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">৳</span>
                                <input type="number" name="amount" class="form-control border-start-0 ps-0" min="100" placeholder="উদা: ৫০০" required>
                            </div>
                            <small class="text-muted">সর্বনিম্ন উত্তোলন ১০০ টাকা</small>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold small mb-2">Payment Method</label>
                            <select name="method" class="form-select form-control" required>
                                <option value="" selected disabled>Select Method</option>
                                <option value="Bkash">বিকাশ (Bkash)</option>
                                <option value="Nagad">নগদ (Nagad)</option>
                                <option value="Rocket">রকেট (Rocket)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold small mb-2">Account Number (বিকাশ/নগদ/রকেট নম্বর)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="mdi mdi-cellphone-iphone"></i></span>
                                <input type="text" name="account_details" class="form-control border-start-0 ps-0" placeholder="01XXXXXXXXX" required>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg fw-bold shadow-sm" style="border-radius: 10px;">
                                <i class="mdi mdi-send me-2"></i> Request Withdraw
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-light py-3 text-center" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                    <p class="mb-0 small text-muted">পেমেন্ট প্রসেস হতে ২৪-৪৮ ঘণ্টা সময় লাগতে পারে।</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection