@extends('backend.master')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4>Add New Course</h4>
            </div>
            <div class="card-body">
                <form action="{{url('/admin/course/store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="title">Course Title</label>
                        <input type="text" name="title" id="title" class="form-control"
                            placeholder="Enter course title" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows="4" class="form-control"
                            placeholder="Enter course description"></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="summery">Course Summery</label>
                        <textarea name="summery" id="summery" rows="4" class="form-control"
                            placeholder="Enter course summery"></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="requrements">Course Requrements</label>
                        <textarea name="requrements" id="requrements" rows="4" class="form-control"
                            placeholder="Enter course requrements"></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="duration">Duration</label>
                        <input type="text" name="duration" id="duration" class="form-control"
                            placeholder="Ex: 3 Months, 6 Weeks" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="course_fee">Course Fee</label>
                        <input type="text" name="course_fee" id="course_fee" class="form-control"
                            placeholder="Course Fee" required>
                    </div>

                    <div class="mb-3">
                        <label for="teacher_id" class="form-label">Select Teacher <span class="text-danger">*</span></label>
                        <select name="teacher_id" id="teacher_id" class="form-select" required>
                            <option selected disabled>-- Select Teacher --</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Course Image <span class="text-danger">*</span></label>
                        <input type="file" name="thumbnail" id="thumbnail" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Create Course</button>
                </form>
            </div>
        </div>
    </div>
@endsection
