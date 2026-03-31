@extends('backend.master')
@section('content')
<form action="{{url('/admin/student/result/store')}}" method="POST">
    @csrf
    <!-- Select Student -->
    <div class="mb-3">
        <label for="student_id" class="form-label">Select Student</label>
        <select name="student_id" class="form-control" required>
            <option value="">-- Select Student --</option>
            @foreach($students as $student)
                <option value="{{ $student->id }}">{{ $student->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Total Marks -->
    <div class="mb-3">
        <label for="total_marks" class="form-label">Total Marks</label>
        <input type="number" name="total_marks" class="form-control" required>
    </div>

    <!-- Obtained Marks -->
    <div class="mb-3">
        <label for="marks_obtained" class="form-label">Marks Obtained</label>
        <input type="number" name="marks_obtained" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success mb-5">Submit</button>
    <a href="{{url('/admin/student/result')}}" class="btn btn-secondary mb-5">Back</a>
</form>
@endsection