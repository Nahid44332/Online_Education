@extends('backend.master')

@section('content')
<div class="container mt-4">
    <h4>Update About Us</h4>
    <form action="{{url('/admin/about-us/update/'.$aboutus->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">

                <!-- Title & Description -->
                <div class="form-group mb-3">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" 
                           value="{{$aboutus->title}}" placeholder="Enter Title">
                </div>

                <div class="form-group mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="5">{{$aboutus->description}}</textarea>
                </div>

                <!-- Image -->
                <div class="form-group mb-3">
                    <label>Image</label><br>
                        <img src="{{asset('backend/images/aboutus/'.$aboutus->image)}}" height="100" width="100" class="mb-2 rounded">
                    <input type="file" name="image" class="form-control">
                </div>

                <hr>

                <!-- Choose Section -->
                <h5>Why Choose Us</h5>
                <input type="text" name="choose_title" class="form-control mb-2" 
                       value="{{$aboutus->choose_title}}" placeholder="Choose Us Title">
                <textarea name="choose_description" class="form-control mb-3" rows="5">{{$aboutus->choose_description}}</textarea>

                <!-- Mission Section -->
                <h5>Our Mission</h5>
                <input type="text" name="mission_title" class="form-control mb-2" 
                       value="{{$aboutus->mission_title}}" placeholder="Mission Title">
                <textarea name="mission_description" class="form-control mb-3" rows="5">{{$aboutus->mission_description}}</textarea>

                <!-- Vision Section -->
                <h5>Our Vision</h5>
                <input type="text" name="vision_title" class="form-control mb-2" 
                       value="{{$aboutus->vision_title}}" placeholder="Vision Title">
                <textarea name="vision_description" class="form-control mb-3" rows="5">{{$aboutus->vision_description}}</textarea>

                <button type="submit" class="btn btn-primary">Update</button>

            </div>
        </div>
    </form>
</div>
@endsection
