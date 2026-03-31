@extends('backend.master')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4">Teacher Applications</h3>

    <table class="table table-bordered table-striped">
        <thead class="table table-success">
            <tr>
                <th>SL</th>
                <th>Application ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Skill</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $key => $app)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $app->application_id ?? 'N/A' }}</td>
                    <td>{{ $app->name }}</td>
                    <td>{{ $app->email }}</td>
                    <td>{{ $app->phone }}</td>
                    <td>{{ $app->skills }}</td>
                    <td>
                        @if($app->status == 'approved')
                            <span class="badge bg-success">Approved</span>
                        @elseif($app->status == 'rejected')
                            <span class="badge bg-danger">Rejected</span>
                        @else
                            <span class="badge bg-warning">Pending</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ url('teacher-applications/'.$app->id.'/approve')}}" class="btn btn-success btn-sm"><span class="mdi mdi-check"></span></a>
                        <a href="{{ url('teacher-applications/'.$app->id.'/reject')}}" class="btn btn-danger btn-sm"><span class="mdi mdi-close-thick"></span></a>
                        <a href="{{ url('teacher-applications/show/'.$app->id )}}" class="btn btn-info btn-sm"><span class="mdi mdi-eye"></span></a>
                        <a href="{{ url('/teacher-applications/delete/'.$app->id )}}" class="btn btn-danger btn-sm"><span class="mdi mdi-delete"></span></a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">No Teacher Applications Found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
