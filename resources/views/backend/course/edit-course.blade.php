@extends('backend.master')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4>Edit Course</h4>
            </div>
            <div class="card-body">
                <form action="{{url('/admin/course/update/'.$course->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="title">Course Title</label>
                        <input type="text" name="title" id="title" class="form-control"
                            value="{{ $course->title }}" placeholder="Enter course title">
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows="4" class="form-control"
                            placeholder="Enter course description">{{ $course->description }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="summery">Course Summery</label>
                        <textarea name="summery" id="summery" rows="4" class="form-control" placeholder="Enter course summery">{{ $course->summery }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="requrements">Course Requrements</label>
                        <textarea name="requrements" id="requrements" rows="4" class="form-control"
                            placeholder="Enter course requrements">{{ $course->requrements }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="duration">Duration</label>
                        <input type="text" name="duration" id="duration" class="form-control"
                            value="{{ $course->duration }}" placeholder="Ex: 3 Months, 6 Weeks">
                    </div>

                    <div class="form-group mb-3">
                        <label for="course_fee">Course Fee</label>
                        <input type="text" name="course_fee" id="course_fee" class="form-control"
                            value="{{ $course->course_fee }}" placeholder="Course Fee">
                    </div>

                    <div class="mb-3">
                        <label for="teacher_id" class="form-label">Select Teacher</label>
                        <select name="teacher_id" id="teacher_id" class="form-select">
                            <option selected disabled>-- Select Teacher --</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}"
                                    {{ $teacher->id == $course->teacher_id ? 'selected' : '' }}>
                                    {{ $teacher->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Course Image</label>
                        <input type="file" name="thumbnail" id="thumbnail" class="form-control">
                    </div>
                    <div>
                        <img src="{{asset('backend/images/courses/'.$course->thumbnail)}}" alt="" height="100" width="100" class="mb-3">
                    </div>
                    <button type="submit" class="btn btn-success">Update Course</button>
                </form>
            </div>
        </div>
    </div>
@endsection
