@extends('backend.manager-panel.master')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Course List </h3>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">All Available Courses</h4>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th> Thumbnail </th>
                                        <th> Course Name </th>
                                        <th> Student Count </th>
                                        <th> Price </th>
                                        <th> Duration </th>
                                        <th> Status </th>
                                        <th> Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($courses as $course)
                                        <tr>
                                            <td class="py-1">
                                                <img src="{{ asset('backend/images/courses/' . $course->thumbnail) }}"
                                                    style="width: 70px; height: 45px; border-radius: 4px; object-fit: cover;" />
                                            </td>
                                            <td>
                                                <span class="font-weight-bold">{{ $course->title }}</span><br>
                                                <small class="text-muted">ID: #CR-{{ $course->id }}</small>
                                            </td>
                                            <td>
                                                <div class="badge badge-gradient-info d-flex align-items-center"
                                                    style="gap: 5px; width: fit-content;">
                                                    <i class="mdi mdi-account-group"></i>
                                                    <span class="font-weight-bold">{{ $course->students_count }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-primary font-weight-bold">{{ $course->course_fee }}
                                                    TK</span>
                                            </td>
                                            <td> <i class="mdi mdi-clock-outline"></i> {{ $course->duration ?? 'N/A' }}
                                            </td>
                                            <td>
                                                <label class="badge badge-success">Active</label>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-outline-primary"
                                                        onclick="editCourse({{ $course->id }})" title="Edit">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editCourseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title">Edit Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('manager.course.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="course_id" id="edit_course_id">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label>Course Title</label>
                            <input type="text" name="title" id="edit_title" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Price (TK)</label>
                            <input type="number" name="course_fee" id="edit_course_fee" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Current Thumbnail</label><br>
                            <img id="current_img" src="" style="width: 100px; border-radius: 5px;" class="mb-2">
                            <input type="file" name="thumbnail" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="submit" class="btn btn-gradient-primary w-100">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        function editCourse(id) {
            $.ajax({
                url: "{{ url('panel/manager/course/edit') }}/" + id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#edit_course_id').val(data.id);
                    $('#edit_title').val(data.title);
                    $('#edit_course_fee').val(data.course_fee);
                    $('#current_img').attr('src', "{{ asset('backend/images/courses/') }}/" + data.thumbnail);

                    var myModal = new bootstrap.Modal(document.getElementById('editCourseModal'));
                    myModal.show();
                },
                error: function() {
                    alert("ডাটা আনতে সমস্যা হচ্ছে মামা!");
                }
            });
        }
    </script>
@endpush
