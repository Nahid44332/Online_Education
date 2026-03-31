@extends('frontend.master')
@section('content')
    
    <section id="page-banner" class="pt-105 pb-110 bg_cover" data-overlay="8" style="background-image: url({{asset('frontend/images/page-banner-3.jpg')}})">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-banner-cont">
                        <h2>Student Result</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Student Result</li>
                            </ol>
                        </nav>
                    </div>  <!-- page banner cont -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>
    
    <!--====== PAGE BANNER PART ENDS ======-->
<style>
    body {
        background: #f5f7fa;
    }
    .result-card {
        max-width: 500px;
        margin: 50px auto;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        padding: 30px;
        transition: transform 0.3s ease;
    }
    .result-card:hover {
        transform: translateY(-5px);
    }
    .result-card h3 {
        font-weight: 700;
        color: #333;
        margin-bottom: 25px;
        text-align: center;
    }
    .btn-submit {
        width: 100%;
        padding: 10px;
        font-weight: 600;
        border-radius: 8px;
    }
</style>

<div class="result-card">
    <h3>Check Your Result</h3>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Oops!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{url('/student-result')}}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="student_id" class="form-label fw-bold">Enter Your Student ID</label>
            <input type="text" name="student_id" class="form-control form-control-lg" placeholder="e.g. 2023001" required>
        </div>

        <button type="submit" class="btn btn-success btn-submit">View Result</button>
    </form>

    <div class="text-center mt-4">
        <small class="text-muted">Make sure you enter your correct Student ID to view the result.</small>
    </div>
</div>

@endsection
