@extends('backend.master')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark"><i class="fa-solid fa-file-invoice-dollar me-2"></i>Payment History</h3>
        <button class="btn btn-outline-info btn-sm text-dark shadow-sm" onclick="window.print()">
            <i class="fa-solid fa-print me-1"></i> Print Statement
        </button>
    </div>

    {{-- পেমেন্ট স্ট্যাটাস কার্ড --}}
    <div class="row g-3">
        <div class="col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm bg-info text-white h-100" style="border-radius: 12px;">
                <div class="card-body p-4 text-center">
                    <i class="fa-solid fa-wallet mb-2 opacity-50" style="font-size: 2rem;"></i>
                    <h6 class="text-uppercase small fw-bold mb-1">Total Collections</h6>
                    <h2 class="mb-0 fw-bold">{{ $totapayments }}</h2>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4 opacity-25">

    {{-- পেমেন্ট টেবিল সেকশন --}}
    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-info"><i class="fa-solid fa-money-check-dollar me-2"></i>Transaction List</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3" style="width: 80px;">SL</th>
                            <th class="text-start">Student Name</th>
                            <th class="text-start">Enrolled Course</th>
                            <th>Amount</th>
                            <th class="pe-3">Payment Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $payment)
                            <tr>
                                <td class="ps-3">{{ $loop->iteration }}</td>
                                <td class="text-start">
                                    <span class="fw-bold text-dark d-block">{{ $payment->student->name ?? 'N/A' }}</span>
                                    <small class="text-muted">ID: #{{ $payment->student->id ?? '---' }}</small>
                                </td>
                                <td class="text-start">
                                    <span class="badge bg-info-subtle text-info border border-info-subtle px-2">
                                        {{ $payment->course->title ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-success" style="font-size: 1.1rem;">
                                        ৳{{ number_format($payment->amount, 0) }}
                                    </span>
                                </td>
                                <td class="pe-3 text-muted">
                                    <i class="fa-regular fa-calendar-check me-1 small"></i>
                                    {{ \Carbon\Carbon::parse($payment->created_at)->format('d M, Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-magnifying-glass-dollar d-block mb-2 fs-2 opacity-25"></i>
                                    No transactions found yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3 border-top-0">
            <div class="alert alert-light border-0 mb-0 small text-center text-muted">
                <i class="fa-solid fa-circle-info me-1"></i> 
                This report is automatically generated and includes all confirmed payments.
            </div>
        </div>
    </div>
</div>

<style>
    .card { transition: all 0.3s ease; }
    .card:hover { transform: translateY(-3px); }
    .bg-info-subtle { background-color: #e1f5fe !important; }
    .table-responsive { border-radius: 0 0 12px 12px; }
    @media print {
        .btn, hr, .card-footer { display: none !important; }
        .card { box-shadow: none !important; border: 1px solid #eee !important; }
        .text-success { color: #000 !important; }
    }
</style>
@endsection