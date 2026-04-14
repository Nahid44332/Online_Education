@extends('backend.master')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-dark">Result Management</h3>
        <a href="{{ url('/admin/student/result-create') }}" class="btn btn-primary shadow-sm">
            <i class="fa-solid fa-plus-circle me-1"></i> Create Student Result
        </a>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-header bg-success text-white py-3" style="border-radius: 12px 12px 0 0;">
            <h5 class="mb-0 fw-bold"><i class="fa-solid fa-file-invoice me-2"></i> Student Result Sheet</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-center">
                        <tr>
                            <th class="text-nowrap ps-3">SL</th>
                            <th class="text-nowrap">Student Details</th>
                            <th class="text-nowrap">Image</th>
                            <th class="text-nowrap">Total Marks</th>
                            <th class="text-nowrap">Obtained</th>
                            <th class="text-nowrap">Status</th>
                            <th class="text-nowrap">Grade</th>
                            <th class="text-nowrap pe-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($results as $result)
                            <tr>
                                <td class="ps-3">{{ $loop->iteration }}</td>
                                <td class="text-start">
                                    <span class="fw-bold d-block text-dark">{{ $result->student->name ?? 'Unknown Student' }}</span>
                                    <small class="text-muted">ID: #{{ $result->student->id ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    @php
                                        $studentImg = $result->student->image ?? null;
                                    @endphp
                                    <img src="{{ $studentImg ? asset('backend/images/students/' . $studentImg) : asset('backend/images/default.png') }}" 
                                         alt="Student" 
                                         class="rounded-circle shadow-sm"
                                         style="width: 45px; height: 45px; object-fit: cover; border: 2px solid #eee;">
                                </td>
                                <td><span class="badge bg-secondary px-3">{{ $result->total_marks }}</span></td>
                                <td class="fw-bold text-dark">{{ $result->marks_obtained }}</td>
                                <td>
                                    @if ($result->status == 'Pass')
                                        <span class="badge bg-success-subtle text-success border border-success px-3">Pass</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger px-3">Fail</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-bold text-primary">{{ $result->grade ?? '-' }}</span>
                                </td>
                                <td class="pe-3 text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{url('/admin/student/resule/edit/'.$result->id)}}" 
                                           class="btn btn-outline-primary" title="Edit Result">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <a href="{{url('/admin/student/resule/delete/'.$result->id)}}" 
                                           class="btn btn-outline-danger" 
                                           onclick="return confirm('Are you sure you want to delete this result?')" 
                                           title="Delete Result">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-folder-open d-block mb-2" style="font-size: 2rem;"></i>
                                    No results found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .table-responsive { border-radius: 0 0 12px 12px; }
    .text-nowrap { white-space: nowrap; }
    .bg-success-subtle { background-color: #e1f7ec; }
    .bg-danger-subtle { background-color: #fce8e8; }
    .btn-group-sm > .btn { padding: 0.4rem 0.6rem; }
</style>
@endsection