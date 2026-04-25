@extends('backend.counsellor-panel.cs-master')
@section('content')

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Dashboard
        </h3>
    </div>

    <div class="row">
        {{-- ১. এসাইন করা স্টুডেন্ট --}}
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Assigned Students <i class="mdi mdi-account-multiple mdi-24px float-right"></i></h4>
                    <h2 class="mb-5">{{ $total_assigned ?? 0 }}</h2>
                </div>
            </div>
        </div>

        {{-- ২. পেন্ডিং ফলোআপ --}}
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Follow-up Leads <i class="mdi mdi-phone-paused mdi-24px float-right"></i></h4>
                    <h2 class="mb-5">{{ $pending_followup ?? 0 }}</h2>
                </div>
            </div>
        </div>

        {{-- ৩. সফল ভর্তি --}}
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total Admitted <i class="mdi mdi-school mdi-24px float-right"></i></h4>
                    <h2 class="mb-5">{{ $total_admitted ?? 0 }}</h2>
                </div>
            </div>
        </div>

        {{-- ৪. কাউন্সেলর স্যালারি/পয়েন্ট (এখানেই আপডেট হয়েছে) --}}
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-warning card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Current Balance <i class="mdi mdi-cash-multiple mdi-24px float-right"></i></h4>
                    <h2 class="mb-2">৳ {{ number_format($counsellor->points ?? 0, 2) }}</h2>
                    <p class="card-text">Total Earnings</p>
                </div>
            </div>
        </div>
    </div>

    {{-- রিসেন্ট লিড টেবিল --}}
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title text-primary"><i class="mdi mdi-clock-outline me-2"></i>Recent New Leads</h4>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th> Student Name </th>
                                    <th> Course </th>
                                    <th> Phone </th>
                                    <th> Status </th>
                                    <th> Date </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_students as $student)
                                <tr>
                                    <td class="fw-bold">{{ $student->name }}</td>
                                    <td>{{ $student->course->title ?? 'N/A' }}</td>
                                    <td>{{ $student->phone }}</td>
                                    <td>
                                        <span class="badge badge-gradient-info">New</span>
                                    </td>
                                    <td>{{ $student->created_at->format('d M, Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">এখনো কোনো নতুন লিড আসেনি মামা!</td>
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