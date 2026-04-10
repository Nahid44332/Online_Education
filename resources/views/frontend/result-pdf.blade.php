<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Official Result - {{ $result->student->name }}</title>
    <style>
        /* PDF এর জন্য মার্জিন এবং সাইজ ফিক্স */
        @page { 
            margin: 0.5cm; 
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        .container {
            border: 8px solid #2c3e50;
            padding: 5px;
        }
        .inner-border {
            border: 2px solid #34495e;
            padding: 20px;
            position: relative;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #1a2a6c;
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }
        .header p {
            margin: 2px 0;
            font-size: 12px;
        }
        .title {
            text-align: center;
            background: #2c3e50;
            color: #fff;
            padding: 8px;
            font-size: 18px;
            margin-bottom: 20px;
        }
        /* টেবিল লেআউট ফিক্স */
        .info-table, .result-table {
            width: 100%;
            border-collapse: collapse;
        }
        .student-photo {
            width: 100px;
            height: 100px;
            border: 1px solid #2c3e50;
        }
        .result-table th, .result-table td {
            border: 1px solid #bdc3c7;
            padding: 10px;
            text-align: left;
        }
        .result-table th {
            background-color: #ecf0f1;
            width: 40%;
        }
        .status-pass { color: #27ae60; font-weight: bold; }
        .status-fail { color: #c0392b; font-weight: bold; }
        
        .footer {
            margin-top: 30px;
        }
        .sig-box {
            text-align: center;
            width: 200px;
        }
        .sig-line {
            border-top: 2px solid #2c3e50;
            padding-top: 5px;
            font-weight: bold;
            font-size: 12px;
        }
        .watermark {
            position: absolute;
            top: 40%;
            left: 25%;
            font-size: 60px;
            color: rgba(0,0,0,0.03);
            transform: rotate(-45deg);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="inner-border">
            <div class="watermark">LINA DIGITAL</div>

            <div class="header">
                <h1>Lina Digital E-learning Platform</h1>
                <p>High-Quality IT Training & Digital Skills</p>
                <p>Phone: 01968-400331 | Email: info@linadigital.com</p>
            </div>

            <div class="title">ACADEMIC TRANSCRIPT / RESULT</div>

            <table class="info-table" style="margin-bottom: 20px;">
                <tr>
                    <td style="vertical-align: top;">
                        <p><strong>Student ID:</strong> {{ $result->student->id }}</p>
                        <p><strong>Issue Date:</strong> {{ date('d M, Y') }}</p>
                    </td>
                    <td style="text-align: right;">
                        @if($result->student->image)
                            <img src="{{ public_path('backend/images/students/' . $result->student->image) }}" class="student-photo">
                        @endif
                    </td>
                </tr>
            </table>

            <table class="result-table">
                <tr>
                    <th>Student Name</th>
                    <td>{{ $result->student->name }}</td>
                </tr>
                <tr>
                    <th>Father's Name</th>
                    <td>{{ $result->student->father_name }}</td>
                </tr>
                <tr>
                    <th>Course Title</th>
                    <td>{{ $result->student->course->title }}</td>
                </tr>
                <tr>
                    <th>Total Marks</th>
                    <td>{{ $result->total_marks ?? '100' }}</td>
                </tr>
                <tr>
                    <th>Marks Obtained</th>
                    <td>{{ $result->marks_obtained }}</td>
                </tr>
                <tr>
                    <th>Grade / Percentage</th>
                    <td>{{ $result->grade ?? 'A+' }}</td>
                </tr>
                <tr>
                    <th>Result Status</th>
                    <td>
                        <span class="{{ strtolower($result->status) == 'pass' ? 'status-pass' : 'status-fail' }}">
                            {{ strtoupper($result->status) }}
                        </span>
                    </td>
                </tr>
            </table>

            <div class="footer">
                <table style="width: 100%;">
                    <tr>
                        <td class="sig-box">
                            <div style="height: 50px;"></div>
                            <div class="sig-line">Student Signature</div>
                        </td>
                        <td></td>
                        <td class="sig-box">
                            <div style="height: 50px;">
                                @php
                                    $sigPath = public_path('backend/images/signature.png');
                                @endphp
                                @if(file_exists($sigPath))
                                    <img src="{{ $sigPath }}" style="width: 80px;">
                                @endif
                            </div>
                            <div class="sig-line">Authorized Signature</div>
                        </td>
                    </tr>
                </table>
            </div>

            <p style="text-align: center; margin-top: 30px; font-size: 9px; color: #7f8c8d;">
                This is a computer-generated document. For verification, visit www.linadigital.com/verify
            </p>
        </div>
    </div>
</body>
</html>