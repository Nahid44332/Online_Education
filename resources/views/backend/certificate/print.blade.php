<!DOCTYPE html>
<html>
<head>
    <title>Certificate</title>
    <style>
        body { font-family: 'Times New Roman', serif; background: #f0f0f0; }
        .certificate-card {
            max-width: 900px;
            margin: 50px auto;
            padding: 50px 60px;
            border: 5px solid #1d3557;
            border-radius: 15px;
            background-color: #ffffff;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        /* Logo */
        .logo {
            width: 120px;
            height: auto;
            margin-bottom: 20px;
        }

        h1 { color: #1d3557; margin-bottom: 5px; }
        hr { border-top: 3px solid #1d3557; margin: 20px 0; }
        h2 { margin: 15px 0; }

        .btn-print {
            display: inline-block;
            margin: 30px auto 0 auto;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            background-color: #1d3557;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: background 0.3s ease;
            text-decoration: none;
        }
        .btn-print:hover {
            background-color: #457b9d;
        }

        @media print {
            .btn-print { display: none; }
            body { background: #fff; }
        }
    </style>
</head>
<body>
    <div class="certificate-card">
        <!-- Logo -->
        <img src="{{ asset('backend/images/seetings/'.$sitesettings->logo) }}" alt="Logo" class="logo">

        <h1>Nahid Computer Training Center</h1>
        <p>Phone: 01968-400331 | Address: Kumun, Gazipur Sadar, Gazipur</p>
        <hr>

        <h2>Certificate of Completion</h2>
        <p>This is to certify that</p>
        <h2>{{ $certificate->student->name }}</h2>
        <p>Student ID: <strong>{{ $certificate->student->id }}</strong></p>
        <p>Course: {{ $certificate->course->title }}</p>
        <p>Grade: {{ $certificate->result->grade }}</p>
        <p>Issue Date: {{ \Carbon\Carbon::parse($certificate->issue_date)->format('d/m/Y') }}</p>
        <p>Certificate No: {{ $certificate->certificate_no }}</p>

        <div style="display:flex; justify-content:space-between; margin-top:50px;">
            <div>
                <p>__________________</p>
                <p>Instructor</p>
            </div>
            <div>
                <p>__________________</p>
                <p>Director</p>
            </div>
        </div>

        <button onclick="window.print()" class="btn-print">Print Certificate</button>
    </div>
</body>
</html>
