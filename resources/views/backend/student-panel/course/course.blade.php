@extends('backend.student-panel.st-master')

@section('content')
    <div class="container mt-4">

        <h3>My Course</h3>

        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <img src="{{ asset('backend/images/courses/' . $course->thumbnail) }}" class="card-img-top"
                    alt="{{ $course->title }}">

                <div class="card-body">
                    <h5 class="card-title">{{ $course->title }}</h5>

                    <p class="card-text"><strong>Teacher:</strong> {{ $course->teacher->name ?? 'N/A' }}</p>
                    <p class="card-text"><strong>Topic:</strong> {{ $liveclass->title ?? 'N/A' }}</p>

                    @if ($liveclass && $liveclass->status == 'active')
                        <a href="{{ $liveclass->meeting_link }}" target="_blank" class="btn btn-success btn-sm">
                            Join Live Class
                        </a>
                    @else
                        <button class="btn btn-secondary btn-sm" disabled>
                            Waiting for Link
                        </button>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection
