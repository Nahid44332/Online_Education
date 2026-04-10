@extends('backend.teacher-panel.TS-master')
@section('content')
<div class="card shadow border-0 mt-4">
    <div class="card-header bg-primary text-white py-3">
        <h5 class="mb-0"><i class="fas fa-exchange-alt me-2"></i>Point Transaction History</h5>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Date</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $trx)
                <tr>
                    <td class="ps-4">{{ $trx->created_at->format('d M, Y h:i A') }}</td>
                    <td>{{ $trx->description }}</td>
                    <td>
                        @if($trx->type == 'credit')
                            <span class="badge bg-success">Received</span>
                        @else
                            <span class="badge bg-danger">Paid</span>
                        @endif
                    </td>
                    <td class="fw-bold {{ $trx->type == 'credit' ? 'text-success' : 'text-danger' }}">
                        {{ $trx->type == 'credit' ? '+' : '-' }} {{ number_format($trx->amount) }} Pt
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-3">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection