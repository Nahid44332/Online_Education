@extends('backend.master')
@section('content')
<div class="container">
    <a href="{{url('/admin/exam/create')}}" class="btn btn-primary">Upload Exam File</a>
</div>
<div class="container mt-4">
     <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Exam Paper List</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Exam List</li>
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
                <th>Exam</th>
                <th>Exam Date</th>
                <th>Exam File</th>
                <th>Upload Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
              @foreach ($exams as $exam)
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$exam->title}}</td>
                    <td>{{$exam->exam_date}}</td>
                    <td>{{$exam->exam_file}}</td>
                    <td>{{$exam->created_at->format('d/m/y')}}</td>
                    <td>
                         <a href="{{asset('backend/file/exam/'.$exam->exam_file)}}" target="_blank" class="btn btn-primary btn-sm"><span class="mdi mdi-eye"></span></a>
                        <a href="{{asset('backend/file/exam/'.$exam->exam_file)}}" download class="btn btn-success btn-sm">
                            <span class="mdi mdi-download"></span></a>
                        <a href="{{url('/admin/exam/delete/'.$exam->id)}}" onclick="return confirm('Are you sure Delete Exam File?')" class="btn btn-danger btn-sm"><span class="mdi mdi-delete"></span></a>
                    </td>
                </tr>
              @endforeach
        </tbody>
    </table>
    <div class="">
        <center>Exam for Students</center>
    </div>
</div>
@endsection