@extends('backend.student-panel.st-master')

@section('content')
<div class="container mt-4">

    <h3>My Course</h3>


    <div class="col-md-6 mb-3">
        <div class="card h-100">
            <!-- Course Image -->
            <img src="{{ asset('backend/images/courses/'.$course->thumbnail) }}" class="card-img-top" alt="{{ $course->title }}">

            <div class="card-body">
                <!-- Course Title -->
                <h5 class="card-title">{{ $course->title }}</h5>

                <!-- Teacher Name -->
                <p class="card-text"><strong>Teacher:</strong> {{ $course->teacher->name ?? 'N/A' }}</p>

                {{-- <!-- Class Time -->
                <p class="card-text"><strong>Class Time:</strong> {{ $course->start_date->format('d M Y H:i') }} - {{ $course->end_date->format('d M Y H:i') }}</p> --}}

                <!-- Join Button -->
                {{-- @if($course->google_meet_link) --}}
                    <a href="https://meet.google.com/dwd-owwn-sut" target="_blank" class="btn btn-success btn-sm">
                        Join Live Class
                    </a>
                {{-- @else
                    <button class="btn btn-secondary btn-sm" disabled>
                        Waiting for Link
                    </button>
                @endif --}}
            </div>
        </div>
    </div>
    {{-- @else
        <div class="alert alert-warning text-center">
            You are not enrolled in any course yet.
        </div>
    @endif --}}

</div>
@endsection