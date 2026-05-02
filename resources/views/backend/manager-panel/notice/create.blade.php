@extends('backend.manager-panel.master')

@section('content')
<div class="content-wrapper">
    {{-- হেডার সেকশন --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-bullhorn"></i>
                </span> Create Manager Notice
            </h3>
            <small class="text-muted">মামা, এখান থেকে আপনার টিমের জন্য নতুন নোটিশ পাবলিশ করুন।</small>
        </div>
        <a href="{{ route('manager.notice') }}" class="btn btn-gradient-light btn-sm shadow-sm text-dark">
            <i class="mdi mdi-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-body p-4 p-md-5">
                    {{-- সাকসেস মেসেজ দেখানোর জন্য --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('manager.notice.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">Notice Title <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="mdi mdi-format-title text-muted"></i></span>
                                <input type="text" name="title" id="title" class="form-control border-start-0 ps-0 @error('title') is-invalid @enderror" 
                                    placeholder="যেমন: আগামীকালের মিটিং সংক্রান্ত নোটিশ" required value="{{ old('title') }}">
                            </div>
                            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="date" class="form-label fw-bold">Notice Date</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="mdi mdi-calendar text-muted"></i></span>
                                    <input type="date" name="date" id="date" class="form-control border-start-0 ps-0" 
                                        value="{{ date('Y-m-d') }}">
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="status" class="form-label fw-bold">Publish Status</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="mdi mdi-eye text-muted"></i></span>
                                    <select name="status" id="status" class="form-select border-start-0 ps-0">
                                        <option value="1">Publish Now</option>
                                        <option value="0" selected>Save as Draft</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">Detailed Description <span class="text-danger">*</span></label>
                            <textarea name="description" id="description" class="form-control border-1 @error('description') is-invalid @enderror" rows="6" 
                                placeholder="নোটিশের বিস্তারিত এখানে লিখুন..." required style="border-radius: 10px;">{{ old('description') }}</textarea>
                            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="btn btn-gradient-primary w-100 py-3 shadow-sm fw-bold">
                                <i class="mdi mdi-send me-2"></i> Post Notice
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <p class="text-muted small italic">
                    <i class="mdi mdi-information-outline me-1"></i> 
                    পাবলিশ করার পর এই নোটিশটি সংশ্লিষ্ট মেম্বারদের ড্যাশবোর্ডে দেখা যাবে।
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        border-color: #b66dff;
        box-shadow: 0 0 0 0.1rem rgba(182, 109, 255, 0.25);
        background-color: #fcfaff;
    }
    .input-group-text {
        border-radius: 10px 0 0 10px;
        border-color: #ebedf2;
    }
    .form-control, .form-select {
        border-radius: 0 10px 10px 0;
        border-color: #ebedf2;
    }
    .btn-gradient-primary {
        background: linear-gradient(to right, #da8cff, #9a55ff);
        border: 0;
        color: #fff;
    }
    label {
        font-size: 0.85rem;
        color: #343a40;
    }
</style>
@endsection