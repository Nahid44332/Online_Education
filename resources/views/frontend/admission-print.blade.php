<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application Copy</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 40px;
            background: #f9f9f9;
        }
        .container {
            width: 900px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.08);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .header h2 {
            margin: 0;
            text-transform: uppercase;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        table, th, td {
            border: 1px solid #bbb;
        }
        th {
            background: #f0f0f0;
            text-align: left;
            width: 30%;
            padding: 10px;
            font-weight: 600;
        }
        td {
            padding: 10px;
        }
        .photo {
            text-align: center;
        }
        .photo img {
            width: 120px;
            height: 140px;
            object-fit: cover;
            border: 2px solid #4CAF50;
            border-radius: 4px;
        }
        h3 {
            margin: 15px 0;
            color: #444;
            border-left: 4px solid #4CAF50;
            padding-left: 8px;
            font-size: 18px;
        }
        .btn-print {
            display: block;
            width: 220px;
            margin: 30px auto 0;
            padding: 12px 20px;
            background: #4CAF50;
            color: #fff;
            text-align: center;
            font-size: 16px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            border-radius: 6px;
            transition: 0.3s;
        }
        .btn-print:hover {
            background: #388e3c;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 13px;
            color: #777;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Header -->
    <div class="header">
        <h2>Student Application Copy</h2>
        <p>Online Admission System</p>
    </div>

    <!-- Student Information -->
    <h3>Personal Information</h3>
    <table>
        <tr>
            <th>Name</th>
            <td>{{ $student->name }}</td>
            <th rowspan="6" class="photo">
                @if($student->image)
                    <img src="{{ asset('backend/images/students/'.$student->image) }}" alt="Student Photo">
                @else
                    <span>No Photo</span>
                @endif
            </th>
        </tr>
        <tr>
            <th>Student ID</th>
            <td>{{ $student->id }}</td>
        </tr>
        <tr>
            <th>Father's Name</th>
            <td>{{ $student->father_name }}</td>
        </tr>
        <tr>
            <th>Mother's Name</th>
            <td>{{ $student->mother_name }}</td>
        </tr>
        <tr>
            <th>Date of Birth</th>
            <td>{{ $student->dob }}</td>
        </tr>
        <tr>
            <th>Gender</th>
            <td>{{ ucfirst($student->gender) }}</td>
        </tr>
        <tr>
            <th>Religion</th>
            <td colspan="2">{{ $student->religion }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td colspan="2">{{ $student->email }}</td>
        </tr>
        <tr>
            <th>Phone</th>
            <td colspan="2">{{ $student->phone }}</td>
        </tr>
        <tr>
            <th>Blood Group</th>
            <td colspan="2">{{ $student->blood }}</td>
        </tr>
        <tr>
            <th>Nationality</th>
            <td colspan="2">{{ $student->nationality }}</td>
        </tr>
        <tr>
            <th>Course</th>
            <td colspan="2">{{ $student->course->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Present Address</th>
            <td colspan="2">{{ $student->present_address }}</td>
        </tr>
        <tr>
            <th>Permanent Address</th>
            <td colspan="2">{{ $student->permanent_address }}</td>
        </tr>
    </table>

    <!-- Education Information -->
    <h3>Educational Qualification</h3>
    <table>
        <tr>
            <th>SSC Passing Year</th>
            <td>{{ optional($student->education)->ssc_passing_year ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>SSC Board</th>
            <td>{{ optional($student->education)->ssc_board ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>SSC Result</th>
            <td>{{ optional($student->education)->ssc_result ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>HSC Passing Year</th>
            <td>{{ optional($student->education)->hsc_passing_year ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>HSC Board</th>
            <td>{{ optional($student->education)->hsc_board ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>HSC Result</th>
            <td>{{ optional($student->education)->hsc_result ?? 'N/A' }}</td>
        </tr>
    </table>

    <!-- Print Button -->
    <button class="btn-print" onclick="window.print()">🖨️ Print Application</button>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; {{ date('Y') }} Online Admission System | All rights reserved.</p>
    </div>
</div>
</body>
</html>
