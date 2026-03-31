@extends('frontend.master')

@section('content')
    <section class="pt-80 pb-80">
        <div class="container">
            <div class="row mb-4">
                <div class="col text-center">
                    <h2 class="section-title">Latest Notices</h2>
                    <p class="text-muted">Stay updated with all important announcements</p>
                </div>
            </div>

            <div class="row">
                @forelse($notices as $notice)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-lg h-100 border-0">
                            <div class="card-body">
                                <h5 class="card-title">{{ $notice->title }}</h5>
                                <p class="card-text">{{ Str::limit($notice->description, 120) }}</p>
                                <p class="text-muted">
                                    <small><i class="fa fa-calendar"></i>
                                        {{ $notice->created_at->format('d M, Y') }}
                                    </small>
                                </p>
                                <a href="{{ url('notice/'.$notice->id) }}" class="btn btn-primary btn-sm">
                                    View Details
                                </a>
                            </div>

                            <div class="card-footer text-center bg-success text-white">
                                Published
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No notices available right now.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
