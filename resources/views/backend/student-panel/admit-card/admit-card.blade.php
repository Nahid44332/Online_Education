@extends('backend.student-panel.st-master')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <span>Your Admit Card</span>
                        {{-- এখানে চেক করা হচ্ছে কার্ড আছে কি না এবং স্টুডেন্ট রিলেশন ঠিক আছে কি না --}}
                        @if (isset($admitCard) && $admitCard->student)
                            <div>
                                <a href="{{ route('student.admit-card.download', $admitCard->id) }}"
                                    class="btn btn-sm btn-success text-white">
                                    <i class="mdi mdi-download"></i> Download PDF
                                </a>
                            </div>
                        @endif
                    </div>
                    
                    <div class="card-body">
                        @if (isset($admitCard) && $admitCard->student)
                            <div class="admit-box p-4 border text-center">
                                <h4>Lina Digital E-Learning Platform</h4>
                                <p>Kumun, Gazipur Sadar, Gazipur</p>
                                <hr>
                                <h5 class="mb-4">EXAMINATION ADMIT CARD</h5>

                                <div class="text-left mt-4" style="text-align: left;">
                                    {{-- optional() ব্যবহার করলে ডেটা না থাকলেও এরর দেবে না --}}
                                    <p><strong>Student Name:</strong> {{ optional($admitCard->student)->name }}</p>
                                    <p><strong>Student ID:</strong> {{ optional($admitCard->student)->id }}</p>
                                    <p><strong>Course:</strong> {{ $admitCard->course }}</p>
                                    <p><strong>Exam Name:</strong> {{ $admitCard->exam }}</p>
                                    <p><strong>Exam Date:</strong>
                                        {{ $admitCard->exam_date ? \Carbon\Carbon::parse($admitCard->exam_date)->format('d M, Y') : 'N/A' }}
                                    </p>
                                    <p><strong>Seat No:</strong> {{ $admitCard->seat_no ?? 'N/A' }}</p>
                                </div>

                                <div class="mt-5 d-flex justify-content-between">
                                    <div class="text-center">
                                        <p class="mb-0">_________________</p>
                                        <p>Student Signature</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="mb-0">_________________</p>
                                        <p>Director Signature</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- কার্ড না থাকলে এই অংশটি দেখাবে --}}
                            <div class="alert alert-info text-center shadow-sm">
                                <i class="mdi mdi-information-outline mdi-24px"></i> <br>
                                আপনার জন্য কোনো এডমিট কার্ড এখনও ইস্যু করা হয়নি। <br>
                                <small>অনুগ্রহ করে অফিসের সাথে যোগাযোগ করুন বা কিছু সময় অপেক্ষা করুন।</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- প্রিন্ট স্টাইল --}}
    <style>
        @media print {
            body * { visibility: hidden; }
            .admit-box, .admit-box * { visibility: visible; }
            .admit-box { position: absolute; left: 0; top: 0; width: 100%; border: none !important; }
        }
    </style>
@endsection