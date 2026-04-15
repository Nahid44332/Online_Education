@extends('backend.helpline-panel.help-master')
@section('content')
    <div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Helpline Dashboard
        </h3>
    </div>

    <div class="row">
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Live Status <i class="mdi mdi-video-wireless mdi-24px float-right"></i></h4>
                    <h2 class="mb-5">{{ Auth::guard('subadmin')->user()->helpline->is_online == 1 ? 'Online' : 'Offline' }}</h2>
                    <h6 class="card-text">Status synchronized with student panel</h6>
                </div>
            </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total Earnings <i class="mdi mdi-wallet mdi-24px float-right"></i></h4>
                    <h2 class="mb-5">৳ {{$helpline_data->points}}</h2>
                    <h6 class="card-text">Current month earnings</h6>
                </div>
            </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Withdraw Requests <i class="mdi mdi-cash mdi-24px float-right"></i></h4>
                    <h2 class="mb-5">03</h2>
                    <h6 class="card-text">Pending approvals</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Quick Meeting Setup</h4>
                    <p class="card-description"> স্টুডেন্টদের সাথে মিটিং শুরু করতে আপনার গুগল মিট লিঙ্কটি আপডেট করুন। </p>
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="mdi mdi-google-meet text-primary" style="font-size: 40px;"></i>
                        </div>
                        <div>
                            <p class="mb-1"><b>Current Meet Link:</b> {{ Auth::guard('subadmin')->user()->helpline->meet_link ?? 'Not Set' }}</p>
                            <a href="{{route('helpline.meeting')}}" class="btn btn-sm btn-gradient-primary">Go to Meeting Desk</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection