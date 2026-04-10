@extends('backend.master')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3>Generate Admit Card</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ url('/admin/admit-card/create/store') }}" method="POST">
                @csrf
                
                <div class="form-group mb-3">
                    <label for="student_id">Select Student</label>
                    <select name="student_id" id="student_id" class="form-control" required>
                        <option value="">-- Select Student --</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="course_id">Course</label>
                    <select name="course_id" id="course_id" class="form-control" required>
                        <option value="">-- Select Course --</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="exam">Exam Name</label>
                    <input type="text" name="exam" id="exam" class="form-control" placeholder="e.g. Final Examination" required>
                </div>

                <div class="form-group mb-3">
                    <label for="exam_date">Exam Date</label>
                    <input type="date" name="exam_date" id="exam_date" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="seat_no">Seat Number (Optional)</label>
                    <input type="text" name="seat_no" id="seat_no" class="form-control" placeholder="e.g. A-102">
                </div>

                <button type="submit" class="btn btn-success">Generate Admit Card</button>
            </form>
        </div>
    </div>
</div>
@endsection
@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // স্টুডেন্ট সিলেক্ট করলে এই ফাংশনটি চলবে
    $('#student_id').on('change', function() {
        var studentId = $(this).val();
        
        if (studentId) {
            $.ajax({
                // URL টি আপনার রাউটের সাথে মিলিয়ে নিন
               url: "{{ url('/admin/get-student-course') }}/" + studentId,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        // এই লাইনটি কোর্স ড্রপডাউনকে অটোমেটিক সিলেক্ট করে দেবে
                        $('#course_id').val(data.course_id).trigger('change');
                    } else {
                        $('#course_id').val('').trigger('change');
                        alert('এই স্টুডেন্টের কোনো কোর্স এসাইন করা নেই!');
                    }
                },
                error: function() {
                    console.log("AJAX error: ডাটা খুঁজে পাওয়া যায়নি।");
                }
            });
        } else {
            $('#course_id').val('').trigger('change');
        }
    });
});
</script>
@endpush