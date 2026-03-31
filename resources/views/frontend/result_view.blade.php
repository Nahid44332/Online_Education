@extends('frontend.master')
@section('content')
 <!--====== PAGE BANNER PART START ======-->
    
    <section id="page-banner" class="pt-105 pb-110 bg_cover" data-overlay="8" style="background-image: url({{asset('frontend/images/page-banner-3.jpg')}})">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-banner-cont">
                        <h2>Result of {{$result->student->name}}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Result of {{$result->student->name}}</li>
                            </ol>
                        </nav>
                    </div>  <!-- page banner cont -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>
    
    <!--====== PAGE BANNER PART ENDS ======-->
<style>
/* General card layout */
.result-card {
    max-width: 800px;
    margin: 50px auto;
    padding: 30px 40px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    font-family: 'Arial', sans-serif;
    color: #333;
}

/* Header info */
.result-header {
    text-align: center;
    margin-bottom: 30px;
}
.result-header h2 {
    font-weight: 700;
    margin-bottom: 5px;
}
.result-header p {
    margin: 0;
    font-size: 14px;
}

/* Student Photo */
.student-photo {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #ddd;
    display: block;
    margin: 0 auto 15px auto;
}

/* Table styling */
.result-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}
.result-table th, .result-table td {
    padding: 12px 15px;
    border: 1px solid #ddd;
}
.result-table th {
    background-color: #f2f2f2;
    text-align: left;
}
.result-table td {
    font-weight: 500;
}

/* Status colors */
.status-pass {
    color: #28a745;
    font-weight: 700;
}
.status-fail {
    color: #dc3545;
    font-weight: 700;
}

/* Print button */
.btn-print {
    display: block;
    margin: 20px auto 0 auto;
    padding: 10px 20px;
    font-weight: 600;
}

/* Print-specific styling */
@media print {
    body * {
        visibility: hidden;
    }
    .result-card, .result-card * {
        visibility: visible;
    }
    .result-card {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        margin: 0;
        box-shadow: none;
        border-radius: 0;
    }
    .btn-print {
        display: none;
    }
}
</style>

<div class="result-card">

    <!-- Header -->
    <div class="result-header">
        <h2>Nahid Computer Training Center</h2>
        <p>Phone: 01968-400331</p>
        <p>Address: Kumun, Gazipur Sadar, Gazipur</p>
        <hr style="margin-top:15px; border-top:2px solid #333;">
    </div>

    <!-- Student Photo -->
    <img src="{{asset('backend/images/students/'.$result->student->image)}}" alt="Student Photo" class="student-photo">

    <!-- Student Result -->
    <h4 class="text-center mb-3">Result of {{ $result->student->name }}</h4>

    <table class="result-table">
        <tr>
            <th>Student ID</th>
            <td>{{ $result->student->id }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $result->student->name }}</td>
        </tr>
        <tr>
            <th>Total Marks</th>
            <td>{{ $result->total_marks }}</td>
        </tr>
        <tr>
            <th>Marks Obtained</th>
            <td>{{ $result->marks_obtained }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                @if ($result->status == 'Pass')
                    <span class="status-pass">{{ $result->status }}</span>
                @else
                    <span class="status-fail">{{ $result->status }}</span>
                @endif
            </td>
        </tr>
        <tr>
            <th>Grade</th>
            <td>{{ $result->grade }}</td>
        </tr>
    </table>

    <button onclick="window.print()" class="btn btn-primary btn-print">Print Result</button>
</div>

@endsection
