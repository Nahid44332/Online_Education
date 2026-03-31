@extends('backend.master')
@section('content')

<div class="container mt-3">
    <h3>Edit Student Result</h3>

    <form action="{{url('/admin/student/resule/update/'.$result->id)}}" method="POST">
        @csrf
        <!-- Select Student -->
        <div class="mb-3">
            <label for="student_id" class="form-label">Select Student</label>
            <select name="student_id" class="form-control" required>
                <option value="">-- Select Student --</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}" 
                        {{ $result->student_id == $student->id ? 'selected' : '' }}>
                        {{ $student->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Total Marks -->
        <div class="mb-3">
            <label for="total_marks" class="form-label">Total Marks</label>
            <input type="number" name="total_marks" class="form-control" value="{{ $result->total_marks }}" required>
        </div>

        <!-- Obtained Marks -->
        <div class="mb-3">
            <label for="marks_obtained" class="form-label">Marks Obtained</label>
            <input type="number" name="marks_obtained" class="form-control" value="{{ $result->marks_obtained }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update Result</button>
        <a href="{{ url('/admin/student/result') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

@endsection
