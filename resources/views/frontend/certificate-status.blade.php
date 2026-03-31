@extends('frontend.master')
@section('content')
<div class="container mt-5">
    <div class="alert alert-info text-center">
        <h4>{{ $message }}</h4>
    </div>
    <div class="text-center mt-3">
        <a href="{{ url('/certificate/check') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
