@extends('backend.student-panel.st-master')

@section('content')

<div class="content-wrapper">

```
<div class="row">
    <!-- Total Points -->
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h4 class="card-title">Total Points</h4>
                <h2>{{ $student->points }}</h2>
            </div>
        </div>
    </div>

    <!-- Total Referrals -->
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h4 class="card-title">Total Referrals</h4>
                <h2>{{ $totalReferrals }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Referral History Table -->
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Referral History</h4>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Student ID</th>
                                <th>Earned Money</th>
                                <th>Date</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($histories as $history)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $history->referredStudent->name ?? 'N/A' }}</td>
                                <td>{{ $history->referred_student_id }}</td>
                                <td class="text-success">
                                    +{{ $history->points }}
                                </td>
                                <td>{{ $history->created_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-danger">
                                    No Referral History Found
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
```

</div>
@endsection
