@extends('frontend.master')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">Check Your Certificate Status</h3>
                </div>
                <div class="card-body">
                    <p class="text-center text-muted mb-4">
                        Enter your Student ID to see if your certificate has been generated.
                    </p>
                    <form action="#" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student ID</label>
                            <input type="text" name="student_id" id="student_id" class="form-control form-control-lg" placeholder="Enter your Student ID" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100 btn-lg">Check Status</button>
                    </form>
                </div>
                <div class="card-footer text-center text-muted">
                    &copy; {{ date('Y') }} Nahid Computer Training Center
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
