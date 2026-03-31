@extends('backend.master')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Create Testimonial</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/testimonial') }}">Testimonial</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
        </div>
    </div>

    <!-- Create Form -->
    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <form action="{{url('/admin/testimonial/store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter name" required>
                </div>

                <!-- Designation -->
                <div class="mb-3">
                    <label for="designation" class="form-label">Designation <span class="text-danger">*</span></label>
                    <input type="text" name="designation" id="designation" class="form-control" placeholder="Student, Teacher, etc." required>
                </div>

                <!-- Message -->
                <div class="mb-3">
                    <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                    <textarea name="message" id="message" rows="4" class="form-control" placeholder="Write testimonial message..." required></textarea>
                </div>

                <!-- Photo -->
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    <small class="text-muted">Optional – JPG, PNG only</small>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-success">
                    <i class="mdi mdi-content-save"></i> Publish Testimonial
                </button>
                <a href="{{ url('/admin/testimonial') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
