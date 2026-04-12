@extends('backend.master')
@section('content')
<div class="container mt-4">
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-sm-6">
                <h3 class="mb-0">Teachers List</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Teachers List</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-success text-center">
                <tr>
                    <th>SL</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Salary Points</th> 
                    <th>Designation</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teachers as $teacher)
                <tr>
                    <td class="text-center">{{$loop->index+1}}</td>
                    <td class="text-center">
                        <a href="{{url('/admin/teacher/view/'.$teacher->id)}}">
                            <img src="{{asset('backend/images/teachers/'.$teacher->profile_image)}}" 
                                 alt="" height="60" width="60" class="rounded-circle shadow-sm">
                        </a>
                    </td>
                    <td>
                        <strong>{{$teacher->name}}</strong><br>
                        <small class="text-muted">{{$teacher->phone}}</small>
                    </td>
                    
                    <td style="width: 200px;">
                        <div class="text-center mb-2">
                            <span class="badge bg-primary">Current: {{ $teacher->points ?? 0 }}</span>
                        </div>
                        <form action="{{ route('admin.add.points') }}" method="POST">
                            @csrf
                            <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                            <div class="input-group input-group-sm">
                                <input type="number" name="points" class="form-control" placeholder="Add Points" required>
                                <button class="btn btn-success" type="submit">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </form>
                    </td>

                    <td>{{$teacher->designation}}</td>
                    
                    <td class="text-center">
                        <div class="btn-group">
                            <a href="{{url('/admin/teacher/view/'.$teacher->id)}}" class="btn btn-sm btn-info" title="View"><i class="fa-solid fa-user"></i></a>
                            <a href="{{url('/admin/teacher/edit/'.$teacher->id)}}" class="btn btn-sm btn-primary" title="Edit"><i class="fa-solid fa-pen"></i></a>
                            <a href="{{url('/admin/teacher/assign-course/'.$teacher->id)}}" class="btn btn-sm btn-success" title="Assign Course"><i class="fa-solid fa-book"></i></a>
                            <a href="{{url('/admin/teacher/delete/'.$teacher->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')" title="Delete"><i class="fa-solid fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-4 text-center text-muted">
        <hr>
        <p>Teacher Team of Company</p>
    </div>
</div>
@endsection