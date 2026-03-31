@extends('backend.master')

@section('content')
    <div class="container mt-5">
        <h3>Edit Admit Card</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{url('/admin/admit-card/update/'.$admitcard->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="student_id">Select Student</label>
                <select name="student_id" id="student_id" class="form-control">
                    <option value="">-- Select Student --</option>
                    @foreach ($student as $st)
                        <option value="{{ $st->id }}" @if ($admitcard->student_id == $st->id) selected @endif>
                            {{ $st->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="course">Course</label>
                <input type="text" name="course" id="course" value="{{ $admitcard->course }}" class="form-control"
                    placeholder="Enter course Name">
            </div>

            <div class="form-group mb-3">
                <label for="exam">Exam Name</label>
                <input type="text" name="exam" id="exam" value="{{ $admitcard->exam }}" class="form-control"
                    placeholder="Enter Exam Name">
            </div>

            <div class="form-group mb-3">
                <label for="exam_date">Exam Date</label>
                <input type="date" name="exam_date" id="exam_date" value="{{ $admitcard->exam_date }}"
                    class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="seat_no">Seat Number (Optional)</label>
                <input type="text" name="seat_no" id="seat_no" value="{{ $admitcard->seat_no }}" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Update Admit Card</button>
        </form>
    </div>
@endsection
