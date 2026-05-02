@extends('frontend.master')

@section('content')
    <section class="pt-80 pb-80">
        <div class="container">
            <div class="row mb-5">
                <div class="col text-center">
                    <h2 class="section-title fw-bold">Latest Notices</h2>
                    <div class="mx-auto bg-primary mb-3" style="height: 3px; width: 60px;"></div>
                    <p class="text-muted">Stay updated with all important announcements</p>
                </div>
            </div>

            <div class="row">
                @forelse($notices as $notice)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm h-100 border-0 overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <small class="text-primary fw-bold">
                                        <i class="fa fa-calendar-alt mr-1"></i>
                                        {{-- তারিখ যদি ম্যানুয়ালি দেওয়া থাকে তবে সেটা, না থাকলে তৈরির তারিখ --}}
                                        {{ $notice->date ? date('d M, Y', strtotime($notice->date)) : $notice->created_at->format('d M, Y') }}
                                    </small>
                                    <small class="text-muted">
                                        <i class="fa fa-user-circle mr-1"></i>       
                                        @if($notice->author)
                                            {{ $notice->author->name }} (Manager)
                                        @else
                                            Admin
                                        @endif
                                    </small>
                                </div>

                                <h5 class="card-title fw-bold text-dark">{{ Str::limit($notice->title, 50) }}</h5>
                                <p class="card-text text-muted" style="font-size: 0.95rem;">
                                    {{ Str::limit($notice->description, 120) }}
                                </p>
                                
                                <a href="{{ url('notice/'.$notice->id) }}" class="btn btn-outline-primary btn-sm btn-rounded px-4 mt-2">
                                    View Details
                                </a>
                            </div>

                            {{-- নিচের অংশটি স্টাইলিশ করার জন্য একটি বর্ডার দেওয়া হয়েছে --}}
                            <div class="card-footer bg-transparent border-0 pb-3">
                                <span class="badge badge-success px-3">Official Notice</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <img src="{{ asset('frontend/assets/img/no-data.png') }}" alt="No Data" style="width: 150px; opacity: 0.5;">
                        <p class="text-muted mt-3">No notices available right now.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection