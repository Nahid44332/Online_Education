@extends('backend.team-leader-panel.tl-master')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-account-card-details"></i>
                </span> Trainer List
            </h3>
            <a href="{{ route('team_leader.trainers.create') }}" class="btn btn-gradient-primary btn-icon-text">
                <i class="mdi mdi-plus btn-icon-prepend"></i> Add New Trainer
            </a>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title">Manage Your Trainers</h4>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th> Photo </th>
                                        <th> Name </th>
                                        <th> Email / Phone </th>
                                        <th> Designation </th>
                                        <th> Assigned Students </th>
                                        <th> Points </th>
                                        <th> Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($trainers as $trainer)
                                        <tr>
                                            <td class="py-1">
                                                <img src="{{ $trainer->profile_image ? asset('backend/images/trainer/' . $trainer->profile_image) : asset('backend/images/default.png') }}"
                                                    alt="image"
                                                    style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;" />
                                            </td>
                                            <td class="font-weight-bold"> {{ $trainer->trainer_name }} </td>
                                            <td>
                                                <small><i class="mdi mdi-email-outline"></i>
                                                    {{ $trainer->email }}</small><br>
                                                <small><i class="mdi mdi-phone"></i> {{ $trainer->phone ?? 'N/A' }}</small>
                                            </td>
                                            <td> <label
                                                    class="badge badge-gradient-info">{{ $trainer->designation ?? 'Trainer' }}</label>
                                            </td>
                                            <td class="text-center">
                                                {{ DB::table('students')->where('trainer_id', $trainer->id)->count() }}
                                            </td>
                                            <td> <span class="text-primary font-weight-bold">{{ $trainer->points }}</span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    {{-- Assign Button --}}
                                                    <a href="{{ route('team_leader.trainers.assign', $trainer->id) }}"
                                                        class="btn btn-sm btn-inverse-primary" title="Assign Students">
                                                        <i class="mdi mdi-account-plus"></i>
                                                    </a>
                                                    {{-- Edit Button --}}
                                                    <a href="javascript:void(0)" onclick="editTrainer({{ json_encode($trainer) }})" 
                                                        class="btn btn-sm btn-inverse-warning" title="Edit">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
                                                    {{-- Delete Button --}}
                                                    <button type="button" onclick="deleteTrainer({{ $trainer->id }})" 
                                                        class="btn btn-sm btn-inverse-danger" title="Delete">
                                                        <i class="mdi mdi-delete"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if ($trainers->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">No trainers found. Create one to get started!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Trainer Modal --}}
    <div class="modal fade" id="editTrainerModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Trainer Details</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editTrainerForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Full Name</label>
                                <input type="text" name="name" id="edit_name" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Phone</label>
                                <input type="text" name="phone" id="edit_phone" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Designation</label>
                                <input type="text" name="designation" id="edit_designation" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Blood Group</label>
                                <select name="blood" id="edit_blood" class="form-control text-dark">
                                    <option value="A+">A+</option><option value="A-">A-</option>
                                    <option value="B+">B+</option><option value="B-">B-</option>
                                    <option value="O+">O+</option><option value="O-">O-</option>
                                    <option value="AB+">AB+</option><option value="AB-">AB-</option>
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Facebook Link</label>
                                <input type="url" name="facebook_link" id="edit_fb" class="form-control">
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Profile Image (Leave blank to keep current)</label>
                                <input type="file" name="profile_image" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-gradient-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div class="modal fade" id="deleteTrainerModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-body p-4">
                    <i class="mdi mdi-alert-circle-outline text-danger" style="font-size: 50px;"></i>
                    <h4 class="mt-2">Are you sure?</h4>
                    <p class="text-muted">This trainer and their login access will be permanently deleted.</p>
                </div>
                <form id="deleteTrainerForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-footer justify-content-center border-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete It</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function editTrainer(trainer) {
            let url = "{{ route('team_leader.trainers.update', ':id') }}";
            url = url.replace(':id', trainer.id);
            $('#editTrainerForm').attr('action', url);

            // Fill fields with trainer data
            $('#edit_name').val(trainer.name); 
            $('#edit_phone').val(trainer.phone);
            $('#edit_designation').val(trainer.designation);
            $('#edit_blood').val(trainer.blood);
            $('#edit_fb').val(trainer.facebook_link);

            $('#editTrainerModal').modal('show');
        }

        function deleteTrainer(id) {
            let url = "{{ route('team_leader.trainers.delete', ':id') }}";
            url = url.replace(':id', id);
            $('#deleteTrainerForm').attr('action', url);
            $('#deleteTrainerModal').modal('show');
        }
    </script>
@endpush