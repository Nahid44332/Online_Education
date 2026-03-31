@extends('frontend.master')
@section('content')
    <style>
        .login-section {
            padding: 80px 0;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .login-title {
            font-weight: 600;
        }

        .login-btn {
            width: 100%;
            border-radius: 8px;
        }

        .extra-links {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
        }
    </style>

    <div class="container login-section">

        <div class="row justify-content-center">

            <div class="col-md-5">

                <div class="card login-card border-0">

                    <div class="card-body p-4">

                        <h3 class="text-center login-title mb-4">
                            🔐 Student Login
                        </h3>

                        <form action="{{ route('student.login.submit') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label>Email or Username</label>
                                <input type="text" name="email" class="form-control"
                                    placeholder="Enter Email or Username">
                            </div>

                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter Password">
                            </div>

                            <div class="extra-links mb-3">

                                <div>
                                    <input type="checkbox" name="remember"> Remember
                                </div>

                                <div>
                                    <a href="#">Forgot Password?</a>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary login-btn">
                                Login
                            </button>

                        </form>

                        <hr>

                        <div class="text-center">

                            <p class="mb-1">New Student?</p>

                            <a href="/admission" class="btn btn-outline-primary btn-sm">
                                Apply For Admission
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
