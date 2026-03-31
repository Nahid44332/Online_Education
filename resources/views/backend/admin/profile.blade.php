@extends('backend.master')

@section('content')
<div class="container mt-5">
    <h3>Admin Profile</h3>
    <form action="{{url('admin/profile/update')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $admin->name }}">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $admin->email }}">
        </div>

        <div class="mb-3">
            <label>Profile Picture</label>
            <input type="file" name="image" class="form-control">
            @if ($admin->image)
                <img src="{{ asset('backend/images/admin/'.$admin->image) }}" width="80" class="mt-2 rounded">
            @endif
        </div>

        <button type="submit" class="btn btn-success">Update Profile</button>
    </form>
    
    <a href="{{url('/admin/change-password')}}" class="btn btn-warning mt-3">Change Password</a>
</div>
@endsection
