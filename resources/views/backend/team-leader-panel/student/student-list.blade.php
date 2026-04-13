@extends('backend.team-leader-panel.tl-master')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-account-group"></i>
                </span> My Students List
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
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="card-title">All Students Under Your Supervision</h4>
                                <p class="card-description mb-0">Track performance and appreciate their hard work.</p>
                            </div>
                            <div class="bg-gradient-info p-3 rounded text-white shadow-sm">
                                <small class="d-block">Your Balance</small>
                                <h4 class="mb-0">৳ {{ number_format(DB::table('team_leaders')->where('subadmin_id', Auth::guard('subadmin')->id())->value('points'), 2) }}</h4>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th> ID </th>
                                        <th> Student </th>
                                        <th> Course </th>
                                        <th> Join Date </th>
                                        <th> Status </th>
                                        <th class="text-center"> Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($students as $student)
                                        <tr>
                                            <td>#{{ $student->id }}</td>
                                            <td class="py-1">
                                                <img src="{{ asset('backend/images/students/' . ($student->image ?? 'default.png')) }}"
                                                    class="me-2 shadow-sm" alt="image" style="width: 35px; height: 35px;">
                                                <span class="fw-bold">{{ $student->name }}</span>
                                            </td>
                                            <td> 
                                                <label class="badge badge-gradient-info text-white">{{ $student->course->title ?? 'N/A' }}</label>
                                            </td>
                                            <td> {{ date('d M, Y', strtotime($student->created_at)) }} </td>
                                            <td>
                                                @if ($student->status == 1)
                                                    <label class="badge badge-success">Active</label>
                                                @else
                                                    <label class="badge badge-warning">Pending</label>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    {{-- গিফট বাটন (মায়া) --}}
                                                    <button type="button" class="btn btn-sm btn-gradient-danger btn-icon-text me-2 shadow-sm" 
                                                            data-bs-toggle="modal" data-bs-target="#giftModal{{ $student->id }}" 
                                                            style="border-radius: 5px;">
                                                        <i class="mdi mdi-heart me-1"></i> Gift
                                                    </button>

                                                    {{-- হোয়াটসঅ্যাপ বাটন --}}
                                                    @if ($student->phone)
                                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $student->phone) }}?text=Hello%20{{ $student->name }},%20I%20am%20your%20Team%20Leader."
                                                            target="_blank" class="btn btn-sm btn-outline-success border-2 shadow-sm"
                                                            style="border-radius: 5px; padding: 5px 8px;">
                                                            <i class="mdi mdi-whatsapp"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- Gift Modal --}}
                                        <div class="modal fade" id="giftModal{{ $student->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow" style="border-radius: 15px;">
                                                    <form action="{{ route('team_leader.gift.points') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                        <div class="modal-header border-0 bg-light" style="border-radius: 15px 15px 0 0;">
                                                            <h5 class="modal-title fw-bold">🎁 Gift Points to {{ $student->name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center p-5">
                                                            <div class="mb-4">
                                                                <i class="mdi mdi-heart text-danger pulse" style="font-size: 60px;"></i>
                                                                <p class="text-muted mt-2">আপনার মায়া সরাসরি স্টুডেন্টের ওয়ালেটে যাবে।</p>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <label class="fw-bold small mb-2 text-uppercase">পরিমাণ (পয়েন্ট)</label>
                                                                <input type="number" name="points" class="form-control form-control-lg text-center fw-bold text-primary" 
                                                                       placeholder="0" min="10" required style="font-size: 24px; border-radius: 10px;">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-0 p-3">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-gradient-danger px-4 fw-bold shadow-sm">Confirm Gift</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted p-5">
                                                <i class="mdi mdi-account-off d-block mb-2" style="font-size: 40px;"></i>
                                                No students have been assigned to you yet.
                                            </td>
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

    {{-- Pulse Animation for Heart --}}
    <style>
        .pulse { animation: pulse-red 2s infinite; }
        @keyframes pulse-red {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(255, 82, 82, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(255, 82, 82, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(255, 82, 82, 0); }
        }
    </style>
@endsection