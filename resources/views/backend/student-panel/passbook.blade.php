@extends('backend.student-panel.st-master')
@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    
                    {{-- হেডার সেকশন --}}
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                        <div>
                            <h3 class="card-title text-dark fw-bold mb-1">
                                <i class="mdi mdi-book-open-page-variant text-primary me-2"></i> ডিজিটাল পাসবুক
                            </h3>
                            <p class="text-muted small mb-0">আপনার সকল ক্রেডিট ও ডেবিট লেনদেনের বিস্তারিত ইতিহাস</p>
                        </div>
                        <div class="mt-3 mt-md-0">
                            <a href="{{ route('student.passbook.download') }}" class="btn btn-gradient-danger btn-icon-text shadow-sm" style="border-radius: 10px;">
                                <i class="mdi mdi-file-pdf btn-icon-prepend"></i> Download PDF
                            </a>
                        </div>
                    </div>

                    {{-- ট্রানজ্যাকশন টেবিল --}}
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light">
                                <tr class="text-dark">
                                    <th class="border-0 py-3">তারিখ</th>
                                    <th class="border-0 py-3">বিবরণ (Description)</th>
                                    <th class="border-0 py-3">টাইপ</th>
                                    <th class="border-0 py-3">পরিমাণ (Points)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($all_history as $item)
                                    <tr>
                                        <td class="text-muted">
                                            <i class="mdi mdi-calendar-clock me-1"></i> {{ date('d M, Y', strtotime($item->created_at)) }}
                                        </td>
                                        <td>
                                            <span class="fw-bold text-dark">{{ $item->reason }}</span>
                                            @if($item->reason == 'Gift/Special Reward 🎁')
                                                <br><small class="text-info">Received from Authority</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->type == 'Credit')
                                                <label class="badge badge-gradient-success px-3" style="font-size: 11px;">
                                                    <i class="mdi mdi-arrow-bottom-left me-1"></i> Credit
                                                </label>
                                            @else
                                                <label class="badge badge-gradient-danger px-3" style="font-size: 11px;">
                                                    <i class="mdi mdi-arrow-top-right me-1"></i> Debit
                                                </label>
                                            @endif
                                        </td>
                                        <td>
                                            <h5 class="{{ $item->type == 'Credit' ? 'text-success' : 'text-danger' }} fw-bold mb-0">
                                                {{ $item->type == 'Credit' ? '+' : '-' }} {{ number_format($item->amount, 0) }}
                                            </h5>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="mdi mdi-information-outline fs-1"></i>
                                                <p class="mt-2">এখনো কোনো লেনদেন হয়নি!</p>
                                            </div>
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
    /* টেবিল রো তে হালকা হোভার ইফেক্ট */
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.3s ease;
    }
    .badge {
        border-radius: 5px;
    }
    .btn-gradient-danger {
        background: linear-gradient(to right, #ff416c, #ff4b2b);
        border: none;
        color: white;
    }
</style>
@endsection