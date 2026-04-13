@extends('backend.team-leader-panel.tl-master')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Assign Students to: <span class="text-primary">{{ $trainer->name }}</span> </h3>
        <a href="{{ route('team_leader.trainers.list') }}" class="btn btn-light btn-sm">Back to List</a>
    </div>

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="bg-light text-dark">
                                <tr>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>Current Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                <tr>
                                    <td>#{{ $student->id }}</td>
                                    <td class="font-weight-bold">{{ $student->name }}</td>
                                    <td>
                                        @if($student->trainer_id == $trainer->id)
                                            <span class="badge badge-success">Assigned to this Trainer</span>
                                        @elseif($student->trainer_id)
                                            <span class="badge badge-warning">Under Another Trainer</span>
                                        @else
                                            <span class="badge badge-secondary">Not Assigned</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($student->trainer_id == $trainer->id)
                                            <button class="btn btn-sm btn-outline-secondary" disabled>Already Assigned</button>
                                        @else
                                            <form action="{{ route('team_leader.trainers.assignProcess') }}" method="POST" 
                                                  {{-- এখানে লজিক: যদি স্টুডেন্টের ট্রেইনার আইডি থাকে, তবে কনফার্মেশন চাবে --}}
                                                  @if($student->trainer_id) 
                                                    onsubmit="return confirm('Attention! This student is already assigned to another trainer. Do you want to re-assign to {{ $trainer->name }}?');" 
                                                  @endif>
                                                
                                                @csrf
                                                <input type="hidden" name="trainer_id" value="{{ $trainer->id }}">
                                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                
                                                <button type="submit" class="btn btn-sm btn-gradient-primary">
                                                    Assign Now
                                                </button>
                                            </form>
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