@extends('backend.master')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-header bg-white p-3 d-flex justify-content-between align-items-center"
                        style="border-radius: 15px 15px 0 0;">
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
                                                @if ($row->profile_image)
                                                    <img src="{{ asset('backend/images/counsellor/' . $row->profile_image) }}"
                                                        alt="image" class="rounded-circle shadow-sm"
                                                        style="width: 45px; height: 45px; object-fit: cover; border: 2px solid #eee;">
                                                @else
                                                    <img src="{{ asset('backend/assets/images/no-image.png') }}"
                                                        alt="no-image" class="rounded-circle"
                                                        style="width: 45px; height: 45px;">
                                                @endif
                                            </td>
                                            <td class="text-start">
                                                <div class="fw-bold text-dark">{{ $row->name }}</div>
                                                <small class="text-muted"><i
                                                        class="mdi mdi-email-outline me-1"></i>{{ $row->email }}</small>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-light-info text-info px-3">{{ $row->designation ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                {{-- ব্যালেন্স ডিসপ্লে --}}
                                                <div class="mb-1">
                                                    <span class="badge px-3 text-white"
                                                        style="background: linear-gradient(90deg, #11998e 0%, #38ef7d 100%); font-size: 11px;">
                                                        ৳ {{ number_format($row->points ?? 0, 2) }}
                                                    </span>
                                                </div>

                                                {{-- ছোট এবং স্লিম ইনপুট ফর্ম --}}
                                                <form action="{{ route('admin.add.counsellor.points') }}" method="POST"
                                                    class="d-flex justify-content-center">
                                                    @csrf
                                                    <input type="hidden" name="counsellor_id" value="{{ $row->id }}">
                                                    <div class="input-group input-group-sm" style="width: 100px;">
                                                        {{-- উইডথ ১০০ পিক্সেল করে দিলাম --}}
                                                        <input type="number" name="points"
                                                            class="form-control form-control-sm border-success"
                                                            placeholder="0.00" required step="0.01"
                                                            style="font-size: 11px; padding: 2px 5px;">
                                                        <button class="btn btn-success btn-sm text-white" type="submit"
                                                            style="padding: 0 8px;">
                                                            <i class="mdi mdi-plus"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="fw-bold text-muted">{{ $row->phone ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-soft-success text-success fw-bold p-2">
                                                    <i class="mdi mdi-star me-1"></i>{{ $row->points }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill {{ $row->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $row->status == 1 ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    {{-- এডিট বাটন --}}
                                                    <a href="javascript:void(0)"
                                                        onclick="editCounsellor({{ json_encode($row) }})"
                                                        class="btn btn-sm btn-outline-primary" title="Edit">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
                                                    {{-- লগ ভিউ বাটন --}}
                                                    <button type="button" class="btn btn-sm btn-outline-warning"
                                                        onclick="viewCounsellorLogs({{ $row->id }}, '{{ $row->name }}')"
                                                        title="View Logs">
                                                        <i class="mdi mdi-eye"></i>
                                                    </button>
                                                    {{-- ডিলিট বাটন --}}
                                                    <a href="{{ route('admin.counsellor.delete', $row->id) }}"
                                                        class="btn btn-sm btn-outline-danger" title="Delete"
                                                        onclick="return confirm('মামা, সত্যিই কি ডিলিট করবেন?')">
                                                        <i class="mdi mdi-trash-can"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center p-5 text-muted">কোনো কাউন্সেলর ডাটা পাওয়া
                                                যায়নি মামা!</td>
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

    {{-- ১. এডিট কাউন্সেলর মডাল (পয়েন্টসহ) --}}
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
                                <label class="form-label">Points</label>
                                <input type="number" name="points" id="edit_points" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" id="edit_status" class="form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Profile Image</label>
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

    {{-- ২. স্টুডেন্ট লগ ভিউ মডাল --}}
    <div class="modal fade" id="viewLogsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title fw-bold" id="log_modal_title">Student Updates</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>Latest Status</th>
                                    <th>Note</th>
                                    <th>Update Date</th>
                                </tr>
                            </thead>
                            <tbody id="logs_table_body">
                                {{-- AJAX ডাটা এখানে আসবে --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-light-info {
            background-color: #e7f6f8 !important;
        }

        .bg-soft-success {
            background-color: #e8f9f0 !important;
        }

        .btn-gradient-primary {
            background: linear-gradient(45deg, #4e73df 0%, #224abe 100%);
            border: none;
        }
    </style>
@endsection

@push('script')
    <script>
        // ১. এডিট মডাল ফাংশন
        function editCounsellor(data) {
            document.getElementById('edit_name').value = data.name;
            document.getElementById('edit_designation').value = data.designation;
            document.getElementById('edit_phone').value = data.phone;
            document.getElementById('edit_status').value = data.status;
            document.getElementById('edit_points').value = data.points;

            let updateUrl = "{{ route('admin.counsellor.update', ':id') }}";
            updateUrl = updateUrl.replace(':id', data.id);
            document.getElementById('editForm').action = updateUrl;

            var editModal = new bootstrap.Modal(document.getElementById('editCounsellorModal'));
            editModal.show();
        }

        // ২. কাউন্সেলর অনুযায়ী স্টুডেন্ট লগ দেখা
        function viewCounsellorLogs(counsellorId, counsellorName) {
            document.getElementById('log_modal_title').innerText = "Student Updates by: " + counsellorName;
            document.getElementById('logs_table_body').innerHTML =
                '<tr><td colspan="4" class="text-center">লোড হচ্ছে মামা... ⏳</td></tr>';

            var logsModal = new bootstrap.Modal(document.getElementById('viewLogsModal'));
            logsModal.show();

            // সরাসরি ইউআরএল না লিখে লারাভেলের রুট ব্যবহার করা ভালো
            let url = "{{ route('admin.counsellor.logs', ':id') }}".replace(':id', counsellorId);

            fetch(url)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    let html = '';
                    if (data.length > 0) {
                        data.forEach(log => {
                            let statusBadge = '';
                            if (log.status == 0) statusBadge =
                                '<span class="badge bg-secondary">Pending</span>';
                            else if (log.status == 1) statusBadge =
                                '<span class="badge bg-success">Active</span>';
                            else if (log.status == 2) statusBadge =
                                '<span class="badge bg-danger">Rejected</span>';
                            else if (log.status == 3) statusBadge =
                                '<span class="badge bg-info">Interested</span>';

                            html += `<tr>
                        <td class="fw-bold">${log.student_id}</td>
                        <td class="fw-bold">${log.student_name}</td>
                        <td>${statusBadge}</td>
                        <td class="text-start">${log.note ? log.note : 'নোট নেই'}</td>
                        <td>${new Date(log.created_at).toLocaleDateString()}</td>
                    </tr>`;
                        });
                    } else {
                        html =
                            '<tr><td colspan="4" class="text-center text-danger">এই কাউন্সেলর এখনো কোনো আপডেট দেয়নি!</td></tr>';
                    }
                    document.getElementById('logs_table_body').innerHTML = html;
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('logs_table_body').innerHTML =
                        '<tr><td colspan="4" class="text-center text-danger">ডাটা আনতে সমস্যা হয়েছে মামা! ❌</td></tr>';
                });
        }
    </script>
@endpush
