@extends('backend.student-panel.st-master')
@section('content')
    <div class="container-fluid mt-4">

        @if ($student->status == 1)
            {{-- স্টুডেন্ট একটিভ থাকলে এই অংশ দেখাবে --}}

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-gradient-success text-white shadow-sm border-0" style="border-radius: 15px;">
                        <div class="card-body p-4">
                            <h3 class="fw-bold">স্বাগতম, {{ $student->name }}! 🎓</h3>
                            <p class="mb-0">আপনার শেখার যাত্রা শুভ হোক। যেকোনো প্রয়োজনে সাপোর্ট টিমের সাথে যোগাযোগ করুন।
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="row">
                    <div class="col-md-6 col-xl-4 mb-4">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                            <div class="card-body d-flex align-items-center">
                                <div class="me-3">
                                    <img src="{{ asset('backend/images/team-leader/' . ($my_tl->profile_image ?? 'default.png')) }}"
                                        style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;"
                                        alt="TL">
                                </div>
                                <div>
                                    <h5 class="text-muted small text-uppercase fw-bold">Support Mentor</h5>
                                    <h4 class="fw-bold text-dark">{{ $my_tl->name ?? 'Admin' }}</h4>
                                    @if ($my_tl && $my_tl->phone)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $my_tl->phone) }}"
                                            target="_blank" class="badge badge-gradient-success text-decoration-none">
                                            <i class="mdi mdi-whatsapp"></i> WhatsApp Connect
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-4 mb-4">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                            <div class="card-body d-flex align-items-center">
                                <div class="me-3">
                                    <div class="bg-light-info text-center"
                                        style="width: 60px; height: 60px; line-height: 60px; border-radius: 50%;">
                                        <i class="mdi mdi-account-tie text-info fs-3"></i>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="text-muted small text-uppercase fw-bold">Course Trainer</h5>
                                    <h4 class="fw-bold text-dark">Lina Digital Trainer</h4>
                                    <a href="tel:01XXXXXXXXX" class="badge badge-gradient-info text-decoration-none">
                                        <i class="mdi mdi-phone"></i> Call Trainer
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-4 mb-4">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                            <div class="card-body d-flex align-items-center">
                                <div class="me-3">
                                    <div class="bg-light-danger text-center"
                                        style="width: 60px; height: 60px; line-height: 60px; border-radius: 50%;">
                                        <i class="mdi mdi-headset text-danger fs-3"></i>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="text-muted small text-uppercase fw-bold">Official Helpline</h5>
                                    <h4 class="fw-bold text-dark">Technical Support</h4>
                                    <p class="mb-0 text-muted small">Available: 10AM - 10PM</p>
                                    <a href="tel:01700000000" class="text-danger fw-bold text-decoration-none">
                                        <i class="mdi mdi-phone-in-talk"></i> 01700-000000
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- স্টুডেন্ট ইন-অ্যাক্টিভ থাকলে এই এরর স্ক্রিন দেখাবে --}}
                <div class="row justify-content-center mt-5">
                    <div class="col-md-8 col-lg-6">
                        <div class="card border-0 shadow-lg text-center" style="border-radius: 20px; overflow: hidden;">
                            <div class="card-header bg-danger p-4">
                                <i class="mdi mdi-lock-outline text-white" style="font-size: 50px;"></i>
                            </div>
                            <div class="card-body p-5">
                                <h2 class="fw-bold text-danger">Account Inactive! 😒</h2>
                                <p class="text-muted mt-3">দুঃখিত মামা! আপনার অ্যাকাউন্টটি বর্তমানে ইন-এক্টিভ আছে।
                                এক্টিভ একাউন্ট ব্যবহার করতে হলে দয়া করে আপনার কাউন্সিলরের সাথে যোগাযোগ করুন।</p>

                                <div class="bg-light p-4 mt-4" style="border-radius: 15px;">
                                    <h5 class="fw-bold text-dark">Contact Your Counsellor</h5>
                                    <hr>
                                    <h4 class="text-primary fw-bold">{{ $my_tl->name ?? 'Head Office' }}</h4>
                                    @if ($my_tl && $my_tl->phone)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $my_tl->phone) }}"
                                            class="btn btn-gradient-success mt-2">
                                            <i class="mdi mdi-whatsapp"></i> WhatsApp Now
                                        </a>
                                        <br>
                                        <a href="tel:{{ $my_tl->phone }}"
                                            class="d-block mt-3 text-dark fw-bold text-decoration-none">
                                            <i class="mdi mdi-phone"></i> {{ $my_tl->phone }}
                                        </a>
                                    @else
                                        <p class="text-danger mt-2">হেল্পলাইন: ০১৭০০-০০০০০০</p>
                                    @endif
                                </div>

                                <div class="mt-4">
                                    <small class="text-muted">অ্যাকাউন্ট ভেরিফাই হতে সাধারণত ২৪-৪৮ ঘণ্টা সময় লাগে।</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        @endif

    </div>
@endsection
