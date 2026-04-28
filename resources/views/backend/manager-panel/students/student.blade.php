@extends('backend.manager-panel.master')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Students List </h3>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">All Enrolled Students</h4>
                        <p class="card-description"> Manage your students and their status </p>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th> ID </th>
                                        <th> Photo </th>
                                        <th> Name </th>
                                        <th> Course </th>
                                        <th>Points</th>
                                        <th> Status </th>
                                        <th> Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr>
                                            <td> #ST-{{ $student->id }} </td>
                                            <td class="py-1">
                                                <img src="{{ asset('backend/images/students/' . $student->image) }}"
                                                    alt="image" style="width: 40px; height: 40px; border-radius: 8px;" />
                                            </td>
                                            <td>
                                                <span class="font-weight-bold">{{ $student->name }}</span><br>
                                                <small class="text-muted">{{ $student->phone }}</small>
                                            </td>
                                            <td> {{ $student->course->title ?? 'N/A' }} </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span
                                                        class="badge badge-gradient-info me-2">{{ $student->points }}</span>
                                                    <button type="button" class="btn btn-inverse-primary btn-icon btn-sm"
                                                        onclick="givePoint({{ $student->id }}, '{{ $student->name }}', {{ $student->points }})">
                                                        <i class="mdi mdi-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($student->status == '1')
                                                    <span class="text-success"><i class="mdi mdi-record"></i> Active</span>
                                                @else
                                                    <span class="text-danger"><i class="mdi mdi-record"></i> Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="#" class="btn btn-sm btn-outline-info" title="View"><i
                                                            class="mdi mdi-eye"></i></a>
                                                    <a href="#" class="btn btn-sm btn-outline-warning"
                                                        title="Edit"><i class="mdi mdi-pencil"></i></a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        title="Delete"><i class="mdi mdi-delete"></i></button>
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
    <div class="modal fade" id="pointModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Give Points to <span id="studentName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('students.updatePoints') }}" method="POST">
                @csrf
                <input type="hidden" name="student_id" id="modal_student_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Current Points: <b id="currentPoints"></b></label>
                        <input type="number" name="points" class="form-control" placeholder="Enter points (e.g. 10 or -5)" required>
                        <small class="text-muted">পয়েন্ট যোগ করতে পজিটিভ (১০) আর কমাতে নেগেটিভ (-৫) নাম্বার দিন।</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-gradient-primary">Update Points</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('script')
    <script>
function givePoint(id, name, points) {
    document.getElementById('modal_student_id').value = id;
    document.getElementById('studentName').innerText = name;
    document.getElementById('currentPoints').innerText = points;
    var myModal = new bootstrap.Modal(document.getElementById('pointModal'));
    myModal.show();
}
</script>
@endpush