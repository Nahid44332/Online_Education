@extends('backend.team-leader-panel.tl-master')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-account-group"></i>
                </span> My Students List
            </h3>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">All Students Under Your Supervision</h4>
                        <p class="card-description"> You can track their information and course details here. </p>

                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr class="bg-light">
                                        <th>Student Id</th>
                                        <th> Student </th>
                                        <th> Email </th>
                                        <th> Course </th>
                                        <th> Join Date </th>
                                        <th> Status </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($students as $student)
                                        <tr>
                                            <td>{{ $student->id }}</td>
                                            <td class="py-1">
                                                <img src="{{ asset('backend/images/students/' . ($student->image ?? 'default.png')) }}"
                                                    class="me-2" alt="image">
                                                {{ $student->name }}
                                            </td>
                                            <td> {{ $student->email }} </td>
                                            <td> <label
                                                    class="badge badge-info">{{ $student->course->title ?? 'N/A' }}</label>
                                            </td>
                                            <td> {{ date('d M, Y', strtotime($student->created_at)) }} </td>
                                            <td>
                                                @if ($student->status == 1)
                                                    <label class="badge badge-success">Active</label>
                                                @else
                                                    <label class="badge badge-danger">Pending</label>
                                                @endif
                                                @if ($student->phone)
                                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $student->phone) }}?text=Hello%20{{ $student->name }},%20I%20am%20your%20Team%20Leader%20from%20Lina%20Digital."
                                                        target="_blank" class="btn btn-sm btn-gradient-success"
                                                        style="padding: 5px 10px;">
                                                        <i class="mdi mdi-whatsapp me-1"></i> WhatsApp
                                                    </a>
                                                @else
                                                    <span class="text-muted small">No Number</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted p-4">
                                                No students have been assigned to you yet.
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
