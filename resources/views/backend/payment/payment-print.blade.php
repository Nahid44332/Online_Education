<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .receipt-card {
            max-width: 700px;
            margin: 0 auto;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            background-color: #fff;
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
        table th {
            background-color: #198754 !important;
            color: white !important;
            text-align: left;
            width: 40%;
        }
        
        /* Print layout adjustments */
        @media print {
            .btn-container {
                display: none;
            }
            body {
                background-color: #fff;
                padding: 0;
            }
            .receipt-card {
                box-shadow: none;
                border: none;
            }
        }
    </style>
</head>
<body>

    <div class="receipt-card" id="invoice-card">
        <div class="header">
            <h1>Lina Digital E-Learning Platfrom</h1>
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
                <td><strong>{{ number_format($payment->amount, 2) }} BDT</strong></td>
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

        <div class="text-center mt-4 btn-container">
    <a href="javascript:history.back()" class="btn btn-secondary px-4 me-2">
        <i class="fa fa-arrow-left"></i> Back
    </a>

    <button id="downloadPdf" class="btn btn-success px-4">
        <i class="fa fa-download"></i> Download PDF
    </button>
</div>
    </div>

    <script>
        document.getElementById('downloadPdf').addEventListener('click', function () {
            // ১. যে অংশটি PDF হবে সেটি সিলেক্ট করা
            const element = document.getElementById('invoice-card'); 
            
            // ২. ডাউনলোড করার সময় বাটনটি সাময়িকভাবে হাইড করা
            const btnContainer = document.querySelector('.btn-container');
            btnContainer.style.display = 'none';

            // ৩. PDF এর কনফিগারেশন সেট করা
            const opt = {
                margin:       [10, 10],
                filename:     'Receipt_{{ $payment->student->id }}_{{ date("d-m-Y") }}.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            // ৪. PDF জেনারেট এবং সেভ করা
            html2pdf().set(opt).from(element).save().then(() => {
                // ৫. ডাউনলোড শেষ হলে বাটনটি আবার ফিরিয়ে আনা
                btnContainer.style.display = 'block';
            }).catch(err => {
                console.error('PDF Error:', err);
                btnContainer.style.display = 'block';
            });
        });
    </script>

</body>
</html>