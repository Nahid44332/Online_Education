@extends('backend.master')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Edit Testimonial</h3>
        <a href="{{ url('/admin/testimonial') }}" class="btn btn-secondary">Back to List</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ url('/admin/testimonial/update/'.$testimonial->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $testimonial->name }}" required>
                </div>

                <div class="mb-3">
                    <label for="designation" class="form-label">Designation</label>
                    <input type="text" name="designation" id="designation" class="form-control" value="{{ $testimonial->designation }}" required>
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea name="message" id="message" class="form-control" rows="5" required>{{ $testimonial->message }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" name="image" id="image" class="form-control">
                    @if($testimonial->image)
                        <img src="{{ asset('backend/images/testimonial/'.$testimonial->image) }}" alt="image" class="mt-2" width="80" height="80">
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Update Testimonial</button>
            </form>
        </div>
    </div>
</div>
@endsection
