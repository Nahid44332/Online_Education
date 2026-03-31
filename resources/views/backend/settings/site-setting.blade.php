@extends('backend.master')
@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Site Setting</h4>
    <form action="{{url('/admin/site-seeting/update')}}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="form-group mb-3">
        <label>Site Name</label>
        <input type="text" name="sitename" class="form-control" value="{{$siteSettings->sitename}}" placeholder="Enter Site Name" required>
      </div>

      <div class="form-group mb-3">
        <label>Site Description</label>
       <textarea name="site_description" class="form-control" id="site_description" cols="20" rows="10" required>{{$siteSettings->site_description}}</textarea>
      </div>

      <div class="form-group mb-3">
        <label>Phone</label>
        <input type="text" name="phone" value="{{$siteSettings->phone}}" class="form-control" placeholder="Enter Your Phone" required>
      </div>

      <div class="form-group mb-3">
        <label>Email</label>
        <input type="text" name="email"  value="{{$siteSettings->email}}" class="form-control" placeholder="Enter Your email" required>
      </div>

      <div class="form-group mb-3">
        <label>Address</label>
         <textarea name="address" class="form-control" id="address" cols="30" rows="10" required>{{$siteSettings->address}}</textarea>
      </div>

      <div class="form-group mb-3">
        <label>Opening</label>
        <input type="text" name="opening" value="{{$siteSettings->opening}}" class="form-control" placeholder="Center Opening & Closing Time" required>
      </div>

      <div class="form-group mb-3">
        <label>Helpline Number</label>
        <input type="text" name="helpline" value="{{$siteSettings->helpline}}" class="form-control" placeholder="Enter Helpline Number">
      </div>

      <div class="form-group mb-3">
        <label>Logo</label><br>
        <img class="mb-2" src="{{ asset('backend/images/seetings/'.$sitesettings->logo) }}" alt="">
        <input type="file" name="logo" class="form-control">
      </div>

      <div class="form-group mb-3">
        <label>Facebook Link</label>
        <input type="url" name="facebook" value="{{$siteSettings->facebook}}" class="form-control" placeholder="https://facebook.com/...">
      </div>

      <div class="form-group mb-3">
        <label>Twitter Link</label>
        <input type="url" name="twitter" value="{{$siteSettings->twitter}}" class="form-control" placeholder="https://twitter.com/...">
      </div>

      <div class="form-group mb-3">
        <label>Google Link</label>
        <input type="url" name="google" value="{{$siteSettings->google}}" class="form-control" placeholder="https://plus.google.com/...">
      </div>

      <div class="form-group mb-3">
        <label>Instagram</label>
        <input type="url" name="instagram" value="{{$siteSettings->instagram}}" class="form-control" placeholder="https://linkedin.com/...">
      </div>

      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
</div>
@endsection