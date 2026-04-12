@extends('backend.team-leader-panel.tl-master')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0 text-dark fw-bold">
                        <i class="mdi mdi-history me-2 text-primary"></i>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light text-center">
                                <tr>
                                    <th>Date</th>
                                    <th>Method</th>
                                    <th>Account</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse($withdraws as $row)
                                    <tr>
                                        <td>{{ date('d M, Y', strtotime($row->created_at)) }}</td>
                                        <td><span class="badge badge-outline-dark">{{ $row->method }}</span></td>
                                        <td>{{ $row->account_details }}</td>
                                        <td class="fw-bold text-dark">৳ {{ number_format($row->amount, 2) }}</td>
                                        <td>
                                            @if($row->status == 'pending')
                                                <span class="badge bg-warning text-dark px-3" style="border-radius: 20px;">
                                                    <i class="mdi mdi-clock-outline me-1"></i> Pending
                                                </span>
                                            @elseif($row->status == 'approved')
                                                <span class="badge bg-success text-white px-3" style="border-radius: 20px;">
                                                    <i class="mdi mdi-check-circle me-1"></i> Approved
                                                </span>
                                            @else
                                                <span class="badge bg-danger text-white px-3" style="border-radius: 20px;">
                                                    <i class="mdi mdi-close-circle me-1"></i> Rejected
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">কোনো উইথড্র হিস্টোরি পাওয়া যায়নি।</td>
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