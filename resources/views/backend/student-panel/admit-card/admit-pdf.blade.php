<!DOCTYPE html>
<html>
<head>
    <title>Admit Card PDF</title>
    <style>
        .admit-box { border: 2px solid #000; padding: 30px; text-align: center; }
        .footer-table { width: 100%; margin-top: 50px; }
        .text-left { text-align: left; }
    </style>
</head>
<body>
    <div class="admit-box">
        <h2>Lina Digital E-learning Platfrom</h2>
        <p>Kumun, Gazipur Sadar, Gazipur</p>
        <hr>
        <h3>EXAMINATION ADMIT CARD</h3>
        
        <div class="text-left" style="margin-top: 20px;">
            <p><strong>Student Name:</strong> {{ $admitCard->student->name }}</p>
            <p><strong>Student ID:</strong> {{ $admitCard->student->id }}</p>
            <p><strong>Course:</strong> {{ $admitCard->course }}</p>
            <p><strong>Exam Name:</strong> {{ $admitCard->exam }}</p>
            <p><strong>Exam Date:</strong> {{ \Carbon\Carbon::parse($admitCard->exam_date)->format('d M, Y') }}</p>
            <p><strong>Seat No:</strong> {{ $admitCard->seat_no ?? 'N/A' }}</p>
        </div>

        <table class="footer-table">
            <tr>
                <td style="text-align: left;">
                    <p>_________________</p>
                    <p>Student Signature</p>
                </td>
                <td style="text-align: right;">
                    <p>_________________</p>
                    <p>Director Signature</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>