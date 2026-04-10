<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admit Card - {{ $admitCard->student->name }}</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .admit-card-container {
            width: 100%;
            padding: 20px;
        }
        .admit-card {
            border: 3px solid #333;
            padding: 15px;
            position: relative;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .school-name {
            font-size: 24px;
            font-weight: bold;
            color: #1a73e8;
            margin: 0;
            text-transform: uppercase;
        }
        .address {
            font-size: 13px;
            margin: 5px 0;
        }
        .exam-title {
            background: #333;
            color: #fff;
            padding: 5px 15px;
            display: inline-block;
            margin-top: 10px;
            border-radius: 5px;
            font-size: 18px;
        }
        .info-table {
            width: 100%;
            margin-top: 20px;
        }
        .info-table td {
            padding: 8px 0;
            font-size: 15px;
            vertical-align: top;
        }
        .student-photo {
            width: 100px;
            height: 110px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .footer-table {
            width: 100%;
            margin-top: 60px;
        }
        .signature-box {
            width: 40%;
            text-align: center;
            font-size: 14px;
        }
        .signature-line {
            border-top: 1px solid #333;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="admit-card-container">
        <div class="admit-card">
            <table class="header-table">
                <tr>
                    <td width="80%">
                        <h1 class="school-name">Lina Digital E-Learning Platform</h1>
                        <p class="address">Kumun, Gazipur Sadar, Gazipur <br> Mobile: 019XXXXXXXX</p>
                    </td>
                    <td width="20%" style="text-align: right;">
                        @if($admitCard->student->image)
                            <img src="{{ public_path('backend/images/students/'.$admitCard->student->image) }}" class="student-photo">
                        @endif
                    </td>
                </tr>
            </table>

            <div style="text-align: center;">
                <div class="exam-title">ADMIT CARD</div>
            </div>

            <table class="info-table">
                <tr>
                    <td width="25%"><strong>Student Name</strong></td>
                    <td width="5%">:</td>
                    <td width="70%">{{ $admitCard->student->name }}</td>
                </tr>
                <tr>
                    <td><strong>Student ID</strong></td>
                    <td>:</td>
                    <td>{{ $admitCard->student->id }}</td>
                </tr>
                <tr>
                    <td><strong>Course Name</strong></td>
                    <td>:</td>
                    <td>{{ $admitCard->course }}</td>
                </tr>
                <tr>
                    <td><strong>Examination</strong></td>
                    <td>:</td>
                    <td>{{ $admitCard->exam }}</td>
                </tr>
                <tr>
                    <td><strong>Exam Date</strong></td>
                    <td>:</td>
                    <td>{{ \Carbon\Carbon::parse($admitCard->exam_date)->format('d F, Y') }}</td>
                </tr>
                <tr>
                    <td><strong>Seat Number</strong></td>
                    <td>:</td>
                    <td>{{ $admitCard->seat_no ?? 'N/A' }}</td>
                </tr>
            </table>

            <table class="footer-table">
                <tr>
                    <td class="signature-box">
                        <div class="signature-line">Student Signature</div>
                    </td>
                    <td width="20%"></td> <td class="signature-box">
                        <div class="signature-line">Director Signature</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>