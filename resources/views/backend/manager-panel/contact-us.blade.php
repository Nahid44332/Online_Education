@extends('backend.manager-panel.master')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-account-card-details"></i>
                </span> Contact Messages
            </h3>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        <span>Contact List</span> <i
                            class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Latest Inquiries</h4>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="py-3">Sender Info</th>
                                        <th class="py-3">Message Snippet</th>
                                        <th class="py-3 text-center">Date</th>
                                        <th class="py-3 text-center">Quick Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($messages as $msg)
                                        <tr>
                                            <td class="py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle me-3">
                                                        <span
                                                            class="initials">{{ strtoupper(substr($msg->name, 0, 1)) }}</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-0 fw-bold">{{ $msg->name }}</p>
                                                        <small class="text-muted">{{ $msg->phone }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3 text-wrap" style="max-width: 250px;">
                                                <p class="mb-0 text-dark small">{{ Str::limit($msg->message, 80) }}</p>
                                            </td>
                                            <td class="py-3 text-center">
                                                <small
                                                    class="text-muted">{{ $msg->created_at->format('d M, Y') }}</small><br>
                                                <small
                                                    style="font-size: 10px;">{{ $msg->created_at->diffForHumans() }}</small>
                                            </td>
                                            <td class="py-3 text-center">
                                                {{-- হোয়াটসঅ্যাপ লজিক --}}
                                                @php
                                                    $cleanPhone = preg_replace('/[^0-9]/', '', $msg->phone);
                                                    if (strlen($cleanPhone) == 11) {
                                                        $cleanPhone = '88' . $cleanPhone;
                                                    }
                                                    $text =
                                                        'হ্যালো ' .
                                                        $msg->name .
                                                        ", আপনার মেসেজটির প্রেক্ষিতে আমরা 'লিনা ডিজিটাল ই-লার্নিং প্লাটফর্ম' থেকে যোগাযোগ করছি।";
                                                @endphp

                                                <div class="btn-group">
                                                    <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode($text) }}"
                                                        target="_blank"
                                                        class="btn btn-gradient-success btn-sm btn-icon-text"
                                                        title="Chat on WhatsApp">
                                                        <i class="mdi mdi-whatsapp btn-icon-prepend"></i> WhatsApp
                                                    </a>
                                                    <button class="btn btn-outline-info btn-sm view-msg-btn"
                                                        data-bs-toggle="modal" data-bs-target="#viewMessageModal"
                                                        data-name="{{ $msg->name }}" data-phone="{{ $msg->phone }}"
                                                        data-message="{{ $msg->message }}">
                                                        <i class="mdi mdi-eye"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <p class="text-muted">মামা, কোনো মেসেজ পাওয়া যায়নি!</p>
                                            </td>
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

    <!-- View Message Modal -->
    <div class="modal fade" id="viewMessageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Message Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="fw-bold text-primary">Sender Name:</label>
                        <p id="view_name" class="border-bottom pb-2"></p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-primary">Phone Number:</label>
                        <p id="view_phone" class="border-bottom pb-2"></p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-primary">Full Message:</label>
                        <div class="p-3 bg-light rounded">
                            <p id="view_message" style="white-space: pre-wrap;"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        .avatar-circle {
            width: 40px;
            height: 40px;
            background-color: #f3f4f7;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #e1e1e1;
        }

        .initials {
            font-weight: bold;
            color: #b66dff;
        }

        .table thead th {
            border-top: 0;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .btn-gradient-success {
            background: linear-gradient(to right, #84d9d2, #07cdae);
            border: none;
            color: #fff;
        }

        .btn-gradient-success:hover {
            opacity: 0.9;
            color: #fff;
        }
    </style>
@endsection
@push('script')
    <script>
        $('.view-msg-btn').on('click', function() {
    let name = $(this).data('name');
    let phone = $(this).data('phone');
    let message = $(this).data('message');

    $('#view_name').text(name);
    $('#view_phone').text(phone);
    $('#view_message').text(message);
});
    </script>
@endpush