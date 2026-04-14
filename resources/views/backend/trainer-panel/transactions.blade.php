@extends('backend.trainer-panel.tr-master')
@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card shadow-sm border-0" style="border-radius: 10px;">
                <div class="card-body">
                    <h4 class="card-title fw-bold mb-4">
                        <i class="mdi mdi-history text-primary"></i> Transaction History
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
                                    <td>{{ date('d M, Y', strtotime($trx->created_at)) }}</td>
                                    <td>{{ $trx->description }}</td>
                                    <td>
                                        <h5 class="fw-bold {{ $trx->type == 'credit' ? 'text-success' : 'text-danger' }}">
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
                                    <td colspan="5" class="text-center py-5 text-muted">No transactions found!</td>
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