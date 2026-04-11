@extends('backend.master')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-account-plus"></i>
                </span> Assign Students to Team Leader
            </h3>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        <span></span>Summary <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Assigning to: <span class="text-primary">{{ $team_leader->name }}</span></h4>
                        <p class="card-description"> Showing only students who are not assigned yet. </p>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="bg-light">
                                        <th> Student Name </th>
                                        <th> Email Address </th>
                                        <th> Status </th>
                                        <th> Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($students as $student)
                                        <tr>
                                            <td class="py-1">
                                                <img src="{{ asset('backend/images/students/' . $student->image) }}"
                                                    class="me-2" alt="image">
                                                {{ $student->name }}
                                            </td>
                                            <td> {{ $student->email }} </td>
                                            <td>
                                                <label class="badge badge-gradient-warning">Unassigned</label>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.do_assign', [$team_leader->id, $student->id]) }}"
                                                    class="btn btn-gradient-success btn-sm">
                                                    Add Now
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-danger">No unassigned students found!
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
