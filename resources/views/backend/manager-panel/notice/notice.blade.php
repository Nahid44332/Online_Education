@extends('backend.manager-panel.master')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-bullhorn"></i>
                </span> Manager Notices
            </h3>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="{{ route('manager.notice.create') }}" class="btn btn-gradient-primary btn-icon-text">
                            <i class="mdi mdi-plus btn-icon-prepend"></i> Create New Notice
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="row">
            @forelse ($notices as $notice)
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h4 class="card-title text-primary">{{ Str::limit($notice->title, 40) }}</h4>
                                @if ($notice->status)
                                    <i class="mdi mdi-check-circle text-success icon-sm"></i>
                                @else
                                    <i class="mdi mdi-clock text-warning icon-sm"></i>
                                @endif
                            </div>

                            <p class="card-description text-muted" style="min-height: 60px;">
                                {{ Str::limit($notice->description, 100) }}
                            </p>

                            <div class="py-2 border-top border-bottom mb-3">
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">
                                        <i class="mdi mdi-calendar"></i>
                                        {{ $notice->date ?? $notice->created_at->format('d M, Y') }}
                                    </small>

                                    <small class="text-muted">
                                        <i class="mdi mdi-account-circle"></i>
                                        @if($notice->author)
                                            {{ $notice->author->name }} ({{ ucfirst($notice->author->position) }})
                                        @else
                                            Admin
                                        @endif
                                    </small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Toggle Status Form -->
                                <form action="{{ route('manager.notice.status', $notice->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-sm {{ $notice->status ? 'btn-outline-warning' : 'btn-outline-success' }} btn-rounded">
                                        {{ $notice->status ? 'Unpublish' : 'Publish' }}
                                    </button>
                                </form>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-inverse-info btn-sm p-2 edit-notice-btn"
                                        data-bs-toggle="modal" data-bs-target="#editNoticeModal"
                                        data-id="{{ $notice->id }}" data-title="{{ $notice->title }}"
                                        data-description="{{ $notice->description }}" data-date="{{ $notice->date }}"
                                        data-status="{{ $notice->status }}">
                                        <i class="mdi mdi-pencil"></i>
                                    </button>
                                    <a href="{{ route('manager.notice.delete', $notice->id) }}"
                                        class="btn btn-inverse-danger btn-sm p-2"
                                        onclick="return confirm('মামা, নোটিশটা মুছে ফেলবেন?')" title="Delete">
                                        <i class="mdi mdi-delete"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div
                            class="card-footer text-center py-2 {{ $notice->status ? 'bg-gradient-success' : 'bg-gradient-secondary' }} text-white border-0">
                            <small class="font-weight-bold">{{ $notice->status ? 'LIVE' : 'HIDDEN' }}</small>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="bg-light rounded p-5">
                        <i class="mdi mdi-information-outline display-3 text-muted"></i>
                        <p class="mt-3 text-muted">মামা, এখনো কোনো নোটিশ দেওয়া হয়নি!</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        .card {
            transition: transform .2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .bg-gradient-success {
            background: linear-gradient(to right, #84d9d2, #07cdae);
        }

        .bg-gradient-secondary {
            background: linear-gradient(to right, #e7e9ec, #adb5bd);
        }

        .btn-inverse-info {
            background-color: rgba(25, 145, 235, 0.1);
            border: none;
            color: #1991eb;
        }

        .btn-inverse-danger {
            background-color: rgba(254, 112, 150, 0.1);
            border: none;
            color: #fe7096;
        }
    </style>
    <!-- Edit Notice Modal -->
    <div class="modal fade" id="editNoticeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Notice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editNoticeForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="fw-bold">Notice Title</label>
                            <input type="text" name="title" id="edit_title" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Date</label>
                                <input type="date" name="date" id="edit_date" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Status</label>
                                <select name="status" id="edit_status" class="form-select text-dark">
                                    <option value="1">Publish</option>
                                    <option value="0">Draft</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Description</label>
                            <textarea name="description" id="edit_description" class="form-control" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary text-white">Update Notice</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.edit-notice-btn').on('click', function() {
                // বাটন থেকে ডাটা নেওয়া
                let id = $(this).data('id');
                let title = $(this).data('title');
                let description = $(this).data('description');
                let date = $(this).data('date');
                let status = $(this).data('status');

                // মডালের ইনপুট ফিল্ডে ডাটা বসানো
                $('#edit_title').val(title);
                $('#edit_description').val(description);
                $('#edit_date').val(date);
                $('#edit_status').val(status);

                // ফর্মের অ্যাকশন ইউআরএল আপডেট করা
                let url = "{{ url('panel/manager/notice/update') }}/" + id;
                url = url.replace(':id', id);
                $('#editNoticeForm').attr('action', url);
            });
        });
    </script>
@endpush
