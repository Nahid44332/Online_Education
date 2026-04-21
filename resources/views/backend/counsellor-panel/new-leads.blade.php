@extends('backend.counsellor-panel.cs-master')
@section('content')
    <div class="container-fluid mt-4">
    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-header bg-white py-3">
            <h4 class="mb-0 fw-bold text-primary"><i class="mdi mdi-account-group me-2"></i>নতুন স্টুডেন্ট লিস্ট (New Leads)</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>ছবি ও নাম</th>
                            <th>কোর্স</th>
                            <th>মোবাইল ও যোগাযোগ</th>
                            <th>রেজিস্ট্রেশন তারিখ</th>
                            <th class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('backend/images/students/'.($student->image ?? 'default.png')) }}" 
                                         class="rounded-circle me-3" style="width: 45px; height: 45px; object-fit: cover;">
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $student->name }}</h6>
                                        <small class="text-muted">{{ $student->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-soft-primary text-primary">{{ $student->course->title ?? 'N/A' }}</span></td>
                            <td>
                                <div class="d-flex gap-2">
                                    {{-- সরাসরি কল বাটন --}}
                                    <a href="tel:{{ $student->phone }}" class="btn btn-sm btn-outline-primary" title="সরাসরি কল করুন">
                                        <i class="mdi mdi-phone"></i>
                                    </a>
                                    {{-- হোয়াটসঅ্যাপ বাটন --}}
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $student->phone) }}?text=আসসালামু আলাইকুম {{ $student->name }}, আমি আপনার কাউন্সেলর {{ $counsellor->name }} বলছি। আপনি আমাদের কোম্পানির {{$student->course->title}} কোর্সে রেজিষ্ট্রেশন করেছিলেন।" 
                                       target="_blank" class="btn btn-sm btn-outline-success" title="হোয়াটসঅ্যাপে মেসেজ দিন">
                                        <i class="mdi mdi-whatsapp"></i>
                                    </a>
                                </div>
                                <small class="d-block mt-1 text-dark fw-bold">{{ $student->phone }}</small>
                            </td>
                            <td>{{ date('d M, Y', strtotime($student->created_at)) }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-gradient-info text-white px-3" data-bs-toggle="modal" data-bs-target="#updateStatus{{ $student->id }}">
                                    <i class="mdi mdi-pencil"></i> আপডেট
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">কোনো নতুন স্টুডেন্ট পাওয়া যায়নি মামা! 🙄</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- স্ট্যাটাস আপডেটের জন্য একটি সিম্পল মডাল (এটি ট্র্যাকিং এর শুরুর ধাপ) --}}
@foreach($students as $student)
<div class="modal fade" id="updateStatus{{ $student->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('counsellor.student.update', $student->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">স্টুডেন্ট আপডেট: {{ $student->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">বর্তমান অবস্থা</label>
                        <select name="status" class="form-select border-primary">
                            <option value="0">পেন্ডিং (Inactive)</option>
                            <option value="1">ভর্তি নিশ্চিত (Active)</option>
                            <option value="2">আগ্রহী নয় (Rejected)</option>
                            <option value="3">ফলো-আপে আছে (Interested)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">কাউন্সেলর নোট</label>
                        <textarea name="note" class="form-control" rows="3" placeholder="স্টুডেন্ট সম্পর্কে কিছু লিখুন..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">সেভ করুন</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection