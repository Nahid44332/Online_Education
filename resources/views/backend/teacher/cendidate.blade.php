@extends('backend.master')

@section('content')
<div class="container-fluid mt-5">
    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold text-dark">Teacher Applications</h4>
        </div>
        <div class="card-body p-0">
            {{-- টেবিল রেসপনসিভ করার জন্য মেইন কন্টেইনার --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-nowrap ps-3">SL</th>
                            <th class="text-nowrap">Application ID</th>
                            <th class="text-nowrap">Name</th>
                            <th class="text-nowrap">Contact Info</th> {{-- Email ও Phone একসাথে --}}
                            <th class="text-nowrap">Skill</th>
                            <th class="text-nowrap">Status</th>
                            <th class="text-nowrap text-center pe-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $key => $app)
                            <tr>
                                <td class="ps-3">{{ $key+1 }}</td>
                                <td class="fw-bold">#{{ $app->application_id ?? 'N/A' }}</td>
                                <td class="text-nowrap">{{ $app->name }}</td>
                                <td>
                                    <small class="d-block text-dark fw-bold">{{ $app->email }}</small>
                                    <small class="text-muted">{{ $app->phone }}</small>
                                </td>
                                <td>
                                    <span class="badge badge-outline-primary">{{ $app->skills }}</span>
                                </td>
                                <td>
                                    @if($app->status == 'approved')
                                        <span class="badge bg-success text-white">Approved</span>
                                    @elseif($app->status == 'rejected')
                                        <span class="badge bg-danger text-white">Rejected</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                                <td class="pe-3 text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        {{-- Approve --}}
                                        <a href="{{ url('teacher-applications/'.$app->id.'/approve')}}" 
                                           class="btn btn-outline-success" title="Approve">
                                            <i class="mdi mdi-check"></i>
                                        </a>
                                        {{-- Reject --}}
                                        <a href="{{ url('teacher-applications/'.$app->id.'/reject')}}" 
                                           class="btn btn-outline-warning" title="Reject">
                                            <i class="mdi mdi-close-thick"></i>
                                        </a>
                                        {{-- View --}}
                                        <a href="{{ url('teacher-applications/show/'.$app->id )}}" 
                                           class="btn btn-outline-info" title="View Detail">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                        {{-- Delete --}}
                                        <a href="{{ url('/teacher-applications/delete/'.$app->id )}}" 
                                           class="btn btn-outline-danger" title="Delete"
                                           onclick="return confirm('Are you sure?')">
                                            <i class="mdi mdi-delete"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="mdi mdi-account-off d-block mb-2 shadow-none" style="font-size: 2rem;"></i>
                                    No Teacher Applications Found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- কিছু কাস্টম স্টাইল যাতে ডিজাইন আরও ক্লিন থাকে --}}
<style>
    .table-responsive {
        border-radius: 0 0 12px 12px;
    }
    .text-nowrap {
        white-space: nowrap;
    }
    .badge-outline-primary {
        color: #4b49ac;
        border: 1px solid #4b49ac;
        background: transparent;
    }
    .btn-group-sm > .btn {
        padding: 0.4rem 0.5rem;
    }
    /* মোবাইল স্ক্রিনে যাতে টেবিলটা ফ্রেশ থাকে */
    .table td, .table th {
        padding: 12px 10px;
    }
</style>
@endsection