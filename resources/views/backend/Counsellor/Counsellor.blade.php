@extends('backend.master')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-white p-3 d-flex justify-content-between align-items-center" style="border-radius: 15px 15px 0 0;">
                    <h4 class="mb-0 text-primary fw-bold"><i class="mdi mdi-account-group me-2"></i>Counsellor List</h4>
                    <a href="{{ route('admin.counsellor.create') }}" class="btn btn-gradient-primary btn-sm text-white">
                        <i class="mdi mdi-plus me-1"></i> Add New Counsellor
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Phone</th>
                                    <th>Points</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($counsellors as $row)
                                <tr>
                                    <td>
                                        @if($row->profile_image)
                                            {{-- আপনার নতুন পাথ অনুযায়ী --}}
                                            <img src="{{ asset('backend/images/counsellor/'.$row->profile_image) }}" alt="image" class="rounded-circle shadow-sm" style="width: 45px; height: 45px; object-fit: cover; border: 2px solid #eee;">
                                        @else
                                            <img src="{{ asset('backend/assets/images/no-image.png') }}" alt="no-image" class="rounded-circle" style="width: 45px; height: 45px;">
                                        @endif
                                    </td>
                                    <td class="text-start">
                                        <div class="fw-bold text-dark">{{ $row->name }}</div>
                                        <small class="text-muted"><i class="mdi mdi-email-outline me-1"></i>{{ $row->email }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light-info text-info px-3">{{ $row->designation ?? 'N/A' }}</span>
                                    </td>
                                    <td class="fw-bold text-muted">{{ $row->phone ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-soft-success text-success fw-bold p-2">
                                            <i class="mdi mdi-star me-1"></i>{{ $row->points }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($row->status == 1)
                                            <span class="badge rounded-pill bg-success">Active</span>
                                        @else
                                            <span class="badge rounded-pill bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="javascript:void(0)" onclick="editCounsellor({{ json_encode($row) }})" class="btn btn-sm btn-outline-primary"><i class="mdi mdi-pencil"></i></a>
                                            <a href="{{ route('admin.counsellor.delete', $row->id) }}" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('মামা, সত্যিই কি ডিলিট করবেন?')">
                                                <i class="mdi mdi-trash-can"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center p-5 text-muted">কোনো কাউন্সেলর ডাটা পাওয়া যায়নি মামা!</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editCounsellorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edit Counsellor Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Designation</label>
                            <input type="text" name="designation" id="edit_designation" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" id="edit_phone" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" id="edit_status" class="form-select">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Profile Image (Leave blank to keep current)</label>
                            <input type="file" name="profile_image" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .bg-light-info { background-color: #e7f6f8 !important; }
    .bg-soft-success { background-color: #e8f9f0 !important; }
    .btn-gradient-primary {
        background: linear-gradient(45deg, #4e73df 0%, #224abe 100%);
        border: none;
    }
    .table thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
        color: #555;
        border-bottom: 2px solid #f8f9fc;
    }
    .dropdown-item { font-size: 13px; padding: 8px 15px; }
    .dropdown-item:hover { background-color: #f8f9fc; }
</style>
@endsection
@push('script')
    <script>
    function editCounsellor(data) {
        // মডালের ইনপুট ফিল্ডে ডাটা বসানো
        document.getElementById('edit_name').value = data.name;
        document.getElementById('edit_designation').value = data.designation;
        document.getElementById('edit_phone').value = data.phone;
        document.getElementById('edit_status').value = data.status;
        
        // ফর্মের অ্যাকশন ইউআরএল ডাইনামিক করা
        let updateUrl = "{{ route('admin.counsellor.update', ':id') }}";
        updateUrl = updateUrl.replace(':id', data.id);
        document.getElementById('editForm').action = updateUrl;
        
        // মডাল শো করা
        var myModal = new bootstrap.Modal(document.getElementById('editCounsellorModal'));
        myModal.show();
    }
</script>
@endpush