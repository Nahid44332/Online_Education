@extends('backend.teacher-panel.TS-master')
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4 border-0">
            <div class="card-header py-3 d-flex justify-content-between align-items-center bg-white">
                <h6 class="m-0 font-weight-bold text-primary"><i class="mdi mdi-account-group me-2"></i>My Student List</h6>

                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-success shadow-sm px-3 py-2 text-white me-2 border-0">
                        <i class="mdi mdi-database-export me-1"></i>
                        My Points: <strong>{{$teacher->points}}</strong> pts
                    </span>
                    <span class="badge bg-info shadow-sm px-3 text-white">Total Students: {{ $students->count() }}</span>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" width="100%">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Contact Info</th>
                                <th>Join Date</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-bold text-secondary">#{{ $student->id }}</td>
                                    <td class="fw-bold">{{ $student->name }}</td>
                                    <td>
                                        <small class="d-block text-muted"><i class="mdi mdi-email-outline"></i>
                                            {{ $student->email }}</small>
                                        <small class="d-block text-muted"><i class="mdi mdi-phone-outline"></i>
                                            {{ $student->phone ?? 'N/A' }}</small>
                                    </td>
                                    <td>{{ $student->created_at->format('d M, Y') }}</td>
                                    <td>
                                        <span class="badge {{ $student->status == '1' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $student->status == '1' ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-warning shadow-sm"
                                            data-bs-toggle="modal" data-bs-target="#giftModal{{ $student->id }}">
                                            <i class="mdi mdi-gift-outline"></i> Gift Point
                                        </button>
                                    </td>
                                </tr>

                                <div class="modal fade" id="giftModal{{ $student->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                        <div class="modal-content border-0 shadow">
                                            <form action="{{ route('teacher.gift.point') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                <div class="modal-header border-0 bg-light">
                                                    <h6 class="modal-title fw-bold">Gift to {{ $student->name }}</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center py-4">
                                                    <p class="text-muted small mb-3">Your Balance: <b
                                                            class="text-success">{{$teacher->points}}
                                                            pts</b></p>

                                                    <div class="mb-3">
                                                        <i class="mdi mdi-gift text-warning" style="font-size: 3rem;"></i>
                                                        <label class="d-block small fw-bold mt-2 text-uppercase">Enter
                                                            Amount</label>
                                                        <input type="number" name="amount"
                                                            class="form-control text-center fw-bold border-primary shadow-sm"
                                                            placeholder="00" min="1"
                                                            max="{{$teacher->points}}" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 p-0">
                                                    <button type="submit"
                                                        class="btn btn-success btn-lg w-100 m-0 rounded-0 rounded-bottom">
                                                        Send Gift 🎁
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        আপনার কোর্সে এখন পর্যন্ত কোনো স্টুডেন্ট এনরোল করেনি।
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
