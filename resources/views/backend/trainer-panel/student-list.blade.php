@extends('backend.trainer-panel.tr-master')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> My Students List </h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body">
                        <h4 class="card-title">List of Learners</h4>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="bg-light">
                                        <th> Student ID </th>
                                        <th> Name </th>
                                        <th> Phone </th>
                                        <th> Course </th>
                                        <th> Status </th>
                                        <th> Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr>
                                            <td class="py-1">{{ $student->id }} </td>
                                            <td> {{ $student->name }} </td>
                                            <td> {{ $student->phone }} </td>
                                            <td> {{ $student->course->title ?? 'N/A' }} </td>
                                            <td>
                                                @if ($student->status == '1')
                                                    <label class="badge badge-success">Active</label>
                                                @else
                                                    <label class="badge badge-warning">Pending</label>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($student->phone)
                                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $student->phone) }}?text=Hello%20{{ $student->name }},%20I%20am%20your%20Trainer."
                                                        target="_blank"
                                                        class="btn btn-sm btn-outline-success border-2 shadow-sm"
                                                        style="border-radius: 5px; padding: 5px 8px;">
                                                        <i class="mdi mdi-whatsapp"></i>
                                                    </a>
                                                @endif
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
