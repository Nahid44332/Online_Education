@extends('backend.student-panel.st-master')
@section('content')
    <div class="container-fluid mt-4">

        @if ($student->status == 1)
            {{-- স্টুডেন্ট একটিভ থাকলে এই অংশ দেখাবে --}}
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-gradient-success text-white shadow-sm border-0" style="border-radius: 15px;">
                        <div class="card-body p-4 d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="fw-bold">স্বাগতম, {{ $student->name }}! 🎓</h3>
                                <p class="mb-0">আপনার শেখার যাত্রা শুভ হোক। আপনার বর্তমান ব্যালেন্স:
                                    <strong>{{ number_format($student->points, 0) }}</strong>
                                </p>
                            </div>
                            <div class="text-center">
                                <i class="mdi mdi-wallet-giftcard" style="font-size: 40px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                {{-- টিম লিডার কার্ড (ডাইনামিক ও সেফ) --}}
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                @if (isset($my_tl->profile_image) && $my_tl->profile_image)
                                    <img src="{{ asset('backend/images/team-leader/' . $my_tl->profile_image) }}"
                                        style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;"
                                        alt="Team Leader">
                                @else
                                    <div class="bg-light-primary text-center"
                                        style="width: 60px; height: 60px; line-height: 60px; border-radius: 50%;">
                                        <i class="mdi mdi-account-group text-primary fs-3"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h5 class="text-muted small text-uppercase fw-bold">Team Leader</h5>
                                <h4 class="fw-bold text-dark">{{ $my_tl->name ?? 'Not Assigned' }}</h4>

                                @if (isset($my_tl->phone))
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $my_tl->phone) }}"
                                        target="_blank" class="badge badge-gradient-success text-decoration-none">
                                        <i class="mdi mdi-whatsapp"></i> WhatsApp Connect
                                    </a>
                                @else
                                    <span class="badge badge-secondary small">Wait for Assign</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ট্রেইনার কার্ড (ডাইনামিক ও সেফ) --}}
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                @if (isset($my_trainer->profile_image) && $my_trainer->profile_image)
                                    <img src="{{ asset('backend/images/trainer/' . $my_trainer->profile_image) }}"
                                        style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;"
                                        alt="Trainer">
                                @else
                                    <div class="bg-light-info text-center"
                                        style="width: 60px; height: 60px; line-height: 60px; border-radius: 50%;">
                                        <i class="mdi mdi-account-tie text-info fs-3"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h5 class="text-muted small text-uppercase fw-bold">Trainer</h5>
                                <h4 class="fw-bold text-dark">{{ $my_trainer->name ?? 'Not Assigned' }}</h4>

                                @if (isset($my_trainer->phone))
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $my_trainer->phone) }}"
                                        target="_blank" class="badge badge-gradient-success text-decoration-none">
                                        <i class="mdi mdi-whatsapp"></i> WhatsApp Connect
                                    </a>
                                @else
                                    <span class="badge badge-secondary small">Wait for Assign</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- হেল্পলাইন কার্ড --}}
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
                                <h5 class="text-muted small text-uppercase fw-bold">May I Help You</h5>
                                <h4 class="fw-bold text-dark">Emergency Support</h4>

                                {{-- মামা, যদি অনলাইনে কেউ থাকে তবেই $emargancy_link ডাটা পাবে --}}
                                @if ($emargancy_link)
                                    <a href="{{ $emargancy_link->meet_link }}" target="_blank"
                                        class="badge badge-gradient-success text-decoration-none shadow-sm">
                                        <i class="mdi mdi-headset"></i> Join Now
                                    </a>
                                @else
                                    <span class="badge bg-secondary text-white shadow-sm">
                                        <i class="mdi mdi-power-off"></i> Offline Now
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- গিফট হিস্ট্রি সেকশন --}}
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-body">
                <h4 class="card-title text-dark fw-bold">
                    <i class="mdi mdi-heart text-danger me-2"></i> উপহারের তালিকা (Gift History)
                </h4>

                <div class="table-responsive">
                    <table class="table table-hover mt-3">
                        <thead class="bg-light">
                            <tr>
                                <th>তারিখ</th>
                                <th>উপহারের বিবরণ</th>
                                <th>প্রেরক (Sender)</th>
                                <th>পরিমাণ</th>
                                <th>স্ট্যাটাস</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($gifts as $gift)
                                <tr>
                                    <td>{{ date('d M, Y', strtotime($gift->created_at)) }}</td>
                                    <td>
                                        <span class="fw-bold text-dark">স্পেশাল উপহার 🎁</span> <br>
                                        <small class="text-muted">{{ $gift->description ?? 'পয়েন্ট গিফট করা হয়েছে' }}</small>
                                    </td>
                                    <td>
                                        {{-- প্রেরক শনাক্তকরণ --}}
                                        @if (!empty($gift->teacher_id))
                                            <label class="badge badge-gradient-primary">Teacher</label>
                                            <br><small class="fw-bold text-info">{{$my_teacher->name}}</small>
                                        @elseif(!empty($gift->trainer_id))
                                            <label class="badge badge-gradient-info">Trainer</label>
                                            <br><small>{{ $my_trainer->name ?? 'Course Mentor' }}</small>
                                        @elseif(!empty($gift->team_leader_id))
                                            <label class="badge badge-gradient-danger">Team Leader</label>
                                            <br><small>{{ $my_tl->name ?? 'Leader' }}</small>
                                        @else
                                            <label class="badge badge-gradient-secondary">System Admin</label>
                                        @endif
                                    </td>
                                    <td>
                                        <h5 class="text-success fw-bold mb-0">+{{ number_format($gift->amount, 0) }}</h5>
                                    </td>
                                    <td>
                                        <label class="badge badge-success px-3">Received</label>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">কোনো উপহার পাওয়া যায়নি।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
        @else
            {{-- ইন-অ্যাক্টিভ স্ক্রিন --}}
            <div class="row justify-content-center mt-5">
                <div class="col-md-8 col-lg-6">
                    <div class="card border-0 shadow-lg text-center" style="border-radius: 20px; overflow: hidden;">
                        <div class="card-header bg-danger p-4 text-white">
                            <i class="mdi mdi-lock-outline" style="font-size: 50px;"></i>
                        </div>
                        <div class="card-body p-5">
                            <h2 class="fw-bold text-danger">Account Inactive! 😒</h2>
                            <p class="text-muted mt-3">দুঃখিত মামা! আপনার অ্যাকাউন্টটি বর্তমানে ইন-এক্টিভ আছে। এক্টিভ করতে
                                নিচের কাউন্সেলরের সাথে যোগাযোগ করুন।</p>

                            <div class="bg-light p-4 mt-4" style="border-radius: 15px;">
                                <h5 class="fw-bold text-dark mb-3">Contact Your Counsellor</h5>

                                {{-- এখানে সরাসরি $counsellor ভেরিয়েবল ব্যবহার করা হয়েছে যা কন্ট্রোলার থেকে আসছে --}}
                                @if ($counsellor)
                                    {{-- কাউন্সেলরের প্রোফাইল ছবি --}}
                                    @php
                                        $c_image = $counsellor->profile_image
                                            ? asset('backend/images/counsellor/' . $counsellor->profile_image)
                                            : asset('backend/assets/images/no-image.png');
                                    @endphp
                                    <img src="{{ $c_image }}" alt="counsellor" class="rounded-circle mb-2"
                                        style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">

                                    <h4 class="text-primary fw-bold mt-2">{{ $counsellor->name }}</h4>
                                    <p class="text-muted small mb-2"><i class="mdi mdi-briefcase-outline"></i>
                                        {{ $counsellor->designation ?? 'Academic Counsellor' }}</p>

                                    @if ($counsellor->phone)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $counsellor->phone) }}"
                                            target="_blank" class="btn btn-success mt-2"
                                            style="background: linear-gradient(45deg, #25D366, #128C7E); border: none; border-radius: 30px; padding: 10px 25px;">
                                            <i class="mdi mdi-whatsapp"></i> WhatsApp Now
                                        </a>
                                    @endif
                                @else
                                    {{-- যদি কোনো কাউন্সেলর এসাইন করা না থাকে --}}
                                    <div class="py-3">
                                        <i class="mdi mdi-office-building text-muted fs-1"></i>
                                        <h4 class="text-primary fw-bold mt-2">Head Office</h4>
                                        <p class="text-muted mt-2">বর্তমানে আপনার প্রোফাইলে কোনো কাউন্সেলর এসাইন করা নেই।
                                            দয়া করে মেইন অফিসে যোগাযোগ করুন।</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>

    {{-- SweetAlert Logic --}}
    @if ($gifts->count() > 0 && session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                title: 'অভিনন্দন! 🎉',
                text: 'আপনি টিম লিডার থেকে একটি উপহার পেয়েছেন!',
                icon: 'success',
                confirmButtonColor: '#1bcfb4',
                confirmButtonText: 'ধন্যবাদ!'
            });
        </script>
    @endif
@endsection
