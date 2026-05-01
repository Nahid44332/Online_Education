@extends('backend.master')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Add Payment for Nahid Hossen</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('admin/payments/store/' . $student_id) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="amount" name="amount"
                                    placeholder="Enter payment amount" required>
                            </div>

                            <div class="mb-3">
                                <label for="payment_method" class="form-label">Payment Method<span
                                        class="text-danger">*</span></label>
                                <select class="form-select form-control" id="payment_method" name="method" required>
                                    <option value="" selected disabled>Select a payment method</option>
                                    <option value="bkash">bKash</option>
                                    <option value="nagad">Nagad</option>
                                    <option value="rocket">Rocket</option>
                                    <option value="bank">Bank Transfer</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="transaction_id" class="form-label">Transaction ID <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="transaction_id" name="transaction_id"
                                    placeholder="e.g. 8N7A6D5W4Q" required>
                            </div>

                            <div class="mb-3">
                                <label for="payment_date" class="form-label">Payment Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="payment_date" name="payment_date"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="note" class="form-label">Note</label>
                                <textarea class="form-control" id="note" name="note" rows="2" placeholder="Optional note"></textarea>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Save Payment</button>
                            <a href="{{ url('/admin/student/list') }}" class="btn btn-secondary w-100 mt-2">Back to
                                Students</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
