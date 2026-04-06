@extends('backend.master')

@section('content')
    <div class="container mt-5">
        <h3 class="mb-4">Payment Overview</h3>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-success text-center">
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Student Name</th>
                            <th scope="col">Student ID</th>
                            <th scope="col">Total Admission Fee</th>
                            <th scope="col">Paid Payment</th>
                            <th scope="col">Payment Date</th>
                            <th scope="col">Note</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($payments as $payment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $payment->student->name }}</td>
                                <td>{{ $payment->student->id }}</td>
                                <td>{{ $payment->course ? $payment->course->course_fee : 'N/A' }}</td>
                                <td>{{ $payment->amount }}</td>
                                <td>{{ $payment->created_at->format('d M Y') }}</td>
                                <td>{{ $payment->note }}</td>
                                <td class="d-flex justify-content-center gap-2">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-info viewPaymentsBtn"
                                        data-student-id="{{ $payment->student->id }}">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ url('/admin/payment/download/' . $payment->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-download"></i>
                                    </a>
                                    <a href="{{ url('/payment/delete/' . $payment->id) }}" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this payment?');">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Payment View Modal -->
                <div class="modal fade" id="paymentViewModal" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title">Student Payment History</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <h6 id="studentName"></h6>

                                <table class="table table-bordered mt-3">
                                    <thead class="table-light">
                                        <tr>
                                            <th>SL</th>
                                            <th>Course</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="paymentTableBody">
                                        <!-- AJAX DATA -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
   <script>
document.addEventListener('DOMContentLoaded', function () {
    // সরাসরি document এ লিসেনার দিলে ডাইনামিক বাটনও কাজ করবে
    document.addEventListener('click', function (event) {
        // চেক করুন ক্লিক করা এলিমেন্টটি viewPaymentsBtn কি না (বা তার ভেতরের আইকন কি না)
        const button = event.target.closest('.viewPaymentsBtn');

        if (button) {
            let studentId = button.dataset.studentId;

            // ডাটা লোড হওয়ার সময় বাটনটি একটু ডিজেবল করে রাখা ভালো (ঐচ্ছিক)
            fetch("{{ url('admin/student/payments') }}/" + studentId)
                .then(res => {
                    if (!res.ok) throw new Error("Data not found");
                    return res.json();
                })
                .then(data => {
                    document.getElementById('studentName').innerText = 
                        `Student: ${data.name} (ID: ${data.id})`;

                    let rows = '';
                    if (data.payments && data.payments.length > 0) {
                        data.payments.forEach((payment, index) => {
                            rows += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${payment.course?.title ?? 'N/A'}</td>
                                    <td>${payment.amount}</td>
                                    <td>${new Date(payment.created_at).toLocaleDateString()}</td>
                                </tr>`;
                        });
                    } else {
                        rows = '<tr><td colspan="4">No payments found.</td></tr>';
                    }

                    document.getElementById('paymentTableBody').innerHTML = rows;

                    // বুটস্ট্র্যাপ মডাল ওপেন করা
                    let modalElement = document.getElementById('paymentViewModal');
                    let modal = bootstrap.Modal.getOrCreateInstance(modalElement);
                    modal.show();
                })
                .catch(err => {
                    console.error(err);
                    alert("Something went wrong or student not found!");
                });
        }
    });
});
</script>
@endpush
