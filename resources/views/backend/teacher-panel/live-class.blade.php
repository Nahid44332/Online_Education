@extends('backend.teacher-panel.TS-master')
@section('content')

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> 
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-video"></i>
            </span> Live Class Management 
        </h3>
    </div>
    
    <div class="row">
        <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Update Live Class Link</h4>
                    <p class="card-description"> Fill in the details to update the meeting link for students. </p>
                    
                    <form action="{{ route('live.class.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">Class Title</label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="e.g. PHP Laravel Class 01" required>
                        </div>
                       <div class="form-group">
    @if($course)
        <input type="hidden" name="course_id" value="{{ $course->id }}">
    @else
        <div class="alert alert-warning">
            আপনার নামে কোনো কোর্স পাওয়া যায়নি। দয়া করে এডমিনের সাথে যোগাযোগ করুন।
        </div>
    @endif
</div>
                        <div class="form-group">
                            <label for="link">Google Meet / Zoom Link</label>
                            <input type="url" name="meeting_link" class="form-control" id="link" placeholder="https://meet.google.com/xxx-xxxx-xxx" required>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-gradient-primary btn-icon-text">
                                <i class="mdi mdi-upload btn-icon-prepend"></i> Update & Publish 
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Currently Active Class Info</h4>
                    <div class="mt-4">
                        @php $currentClass = $classes->first(); @endphp
                        
                        @if($currentClass)
                            <div class="alert {{ $currentClass->status == 'active' ? 'alert-info' : 'alert-secondary' }} border-0">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0 text-dark"><strong>Topic:</strong> {{ $currentClass->title }}</h5>
                                    <span class="badge {{ $currentClass->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                        {{ strtoupper($currentClass->status) }}
                                    </span>
                                </div>
                                
                                <p class="mb-2 text-dark">
                                    <strong>Meeting URL:</strong> <br>
                                    <a href="{{ $currentClass->meeting_link }}" target="_blank" class="text-primary word-break">
                                        {{ $currentClass->meeting_link }}
                                    </a>
                                </p>
                                
                                <hr>
                                <p class="text-muted small mb-0">
                                    <i class="mdi mdi-clock-outline"></i> Last Updated: {{ $currentClass->updated_at->diffForHumans() }}
                                </p>
                            </div>

                            <div class="d-flex mt-3">
                                <a href="{{ route('live.class.status', $currentClass->id) }}" 
                                   class="btn {{ $currentClass->status == 'active' ? 'btn-gradient-warning' : 'btn-gradient-success' }} btn-sm me-2 btn-icon-text">
                                   <i class="mdi {{ $currentClass->status == 'active' ? 'mdi-eye-off' : 'mdi-eye' }} btn-icon-prepend"></i> 
                                   Set to {{ $currentClass->status == 'active' ? 'Expired' : 'Active' }}
                                </a>

                                <a href="{{ route('live.class.delete', $currentClass->id) }}" 
                                   class="btn btn-outline-danger btn-sm btn-icon-text" 
                                   onclick="return confirm('Are you sure you want to clear this link? Students will not see any link.')">
                                   <i class="mdi mdi-delete btn-icon-prepend"></i> Clear Link
                                </a>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="mdi mdi-video-off display-3 text-light"></i>
                                <p class="mt-3 text-muted italic">No active live class link found at the moment.</p>
                                <small class="text-secondary">Fill the form on the left to publish a new link.</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .word-break {
        word-break: break-all;
    }
</style>

@endsection