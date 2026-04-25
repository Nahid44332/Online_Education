@extends('backend.counsellor-panel.cs-master')
@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 text-dark fw-bold">
                        <i class="mdi mdi-history me-2 text-success"></i>পেমেন্ট ট্রানজেকশন হিস্টোরি
                    </h4>
                    {{-- অপশনাল: কাউন্সেলরের বর্তমান ব্যালেন্স দেখানোর জন্য --}}
                    @if(isset($counsellor))
                    <span class="badge bg-soft-success text-success border border-success px-3 py-2">
                        ব্যালেন্স: ৳ {{ number_format($counsellor->points, 2) }}
                    </span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light text-center">
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse($transactions as $trx)
                                    <tr>
                                        <td>{{ date('d M, Y', strtotime($trx->created_at)) }}</td>
                                        <td class="text-start">{{ $trx->description }}</td>
                                        <td>
                                            <span class="fw-bold {{ $trx->type == 'credit' ? 'text-success' : 'text-danger' }}">
                                                {{ $trx->type == 'credit' ? '+' : '-' }} ৳{{ number_format($trx->amount, 2) }}
                                            </span>
                                        </td>
                                        <td>
                                            <label class="badge {{ $trx->type == 'credit' ? 'badge-outline-success' : 'badge-outline-danger' }}">
                                                {{ strtoupper($trx->type) }}
                                            </label>
                                        </td>
                                        <td>
                                            <span class="badge bg-success text-white px-3" style="border-radius: 20px;">
                                                <i class="mdi mdi-check-circle me-1"></i> Success
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">এখনো কোনো ট্রানজেকশন হয়নি।</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- পেজিনেশন যদি থাকে --}}
                    @if(method_exists($transactions, 'links'))
                    <div class="d-flex justify-content-center mt-4">
                        {{ $transactions->links('pagination::bootstrap-5') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-success { background-color: #e8f9f0 !important; }
    .badge-outline-success { border: 1px solid #1bcfb4; color: #1bcfb4; background: transparent; }
    .badge-outline-danger { border: 1px solid #fe7c96; color: #fe7c96; background: transparent; }
</style>
@endsection