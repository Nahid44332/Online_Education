@extends('backend.master')

@section('content')
<div class="container-fluid mt-4 pb-5">
    {{-- ব্রেডক্রাম্ব ও হেডার --}}
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h3 class="fw-bold text-dark"><i class="fa-solid fa-envelope-open-text me-2 text-success"></i>Contact Messages</h3>
            <p class="text-muted small mb-0">Manage inquiries sent by visitors from the website.</p>
        </div>
        <div class="col-md-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb float-md-end bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Contact Messages</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- টেবিল কার্ড --}}
    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold"><i class="fa-solid fa-list me-2"></i>Inquiry List</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-center">
                            <th class="ps-3" style="width: 60px;">SL</th>
                            <th class="text-start">Sender Info</th>
                            <th class="text-start">Message</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($contacts as $contact)
                            <tr>
                                <td class="text-center ps-3 text-muted">{{ $loop->iteration }}</td>
                                <td class="text-start">
                                    <div class="fw-bold text-dark">{{ $contact->name }}</div>
                                    <div class="small text-muted"><i class="fa-solid fa-phone me-1 small"></i>{{ $contact->phone }}</div>
                                    <div class="small text-muted"><i class="fa-solid fa-envelope me-1 small"></i>{{ $contact->email }}</div>
                                </td>
                                <td class="text-start" style="max-width: 300px;">
                                    <div class="text-wrap small text-dark" style="line-height: 1.5;">
                                        {{ Str::limit($contact->message, 100) }}
                                        @if(strlen($contact->message) > 100)
                                            <a href="#" class="text-primary text-decoration-none small" data-bs-toggle="modal" data-bs-target="#msgModal{{$contact->id}}">Read More</a>
                                        @endif
                                    </div>
                                    <small class="text-muted italic" style="font-size: 10px;">
                                        <i class="fa-regular fa-clock me-1"></i>{{ $contact->created_at->diffForHumans() }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- ভিউ বাটন (মডাল ওপেন করবে) --}}
                                        <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#msgModal{{$contact->id}}">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        {{-- ডিলিট বাটন --}}
                                        <a href="{{url('/admin/contact-us/delete/'.$contact->id)}}" 
                                           class="btn btn-sm btn-outline-danger" 
                                           onclick="return confirm('Are you sure you want to delete this message?')">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="msgModal{{$contact->id}}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-light">
                                            <h5 class="modal-title fw-bold small text-uppercase">Message from {{ $contact->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="text-dark" style="white-space: pre-wrap;">{{ $contact->message }}</p>
                                            <hr class="opacity-25">
                                            <div class="small">
                                                <strong>Email:</strong> {{ $contact->email }}<br>
                                                <strong>Phone:</strong> {{ $contact->phone }}
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Close</button>
                                            <a href="mailto:{{ $contact->email }}" class="btn btn-primary btn-sm px-4">Reply via Email</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-inbox d-block mb-2 fs-2 opacity-25"></i>
                                    No contact messages found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light py-2">
            <p class="text-center mb-0 small text-muted">Lina Digital E-Learning - Admin Communication Log</p>
        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover { background-color: #f8f9fa; }
    .btn-sm { border-radius: 8px; }
    .modal-content { border-radius: 15px; }
    .text-wrap { word-break: break-word; }
</style>
@endsection