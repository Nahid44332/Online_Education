@extends('backend.master')
@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Add Teacher</h4>
    <form action="{{url('/admin/teacher/store')}}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="form-group mb-3">
        <label>Teacher Name</label>
        <input type="text" name="name" class="form-control" placeholder="Enter teacher name" required>
      </div>

      <div class="form-group mb-3">
        <label>Designation</label>
        <input type="text" name="designation" class="form-control" placeholder="Profession">
      </div>

      <div class="form-group mb-3">
        <label>phone</label>
        <input type="text" name="phone" class="form-control" placeholder="Enter Your Phone">
      </div>

      <div class="form-group mb-3">
        <label>Profile Image</label>
        <input type="file" name="profile_image" class="form-control">
      </div>

      <div class="form-group mb-3">
        <label>About</label>
        <textarea name="about" class="form-control" rows="3"></textarea>
      </div>

      <div class="form-group mb-3">
        <label>Achievements</label>
        <textarea name="achievements" class="form-control" rows="3"></textarea>
      </div>

      <div class="form-group mb-3">
        <label>Objective</label>
        <textarea name="objective" class="form-control" rows="3"></textarea>
      </div>

      <div class="form-group mb-3">
        <label>Short Description</label>
        <textarea name="short_description" class="form-control" rows="2"></textarea>
      </div>

      <div class="form-group mb-3">
        <label>Facebook Link</label>
        <input type="url" name="facebook_link" class="form-control" placeholder="https://facebook.com/...">
      </div>

      <div class="form-group mb-3">
        <label>Twitter Link</label>
        <input type="url" name="twitter_link" class="form-control" placeholder="https://twitter.com/...">
      </div>

      <div class="form-group mb-3">
        <label>Google Link</label>
        <input type="url" name="google_link" class="form-control" placeholder="https://plus.google.com/...">
      </div>

      <div class="form-group mb-3">
        <label>LinkedIn Link</label>
        <input type="url" name="linkedin_link" class="form-control" placeholder="https://linkedin.com/...">
      </div>

      <button type="submit" class="btn btn-primary">Add Teacher</button>
    </form>
  </div>
</div>
@endsection