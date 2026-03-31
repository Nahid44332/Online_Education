<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admit Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f5f5f5;
        }
        .admit-card {
            border: 3px solid #000;
            padding: 25px;
            width: 750px;
            margin: auto;
            background: #fff;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
            position: relative;
        }

        /* Watermark */
        .admit-card::before {
            content: "Nahid Computer Training Center";
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 40px;
            color: rgba(0,0,0,0.05);
            white-space: nowrap;
            z-index: 0;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }

        .admit-title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            position: relative;
            z-index: 1;
        }
        td, th {
            padding: 12px;
            border: 1px solid #000;
            font-size: 15px;
        }

        .student-photo {
            text-align: center;
        }
        .student-photo img {
            border: 1px solid #000;
            padding: 3px;
            width: 120px;
            height: 120px;
            object-fit: cover;
        }

        .footer {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            position: relative;
            z-index: 1;
        }
        .signature {
            text-align: center;
        }
        .signature-line {
            margin-top: 50px;
            border-top: 1px solid #000;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }

        .print-btn {
            margin-top: 30px;
            text-align: center;
            position: relative;
            z-index: 1;
        }
        .print-btn button {
            background: #007bff;
            color: #fff;
            font-size: 18px;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }
        .print-btn button:hover {
            background: #0056b3;
        }

        @media print {
            .print-btn {
                display: none;
            }
            body {
                background: #fff;
            }
            .admit-card {
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="admit-card">
        <!-- Header -->
        <div class="header">
            {{-- চাইলে এখানে লোগো যোগ করতে পারো --}}
            {{-- <img src="{{ asset('backend/images/logo.png') }}" width="80" alt="Logo"> --}}
            <h1>Nahid Computer Training Center</h1>
            <p>Address: Gazipur | Phone: +8801968400331</p>
        </div>

        <!-- Title -->
        <div class="admit-title">Admit Card</div>

        <!-- Student Info -->
        <table>
            <tr>
                <th>Student Name</th>
                <td>{{ $admitCard->student->name }}</td>
                <th rowspan="4" class="student-photo">
                    <img src="{{ asset('backend/images/students/'.$admitCard->student->image) }}" alt="Student Photo">
                </th>
            </tr>
            <tr>
                <th>Student ID</th>
                <td>{{ $admitCard->student->id }}</td>
            </tr>
            <tr>
                <th>Course</th>
                <td>{{ $admitCard->course }}</td>
            </tr>
            <tr>
                <th>Seat No</th>
                <td>{{ $admitCard->seat_no }}</td>
            </tr>
            <tr>
                <th>Exam</th>
                <td colspan="2">{{ $admitCard->exam }}</td>
            </tr>
            <tr>
                <th>Exam Date</th>
                <td colspan="2">{{ $admitCard->exam_date }}</td>
            </tr>
        </table>

        <!-- Footer -->
        <div class="footer">
            <div class="signature">
                <div class="signature-line"></div>
                Student Signature
            </div>
            <div class="signature">
                <div class="signature-line"></div>
                Authority Signature
            </div>
        </div>

        <!-- Print Button -->
        <div class="print-btn">
            <button onclick="window.print()">🖨️ Print</button>
        </div>
    </div>
</body>
</html>
