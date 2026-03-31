@extends('backend.master')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Create Notice</h3>
        <a href="{{ url('/admin/notice') }}" class="btn btn-secondary">
            <i class="mdi mdi-arrow-left"></i> Back to Notices
        </a>
    </div>

    <div class="card shadow-lg border-0">
        <div class="card-body">
            <form action="{{url('/admin/notice/store')}}" method="POST">
                @csrf

                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="form-label">Notice Title</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter notice title" required>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" placeholder="Write notice details here..." required></textarea>
                </div>

                <!-- Date -->
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" name="date" id="date" class="form-control">
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="1">Publish</option>
                        <option value="0" selected>Unpublish</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-content-save"></i> Save Notice
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
