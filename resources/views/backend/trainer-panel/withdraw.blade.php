@extends('backend.trainer-panel.tr-master')
@section('content')
    <div class="container-fluid mt-4 pb-5">
        {{-- হেডার --}}
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h3 class="fw-bold text-dark"><i class="fa-solid fa-money-bill-transfer me-2 text-primary"></i>Withdraw Funds
                </h3>
                <p class="text-muted small mb-0">Request a withdrawal of your earned balance.</p>
            </div>
        </div>

        <div class="row g-4">
            {{-- বাম পাশ: ব্যালেন্স ও ফর্ম --}}
            <div class="col-lg-5">
                {{-- কারেন্ট ব্যালেন্স কার্ড --}}
                <div class="card border-0 shadow-sm bg-primary text-white mb-4" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase small fw-bold opacity-75">Available Balance</h6>
                                <h1 class="mb-0 fw-bold">৳ {{ number_format($current_points ?? 0, 2) }}</h1>
                            </div>
                            <i class="fa-solid fa-wallet fs-1 opacity-25"></i>
                        </div>
                    </div>
                </div>

                {{-- উইথড্র ফর্ম --}}
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-paper-plane me-2 text-primary"></i>New Request</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('trainer.withdraw.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Withdraw Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">৳</span>
                                    <input type="number" name="amount" class="form-control" placeholder="Enter amount"
                                        min="500" required>
                                </div>
                                <small class="text-muted">Minimum withdrawal: ৳ 500.00</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Payment Method</label>
                                <select name="method" class="form-select" required>
                                    <option value="" selected disabled>Select Method</option>
                                    <option value="bkash">bKash</option>
                                    <option value="nagad">Nagad</option>
                                    <option value="bank">Bank Transfer</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Account Details</label>
                                <textarea name="account_details" class="form-control" rows="3"
                                    placeholder="Enter Mobile Number or Bank Details (AC No, Branch, etc.)" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                                Submit Request
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ডান পাশ: উইথড্র হিস্ট্রি --}}
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i>Recent
                            Withdrawals</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light small text-uppercase">
                                    <tr>
                                        <th class="ps-3">Date</th>
                                        <th>Amount</th>
                                        <th>Method</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- লুপ দিয়ে ডাটা আসবে --}}
                                    @forelse($withdrawals ?? [] as $row)
                                        <tr>
                                            <td class="ps-3 small text-muted">
                                                {{ \Carbon\Carbon::parse($row->created_at)->format('d M, Y') }}
                                            </td>
                                            <td class="fw-bold">৳ {{ number_format($row->amount, 0) }}</td>
                                            <td class="text-capitalize">{{ $row->method }}</td>
                                            <td class="text-center">
                                                @if ($row->status == 'pending')
                                                    <span
                                                        class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2">Pending</span>
                                                @elseif($row->status == 'approved')
                                                    <span
                                                        class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">Success</span>
                                                @else
                                                    <span
                                                        class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2">Rejected</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5 text-muted">
                                                <i class="fa-solid fa-folder-open d-block mb-2 fs-2 opacity-25"></i>
                                                No withdrawal history found.
                                            </td>
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

    <style>
        .bg-primary {
            background: linear-gradient(45deg, #0d6efd, #0dcaf0) !important;
        }

        .bg-warning-subtle {
            background-color: #fff3cd !important;
            color: #856404 !important;
        }

        .bg-success-subtle {
            background-color: #d1e7dd !important;
            color: #0f5132 !important;
        }

        .bg-danger-subtle {
            background-color: #f8d7da !important;
            color: #842029 !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0d6efd;
            box-shadow: none;
        }

        .card {
            transition: 0.3s;
        }
    </style>
@endsection
