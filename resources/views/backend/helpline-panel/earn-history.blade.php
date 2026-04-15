@extends('backend.helpline-panel.help-master')
@section('content')
    <div class="content-wrapper">
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card shadow-sm border-0" style="border-radius: 10px;">
                    <div class="card-body">
                        <h4 class="card-title fw-bold mb-4">
                            <i class="mdi mdi-history text-primary"></i> Earnings & Transaction History
                        </h4>
                        
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="text-muted">
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $trx)
                                    <tr>
                                        {{-- ডেট ফরম্যাট আপনার ট্রেইনার প্যানেলের মতো --}}
                                        <td>{{ date('d M, Y', strtotime($trx->created_at)) }}</td>
                                        
                                        <td>
                                            <span class="text-dark">{{ $trx->description }}</span>
                                        </td>
                                        
                                        <td>
                                            <h5 class="fw-bold {{ $trx->type == 'credit' ? 'text-success' : 'text-danger' }} mb-0">
                                                {{ $trx->type == 'credit' ? '+' : '-' }} ৳{{ number_format($trx->amount, 2) }}
                                            </h5>
                                        </td>
                                        
                                        <td>
                                            <span class="badge {{ $trx->type == 'credit' ? 'badge-outline-success' : 'badge-outline-danger' }} px-3">
                                                {{ strtoupper($trx->type) }}
                                            </span>
                                        </td>
                                        
                                        <td>
                                            <label class="badge badge-success bg-gradient-success text-white px-3" style="border-radius: 20px;">
                                                <i class="mdi mdi-check-circle"></i> Success
                                            </label>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="mdi mdi-alert-circle-outline mdi-36px d-block mb-2"></i>
                                            মামা, এখনো কোনো ট্রানজেকশন ডাটা পাওয়া যায়নি!
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
</div>
@endsection