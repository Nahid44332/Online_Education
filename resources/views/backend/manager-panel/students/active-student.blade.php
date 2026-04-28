@extends('backend.manager-panel.master')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Active Students List </h3>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card border-top border-success"> <div class="card-body">
                        <h4 class="card-title text-success">Currently Active Students</h4>
                        <p class="card-description"> Showing only students with active status </p>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th> ID </th>
                                        <th> Photo </th>
                                        <th> Name </th>
                                        <th> Course </th>
                                        <th> Points </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr>
                                            <td> #ST-{{ $student->id }} </td>
                                            <td class="py-1">
                                                <img src="{{ asset('backend/images/students/' . $student->image) }}"
                                                    alt="image" style="width: 40px; height: 40px; border-radius: 8px;" />
                                            </td>
                                            <td>
                                                <span class="font-weight-bold">{{ $student->name }}</span><br>
                                                <small class="text-muted">{{ $student->phone }}</small>
                                            </td>
                                            <td> {{ $student->course->title ?? 'N/A' }} </td>
                                            <td>
                                                <span class="badge badge-gradient-success">{{ $student->points }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection