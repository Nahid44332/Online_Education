@extends('backend.master')
@section('content')
    <div class="container-fluid px-4 mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white py-3">
                <h5 class="mb-0 font-weight-bold small-caps">Team Leader Withdrawal Requests</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Team Leader Name</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Account Info</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $row)
                                @php 
                                    // টিম লিডারের নাম বের করার জন্য
                                    $tl = DB::table('team_leaders')->where('id', $row->team_leader_id)->first(); 
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-bold text-dark">{{ $tl->name ?? 'Unknown TL' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary px-3">৳ {{ number_format($row->amount) }}</span>
                                    </td>
                                    <td>{{ $row->method }}</td>
                                    <td>{{ $row->account_details }}</td>
                                    <td>
                                        @if ($row->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($row->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($row->status == 'pending')
                                            <div class="d-flex justify-content-center gap-2">
                                                {{-- এপ্রুভ বাটন --}}
                                                <form action="{{ route('admin.team_leader.withdraw.approve', $row->id) }}"
                                                    method="POST" onsubmit="return confirm('পেমেন্ট কি করা হয়েছে?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success shadow-sm">
                                                        <i class="fas fa-check-circle"></i> Approve
                                                    </button>
                                                </form>

                                                {{-- রিজেক্ট বাটন (যদি প্রয়োজন হয়) --}}
                                                {{-- <form action="#" method="POST" onsubmit="return confirm('রিজেক্ট করবেন?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger shadow-sm">
                                                        <i class="fas fa-times-circle"></i>
                                                    </button>
                                                </form> --}}
                                            </div>
                                        @elseif($row->status == 'approved')
                                            <span class="badge bg-light text-success border border-success px-3">
                                                <i class="fas fa-check"></i> Completed
                                            </span>
                                        @else
                                            <span class="badge bg-light text-danger border border-danger px-3">
                                                <i class="fas fa-times"></i> Rejected
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">টিম লিডারদের কোনো উইথড্র রিকোয়েস্ট নেই।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection