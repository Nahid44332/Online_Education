@extends('backend.master')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold text-dark">Admit Card List</h3>
                </div>
                <div class="col-sm-6 text-sm-end mt-2 mt-sm-0">
                    <a href="{{ url('/admin/admit-card/create') }}" class="btn btn-primary btn-sm shadow-sm">
                        <i class="fa-solid fa-plus-circle me-1"></i> Generate Admit Card
                    </a>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Admit Card List</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-center">
                        <tr>
                            <th class="text-nowrap ps-3">SL</th>
                            <th class="text-nowrap">Student Details</th>
                            <th class="text-nowrap">Image</th>
                            <th class="text-nowrap">Course & Exam</th>
                            <th class="text-nowrap">Exam Date</th>
                            <th class="text-nowrap">Seat-No</th>
                            <th class="text-nowrap pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($admitcard as $admit)
                            <tr>
                                <td class="ps-3">{{ $loop->index + 1 }}</td>
                                <td class="text-start">
                                    <span class="fw-bold d-block text-dark">{{ $admit->student->name ?? 'Deleted Student' }}</span>
                                    <small class="text-muted">ID: #{{ $admit->student->id ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    @if(isset($admit->student->image))
                                        <img src="{{ asset('backend/images/students/' . $admit->student->image) }}" 
                                             alt="Student" class="rounded shadow-sm"
                                             style="width: 45px; height: 45px; object-fit: cover;">
                                    @else
                                        <i class="fa-solid fa-user-circle text-muted" style="font-size: 40px;"></i>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark d-block mb-1">{{ $admit->course }}</span>
                                    <small class="fw-bold text-primary">{{ $admit->exam }}</small>
                                </td>
                                <td class="text-nowrap">{{ $admit->exam_date }}</td>
                                <td><span class="badge badge-outline-dark">{{ $admit->seat_no }}</span></td>
                                <td class="pe-3">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ url('/admin/admit-card/edit/' . $admit->id) }}" 
                                           class="btn btn-outline-primary" title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <a href="{{ route('admin.admit-card.download', $admit->id) }}" 
                                           class="btn btn-outline-success" title="Download">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                        <a href="{{ url('/admin/admit-card/delete/' . $admit->id) }}" 
                                           class="btn btn-outline-danger" 
                                           onclick="return confirm('Are you sure you want to delete this admit card?')" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light py-2">
            <p class="text-center mb-0 small text-muted">Official Admit Card Management</p>
        </div>
    </div>
</div>

<style>
    .table-responsive {
        border-radius: 0 0 12px 12px;
    }
    .text-nowrap {
        white-space: nowrap;
    }
    .badge-outline-dark {
        border: 1px solid #343a40;
        background: transparent;
        color: #343a40;
        padding: 4px 8px;
    }
</style>
@endsection