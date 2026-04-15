@extends('backend.helpline-panel.help-master')
@section('content')
    <div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Meeting Desk </h3>
    </div>
    <div class="row">
        <div class="col-md-8 grid-margin stretch-card mx-auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-primary">Update Emergency Meeting Link</h4>
                    <p class="card-description"> স্টুডেন্টদের সহায়তার জন্য আপনার গুগল মিট লিঙ্কটি এখানে দিন। </p>
                    
                    <form action="{{ route('meeting.update') }}" method="POST" class="forms-sample">
                        @csrf
                        <input type="hidden" name="id" value="{{ Auth::guard('subadmin')->user()->id }}">

                        <div class="form-group">
                            <label for="meet_link">Google Meet Link</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-gradient-primary text-white">
                                        <i class="mdi mdi-link-variant"></i>
                                    </span>
                                </div>
                                <input type="url" name="meet_link" class="form-control" id="meet_link" 
                                       placeholder="https://meet.google.com/xxx-xxxx-xxx" 
                                       value="{{ Auth::guard('subadmin')->user()->helpline->meet_link ?? '' }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Current Availability Status</label>
                            <select name="is_online" class="form-control border-primary text-black">
                                <option value="1" {{ (Auth::guard('subadmin')->user()->helpline->is_online == 1) ? 'selected' : '' }}>🟢 I am Online (Live Now)</option>
                                <option value="0" {{ (Auth::guard('subadmin')->user()->helpline->is_online == 0) ? 'selected' : '' }}>🔴 I am Offline</option>
                            </select>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-gradient-primary me-2">Update Link</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection