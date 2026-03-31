<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .receipt-card {
            max-width: 700px;
            margin: 0 auto;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            color: #198754;
        }
        .header p {
            margin: 2px 0;
            font-size: 14px;
            color: #555;
        }
        table {
            width: 100%;
            margin-top: 20px;
        }
        table th, table td {
            padding: 12px;
        }
        table th {
            background-color: #198754;
            color: white;
            text-align: left;
            width: 40%;
        }
        @media print {
            body {
                margin: 0;
            }
            .receipt-card {
                box-shadow: none;
                border: none;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-card">
        <div class="header">
            <h1>Nahid Computer Training Center</h1>
            <p>Address: Kumun, Gazipur Sadar, Gazipur</p>
            <p>Phone: +8801968-400331</p>
            <h2 class="mt-3">Payment Receipt</h2>
            <small class="text-muted">Generated on: {{ date('d-m-Y H:i') }}</small>
        </div>

        <table class="table table-bordered">
            <tr>
                <th>Student Name</th>
                <td>{{ $payment->student->name }}</td>
            </tr>
            <tr>
                <th>Student ID</th>
                <td>{{ $payment->student->id }}</td>
            </tr>
            <tr>
                <th>Course</th>
                <td>{{ $payment->course ? $payment->course->title : 'N/A' }}</td>
            </tr>
            <tr>
                <th>Amount</th>
                <td>{{ number_format($payment->amount, 2) }} BDT</td>
            </tr>
            <tr>
                <th>Payment Date</th>
                <td>{{ $payment->payment_date }}</td>
            </tr>
            <tr>
                <th>Note</th>
                <td>{{ $payment->note ?? 'N/A' }}</td>
            </tr>
        </table>

        <div class="text-center mt-4">
            <button onclick="window.print()" class="btn btn-success">Print / Save as PDF</button>
        </div>
    </div>
</body>
</html>
