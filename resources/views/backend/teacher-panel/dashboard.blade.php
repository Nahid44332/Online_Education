@extends('backend.teacher-panel.TS-master') {{-- অথবা আপনার টিচার প্যানেলের আলাদা মাস্টার ফাইল --}}

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <img src="{{ asset('backend/images/teachers/' . $teacher->teacher->profile_image) }}" 
                         class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    <h4>{{ $teacher->name }}</h4>
                    <p class="text-muted">{{ $teacher->teacher->designation }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">Teacher Information</div>
                <div class="card-body">
                    <p><strong>Email:</strong> {{ $teacher->email }}</p>
                    <p><strong>Phone:</strong> {{ $teacher->teacher->phone }}</p>
                    <p><strong>About:</strong> {{ $teacher->teacher->about }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection