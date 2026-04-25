@extends('backend.counsellor-panel.cs-master')
@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="mdi mdi-shield-lock me-2 text-primary"></i>Change Password</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('counsellor.password.update') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Current Password</label>
                            <div class="input-group">
                                <input type="password" name="current_password" class="form-control" id="current_password" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="current_password">
                                    <i class="mdi mdi-eye-outline"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">New Password</label>
                            <div class="input-group">
                                <input type="password" name="new_password" class="form-control" id="new_password" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new_password">
                                    <i class="mdi mdi-eye-outline"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Confirm New Password</label>
                            <div class="input-group">
                                <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new_password_confirmation">
                                    <i class="mdi mdi-eye-outline"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update Security Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- পাসওয়ার্ড শো/হাইড করার ম্যাজিক স্ক্রিপ্ট --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.toggle-password').click(function() {
            const targetId = $(this).data('target');
            const passwordField = $('#' + targetId);
            const icon = $(this).find('i');

            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                icon.removeClass('mdi-eye-outline').addClass('mdi-eye-off-outline');
            } else {
                passwordField.attr('type', 'password');
                icon.removeClass('mdi-eye-off-outline').addClass('mdi-eye-outline');
            }
        });
    });
</script>

<style>
    .input-group .btn {
        border-color: #ced4da;
    }
    .input-group .btn:hover {
        background-color: #f8f9fa;
    }
</style>
@endsection