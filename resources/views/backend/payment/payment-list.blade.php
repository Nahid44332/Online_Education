@extends('backend.master')

@section('content')
    <div class="container-fluid mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark">Payment Overview</h3>
        </div>

        <div class="card shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-body p-0">
                {{-- টেবিল রেসপনসিভ করার মেইন কন্টেইনার --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-center">
                            <tr>
                                <th class="text-nowrap ps-3">SL</th>
                                <th class="text-nowrap">Student Name</th>
                                <th class="text-nowrap">Student ID</th>
                                <th class="text-nowrap">Total Fee</th>
                                <th class="text-nowrap">Paid</th>
                                <th class="text-nowrap">Date</th>
                                <th class="text-nowrap">Note</th>
                                <th class="text-nowrap pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse ($payments as $payment)
                                <tr>
                                    <td class="ps-3">{{ $loop->iteration }}</td>
                                    {{-- স্টুডেন্ট না থাকলে এরর দিবে না --}}
                                    <td class="text-nowrap fw-bold">{{ $payment->student->name ?? 'Deleted Student' }}</td>
                                    <td><span class="badge bg-light text-dark border">#{{ $payment->student->id ?? 'N/A' }}</span></td>
                                    
                                    <td class="text-nowrap">৳{{ number_format($payment->course->course_fee ?? 0, 2) }}</td>
                                    <td class="text-success fw-bold text-nowrap">৳{{ number_format($payment->amount ?? 0, 2) }}</td>
                                    
                                    <td class="text-nowrap small">{{ $payment->created_at ? $payment->created_at->format('d M Y') : 'N/A' }}</td>
                                    <td>
                                        <small class="text-muted">{{ Str::limit($payment->note ?? '---', 20) }}</small>
                                    </td>
                                    <td class="pe-3">
                                        <div class="btn-group btn-group-sm">
                                            {{-- স্টুডেন্ট আইডি না থাকলে ভিউ বাটন ডিজেবল রাখা ভালো --}}
                                            <button class="btn btn-outline-info viewPaymentsBtn"
                                                data-student-id="{{ $payment->student->id ?? '' }}"
                                                {{ !isset($payment->student->id) ? 'disabled' : '' }}
                                                title="View History">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                            
                                            <a href="{{ url('/admin/payment/download/' . $payment->id) }}" 
                                               class="btn btn-outline-primary" title="Download Invoice">
                                                <i class="fa-solid fa-download"></i>
                                            </a>
                                            
                                            <a href="{{ url('/payment/delete/' . $payment->id) }}" 
                                               class="btn btn-outline-danger"
                                               onclick="return confirm('Are you sure?');" title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">No Payment Records Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Payment View Modal --}}
    <div class="modal fade" id="paymentViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                <div class="modal-header bg-success text-white" style="border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-history me-2"></i> Payment History</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <h6 id="studentName" class="mb-3 text-primary fw-bold"></h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>SL</th>
                                    <th>Course</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="paymentTableBody" class="text-center">
                                {{-- AJAX DATA --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.addEventListener('click', function (event) {
            const button = event.target.closest('.viewPaymentsBtn');
            if (button) {
                let studentId = button.dataset.studentId;
                if(!studentId) return; // আইডি না থাকলে কাজ করবে না

                fetch("{{ url('admin/student/payments') }}/" + studentId)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('studentName').innerText = 
                            `Student: ${data.name ?? 'Unknown'} (ID: ${data.id ?? 'N/A'})`;

                        let rows = '';
                        if (data.payments && data.payments.length > 0) {
                            data.payments.forEach((payment, index) => {
                                rows += `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${payment.course?.title ?? 'N/A'}</td>
                                        <td class="fw-bold text-success">৳${parseFloat(payment.amount).toLocaleString()}</td>
                                        <td>${new Date(payment.created_at).toLocaleDateString()}</td>
                                    </tr>`;
                            });
                        } else {
                            rows = '<tr><td colspan="4">No payments found.</td></tr>';
                        }
                        document.getElementById('paymentTableBody').innerHTML = rows;

                        let modalElement = document.getElementById('paymentViewModal');
                        let modal = bootstrap.Modal.getOrCreateInstance(modalElement);
                        modal.show();
                    })
                    .catch(err => alert("Data not available for this student."));
            }
        });
    });
    </script>
@endpush

<style>
    .table-responsive { border-radius: 0 0 12px 12px; }
    .text-nowrap { white-space: nowrap; }
    .btn-group-sm > .btn { padding: 0.4rem 0.6rem; }
</style>