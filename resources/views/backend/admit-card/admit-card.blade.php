@extends('backend.master')
@section('content')
    <div class="container">
        <a href="{{url('/admin/admit-card/create')}}" class="btn btn-primary">Generate Admit Card</a>
    </div>
    <div class="container mt-4">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Admit Card List</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Admit Card List</li>
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
                    <th>Student Name</th>
                    <th>Student ID</th>
                    <th>Image</th>
                    <th>Course</th>
                    <th>Exam</th>
                    <th>Exam Date</th>
                    <th>Seat-No</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
               @foreach ($admitcard as $admit)
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$admit->student->name}}</td>
                    <td>{{$admit->student->id}}</td>
                    <td>
                        <img src="{{asset('backend/images/students/'.$admit->student->image) }}" alt="">
                    </td>
                    <td>{{$admit->course}}</td>
                    <td>{{$admit->exam}}</td>
                    <td>{{$admit->exam_date}}</td>
                    <td>{{$admit->seat_no}}</td>
                    <td>
                        <a href="{{url('/admin/admit-card/edit/'.$admit->id)}}" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen"></i></a>
                        <a href="{{url('/admin/admit-card/delete/'.$admit->id)}}" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></a>
                        <a href="{{url('/admin/admit-card/print-admit/'.$admit->id)}}" class="btn btn-sm btn-info"><i class="fa-solid fa-print"></i></a>
                    </td>
                </tr>
               @endforeach
            </tbody>
        </table>
        <div class="">
            <center>Admit Card for Students</center>
        </div>
    </div>
@endsection
