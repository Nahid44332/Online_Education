@extends('backend.master')

@section('content')
<div class="card shadow-lg">
    <div class="card-header bg-primary text-white">
        <h4>Teacher {{$teacher->name}}</h4>
    </div>
    <div class="card-body">
        <div class="row">

            <!-- Profile Image -->
            <div class="col-md-4 text-center">
                @if($teacher->profile_image)
                    <img src="{{ asset('backend/images/teachers/'.$teacher->profile_image) }}" 
                         alt="Teacher Image" class="img-fluid rounded-circle mb-3" width="200">
                @else
                    <img src="{{ asset('backend/images/no-image.png') }}" 
                         alt="No Image" class="img-fluid rounded-circle mb-3" width="200">
                @endif
                <h5 class="mt-2">{{ $teacher->name }}</h5>
                <p class="text-muted">{{ $teacher->designation }}</p>
                <p><b>Phone:</b> {{ $teacher->phone }}</p>
            </div>

            <!-- Profile Info -->
            <div class="col-md-8">
                <h5>About</h5>
                <p>{{ $teacher->about }}</p>

                <h5>Achievements</h5>
                <p>{{ $teacher->achievements }}</p>

                <h5>Objective</h5>
                <p>{{ $teacher->objective }}</p>

                <h5>Short Description</h5>
                <p>{{ $teacher->short_description }}</p>

                <h5>Social Links</h5>
                <p>
                    @if($teacher->facebook_link)
                        <a href="{{ $teacher->facebook_link }}" target="_blank"><i class="fa-brands fa-facebook"></i></a> |
                    @endif
                    @if($teacher->twitter_link)
                        <a href="{{ $teacher->twitter_link }}" target="_blank"><i class="fa-brands fa-x-twitter"></i></a> |
                    @endif
                    @if($teacher->google_link)
                        <a href="{{ $teacher->google_link }}" target="_blank"><i class="fa-brands fa-google"></i></a> |
                    @endif
                    @if($teacher->linkedin_link)
                        <a href="{{ $teacher->linkedin_link }}" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
