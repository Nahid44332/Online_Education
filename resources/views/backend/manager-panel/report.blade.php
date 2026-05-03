@extends('backend.manager-panel.master')

@section('content')
<div class="content-wrapper">
    {{-- পেজ হেডার --}}
    <div class="page-header d-flex justify-content-between align-items-center">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-file-document"></i>
            </span> Company Master Report
        </h3>
        <nav aria-label="breadcrumb" class="d-print-none">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active text-primary fw-bold" aria-current="page">
                    Summary & Detailed Lists
                </li>
            </ul>
        </nav>
    </div>

    {{-- ফিল্টার সেকশন (প্রিন্টে আসবে না) --}}
    <div class="card mb-4 border-0 shadow-sm d-print-none">
        <div class="card-body">
            <h5 class="card-subtitle mb-3 text-muted">Filter Records by Date Range</h5>
            <form action="{{ route('manager.report') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="fw-bold">From Date</label>
                    <input type="date" name="start_date" value="{{ $start_date }}" class="form-control border-primary">
                </div>
                <div class="col-md-4">
                    <label class="fw-bold">To Date</label>
                    <input type="date" name="end_date" value="{{ $end_date }}" class="form-control border-primary">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-gradient-primary btn-icon-text">
                        <i class="mdi mdi-filter btn-icon-prepend"></i> Filter Report
                    </button>
                    <button type="button" onclick="window.print()" class="btn btn-dark btn-icon-text">
                        <i class="mdi mdi-printer btn-icon-prepend"></i> Print
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- সামারি কার্ড গ্রিড --}}
    <div class="row mb-2">
        @foreach ($counts as $label => $value)
            <div class="col-md-2 col-sm-4 col-6 mb-3">
                <div class="card shadow-sm border-0 text-center p-2 border-bottom border-primary border-3 h-100 bg-white">
                    <small class="text-uppercase fw-bold text-muted d-block mb-1" style="font-size: 9px; letter-spacing: 0.5px;">
                        Total {{ str_replace('total_', '', $label) }}
                    </small>
                    <h3 class="mb-0 fw-bold text-dark">{{ $value }}</h3>
                </div>
            </div>
        @endforeach
    </div>

    <hr class="my-4">

    {{-- ১. স্টুডেন্ট টেবিল --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h4 class="card-title text-primary"><i class="mdi mdi-account-group me-2"></i>Student List</h4>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Phone/Email</th>
                            <th>Registration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $key => $s)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td class="fw-bold">{{ $s->name }}</td>
                                <td>{{ $s->phone }}</td>
                                <td>{{ $s->created_at->format('d M, Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center">No students found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ২. টিচার ও ট্রেইনার (দুই কলামে ছোট করে দেখানো যেতে পারে, কিন্তু আপনি আলাদা চেয়েছেন তাই আলাদা নিচে নিচে) --}}
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h4 class="card-title text-success"><i class="mdi mdi-human-male-board me-2"></i>Teacher List</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="bg-success text-white">
                                <tr><th>SL</th><th>Name</th><th>Dept.</th></tr>
                            </thead>
                            <tbody>
                                @foreach ($teachers as $key => $t)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $t->name }}</td>
                                        <td><small>{{ $t->department ?? 'General' }}</small></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100 border-start border-success border-3">
                <div class="card-body">
                    <h4 class="card-title text-success"><i class="mdi mdi-teach me-2"></i>Trainer List</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="bg-light">
                                <tr><th>SL</th><th>Name</th><th>Designation</th></tr>
                            </thead>
                            <tbody>
                                @foreach ($trainers as $key => $t)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $t->name }}</td>
                                        <td><small class="text-muted">{{ $t->designation }}</small></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ৩. টিম লিডার ও কাউন্সিলর --}}
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100 border-start border-info border-3">
                <div class="card-body">
                    <h4 class="card-title text-info"><i class="mdi mdi-account-star me-2"></i>Team Leaders</h4>
                    <table class="table table-sm table-hover">
                        <thead><tr><th>SL</th><th>Name</th><th>Phone</th></tr></thead>
                        <tbody>
                            @foreach ($teamleaders as $key => $tl)
                                <tr><td>{{ $key + 1 }}</td><td>{{ $tl->name }}</td><td>{{ $tl->phone }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100 border-start border-danger border-3">
                <div class="card-body">
                    <h4 class="card-title text-danger"><i class="mdi mdi-account-tie me-2"></i>Counsellors</h4>
                    <table class="table table-sm table-hover">
                        <thead><tr><th>SL</th><th>Name</th><th>Contact</th></tr></thead>
                        <tbody>
                            @foreach ($counsellors as $key => $c)
                                <tr><td>{{ $key + 1 }}</td><td>{{ $c->name }}</td><td>{{ $c->phone }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ৪. কন্টাক্ট ও হেল্পলাইন --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h4 class="card-title text-warning"><i class="mdi mdi-message me-2"></i>Recent Inquiries</h4>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead><tr><th>Date</th><th>Name</th><th>Message</th></tr></thead>
                    <tbody>
                        @foreach ($messages as $m)
                            <tr>
                                <td>{{ $m->created_at->format('d-m-Y') }}</td>
                                <td class="fw-bold">{{ $m->name }}</td>
                                <td>{{ Str::limit($m->message, 80) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mb-4 shadow-sm border-0 bg-light">
        <div class="card-body">
            <h4 class="card-title text-info"><i class="mdi mdi-phone-in-talk me-2"></i>Helpline Records</h4>
            <div class="row">
                @foreach ($helplines as $h)
                    <div class="col-md-3 mb-2">
                        <div class="p-2 bg-white rounded shadow-sm border">
                            <strong>{{ $h->name }}:</strong> {{ $h->phone }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    /* প্রিন্ট করার সময় কিছু জিনিস সুন্দর করার জন্য */
    @media print {
        .d-print-none { display: none !important; }
        .content-wrapper { padding: 0 !important; }
        .card { border: 1px solid #eee !important; box-shadow: none !important; }
        body { background-color: #fff !important; }
    }
    .table thead th {
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
</style>
@endsection