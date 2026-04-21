@extends('backend.counsellor-panel.cs-master')
@section('content')

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Dashboard
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
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Assigned Students <i class="mdi mdi-account-multiple mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">০</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Pending Follow-up <i class="mdi mdi-phone-paused mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">০</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total Admitted <i class="mdi mdi-school mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">০</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-warning card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">My Points <i class="mdi mdi-star mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">০</h2>
                </div>
            </div>
        </div>
    </div>

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
                                    <th> Date </th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- এখানে লুপ হবে --}}
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">এখনো কোনো নতুন লিড আসেনি মামা!</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary { background: linear-gradient(to right, #da8cff, #9a55ff); }
    .bg-gradient-danger { background: linear-gradient(to right, #ffbf96, #fe7096); }
    .bg-gradient-info { background: linear-gradient(to right, #90caf9, #047edf); }
    .bg-gradient-success { background: linear-gradient(to right, #84d9d2, #07cdae); }
    .bg-gradient-warning { background: linear-gradient(to right, #f6e384, #ffd500); }
    
    .card-img-absolute {
        position: absolute;
        top: 0;
        right: 0;
        height: 100%;
    }
</style>

@endsection