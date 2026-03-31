@extends('backend.master')
@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Edit Teacher ({{$teachers->name}})</h4>
    <form action="{{url('/admin/teacher/update/'.$teachers->id)}}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-group mb-3">
        <label>Teacher Name</label>
        <input type="text" name="name" class="form-control" value="{{$teachers->name}}" required>
      </div>

      <div class="form-group mb-3">
        <label>Designation</label>
        <input type="text" name="designation" class="form-control" value="{{$teachers->designation}}">
      </div>

      <div class="form-group mb-3">
        <label>phone</label>
        <input type="text" name="phone" class="form-control" value="{{$teachers->phone}}">
      </div>

      <div class="form-group mb-3">
        <label>Profile Image</label>
        <input type="file" name="profile_image" class="form-control">
        <div class="mt-2">
            <img src="{{asset('backend/images/teachers/'.$teachers->profile_image)}}" alt="" height="100" width="100">
        </div>
      </div>

      <div class="form-group mb-3">
        <label>About</label>
        <textarea name="about" class="form-control" rows="3">{{$teachers->about}}</textarea>
      </div>

      <div class="form-group mb-3">
        <label>Achievements</label>
        <textarea name="achievements" class="form-control" rows="3">{{$teachers->achievements}}</textarea>
      </div>

      <div class="form-group mb-3">
        <label>Objective</label>
        <textarea name="objective" class="form-control" rows="3">{{$teachers->objective}}</textarea>
      </div>

      <div class="form-group mb-3">
        <label>Short Description</label>
        <textarea name="short_description" class="form-control" rows="2">{{$teachers->short_description}}</textarea>
      </div>

      <div class="form-group mb-3">
        <label>Facebook Link</label>
        <input type="url" name="facebook_link" class="form-control" value="{{$teachers->facebook_link}}">
      </div>

      <div class="form-group mb-3">
        <label>Twitter Link</label>
        <input type="url" name="twitter_link" class="form-control" value="{{$teachers->twitter_link}}">
      </div>

      <div class="form-group mb-3">
        <label>Google Link</label>
        <input type="url" name="google_link" class="form-control"  value="{{$teachers->google_link}}">
      </div>

      <div class="form-group mb-3">
        <label>LinkedIn Link</label>
        <input type="url" name="linkedin_link" class="form-control" value="{{$teachers->linkedin_link}}">
      </div>

      <button type="submit" class="btn btn-primary">Update Teacher</button>
    </form>
  </div>
</div>
@endsection