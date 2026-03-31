@extends('backend.master')

@section('content')
<div class="container-fluid px-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>All Notices</h3>
        <a href="{{url('/admin/notice/create')}}" class="btn btn-primary">
            <i class="mdi mdi-plus"></i> Create Notice
        </a>
    </div>

    <div class="row">
        @foreach ($notices as $notice)
            <div class="col-md-4 mb-4">
                <div class="card shadow-lg border-0 h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $notice->title }}</h5>
                        <p class="card-text">{{ $notice->description }}</p>
                        <p class="text-muted">
                            <small><i class="mdi mdi-calendar"></i> {{ $notice->date ?? 'No date' }}</small>
                        </p>

                        <div class="d-flex justify-content-between">
                            <!-- Publish / Unpublish Form -->
                            <form action="{{ url('/admin/notice/toggle-status/'.$notice->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                    class="btn btn-sm {{ $notice->status ? 'btn-warning' : 'btn-success' }}">
                                    {{ $notice->status ? 'Unpublish' : 'Publish' }}
                                </button>
                            </form>

                            <a href="{{ url('/admin/notice/edit/'.$notice->id) }}" class="btn btn-sm btn-info">Edit</a>
                            <a href="{{url('/admin/notice/delete/'.$notice->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure delete notice?')">Delete</a>
                        </div>
                    </div>
                    <div class="card-footer text-center 
                        {{ $notice->status ? 'bg-success' : 'bg-secondary' }} text-white">
                        {{ $notice->status ? 'Published' : 'Unpublished' }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
