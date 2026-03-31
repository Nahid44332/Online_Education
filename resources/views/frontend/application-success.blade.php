@extends('frontend.master')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h3 class="text-success text-center">🎉 Application Submitted Successfully!</h3>
        <hr>
        <p class="text-center fs-5">
            <strong>Your Application ID:</strong> 
            <span class="text-success">{{ $application_id }}</span>
        </p>

        <p class="text-center text-muted">
            Please note down this ID. You can check your application status later.
        </p>

        <div class="text-center mt-3">
            <button class="btn btn-outline-secondary" onclick="window.print()">🖨 Print Application</button>
            <a href="{{ url('/') }}" class="btn btn-success">Go to Home</a>
        </div>
    </div>
</div>
@endsection
