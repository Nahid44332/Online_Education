@extends('backend.master')

@section('content')
<div class="container-fluid mt-4 pb-5">
    {{-- হেডার সেকশন --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0"><i class="fa-solid fa-bullhorn me-2 text-primary"></i>Create New Notice</h3>
            <small class="text-muted">Publish important announcements for students and teachers.</small>
        </div>
        <a href="{{ url('/admin/notice') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-body p-4 p-md-5">
                    <form action="{{url('/admin/notice/create/store')}}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">Notice Title <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-heading text-muted"></i></span>
                                <input type="text" name="title" id="title" class="form-control border-start-0 ps-0" 
                                    placeholder="e.g. Eid-ul-Fitr Vacation Notice" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="date" class="form-label fw-bold">Notice Date</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-calendar-day text-muted"></i></span>
                                    <input type="date" name="date" id="date" class="form-control border-start-0 ps-0" 
                                        value="{{ date('Y-m-d') }}">
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="status" class="form-label fw-bold">Status</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-toggle-on text-muted"></i></span>
                                    <select name="status" id="status" class="form-select border-start-0 ps-0">
                                        <option value="1">Publish Now</option>
                                        <option value="0" selected>Save as Draft (Unpublish)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">Detailed Description <span class="text-danger">*</span></label>
                            <textarea name="description" id="description" class="form-control border-1" rows="6" 
                                placeholder="Write the full notice details here..." required style="border-radius: 10px;"></textarea>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="btn btn-primary w-100 py-2 shadow-sm fw-bold">
                                <i class="fa-solid fa-paper-plane me-2"></i> Post Notice
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <p class="text-muted small italic"><i class="fa-solid fa-info-circle me-1"></i> Once published, this notice will be visible on the student and teacher dashboard.</p>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: none;
        background-color: #f8f9fa;
    }
    .input-group-text {
        border-radius: 10px 0 0 10px;
    }
    .form-control, .form-select {
        border-radius: 0 10px 10px 0;
    }
    .card {
        background-color: #ffffff;
    }
    label {
        font-size: 0.9rem;
        color: #444;
    }
</style>
@endsection