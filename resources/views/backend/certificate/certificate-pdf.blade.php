<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Certificate</title>
    <style>
        body { font-family: 'serif'; margin: 0; padding: 0; }
        .certificate-card {
            padding: 30px;
            border: 10px solid #1d3557;
            background-color: #ffffff;
            text-align: center;
            position: relative;
        }

        .logo {
            width: 100px;
            margin-bottom: 10px;
        }

        h1 { color: #1d3557; margin: 5px 0; text-transform: uppercase; }
        .divider { border-top: 2px solid #1d3557; margin: 10px 0; }
        
        .student-name {
            font-size: 30px;
            color: #457b9d;
            margin: 10px 0;
            font-style: italic;
        }

        /* ফ্লেক্সবক্সের বিকল্প হিসেবে টেবিল ব্যবহার */
        .signature-table {
            width: 100%;
            margin-top: 50px;
        }
        .signature-table td {
            width: 50%;
            text-align: center;
        }

        .btn-print { display: none; } /* PDF এ বাটন দরকার নেই */
    </style>
</head>
<body>
    <div class="certificate-card">
        @if($sitesettings->logo)
            <img src="{{ public_path('backend/images/seetings/'.$sitesettings->logo) }}" class="logo">
        @endif

        <h1>Nahid Computer Training Center</h1>
        <p>Phone: 01968-400331 | Address: Kumun, Gazipur Sadar, Gazipur</p>
        
        <div class="divider"></div>

        <p style="font-size: 20px;">Certificate of Completion</p>
        <p>This is to certify that</p>
        
        <h2 class="student-name">{{ $certificate->student->name }}</h2>
        
        <p>Student ID: <strong>{{ $certificate->student->id }}</strong></p>
        <p>Course: <strong>{{ $certificate->course->title }}</strong></p>
        <p>Grade: <strong>{{ $certificate->result->grade }}</strong></p>
        <p>Issue Date: {{ \Carbon\Carbon::parse($certificate->issue_date)->format('d/m/Y') }}</p>
        <p>Certificate No: {{ $certificate->certificate_no }}</p>

        <table class="signature-table">
            <tr>
                <td>
                    <p>__________________</p>
                    <p>Instructor</p>
                </td>
                <td>
                    <p>__________________</p>
                    <p>Director</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>