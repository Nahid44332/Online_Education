@extends('backend.master')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 text-primary fw-bold">Helpline Management</h4>
                        <button type="button" class="btn btn-primary rounded-pill shadow-sm" data-bs-toggle="modal"
                            data-bs-target="#addHelpline">
                            <i class="ri-user-add-line align-middle me-1"></i> Add Support Staff
                        </button>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0" style="border-radius: 20px;">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-hover align-middle mb-0 text-center">
                                    <thead class="table-light">
                                        <tr class="text-uppercase small fw-bold">
                                            <th>SL</th>
                                            <th>Photo</th>
                                            <th class="text-start">Staff Info</th>
                                            <th style="width: 180px;">Wallet Points</th>
                                            <th>Contact</th>
                                            <th>Shift</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($staffs as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <img src="{{ !empty($item->helpline->image) ? asset($item->helpline->image) : asset('backend/images/no_image.jpg') }}"
                                                        class="rounded-circle avatar-sm img-thumbnail"
                                                        style="width: 50px; height: 50px; object-fit: cover;"
                                                        alt="staff-photo">
                                                </td>
                                                <td class="text-start">
                                                    <h6 class="mb-0 fw-bold">{{ $item->name }}</h6>
                                                    <small class="text-muted">{{ $item->email }}</small>
                                                </td>

                                                {{-- পয়েন্ট অ্যাড করার সেকশন --}}
                                                <td>
                                                    <div class="mb-1">
                                                        <span class="badge px-3 text-white" style="background: linear-gradient(90deg, #11998e 0%, #38ef7d 100%); border:none; border-radius: 50px;">
                                                            ৳ {{ number_format($item->helpline->points ?? 0, 2) }}
                                                        </span>
                                                    </div>
                                                    <form action="{{ route('admin.add.helpline.points') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="subadmin_id" value="{{ $item->id }}">
                                                        <div class="input-group input-group-sm mt-1">
                                                            <input type="number" name="amount" class="form-control" placeholder="Point" required>
                                                            <button class="btn btn-success text-white" type="submit">
                                                                <i class="mdi mdi-plus"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </td>

                                                <td><i class="ri-phone-line text-success me-1"></i>
                                                    {{ $item->helpline->phone ?? 'N/A' }}</td>
                                                <td><span
                                                        class="badge bg-soft-info text-info text-capitalize">{{ $item->helpline->shift ?? 'N/A' }}</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge {{ $item->status == 1 ? 'bg-success' : 'bg-danger' }} rounded-pill">
                                                        {{ $item->status == 1 ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" onclick="editStaff({{ $item->id }})"
                                                            class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1">
                                                            <i class="ri-pencil-line"></i> Edit
                                                        </a>
                                                        <a href="{{ route('admin.helpline.delete', $item->id) }}"
                                                            id="delete" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                            <i class="ri-delete-bin-line"></i> Delete
                                                        </a>
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
    </div>

    <div class="modal fade" id="addHelpline" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="modal-title fw-bold text-primary">New Helpline Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.helpline.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Full Name</label>
                                <input type="text" name="name" class="form-control bg-light border-0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email Address</label>
                                <input type="email" name="email" class="form-control bg-light border-0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Phone Number</label>
                                <input type="text" name="phone" class="form-control bg-light border-0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Login Password</label>
                                <input type="password" name="password" class="form-control bg-light border-0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Blood Group</label>
                                <select name="blood" class="form-select bg-light border-0">
                                    <option value="">Select Blood</option>
                                    <option value="A+">A+</option>
                                    <option value="B+">B+</option>
                                    <option value="O+">O+</option>
                                    <option value="AB+">AB+</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Duty Shift</label>
                                <select name="shift" class="form-select bg-light border-0">
                                    <option value="day">Day Shift</option>
                                    <option value="night">Night Shift</option>
                                </select>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="form-label fw-semibold">Address</label>
                                <input type="text" name="address" class="form-control bg-light border-0">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Profile Photo</label>
                                <input type="file" name="image" class="form-control bg-light border-0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 shadow">Save Staff</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editHelpline" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="modal-title fw-bold text-info">Edit Helpline Manager</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.helpline.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="staff_id">
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Full Name</label>
                                <input type="text" name="name" id="edit_name" class="form-control bg-light border-0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email Address</label>
                                <input type="email" name="email" id="edit_email" class="form-control bg-light border-0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Phone Number</label>
                                <input type="text" name="phone" id="edit_phone" class="form-control bg-light border-0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Password (Leave blank to keep same)</label>
                                <input type="password" name="password" class="form-control bg-light border-0">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Blood Group</label>
                                <select name="blood" id="edit_blood" class="form-select bg-light border-0">
                                    <option value="A+">A+</option>
                                    <option value="B+">B+</option>
                                    <option value="O+">O+</option>
                                    <option value="AB+">AB+</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Shift</label>
                                <select name="shift" id="edit_shift" class="form-select bg-light border-0">
                                    <option value="day">Day Shift</option>
                                    <option value="night">Night Shift</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Profile Photo</label>
                                <input type="file" name="image" class="form-control bg-light border-0">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Address</label>
                                <textarea name="address" id="edit_address" class="form-control bg-light border-0" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="submit" class="btn btn-info rounded-pill px-5 shadow">Update Staff</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
  function editStaff(id) {
    // লারাভেল রাউট নাম ব্যবহার করে ইউআরএল জেনারেট করা
    let url = "{{ route('admin.helpline.edit', ':id') }}";
    url = url.replace(':id', id);

    $.ajax({
        type: 'GET',
        url: url,
        dataType: 'json',
        success: function(data) {
            $('#staff_id').val(data.id);
            $('#edit_name').val(data.name);
            $('#edit_email').val(data.email);
            
            if(data.helpline){
                $('#edit_phone').val(data.helpline.phone);
                $('#edit_blood').val(data.helpline.blood);
                $('#edit_shift').val(data.helpline.shift);
                $('#edit_address').val(data.helpline.address);
            }
            $('#editHelpline').modal('show');
        },
        error: function(xhr) {
            // যদি ৪0৪ আসে, তবে টার্মিনালে 'php artisan route:clear' দিন
            alert('মামা, রাউট মিলছে না! ক্লিয়ার ক্যাশ দিয়ে ট্রাই করেন।');
        }
    });
}
</script>
@endpush