@extends('backend.master')

@section('content')
<div class="container mt-4">
    <h3>Teacher Feature Settings</h3>

    {{-- Featured Text Section --}}
    <form action="{{url('/admin/teacher/featured/update')}}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="feature_title" class="form-label">Section Title</label>
            <input type="text" class="form-control" id="feature_title" value="{{$teachereatured->feature_title}}" name="feature_title" placeholder="Enter section title" required>
        </div>

        <div class="mb-3">
            <label for="feature_description" class="form-label">Section Description</label>
            <textarea class="form-control" id="feature_description" name="feature_description" rows="3" placeholder="Enter description">{{$teachereatured->feature_description}}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{'/admin/dashboard'}}" class="btn btn-secondary">Home</a>
    </form>
</div>
@endsection
