@extends('backend.master')
@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="card-title">Policy Setting</h1>
            <form action="{{ url('/admin/policy-seeting/update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label>Privacy Policy</label>
                    <textarea name="privacy_policy" class="form-control" id="privacy_policy" cols="20" rows="10" required>{!!$policies->privacy_policy!!}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label>Trams & Condition</label>
                    <textarea name="trams_condition" class="form-control" id="trams_condition" cols="20" rows="10" required>{{$policies->trams_condition}}</textarea>
                </div>
                
                <div class="form-group mb-3">
                    <label>Admission Policy</label>
                    <textarea name="admission_policy" class="form-control" id="admission_policy" cols="20" rows="10" required>{{$policies->admission_policy}}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label>Payment Policy</label>
                    <textarea name="payment_policy" class="form-control" id="payment_policy" cols="20" rows="10" required>{{$policies->payment_policy}}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
 