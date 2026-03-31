@extends('backend.master')
@section('content')
<div class="container mt-4">
     <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Teachers List</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Teachers List</li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    <table class="table table-bordered table-striped">
        <thead class="table-success">
            <tr>
                <th>Teacher ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Designation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
           @foreach ($teachers as $teacher)
                <tr>
                <td>{{$loop->index+1}}</td>
                <td>
                    <a href="{{url('/admin/teacher/view/'.$teacher->id)}}"><img src="{{asset('backend/images/teachers/'.$teacher->profile_image)}}" alt="" height="200" width="200" class="rounded"></a>
                </td>
                <td>{{$teacher->name}}</td>
                <td>{{$teacher->phone}}</td>
                <td>{{$teacher->designation}}</td>
                <td>
                    <a href="{{url('/admin/teacher/view/'.$teacher->id)}}" class="btn btn-sm btn-info"><i class="fa-solid fa-user"></i></a>
                    <a href="{{url('/admin/teacher/edit/'.$teacher->id)}}" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen"></i></a>
                    <a href="{{url('/admin/teacher/delete/'.$teacher->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure delete teacher?')"><i class="fa-solid fa-trash"></i></a>                
                    <a href="{{url('/admin/teacher/assign-course/'.$teacher->id)}}" class="btn btn-sm btn-success">Assign</a>
                </td>
            </tr>
           @endforeach
        </tbody>
    </table>
    <div class="">
        <center>Teacher Team  of  Company</center>
    </div>
</div>
@endsection