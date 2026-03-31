@extends('backend.master')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Edit News</h2>

        <form action="{{url('/admin/news/update/'.$news->id)}}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label">News Title</label>
                <input type="text" name="title" class="form-control" value="{{ $news->title }}" id="title"
                    placeholder="Enter news title" required>
            </div>

            <!-- Content -->
            <div class="mb-3">
                <label for="description" class="form-label">News Content</label>
                <textarea name="description" class="form-control" id="description" rows="5" placeholder="Write your news..."
                    required>{{ $news->description }}</textarea>
            </div>

            <!-- Image -->
            <div class="mb-3">
                <label for="image" class="form-label">News Image</label>
                <div class="mb-2">
                    <img src="{{ asset('backend/images/news/'.$news->image) }}" alt="" height="100" width="100">
                </div>
                <input type="file" name="image" class="form-control" id="image" accept="image/*">
            </div>

            <!-- Published By -->
            <div class="mb-3">
                <label for="published_by" class="form-label">Published By</label>
                <input type="text" name="published_by" class="form-control" value="{{ $news->published_by }}"
                    id="published_by" value="" required>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="1">Published</option>
                    <option value="0">Unpublished</option>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Create News</button>
        </form>
    </div>
@endsection
