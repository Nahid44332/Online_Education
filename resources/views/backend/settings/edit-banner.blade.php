@extends('backend.master')
@section('content')
 <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Edit Banner</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Edit Banner</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row g-4">
              <!--begin::Col-->
              <div class="col-md-12">
                <!--begin::Quick Example-->
                <div class="card card-primary card-outline mb-4">
                  <!--begin::Header-->
                  <div class="card-header"><div class="card-title">Input Banner</div></div>
                  <!--end::Header-->
                  <!--begin::Form-->
                  <form action="{{url('/admin/update-banner/'.$banner->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Body-->
                    <div class="card-body">
                      <div class="input-group mb-3">
                        <input type="file" class="form-control" id="image" name="image" />
                        <label class="input-group-text" for="inputGroupFile02">Upload</label>
                      </div>
                      <img src="{{asset('backend/images/banner/'.$banner->image)}}" height="200" width="400">
                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Update</button>
                      <a href="{{url('/admin/banner-settings')}}" class="btn btn-info">Back</a>
                    </div>
                    <!--end::Footer-->
                  </form>
                  <!--end::Form-->
                </div>
                <!--end::Quick Example-->
              </div>
              <!--end::Col-->
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
@endsection