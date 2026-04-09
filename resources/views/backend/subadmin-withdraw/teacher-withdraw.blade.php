@extends('backend.master')
@section('content')
    <div class="container-fluid px-4 mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white py-3">
                <h5 class="mb-0 font-weight-bold small-caps">Teacher Withdrawal Requests</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Teacher Name</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Account Info</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($withdrawals as $item)
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-bold">{{ $item->teacher->subadmin->name ?? 'Unknown' }}</span>
                                    </td>
                                    <td><span class="badge bg-primary px-3">{{ number_format($item->amount) }} Points</span>
                                    </td>
                                    <td>{{ $item->method }}</td>
                                    <td>{{ $item->account_details }}</td>
                                    <td>
                                        @if ($item->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @else
                                            <span class="badge bg-success">Approved</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($item->status == 'pending')
                                            <div class="d-flex justify-content-center gap-2">
                                                <form action="{{ route('admin.withdraw.approve', $item->id) }}"
                                                    method="POST" onsubmit="return confirm('পেমেন্ট কি করা হয়েছে?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success shadow-sm">
                                                        <i class="fas fa-check-circle"></i>
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.withdraw.reject', $item->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('আপনি কি নিশ্চিত যে এটি রিজেক্ট করবেন?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger shadow-sm">
                                                        <i class="fas fa-times-circle"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($item->status == 'approved')
                                            <span class="badge bg-light text-success border border-success">Completed</span>
                                        @else
                                            <span class="badge bg-light text-danger border border-danger">Rejected</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">কোনো রিকোয়েস্ট নেই।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
