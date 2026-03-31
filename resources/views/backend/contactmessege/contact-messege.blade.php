@extends('backend.master')
@section('content')
<div class="container mt-4">
     <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Contact Messege</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact Messege</li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    <table class="table table-bordered table-striped">
        <thead class="table-success">
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Messege</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
          @foreach ($contacts as $contact)
            <tr>
                <td>{{$loop->index+1}}</td>
                <td>{{$contact->name}}</td>
                <td>{{$contact->phone}}</td>
                <td>{{$contact->email}}</td>
                <td>{{$contact->message}}</td>
                <td>
                    <a href="{{url('/admin/contact-us/delete/'.$contact->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure delete Contact?')"><i class="fa-solid fa-trash"></i></a>                
                </td>
            </tr>
          @endforeach
        </tbody>
    </table>
    <div class="">
        <center>Contact Messege</center>
    </div>
</div>
@endsection