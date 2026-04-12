@extends('backend.team-leader-panel.tl-master')
@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0 text-dark fw-bold">
                        <i class="mdi mdi-history me-2 text-primary"></i>Transaction History
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light text-center">
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Catagory</th>
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
                                        <td colspan="5" class="text-center py-4 text-muted">এখনো কোনো ট্রানজেকশন হয়নি।</td>
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