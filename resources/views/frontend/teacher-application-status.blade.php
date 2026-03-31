@extends('frontend.master')

@section('content')
<div class="container mt-5">
    <div class="card p-4 shadow-lg">
        <h3 class="text-center mb-4">Check Your Teacher Application Status</h3>

        {{-- Error Message --}}
        @if(session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        {{-- Application ID Form --}}
        <form action="{{ route('teacher.application.status.check') }}" method="POST" class="mb-4">
            @csrf
            <div class="input-group">
                <input type="text" name="application_id" class="form-control" placeholder="Enter Your Application ID" required>
                <button type="submit" class="btn btn-primary">Check Status</button>
            </div>
        </form>

        {{-- Application Details --}}
        @isset($application)
            <hr>
            <div class="text-center mt-3">

                {{-- Status Card --}}
                @if($application->status == 'approved')
                    <div class="card border-success mb-3 shadow-sm">
                        <div class="card-body">
                            <h4 class="card-title text-success">🎉 Congratulations!</h4>
                            <p class="card-text"><strong>Application ID:</strong> {{ $application->application_id }}</p>
                            <p class="card-text"><strong>Name:</strong> {{ $application->name }}</p>
                            <span class="badge bg-success mb-2">Approved</span>
                            <hr>
                            <p class="alert alert-success fs-6">
                                ✅ Your application has been approved. Our team will contact you shortly.
                            </p>
                        </div>
                    </div>
                @elseif($application->status == 'rejected')
                    <div class="card border-danger mb-3 shadow-sm">
                        <div class="card-body">
                            <h4 class="card-title text-danger">❌ Application Not Approved</h4>
                            <p class="card-text"><strong>Application ID:</strong> {{ $application->application_id }}</p>
                            <p class="card-text"><strong>Name:</strong> {{ $application->name }}</p>
                            <span class="badge bg-danger mb-2">Rejected</span>
                            <hr>
                            <p class="alert alert-danger fs-6">
                                ⚠️ We regret to inform you that your application was not approved. Please keep preparing and try again in the future.
                            </p>
                        </div>
                    </div>
                @else
                    <div class="card border-warning mb-3 shadow-sm">
                        <div class="card-body">
                            <h4 class="card-title text-warning">⏳ Pending</h4>
                            <p class="card-text"><strong>Application ID:</strong> {{ $application->application_id }}</p>
                            <p class="card-text"><strong>Name:</strong> {{ $application->name }}</p>
                            <span class="badge bg-warning mb-2">Pending</span>
                            <hr>
                            <p class="alert alert-warning fs-6">
                                ⏳ Your application is under review. Please be patient; we will notify you once it is processed.
                            </p>
                        </div>
                    </div>
                @endif

            </div>
        @endisset
    </div>
</div>
@endsection
