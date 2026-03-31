@extends('backend.master')
@section('content')
<div class="container mt-4">

    <h3 class="mb-4">Generate Certificate</h3>

    <form action="{{url('/admin/student/certificate/store')}}" method="POST">
        @csrf

        <!-- Select Student -->
        <div class="mb-3">
            <label for="student_id" class="form-label">Select Student</label>
            <select name="student_id" id="student_id" class="form-control" required>
                <option value="">-- Select Student --</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }} (ID: {{ $student->id }})</option>
                @endforeach
            </select>
        </div>

        <!-- Select Course -->
        <div class="mb-3">
            <label for="course_id" class="form-label">Select Course</label>
            <select name="course_id" id="course_id" class="form-control" required>
                <option value="">-- Select Course --</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                @endforeach
            </select>
        </div>

        <!-- Issue Date -->
        <div class="mb-3">
            <label for="issue_date" class="form-label">Issue Date</label>
            <input type="date" name="issue_date" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>

        <!-- Certificate No (Auto Generated - readonly) -->
        <div class="mb-3">
            <label for="certificate_no" class="form-label">Certificate No</label>
            <input type="text" name="certificate_no" class="form-control" value="Auto Generate" readonly>
        </div>

        <button type="submit" class="btn btn-success">Generate</button>
        <a href="{{url('/admin/student/certificate')}}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
