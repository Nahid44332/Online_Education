@extends('backend.manager-panel.master')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-cash-refund"></i>
            </span> Subadmin Withdrawal History
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                </li>
            </ul>
        </nav>
    </div>

    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title">All Withdrawal Logs</h4>
                        <button type="button" class="btn btn-outline-primary btn-sm btn-icon-text" onclick="window.print()">
                            <i class="mdi mdi-printer btn-icon-prepend"></i> Print Report 
                        </button>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="font-weight-bold"> Date </th>
                                    <th class="font-weight-bold"> Subadmin Details </th>
                                    <th class="font-weight-bold"> Amount </th>
                                    <th class="font-weight-bold"> Method & Account </th>
                                    <th class="font-weight-bold"> Status </th>
                                </tr>
                            </thead>
                           <tbody>
    @forelse($withdrawals as $withdraw)
    @php
        // কার ডাটা আছে সেটা খুঁজে বের করা (মামা স্পেশাল লজিক)
        $subadminData = null;
        $position = '';

        if($withdraw->teacher_id) {
            $subadminData = $withdraw->teacher;
            $position = 'Teacher';
        } elseif($withdraw->team_leader_id) {
            $subadminData = $withdraw->team_leader;
            $position = 'Team Leader';
        } elseif($withdraw->trainer_id) {
            $subadminData = $withdraw->trainer;
            $position = 'Trainer';
        } elseif($withdraw->helpline_id) {
            $subadminData = $withdraw->helpline;
            $position = 'Helpline';
        } elseif($withdraw->counsellor_id) {
            $subadminData = $withdraw->counsellor;
            $position = 'Counsellor';
        }
    @endphp
    <tr>
        <td class="text-muted">
            <i class="mdi mdi-calendar-clock me-1"></i> {{ $withdraw->created_at->format('d M, Y') }}
        </td>
        <td>
            <div class="d-flex align-items-center">
                <div class="bg-soft-primary p-2 rounded text-primary text-center me-3" style="width: 40px;">
                    {{ strtoupper(substr($subadminData->name ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <span class="d-block font-weight-bold">{{ $subadminData->name ?? 'Unknown User' }}</span>
                    <span class="badge badge-outline-secondary badge-pill mt-1" style="font-size: 10px;">{{ $position }}</span>
                </div>
            </div>
        </td>
        <td>
            <span class="text-danger font-weight-bold">
                ৳ {{ number_format($withdraw->amount, 0) }}
            </span>
        </td>
        <td>
            <div class="d-flex flex-column">
                <span class="text-uppercase text-primary small font-weight-bold">{{ $withdraw->method }}</span>
                <code class="text-dark">{{ $withdraw->account_details }}</code> <!-- আপনার ডাটাবেজে কলামের নাম account_details -->
            </div>
        </td>
        <td>
            @if($withdraw->status == 'approved')
                <label class="badge badge-gradient-success">Paid</label>
            @elseif($withdraw->status == 'pending')
                <label class="badge badge-gradient-warning text-dark">Pending</label>
            @else
                <label class="badge badge-gradient-danger">Rejected</label>
            @endif
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="5" class="text-center py-5">কোন ডাটা পাওয়া যায়নি মামা!</td>
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
    .bg-soft-primary { background-color: #e8f0fe; }
    .font-weight-bold { font-weight: 600 !important; }
    .table thead th { border-top: 0; border-bottom-width: 1px; }
    .badge-gradient-success { background: linear-gradient(to right, #84d9d2, #07cdae); color: #fff; border: none; }
    .badge-gradient-warning { background: linear-gradient(to right, #f6e384, #ffd500); color: #000; border: none; }
    .badge-gradient-danger { background: linear-gradient(to right, #ffbf96, #fe7096); color: #fff; border: none; }
</style>
@endsection