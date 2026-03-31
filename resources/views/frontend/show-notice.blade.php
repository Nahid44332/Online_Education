@extends('frontend.master')
@section('content')
<section class="pt-80 pb-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <h2 class="card-title">{{ $notice->title }}</h2>
                        <p class="text-muted mb-3">
                            <i class="fa fa-calendar"></i> 
                            {{ $notice->created_at->format('d M, Y') }}
                        </p>
                        <p class="card-text">
                            {!! nl2br(e($notice->description)) !!}
                        </p>
                        <a href="{{ url('/notice') }}" class="btn btn-secondary mt-3">
                            ← Back to All Notices
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
