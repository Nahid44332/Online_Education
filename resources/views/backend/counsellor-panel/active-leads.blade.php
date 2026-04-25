@extends('backend.counsellor-panel.cs-master')
@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold text-success">
                <i class="mdi mdi-account-check me-2"></i>আমার একটিভ স্টুডেন্ট লিস্ট
            </h4>
            <span class="badge bg-success text-white px-3">Total: {{ $active_students->total() }}</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Student Name</th>
                            <th>Course</th>
                            <th>Phone</th>
                            <th>Activation Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($active_students as $student)
                        <tr>
                            <td class="text-muted">#{{ $student->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('backend/images/students/'.($student->image ?? 'default.png')) }}" 
                                         class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                    <div class="fw-bold">{{ $student->name }}</div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-soft-success text-success border border-success">
                                    {{ $student->course->title ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <a href="tel:{{ $student->phone }}" class="text-decoration-none text-dark">
                                    <i class="mdi mdi-phone-in-talk text-primary me-1"></i>{{ $student->phone }}
                                </a>
                            </td>
                            <td>
                                <small class="text-muted">
                                    <i class="mdi mdi-calendar-check me-1"></i>{{ $student->updated_at->format('d M, Y') }}
                                </small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="mdi mdi-account-off mdi-48px"></i><br>
                                    মামা, আপনার আন্ডারে এখনো কোনো স্টুডেন্ট একটিভ হয়নি! 🙄
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ৩. পেজিনেশন লিংক --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $active_students->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-success { background-color: #e8f9f0 !important; }
    .pagination { margin-bottom: 0; }
    .page-link { border-radius: 5px; margin: 0 2px; }
</style>
@endsection