@extends('backend.trainer-panel.tr-master')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-school"></i>
                </span> My Students List
            </h3>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="card-title">All Learners Under Your Mentorship</h4>
                                <p class="card-description mb-0">Track performance and appreciate their hard work.</p>
                            </div>
                            {{-- ট্রেইনারের ব্যালেন্স কার্ড --}}
                            <div class="bg-gradient-info p-3 rounded text-white shadow-sm">
                                <small class="d-block">Your Points</small>
                                <h4 class="mb-0">৳ {{ number_format(DB::table('trainers')->where('subadmin_id', Auth::guard('subadmin')->id())->value('points'), 2) }}</h4>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th> Student ID </th>
                                        <th> Name </th>
                                        <th> Phone </th>
                                        <th> Course </th>
                                        <th> Status </th>
                                        <th class="text-center"> Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr>
                                            <td class="py-1">#{{ $student->id }}</td>
                                            <td class="fw-bold text-dark"> {{ $student->name }} </td>
                                            <td> {{ $student->phone }} </td>
                                            <td> 
                                                <label class="badge badge-gradient-info text-white">{{ $student->course->title ?? 'N/A' }}</label>
                                            </td>
                                            <td>
                                                @if ($student->status == '1')
                                                    <label class="badge badge-success">Active</label>
                                                @else
                                                    <label class="badge badge-warning">Pending</label>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    {{-- গিফট বাটন (মায়া এনিমেশন সহ) --}}
                                                    <button type="button" class="btn btn-sm btn-gradient-danger btn-icon-text me-2 shadow-sm"
                                                        data-bs-toggle="modal" data-bs-target="#giftModal{{ $student->id }}"
                                                        style="border-radius: 5px;">
                                                        <i class="mdi mdi-heart me-1"></i> Gift
                                                    </button>

                                                    {{-- হোয়াটসঅ্যাপ বাটন --}}
                                                    @if ($student->phone)
                                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $student->phone) }}?text=Hello%20{{ $student->name }},%20I%20am%20your%20Trainer."
                                                            target="_blank"
                                                            class="btn btn-sm btn-outline-success border-2 shadow-sm"
                                                            style="border-radius: 5px; padding: 5px 8px;">
                                                            <i class="mdi mdi-whatsapp"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="giftModal{{ $student->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow" style="border-radius: 15px;">
                                                    <form action="{{ route('trainer.gift.points') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                        <div class="modal-header border-0 bg-light" style="border-radius: 15px 15px 0 0;">
                                                            <h5 class="modal-title fw-bold">🎁 Gift Points to {{ $student->name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center p-5">
                                                            <div class="mb-4">
                                                                <i class="mdi mdi-heart text-danger pulse" style="font-size: 60px;"></i>
                                                                <p class="text-muted mt-2">আপনার পয়েন্ট সরাসরি স্টুডেন্টের ওয়ালেটে যুক্ত হবে।</p>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <label class="fw-bold small mb-2 text-uppercase">পরিমাণ (পয়েন্ট)</label>
                                                                <input type="number" name="points" class="form-control form-control-lg text-center fw-bold text-primary" 
                                                                       placeholder="0" min="1" required style="font-size: 24px; border-radius: 10px;">
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Pulse Animation CSS --}}
    <style>
        .pulse { animation: pulse-red 2s infinite; }
        @keyframes pulse-red {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(255, 82, 82, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(255, 82, 82, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(255, 82, 82, 0); }
        }
    </style>
@endsection