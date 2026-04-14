@extends('backend.master')

@section('content')
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                {{-- কার্ড হেডার --}}
                <div class="card-header bg-primary text-white py-3" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0 fw-bold"><i class="fa-solid fa-plus-circle me-2"></i> Create Student Result</h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{url('/admin/student/result/store')}}" method="POST">
                        @csrf
                        
                        {{-- স্টুডেন্ট সিলেক্ট --}}
                        <div class="mb-4">
                            <label for="student_id" class="form-label fw-bold text-dark">Select Student</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fa-solid fa-user-graduate"></i></span>
                                <select name="student_id" id="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
                                    <option value="" selected disabled>-- Choose a Student --</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }} (ID: {{ $student->id }})</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('student_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="row">
                            {{-- টোটাল মার্কস --}}
                            <div class="col-md-6 mb-4">
                                <label for="total_marks" class="form-label fw-bold text-dark">Total Marks</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-solid fa-clipboard-list"></i></span>
                                    <input type="number" name="total_marks" id="total_marks" class="form-control" placeholder="e.g. 100" required>
                                </div>
                            </div>

                            {{-- প্রাপ্ত নম্বর --}}
                            <div class="col-md-6 mb-4">
                                <label for="marks_obtained" class="form-label fw-bold text-dark">Marks Obtained</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-solid fa-star"></i></span>
                                    <input type="number" name="marks_obtained" id="marks_obtained" class="form-control" placeholder="e.g. 85" required>
                                </div>
                            </div>
                        </div>

                        {{-- বাটন গ্রুপ --}}
                        <div class="d-flex gap-2 mt-2">
                            <button type="submit" class="btn btn-success px-4 shadow-sm">
                                <i class="fa-solid fa-save me-1"></i> Save Result
                            </button>
                            <a href="{{url('/admin/student/result')}}" class="btn btn-outline-secondary px-4">
                                <i class="fa-solid fa-arrow-left me-1"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ফর্ম ইনপুট ফোকাস স্টাইল */
    .form-control:focus, .form-select:focus {
        border-color: #4b49ac;
        box-shadow: 0 0 0 0.2rem rgba(75, 73, 172, 0.1);
    }
    /* ইনপুট গ্রুপ আইকন স্টাইল */
    .input-group-text {
        border-right: none;
        color: #6c757d;
    }
    .form-control, .form-select {
        border-left: none;
    }
</style>
@endsection